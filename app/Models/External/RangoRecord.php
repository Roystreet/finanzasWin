<?php

namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class RangoRecord extends Model
{
  protected $table      = 'rango_record';
  protected $fillable   = ['rangoa' , 'rangob', 'estatus', 'baprobado','color', 'created_at','updated_at', 'modified_by'];

}
