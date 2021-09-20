<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\file_drivers;
use App\User;


class ServiceType extends Model
{
  protected $table      = 'service_type';
  protected $connection = 'pgsql';
  protected $fillable   = ['id_file_drivers','service_type','modified_by', 'created_at', 'updated_at', 'status_system' ];
  public    $timestamps = true;

  function getfiledrivers()
  {
    return $this->belongsTo(file_drivers::class,  'id_file_drivers','id')->withDefault([
      'id' => '0'
    ]);
  }

}
