<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\file_drivers;

class Record_Driver extends Model
{
  protected $table      = 'record_driver';
  protected $fillable   = ['id_file_drivers' , 'id_user_offices', 'cod_falta', 'papeleta', 'entidad',
  'points_saldo', 'points_firmes', 'dinfranccion', 'estado', 'note', 'created_at','updated_at','status_system', 'modified_by'];

}
