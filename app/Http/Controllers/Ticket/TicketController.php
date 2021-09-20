<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketDs;
use App\Models\General\Pay;
use App\Models\General\Money;
use App\Models\General\Status;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\city;
use App\Models\General\Banks;
use App\Models\General\User;
use App\Models\General\historical;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerType;
use App\Models\Customer\dtCustomerType;
use App\Models\Ticket\NumberBookSave;
use App\Models\Book\Book;
use App\Models\General\voucherimg;
use App\Classes\MainClass;
use App\Models\Product\Product;
use App\Models\Product\ProductAction;
use App\Models\Product\Price;
use App\Models\Book\File;
use \stdClass;
use Carbon\Carbon;


use App\Models\General\Rol_User;
use App\Models\GuestPayment\guestPayment;
use \PDF;
use Mail;

class TicketController extends Controller{

  public function __construct(){
		// $this->middleware('auth');
    // $this->middleware('role');
	}

  public function TicketPermisos(){
    $a = new stdClass();

    $a->activate = false;
    $a->create = false;
    $a->viewgeneral = false;
    $a->viewspecific = false;
    $a->edit = false;
    $a->delete = false;
    $a->reporte = false;
    $a->paymentBono = false;
    $a->printCert = false;
    $a->passthroughaction  = false;
    $a->historial = false;
    $a->download  = false;
    $a->details = false;
    $a->mytickets  = false;

    return $a;
  }

  public function index(){
    $main = new MainClass();
    $main = $main->getMain();
    $orderByAsc;
    $rol= Main::where('users.id', '=', auth()->user()->id)
      ->where('main.status_user', '=', 'TRUE')
      ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
      ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
      ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
      ->join('users',    'users.id',              '=',   'rol_user.id_user')
      ->select('roles.id')
      ->first();

      if ($rol->id == '1'){
        $orderByAsc = [1];
      }
      elseif ($rol->id == '2') {
        $orderByAsc = [2,3];
      }
      elseif ($rol->id == '6') {
        $orderByAsc = [2,7];
      }else{
        $orderByAsc = [1,2,3,4,5,6,7];
      }
    return view('ticket.index', compact( 'main'));
  }

  public function show($id){

    $ticket = Ticket::where('id','=',$id)->with('getCustomer','getCountryInv','getCountryCus','getStateCus','getCityCus','getInvited','getModifyBy', 'getTicketDs', 'getProduct',
           'getMoney', 'getPay','getGuestPayment', 'getStatus','getBanks')->first();


    $tkds = TicketDs::where('id_ticket',$id)->first();
    $propreci=$tkds->price;
    $tkdss =$tkds->id_product;
    $idpric = Price::where('id_product',$tkdss)->where('price',$propreci)->first();
    $pricenow = $idpric->id;
    $main = new MainClass();
    $main = $main->getMain();
    $countryinver = Country::where('status_user','=','TRUE')
    ->orderBy('description','ASC')
    ->pluck('description','id');

    $queryPays = Pay::where('pays.status_system', '=', 'TRUE')
    ->get();

    $queryMoneys = Money::where('moneys.status_system', '=', 'TRUE')
    ->get();

    $cantAccions = Product::where('id','=',$tkdss)->with('getProductAction')->first();

    $pricelist = Price::join('products', 'prices.id_product', '=', 'products.id')
                 ->join('moneys', 'prices.id_money', '=', 'moneys.id')
                 ->select(DB::raw("CONCAT(products.name_product,' ',prices.price,' ',moneys.description) AS idnameproduct"),"prices.id")
                 ->where('prices.status_user', '=', 1)
                 ->pluck('idnameproduct','prices.id');

          $moned = $idpric->id_money;
          if($moned == 1){
            $moned="PEN";
          }else{
            $moned="USD";
          }

$img = voucherimg::where('id_ticket','=',$id)->first();

    $gettipopay = Pay::where('status_user','=','TRUE')
    ->orderBy('name_pay','ASC')
    ->pluck('name_pay','id');

    $bankslist = Banks::where('status_user','=','TRUE')
    ->orderBy('name','ASC')
    ->pluck('name','id');

    $country = Country::where('status_system','=','TRUE')
    ->orderBy('description','ASC')
    ->pluck('description','id');
// dd($ticket->getStateCus[0]->id_country);
    $state = State::where('status_user','=','TRUE')
    ->where('id_country',$ticket->getCustomer->id_country)
    ->orderBy('description','ASC')
    ->pluck('description','id');

// dd($ticket->getCityCus[0]->id_state);
    $city = City::where('status_user','=','TRUE')
    ->where('id_state',$ticket->getCustomer->id_state)
    ->orderBy('description','ASC')
    ->pluck('description','id');
    // dd($ticket->getCountryCus[0]->description);

    /*if es para los que no tiene registro de fecha de pago
    y los que tienen registro se le agrega una T en la mitad
    para poder mostrar en el formulario datetime-local*/
    if($ticket->date_pay == null){
      $mytime =  Carbon::now();
      $ticket->date_pay = $mytime->format('Y-m-d\TH:i:s');
    }else{
    //Agregar al date en el espacio insertarle T
    $fecha = $ticket->date_pay;
    $a = explode(" ", $fecha);
    $fecha = $a[0]."T".$a[1];
    $ticket->date_pay = $fecha;
    }


    return view ("ticket.editarTicket", compact("ticket","main","countryinver","country","state","city","gettipopay","bankslist","img","queryMoneys","pricelist","pricenow","moned","cantAccions"));
  }

  public function cambiarproduct(){
    if(request()->id <> null){

      $id=intval(request()->id);

      $price = Price::join('products', 'prices.id_product', '=', 'products.id')
      ->join('product_actions','products.id','=','product_actions.id_product')
      ->where('prices.id',$id)->first();
      $moneda=Price::where('id',$id)->first();
      $moneda=$moneda->id_money;

      return response()->json([
        "price"    => $price,
        "money"    => $moneda
      ]);
    }else{
      $price =[
        'cod_product' => "Seleccione un producto",
        'name_product' => "Seleccione un producto",
        'cant' => "Seleccione un producto",
        'price' => "Seleccione un producto",
        'total' => "Seleccione un producto",
        'money' => "Seleccione un producto"
      ];
      $moneda="Seleccione un producto";
      return response()->json([
        "price"    => $price,
        "money"    => $moneda
      ]);
    }

  }

  public function editar(request $r, $id){
//limpiar date que viene del formulario quitarle la T


    $validator = Validator::make($r->all(),[

          'fechapago'=>'required',
          'tipago'=>'required|numeric',
          'painvertir'=>'required|numeric',
          'firstname'=>'required',
          'lastname'=>'required',
          'phone'=>'required|numeric',
          'email'=>'required|email',
          'country'=>'required|numeric',
          'state'=>'required|numeric',
          'idnameproduct'=>'required'
        ]);
        if ($validator->fails()) {
          $errors = $validator->errors()->all();
          return \Redirect::back()->withErrors($errors);
        }
    $ticket = Ticket::where('id',$r->id_ticket)
    ->with('getCustomer','getCountryInv','getCountryCus','getStateCus','getCityCus')
    ->first();
$id_c = $ticket->id_customer;
$id_t = $r->id_ticket;

//Antes de guardar hay que quitarle la T y dejarle un espacio en medio
$fecha = request()->fechapago;
$a = explode("T", $fecha);
$fecha = $a[0]." ".$a[1];

$id_ticket_act = [
  'date_pay'         => $fecha,
  'id_pay'           => request()->tipago,
  'id_country_invert'=> request()->painvertir,
  'id_banck'         => request()->id_banck,
  'number_operation' => request()->numopera,
  'note'             => request()->note,
  'obser_int'        => request()->obser_int,
  'modified_by'      => auth()->user()->id,
];
$ticket_act = ticket::find($id_t);
$ticket_act->update($id_ticket_act);

$ticketDsr = ticketDs::find($id_t);
$idproductk = $ticketDsr->id_product;
$ticketdsprice = $ticketDsr->price;

$id_price =$r->idnameproduct;
$price = Price::find($id_price);
$idproducprice = $price->id_product;
$priceprice = $price->price;

if(($idproductk == $idproducprice)&&($priceprice == $ticketdsprice)  ){

}else{
  $id_ticket_ds = [
      'id_product' => $price->id_product,
      'price' => $price->price,
      'id_money' => $price->id_money,
      'total' => $price->price,
  ];
$ticketDsr->update($id_ticket_ds);
}



$id_customer_act = [
    'first_name' => request()->firstname,
    'last_name'  => request()->lastname,
    'phone'      => request()->phone,
    'email'      => request()->email,
    'id_country' => request()->country,
    'id_state'   => request()->state,
    'id_city'    => request()->city,
];
$customer_act = Customer::find($id_c);
$customer_act->update($id_customer_act);

return redirect()->back()->with('message', 'Ticket ya fue actualizado!');
  }

  public function getTicketsAll()
  {
  return  $tickets = Ticket::where('status_system', '=', 'TRUE')
    ->Where('create_by', '=', auth()->user()->id)
    ->Where('status_user', '<>', 5)
    ->orderBy('created_at', 'DESC')
    ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus','getCreateBy')
    ->get();
  }

  public function myTickets(){
    $main = new MainClass();
    $main = $main->getMain();
    $orderByAsc;

    $t = $this->PermisosTickets();
    $permisover = $t->viewgeneral;
    $permisoverespe = $t->viewspecific;
    $permisocrear = $t->create;
    $permisodownload = $t->download;
    $permisodetails = $t->details;
    $rolid = $t->rolid;

      if ($rolid == '1'){
        $orderByAsc = [1];
      }
      elseif ($rolid == '2') {
        $orderByAsc = [2,3];
      }
      elseif ($rolid == '6') {
        $orderByAsc = [2,7];
      }else{
        $orderByAsc = [1,2,3,4,5,6,7];
      }

    if ($permisover == true || $rolid == 4 || $permisoverespe == true){
      return view('ticket.index', compact('main','permisocrear','rolid','permisover','permisoverespe','permisodownload','permisodetails'));
    }else{
      return view('errors.403', compact('main'));
    }
  }

  public function resgisterTicket(Request $r){
    $dt = new \DateTime();
    $invited = [
      'first_name'      =>  $r->customer{'name_inv'},
      'last_name'       =>  $r->customer{'lastname_inv'},
      'document'             =>  $r->customer{'dni_inv'},
      'admission_date'  =>  $dt->format('Y-m-d H:i:s'),
      'modified_by'     =>  auth()->user()->id,
      'status_user'     => 'FALSE'
    ];
    $invited_by = Customer::create($invited)->id;

    $customer = [
      'first_name'      =>  $r->customer{'first_name'},
      'last_name'       =>  $r->customer{'last_name'},
      'document'             =>  $r->customer{'document'},
      'phone'           =>  $r->customer{'phone'},
      'email'           =>  $r->customer{'email'},
      'id_country'      =>  $r->customer{'cod_country'},
      'id_state'        =>  $r->customer{'cod_state'},
      'id_city'         =>  $r->customer{'cod_city'},
      'address'         =>  $r->customer{'district'},
      'admission_date'  =>  $dt->format('Y-m-d H:i:s'),
      'modified_by'     =>  auth()->user()->id,
      'invited_by'      => $invited_by
    ];

    Customer::create($customer);



    return response()->json([
        "mensaje"=> $customer,
        "codTicket"=>"TK-".$this->getCodTicket()
      ]);

    }

    public function getProduct($id){
       return  DB::table('products')
                 ->join('product_actions', 'products.id', '=', 'product_actions.id_product')
                 ->join('moneys', 'moneys.id', '=', 'product_actions.id_money')
                 ->select('products.cod_product', 'products.id', 'products.description','products.name_product',
                 'moneys.id as money','product_actions.cant','product_actions.sale_price')
                  ->where('products.id', '=', $id)
                 ->get();
     }

  public function getProductid($id){

    $price = Price::where('id',$id)->first();
    $product = Product::where('id',$price->id_product)->with('getProductAction')->first();
    $money = Money::where('id',$price->id_money)->first();

    $datos1 = [
              'id'      => $id,
              'codigo'  => $product->cod_product,
              'nombre'  => $product->name_product,
              'cantidad'=> $product->getProductAction->cant,
              'precio'  => $price->price,
              'moneda'  => $money->description,
              'total'   => $price->price,
    ];


      return response()->json($datos1);
  }

  public function getShareholder(Request $r){
      $shareholder = Shareholder::where('info_',"like" , "%".$r->dato."%")->get();
      return response()->json(["shareholder"=>$shareholder]);
  }

  public function getProducts(){
    return DB::table('products')
          ->join('product_actions', 'products.id', '=', 'product_actions.id_product')
          ->join('moneys', 'moneys.id', '=', 'product_actions.id_money')
          ->select('products.cod_product', 'products.id', 'products.description','products.name_product',
          'moneys.description','product_actions.cant','product_actions.sale_price')
          ->get();
  }

  public function getCodTicket(){
    return DB::table('tickets')->max('id')+1;
  }

  function getMoney($f)
  {

      $b = Money::where("id","=",$f)->first();

    return   $b;
  }

  public function listProductos()
  {
    $pri = Price::all();
    $p = [];
    foreach ($pri as $key => $value)
    {
      $pro = Product::where('id',$value->id_product)
      ->with('getPrice','getProductAction')
      ->first();

       $a= new stdClass();
       $a->product = $pro;
       $a->moneda = $this->getMoney($value->id_money);
       $a->precio = $value;

      array_push($p, $a);
    }

    return $p;

  }

  public function getTicketDetails(){
      $id = request()->all();

      $queryT = Ticket::where('status_system', '=', 'TRUE')
      ->where('id', '=', $id)
      ->with('getCustomer','getInvited','getModifyBy', 'getTicketDs', 'getProduct',
             'getMoney', 'getCountryInv', 'getPay','getGuestPayment', 'getStatus','getBanks')
      ->first();

      $queryPays = Pay::where('pays.status_system', '=', 'TRUE')
      ->get();

      $queryMoneys = Money::where('moneys.status_system', '=', 'TRUE')
      ->get();

      $queryProducts = $this->listProductos();

      $valimg = voucherimg::where('status_system', '=', 'TRUE')
      ->where('id_ticket', '=', $id)
      ->first();

      $rol_user =  Rol_User::where('rol_user.id_user', '=', auth()->user()->id)
                   ->select('rol_user.id_role as idrol')
                   ->get();

      $dtz = date_default_timezone_set('America/Lima'); //Your timezone
      $fecha = date("Y-m-d");

      $datos = [
        'cod_ticket'        => $queryT->cod_ticket,
        'id_country_invert' => $queryT->getCountryInv->description,
        'id_pay'            => $queryT->getPay->name_pay,
        'id_banck'          => $queryT->getBanks ? $queryT->getBanks->name : '-',
        'id_payrec'         => $queryT->getPay->id,
        'number_operation'  => $queryT->number_operation,
        'date_pay'          => date("Y-m-d\TH:i", strtotime($queryT->date_pay)),
        'date_now'          => $fecha,
        'bono'              =>$queryT->getGuestPayment,
        'cod_product'       => $queryT->getProduct[0]{'cod_product'},
        'name_product'      => $queryT->getProduct[0]{'name_product'},
        'cant'              => $queryT->getTicketDs->cant,
        'price'             => $queryT->getTicketDs->price,
        'total'             => $queryT->getTicketDs->total,
        'id_money'          => $queryT->getMoney[0]{'description'},
        'name_inv'          => $queryT->getInvited ? $queryT->getInvited->first_name : '',
        'dni_inv'           => $queryT->getInvited ? $queryT->getInvited->document        : '',
        'phone_inv'         => $queryT->getInvited ? $queryT->getInvited->phone      : '',
        'nom_estado'        => $queryT->getStatus->description,
        'est_ticket'        => $queryT->getStatus->id,
        'productos'         => $queryProducts,
        'pays'              => $queryPays,
        'moneys'            => $queryMoneys,
        'valimg'            => $valimg,
        'rol'               => $rol_user[0]['idrol']
      ];

      if ($queryT->getGuestPayment !== null){
        $queryNamePays = Pay::where('pays.id', '=', $queryT->getGuestPayment->modo_pago)
        ->first();

        $queryNameMoneys = Money::where('moneys.id', '=', $queryT->getGuestPayment->tip_moneda)
        ->first();


        $datos += [
          'date_register_pay' => $queryT->getGuestPayment->fecha,
          'bono_direct'       => $queryT->getGuestPayment->bono_directo,
          'date_cobro'        => $queryT->getGuestPayment->fecha_cobro,
          'obser_pay'         => $queryT->getGuestPayment->observaciones,
          'obser_int'         => $queryT->obser_int,
          'modo_pay'          => $queryNamePays->name_pay,
          'namemoney'         => $queryNameMoneys->description
        ];
      }


			return  response()->json($datos);

  }

  public function pdfTicket($id){
   $queryT = Ticket::where('status_system', '=', 'TRUE')
   ->where('id', '=', $id)
   ->with('getCustomer','getInvited','getModifyBy', 'getTicketDs', 'getProduct',
          'getMoney', 'getCountryInv', 'getPay','getGuestPayment', 'getStatus')
   ->first();

   $queryNamePays    =  $queryT->getGuestPayment->modo_pago  ? Pay::where('pays.id', '=', $queryT->getGuestPayment->modo_pago)->first()        : '';
   $queryNameMoneys  =  $queryT->getGuestPayment->tip_moneda ? Money::where('moneys.id', '=', $queryT->getGuestPayment->tip_moneda)->first()   : '';

   $cabecera  = $queryT;
   $modo_pay  = $queryNamePays->name_pay;
   $namemoney = $queryNameMoneys->description;

   $pdf = PDF::loadView('ticket.imprimirticket', compact('cabecera','modo_pay','namemoney'));
   return $pdf->download('ticketPago.pdf');
  }

  //Obtenidos por roles y status
  public function getTicketcustomerID($id){
    $ticketsQuery;     $tickets = [];

    $url = request()->path();
    $url = explode("/",$url);
    $url = $url[0];

    $t = $this->PermisosTickets();
    //dd($t);
    $ticketsQuery = $this->PermisosVerTickets($t->mytickets,$id,$t->rolid);

    foreach ($ticketsQuery as $r) {

      $iconSt   = 'fa-check-square-o';

      $iconDelet = 'fa-trash-o';

      $action   = '<center>';
      $action  .= ($r->getStatus->id == '1'|| $t->rolid == '4')?'<a href="/ticket/editarTicket/'.$r->id.'"><i class="fa fa-edit" title="Editar ticket"></i> &nbsp;&nbsp;</a>': '';
      $action  .= ($r->getGuestPayment{'id_ticket'})?'<a href="/customers/pdfTicket/'.$r->id.'"><i class="fa fa-file-pdf-o" title="Descargar ticket BONO PAGADO"></i> &nbsp;&nbsp;</a>': '';

      $action  .= (!($r->getStatus->id == '1')|| ($t->activate == false && $t->rolid == '4'))? "":'<i class="fa fa-check" title="Activar"onclick="activarTicket('.$r->id.'); this.onclick=null;"></i>';

      $action  .= '<a href="/tickets/pdf/'.$r->id.'"><i class="fa fa-download" title="Descargar"></i></a>';

      $action  .= ($r->getStatus->id != '1' && $t->paymentBono == true || $r->getStatus->id != '1' && $t->rolid == '4') ?
                  '&nbsp;&nbsp;<a data-toggle="modal" data-target="#modal-ticket" data-id='.$r->id.' class="btn-ticket"><i class="fa fa-cog" title="Actualizar"></i></a>' : '';

      $action  .= ($r->getStatus->id == '1' && ($t->rolid == '4' || $t->rolid == '1') || $r->getStatus->id == '1' && $t->activate == true) ?
                  '&nbsp;&nbsp;<a data-toggle="modal" data-target="#modal-ticket" data-id='.$r->id.' class="btn-ticket"><i class="fa fa-cog" title="Actualizar"></i></a>' : '';

      $action  .= '<a data-toggle="modal" data-target="#modal-ticket" data-id='.$r->id.' class="btn-ticket"><i class="fa fa-delete"></i></a>';
      // $action  .= ($r->getStatus->id == '1' && ($t->rolid == '4' || $t->rolid == '1') || $r->getStatus->id == '1' &&  $t->delete == true) ?
      //             '&nbsp;&nbsp;<a statussis="5"  data-id="'.$r->id.'" id="statussis"><i class="fa '.$iconDelet.'" title="Eliminar Registro"></i></a>' : '';

      $action  .= '<a data-toggle="modal" data-target="#exampleModalCenter" data-id='.$r->id.' class="btn-ticket"><i class="fa fa-delete"></i></a>';
      $action  .= ($r->getStatus->id != '5' && ($t->rolid == '4' || $t->rolid == '1') && $r->getTicketDs->cant > 0 && $r->getStatus->id != '5' && $r->getStatus->id != '5' ||
                  $r->getStatus->id != '5' &&   $t->delete == true && $r->getTicketDs->cant > 0 && $r->getStatus->id != '5' && $r->getStatus->id != '1') ?
                  '&nbsp;&nbsp;<a numberbook="'.$r->nro_book.'"  data-id="'.$r->id.'" id="numberbook"><i class="fa '.$iconDelet.'" title="Eliminar ticket"></i></a>' : '';



      $action  .= '</center>';



      $download  = ( ($r->getStatus->id != '5' || $r->getStatus->id != '1')
                 &&   $t->rolid == '4' && $r->nro_book ||  ($r->getStatus->id != '5' || $r->getStatus->id != '1') && $r->nro_book && $t->printCert == true)?
                 '<center><a onclick="openCertBook()" data-id='.$r->id.' class="btn-certif"><i class="fa fa-download"></i></a></center>' : '';



      $ticket   = [
        'action'         => $action,
        'cod_ticket'     => $r->cod_ticket ?  $r->cod_ticket  : '-',
        'name_product'   => $r->getProduct[0]->{'name_product'} ? $r->getProduct[0]->{'name_product'}   : '-',
        'moneda'         => $r->getMoney ?  $r->getMoney[0]->description  : '-',
        'first_name'     => $r->getInvited ?                      '<u title="'.$r->getInvited->first_name.", ". $r->getInvited->last_name .'">'.$r->getInvited->first_name.'</u>'            : '-',
        'country'        => $r->getCountryInv ?                   $r->getCountryInv->description        : '-',
        'price'          => $r->getTicketDs->price ?              $r->getTicketDs->price                : '-',
        'id_banck'       => $r->getBanks                       ?  $r->getBanks->name               : '-',
        'money'          => $r->getProduct[0]->{'description'} ?  $r->getProduct[0]->{'description'}    : '-',
        'cant'           => $r->getProduct[0]->getProductAction->cant ?  $r->getProduct[0]->getProductAction->cant  : '0',
        'total'          => $r->getTicketDs->total,
        'statussis'      => $r->getStatus ?                       $r->getStatus->description  : '-',
        'nro_book'       => $r->nro_book ?                        $r->nro_book                : '-',
        'download'       => $download ?                           $download                   : '-',
        'username'       => $r->getModifyBy ?                     $r->getModifyBy->username   : '-',
        'id'             => $r->id,
        'note'           => $r->note,
        'obser_int'      => $r->obser_int,

      ];
      array_push($tickets, $ticket);

    }
    return response()->json(["data"=>$tickets]);
  }

  public function activacion(){
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosTickets();
    $activacion = $t->activate;
    $rolid = $t->rolid;

    if ($activacion == true || $rolid == 4){
      return view('ticket.activacion', compact('main'));
    }else{
      return view('errors.403', compact('main'));
    }

  }

  public function allTicketsAct (){
    $ticketsQuery;     $tickets = [];

    $ticketsQuery = Ticket::where('status_system', '=', 'TRUE')
       ->where('status_user', '=', '1')
       ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy','getCreateBy', 'getMoney','getCountryInv', 'getStatus')
       ->get();


    foreach ($ticketsQuery as $r) {

      $verCliente ='<a href=/customers/'.$r->getCustomer->id.'><i class="fa fa-cog" title="Detalles del Cliente"></i></a>';
      $iconSt     = 'fa-check-square-o';
      $action   = '<center>';
      $action  .= '&nbsp;&nbsp;<a statussis="2"  data-id="'.$r->id.'" id="statussis"><i class="fa '.$iconSt.'" title="Aprobar Registro"></i></a>';
      $action  .= '</center>';
      $precioMoney  =  $r->getMoney ? $r->getMoney[0]->symbol : '';
      $precioMoney  .= $r->getTicketDs->price ?              $r->getTicketDs->price  : ' ';

      $ticket   = [
        'action'         => $action,
        'verCliente'     => $verCliente,
        'cod_ticket'     => $r->cod_ticket ?                      $r->cod_ticket                        : '-',
        'name_product'   => $r->getProduct[0]->{'name_product'} ? $r->getProduct[0]->{'name_product'}   : '-',
        'first_name'     => $r->getCustomer ?                     $r->getCustomer->last_name.' '.$r->getCustomer->first_name            : '-',
        'country'        => $r->getCountryInv ?                   $r->getCountryInv->description        : '-',
        'price'          => $precioMoney, //$r->getTicketDs->price ?              $r->getTicketDs->price.' '.($r->getMoney ? $r->getMoney->symbol : '' )                : '-',
        'cant'           => $r->getTicketDs->cant,
        'total'          => $r->getTicketDs->total,
        'statussis'      => $r->getStatus ?                       $r->getStatus->description  : '-',
        'nro_book'       => $r->nro_book ?                        $r->nro_book                : '-',
        'username'       => $r->getCreateBy ?                     $r->getCreateBy->username   : '-',
        'id'             => $r->id,
      ];
      array_push($tickets, $ticket);

    }
    return response()->json(["data"=>$tickets]);
  }

  public function viewVoucherIDt($id){
   $queryT = voucherimg::where('status_system', '=', 'TRUE')
   ->where('id_ticket', '=', $id)
   ->first();
   return response()->json($queryT);
  }

  public function getImprimirCertIDTicket($city,$id,$date,$letras){

    $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
               'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    $respuesta = true;
    $month = "indefinido";
    $m = date("m", strtotime($date));
    $d = date("d", strtotime($date));
    $y = date("Y", strtotime($date));
    $month = $meses[$m-1];

   $queryT = Ticket::where('status_system', '=', 'TRUE')
   ->where('id', '=', $id)
   ->with('getCustomer','getInvited','getModifyBy', 'getTicketDs', 'getProduct',
          'getMoney', 'getCountryInv', 'getPay','getStatus')
   ->first();

   $book = book::where('nro_book',$queryT->nro_book)->first();
   $book->cant_print_book = $book->cant_print_book +1;
   $book->save();
   $payBono = guestPayment::where('id_ticket', '=', request()->id)->exists();
   if($queryT->status_user == '2' || $queryT->status_user == '7'){
      $ticket = Ticket::findOrFail(request()->id);
      $ticket->status_user = $payBono ? '4' : '3';
      $ticket->save();
   }
   $product  = $queryT->getProduct ? $queryT->getProduct[0]->id : '-';
   $product  = ProductAction::where('id_product', '=', $product)->first();
   $cantidad = $product->cant;
 if($cantidad == 1||$cantidad == 5 || ($cantidad==10 && (132 <> $queryT->getProduct[0]->id) ) ||$cantidad==20)
   $cantidad = $cantidad*11;
//colocar producto si es igual a cant 1,5,10,20 para q no lo multiplique
if(97 == $queryT->getProduct[0]->id ||98 == $queryT->getProduct[0]->id ||99 == $queryT->getProduct[0]->id || 90 == $queryT->getProduct[0]->id || 105 == $queryT->getProduct[0]->id || 116 == $queryT->getProduct[0]->id)
{
	 $cantidad = $product->cant;
}

   $cantidad = str_pad($cantidad, 2, "0", STR_PAD_LEFT);
   if ($cantidad == 1){
     $valor1=$cantidad*7;     $valor2=$valor1*10;
   }else {
     $valor1=$cantidad*5;     $valor2=$valor1*10;
   }

    // $valor1=$cantidad*11;     $valor2=$valor1*11;
   if(91 == $queryT->getProduct[0]->id || 84 == $queryT->getProduct[0]->id || 88 == $queryT->getProduct[0]->id || 89 == $queryT->getProduct[0]->id
	|| 95 == $queryT->getProduct[0]->id || 97 == $queryT->getProduct[0]->id ||98 == $queryT->getProduct[0]->id ||99 == $queryT->getProduct[0]->id)
	{
		$letras =  0;
	}
else
{
	$letras = 1;
}


   $cabecera  = $queryT->getCustomer ? $queryT->getCustomer : '-';
   $fecha     = $queryT->updated_at  ? $queryT->updated_at  : '-';
   $nro       = $queryT->nro_book    ? $queryT->nro_book    : '-';
   $modo_pay  = $queryT->getPay      ? $queryT->getPay->name_pay : '-';
   $namemoney = $queryT->getMoney    ? $queryT->getMoney[0]{'description'} : '-';

      $pdf = PDF::loadView('customer.imprimirCertificado', compact('letras','cabecera'
      ,'cantidad', 'nro','fecha','modo_pay','namemoney','city','month','d','y','respuesta','valor1','valor2'));
      $pdf->setPaper('A4', 'landscape')->setWarnings(false);

      return $pdf->download($queryT->cod_ticket. '- Certificado N°'.$queryT->nro_book.'.pdf');

  }

  public function saveNumberBook(){
    if (request()->ajax( )){
      $ticket  =  Ticket::findOrFail(request()->id);
      $nrobooks = request()->numberbook;

      try{
        DB::beginTransaction();

        if(Book::where('nro_book',$nrobooks)->exists())
        {
          $books = Book::where('nro_book',$nrobooks)->first();
          $booksa = Book::findOrFail($books->id);
          if(file::where('id_book',$books->id)->exists())
          {
            $f = file::where('id_book',$books->id)->first();
            $f->delete();
          }

          $booksa->delete();
        }

        $numberbooksaves = [
          'number_book' => $nrobooks,
          'modified_by' => auth()->user()->id
        ];
        // if($ticket->status_user = 5) // Se cambio la logica porque el campo nro_book en la tabla ticket AHORA es UNICO (para que entre cuando el estatus es INACTIVO '5')
        if($ticket->nro_book != null || $ticket->nro_book >0){
          NumberBookSave::create($numberbooksaves);
        }

        $id_customer = $ticket->id_customer;// <---- EL ID DEL CUSTOMER
        // $ticket->nro_book    = 0;
        $ticket->status_user = 5;
        $ticket->nro_book    = null; //Cambio a null porque el campo nro_book en la tabla ticket AHORA es UNICO
        $ticket->save();



        DB::commit();
      }catch(\Exception $e){  dump($e);  DB::rollback(); }
      $mensaje;
      $mensaje = 'El Ticket N° '.$ticket->cod_ticket.' ha sido eliminado de forma satisfactoria';

      // CAMBIAR ESTATUS DEL CUSTOMER SEGUN SI TENGA TICKET CON ESTATUS DIFERENTES A 5 (INACTIVO)

          $alltickets = Ticket::where('id_customer','=',$id_customer)->get();// Consulta todos los ticket de ese ID_CUSTOMER
          $count=0;
         foreach ($alltickets as $key => $value) {//recorro todos los ticket de ese ID_CUSTOMER
              $cambiarstatus = Customer::where('id','=',$id_customer)->first();//busco el customer_id
               if( $value->status_user == 5 ){
                 $count++;//aumenti 1
                 if($count==count($alltickets)){
                  $cambiarstatus->status_system = 0;
                  $cambiarstatus->save();
                  break;
                  }
               }else{
                 $cambiarstatus->status_system = 1;
                 $cambiarstatus->save();
                 break;
               }
         }
// FIN   CAMBIAR ESTATUS DEL CUSTOMER SEGUN SI TENGA TICKET CON ESTATUS DIFERENTES A 5 (INACTIVO)


      return response()->json([
          "mensaje"       => $mensaje
        ]);

    }

  }

  public function updatePays(){
    if (request()->ajax( )){
      $ticketdetalle = Ticket::findOrFail(request()->id);
      $ticketdetalle->date_pay = request()->data{'fecha_pay'}.".0000-05";
      $ticketdetalle->id_pay = request()->data{'pays_rec'};
      if (isset(request()->data{'number_ope_pay'})){
        $ticketdetalle->number_operation = request()->data{'number_ope_pay'};
      }else{
        $ticketdetalle->number_operation = "";
      }
      $ticketdetalle->save();
      return response()->json([
          "mensaje"       => "success"
      ]);
    }
  }

  public function updateStatus(){
   if (request()->ajax( )){
     $ticketdeta = Ticket::where('id',request()->id)
                   ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
                   ->first();
     $ticket     = Ticket::findOrFail(request()->id);
     $customer   = Customer::findOrFail($ticket->id_customer);
     $id_product = $ticket->getTicketDs->id_product;
     $product    = ProductAction::where('id_product', '=', $id_product )->first();

     $numberbooksave = NumberBookSave::where('status_system', '=', 'TRUE')
     ->where('status_user', '=', 'TRUE')
     ->first();

     try{
       DB::beginTransaction();
         $TicketCount = Book::max('nro_book');

         $ticket->status_user = $product->cant > 0 ?  request()->status : '2' ;
         if ($numberbooksave !== null){
           $updatenumberbook = NumberBookSave::findOrFail($numberbooksave->id);
           $ticket->nro_book    = request()->status == 2 && $product->cant > 0 ? $numberbooksave->number_book : null;
           $numberbook = request()->status == 2 && $product->cant > 0 ? $numberbooksave->number_book : null;
           $updatenumberbook->status_user = false;
           $updatenumberbook->status_system = false;
           $updatenumberbook->save();
         }else{
           $ticket->nro_book    = request()->status == 2 && $product->cant > 0 ? $TicketCount +1 : null ;
           $numberbook = request()->status == 2 && $product->cant > 0 ? $TicketCount +1 : null ;
         }
         $ticket->modified_by = auth()->user()->id;
         $ticket->save();

         $customer->status_user = 6 ;
         $customer->save();

         $booksave = [
           'nro_book' => $numberbook,
           'id_customer' => $ticketdeta->id_customer,
           'cant' => $ticketdeta->getProduct[0]->getProductAction->cant,
           'cant_print_book' => 0,
           'created_by' => auth()->user()->id,
           'id_ticket' => $ticketdeta->id
         ];
         if($ticketdeta->getProduct[0]->getProductAction->cant>0)
         $booksaves = Book::create($booksave);

         if (request()->status == 2){
           // $this->checkoutpdf(request()->id);
         }

       DB::commit();
     }catch(\Exception $e){  dump($e);  DB::rollback(); }
     $mensaje;
     $mensaje = 'El Ticket N° '.$ticket->cod_ticket.' ha sido actualizado de forma satisfactoria ';


     return response()->json([
         "mensaje"       => $mensaje
       ]);
     }
  }
public function enviarcorreo(){

  $ticket = Ticket::where('id', '=', request()->id)
  ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus','getPay','getBanks')
  ->first();
  $a = array('num' =>1);
  $s = $ticket->getCustomer->email;
  $message='cualquier cosa';

  $cabecera         = $this->getTicket_id($ticket->id);
  $pay              = $ticket->getPay->name_pay;
  $banks            = $ticket->getBanks     ? $ticket->getBanks->name : '-';
  $city             = $this->getCitys   ($ticket->getCustomer->id_city   ) ? $this->getCitys   ($ticket->getCustomer->id_city   )->description : '-';
  $state            = $this->getStates  ($ticket->getCustomer->id_state  ) ? $this->getStates  ($ticket->getCustomer->id_state  )->description : '-';
  $country          = $this->getCountrys($ticket->getCustomer->id_country) ? $this->getCountrys($ticket->getCustomer->id_country)->description : '-';

  $countryinvert    = $this->getCountrys($ticket->id_country_invert) ? $this->getCountrys($ticket->id_country_invert)->description : '';
  $detalleprod      = $this->getProduct($ticket->getProduct[0]->id);

  $datoticket= $ticket->cod_ticket.' ';
  $datoticket .= $ticket->getCustomer->last_name.' ';
  $datoticket .= $ticket->getCustomer->first_name;

if(request()->external){
  $fechaemi = date("Y-m-d", strtotime($ticket->created_at));

  $e = array("nombre"    => $ticket->getCustomer->first_name ,
             "apellido"  => $ticket->getCustomer->last_name ,
             "codticket" => $ticket->cod_ticket,
             "pay"       => $pay,
             "dateemi"   => $fechaemi,
             "document"  => $ticket->getCustomer->document,
             "phone"     => $ticket->getCustomer->phone,
             "email"     => $ticket->getCustomer->email,
             "regis"     => 'Registro y activacion por pago via Culqi',
             "observacion"=> $ticket->note);



  $f = 'sistemas@winhold.net';
  Mail::send('external.inicio.sales.sendticketfinanza', compact('e'),function($message) use ($f)
  {
    $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
    $message->to($f)->subject('Aviso! Se ha realizado Registro y Activacion de compra de producto via Culqi');
  });
}

Mail::send('ticket.ticketemail',$a,function($message) use ($s,$ticket,$country,$state,$city,$cabecera,$pay,$detalleprod,$banks)
{
$pdf = PDF::loadView('customer.imprimir',compact('ticket', 'country', 'state', 'city', 'pay','detalleprod','banks'));
  $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
  $message->to($s)->subject('Activacion de ticket N°'.$ticket->cod_ticket);
  $message->attachData($pdf->output(), $ticket->cod_ticket.".pdf");
});


  return response()->json([
      "mensaje"=> "Enviado el correo"
    ]);

}
  public function checkoutpdf($id){

     $ticket = Ticket::where('id',$id)
              ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
              ->first();

      $monto = $ticket->total;

      $cabecera         = $this->getTicket_id($id);
      $pay              = $this->getPay              ($cabecera->id_pay);

      $city             = $this->getCitys   ($ticket->getCustomer->id_city   ) ? $this->getCitys   ($ticket->getCustomer->id_city   )->description : '-';
      $state            = $this->getStates  ($ticket->getCustomer->id_state  ) ? $this->getStates  ($ticket->getCustomer->id_state  )->description : '-';
      $country          = $this->getCountrys($ticket->getCustomer->id_country) ? $this->getCountrys($ticket->getCustomer->id_country)->description : '-';

      $countryinvert    = $this->getCountrys($cabecera->id_country_invert) ? $this->getCountrys($cabecera->id_country_invert)->description : '';
      $detalleprod      = $this->getProduct($ticket->getProduct[0]->id);

        $fechaemi = date("Y-m-d", strtotime($ticket->created_at));

        $a = array("nombre" => $ticket->getCustomer->first_name , "apellido"=> $ticket->getCustomer->last_name , "codticket" => $ticket->cod_ticket, "pay" => $pay->name_pay, "dateemi" => $fechaemi,"document" => $ticket->getCustomer->document);
        $s = $ticket->getCustomer->email;
        Mail::send('external.inicio.sales.sendticket',$a,function($message) use ($s,$ticket,$country,$state,$city,$cabecera,$pay,$detalleprod)
        {
          $pdf = PDF::loadView('customer.imprimir',compact('ticket', 'country', 'state', 'city', 'cabecera', 'pay','detalleprod'));
          $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
          $message->to($s)->subject('Registro exitoso');
          $message->attachData($pdf->output(), $ticket->cod_ticket.".pdf");
        });

        return true;

  }

  public function getPay($id)
  {
    return  DB::table('pays')
     ->where('id', '=', $id)->first();
  }

  public function getCustumer($id)
  {
    return  DB::table('customers')
     ->where('id', '=', $id)->first();
  }

  public function getCitys($id)
  {
    return  DB::table('city')
     ->where('id', '=', $id)->first();
  }

  public function getStates($id)
  {
    return  DB::table('state')
     ->where('id', '=', $id)->first();
  }


  public function getCountrys($id)
  {
    return  DB::table('country')
     ->where('id', '=', $id)->first();
  }






  ///actulizar tickets
  public function updateTicket(Request $r){
    $ticket = Ticket::fint($id);
    $ticket->id_country_invert;
  }

  public function reporte() {
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosTickets();
    $permisover = $t->viewgeneral;
    $permisoverespe = $t->viewspecific;
    $permisocrear = $t->create;
    $rolid = $t->rolid;
    $customer       =  Customer::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "customers.id as id")
                      ->where('customers.status_system','=',TRUE)
                      ->orderBy('name',  'ASC')
                      ->pluck( '(last_name||" " ||first_name)as name', 'customers.id as id');

    $product       = Product::select(DB::raw("UPPER(CONCAT(cod_product, ' - ', description)) AS name"), "id")->where('status_system', '=', 'TRUE')
    ->orderBy('cod_product',  'ASC')
    ->pluck( '(cod_product||" " ||description)as name', 'id');


    $pay           = Pay::orderBy('name_pay', 'ASC')->pluck('name_pay', 'id');
    $country       = Country::orderBy('description', 'ASC')->pluck('description', 'id');
    $modified_by   = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');
    $status        = Status::select(DB::raw("UPPER(description) AS description"), "id")->where('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');

    $money         = Money::orderBy('description', 'ASC')->pluck('description', 'id');


    if ($permisover == true || $rolid == 4 || $permisoverespe == true){
      return view('ticket.reporte', compact('main', 'customer', 'pay', 'country', 'modified_by', 'status', 'money', 'product','permisocrear','rolid','permisover','permisoverespe'));
    }else{
      return view('errors.403', compact('main'));
    }
  }

  public function getDataTickets() {

    $start_datec    = request()->start_datec ? request()->start_datec." 00:00:00.0000-05" : null;
    $end_datec      = request()->end_datec   ? request()->end_datec." 23:59:59.0000-05"   : null;

    $start_datep     = request()->start_datep ? request()->start_datep." 00:00:00.0000-05" : null;
    $end_datep       = request()->end_datep   ? request()->end_datep." 23:59:59.0000-05"   : null;


    $id_pay          = request()->datos{'id_pay'};
    $id_customer     = request()->datos{'id_customer'};
    $id_invited_by   = request()->datos{'id_invited_by'};
    $modified_by     = request()->datos{'modified_by'};
    $id_country_inv  = request()->datos{'id_country_inv'};
    $status_user     = request()->datos{'status_user'};


    $num_ticket      = request()->datos{'num_ticket'};
    $num_ticket      = strtoupper($num_ticket);
    $num_libro       = request()->datos{'num_libro'};


    $tickets = Ticket::query();


    //filtrar ticket por rol y permisos
    $t = $this->PermisosTickets();

    if (($t->mytickets == false || $t->rolid ==  4)){
      if ($num_ticket) $tickets->Where('cod_ticket', 'LIKE', '%' . $num_ticket . '%')->Where('status_user','<>',5);
      if ($modified_by)$tickets->Where('create_by' ,'=', $modified_by)->Where('status_user','<>',5);
      if ($id_pay)                  $tickets->Where('id_pay','=',$id_pay)->Where('status_user','<>',5);
      if ($id_customer)             $tickets->Where('id_customer','=',$id_customer)->Where('status_user','<>',5);
      if ($id_invited_by)           $tickets->Where('id_invited_by','=',$id_invited_by)->Where('status_user','<>',5);
      if ($id_country_inv)          $tickets->Where('id_country_invert','=', $id_country_inv)->Where('status_user','<>',5);
      if ($status_user)             $tickets->Where('status_user','=',$status_user);
      if ($num_libro)               $tickets->Where('nro_book',   '=', $num_libro)->Where('status_user','<>',5);
      if ($start_datec && $end_datec)  $tickets->WhereBetween('created_at', [$start_datec, $end_datec])->Where('status_user','<>',5);
      if ($start_datep && $end_datep)  $tickets->WhereBetween('date_pay', [$start_datep, $end_datep])->Where('status_user','<>',5);
    }else {
      if ($num_ticket) $tickets->Where('cod_ticket', 'LIKE', '%' . $num_ticket . '%')->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($modified_by) $tickets->Where('create_by' ,'=', $modified_by)->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($id_pay)                  $tickets->Where('id_pay','=',$id_pay)->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($id_customer)             $tickets->Where('id_customer','=',$id_customer)->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($id_invited_by)           $tickets->Where('id_invited_by','=',$id_invited_by)->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($id_country_inv)          $tickets->Where('id_country_invert','=', $id_country_inv)->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($status_user)             $tickets->Where('status_user','=',$status_user)->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($num_libro)               $tickets->Where('nro_book',   '=', $num_libro)->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($start_datec && $end_datec)  $tickets->WhereBetween('created_at', [$start_datec, $end_datec])->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
      if ($start_datep && $end_datep)  $tickets->WhereBetween('date_pay', [$start_datep, $end_datep])->Where('create_by', '=', auth()->user()->id)->Where('status_user','<>',5);
    }




    $tickets = $tickets->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus', 'getPay','getBanks')->get();
    $ticketsAll = [];
    foreach ($tickets as $r) {
      $date = new \DateTime($r->created_at);
      $cantidad= '-';
      if ($r->getProduct[0]->{'id'}) $cantidad = ProductAction::where('id_product', '=',$r->getProduct[0]->{'id'})->first()->cant;
      $comision =  guestPayment::where('id_ticket', '=',$r->id)->first();

      if ($comision){
        $id_pay_inv = Pay::findOrFail($comision->modo_pago)->name_pay;
        $total_inv  = $comision->bono_directo;
        $fecha_inv  = $comision->fecha;
        $resp_inv   = User::findOrFail($comision->id_user_register)->username;
        $observ_inv = $comision->observaciones;
        $fecha_cobro= $comision->fecha_cobro;
      }

      $ticket   = [
        'idticket'         => $r->id,
        'code_ticket'      => $r->cod_ticket,
        'customerid'       => $r->getCustomer->id,
        'name'             => $r->getCustomer  ? strtoupper($r->getCustomer->first_name) :'-',
        'lastname'         => $r->getCustomer  ? strtoupper($r->getCustomer->last_name)  :'-',
        'document'              => $r->getCustomer  ? $r->getCustomer->document   : '-',

        'id_product'       => $r->getProduct     ? $r->getProduct[0]->name_product : '-',
        'cant_acc'         => $cantidad > 0 ? $cantidad : 'NO APLICA',
        'id_pay'           => $r->getPay  ? $r->getPay->name_pay :'-',
        'number_operation' => $r->number_operation ? $r->number_operation : '-',
        'id_banck'          => $r->getBanks ? $r->getBanks->name : '-',
        'id_money'         => $r->getMoney         ? $r->getMoney[0]->description : '-',
        'total'            => $r->total            ? $r->total : '-',
        'created_at'       => $date->format('Y-m-d H:i'),
        'date_pay'         => $r->date_pay,

        'name_inv'         => $r->getInvited  ? strtoupper($r->getInvited->first_name) :'-',
        'lastname_inv'     => $r->getInvited  ? strtoupper($r->getInvited->last_name)  :'-',
        'dni_inv'          => $r->getInvited  ? $r->getInvited->document   : '-',

        'id_pay_inv'       => $comision ? $id_pay_inv : '-',
        'total_inv'        => $comision ? $total_inv  : '-',
        'fecha_inv'        => $comision ? $fecha_inv  : '-',
        'resp_inv'         => $comision ? strtoupper($resp_inv)   : '-',
        'observ_inv'       => $comision ? strtoupper($observ_inv)   : '-',
        'fecha_cobro'      => $comision ? $fecha_cobro  : '-',


        'num_libro'        => $r->nro_book  ? $r->nro_book   : '-',
        'pais_inv'         => $r->getCountryInv  ? $r->getCountryInv->description   : '-',
        'note'             => $r->note,
        'donate'           => $r->donate == true  ? 'SI'  : 'NO',
        'status_user'      => $r->getStatus       ? $r->getStatus->description : '-',

        'modified_by'      => $r->getModifyBy  ? strtoupper($r->getModifyBy->username)   : '-',
        'downloadticket'   => $t->download || $t->rolid = 4  ? true   : false,
        'detailsticket'    => $t->details || $t->rolid = 4  ? true   : false,
      ];
      array_push($ticketsAll, $ticket);
    }

    return response()->json([
      'data'     =>  $ticketsAll,
    ]);

  }
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------actulizacion de tickets
  public function indexEdit()
  {
    $main = new MainClass();
    $main = $main->getMain();

    $t = $this->PermisosTickets();
    $traspaso = $t->passthroughaction;
    $rolid = $t->rolid;

    if ($traspaso == true || $rolid == 4){
      return view('ticket.listTicket',compact('main'));
    }else{
      return view('errors.403', compact('main'));
    }
  }

  public function getTicketAll()
  {
    $t = Ticket::where('status_system', '=', 'TRUE')
    ->orderBy('created_at', 'DESC')
    ->with('getInvited','getCustomer','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
    ->get();
    return $t;
  }

  public function updateTicket_id()
  {
    $queryT = Ticket::where('status_system', '=', 'TRUE')
    ->where('id', '=', request(){'id_ticket'})
    ->first();
    $fecha = date('Y-m-d H:i:s');

    $historial = [
      'id_ticket' => request(){'id_ticket'},
      'id_customer_ant' => $queryT->id_customer,
      'id_customer_act' => request(){'id_customer'},
      'fecha' => $fecha,
      'modified_by' => auth()->user()->id
    ];
    $create = Historical::create($historial);


    $t = Ticket::findOrFail(request(){'id_ticket'});
    $t->id_customer = request(){'id_customer'};
    // $t->id_invited_by = "algo";
    // $t->note= "algo";
    $t->modified_by = auth()->user()->id;
    $t->save();
    return $t;
  }

  public function viewEdidticket($id)
  {
    $main = new MainClass();
    $main = $main->getMain();
    return view('ticket.edit',compact('main',"id"));
  }

  public function getTicket_id()
  {
    $id = request(){'id'};
    $t = Ticket::where('id',$id)
    ->with('getCustomer','getInvited')->first();

    return $t;

  }

  public function getCustomer_id()
  {

    $c = Customer::where('document','like', request(){'term'}.'%')->get();
    $s = [];
    foreach ($c as $key => $value) {
      // code...
      $v = [  "value" => $value->id,
        "label"=>$value->last_name.", ".$value->first_name."(".$value->email." - ".$value->document.")",
        "desc"=> $value->document];
        array_push($s,$v);
    }

    return $s;
  }

  //Funcion para ver tickets por permisos
  public function PermisosVerTickets($permiso,$id,$rol){
    if ($rol == 4 || $permiso == false){
       $ticketsQuery = Ticket::where('status_system', '=', 'TRUE')
       ->where('id_customer', '=', $id)
       ->where('status_user', '<>', 5)
       ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus','getGuestPayment','getBanks','getPay','getMoney')
       ->get();
    } else {
      $ticketsQuery = Ticket::where('status_system', '=', 'TRUE')
       ->where('id_customer', '=', $id)
       ->where('status_user', '<>', 5)
       ->Where('create_by', '=', auth()->user()->id)
       ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus','getGuestPayment','getBanks','getPay','getMoney')
       ->get();
    }
    return  $ticketsQuery;
  }

  public function PermisosTickets(){
    $rol = Main::where('users.id', '=', auth()->user()->id)
      ->where('main.status_user', '=', 'TRUE')
      ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
      ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
      ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
      ->join('users',    'users.id',              '=',   'rol_user.id_user')
      ->select('roles.id','rol_user.id as id_roluser')
      ->first();

    $roluser = $rol{'id_roluser'};

    $t = $this->TicketPermisos();

    $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                  ->select('id_permission')
                  ->get();

    foreach ($permissions as $rs) {
        if ($rs->id_permission == 3){
           $t->viewgeneral = true;
        }else if ($rs->id_permission == 1){
           $t->activate = true;
        }else if ($rs->id_permission == 7){
           $t->paymentBono = true;
        }else if ($rs->id_permission == 2){
           $t->create = true;
        }else if ($rs->id_permission == 4){
           $t->viewspecific = true;
        }else if ($rs->id_permission == 5){
           $t->edit = true;
        }else if ($rs->id_permission == 6){
           $t->delete = true;
        }else if ($rs->id_permission == 8){
           $t->reporte = true;
        }else if ($rs->id_permission == 11){
           $t->printCert = true;
        }else if ($rs->id_permission == 18){
           $t->passthroughaction  = true;
        }else if ($rs->id_permission == 19){
           $t->historial  = true;
        }else if ($rs->id_permission == 26){
           $t->download  = true;
        }else if ($rs->id_permission == 27){
           $t->details  = true;
        }else if ($rs->id_permission == 35){
          $t->mytickets  = true;
        }
    }

    $t->rolid = $rol{'id'};

    return $t;
  }

  public function customerTransferir(Request $r){
       $idBook = request()->data{'id_book'};
       $nrobook = request()->data{'nroBook'};
       $idcustomeract = request()->data{'customer_act'};
       $idcustometras = request()->data{'customer_trans'};
       $queryT = Ticket::where('nro_book', '=', $nrobook)
       ->first();
       $idticket = $queryT->id;

       $t = Ticket::findOrFail($idticket);
       $t->id_customer = $idcustometras;
       $t->modified_by = auth()->user()->id;
       $t->save();

       $b = Book::findOrFail($idBook);
       $b->id_customer = $idcustometras;
       $b->modified_by = auth()->user()->id;
       $b->save();

       $fecha = date('Y-m-d H:i:s');

       $historial = [
         'id_ticket' => $idticket,
         'id_customer_ant' => $idcustomeract,
         'id_customer_act' => $idcustometras,
         'fecha' => $fecha,
         'modified_by' => auth()->user()->id
       ];
       $create = Historical::create($historial);

       return response()->json([
         'data' => "exito",
       ]);
  }

  function updateNota()
  {
    $t = ticket::where('id',request()->id)->first();

    $b = book::where('nro_book',$t->nro_book)->first();
    $b->note = request()->note;
    $b->save();
    return response()->json([
      'object' => "success"
    ]);
  }

  function getBook()
  {
    $t = ticket::where('id',request()->id)->first();

    $b = book::where('nro_book',$t->nro_book)->first();
    return response()->json([
      'object' => "success",
      'data' =>$b
    ]);
  }

  function saveFile()
  {
    if(File::where('id_book',request()->data{'id_book'})->where('id_customer',request()->data{'id_customer'})->exists())
    {
      $f = File::where('id_book',request()->data{'id_book'})->where('id_customer',request()->data{'id_customer'})->first();
    }else {
      $f = new File();
       $f->id_book = request()->data{'id_book'};
       $f->id_customer = request()->data{'id_customer'};
       $f->create_by =  auth()->user()->id;
    }

    if(request()->campo == "url_contrato")
    {
      $f->url_contrato = request()->url;
    }elseif (request()->campo == "url_certificado_old") {
      $f->url_certificado_old = request()->url;
    }elseif (request()->campo == "url_certificado_new") {
      $f->url_certificado_new = request()->url;
    }elseif (request()->campo == "url_baucher_new") {
      $f->url_baucher_new = request()->url;
    }elseif (request()->campo == "url_baucher_old") {
      $f->url_baucher_old = request()->url;
    }elseif (request()->campo == "url_baucher_old") {
      $f->url_baucher_old = request()->url;
    }elseif (request()->campo == "url_traspado") {
      $f->url_traspado = request()->url;
    }
    $f->modified_by =  auth()->user()->id;
    $f->save();
    return response()->json([
      'object' => "success"
    ]);
  }

  function getFile()
  {

    $f = File::where('id_book',request()->id_book)->where('id_customer',request()->id_customer)->first();
    return response()->json([
        "object"   =>"success",
        "data"=>$f
      ]);
  }

}
