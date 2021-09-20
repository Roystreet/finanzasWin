<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Status_driver extends Model
{
  protected $table      = 'status_drivers';
  protected $fillable   = ['description'];
}
