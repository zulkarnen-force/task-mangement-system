<?php

namespace App\TaskNodeFilter\Filter;

use App\Ticket;

class Create implements Filter {
    public static function apply($builder, $value) 
    {
        $ticketQuery = Ticket::query();
        $ticketQuery->whereBetween('created_at', [$value.' 00:00:00', $value.' 23:59:59']);
        $id = $ticketQuery->get(['id']);
       
        return $builder->whereIn('ticket_id', $id);
    }

}

?>