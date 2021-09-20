<?php

namespace App\Http\Controllers\Cobranza;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Classes\MainClass;
use App\Models\Ticket\Ticket;
use App\Models\Cobranza\Driver_App;
use App\Models\Cobranza\Rides;
use App\Models\Cobranza\Order;
use App\Models\Cobranza\Order_Ride;
use App\Models\General\Country;
use \PDF;

class OrderPayController extends Controller{

  private function setUrl(){
    return 'https://admin.taxiwin.in/api/v2/admin/';
  }

  public function __construct(){
		$this->middleware('auth');
    $this->middleware('role');

	}

  public function index() {
    $main = new MainClass();
    $main = $main->getMain();

    return view('cobranza.index', compact('main', 'customer'));
  }

  public function doOrderPay() {
    $main = new MainClass();
    $main = $main->getMain();
    return view('cobranza.doOrder', compact('main', 'customer'));
  }

  public function getridesByOrderPay(){
    $mensaje;     $ridesAll    = [];

    // Obtengo el token para ingresar a la api de la data de conductores
    $token      = $this->getTokenApp()->api_token;

    // Obtengo el las fechas que deseo observar de las carreras
    $start_date      = request()->start_date;
    $end_date        = request()->end_date;
    $porcentaj_ret   = request()->porcentaj_ret;

    // Obtengo los datos de todas las carerras por conductores.
    $sumDriverRides = $this->getRidesDriver($start_date, $end_date, $token);

    // Almaceno en mi BD todos los conductores que tienen carreras realizadas, devolviendo la cant de registros insertados.
    $cantRegistros  = $this->saveDriver($sumDriverRides->driver_details);

    // Tomo los conductores y su carreras.
    $drivers = $sumDriverRides->driver_details;

    foreach ($drivers as $d) {
      $rides = [];

      $driver  = Driver_App::where('dblink_driver', '=', $d->driver_id)->where('license_number', '=',$d->driver_license_number)->with('getCountry')->first();

      $id_driver      = $driver->id              ?  $driver->id : '';
      $license_number = $driver->license_number  ?  $driver->license_number : '';
      $last_name      = $driver->last_name       ?  $driver->last_name      : '';
      $first_name     = $driver->first_name      ?  $driver->first_name     : '';
      $money          = $d->driver_currency      ?  $d->driver_currency   : '';
      $country        = $driver->getCountry      ?  $driver->getCountry->description : '';
      $rides          = $d->rides;

        foreach ($rides as $r) {
          $ride      = Rides::where('dblink_ride', '=', $r->ride_id)->where('dblink_driver', '=',$d->driver_id)->first();
          $rideOnly  = Rides::where('dblink_ride', '=', $r->ride_id)->first();


          if(!$ride && !$rideOnly){

            $check    ='<input type="checkbox" class="minimal" name="cod_rides[]" value="'.$r->ride_id.'">';
            $mto_ret    =   sprintf("%01.2f", ( (($r->ride_total_cost*$porcentaj_ret) /100) ));
            $mto_abono  =   sprintf("%01.2f", ($r->ride_total_cost - $mto_ret));


            $ride   = [
              'check'           => $check,
              'codigo_ride'     => str_pad($r->ride_id, 7, "0", STR_PAD_LEFT),
              'license_number'  => $license_number,
              'last_name'       => $last_name,
              'first_name'      => $first_name,
              'money'           => $money,
              'country'         => $country,
              'pay'             => $r->payment_type        ?  strtoupper($r->payment_type) : '',
              'date_ride'       => $r->ride_date           ?  $r->ride_date                : '',
              'total_pay'       => $r->ride_total_cost     ?  $r->ride_total_cost          : '',
              'porcentaj_ret'   => $porcentaj_ret,
              'mto_ret'         => $mto_ret,
              'mto_abono'       => $mto_abono,
              'status'          => $r->paid,
              'id_driver'       =>  str_pad($d->driver_id, 6, "0", STR_PAD_LEFT),

              ];
            array_push($ridesAll, $ride);
        }
        }
    }
    return response()->json([
        'data'     => $ridesAll,
        'mensaje'  => 'Se registro un total de ('.$cantRegistros.') conductores',
        'total'    => $sumDriverRides->sum_of_rides,

    ]);
  }

  public function generandoOrder(Request $request){
    $rides    = request()->rides;
    $id_rides = array();
    try{
      DB::beginTransaction();
    foreach ($rides as $r) {
      $id_driver = $r{'id_driver'};
      $driver    = Driver_App::where('license_number', '=', $r{'license_number'})->where('dblink_driver', '=',$id_driver )->first();

      if ($driver){
        $ride   = [
          'dblink_driver'   => $driver->dblink_driver,
          'id_driver'       => $driver->id,
          'dblink_ride'     => $r{'cod_ride'},
          'pay'             => $r{'pay'},
          'date_ride'       => $r{'date_ride'},
          'total_pay'       => $r{'total_pay'},
          'porcentaj_ret'   => $r{'porcentaj_ret'},
          'mto_ret'         => $r{'mto_ret'},
          'mto_abono'       => $r{'mto_abono'},
          'status_app'      => $r{'status'},
          'modified_by'     => auth()->user()->id,
          'money'           => $r{'money'},
          'id_status_pay'   => '1'
        ];
        $id_ride = Rides::create($ride)->id;
        array_push($id_rides, $id_ride);
      }
    }

    $totalValues = Rides::whereIn('id', $id_rides)->first();
    $order   = [
      'cod_order'       => $this->getCodigo(),
      'total'           => $totalValues->sum('total_pay'),
      'total_ret'       => $totalValues->sum('mto_ret'),
      'total_abono'     => $totalValues->sum('mto_abono'),
      'modified_by'     => auth()->user()->id,
      'status_user'     => '1',
    ];
    $id_order  = Order::create($order)->id;
    $cod_order = Order::findOrFail($id_order)->cod_order;

    foreach ($id_rides as $x) {
      $order_ride   = [
        'id_order'    => $id_order,
        'id_ride'     => $x,
        'modified_by'     => auth()->user()->id,
      ];
      Order_Ride::create($order_ride)->id;
    }
    DB::commit();
    }catch(\Exception $e){
      DB::rollback();
      dump($e);
      $respuesta = false;
     }

    return response()->json([
        "dato"   => 'Su numero de orden es '.$cod_order,
      ]);
  }

  //Api's
  public function getTokenApp() {

    $data = array('user[email]'    => 'superadmin1@mail.com',
                  'user[password]' => 'qaz789wsx');
    $data_string = json_encode($data);

    $ch = curl_init($this->setUrl().'sign_in.json');
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    $result = curl_exec($ch);
    $myArray = json_decode($result);
    return $myArray;
  }

  public function getRidesDriver($start_date, $end_date, $token) {

    $ch = curl_init($this->setUrl().'/sum_fund_rides_all_drivers?start_date='.$start_date.'&end_date='.$end_date.'');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Token token='.$token.''));

    $result = curl_exec($ch);
    $myArray = json_decode($result);
    return $myArray;
  }

  public function saveDriver($drivers) {
    $i=0;
    foreach ($drivers as $dato) {

      $driver    = Driver_App::where('dblink_driver', '=', $dato->driver_id)->where('license_number', '=',$dato->driver_license_number)->first();
      //$driverL   = Driver_App::where('license_number', '=',$dato->driver_license_number)->first();

      $id_country;
      if ($dato->driver_country) $id_country  = Country::where('description', '=', strtoupper($dato->driver_country))->first()->id;

      $driverArray   = [
        'dblink_driver'   => $dato->driver_id,
        'first_name'      => $dato->driver_first_name,
        'last_name'       => $dato->driver_last_name,
        'document'             => null,//$dato->document,
        'license_number'  => $dato->driver_license_number,
        'email'           => $dato->driver_email,
        'phone'           => $dato->driver_phone_number,
        'id_country'      => $id_country ? $id_country : null,
        'modified_by'     => request()->username,
      ];

      //if (!$driver && !$driverL){
      if (!$driver){
        Driver_App::create($driverArray);
        $i++;
      }else{
        $driver->update($driverArray);
        $i++;
      }


    }
    return $i;

  }

  public function getCodigo(){
    $now = new \DateTime();
    $fecha = $now->format('Y')."-".$now->format('m')."-".$now->format('d');
    $fi = $fecha." 00:00:00.0000-05";
    $ff = $fecha." 23:59:59.0000-05";

    $num =  DB::table('order')->whereBetween('created_at', [$fi, $ff])->count()+1;

    $codigo = $now->format('Y').$now->format('m').$now->format('d')."-".$num;

    return $codigo;
  }

  //Obtener Listado
  public function getOrders() {
    // Obtengo el las fechas que deseo observar de las carreras

    $orderAll       = [];
    $start_date     = request()->start_date ? request()->start_date." 00:00:00.0000-05" : null;
    $end_date       = request()->end_date   ? request()->end_date." 23:59:59.0000-05"   : null;
    $cod_order      = request()->cod_order;

    $orders = Order::query();
    if ($cod_order)               $orders->Where('cod_order','like','%'.$cod_order.'%');
    if ($start_date && $end_date) $orders->WhereBetween('created_at', [$start_date, $end_date]);

    $orderQuery = $orders->with('getStatus', 'getMoney', 'getPay', 'getModifyBy')->get();

    foreach ($orderQuery as $d) {

      $action   = '<center>';
      $action  .= '<a data-toggle="modal" data-target="#modal-ticket" data-id='.$d->id.' class="btn-ticket"><i class="fa fa-eye"></i></a>';
      $action  .= '</center>';
      $countRides = Order_Ride::where('id_order', '=', $d->id)->count();

      $date_pay   = $d->date_pay   ? new \DateTime($d->date_pay)   : null;
      $created_at = $d->created_at ? new \DateTime($d->created_at) : null;
      $updated_at = $d->updated_at ? new \DateTime($d->updated_at) : null;


      $order   = [
         'action'       => $action,
         'id'           => $d->id,
         'cod_order'    => $d->cod_order,
         'date_pay'     => $date_pay    ?  $date_pay->format('Y-m-d H:i') : '-',
         'id_pay'       => $d->getPay   ?  $d->getPay->name_pay : '-',
         'id_money'     => $d->getMoney ?  $d->getMoney->description : '-',
         'total'        => $d->total,
         'total_abono'  => $d->total_abono,
         'total_ret'    => $d->total_ret,
         'note'         => $d->note,
         'created_at'   => $created_at    ?  $created_at->format('Y-m-d H:i') : '-',
         'updated_at'   => $updated_at    ?  $updated_at->format('Y-m-d H:i') : '-',
         'modified_by'  => $d->getModifyBy ?  $d->getModifyBy->username  : '-',
         'status_user'  => $d->getStatus   ?  $d->getStatus->name : '-',
         'total_ride'   => $countRides,

      ];
      array_push($orderAll, $order);
    }
    return response()->json([
      'data'     =>  $orderAll,
    ]);
  }

}
