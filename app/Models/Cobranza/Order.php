<?php

namespace App\Models\Cobranza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\General\Country;
use App\Models\General\Pay;
use App\Models\General\Money;
use App\Models\General\User;
use App\Models\General\Status_Pay;
use App\Models\Cobranza\Rides;
use App\Models\Cobranza\Order_Ride;
use App\Models\Cobranza\Driver_App;


class Order extends Model
{

  protected $table      = 'order';
  protected $fillable   = ['id', 'cod_order', 'date_pay', 'id_pay' , 'id_money',
                          'total', 'total_abono', 'total_ret', 'note', 'created_at',
                          'updated_at', 'modified_by',
                          'status_system','status_user'];
  public    $timestamps = true;


    public function getCountry()   {
      return $this->belongsTo(Country::class,     'id_country');
    }

    public function getPay()   {
      return $this->belongsTo(Pay::class,             'id_pay');
    }
    public function getMoney()   {
      return $this->belongsTo(Money::class,           'id_money');
    }
    public function getModifyBy()   {
      return $this->belongsTo(User::class,       'modified_by');
    }
    public function getStatus()   {
      return $this->belongsTo(Status_Pay::class,  'status_user');
    }

    // public function getRides()  {
    //   return $this->hasManyThrough(Rides::class, Order_Ride::class, 'id_order', 'id', 'id', 'id_ride');
    // }

     public function getRides()  {
      return $this->hasManyThrough(Driver_app::class,Rides::class, 'campo1','id','camnpo3','id_driver');
    }

}
