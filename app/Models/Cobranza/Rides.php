<?php

namespace App\Models\Cobranza;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Cobranza\Driver_App;
use App\Models\General\Status_Pay;

use \Carbon\Carbon;


class Rides extends Model
{

  protected $table      = 'rides';
  protected $fillable   = ['id', 'dblink_ride', 'dblink_driver' ,
                          'id_driver', 'pay', 'date_ride','id_status_pay','money',
                          'total_pay', 'porcentaj_ret',
                          'mto_ret', 'mto_abono', 'status_app',
                          'note', 'modified_by',
                          'status_system','status_user'];
  public    $timestamps = true;

  public function getDriver()   {
    return $this->belongsTo(Driver_App::class,     'id_driver');
  }
  public function getStatusRide()   {
    return $this->belongsTo(Status_Pay::class,     'id_status_pay');
  }
}
