<?php

namespace App\Models\Red;

use Illuminate\Database\Eloquent\Model;

class Red extends Model
{
  protected $table = "users_net";
  protected $fillable  = ['id','user','password','id_customer', 'id_parent', 'id_sponsor','created_at', 'modified_by'];
}
