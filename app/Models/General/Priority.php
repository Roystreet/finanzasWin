<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
  protected $table = 'priorities';
  protected $fillable  = ['id', 'description','response_time','solution_time','created_by', 'modified_by','created_at',
  'updated_at','status_system'];
}
