<?php

namespace App\Models\Api\Saeg;

use Illuminate\Database\Eloquent\Model;

class Solicitud_saeg extends Model
{
  protected $table = 'solicitud_saegs';
protected $fillable = ['description','state','modify_by','create_by'];
}
