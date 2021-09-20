<?php

namespace App\Http\Controllers\CapitalDriver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Classes\MainClass;

use App\Models\General\Pay;
use App\Models\General\User;
use App\Models\General\Banks;
use App\Models\General\Country;
use App\Models\General\Status_Pay;
use App\Models\General\Account_Type;

use App\Models\Cobranza\Driver_App;
use App\Models\CapitalDriver\Driver_Saldo;


use \PDF;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;


class CapitalDriverController extends Controller{


  private function setUrl(){
      return 'https://admin.taxiwin.in/api/v2/admin/';
  }
  private function setKeyCulqi(){
      return 'sk_live_5KQXcchQiBQhlC23';
  }

  public function __construct(){
		$this->middleware('auth');
    $this->middleware('role');

	}

  public function indexApp() {
    $main = new MainClass();
    $main = $main->getMain();

    return view('capitaldriver.indexApp', compact('main'));
  }

  public function index() {
    $main = new MainClass();
    $main = $main->getMain();


    $driver        = Driver_App::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(last_name||" " ||first_name)as name', 'id');
    $country       = Country::orderBy('description', 'ASC')->pluck('description', 'id');
    $status        = Status_Pay::orderBy('name', 'ASC')->pluck('name', 'id');
    $modified_by   = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');
    $pay           = Pay::orderBy('name_pay', 'ASC')->pluck('name_pay', 'id');
    $bank          = Banks::orderBy('name', 'ASC')->pluck('name', 'id');
    $account_type   = Account_Type::orderBy('name', 'ASC')->pluck('name', 'id');

    return view('capitaldriver.index', compact('main', 'driver', 'pay', 'country', 'modified_by', 'status', 'bank', 'account_type'));
  }

  public function indexPendients() {
    $main = new MainClass();
    $main = $main->getMain();
    $country        = Country::orderBy('description', 'ASC')->pluck('description', 'id');
    $pay            = Pay::orderBy('name_pay', 'ASC')->pluck('name_pay', 'id');
    $bank           = Banks::orderBy('name', 'ASC')->pluck('name', 'id');
    $account_type   = Account_Type::orderBy('name', 'ASC')->pluck('name', 'id');
    $driver        = Driver_App::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(last_name||" " ||first_name)as name', 'id');
    $modified_by   = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');

    return view('capitaldriver.pendients', compact('main', 'country', 'pay', 'bank', 'account_type', 'driver', 'modified_by'));
  }

  public function indexLote() {
    $main = new MainClass();
    $main = $main->getMain();
    $country        = Country::orderBy('description', 'ASC')->pluck('description', 'id');
    $pay            = Pay::orderBy('name_pay', 'ASC')->pluck('name_pay', 'id');
    $bank           = Banks::orderBy('name', 'ASC')->pluck('name', 'id');
    $account_type   = Account_Type::orderBy('name', 'ASC')->pluck('name', 'id');
    $driver         = Driver_App::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(last_name||" " ||first_name)as name', 'id');
    $modified_by   = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');

    return view('capitaldriver.lote', compact('main', 'country', 'pay', 'bank', 'account_type', 'driver', 'modified_by'));
  }

  public function getRecargas() {

    $start_date     = request()->start_date ? request()->start_date." 00:00:00.0000-05" : null;
    $end_date       = request()->end_date   ? request()->end_date." 23:59:59.0000-05"   : null;


    $id_pay          = request()->datos{'id_pay'};
    $id_bank         = request()->datos{'id_bank'};
    $id_account_type = request()->datos{'id_account_type'};

    $modified_by     = request()->datos{'modified_by'};
    $id_driver       = request()->datos{'id_driver'};
    $id_country      = request()->datos{'id_country'};
    $status_user     = request()->datos{'status_user'};
    $view            = request()->datos{'view'};



    $recargas = Driver_Saldo::query();
    if ($id_pay)                  $recargas->Where('id_pay','=',$id_pay);
    if ($id_bank)                 $recargas->Where('id_bank','=',$id_bank);
    if ($id_account_type)         $recargas->Where('id_account_type','=',$id_account_type);
    if ($modified_by)             $recargas->Where('modified_by','=',$modified_by);
    if ($id_driver)               $recargas->Where('id_driver','=',$id_driver);
    if ($status_user)             $recargas->Where('status_user','=',$status_user);

    if ($view === 'index') { if ($start_date && $end_date)  $recargas->WhereBetween('date_saldo', [$start_date, $end_date]);}
    else if ($view != 'index')       { if ($start_date && $end_date) $recargas->WhereBetween('created_at', [$start_date, $end_date]);}



    $recargas = $recargas->with('getStatus', 'getDriver', 'getPay', 'getModifyBy')->get();

    $recargasAll = [];
    foreach ($recargas as $r) {
      $icon = $r->getStatus  ? $r->getStatus->icon : '';

      if ($view === 'pendients'){
        $action  = '<a data-id="'.$r->id.'" id="changeStatus" statussis="4"><i class="fa '.$icon.'" title="Aprobar Registro"></i></a>
        &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp
                    <a data-id="'.$r->id.'" id="changeStatus" statussis="5"><i class="fa fa-ban" title="Anular Registro"></i></a>';
      }
      else if ($view === 'lote'){
         $action  = '<input type="checkbox" class="flat-red" id="saldo_id" name="saldo_id[]" value="'.$r->id.'">&nbsp;&nbsp;&nbsp;&nbsp
                     <a data-id="'.$r->id.'" id="changeStatus" statussis="5"><i class="fa fa-ban" title="Anular Registro"></i></a>';
      }
      else{
        $action  = '<i class="fa '.$icon.'" title="Aprobar Registro"></i>';
      }
      if($r->route_img) {$ver = '<a data-toggle="modal" data-target="#modal-img" class="btn-modalImg" data-id="'.$r->route_img.'"><i class="fa fa-eye" title="Ver Imagen"></i></a>';}
      else { $ver = '<i class="fa fa-ban" title="Aprobar Registro"></i>'; }
      $responsable = $r->getModifyBy == null ?  $r->getDriver->license_number : $r->getModifyBy->username ;
      if ($r->status_user == 1){
        $code = '<a data-toggle="modal" data-target="#modal-edit" class="btn-modalEdit" data-id="'.$r->id.'"  title="Editar">'.str_pad($r->id, 6, "0", STR_PAD_LEFT).'</a>';
      }else{
        $code = str_pad($r->id, 6, "0", STR_PAD_LEFT);
      }


      $recarga   = [
        'action'       => $action,
        'ver'          => $ver,
        'codigo'       => $code,
        'licencia'     => $r->getDriver  ? $r->getDriver->license_number :'-',
        'name'         => $r->getDriver  ? $r->getDriver->first_name :'-',
        'lastname'     => $r->getDriver  ? $r->getDriver->last_name  :'-',
        'document'          => $r->getDriver  ? $r->getDriver->document   : '-',
        'id_pay'       => $r->getPay     ? $r->getPay->name_pay : '-',
        'id_bank'      => $r->getBank    ? $r->getBank->name    : '-',
        'id_account'       => $r->getAccount ? $r->getAccount->name : '',
        'number_operation' => $r->number_operation ? $r->number_operation : '-',
        'date_pay'         => $r->date_pay       ? $r->date_pay        : '-',
        'date_saldo'       => $r->date_saldo     ? $r->date_saldo      : '-',
        'saldo_actual'     => $r->saldo_actual   ? $r->saldo_actual    : '-',
        'saldo_recarga'    => $r->saldo_recarga  ? $r->saldo_recarga   : '-',
        'status_user'      => $r->getStatus      ? $r->getStatus->name : '-',
        'modified_by'      => $responsable,
        'note'             => $r->note,
      ];
      array_push($recargasAll, $recarga);
    }

    return response()->json([
      'data'     =>  $recargasAll,
    ]);

  }

  public function getRecargasApp() {

    $saldos = $this->getDriversFunds();

    $saldosAll = [];
    foreach ($saldos as $r) {
      if ($r->driver_disabled != 'Disabled' ){

        $sald   = [
          'licencia'     => $r->driver_license_number ? $r->driver_license_number  :'-',
          'name'         => $r->driver_first_name     ? $r->driver_first_name    :'-',
          'lastname'     => $r->driver_last_name      ? $r->driver_last_name     :'-',
          'phone'        => $r->driver_phone_number   ? $r->driver_phone_number  :'-',
          'country'      => $r->driver_country        ? $r->driver_country       :'-',
          'money'        => $r->driver_currency       ? $r->driver_currency      :'-',
          'amount'       => $r->funds                 ? $r->funds                :'-',
          'approved'     => $r->driver_approved       ? $r->driver_approved       :'-',
          'blocked'      => $r->driver_blocked        ? $r->driver_blocked       :'-',
          'disabled'     => $r->driver_disabled       ? $r->driver_disabled       :'-',

        ];
        array_push($saldosAll, $sald);
      }
    }

    return response()->json([
      'data'     =>  $saldosAll,
    ]);

  }

  public function create() {
    $main = new MainClass();
    $main = $main->getMain();
    $country        = Country::orderBy('description', 'ASC')->pluck('description', 'id');
    $pay            = Pay::whereIn('id', [1,2,3,4,5,6,7,8])->orderBy('name_pay', 'ASC')->pluck('name_pay', 'id');
    $bank           = Banks::orderBy('name', 'ASC')->pluck('name', 'id');
    $account_type   = Account_Type::orderBy('name', 'ASC')->pluck('name', 'id');

    return view('capitaldriver.create', compact('main', 'country', 'pay', 'bank', 'account_type'));
  }

  public function edit(){

   if (request()->ajax( )){
     $driver_saldo     = Driver_Saldo::findOrFail(request()->id);
     $date = new \DateTime($driver_saldo->date_pay);

     $datos = [
       'id'             => $driver_saldo->id,
       'code'           => str_pad($driver_saldo->id, 6, "0", STR_PAD_LEFT),
       'date_ed'        => $date->format('Y-m-d'),
       'hour_pay_ed'    => $date->format('H:i:s'),
       'id_pay_ed'      => $driver_saldo->id_pay,
       'id_bank_ed'     => $driver_saldo->id_bank,
       'id_account_ed'  => $driver_saldo->id_account_type,
       'number_operation_ed'  => $driver_saldo->number_operation,
       'saldo_ed'             => $driver_saldo->saldo_recarga,

     ];

     return response()->json($datos);
     }
  }

  public function addSaldo (){
    $now = new \DateTime();
    try{
      DB::beginTransaction();

      $upd_driver = Driver_App::find(request(){'id_driver'});
      $driver     = [
                    'document'         => request()->input('document'),
                    'id_country'  => request()->input('id_country'),
                  ];
      $upd_driver->update($driver);



      $saldo   = [
                  'id_driver'         => request()->input('id_driver'),
                  'id_pay'            => request()->input('id_pay'),
                  'id_bank'           => request()->input('id_bank')          ? request()->input('id_bank')          : null,
                  'id_account_type'   => request()->input('id_account_type')  ? request()->input('id_account_type')  : null,
                  'number_operation'  => request()->input('number_operation') ? request()->input('number_operation') : null ,
                  'date_pay'          => request()->input('date') ." ".request()->input('hour_pay').".0000-05",
                  'saldo_actual'      => request()->input('saldo_actual'),
                  'saldo_recarga'     => request()->input('saldo_recarga'),
                  'note'              => request()->input('note'),
                  'date_saldo'        => $now->format('Y/m/d H:i:s').".0000-05",
                  'status_user'       => '2',
                  'route_img'         =>request()->input('route_img'),
              ];

     $id=   Driver_Saldo::create($saldo)->id;
     $id = str_pad($id, 6, "0", STR_PAD_LEFT);


      //LLAMAR FUNCION DE PAGO
      $saldo           = request()->input('saldo_recarga');
      $license_number  = $upd_driver->license_number;

      $arrayDev = $this->updateSaldo($saldo, $license_number);
      if($arrayDev){
        $upd_driver->update($driver);
        $phone           = request()->input('phone');
        $saldo = $arrayDev->total_fund;

        $mensaje ='TAXI WIN - INFORMA - Su transaccion esta procesada el numero de ticket generado es: '.$id.' y su nuevo saldo es de: '.$saldo;
        $this->enviarMensajePeru($phone, $mensaje);

      }


      DB::commit();
    }catch(\Exception $e){
        DB::rollback();
        dd($e);
    }
    Session::flash('flash_message', $mensaje);
    return redirect()->route('capitaldriver.create');
  }

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

  public function getDriver() {
    $license_number  = request()->license_number;
    $myArray;
    $token           = $this->getTokenApp()->api_token;
    $id_country      = null;


    $ch = curl_init($this->setUrl().'drivers_with_funds?license_number='.$license_number.'');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: Token token='.$token.''));

      $result  = curl_exec($ch);
      $myArray = json_decode($result);

      if ($myArray[0]->driver_country) $id_country  = Country::where('description', '=', strtoupper($myArray[0]->driver_country))->first()->id;
      $driver      = Driver_App::where('license_number', '=',$license_number)->with('getCountry')->first();

      $driverCreate  = [
        'dblink_driver'  => $myArray[0]->driver_id,
        'license_number' => $myArray[0]->driver_license_number,
        'first_name'     => $myArray[0]->driver_first_name,
        'last_name'      => $myArray[0]->driver_last_name,
        'email'          => $myArray[0]->driver_email,
        'phone'          => $myArray[0]->driver_phone_number,
        'id_country'     => $id_country,
      ];

      if (!$driver){
        Driver_App::create($driverCreate);
      }else{
        $driver->update($driverCreate);
      }

      $saldo    = $myArray[0]->funds;
      $moneda   = $myArray[0]->driver_currency;
      $myArray = $this->getDriverDBInterna($license_number, $saldo, $moneda);

    return response()->json([
      'data'     => $myArray,
    ]);
  }

  public function getDriversFunds() {
    $myArray;
    $token           = $this->getTokenApp()->api_token;

    $ch = curl_init($this->setUrl().'drivers_with_funds');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: Token token='.$token.''));

      $result  = curl_exec($ch);
      $myArray = json_decode($result);
      return $myArray;

  }

  public function getDriverDBInterna($license_number, $saldo, $moneda) {

      $driver          = Driver_App::where('license_number', '=',$license_number)
                        ->with('getCountry')
                        ->first();
      $driver  = [
        'id'             => $driver->id,
        'document'            => $driver->document ? $driver->document : '' ,
        'dblink_driver'  => $driver->dblink_ride,
        'license_number' => $driver->license_number,
        'first_name'     => $driver->first_name,
        'last_name'      => $driver->last_name,
        'email'          => $driver->email,
        'phone'          => $driver->phone,
        'id_country'     => $driver->id_country ? $driver->getCountry->id : '',
        'saldo_actual'   => $saldo,
        'moneda'         => $moneda,
      ];
      return $driver;

  }

  public function updateSaldo($saldo, $license_number) {

    $data = array('license_number'  => $license_number,
                  'fund_amount'     => $saldo,
                  'fund_operation'  => 'add');
    $data_string = json_encode($data);
    $token       = $this->getTokenApp()->api_token;

    $ch = curl_init($this->setUrl().'manage_fund');
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Token token='.$token.''));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    $result = curl_exec($ch);
    $myArray = json_decode($result);
    return $myArray;

  }

  public function updateStatus(){
    $mensaje ='';

   if (request()->ajax( )){
     $driver_saldo     = Driver_Saldo::findOrFail(request()->id);

     try{
       DB::beginTransaction();

         $driver_saldo->status_user = request()->status;
         $driver_saldo->modified_by = auth()->user()->id;
         $driver_saldo->save();

       DB::commit();
     }catch(\Exception $e){  dump($e);  DB::rollback(); }
     if       (request()->status == 5)    { $mensaje = 'Se ha sido ANULADO  de forma satisfactoria';}
     else if  (request()->status == 4)    { $mensaje = 'Se ha sido APROBADO de forma satisfactoria';}


     return response()->json($mensaje);
     }
  }

  public function recargando() {
    $now = new \DateTime();

    if (request()->ajax( )){
    $mensaje= ''; $i=0;
    $id_values = request()->codigos;
       foreach ($id_values as $x) {
         $recarga         =  Driver_Saldo::where('id', '=', $x)->with('getStatus', 'getDriver', 'getPay')->first();
         $saldo           =  $recarga->saldo_recarga ? $recarga->saldo_recarga  : null;
         $license_number  =  $recarga->getDriver     ? $recarga->getDriver->license_number : null;

         if ($saldo != null && $license_number != null ){
           $arrayDev = $this->updateSaldo($saldo, $license_number);
           if($arrayDev){
             $recarga->status_user = 2;
             $recarga->date_saldo  =  $now->format('Y/m/d H:i:s').".0000-05";
             $recarga->modified_by = auth()->user()->id;
             $recarga->save();
             $i++;
           }
         }
       }
       $mensaje = 'Se ha recargado de forma exitosa a '.$i.' usuario(s).';
       return response()->json([
           "mensaje"       => $mensaje
         ]);
       }
     }

  public function validaNumber(){
     $num = true;
     $date = request()->date." ".request()->hour.".0000-05";

     if (request()->ajax( )){
         $driver_saldo = Driver_Saldo::where('id_bank', '=', request()->id_bank)
         ->where('number_operation', '=', request()->number_op)
         ->where('date_pay', '=', $date)
         ->first();
         if ($driver_saldo) {$num =false;}
         return response()->json($num);
     }
   }

  public function validaDni(){
       $num = '0';
         if (request()->ajax( )){
             $driver = Driver_App::where('document', '=', request()->document)
             ->where('id', '<>', request()->id)
             ->first();
             if ($driver) {$num ='1';}
             return response()->json($num);
         }
     }

  public function updateRecarga(){

    if (request()->ajax( )){
      $form = request()->form;
      $driver_saldo     = Driver_Saldo::findOrFail($form{'id'});
      $date_pay         = $form{'date_ed'} ." ".$form{'hour_pay_ed'}.".0000-05";

      try{
        DB::beginTransaction();

          $driver_saldo->id_pay           = $form{'id_pay_ed'};
          $driver_saldo->id_bank          = $form{'id_bank_ed'};
          $driver_saldo->id_account_type  = $form{'id_account_ed'};
          $driver_saldo->number_operation = $form{'number_operation_ed'};

          $driver_saldo->date_pay         = $date_pay;
          $driver_saldo->saldo_recarga    = $form{'saldo_ed'};
          $driver_saldo->modified_by      = auth()->user()->id;

          $driver_saldo->update();

        DB::commit();
      }catch(\Exception $e){  dump($e);  DB::rollback(); }
      $mensaje = 'Se ha sido actualizado de forma satisfactoria!';
      return response()->json($mensaje);
      }
  }

  public function customerAPI($customer){
      $dataCustomer =  array(
          "first_name" => $customer->first_name,
          "last_name" => $customer->last_name,
          "email" => $customer->email,
          "address" => $customer->address,
          "address_city" => "Lima",
          "country_code" => "PE",
          "phone_number" => $customer->phone
        );
      $customer_string = json_encode($dataCustomer);

      $chCustomer = curl_init('https://api.culqi.com/v2/customers');
      curl_setopt($chCustomer, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($chCustomer, CURLOPT_POSTFIELDS, $customer_string);
      curl_setopt($chCustomer, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($chCustomer, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Authorization: Bearer '.$this->setKeyCulqi())
      );
      $customerQ = curl_exec($chCustomer);
      return json_decode($customerQ);
    }

  public function chargeAPI($amount,$currend_code,$email,$token,$description,$customer){
      $antifraud_details =
      array(
        'address' => $customer->address,
        'address_city' => "Lima",
        'country_code' =>"PE",
        'first_name' =>$customer->first_name,
        'last_name' => $customer->last_name,
        'phone_number' =>$customer->phone
      );
      $data =  array(
          "amount" => $amount,
          "currency_code" => $currend_code,
          "description" => $description,
          "email" => $email,
          "source_id" => $token,
          "antifraud_details" =>$antifraud_details
        );
      $string = json_encode($data);

      $ch = curl_init('https://api.culqi.com/v2/charges');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Authorization: Bearer '.$this->setKeyCulqi())
      );

      $cQ = curl_exec($ch);
      return  json_decode($cQ);
    }


   public function enviarMensajePeru($number, $mensaje){
      $m = str_replace(" ","%20",$mensaje);
      $ch = curl_init('https://bcperu.cm-operations.com/dashboard/bin/tu_empresa.php?msisdn='.$number.'&message='.$m.'&tag=EXAMPLE&idu=5c45f662cf248&user=WINHOLD');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json'));
      $result = curl_exec($ch);
      $myArray = json_decode($result);
      $codigo = $myArray->info;
      $f =
      [
        "Celular"=>$number,
        "Estado"=>$codigo,
        "Fecha"=>date("Y-m-d H:i:s"),
        "mensaje" =>$mensaje,
      ];
      return $f;
    }

    public function splitMsm($mensaje,$phone,$contador,$cara) {
      $mensajeSobrante = substr($mensaje,155,strlen($mensaje));
      $mensajeEnviar = substr($mensaje,0,155);
      $CantidadCaracteresTotal =strlen($mensaje);
      $a = [];
      $contador++;

      $nuevoString =
      [
        "MensajeEnviar"=> "(".$contador."/".$this->redondear(($cara/155)) .")" .$mensajeEnviar,
        "CantidadMensajeEnviar" => strlen($mensajeEnviar),
        "MensajeSobrante"=>$mensajeSobrante,
        "CantidadMensajeSobrante"=>strlen($mensajeSobrante),
        "CantidadCaracteresTotal" =>$CantidadCaracteresTotal,
        "Phone" => $phone
      ];
      array_push($a, $nuevoString);
      if($nuevoString{'CantidadMensajeSobrante'} != 0)
      {
        $s = $this->splitMsm($nuevoString{'MensajeSobrante'},$phone,$contador,$cara);
        foreach ($s  as $key => $value)
        {
          array_push($a, $value);
        }

      }
      return $a;
    }




}
