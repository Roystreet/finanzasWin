<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Country extends Model
{
	protected $table      = 'country';
  protected $fillable   = ['description' ,'cod' ,'nationality', 'note', 'modified_by', 'status_system', 'status_user'];
  public    $timestamps = true;


  public function states(){
      return $this->hasMany(State::class, 'id');
  }
	public function getContryNationalities(){
			return $this->hasMany(Driver::class, 'id');
	}
	public function getContryAddress(){
			return $this->hasMany(Driver::class, 'id');
	}
	public function getCountry(){
			return $this->hasMany(Customer::class, 'id');
	}
	public function getCountryInv(){
			return $this->hasMany(Ticket::class, 'id');
	}
	public function getCountryDriverApp(){
			return $this->hasMany(Driver_App::class, 'id');
	}
	public function getCountryInfo(){
      return $this->hasOne(InfoCountry::class,'id_country', 'id');
  }
}
