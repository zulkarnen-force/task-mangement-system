<?php

namespace App\TaskNodeFilter\Filter;

use App\Ticket;

class Priority implements \App\TaskNodeFilter\Filter\Filter
{
    public static function apply($builder, $value)
    {
        $ticketQuery = Ticket::query();
        $ticketQuery->where('priority', $value);
        $id = $ticketQuery->get(['id']);
        return $builder->whereIn('ticket_id', $id);
    }
}

?>