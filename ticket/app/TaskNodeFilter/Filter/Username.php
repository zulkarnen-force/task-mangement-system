<?php

namespace App\TaskNodeFilter\Filter;

use App\Ticket;
use App\User;

class Username implements Filter 
{
    public static function apply($builder, $value)
    {
        $userId = User::where('username', $value)->get(['id']);
        $ticketId = Ticket::whereIn('user_id', $userId)->get(['id']);
        return $builder->whereIn('ticket_id', $ticketId);
    }
}

?>