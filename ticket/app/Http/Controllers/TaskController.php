<?php

namespace App\Http\Controllers;

use App\TaskNode;
use App\Ticket;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
        $this->middleware('auth')->except('index', 'show');
     }

    public function index()
    {
        $tasks = TaskNode::all()->toHierarchy();
        return view('tasks.index', compact("tasks"));
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

        $title = $request->input('title');

        // Save to ticket
        $ticket = Ticket::create($request->all());
        $ticket_id =  $ticket->id;
        
        $root = TaskNode::root();
        
        $child = $root->children()->create(['title' => $title, 'ticket_id' => $ticket_id]);

        return redirect('/tasks');
     
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
        //
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
        $node->delete();
        return back()->with('success', 'node deleted');
    }

}
