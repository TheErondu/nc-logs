<?php

namespace App\Http\Controllers;

use App\Events\EngineerAssignedEvent;
use App\Models\Issue;
use Illuminate\Http\Request;
use App\Events\TicketCreatedEvent;
use App\Events\TicketUpdatedEvent;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $raised_issues = Issue::where('id', Auth::user()->id)->orderBy('id', 'desc')->get();
        if (request()->query('type') === 'raised') {

            $issues = $raised_issues;
        } elseif (($user->can('fix-issues'))) {
            $issues = Issue::where('id', '>', 0 )->orderBy('id', 'DESC')->get();
        } else
            $issues = $raised_issues;
        $users = User::all();
        return view('issues.index', compact('issues', 'raised_issues', 'users'));
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
        $issue->status = 'OPEN';
        $issue->fixed_by = $request->input('fixed_by');
        $issue->action_taken = $request->input('action_taken');
        $issue->cause_of_breakdown = $request->input('cause_of_breakdown');
        $issue->engineers_comment = $request->input('engineers_comment');
        $issue->resolved_date = $request->input('resolved_date');
        $issue->save();
        $copy = User::role('Admin')->get()->pluck('email');
        $email = Auth::user()->email;
        $url = route('home');
        $link = $url . '/' . 'issues' . '/' . $issue->id . '/edit';
        $details = [
            'link' => $link,
            'location' =>  $issue->store->name .', address: '.$issue->store->location,
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

        $issue_status = array(
            'OPEN',
            'CLOSED'
        );
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
        $url = route('home');
        $link = $url . '/' . 'issues' . '/' . $issue->id . '/edit';
        $details = [
            'link' => $link,
            'supervisor' => $supervisor->name,
            'location' =>  $issue->store->name .', address: '.$issue->store->location,
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
        $issue->raised_by = $request->input('raised_by');
        $issue->store_id = $request->input('store_id');
        if ($user->can('fix-issues')) {
            $issue->status = $request->input('status');
            $issue->fixed_by = $request->input('raised_by');
            $issue->action_taken = $request->input('action_taken');
            $issue->cause_of_breakdown = $request->input('cause_of_breakdown');
            $issue->engineers_comment = $request->input('engineers_comment');
            $issue->resolved_date = date('d-m-Y H:i:s');
            $issue->status = $request->input('status');
        }
        $issue->save();
        $email = User::where('username', 'Like', "$issue->raised_by")->pluck('email')->implode('');
        $copy = Store::where('name', 'Engineers')->pluck('mail_group')->implode('');
        $url = route('home');
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
