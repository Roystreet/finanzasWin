<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Model;

class vw_menu_roles extends Model
{
  protected $table = 'vw_menu_roles';
  protected $fillable  = ['id', 'idseccion', 'url','ramaid', 'ramanombre', 'id_rol', 'descripcion', 'id_rol_main'];



}
