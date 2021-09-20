<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Main extends Model
{
	protected $table      = 'main';
	protected $fillable   = ['description' , 'section','path'];


}
