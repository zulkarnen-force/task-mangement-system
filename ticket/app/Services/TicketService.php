<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTicket;
use App\TaskNode;
use App\Ticket;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketService
{
 
    public static function index()
    {
        $tickets = Ticket::all();
        $test = response()->json(["success" => true, "result" => $tickets]);
        return $test;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(StoreTicket $request)
    {
        try {
            $title = $request->get('title');
            $ticket = Ticket::create(["user_id" => auth()->user()->id] + $request->all() );  
            $ticketId = $ticket->id;
         
            $root = TaskNode::root();
            $child = $root->children()->create(['title' => $title, 'ticket_id' => $ticketId]);
            
            return response()->json(['success' => true, 'result' => $ticket], 201); 
        } catch (Exception $e) {
            
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => false, 'message' => 'ticket not found'], 404);
            } else {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show($id)
    {
        try {
            $tickets = Ticket::findOrFail($id);
            return response()->json(['success' => true, 'result' => $tickets], 200); 
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => false, 'message' => 'ticket not found'], 404);
            } else {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function update(Request $request, $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->update($request->all());
            $ticket->task()->update($request->all());
            return response()->json(['success' => true, 'result' => $ticket], 200);
        } catch (Exception $e) {
            
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => false, 'message' => 'ticket not found'], 404);
            } else {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroy($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->task()->delete();
            $ticket->delete();
            return response()->json(['success' => true, 'result' => $ticket], 200);
        } catch (Exception $e) {
            
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['success' => false, 'message' => 'ticket not found'], 404);
            } else {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
            }

        }
    }
}
