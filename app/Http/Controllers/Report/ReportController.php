<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Ticket;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Classes\MainClass;
use App\Models\Customer\Customer;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use \stdClass;
use App\Models\General\Product_multiplied;
use App\Models\Books\Book;
use App\Models\Ticket\TicketDs;

class ReportController extends Controller
{
  public function __construct(){
		$this->middleware('auth');
	}

  public function ReportPermisos(){
    $a = new stdClass();

    $a->rTicket = false;
    $a->rClientes = false;
    $a->rProduct = false;

    return $a;
  }

  public function reportAcciones(){
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosReports();
    $permisover = $t->rTicket;
    $rolid = $t->rolid;

    if ($permisover == true || $rolid == 4){
    return view('Report.reportAccionistas',compact('main'));
    }else{
      return view('errors.403', compact('main'));
    }
  }
  public function getListAccionistas(){

    //   $accionistas = Book::where('status_system','=','true')
    //   ->join('customers','book.id','=', 'customers.id_customer')
    //   ->join('ticket','customers.nro_book','=','ticket.nro_book')
    //   ->join('ticketDs','ticket.id','=','ticketDs.id_ticket')
    //   ->select('customers.document','customers.last_name','customers.first_name',
    //   'customers.email','customers.phone','customers.id_country','book.id_customer',
    //   'SUM(CASE WHEN EXISTS'
    //   Product_multiplied::where('id_product_multiplied','=','ticketDs.id_product')
    //   (SELECT id_product_multiplied FROM phqbgkexy4.product_multiplied WHERE id_product_multiplied  = ticketDs.id_product )
    //   THEN
    //   ((book.cant)*11)
    //   ELSE
    //   (book.cant) end)' as cantidad_acciones')
    //   ->sum('book.cant')
    //   ->groupBy('book.id_customer','customers.id')
    //   ->orderBy('cantidad_acciones', 'desc')
    //   ->get();
    //
    //
    // return response()->json([
    //   "data"=>$accionistas
    // ]);
  }

    public function reportView()
    {
      $main = new MainClass();
      $main = $main->getMain();

      $t = $this->PermisosReports();
      $permisover = $t->rTicket;
      $rolid = $t->rolid;

      if ($permisover == true || $rolid == 4){
        return view('Report.report', compact('main'));
      }else{
        return view('errors.403', compact('main'));
      }
    }

//win is to getShareholder
public function orderWinIsToShareExcel()
  {
    $now = new \DateTime();
    $data = $this->orderWinIsToShare(){"sales"};
    $d = [];
    if($data == null)
    {
      $c = [
            'Dni' =>"No Hay Datos",
            'Nombre'=>"No Hay Datos",
            'Apellido' =>"No Hay Datos",
            'Correo'=>"No Hay Datos",
            'Celular'=>"No Hay Datos"
          ];
      array_push($d, $c);
      $list = collect($d);
    }
    else
    {
      foreach($data as $valor)
      {
          $c =
          [
            'Dni' =>$valor{'document'},
            'Nombre'=>$valor{'first_name'},
            'Apellido' =>$valor{'last_name'},
            'Pais' =>$valor{'country'},
            'Estado' =>$valor{'state'},
            'Cuidad' =>$valor{'city'},
            'Direccion' =>$valor{'adreess_1'},
            'Correo'=>$valor{'email'},
            'Celular'=>$valor{'phone'},
            'Producto'=>$valor{'nameProduct'},
            'Sku'=>$valor{'sku'},
            'Total'=>$valor{'total'},
            'Moneda'=>$valor{'money'},
            'FechaPago'=>$valor{'DatePay'},
            'FechaPago'=>$valor{'statusOrder'},
            'post'=>$valor{'post'},
          ];
          array_push($d, $c);
      }
    }

    $list = collect($d);
     return  (new FastExcel($list))->download('reporteVentasWinIsToShare'.$now->format('Y-m-d').'.xlsx');
  }

  public function orderWinIsToShare()
   {
     $data = json_decode(file_get_contents('https://winistoshare.com/API/ConeccionwinIsToShare/Conexion/sales.php?key=1234&action=getOrdersComplete'), true);
     return  $data;
   }
//-------------------------------------------------------------------------------------------------------------------------------------------------- inicio taxi win
//vista -->Reportes
  public function customerTaxiwin(Request $r)
  {
    $data = json_decode(file_get_contents('https://taxiwin.in/API/ConeccionTaxiWin/Conexion/reportSales.php?action='.$r->data.'&key=1234'), true);
    return response()->json([
        "mensaje"   => $data
      ]);
  }
//vista -->Registrat tiquet
public function getRedTaxiWin(Request $r)
{
  $data = json_decode(file_get_contents('https://taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?data='.$r->data.'&action=getCustomerRed&key=1234'), true);

  $dni = $data[0]{'document'};

  $dataRed = json_decode(file_get_contents('https://www.taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?key=1234&action=getCustomer&data='.$dni.''), true);

  $dataAccionista = json_decode(file_get_contents('http://winistoshare.com/API/ConeccionwinIsToShare/Conexion/customer.php?data='.$dni.'&key=1234'), true);

  $DatoCustomer =  Customer::where('status_system', '=', 'TRUE')
   ->where('document', '=', $dni)
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
 return response()->json(["mensaje"   => $datos, "data" => $resp ]);
}

public function customerWinIstoShareAndTaxiWin(Request $r)
{
  $DatoCustomer =  Customer::where('status_system', '=', 'TRUE')
   ->where('document', '=', $r->data)
   ->first();

  if ($DatoCustomer == null){
    $dataAccionista = json_decode(file_get_contents('https://www.taxiwin.in/API/ConeccionTaxiWin/Conexion/customer.php?key=1234&action=getCustomer&data='.$r->data.''), true);
    if (empty($dataAccionista)){
      $ch = curl_init('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$r->data);
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
         $valorDoc = explode("|", $dataReniec);

         $a = new stdClass();
         $a->first_name = $valorDoc[2];
         $a->last_name = $valorDoc[0].' '.$valorDoc[1];
         $a->phone = '';

         $resp = 'reniec';
         $datos = $a;

       } else {


         $datos = null;
         $resp = 'error';
       }
    }else{
      $resp = 'taxiwin';
      $datos = $dataAccionista[0];
    }
  }else{
    $datos = $DatoCustomer;
    $resp = 'bdwin';
  }

  return response()->json(["mensaje" => $datos, "dato" => $resp]);

}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------- fin taxi win
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------inicio de win is to share

//vista -->Reportes
  public function customerWinistoshare(Request $r)
  {
    $data = json_decode(file_get_contents('https://winistoshare.com/API/ConeccionwinIsToShare/Conexion/reportSales.php?action='.$r->data.'&key=1234'), true);
    return response()->json([
        "mensaje"   => $data
      ]);
  }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------fin de win is to share

//permisosReports
public function PermisosReports(){

  $rol = Main::where('users.id', '=', auth()->user()->id)
    ->where('main.status_user', '=', 'TRUE')
    ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
    ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
    ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
    ->join('users',    'users.id',              '=',   'rol_user.id_user')
    ->select('roles.id','rol_user.id as id_roluser')
    ->first();

  $roluser = $rol{'id_roluser'};

  $t = $this->ReportPermisos();

  $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                ->select('id_permission')
                ->get();

  foreach ($permissions as $rs) {
      if ($rs->id_permission == 8){
         $t->rTicket = true;
      }else if ($rs->id_permission == 17){
         $t->rClientes = true;
      }else if ($rs->id_permission == 24){
         $t->rProduct = true;
      }
  }

  $t->rolid = $rol{'id'};

  return $t;
}



}
