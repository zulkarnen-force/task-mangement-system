<?php

namespace App\Services;

use App\TaskNode;
use App\Ticket;
use App\User;
use Validator;
use Exception;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class TaskService
{

    public static function create($request) : JsonResponse
    {
        
        $tasks = TaskNode::get();
        $title = $request->input('title');

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

        try {
            User::findOrFail($request->get('user_id'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                    "success" => false,
                    "message" => "user id required",
                ], 404);
        }


        if ($validator->fails())
        {
            return response()->json(['success' => 'false',"errors" => $validator->messages()], 400);
        } 
        

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


    public static function getTasks() : JsonResponse
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


    public static function getTaskById($id) : JsonResponse
    {
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


    public static function delete($id) : JsonResponse
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


    public static function update($request, $id) : JsonResponse
    {
        try {
            $title = $request->get('title');
            $task = TaskNode::findOrFail($id);
            $task->update(['title' => $title]);
            $task->ticket()->update($request->all());
            
            return response()->json(['success' => true, 'result' => $task], 200);
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
            } else if ($e instanceof QueryException) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
            } else {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
        }
    }

}


?>