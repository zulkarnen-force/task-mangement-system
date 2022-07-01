<?php

namespace App\Http\Controllers\Api;

use App\User as UserModel;

use App\Enums\PriorityEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TaskNode;
use App\TaskNodeFilter\Filter\Priority;
use App\TaskNodeFilter\Filter\Update;
use App\Ticket;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use RuntimeException;
use Symfony\Component\VarDumper\Caster\EnumStub;
use Validator;


class TaskController extends Controller
{

    public function __construct() 
    {
        $this->middleware('jwt.verify');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tasks = TaskNode::all();
            return response()->json(['success' => true, 'result' => $tasks, 'length' => count($tasks)], 200);
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(
                    ['success' => false,
                        'message' => $e->getMessage()], 400);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'class' => get_class($e)
                    ], 400);
            }
        }  
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

        $validator = Validator::make($request->all(), [
            'message' => 'required|max:255',
            'title' => 'required',
            'priority' => ['required','in:high,medium,low'],
            'status' => ['required','in:progress,waiting,done'],
            'user_id' => 'required',
        ]);

        // validator user_id 
        try {
            UserModel::findOrFail($request->get('user_id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "user not found",
                ], 400);
        }


        if ($validator->fails())
        {
            return response()->json(['success' => 'false',"errors" => $validator->messages()], Response::HTTP_BAD_REQUEST);
        } 
        

        $title = $request->input('title');
        
        $ticket = Ticket::create($request->all());
        $ticket_id =  $ticket->id;
        
        $root = TaskNode::root();
        $child = $root->children()->create(['title' => $title, 'ticket_id' => $ticket_id]);
   

        return response()->json([
            'success' => true,
            'message' => 'task added successfully',
            'result' => $child,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            $task = TaskNode::findOrFail($id);
            return response()->json([
                'success'=> true,
                'result' => $task,
            ], 200);
            
        } catch (Exception $err) {
            return response()->json(['success'=> false, 'message' => $err->getMessage()], 404);
        }
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
        try {
            $title = $request->get('title');
            $task = TaskNode::findOrFail($id);
            $task->update(['title' => $title]);
            $task->ticket()->update($request->all());
            
            return response()->json(['success' => true, 'result' => $task], 200);
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
            } else {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $task = TaskNode::findOrFail($id);
            $task->delete();
            return response()->json([
                'success' => true,
                'result' => $task
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'message' => $err->getMessage()
            ], 404);
        }
        
    }
}
