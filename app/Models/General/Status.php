<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Status extends Model
{
	protected $table = 'status';
  protected $fillable  = ['id', 'description'];

	public function ticket(){
			return $this->hasMany(Ticket::class, 'id');
	}
	public function customer(){
			return $this->hasMany(Customer::class, 'id');
	}

}
