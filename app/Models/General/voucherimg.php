<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class voucherimg extends Model
{
  protected $table      = 'voucherimgs';
  protected $fillable   = ['route_img' , 'type_img','id_ticket','modified_by','status_system', 'status_user'];
}
