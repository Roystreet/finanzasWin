<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class City extends Model
{
	protected $table      = 'city';
	protected $fillable   = ['description' , 'id_state','modified_by', 'status_system', 'status_user'];
	public    $timestamps = false;

	public function getCityAddress(){
			return $this->hasMany(Driver::class, 'id');
	}
	public function getCity(){
			return $this->hasMany(Customer::class, 'id');
	}
	public static function getCities($id) {
		return City::where('id_state', '=', $id)->get();
	}

	public function state(){
    return $this->belongsTo(State::class, 'id_state');
  }


}
