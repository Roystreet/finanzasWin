<?php

namespace App\Models\CapitalDriver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Cobranza\Driver_App;
use App\Models\General\Status_Pay;
use App\Models\General\Pay;
use App\Models\General\Banks;
use App\Models\General\Account_Type;
use App\Models\General\User;
use \Carbon\Carbon;


class Driver_Saldo extends Model
{

  protected $table      = 'drivers_saldo';
  protected $fillable   = ['id', 'id_driver', 'id_pay' ,
                          'id_bank', 'id_account_type',
                          'number_operation', 'date_pay', 'saldo_actual', 'saldo_recarga','date_saldo',
                          'note', 'modified_by',
                          'status_system','status_user','route_img','name_img'];
  public    $timestamps = true;

  public function getDriver()   {
    return $this->belongsTo(Driver_App::class,     'id_driver');
  }
  public function getStatus()   {
    return $this->belongsTo(Status_Pay::class,     'status_user');
  }
  public function getPay()   {
    return $this->belongsTo(Pay::class,             'id_pay');
  }
  public function getBank()   {
    return $this->belongsTo(Banks::class,           'id_bank');
  }
  public function getAccount()   {
    return $this->belongsTo(Account_Type::class,    'id_account_type');
  }
  public function getModifyBy()   {
    return $this->belongsTo(User::class,    'modified_by');
  }
}
