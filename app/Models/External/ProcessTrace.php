<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\ProcesoValidacion;

class ProcessTrace extends Model
{
  protected $table      = 'process_trace';
  protected $connection = 'pgsql';
  protected $fillable   = ['id_file_drivers','id_process_model','sec_actual', 'sec_sig', 'estatus', 'modified_by', 'created_at', 'updated_at', 'status_system' ];
  public    $timestamps = true;

  function getProcesModel()
  {
    return $this->belongsTo(ProcesoValidacion::class,  'id_process_model')->withDefault([
      'id' => '0',
      'obligatorio'=>false
    ]);
  }

}
