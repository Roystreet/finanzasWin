<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\file_drivers;
use App\User;


class DriverApi extends Model
{
  protected $table      = 'driver_api';
  protected $connection = 'pgsql';
  protected $fillable   = ['id_file_drivers','driverid','vehicleid', 'documents', 'migrado', 'estatusapi', 'dmigrado', 'tenantid', 'vehicleTypeList', 'modified_by', 'created_at', 'updated_at', 'status_system' ];
  public    $timestamps = true;

  function getfiledrivers()
  {
    return $this->belongsTo(file_drivers::class,  'id_file_drivers','id')->withDefault([
      'id' => '0'
    ]);
  }

}
