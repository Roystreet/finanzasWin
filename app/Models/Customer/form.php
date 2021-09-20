<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class form extends Model
{
  protected $table = 'forms';
  protected $fillable  =	['id','dni','first_name','last_name',
                           'q1','q2','q3','q4' ];
}
