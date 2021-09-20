<?php

namespace App\Http\Controllers\Bitacora;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bitacora\bitacora;
use Illuminate\Support\Facades\DB;

class BitacoraController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  $now = new \DateTime();
  public function create_bitacora($r){
      $bitacora = [
        'action_bitacora'         => $r->action,
        'database_modification'   => env('DB_DATABASE'),
        'column_table'            => $r->column,
        'fact_column_before'      => $r->column_before,
        'fact_column_after'       => $r->column_after,
        'id_user'                 => auth()->user()->id,
        'ip'                      => $_SERVER['SERVER_ADDR'],
        'location_modification'   => $r->location,
        'date_modification'       => $now->format('d-m-Y H:i:s');
      ];
      $id_bitacora = bitacora::create($bitacora)->id;
      return $id_bitacora;
    }

}
