<?php

namespace App\Http\Controllers\api\Culqi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Customer\Customer;
use App\Models\General\Country;
use \stdClass;

class CulqiController extends Controller
{

    function access()
    {
          $a = new stdClass();
          $a->key_public = "pk_test_f9Tgndd5Qnsx99Lj";
          $a->key_private = "sk_test_8YFhi82RfWJXHvKM";
          $a->lick = "https://api.culqi.com/v2/";
          return $a;
    }
    // Validacion de Campos del Nombre para culqi
  public function soloLetras($cadena){
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
    for ($i=0; $i<strlen($cadena); $i++){
      if (strpos($permitidos, substr($cadena,$i,1))===false){
        return false;
      }
    }
    //si estoy aqui es que todos los caracteres son validos
    return true;
  }

  public function keyPrivate()
  {
    $b = $this->access()->key_public;
    return response()->json($b);
  }


    function payCulqi($c,$m,$t)
    {
          $aa = $this->access();
         	$first_name = $this->soloLetras($c->first_name);
         	$last_name  = $this->soloLetras($c->last_name) ;
     	if ($first_name && $last_name)
     		{
     			 $id_country   = Country::where('id', '=', $c->id_country)->first()->nationality;
       		$antifraud_details  = array(
                   'address'       => $c->address,
                   'address_city'  => $c->city,
                   'country_code'  => $id_country,
                   'first_name'    => $c->first_name,
                   'last_name'     => $c->last_name,
                   'phone_number'  => $c->phone);//validar si esta vacio
             $data               =  array(
                     "amount"            => $m->mount,
                     "currency_code"     => $m->currency_code,
                     "description"       => 'pago por accionista.wintecnologies',
                     "email"             => $c->email,
                     "source_id"         => $t,
                     "antifraud_details" => $antifraud_details );
             $string  = json_encode($data);

             $ch = curl_init($aa->lick.'/charges');
                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                     'Content-Type: application/json',
                     'Authorization: Bearer '.$aa->key_private)
                 );
             $cQ = curl_exec($ch);
             $p  = json_decode($cQ);
       	  if ($p->object != "error")
          {
                $b = [
                    	'object'  => "success",
            		       'data' => $p
                   		];
            return response()->json($b);

          }
          else
          {
            $b = [
                     'object'  => "error",
		                  'data' =>$p
                     ];
            return response()->json($b);
          }
        }
    }




    public function pay(Request $r)
    {
      $a = new stdClass();
      $a->mount = request()->register{'amount'};
      $a->currency_code= request()->register{'money'};
      $t = request()->register{'token'};
      $customer = Customer::where('document',request()->register{'document'})->first();
      return $this->payCulqi($customer,$a,$t);
    }

    public function order()
    {
      $aa = $this->access();
      $data               =  array(
                      "amount" => 1000,
                 "currency_code" => "PEN",
                 "description" => 'Venta de prueba',
                 "order_number" => 'p844sddfgdfg-95565s5s6s5999',
                 "client_details" => array(
                    "first_name"=> "richard",
                    "last_name" => "Hendricks",
                    "email" => "rporlsd@piedpiper.com",
                    "phone_number" => "+51945145222"
                  ),
                  "confirm" => false,
                  "expiration_date" => time() + 24*60*60,   // 1 dia
                  "metadata" => array ("document" => "71701955676" )
            );
      $string             = json_encode($data);

      $ch = curl_init($aa->lick.'/orders');
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Authorization: Bearer '.$aa->key_private)
          );
      $cQ = curl_exec($ch);
  $p  = json_decode($cQ);
      if ($p->object == "order")
      {
            $b = [
                  'object'  => "success",
                   'data' => $p->id,
                  ];
        return response()->json($b);

      }
      else
      {
        $b = [
                 'object'  => "error",
                 'data' => $p,
                 ];

        return response()->json($b);
      }
    }



}
