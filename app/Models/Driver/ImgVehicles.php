<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;

class ImgVehicles extends Model
{
  protected $table      = 'img_vehicles';
  protected $fillable   = ['description' , 'url_image', 'id_vehicle','modified_by','created_by','created_at','updated_at','status_system'];

}
