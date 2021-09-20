<?php

namespace App\Http\Controllers\Red;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Red\Red;
use Illuminate\Support\Facades\DB;

class RedController extends Controller
{
    public function valitedUser(Request $r){
      $data = json_decode(file_get_contents('https://taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?data='.$r->data.'&action=getCustomerRed&key=1234'), true);
      if (empty($data)){
        $Datored =  Red::where('status_system', '=', 'TRUE')
        ->where('user', '=', $r->data)
        ->first();
        if ($Datored !== null){
          $idCustomer = $Datored->id_customer;
          $datos = Customer::where('id', '=', $idCustomer)
          ->first();
          $idsponsor = $Datored->id;
          $resp = 'bdwin';
        }else{
          $datos = '';
          $resp = '';
          $idsponsor = '';
        }
      }else{
        $idsponsor = '';
        $resp = 'taxiwin';
        $datos = $data[0];
      }
      return response()->json(["mensaje"   => $datos, "data" => $resp , 'sponsor' => $idsponsor]);
    }

    public function ValiteWinistoshareTaxiwin(Request $r){

      $dataAccionista = json_decode(file_get_contents('http://winistoshare.com/API/ConeccionwinIsToShare/Conexion/customer.php?data='.$r->data.'&key=1234'), true);

      $dataRed = json_decode(file_get_contents('https://www.taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?key=1234&action=getCustomer&data='.$r->data.''), true);

      $DatoCustomer =  Customer::where('status_system', '=', 'TRUE')
      ->where('document', '=', $r->data)
      ->first();

      if ($DatoCustomer == null){
        if (empty($dataAccionista)){
          if (empty($dataRed)){
              $datos = '';
              $resp = '';
          }else{
              $resp = 'taxiwin';
              $datos = $dataRed[0];
          }
        }else{
          $resp = 'winistoshare';
          $datos = $dataAccionista[0];
        }
      }else{
        $datos = $DatoCustomer;
        $resp = 'bdwin';
      }

      return response()->json(["mensaje" => $datos, "data" => $resp]);
    }


    public function valitedDNI(Request $r){
      $dni = $r->document;

      $respuesta = Customer::where('status_system', '=', 'TRUE')
      ->where('document', '=', $dni)
      ->with('getCountry', 'getState', 'getCity')
      ->first();

      return response()->json($respuesta);
    }

    public function savenet(Request $r){



      if ($r->customer{'metod_sponsor'} == 'bdwin'){
         $id_sponsor = $r->customer{'sponsorid'};
      }else{
        $usuario = $r->customer{'sponsorid'};
        $data = json_decode(file_get_contents('https://taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?data='.$usuario.'&action=getCustomerRed&key=1234'), true);
        $dd = Customer::where('document', '=', $data[0]{'document'})->exists();
        if (!$dd){
          $invited = [
              'first_name'      =>  $data[0]{'first_name'},
              'last_name'       =>  $data[0]{'last_name'},
              'document'             =>  $data[0]{'document'},
              'admission_date'  =>  "12-12-12",
              'modified_by'     =>  2,
              'invited_user'    =>  '',
              'status_user'     => '5'
          ];
          $id_sponsor = Customer::create($invited)->id;
        }else {
          $id_sponsor = Customer::where('document', '=', $data[0]{'document'})->get()[0]->id;
        }
      }


      if ($r->customer{'metod_customer'} == 'bdwin'){
         $id_customer = $r->customer{'id_customer'};
      }else if ($r->customer{'metod_customer'} == 'taxiwin'){
        $dataRed = json_decode(file_get_contents('https://www.taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?key=1234&action=getCustomer&data='.$r->customer{'id_customer'}.''), true);
        $rr = Customer::where('document', '=', $dataRed[0]{'document'})->exists();
        if (!$rr){
          $customer = [
            'first_name'      =>  $dataRed[0]{'first_name'},
            'last_name'       =>  $dataRed[0]{'last_name'},
            'document'             =>  $dataRed[0]{'document'},
            'phone'           =>  $dataRed[0]{'phone'},
            'email'           =>  $dataRed[0]{'email'},
            'admission_date'  =>  "12-12-12",
            'modified_by'     =>  auth()->user()->id
          ];
          $id_customer = Customer::create($customer)->id;
        }else { $id_customer = Customer::where('document', '=', $dataRed[0]{'document'})->get()[0]->id; }

      }else if ($r->customer{'metod_customer'} == 'winistoshare'){
        $dataAccionista = json_decode(file_get_contents('http://winistoshare.com/API/ConeccionwinIsToShare/Conexion/customer.php?data='.$r->customer{'id_customer'}.'&key=1234'), true);

        $rrr = Customer::where('document', '=', $dataAccionista[0]{'document'})->exists();
        if (!$rrr){
          $customer = [
            'first_name'      =>  $dataAccionista[0]{'first_name'},
            'last_name'       =>  $dataAccionista[0]{'last_name'},
            'document'             =>  $dataAccionista[0]{'document'},
            'phone'           =>  $dataAccionista[0]{'phone'},
            'email'           =>  $dataAccionista[0]{'email'},
            'admission_date'  =>  "12-12-12",
            'modified_by'     =>  1
          ];
          $id_customer = Customer::create($customer)->id;
        }else { $id_customer = Customer::where('document', '=', $dataAccionista[0]{'document'})->get()[0]->id; }

      }else{
        $rrrr = Customer::where('document', '=', $r->customer{'documento'})->exists();
        if (!$rrrr){
          $customer = [
            'first_name'      =>  $r->customer{'nombre'},
            'last_name'       =>  $r->customer{'apellidos'},
            'document'             =>  $r->customer{'documento'},
            'phone'           =>  $r->customer{'telefono'},
            'email'           =>  $r->customer{'correo'},
            'admission_date'  =>  "12-12-12",
            'modified_by'     =>  1
          ];
          $id_customer = Customer::create($customer)->id;
        }else { $id_customer = Customer::where('document', '=', $r->customer{'documento'})->get()[0]->id; }
      }

      $password = bcrypt($r->customer{'clave'});

      $parent = $this->list($id_sponsor);

      $usernet = [
        'user'        =>  $r->customer{'usuario'},
        'password'    =>  $password,
        'id_customer' =>  $id_customer,
        'id_parent'   =>  $parent,
        'id_sponsor'  =>  $id_sponsor,
        'note'        => 'FALSE',
      ];

      $usernet_by = Red::create($usernet);

      return response()->json(["mensaje"   => $parent]);
    }


    public function getRedByLevel ($id, $nivel, $nivelStop)    {
         $a = [];
         $red =  Red::where('id_parent', '=', $id)->select('id')->orderBy('created_at', 'asc')->get();
         $nivel++;
         $contador=0;

         foreach ($red as $val)
         {
            $val->id;
            $contador++;
              $p = $this->obtenerPadre       ($val->id);
              $h = $this->obtenerCantChildren($val->id);

           if($h < 2){
               $b = $val->id;
             array_push($a, $b);
           }


             if($nivel!=$nivelStop){
               $Obj2 = $this->getRedByLevel($val->id,$nivel,$nivelStop);
               foreach ($Obj2 as $row2){
                   array_push($a,$row2);
               }
             }

         }
         return $a;
    }


   function list($id)
   {
     $valores = $this->getRedByLevel($id, 0, 10);
     $count =  Red::where('id_parent', '=', $id)->count();

     if($count < 2){
       return $id;

     }
     $fecha   = Red::whereIn('id',$valores)->min('created_at');
     $valor   = Red::where('created_at', '=',  $fecha)->select('id')->first();
     return $valor->id;
   }

    public function obtenerPadre       ($id){
      $parent =  Red::where('id', '=', $id)->select('id_parent')->orderBy('created_at', 'asc')->get();
      foreach ($parent as $val2){
        $cant = $val2->id_parent;
      }
      return $cant;
    }
    public function obtenerCantChildren($id){

      $cant =  Red::where('id_parent', '=', $id)->count();

			 return $cant;
    }



      // $id_parent = null;
      // $nivel   = 1;
      //
      //
      // dump('Hola --- '. $id);
      //
      // $datos =  Red::where('id_parent', '=', $id)->select('id')->orderBy('created_at', 'asc')->get();
      // if ($datos->count() < 2 ){         return  $id;     }
      //
      // else {
      //     ++$nivel;
      //     $evaluar = pow(2,$nivel);
      //     dump('evaluar '.$evaluar);
      //
      //       $Subdatos =  Red::whereIn('id_parent', $datos)->select('id')->orderBy('created_at', 'asc')->get();
      //       if ($Subdatos->count() < $evaluar){  dump('menos de 4'); $id_parent = $valor->id; }
      //       else {
      //         dump('id --- > '.$Subdatos[0]{'id'});
      //         $parent = $this->obtenerhijo($Subdatos[0]{'id'});
      //       }
      // }
      //
      //
      // return $id_parent;











  // public function obtenerhijo($id, $num){
  //
  // }


}
