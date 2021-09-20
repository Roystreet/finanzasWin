<?php

namespace App\Models\Api\Saeg;

use Illuminate\Database\Eloquent\Model;
use App\Models\External\User_office;

class Solicitud_saeg_details extends Model
{
  protected $table = 'solicitud_saeg_details';
  protected $fillable = ['id_solicitud_saeg','id_office','state','modify_by','create_by'];


  function getUserOffice()
  {
    return $this->belongsTo(User_office::class,  'id','id_office')->withDefault([
      'id' => '0'
    ]);
  }
}
