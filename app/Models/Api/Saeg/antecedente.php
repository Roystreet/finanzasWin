<?php

namespace App\Models\Api\Saeg;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Saeg\antecedente_detail;
use App\Models\External\User_office;
class antecedente extends Model
{
  protected $table = 'antecedentes';
  protected $fillable = ['description','id_user_offices','modify_by','create_by'];

  function getAntedenteDetails()
  {
    return $this->hasMany(antecedente_detail::class,  'id_antecedente','id');
  }

  // function getUserOffice()
  // {
  //   return $this->belongsTo(User_office::class,  'id_user_offices','id')->withDefault([
  //     'id' => '0'
  //   ]);
  // }

}
