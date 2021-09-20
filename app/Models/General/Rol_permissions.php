<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Rol_permissions extends Model
{
  protected $table      = 'rol_permissions';
  protected $fillable   = ['id_permission','id_roluser','note','modified_by','create_by'];
}
