<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;
use App\Models\Driver\Driver;

class Vehicle extends Model
{
  protected $table      = 'vehicles';
  protected $connection = 'pgsql';
  protected $fillable   = ['number_enrollment','brand', 'model', 'color', 'nro_doors', 'model_year', 'id_driver','id_customer_owner','id_typebodyworks'];
  public    $timestamps = true;

  public function getDriver() {
    return $this->belongsTo(Driver::class,'id_driver','id');
  }
}
