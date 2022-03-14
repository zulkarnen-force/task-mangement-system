<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
 protected $table="task_list";
 protected $primaryKey="id";
 protected $fillable=['task_created_by','task_title','task_priority','task_status','task_message'];
}