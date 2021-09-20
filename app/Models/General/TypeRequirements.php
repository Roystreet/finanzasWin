<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class TypeRequirements extends Model
{
  protected $table = 'type_requirements';
  protected $fillable  = ['id', 'description'];
}
