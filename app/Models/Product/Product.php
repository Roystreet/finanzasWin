<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductAction;
use App\Models\General\Money;
use App\Models\Product\Price;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "products";
    protected $fillable  = ['cod_product', 'name_product','description','url_imagen','status_user','store', 'created_at', 'modified_by'];


    public function getProductAction(){
  			return $this->hasOne(ProductAction::class, 'id_product');
  	}
    public function product(){
        return $this->hasMany(TicketDs::class, 'id');
    }

    public function getPrice()
    {
      return $this->hasMany(Price::class, 'id_product','id');
    }




}
