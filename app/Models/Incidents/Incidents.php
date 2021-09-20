<?php

namespace App\Models\Incidents;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\Brands;
use App\Models\Customer\Operators;

class Incidents extends Model
{
  protected $table = 'incidents';
  protected $fillable  =	['id','motive','id_operator','appwifi','id_brand','models','OS','verOS', 'date_time','details' , 'modified_by', 'created_by','created_at', 'updated_at','status_system'];

  public function getBrands()  {
    return $this->belongsTo(Brands::class, 'id_brand')->withDefault([
        'description' => 'Anónimo',
    ]);
  }

  public function getOperators() {
    return $this->belongsTo(Operators::class, 'id_operator')->withDefault([
      'description' => 'Anónimo',
    ]);
  }

}
