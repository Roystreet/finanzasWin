<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class Payments_Quotas_ds extends Model
{
  protected $table = 'payments_quotas';
  protected $fillable  =	['id','id_pay_quotas','date_emission','letter','cod_voucher','id_customer_pay','date_limit','date_expiration','import','id_pay','total_amount','id_money','amount_dolar','note','modified_by','created_by'];
}
