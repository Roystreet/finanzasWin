<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Banks extends Model
{
	protected $table      = 'banks';
	protected $fillable   = ['name' ,'note', 'modified_by', 'status_system', 'status_user'];
	public    $timestamps = false;

	public function bank_saldo(){
			return $this->hasMany(Driver_Saldo::class, 'id');
	}
}
