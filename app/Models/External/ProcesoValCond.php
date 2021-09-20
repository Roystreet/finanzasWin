<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\ProcesoValidacion;
use App\User;


class ProcesoValCond extends Model
{
  protected $table      = 'proceso_val_cond';
  protected $connection = 'pgsql';
  protected $fillable   = ['id_file_drivers','id_proceso_validacion','estatus_proceso', 'approved', 'modified_by', 'created_at', 'updated_at', 'status_system' ];
  public    $timestamps = true;

  function getProceso()
  {
    return $this->belongsTo(ProcesoValidacion::class,  'id_proceso_validacion','id')->withDefault([
      'id' => '0'
    ]);
  }
  public function getModifyBy() {
    return $this->belongsTo(User::class,         'modified_by')->withDefault([
        'username' => 'Anónimo',
          ]);
  }
}
