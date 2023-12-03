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
        $raised_issues = DB::table('issues')->where('raised_by', Auth::user()->id)->orderBy('id','desc')->get();
        if (request()->query('type') === 'raised') {

            $issues = $raised_issues;
        } elseif (($user->can('fix-issues'))) {
            $issues = DB::table('issues')->orderBy('id','DESC')->get();
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
            'item_name'                 => 'required'
        ]);
        $raisedby = Auth::user()->username;
        $issue = new Issue();
        $issue->item_name     = $request->input('item_name');
        $issue->description = $request->input('description');
        $issue->date = \Carbon\Carbon::now();
        $issue->location = $request->input('location');
        $issue->raised_by = $raisedby;
        $issue->department = $request->input('department');
        $issue->status = 'OPEN';
        $issue->fixed_by = $request->input('fixed_by');
        $issue->action_taken = $request->input('action_taken');
        $issue->cause_of_breakdown = $request->input('cause_of_breakdown');
        $issue->engineers_comment = $request->input('engineers_comment');
        $issue->resolved_date = $request->input('resolved_date');
        $issue->save();
        $copy = Store::where('name', 'Engineers')->pluck('mail_group')->implode('');
        $email = Auth::user()->email;
        $url = route('home');
        $link = $url . '/' . 'issues' . '/' . $issue->id . '/edit';
        $details = [
            'link' => $link,
           'department' => $issue->department,
            'email' =>  $email,
            'raised_by' => $raisedby,
            'description' =>  $issue->description,
            'status' =>  $issue->status,
            'fixed_by_name' =>$issue->fixed_by,
            'item_name' =>  $issue->item_name,
            'resolved_date' =>  $issue->resolved_date,
            'engineers_comment' =>  $issue->engineers_comment,
            'copy' => $copy
        ];
        Event::dispatch(new TicketCreatedEvent($details));
        $request->session()->flash('message', 'Successfully added Issue');
        return redirect()->route('issues.index');
    }


    public function show(Issue $issue)
    {
        //
    }


    public function edit($id)
    {
        $issue = Issue::all()->find($id);
        $engineers = DB::table('users')->where('department_id',11)->get('name');

        $issue_status   = array(
            'OPEN', 'CLOSED'
        );
        $stores = Store::all();
        $users = User::all();
        return view('dashboard.issues.edit', compact('issue','engineers', 'users', 'stores', 'issue_status'));
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
        $issue->save();
        $email = User::where('username', $issue->raised_by)->pluck('email');
        $supervisor = Auth::user()->username;
        $copy = User::where('username', $issue->assigned_engineer)->pluck('email');
        $url = route('home');
        $link = $url . '/' . 'issues' . '/' . $issue->id . '/edit';
        $details = [
            'link' => $link,
            'supervisor' => $supervisor,
            'department' => $issue->department,
            'status' =>  $issue->status,
            'assigned_engineer' =>  $issue->assigned_engineer,
            'description' => $issue->description,
            'item_name' =>  $issue->item_name,
            'copy' => $copy,
            'email' => $email
        ];
        Event::dispatch(new EngineerAssignedEvent($details));
        $request->session()->flash('message', 'Engineer Assigned to Ticket!');
        return redirect()->route('issues.edit',$issue->id);


    }


    public function update(Request $request, $id)
    {

        $issue = Issue::find($id);
        $user = Auth::user();
        $issue->item_name     = $request->input('item_name');
        $issue->description = $request->input('description');
        $issue->date = $request->input('date');
        $issue->location = $request->input('location');
        $issue->raised_by = $request->input('raised_by');
        $issue->department = $request->input('department');
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
            'email' =>  $email,
            'status' =>  $issue->status,
            'fixed_by_name' => $issue->fixed_by,
            'item_name' =>  $issue->item_name,
            'resolved_date' =>  $issue->resolved_date,
            'engineers_comment' =>  $issue->engineers_comment,
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
