<?php

namespace App\Models\Cobranza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\General\Country;


use \Carbon\Carbon;


class Order_Ride extends Model
{

  protected $table      = 'order_ride';
  protected $fillable   = ['id', 'id_order', 'id_ride' ,
                          'note', 'created_at', 'updated_at', 'modified_by',
                          'status_system','status_user'];
  public    $timestamps = true;

  public function getCountry()   {
    return $this->belongsTo(Country::class,     'id_country');
  }
  public function rides(){
      return $this->hasMany(Rides::class, 'id');
  }

}
