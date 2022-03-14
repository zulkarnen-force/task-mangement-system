<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
 protected $table="ticket_list";
 protected $primaryKey="id";
 protected $fillable=['nama','judul','priority','status','isi'];
}