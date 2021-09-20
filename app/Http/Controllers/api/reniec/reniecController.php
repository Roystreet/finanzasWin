<?php

namespace App\Http\Controllers\api\reniec;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerType;
use App\Models\Customer\dtCustomerType;
use App\Models\Driver\TypeBodywork;
use \stdClass;

class reniecController extends Controller
{
    //consultar con el dni
    public function customerPeruApi()
    {


        $dni = request()->all(){'document'};
        $country = request()->all(){'country'};

        if($country=="PE")
        {
          if(is_numeric($dni))
          {
            if(strlen($dni)==8)
            {
              if(Customer::where('document',$dni)->exists())
              {
                $c = $this->getDriver($dni);
                return response()->json([
                    "resp"   => 'success',
                    "data" =>$c
                  ]);
              }
              else
              {
                  return $this->reniecPeruApi2($dni);
              }
            }
            else
            {
              return response()->json([
                  "resp"   => 'error',
                  "message" => "DNI. es un valor de 8 dígitos.",
                  "data" =>null
                ]);
            }

          }
          else
          {
            return response()->json([
                "resp"   => 'error',
                "message" => "DNI solo números",
              ]);
          }
        }//fin de peru
        else
        {
          return response()->json([
              "resp"   => 'error',
              "message" => "No hay validacion para su pais.",
            ]);
        }

    }

    public function reniecPeruValidate(){
        $dni  = request()->document;
        $val  = $this->reniecPeruApi2($dni);
        $val2 =  $this->reniecPeruApi1($dni);

        if ($val->object == true){
          $data = $val;
        }else if ($val2->object == true){
          $data  = $val2;
        }else{
          $a = new stdClass();
          $a->first_name = null;
          $a->last_name  = null;
          $a->object = false;
          $a->message = "COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
          $data = $a;
        }
        return response()->json([
            "data" => $data
        ]);
    }

    public function reniecPeruApi1($dni){
        $url = 'http://18.228.228.200/taxiwin/reniec_dni.php?dni='.$dni;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );

         $result = [
           'result'       => $result,
           'status'       => $httpStatus
         ];

        if($result{'status'}==200)
        {
          $validatedni = file_get_contents('http://18.228.228.200/taxiwin/reniec_dni.php?dni='.$dni, true);
          $dnival = json_decode($validatedni);

          $a = new stdClass();
          if (isset($dnival->listaAni[0]))
          {
            $a->first_name = $dnival->listaAni[0]->preNombres;
            $a->last_name = $dnival->listaAni[0]->apePaterno.' '.$dnival->listaAni[0]->apeMaterno;
            $a->message    = "CORRECTO DNI ENCONTRADO";
            $a->object = true;
          }else{
            $a->object = true;
            $a->first_name = null;
            $a->last_name = null;
            $a->message = "El DNI ES INVALIDO O ES MENOR DE EDAD";
          }
        return $a;
      }else {
        $a = new stdClass();
        $a->object = false;
        return $a;
      }
    }

    public function reniecPeruApi2($dni)
    {
      $ch = curl_init('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


      $result = curl_exec($ch);
      $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
      curl_close( $ch );

       $result = [
         'result'       => $result,
         'status'       => $httpStatus
       ];


       if($result{'status'}==200)
       {
         $valorDoc = explode("|", $result{'result'});
         $a = new stdClass();
         if (!isset($valorDoc[3])){
           $a->first_name = $valorDoc[2];
           $a->last_name  = $valorDoc[0].' '.$valorDoc[1];
           $a->message    = "CORRECTO DNI ENCONTRADO";
           $a->object = true;
         }else{
           $a->object = true;
           $a->first_name = null;
           $a->last_name = null;
           $a->message = "El DNI ES INVALIDO O ES MENOR DE EDAD";
         }
         return $a;
       } else {
         $a = new stdClass();
         $a->object = false;
         return $a;
      }
    }


    public function reniecPeruApi3($dni)
    {

          $ch = curl_init('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


          $result = curl_exec($ch);
          $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
          curl_close( $ch );

       $result = [
         'result'       => $result,
         'status'       => $httpStatus
       ];


       if($result{'status'}==200)
       {
         $valorDoc = explode("|", $result{'result'});
         $a = new stdClass();
         $a->first_name = $valorDoc[2];
         $a->last_name = $valorDoc[0].' '.$valorDoc[1];

        //----------------
            $cu = new Customer();
             $cu->first_name =  $a->first_name;
             $cu->last_name = $a->last_name;
             $cu->document = $dni;
             $cu->id_country = 172;
             $cu->id_state = 2825;
             $cu->id_city = 48357;
             $cu->admission_date = "12-12-12";


             if($cu->first_name!=null || $cu->first_name!="")
             {
               $cu->save();

               $c = $this->getDriver($dni);

                 $cudt = new dtCustomerType;
                 $cudt->id_customerType = 1;
                 $cudt->id_customer = $c->customer->id;
                 $cudt->save();
               return response()->json([
                   "resp"   => 'success',
                   "data" =>$c
                 ]);
              }
             else
             {
               return response()->json([
                   "resp"   => 'error',
                   "message"=>"No Exsite El documento de identidad.",
                 ]);
             }

       }
       else
       {
         return response()->json([
             "resp"   => 'error',
             "data" =>null
           ]);
       }

     }

     public function getDriver($dni)
     {
       $cu =  new stdClass();
       $u = Customer::where("document",$dni)->first();
       $cudt = dtCustomerType::where('id_customer',$u->id)->first();
       if($cudt != null)
       {
         $cu->typeCustomer = $cudt->getTypeCustomer()->get();
         $cu->infoLicense = $cudt->getDriver()->first();
         if($cu->infoLicense!=null)
         $cu->countryLicense = $cudt->getDriver()->first()->getCountry()->first()->description;
       }

       $cu->getcountry  = $u->getCountry()->first()->description;
       $cu->getState  = $u->getState()->first()->description;
       $cu->getCity  = $u->getCity()->first()->description;
       $cu->customer = $u;
        return $cu;
     }

    //seguridad
    public function denied()
    {
      return "No tienes Acceso contacte al administrador.";
    }

    public function type()
    {
      $c = new TypeBodywork();
      $c->description = "Van";
      $c->save();
    }


}
