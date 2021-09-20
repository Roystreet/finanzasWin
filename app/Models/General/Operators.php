<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Operators extends Model
{
  protected $table      = 'operators';
  protected $fillable   = ['description' , 'modified_by', 'created_by' ,'created_at', 'updated_at'];
  public    $timestamps = true;
}
