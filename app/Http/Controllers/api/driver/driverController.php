<?php

namespace App\Http\Controllers\api\driver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
class driverController extends Controller
{

  // public function __construct()
  // {
  //   $this->middleware('auth.basic');
  // }


  public function getGenerateExcel()
  {


    $ch = curl_init('https://taxi-win.app/wp-json/api/v1/registrados');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json')
      );
      $result = curl_exec($ch);
      $myArray = json_decode($result);
      $a = [];
    foreach ($myArray as $key => $value) {
      $v =	[
        "dni" => $value->dni,
        "Nombres"=>$value->first_name,
        "Apellidos"=>$value->last_name,
        "Celular"=>$value->phone,
        "Correo"=>$value->billing_email,
        "Sponsor"=>$value->sponsor,
        "Pais"=>$value->pais,
        "Marca"=>$value->Marca,
        "Modelo"=>$value->Modelo,
        "Color"=>$value->Color,
        "Anio"=>$value->Anio,
        "Placa"=>$value->Placa,
      ];
				array_push($a,$v);

    }

     $list = collect($a);
     return  (new FastExcel($list))->download('generado'.date("Y-m-d H:i:s").'.xlsx');

  }

}
