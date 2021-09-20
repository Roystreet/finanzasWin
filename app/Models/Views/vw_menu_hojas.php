<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class vw_menu_hojas extends Model
{
  protected $table = 'vw_menu_hojas';
  protected $fillable  = ['id', 'idseccion', 'url','ramaid', 'ramanombre'];



}
