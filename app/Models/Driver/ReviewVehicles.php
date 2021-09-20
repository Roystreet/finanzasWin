<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;

class ReviewVehicles extends Model
{
  protected $table      = 'review_vehicles';
  protected $fillable   = ['date_review','quantity_infringement','amount_infringement','url_origen','soat','date_soat_expiration','id_driver','note','modified_by','created_by','created_at','updated_at','status_system'];

}
