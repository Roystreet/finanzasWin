<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product\ProductAction;

class Money extends Model
{
	protected $table = 'moneys';
  protected $fillable  = ['id', 'description', 'symbol', 'modified_by','status_system'];

	public function money() {
		return $this->belongsToMany(ProductAction::class);
	}
	public function money_order() {
		return $this->belongsToMany(Order::class, 'id');
	}
}
