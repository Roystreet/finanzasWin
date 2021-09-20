<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Status_Pay extends Model
{
	protected $table = 'status_pay';
  protected $fillable  = ['id', 'name'];

	public function driverSaldo(){
			return $this->hasMany(Driver_Saldo::class, 'id');
	}
	public function status_order(){
			return $this->hasMany(Order::class, 'id');
	}
	public function status_ride(){
			return $this->hasMany(Rides::class, 'id');
	}
}
