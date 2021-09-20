<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;

class TypeBodywork extends Model
{
  protected $table      = 'type_bodyworks';
  protected $fillable   = ['description', 'note','modified_by','created_by','created_at','updated_at','status_system'];

}
