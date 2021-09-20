<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Rol_User extends Model
{
	protected $table      = 'rol_user';
	protected $fillable   = ['id_role','id_user'];


}
