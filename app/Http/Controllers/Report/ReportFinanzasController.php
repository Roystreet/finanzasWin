<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Ticket;
use App\Models\Customer\Customer;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\General\pay;

class ReportFinanzasController extends Controller
{
    //
    public function reportTicketGenerate()
    {
      $t = Ticket::where('status_system', '=', 'TRUE')
      ->with('getMoney')
      ->get();
      // ->orderBy('created_at', 'DESC')->get();
      // ->with(
      // // 'getInvited',
      // // 'getCustomer',
      // 'getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
      // ->get();
      $a = [];
      foreach ($t as $key => $value) {
        $customer = $this->getCustomer_id($value->id_customer);
        $anfitron = $this->getCustomer_id($value->id_invited_by);
        $pay = $this->getPay($value->id_pay);
        if($value->donate)
        {
          $d = "DONADO";
        }
        else
        {
          $d = "NO ES DONADO";
        }
        $c = [
              "id" => $value->id,
              "ticket" => $value->cod_ticket,
              "DNI" =>$customer{'document'},
              "Nombres" =>$customer{'last_name'},
              "Apellidos" =>$customer{'first_name'},
              "Telefono" =>$customer{'phone'},
              "Correo" =>$customer{'email'},
              "Pais" =>$customer{'getCountry'}{'description'},
              "Capital" =>$customer{'getCity'}{'description'},
              "Cuidad" =>$customer{'getState'}{'description'},
              "NombreProducto" => $value->getproduct[0]->description,
              "TA" =>$value->total,
              "Moneda"=>$value->getmoney[0]->description,
              "Tipopago"=>$pay{'description'},
              "FechaPago" =>$value->date_pay,
              "Anfitrion" =>$anfitron{'last_name'}.",".$anfitron{'first_name'},
              "user_Anfitrion" =>$customer{'invited_user'},
              "Numero_Libro" =>$value->nro_book,
              "Observaciones" => $value->note,
              "Donado" => $d,
        ];
        array_push($a,$c);
      }
      $list = collect($a);
       return (new FastExcel($list))->download('list'.date("Y-m-d H:i:s").'.xlsx');
    }
    public function  getCustomer_id($id)
    {
      $data = Customer::where('id',$id)
      ->with('getState', 'getCity')
      ->first();
      return $data;
    }

    public function getPay($id)
    {
      return pay::where('id',$id)->first();
    }
///------------------------------
///------------------------------



}
