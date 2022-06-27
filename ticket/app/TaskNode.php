<?php

namespace App;

use Baum\Node;

class TaskNode extends Node
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';

  
    // guard attributes from mass-assignment
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

    protected $fillable = ['ticket_id', 'title'];

    public function ticket() 
    {
        return $this->hasOne('App\Ticket', 'id', 'ticket_id');
    }
  
}
