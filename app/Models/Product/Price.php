<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\Money;
use OwenIt\Auditing\Contracts\Auditable;

class Price extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  protected $table = "prices";
  protected $fillable  = ['id_product', 'id_money','price','description','note','modified_by','status_system','status_user', 'created_at', 'modified_by'];

}
