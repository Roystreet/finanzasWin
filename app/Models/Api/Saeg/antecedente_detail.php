<?php

namespace App\Models\Api\Saeg;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Saeg\Type_antecedente;
use App\Models\Api\Saeg\Type_reference;
use App\Models\Api\Saeg\antecedente;
class antecedente_detail extends Model
{
  protected $table = 'antecedente_details';
protected $fillable = ['id_type_antecedente','id_type_reference','id_antecedente',
          'crime','dependence','number_office','date_register',
          'situation','part','observation','modify_by','create_by'];

          public function getTypeAntecedente()   {
            return $this->belongsTo(Type_antecedente::class,     'id_type_antecedente')->withDefault([
              'id' => '0',
              'description'=>'Anónimo'
            ]);
          }

          public function getTypeReference()   {
            return $this->belongsTo(Type_reference::class,     'id_type_reference')->withDefault([
              'id' => '0',
              'description'=>'Anónimo'
            ]);
          }

}
