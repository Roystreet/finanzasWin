<?php

namespace App\Http\Controllers\api\MTC;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Driver\Vehicle;
use \stdClass;

class MtcController extends Controller
{

  function getVehiculo($p)
  {
    if(Vehicle::where('number_enrollment',$p)->exists())
    {
      $v = Vehicle::where('number_enrollment',$p)->first();
      $d = $v->getDriver()->first();
      $c = $d->getCountry()->first();
      $a = new stdClass();
      $a->Vehicle = $v;
      $a->driver = $d;
      $a->CountryDriver = $c;
      return $a;
    }
    else
    {
      $a = new stdClass();
      $a->objet = "error";
      return $a;
    }
  }
  public function getVehiculoApi()
  {
    $p = request()->placa;
    $v=  $this->getVehiculo($p);
    if(true)
    {
      return response()->json([
        'object'  => "success",
         'data' =>$v
      ]);
    }
    else {
      return response()->json([
        'object'  => "alert",
        'message' => "No existe el vehicle"
      ]);
    }
  }
  public function apiSoatPlaca()
  {
    $p = request()->placa;

    $url = 'http://taxiwin.wsdatosperu.com/soat.php?placa='.$p;

    $ch  =  curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result     = curl_exec($ch);
    $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
                  curl_close( $ch );

     $result = [       'result'       => $result,       'status'       => $httpStatus     ];

    if($result{'status'}==200){

      $validate = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.$p, true);
      $data     = json_decode($validate);
      if(isset($data->NombreCompania)){
        return response()->json([
          'object'  => "sucesss",
          'message' => "Seguro validado con exito.",
          'data'    => $data
        ]);
      }else {
        return response()->json([
          'object'  => "error",
          'message' => "No hemos podido validar su información",
          'data'    => null
        ]);
      }
    }
    else {
      return response()->json([
        'object'  => "error",
        'message' => "No hemos podido validar su información",
        'data'    => null
      ]);
    }

  }




}
