<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Account_Type extends Model
{
	protected $table      = 'account_type';
	protected $fillable   = ['name' ,'note', 'modified_by', 'status_system', 'status_user'];
	public    $timestamps = false;

	public function account_saldo(){
			return $this->hasMany(Driver_Saldo::class, 'id');
	}
}
