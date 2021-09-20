<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
  protected $table = 'customer_types';
  protected $fillable  =	['id','description','note', 'modified_by', 'created_at', 'status_system',
                            'created_by','updated_at'];
}
