<?php

namespace App\Http\Controllers;

use App\Enums\IssueStatus;
use App\Events\EngineerAssignedEvent;
use App\Models\Issue;
use App\Services\IssueService;
use Illuminate\Http\Request;
use App\Events\TicketCreatedEvent;
use App\Events\TicketUpdatedEvent;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;


class IssueController extends Controller
{
    private $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }
    public function index()
    {
        $user = Auth::user();
        $raised_issues = $this->issueService->getRaisedIssues($user->id);

        if (request()->query('type') === 'raised') {
            $issues = $raised_issues;
        } elseif ($user->can('fix-issues')) {
            $issues = $this->issueService->getAllIssues();
        } else {
            $issues = $raised_issues;
        }

        $waitingCount = $this->issueService->getCountByStatus(IssueStatus::WAITING);
        $openCount = $this->issueService->getCountByStatus(IssueStatus::OPEN);
        $closedCount = $this->issueService->getCountByStatus(IssueStatus::CLOSED);
        $contestedCount = $this->issueService->getCountByStatus(IssueStatus::CONTESTED);

        $users = User::all();

        $stores = Store::all();

        $engineers = User::role('Engineer')->get();

        $issueStatuses = IssueStatus::cases();

        return view('issues.index', compact('issues', 'issueStatuses', 'raised_issues', 'users','stores', 'engineers','waitingCount', 'openCount', 'closedCount', 'contestedCount'));
    }


    public function create()
    {
        $stores = Store::all();
        return view('issues.create', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'equipment_name' => 'required',
            "store_id" => 'required'
        ]);
        $issue = new Issue();
        $issue->equipment_name = $request->input('equipment_name');
        $issue->fault_description = $request->input('fault_description');
        $issue->date = \Carbon\Carbon::now();
        $issue->user_id = Auth::user()->id;
        $issue->store_id = $request->input('store_id');
        $issue->status = 'WAITING';
        $issue->fixed_by = $request->input('fixed_by');
        $issue->action_taken = $request->input('action_taken');
        $issue->cause_of_breakdown = $request->input('cause_of_breakdown');
        $issue->engineers_comment = $request->input('engineers_comment');
        $issue->resolved_date = $request->input('resolved_date');
        $issue->save();
        $copy = User::role('Engineer')->get()->pluck('email');
        $email = Auth::user()->email;
        $url = route('default');
        $link = $url . '/' . 'issues' . '/' . $issue->id . '/edit';
        $details = [
            'link' => $link,
            'location' => $issue->store->name . ', address: ' . $issue->store->location,
            'email' => $email,
            'raised_by' => $issue->user->name,
            'fault_description' => $issue->fault_description,
            'status' => $issue->status,
            'fixed_by_name' => $issue->fixed_by,
            'equipment_name' => $issue->equipment_name,
            'resolved_date' => $issue->resolved_date,
            'engineers_comment' => $issue->engineers_comment,
            'copy' => $copy
        ];
        Event::dispatch(new TicketCreatedEvent($details));
        $request->session()->flash('message', 'Successfully Opened ticket!');
        return redirect()->route('issues.index');
    }


    public function show(Issue $issue)
    {
        //
    }


    public function edit($id)
    {
        $issue = Issue::all()->find($id);
        $engineers = User::role('Engineer')->get();

        $issue_status = IssueStatus::cases();
        $stores = Store::all();
        $users = User::all();
        return view('issues.edit', compact('issue', 'engineers', 'users', 'stores', 'issue_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function AssignEngineer(Request $request, $id)
    {
        $issue = Issue::find($id);
        $issue->assigned_engineer = $request->input('assigned_engineer');
        $assigned_engineer = User::find($issue->assigned_engineer);
        $issue->save();
        $email = User::where('id', $issue->user->id)->pluck('email');
        $supervisor = Auth::user();
        $copy = collect([
            $assigned_engineer->email,
            $supervisor->email,
        ]
        );
        $url = route('default');
        $link = $url . '/' . 'issues' . '/' . $issue->id . '/edit';
        $details = [
            'link' => $link,
            'supervisor' => $supervisor->name,
            'location' => $issue->store->name . ', address: ' . $issue->store->location,
            'status' => $issue->status,
            'assigned_engineer' => $assigned_engineer->name,
            'fault_description' => $issue->fault_description,
            'equipment_name' => $issue->equipment_name,
            'copy' => $copy,
            'email' => $email
        ];
        Event::dispatch(new EngineerAssignedEvent($details));
        $request->session()->flash('message', 'Engineer Assigned to Ticket!');
        return redirect()->route('issues.edit', $issue->id);


    }


    public function update(Request $request, $id)
    {

        $issue = Issue::find($id);
        $user = Auth::user();
        $issue->equipment_name = $request->input('equipment_name');
        $issue->fault_description = $request->input('fault_description');
        $issue->date = $request->input('date');
        $issue->store_id = $request->input('store_id');
        if ($user->can('fix-issues')) {
            $issue->status = $request->input('status');
            if ($issue->status == "CLOSED") {
                $issue->fixed_by = $user->name;
            }
            $issue->action_taken = $request->input('action_taken');
            $issue->cause_of_breakdown = $request->input('cause_of_breakdown');
            $issue->engineers_comment = $request->input('engineers_comment');
            $issue->resolved_date = date('d-m-Y H:i:s');
            $issue->status = $request->input('status');
        }
        $issue->save();
        $email = $issue->user->email;
        $copy = User::role('Engineer')->get()->pluck('email');
        $url = route('default');
        $link = $url . '/' . 'issues' . '/' . $issue->id . '/edit';

        // dd($link);
        $details = [
            'link' => $link,
            'email' => $email,
            'status' => $issue->status,
            'fixed_by_name' => $issue->fixed_by,
            'equipment_name' => $issue->equipment_name,
            'resolved_date' => $issue->resolved_date,
            'engineers_comment' => $issue->engineers_comment,
            'copy' => $copy
        ];
        Event::dispatch(new TicketUpdatedEvent($details));
        $request->session()->flash('message', 'Successfully Edited Issue');
        return redirect()->route('issues.index');
    }

    public function destroy($id)
    {
        $issue = Issue::find($id);
        if ($issue) {
            $issue->delete();
        }
        return redirect()->route('issues.index')->with('message', 'Successfully Deleted Issue');
    }
}
