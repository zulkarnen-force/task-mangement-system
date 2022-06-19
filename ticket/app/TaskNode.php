<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;
class TaskNode extends Node
{
    protected $table = 'tasks';
    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
  
    // guard attributes from mass-assignment
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

    protected $fillable = ['ticket_id', 'title'];
  
}
