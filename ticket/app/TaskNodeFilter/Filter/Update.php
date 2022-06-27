<?php

namespace App\TaskNodeFilter\Filter;

use App\Ticket;

class Update implements Filter {
    public static function apply($builder, $value) 
    {
        $ticketQuery = Ticket::query();
        $ticketQuery->whereBetween('updated_at', [$value.' 00:00:00', $value.' 23:59:59']);
        $id = $ticketQuery->get(['id']);

        return $builder->whereIn('ticket_id', $id);
    }

}

?>