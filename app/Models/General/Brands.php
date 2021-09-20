<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
  protected $table      = 'brands';
  protected $fillable   = ['description' , 'modified_by', 'created_by' ,'created_at', 'updated_at'];
  public    $timestamps = true;

}
