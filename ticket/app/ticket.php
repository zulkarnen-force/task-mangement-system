<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $table = "tickets";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'title', 'status', 'priority', 'message'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo('App\TaskNode', 'id', 'ticket_id');
    }

    
}
