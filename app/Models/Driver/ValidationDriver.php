<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Model;

class ValidationDriver extends Model
{
    protected $table      = 'vehicles';
    protected $fillable   = ['status_driver_val','status_driver_fi', 'id_customer', 'id_vehicle', 'note', 'modified_by', 'created_by'];
    public    $timestamps = true;

}
