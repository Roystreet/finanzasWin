<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\Country;
use App\Models\Customer\Customer;

class Driver extends Model
{
   protected $table      = 'drivers';
   protected $fillable   = ['number_license' , 'category', 'id_country_driving', 'date_expiration', 'points', 'points_limit','id_customer','note','modified_by','created_by','created_at','updated_at','status_system'];


   public function getCountry()
   {
     return $this->belongsTo(Country::class,     'id_country_driving')->withDefault([
       'id' => '0',
       'description'=>'Anónimo'
     ]);
   }
   public function getCustomer()
   {
     return $this->belongsTo(Customer::class,     'id_customer')->withDefault([
       'id' => '0'
     ]);
   }
}
