<?php

namespace App\Models\Cobranza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\General\Country;

use \Carbon\Carbon;


class Driver_App extends Model
{

  protected $table      = 'driver_app';
  protected $fillable   = ['dblink_driver', 'first_name' , 'last_name', 'dni', 'license_number', 'phone', 'email',
                          'id_country','note', 'created_at', 'updated_at', 'modified_by',
                          'status_system','status_user'];
  public    $timestamps = true;

  public function getCountry()   {
    return $this->belongsTo(Country::class,     'id_country');
  }
  public function rides(){
      return $this->hasMany(Rides::class, 'id');
  }
  public function saldo(){
      return $this->hasMany(Driver_Saldo::class, 'id');
  }
}
