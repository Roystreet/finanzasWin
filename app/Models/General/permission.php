<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
  protected $table      = 'permissions';
  protected $fillable   = ['id','description','note','modified_by','create_by'];
}
