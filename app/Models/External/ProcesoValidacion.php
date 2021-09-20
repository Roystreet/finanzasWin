<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class ProcesoValidacion extends Model
{
  protected $table      = 'proceso_validacion';
  protected $connection = 'pgsql';
  protected $fillable   = ['nombre','estatus', 'obligatorio', 'id_permission', 'modified_by', 'created_at', 'updated_at', 'status_system' ];
  public    $timestamps = true;
}
