<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class StatusT extends Model
{
  protected $table = 'status_ts';
  protected $fillable  = ['id', 'description'];
}
