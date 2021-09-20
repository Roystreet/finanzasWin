<?php

namespace App\Classes;
use App\Models\Bitacora\bitacora;
use Illuminate\Support\Facades\DB;


class BitacoraClass
{
    //

    public function create_bitacora($r){
      //dd($r);

      $json_string = 'https://api.ipify.org?format=json';
      $jsondata = file_get_contents($json_string);
      $ip = json_decode($jsondata,true);

      $json_string1 = 'http://www.geoplugin.net/json.gp?ip='.$ip['ip'].'';
      $jsondata1 = file_get_contents($json_string1);
      $location = json_decode($jsondata1,true);

      $acc = $r[0]['action'];
      $resultado = $r[0]{'column'};

      $res = [];
      foreach ($resultado as $key => $value) {
          $s = $key;
          array_push($res,$s);
      }

      $array1 = $r[0]{'after'};

      $res1 = [];
      foreach ($array1 as $key1 => $value1) {
        foreach ($res as $key)
        {
          if($key1==$key)
          {
            $r = [$key1 => $value1];
            array_push($res1,$r);
          }
        }
      }






      $now = new \DateTime();
      $bitacora = [
        'action_bitacora'         => $acc,
        'database_modification'   => env('DB_DATABASE'),
        'column_table'            => json_encode($res),
        'fact_column_before'      => json_encode($resultado),
        'fact_column_after'       => json_encode($res1),
        'id_user'                 => auth()->user()->id,
        'ip'                      => $ip['ip'],
        'location_modification'   => $location['geoplugin_countryCode'],
        'date_modification'       => $now->format('d-m-Y H:i:s')
      ];
      $id_bitacora = bitacora::create($bitacora)->id;
      return $bitacora;
    }

}
