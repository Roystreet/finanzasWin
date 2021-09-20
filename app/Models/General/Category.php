<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'categories';
  protected $fillable  = ['id', 'name','description','id_type_requeriments'];
  
}
