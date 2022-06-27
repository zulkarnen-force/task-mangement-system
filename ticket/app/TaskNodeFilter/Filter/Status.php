<?php


namespace App\TaskNodeFilter\Filter;

use App\TaskNode;
use App\Ticket;

class Status implements Filter
{
    public static function apply($builder, $value) 
    {
        $ticketQuery = Ticket::query();
        $ticketQuery->where('status', $value);
        $id = $ticketQuery->get(['id']);
        return $builder->whereIn('ticket_id', $id);
    }
}

?>