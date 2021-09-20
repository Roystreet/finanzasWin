<?php


namespace App\Models\External;

use Illuminate\Database\Eloquent\Model;

class VwProcesosTotal extends Model
{
  protected $table = 'vw_procesos_total';
  protected $fillable  = ['cant_procesos', 'id_file_drivers'];

}
