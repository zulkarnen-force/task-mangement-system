<?php

namespace App\Http\Controllers;

use App\TaskNodeFilter\TaskNodeFilter;
use App\TaskNode;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
        $this->middleware('auth');
     }

    public function index()
    {
        $tasks = TaskNode::all()->toHierarchy();
        $root = TaskNode::root();
        $childrens =  $root->getDescendants();

        $tickets = Ticket::get();
        return view('tasks.index', compact('tasks', 'root', 'childrens', 'tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasks = TaskNode::get();

        if (count($tasks) === 0) {
            $root = TaskNode::create(['title' => 'tasks']);
            $root->makeRoot();
        }

        $validator = $this->validate($request, [
            'message' => 'max:255'
        ]);
        

        $title = $request->input('title');
        
        $ticket = Ticket::create($request->all());
        $ticket_id =  $ticket->id;
        
        $root = TaskNode::root();
        
        $child = $root->children()->create(['title' => $title, 'ticket_id' => $ticket_id]);

        return Redirect::to('tasks')->with('success', 'task added successfully');

     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = TaskNode::findOrFail($id);
        return $task;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // TaskNode::find($id);
        $ticket = TaskNode::find($id)->ticket;
        $user = User::find($ticket->user_id);

        return view('task_edit', array('id' => $id, 'user' => $user)) ->with( compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // update
        $task = TaskNode::find($id);
      
        $validator = $this->validate($request, [
            'message' => 'max:255'
        ]);
        

        $title = $request->input('title');
        
        $ticket = $task->ticket->update($request->all());
        $task = $task->update(['title' => $title]);

        return Redirect::to('tasks')->with('success', 'tasks updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $node = TaskNode::find($id);
        Ticket::destroy($node->ticket_id);
        
        $node->delete();

        return back()->with('success', 'node deleted');
    }


    public function filter(Request $request)
    {
        $tickets = Ticket::get();
        $filtered = TaskNodeFilter::apply($request);

        $childrens = $filtered['childrens'];
        $root = $filtered['root'];

        return view('tasks.index', compact('childrens', 'root', 'tickets'));
    }

}
