<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
use App\Models\General\Money;
use OwenIt\Auditing\Contracts\Auditable;

class ProductAction extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;
    protected $table = "product_actions";
    protected $fillable  = ['id_product','id_money','cant','purchase_price', 'sale_price','status_user', 'created_at', 'modified_by'];

    public function getProduct() {
      return $this->belongsTo(Product::class,  'id_product');
    }
}
