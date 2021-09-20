<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class Payments_quotas extends Model
{
  protected $table = 'payments_quotas';
  protected $fillable  =	['id','id_customer','id_ticket','quotas_amount','total_amount','frecuencia_payment','note','modified_by','created_by'];

}
