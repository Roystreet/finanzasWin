<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Driver\Driver;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\Type_document_identy;
use App\Models\General\City;
use App\Models\Driver\Vehicle;
use App\Models\Driver\TypeBodywork;
use App\Classes\MainClass;
use App\Models\General\Pay;
use App\Models\General\Status;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerType;
use App\Models\Customer\dtCustomerType;
use Illuminate\Database\Eloquent\Builder;
use App\Models\External\User_office;
use App\Models\External\Record_Driver;
use App\Models\External\RangoRecord;
use App\Models\External\ProcessModel;
use App\Models\External\ProcessTrace;
use App\Models\General\User;
use App\Models\External\ProcesoValCond;
use App\Models\External\technical_review;
use App\Models\External\ProcesoValidacion;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\General\Main;
use App\Models\General\Rol_permissions;
use \PDF;
use \stdClass;
use Response;


class ControllerDriver extends Controller
{
  public function __construct(){
		$this->middleware('auth');
	}

  public function index(){

    if(auth()->user()){
      $main = new MainClass();
      $main = $main->getMain();

       $title ='Conductores';

       $drivers = Driver::where('status_system', '=', 'TRUE')
       ->orderBy('created_at', 'asc')
       ->get();

      $pay           = Pay::orderBy('name_pay', 'ASC')->pluck('name_pay', 'id');


      $status        = Status::select(DB::raw("UPPER(description) AS description"), "id")->orderBy('description', 'ASC')->pluck('description', 'id');


      $customer       =  dtCustomerType::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "customers.id as id")
                        ->join('customers', 'dt_customer_types.id_customer', '=', 'customers.id')
                        ->where('dt_customer_types.id_customerType', '=' ,'4')
                        ->orderBy('name',  'ASC')
                        ->pluck( '(last_name||" " ||first_name)as name', 'customers.id as id');




      $modified_by   = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');
      $country  = Country::WHERE('status_user', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');


      return view('driver.index',compact('drivers','title', 'country','pay','status','customer','modified_by' , 'main'));
    }

  }

  public function getDataDriver(){
    $start_datec    = request()->start_datec ? request()->start_datec." 00:00:00.0000-05" : null;
    $end_datec      = request()->end_datec   ? request()->end_datec." 23:59:59.0000-05"   : null;

    $start_datep     = request()->start_datep ? request()->start_datep." 00:00:00.0000-05" : null;
    $end_datep       = request()->end_datep   ? request()->end_datep." 23:59:59.0000-05"   : null;
  }

  public function store(){
     $data = request()->validate([
       'document'          => 'unique:drivers',
     ], [
       'document.unique'     => 'Ya existe este dato en el registro',
     ]);

    //Driver::create($data);
    return  redirect()->route('driver.index');
  }

  public function show($driver){
    $main = new MainClass();
    $main = $main->getMain();
    $title = 'Detalle Conductor';


    $driver = Driver::
      where('status_system', '=', 'TRUE')
    ->where('id', '=', $driver)
    ->orderBy('created_at', 'asc')
    ->with('getCityDriver')
    ->with('getContryNationality')
    ->with('getContryAddress')
    ->with('getStateAddress')
    ->with('getCityAddress')
    ->with('getVehicle')
    ->first();

    if ($driver == null){
      return view('errors.404Null', compact('main', 'title'));

    }else{
      $country        = Country::orderBy('description', 'ASC')->pluck('description', 'id');
      $state          = State::where('id_country', '=', $driver->id_country_address)->orderBy('description', 'ASC')->pluck('description', 'id');
      $city           = City::where('id_state', '=',    $driver->id_state_address  )->orderBy('description', 'ASC')->pluck('description', 'id');
      return view('driver.show', compact('driver',  'country', 'state','city', 'main'));
    }
  }

  public function edit($driver){
    $main = new MainClass();
    $main = $main->getMain();

    $driver = Driver::
      where('status_system', '=', 'TRUE')
    ->where('id', '=', $driver)
    ->orderBy('created_at', 'asc')
    ->with('getVehicle')
    ->first();

    $country        = Country::orderBy('description', 'ASC')->pluck('description', 'id');
    $state          = State::where('id_country', '=', $driver->id_country_address)->orderBy('description', 'ASC')->pluck('description', 'id');
    $city           = City::where('id_state', '=',    $driver->id_state_address  )->orderBy('description', 'ASC')->pluck('description', 'id');
    return view('driver.edit', compact('driver',  'country', 'state','city', 'main'));

  }

  public function update(Driver $driver){
    $data = request()->validate([
      'name'         => 'required',
      'lastname'     =>'',
      'email'        => 'required',
      'birthdate'    => '',
      'phone'        => '',
      'gender'       => '',
      'id_country_address'  => '',
      'id_state_address'    => '',
      'id_city_address'     => '',
      'id_city_driver'      => '',
      'address'             => '',
      'id_nationality'      => '',
      'model_year' => 'required',


    ], [
      'name.required'  => 'Este campo es obligatorio',
      'document.unique'     => 'Ya existe este dato en el registro',
      'email.required' => 'Este campo es obligatorio',
    ]);
    $dataVehicle = request()->validate([
      'model_year' => '',
      'model'      => '',
      'color'      => '',
      'serial'     => '',
      'plate'      => '',
      'note'        => '',
    ], [
      'model_year.required'  => 'Este campo es obligatorio',
    ]);
    $driver->update($data);
    Vehicle::where('id_driver', '=', $driver->id)->update($dataVehicle);

    return  redirect()->route('driver.show', ['driver'=>$driver->id]);
  }

  public function storeVehicle(){
     $data = request()->validate([
       'model_year' => 'required',
       'model'      => 'required',
       'color'      => 'required',
       'serial'     => 'required',
       'plate'      => 'required',
       'note'        => '',
       'id_driver'  => 'required',
     ], [
       'model_year.required'  => 'Este campo es obligatorio',
     ]);
    Vehicle::create($data);

    return  redirect()->route('driver.index');
  }

  public function createDriverView()
  {
    $main = new MainClass();
    $main = $main->getMain();

      if (true){
        $t =  TypeBodywork::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
            $country        = Country::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
        return view('driver.create', compact('main','country',"t"));

      }else{
        return view('errors.403', compact('main'));
      }
  }

  public function createDriver()
  {

    $customer = request(){'customer'};
    $driver = request(){'driver'};
    $vehiculo = request(){'vehicle'};
    if(!Driver::where('id_customer',$customer{'id'})->exists())
    {
      return response()->json([
        'object'  => "error",
        'message' => "No esta registrado el cliente que estas ingrrsando"
      ]);
    }else
    {
     $id_customer =  $customer{'id'};

     $dr = new Driver();
     $dr->number_license=$driver{'number_license'};
     $dr->category=$driver{'category'};
     $dr->id_country_driving=$driver{'cod_country_driver'};
     $dr->date_expiration=$driver{'date_exp'};
     $dr->points_limit=100;
     $dr->id_customer=$id_customer;
     if(!Driver::where('id_customer',$id_customer)->exists())
     $dr->save();

     $cd = new dtCustomerType();
     $cd->id_customerType = 1;
     $cd->id_customer = $id_customer;
     $cd->create_by = auth()->user()->id;
     if(!dtCustomerType::where('id_customer',$id_customer)->exists())
     $id_driver = $cd->save()->id;
     else $id_driver = Driver::where('id_customer',$id_customer)->first()->id;

     $ve = new Vehicle();
     $ve->number_enrollment= $vehiculo{'matricula'};
     $ve->brand= $vehiculo{'brand'};
     $ve->model= $vehiculo{'model'};
     $ve->color= $vehiculo{'color'};
     $ve->nro_doors= $vehiculo{'nro_doors'};
     $ve->model_year= $vehiculo{'model_year'};
     $ve->id_typebodyworks = 1;
     $ve->id_driver= $id_driver;
     $ve->id_customer_owner= $id_customer;
     if(!vehicle::where('id_driver',$dr->id)->exists() || !vehicle::where('number_enrollment',$vehiculo{'matricula'})->exists())
     $ve->save();

     return response()->json([
       'object'  => "success",
       'message' => "creado."
     ]);

    }

  }

  public function getCustomer()
  {
    if(Customer::where('document',request()->document)->exists())
      return response()->json([
       'object'  => "success",
        'data' =>Customer::where('document',request()->document)->first()
     ]);
     else
     {
       return response()->json([
        'object'  => "error",
         'message' =>"No existe la persona por favor registra.<a href='/customer/new' target='_blank'> Registrar </a>. "
      ]);
     }

  }

  public function getnationality()
  {
     return Country::where('id',request()->id_country)->first();
   }

  public function listshow()
  {
     $main = new MainClass();
     $main = $main->getMain();

     $rol= Main::where('users.id', '=', auth()->user()->id)
       ->where('main.status_user', '=', 'TRUE')
       ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
       ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
       ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
       ->join('users',    'users.id',              '=',   'rol_user.id_user')
       ->select('roles.id')
       ->first();

      $rolid = $rol->id;

       if (true){
         return view('external.drivers.list', compact('main','rolid'));
       }else{
         return view('errors.403', compact('main'));
       }
   }

  public function getFile()
  {
     return file_drivers::where('status_system',1)->with('getUserOffice')->get();
       //return file_drivers::where('status_user',1)->with('getUserOffice');
   }

  public function getimgfile()
  {
   return file_drivers::where('id',2)->with('getUserOffice')->first();

     //return file_drivers::where('status_user',1)->with('getUserOffice');
 }

 public function detailshow()
 {
   $type_docs  = Type_document_identy::select(DB::raw("UPPER(description) AS description"), "id")->orderBy('description', 'ASC')->pluck('description', 'id');
   $editar ='false';

   $rol  = Main::where('users.id', '=', auth()->user()->id)
     ->where('main.status_user', '=', 'TRUE')
     ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
     ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
     ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
     ->join('users',    'users.id',              '=',   'rol_user.id_user')
     ->select('roles.id')
     ->first();
   $main = new MainClass();
   $main = $main->getMain();

    if ($rol->id != 7){
       $id = request()->id;
       if(User_office::where('id_office',$id)->exists()){
         $u =  User_office::where('id_office',$id)->first();

         if(Record_Driver::where('id_user_offices', $u->id)->exists()) {
           $pg = Record_Driver::where('id_user_offices', $u->id)->get();
           $pun = 0;
           foreach ($pg as $key => $value) {
            $pun+= $value->points_firmes;
           }
           $statusrecord = true;
         }
         else{
           $pun = 0;
           $statusrecord = false;
         }

         if(file_drivers::where('id_user_offices', $u->id)->exists()) {

           $file = file_drivers::where('id_user_offices', $u->id)->first();

           $rol= Main::where('users.id', '=', auth()->user()->id)
           ->where('main.status_user', '=', 'TRUE')
           ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
           ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
           ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
           ->join('users',    'users.id',              '=',   'rol_user.id_user')
           ->select('roles.id')
           ->first();

          $drivers = [];

          if ($rol->id == 7){
            $DriverQuery = file_drivers::where('id_user_offices', $u->id)
                           ->join('user_offices', 'user_offices.id', '=','file_drivers.id_user_offices')
                           ->where('user_offices.created_by', '=', auth()->user()->id)
                           ->with('getUserOffice','getStatusUser','getTecnical','getDriverApi')
                           ->get();
          }
          else {
             $DriverQuery =  file_drivers::where('id_user_offices', $u->id)
                            ->with('getUserOffice','getStatusUser','getTecnical', 'getDriverApi')
                            ->get();
              $editar = 'true';

          }
        }

       }
       return view('external.drivers.detalle', compact('main','id', 'DriverQuery', 'pun','statusrecord', 'type_docs', 'editar'));
     }
    else{
      return view('errors.403', compact('main'));
     }
 }

 public function permisosProcessValid(){
  $id_proceso_validacion    =  request()->id;
  $estatus                  =  request()->estatus;
  $idfiledrivers            =  request()->idfiledrivers;

  $ProcesoValidacion  = ProcesoValidacion::find($id_proceso_validacion);
  $permiso            = $ProcesoValidacion->id_permissions;
  $rol                = Main::where('users.id', '=', auth()->user()->id)
    ->where('main.status_user', '=', 'TRUE')
    ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
    ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
    ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
    ->join('users',    'users.id',              '=',   'rol_user.id_user')
    ->select('roles.id','rol_user.id as id_roluser')
    ->first();
  $roluser            = $rol{'id_roluser'};

  $rol_permiso        = Rol_permissions::where('id_roluser', '=', $roluser)->where('id_permission', $permiso)->first();

  if($rol_permiso || $rol{'id'}== 4){
    $ProcesoValidacionCond  = ProcesoValCond::where('id_proceso_validacion',$id_proceso_validacion)
    ->where('id_file_drivers', $idfiledrivers)->first();
    if ($id_proceso_validacion == 1){
      $file_divers = file_drivers::find($idfiledrivers);
      $tecnica     = technical_review::where('id_file_drivers', $idfiledrivers)->first();

      $anioactual  = date('Y');
      $aniocar     = $file_divers->year;
      $diferenciaYear = ($anioactual - $aniocar);
      if ($diferenciaYear > 3 && $diferenciaYear <= 5) {
        if (!$tecnica){
          $mensaje = "El vehiculo esta entre 3 y 4 años debe poseer revision tecnica WIN";
          $estatus = 0;
        }
      }

      else if ($diferenciaYear > 5) {
        if (!$tecnica && !$file_divers->technical_review){
          $mensaje=  "El vehiculo es mayor a 6 años debe poseer revision tecnica WIN y un documento tecnico cargado";
          $estatus = 0;
        }
      }
      else{
        $mensaje = "Actualizado de forma satisfactoria";
      }
    }else {
      $mensaje = "Actualizado de forma satisfactoria";
    }

    $datos = ['id_file_drivers' => $idfiledrivers, 'id_proceso_validacion' => $id_proceso_validacion,
              'estatus_proceso' => 1, 'approved' => $estatus ];
    if ($ProcesoValidacionCond){
      ProcesoValCond::find($ProcesoValidacionCond->id)->update($datos);
    }else {
      ProcesoValCond::create($datos);
    }

    return response()->json([
        "object"   => 'sucess',
        "mensaje"  => $mensaje,
      ]);

  }

  return response()->json([
      "object"   => 'sucess',
      "mensaje"  => "Si desea que este proceso sea aprobado debe contactar con un usuario autorizado",
    ]);

 }

 public function updateDriver(){
   $form = request()->form;
   $id   = request()->id;
   $data = request()->data;
   $mensaje =null; $observaciones = null;
   $flag    ='false';

   if ($form == 'formPersonal') {
     $default ='PERU';

    $old = User_office::find($id);
    $emailExiste = User_office::where('email',$data{'email'})->where('id', '!=', $id)->first();
    if ($emailExiste){     $observaciones  .="La direccion de CORREO esta asociado a otro conductor\n";    }

    $dniExiste = User_office::where('document',$data{'document'})->where('id_type_documents',$data{'id_type_documents'})->where('id', '!=', $id)->first();
    if ($dniExiste){  $observaciones      .= "El numero de DOCUMENTO DE IDENTIDAD esta asociado a otro conductor\n";  }
    else{

    }

    $phoneExiste = User_office::where('phone',$data{'phone'})->where('id','!=', $id)->first();
    if ($phoneExiste){ $observaciones     .= "El numero de TELEFONO esta asociado a otro conductor\n";    }

    $datos =[
      'first_name' => ($data{'first_name'} == null || $data{'first_name'} == '')? $old->first_name :  mb_strtoupper($data{'first_name'}),
      'last_name'  => ($data{'last_name'}  == null || $data{'last_name'}  == '')? $old->last_name  :  mb_strtoupper($data{'last_name'}),
      'email'      => ($data{'email'}      == null || $data{'email'}      == ''  || $emailExiste)? $old->email      :  $data{'email'},
      'document'        => ($data{'document'}        == null || $data{'document'}        == ''  || $dniExiste  )? $old->document        :  $data{'document'},
      'phone'      => ($data{'phone'}      == null || $data{'phone'}      == ''  || $phoneExiste)? $old->phone      :  $data{'phone'},
      'id_type_documents' => ($data{'id_type_documents'}      == null || $data{'id_type_documents'}      == ''  || $dniExiste)? $old->id_type_documents      :  $data{'id_type_documents'},
      'country'    => $default,
    ];
    $old = User_office::find($id)->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }

   if ($form == 'formConductor'){
    $old = file_drivers::find($id);
    $licenciaExiste = file_drivers::where('licencia',$data{'licencia'})->where('id', '!=', $id)->first();
    if ($licenciaExiste){      $observaciones = "El numero de LICENCIA esta asociado a otro conductor\n";    }

    $datos = [
      'licencia'        => ($data{'licencia'}        == null || $data{'licencia'}        == '' || $licenciaExiste )? $old->licencia     :   $data{'licencia'},
      'classcategoria'  => ($data{'classcategoria'}  == null || $data{'classcategoria'}  == '')? $old->classcategoria  :  mb_strtoupper($data{'classcategoria'}),
      'licfecemi'       => ($data{'licfecemi'}       == null || $data{'licfecemi'}       == '')? $old->licfecemi       :  $data{'licfecemi'},
      'licfecven'       => ($data{'licfecven'}       == null || $data{'licfecven'}       == '')? $old->licfecven       :  $data{'licfecven'},
    ];
    $old->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }

   if ($form == 'formVehiculo'){
    $old = file_drivers::find($id);
    $placaExiste = file_drivers::where('placa',$data{'placa'})->where('id', '!=', $id)->first();
    if ($placaExiste){      $observaciones = "El numero de PLACA esta asociado a otro conductor\n";    }

    $datos =[
      'placa'        => ($data{'placa'}        == null || $data{'placa'}        == '' || $placaExiste)? $old->placa        :  mb_strtoupper($data{'placa'}),
      'color_car'    => ($data{'color_car'}    == null || $data{'color_car'}    == '')? $old->color_car    :  mb_strtoupper($data{'color_car'}),
      'marca'        => ($data{'marca'}        == null || $data{'marca'}        == '')? $old->marca        :  $data{'marca'},
      'year'         => ($data{'year'}         == null || $data{'year'}         == '')? $old->year         :  $data{'year'},
    ];
    $old = file_drivers::find($id)->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones' => $observaciones];
   }

   if ($form == 'formSeguro'){
    $old = file_drivers::find($id);
    $datos =[
      'enterprisesoat'    => ($data{'enterprisesoat'}  == null || $data{'enterprisesoat'} == '')? $old->enterprisesoat :  mb_strtoupper($data{'enterprisesoat'}),
      'soatfecemi'        => ($data{'soatfecemi'}      == null || $data{'soatfecemi'}     == '')? $old->soatfecemi     :  $data{'soatfecemi'},
      'soatfecven'        => ($data{'soatfecven'}      == null || $data{'soatfecven'}     == '')? $old->marca          :  $data{'soatfecven'},
      'est_soat'          => ($data{'est_soat'}        == null || $data{'est_soat'}       == '')? $old->est_soat       :  $data{'est_soat'},

    ];
    $old = file_drivers::find($id)->update($datos);
    return ['flag' => 'true' , 'mensaje' => 'Actualizado Exitosamente', 'observaciones'=> $observaciones];
   }

   return ['flag' => $flag , 'mensaje' => $mensaje, 'observaciones'=> $observaciones];
 }

 public function updFile() {
   $data     =  request()->data;
   $upd;
   $dato = [ $data{'idinput'} => $data{'url'}];
   $upd = file_drivers::find($data{'id'})->update($dato);

   return 'true';
 }

 public function uploadView()
 {
   $main = new MainClass();
   $main = $main->getMain();

   $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');

     if (true){
       return view('external.drivers.uploadAntecedentes', compact('main','type_docs'));

     }else{
       return view('errors.403', compact('main'));
     }
 }

 public function getuserDri()
 {
   if(User_office::where(request(){'campo'},request(){'dar'})->exists())
   {
      $u =  User_office::where(request(){'campo'},request(){'dar'})->first();
//------------------------------------------------
$ch = curl_init('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$u->document);
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
   $u->first_name =  $a->first_name;
   $u->last_name = $a->last_name;


   if($u->first_name!=null || $u->first_name!="")
   {
     $u->save();


     return response()->json([
         "object"   => 'success',
         "data" =>$u
       ]);
    }
   else
   {
     return response()->json([
         "object"   => 'error',
         "message"=>"No Exsite El documento de identidad.",
       ]);
   }
}
//------------------------------------------------
   }else
   {
     return response()->json([
         "object"=> "error",
         "message"=>"No se encontro el ID"
     ]);
   }
 }

 public function saveAntecendetes()
 {
   $id = request()->id;
   $url = request()->voucherURL;
   $proceso = request()->proceso;
   $codigoproceso= request()->codigoproceso;
   $estatusproceso= request()->estatusproceso;
   $dni = request()->document;
   $nombre = request()->first_name;
   $ape = request()->last_name;
   $tipodocs = request()->tipo_doc;

   $datauserfile = User_office::where('id',$id)->first();
   $datauserfile->document = $dni;
   $datauserfile->first_name = $nombre;
   $datauserfile->last_name =  $ape;
   $datauserfile->id_type_documents = $tipodocs;
   $datauserfile->save();

   if(file_drivers::where('id_user_offices', $id)->exists())
   {
     $ddf = file_drivers::where('id_user_offices', $id)->first();
     $ddf->url_antecedentes = $url;
     $ddf->status_user = 9;
     $ddf->document = $dni;
     $ddf->save();

      $process_model =  ProcessTrace::where('id_file_drivers', $ddf->id)->where('id_process_model', $proceso)->first();
      $process_model->estatus = 1;
      $process_model->save();
      $procesoCond =[
       'id_file_drivers'        => $ddf->id,
       'id_proceso_validacion'  => $codigoproceso,
       'estatus_proceso'        => 1,
       'modified_by'            => auth()->user()->id,
       'approved'               => $estatusproceso
     ];
     ProcesoValCond::create($procesoCond);

     return response()->json([
         "object"=> "success",
         "message"=>"Se registro"
     ]);
   }
   else {
     $d = new file_drivers();
     $d->id_user_offices = $id;
     $d->url_antecedentes = $url;
     $d->status_user = 9;
     $d->document = $dni;
     $d->save();

     $process_model =  ProcessTrace::where('id_file_drivers', $d->id)->where('id_process_model', $proceso)->first();
     $process_model->estatus = 1;
     $process_model->save();
     $procesoCond =[
       'id_file_drivers'        => $d->id,
       'id_proceso_validacion'  => $codigoproceso,
       'estatus_proceso'        => 1,
       'modified_by'            => auth()->user()->id,
       'approved'               => $estatusproceso
     ];
     ProcesoValCond::create($procesoCond);

     return response()->json([
         "object"=> "success",
         "message"=>"Se registro"
     ]);
   }


 }



 public function reporteExcelRecord()
 {

   $id = request()->id;
   if(User_office::where('id_office',$id)->exists())
   {
     $u =  User_office::where('id_office',$id)->first();

     if(file_drivers::where('id_user_offices', $u->id)->exists())
     {

       $d = file_drivers::where('id_user_offices', $u->id)->with('getUserOffice','getStatusUser')->first();
       $records = Record_Driver::where('id_user_offices', $u->id)->get();
       $dp = $d->getUserOffice()->first();

       $licenciaval = file_get_contents('http://18.228.228.200/taxiwin/mtc.php?dni='.$dp->document, true);
       $licenciavals = json_decode($licenciaval);

       $fechaemi = $licenciavals->fechaemision;
       $fechaven = $licenciavals->fecharevalidacion;

       $first_name = $dp->first_name;
       $last_name = $dp->last_name;
       $dni = $dp->document;
       $licence = $licenciavals->nrolicencia;
       $clasecate = $licenciavals->clasecategoria;
       $estadolic = $licenciavals->estado;
       $licfecemi = date("Y-m-d", strtotime($fechaemi));
       $licfecven = date("Y-m-d", strtotime($fechaven));

       $pdf = PDF::loadView('external.drivers.reportRecordDriver',compact(
         'document',
         'first_name',
         'last_name',
         'licence',
         'clasecate',
         'estadolic',
         'licfecemi',
         'licfecven',
         'records'
       ));
       return $pdf->stream('reporteRecord.pdf');
     }else {
       return response()->json([
           "object"=> "error",
           "message"=>"El id no tiene imagenes"
       ]);
     }
   }else {
     return response()->json([
         "object"=> "error",
         "message"=>"No se encontro el ID"
     ]);
  }
 }

public function reportePDFRecord(){
      $u =  User_office::where('id',request()->id)->first();
      if(Record_Driver::where('id_user_offices', $u->id)->exists())
      {

        $d = file_drivers::where('id_user_offices', $u->id)->with('getUserOffice','getStatusUser')->first();
        $records = Record_Driver::where('id_user_offices', $u->id)->get();
        $dp = $d->getUserOffice()->first();

        $point = 0;
        foreach ($records as $key => $value) {
          $point +=$value->points_firmes;
        }


        // $licenciaval = file_get_contents('http://18.228.228.200/taxiwin/mtc.php?dni='.$dp->dni, true);
        // $licenciavals = json_decode($licenciaval);

        // $fechaemi = $licenciavals->fechaemision;
        // $fechaven = $licenciavals->fecharevalidacion;

        $first_name = $dp->first_name;
        $last_name = $dp->last_name;
        $dni = $dp->document;
        $licence = $d->licencia;
        $clasecate = $d->classcategoria;
        $estadolic = $d->est_licencia;
        $licfecemi = $d->licfecemi;
        $licfecven = $d->licfecven;

        $pdf = PDF::loadView('external.drivers.reportRecordDriver',compact(
          'document',
          'first_name',
          'last_name',
          'licence',
          'clasecate',
          'estadolic',
          'licfecemi',
          'licfecven',
          'records',
          'point'
        ));
        return $pdf->stream('reporteRecord.pdf');
      }else {
        return response()->json([
            "object"=> "error",
            "message"=>"El id no tiene record"
        ]);
      }
}




 function reportPDF()
 {


     if (true){

       $id = request()->id;
       if(User_office::where('id_office',$id)->exists())
       {
          $u =  User_office::where('id_office',$id)->first();

         if(file_drivers::where('id_user_offices', $u->id)->exists())
         {
           $d = file_drivers::where('id_user_offices', $u->id)->with('getUserOffice','getStatusUser')->first();
           $rr = Record_Driver::where('id_user_offices', $u->id)->get();
           $point = 0;

           foreach ($rr as $key => $value) {
             $point += $value->points_firmes;
           }

           $dni = $d->document;
           $dp= $d->getUserOffice()->first();
           $first_name = $dp->first_name;
           $last_name = $dp->last_name;
           $licencia = $d->licencia;
           $licfecemi = $d->licfecemi;
           $licfecven = $d->licfecven;
           $placa = $d->placa;
           $marca = $d->marca;
           $color = $d->color_car;
           $year = $d->year;
           $soatfecemi = $d->soatfecemi;
           $soatfecven = $d->soatfecven;
           $enterprisesoat = $d->enterprisesoat;
           $classcategoria = $d->classcategoria;
           $lic_frontal = $d->lic_frontal;
           $lic_back = $d->lic_back;
           $car_externa = $d->car_externa;
           $car_externa2 = $d->car_externa2;
           $car_externa3 = $d->car_externa3;
           $car_interna = $d->car_interna;
           $car_interna2 = $d->car_interna2;
           $tar_veh_back = $d->tar_veh_back;
           $tar_veh_frontal = $d->tar_veh_frontal;
           $doc_front = $d->doc_front;
           $doc_back = $d->doc_back;
           $photo_perfil = $d->photo_perfil;
           $soat_frontal = $d->soat_frontal;
           $soat_back= $d->soat_back;
           $recibo_luz = $d->recibo_luz;
           $revision_tecnica = $d->revision_tecnica;
           $revfecemi = $d->revfecemi;
           $revfecven = $d->revfecven;
           $pdf = PDF::loadView('external.drivers.reportDriver',compact(
             'document',
             'first_name',
             'last_name',
             'licencia',
             'licfecemi',
             'licfecven',
             'year',
             'color',
             'placa',
             'marca',
             'enterprisesoat',
             'classcategoria',
             'soatfecemi',
             'soatfecven',
             'doc_front',
             'doc_back',
             'lic_frontal',
             'lic_back',
             'car_externa',
             'car_externa2',
             'car_externa3',
             'car_interna',
             'car_interna2',
             'tar_veh_back',
             'tar_veh_frontal',
             'photo_perfil',
             'soat_frontal',
             'soat_back',
             'point',
             'recibo_luz',
             'revision_tecnica',
             'revfecemi',
             'revfecven'
           ));
           return $pdf->stream('reporte.pdf');
         }else
         {
           return response()->json([
               "object"=> "error",
               "message"=>"El id no tiene imagenes"
           ]);
         }


       }else
       {
         return response()->json([
             "object"=> "error",
             "message"=>"No se encontro el ID"
         ]);
       }


     }else{
       return view('errors.403', compact('main'));
 }
}
  //GET RECORD RANGO
  public function recordRango(){
    $recordSum   =  request(){'sum'};
    // var_dump($recordSum);
    $recordSum = (int)$recordSum;
    $sql = 'select * from winsystem.rango_record where '.$recordSum.'between rangoa and rangob';
    $evaluo =  DB::select($sql);
    return $evaluo;
  }

  //GESTION DE RECORD
  public function recordDriver($id){

    $dataArraySend =[];
    $datos =  file_drivers::where('id',$id)->with('getUserOffice')->first();
    $first_name = $datos->getuserOffice->first_name;
    $last_name  = $datos->getUserOffice->last_name;
    $dni        = $datos->getUserOffice->document;
    $recordSum = null;    $evaluo= null;

    // $datos =  User_office::where('id_office',$id)->first();
    // $first_name = $datos->first_name;
    // $last_name  = $datos->last_name;
    // $dni        = $datos->dni;
    $licenciaval = file_get_contents('http://18.228.228.200/taxiwin/mtc.php?dni='.$dni, true);
    $licenciavals = json_decode($licenciaval);
    if($licenciavals->sucess == "OK"){
      if($dni){
        $url = 'http://18.228.228.200/taxiwin/mtc_papeletas.php?dni='.$dni.'&type=xml';

        $xml  = file_get_contents($url);
        //if(isset($xml)){return null;}



        $xml  = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
        $xml  = simplexml_load_string($xml);





        $json = json_encode($xml);
        $responseArray = json_decode($json,true);

        if(isset($responseArray["sBody"]["SelBuscarLisResponse"]["SelBuscarLisResult"]["aLC_TM_Papeletas"]) ){
            $dataArray = $responseArray["sBody"]["SelBuscarLisResponse"]["SelBuscarLisResult"]["aLC_TM_Papeletas"];

                if (isset( $dataArray{'aCod_Administrado'} )){
                  $datos =[
                    'aCod_Falta'        => $dataArray{'aCod_Falta'},
                    'aNro_Papeleta'     => $dataArray{'aNro_Papeleta'},
                    'aEntidad'          => $dataArray{'aEntidad'},
                    'aPuntos_Saldo'     => $dataArray{'aPuntos_Saldo'},
                    'aPuntos_Firmes'    => $dataArray{'aPuntos_Firmes'},
                    'aFecha_Infraccion' => $dataArray{'aFecha_Infraccion'},
                    'aEstado'           => $dataArray{'aEstado'},
                  ];
                  array_push($dataArraySend, $datos);
                  $recordSum = $dataArray{'aPuntos_Firmes'};
                }
                else{
                  foreach ($dataArray as $key => $value) {
                    $datos =[
                      'aCod_Falta'        => $value{'aCod_Falta'},
                      'aNro_Papeleta'      => $value{'aNro_Papeleta'},
                      'aEntidad'          => $value{'aEntidad'},
                      'aPuntos_Saldo'     => $value{'aPuntos_Saldo'},
                      'aPuntos_Firmes'    => $value{'aPuntos_Firmes'},
                      'aFecha_Infraccion' => $value{'aFecha_Infraccion'},
                      'aEstado'           => $value{'aEstado'},
                    ];
                    $recordSum += $value{'aPuntos_Firmes'};
                    array_push($dataArraySend, $datos);
                  }
                }
        }
        else{
          $datos =[
            'aCod_Falta'        =>  null,
            'aNro_Papeleta'     =>  null,
            'aEntidad'          =>  null,
            'aPuntos_Saldo'     => '0',
            'aPuntos_Firmes'    => '0',
            'aFecha_Infraccion' => null,
            'aEstado'           => 'NO POSEE INFRACCIONES',
          ];
          array_push($dataArraySend, $datos);
          $recordSum = 0;

        }
      }
    }else{
      return [
        'data'      => [],
        'recordSum' => 100,
        'evaluo'    => 100,
      ];
    }

      if (isset($recordSum) ) {
        //select * from winsystem.rango_record where 70 between rangoa and rangob
        $sql = 'select * from winsystem.rango_record where '.$recordSum.'between rangoa and rangob';
        $evaluo =  DB::select($sql);
        // $evaluo =  RangoRecord::whereBetween($recordSum, ['rangoa', 'rangob'])->first();
      }

      return [
        'data'      => $dataArraySend,
        'recordSum' => $recordSum,
        'evaluo'    => $evaluo,
      ];

    }

  //GUARDAR DATOS DE RECORD
  public function saveRecord(){
    $id          =  request(){'id'};
    $id_estado   =  request(){'id_estado'};
    $recordSum   =  request(){'recordSum'};
    $tipo        =  request(){'tipo'};
    $proceso     =  request(){'proceso'};
    $codigoproceso= request(){'codigoproceso'};
    $noinfraccion = request(){'noinfraccion'};

    $keys        = [];
    $datos       =  file_drivers::where('id',$id)->with('getUserOffice')->first();
    //ESTATUS 6 ES APROBADO  //ESTATUS 7 ES REPROBAR
    $sql = 'select * from winsystem.rango_record where '.$recordSum.'between rangoa and rangob';
    $evaluo =  DB::select($sql);
    $record;

    if ($tipo == 'iframe'){
      if ($noinfraccion == 'false'){
        $records =  request(){'record'};
        $array2  =  json_decode($records, true);
        $array   = $array2["aCod_Falta[]"];

        //OBTIENDO LLAVES
        while($element = current($array)) {
          array_push($keys, key($array));
          next($array);
        }
        //RECORRIENDO AAREGLO
        foreach($keys as $r)
        {

          $record_driver = [
            'id_file_drivers'     =>  $datos->id,
            'id_user_offices'     =>  $datos->id_user_offices,
            'cod_falta'           =>  strtoupper($array2["aCod_Falta[]"][$r]),
            'papeleta'            =>  $array2['aNro_Papeleta[]'][$r],
            'entidad'             =>  strtoupper($array2['aEntidad[]'][$r]),
            'points_saldo'        =>  0,
            'points_firmes'       =>  $array2['aPuntos_Firmes[]'][$r],
            'dinfranccion'        =>  date("Y-m-d", strtotime($array2['aFecha_Infraccion[]'][$r])),
            'estado'              =>  'MANUAL',
            'modified_by'         =>  auth()->user()->id,
          ];

          $updateRecord  =  Record_Driver::where('papeleta', $array2["aNro_Papeleta[]"][$r])->first();
          if ($updateRecord){
            $id_record  = $updateRecord->id;
            $updateRecord->update($record_driver);
          }else{
            $id_record = Record_Driver::create($record_driver)->id;
          }
        }
      }

    }
    else{
      $records =  request(){'record'};
      $array   =  json_decode($records, true);
      // if($id_estado == 6 && $evaluo[0]->baprobado == true){
      // $records =  request(){'record'};
      // $array   =  json_decode($records, true);

      foreach ($array as $r => $valores) {

        $changedDate = null;
        $date = $valores{'aFecha_Infraccion'};
        if ($date){
          $res  = explode("/", $date);
          $changedDate = $res[2]."-".$res[1]."-".$res[0];
        }

        $record_driver = [
          'id_file_drivers'     =>  $datos->id,
          'id_user_offices'     =>  $datos->id_user_offices,
          'cod_falta'           =>  $valores{'aCod_Falta'},
          'papeleta'            =>  $valores{'aNro_Papeleta'},
          'entidad'             =>  $valores{'aEntidad'},
          'points_saldo'        =>  $valores{'aPuntos_Saldo'},
          'points_firmes'       =>  $valores{'aPuntos_Firmes'},
          'dinfranccion'        =>  $changedDate, //date("Y-m-d", strtotime($valores{'aFecha_Infraccion'})),
          'estado'              =>  $valores{'aEstado'},
          'modified_by'         =>  auth()->user()->id,
        ];
        $updateRecord  =  Record_Driver::where('papeleta', $valores{'aNro_Papeleta'})->first();
        if ($updateRecord){
          $id_record  = $updateRecord->id;
          $updateRecord->update($record_driver);
        }else{
          $id_record = Record_Driver::create($record_driver)->id;
        }
      }
      // }
      //
    }



    file_drivers::find($id)->update(['status_user' => $id_estado]);
    $process_model =  ProcessTrace::where('id_file_drivers', $id)->where('id_process_model', $proceso)->first();
    $process_model->estatus  = (($id_estado == 5 )? 1 : 0);
    $process_model->save();

    $procesoCond =[
       'id_file_drivers'        => $id,
       'id_proceso_validacion'  => $codigoproceso,
       'estatus_proceso'        => (($id_estado == 5 )? 1 : 0),
       'modified_by'            =>  auth()->user()->id
     ];
     ProcesoValCond::create($procesoCond);

    return "ACTUALIZADO CORRECTAMENTE";

  }

  //VALIDANDO EL PROCESO COMPLETO
  public function validarProceso(){
    $id_office        =  request(){'id_office'};
    $id_process       =  request(){'idproceso'};
    $process_model    =  ProcessModel::where('id', $id_process)->first();
    $procees_secAnt   =  ($process_model->sec_actual == 0)? 0 : $process_model->sec_actual-1;
    $procesoAnterior  =  ProcessTrace::where('sec_actual',$procees_secAnt)->orderby('updated_at', 'desc')->first();
    $user_offices     =  User_office::where('id_office',$id_office)->first();
    //VALIDAMOS SI EXISTE EL CODIGO
    if ($user_offices){
      $id_user_offices = $user_offices->id;
      $filedriver =  file_drivers::where('id_user_offices',$id_user_offices)->first();
        //VALIDAMOS SI HAY REGISTROS DE EL EN LA BD DE FILE DRIVER
        if (isset($filedriver)){

              $id_file_drivers = $filedriver->id;
              $process_trace  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)->first();
              if ($process_trace){
                //PROCESOS > 0

                if ($process_model->sec_actual != 0){

                  $process_trace_all =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                  ->where('sec_actual',$procesoAnterior->sec_actual)->first();

                   $process_trace_true  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                  ->where('sec_actual',$procesoAnterior->sec_actual)
                  ->where('estatus', true)
                  ->first();

                    if ($process_trace_all == $process_trace_true){
                      return 'true';
                    }
                }
                //cuando es 0
                else if ($process_model->sec_actual == 0) {

                  $process_trace_valid  =  ProcessTrace::where('id_file_drivers',$id_file_drivers)
                 ->where('sec_actual',$procees_secAnt)
                 ->where('id_process_model', $id_process)
                 ->orderBy('updated_at','desc')
                 ->first();
                 if ($process_trace_valid->estatus == null || $process_trace_valid->estatus == false){
                   return 'true';
                 }
                }


              }

              else{
                $respuesta =  $this->creandoTraza($id_file_drivers);
                if ($respuesta){
                  return "true";
                }
                //CREAMOS SU SESION EN FILE DRIVER
              }

        }
        //
        else{
          //CREAMOS SU FILE DRIVE Y LUEGO SESION EN FILE DRIVER
          $datos =[
            'id_user_offices'  => $id_user_offices,
          ];
          if ($procees_secAnt== 0){
            $id_file_drivers = file_drivers::create($datos)->id;
            $this->creandoTraza($id_file_drivers);
            return 'true';
          }
        }

    }else{
      return 'false';
    }
  }

  //GET DATOS
  public function getDataProceso() {
    $id          =  request(){'id'};
    $user_offices     =  User_office::where('id_office',$id)->first();
    //VALIDAMOS SI EXISTE EL CODIGO
    if ($user_offices){
      $id_user_offices = $user_offices->id;
      $filedriver        =  file_drivers::where('id_user_offices',$id_user_offices)->first();
      if($filedriver){
      $proceso_val_cond  = ProcesoValCond::where('id_file_drivers', $filedriver->id)->with('getProceso', 'getModifyBy')->get();
      if ($proceso_val_cond){
        return $proceso_val_cond;
      }
    }else{
      return null;
    }

    }
    return null;
    // code...
  }

  //creamos traza
  public function creandoTraza($id_file_drivers){
    $process_model =  ProcessModel::orderby('sec_actual', 'asc')->get();
    foreach ($process_model as $x) {
      $datos =[
        'id_file_drivers'  => $id_file_drivers,
        'id_process_model' => $x{'id'},
        'sec_actual'       => $x{'sec_actual'},
        'sec_sig'          => $x{'sec_sig'},
        'modified_by'      => auth()->user()->id,
      ];
      ProcessTrace::create($datos)->id;
    }
    return true;
  }
  //CONVERTIR FECHA A MILISEGUNDOS

  public function convertMilisegundos($f){
    return strtotime($f) * 1000;
  }

  //GESTION DE API INSERT APLICATIVO
  public function sendAppDataVehicle($id){


     $datos =  file_drivers::where('id',$id)->with('getUserOffice')->first();

     $insureF  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        =>  $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->soat_frontal,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];
     $insureP  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),
       'documentFileIds'       => [
         'fileUrl' => $datos->soat_back,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];
     $tarVehiF = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [
         'fileUrl' => $datos->tar_veh_frontal,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];
     $tarVehiP = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'INSURE DOCUMENTS',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [
         'fileUrl' => $datos->tar_veh_back,
         'fileName'=> 'INSURE DOCUMENTS'
       ],
     ];

     $vehicleDocuments[0] = $insureF;
     $vehicleDocuments[1] = $insureP;
     $vehicleDocuments[2] = $tarVehiF;
     $vehicleDocuments[3] = $tarVehiP;

     $vehicle = [
       'tenantId'              => 'tenantIdForWinRideShareDev000001', //VALIDAR
       'vehicleTypeId'         => '3a41f03e08484788baf35f0e74118e1d', //VALIDAR
       'makeModel'             => $datos->marca,
       'modelName'             => $datos->model,
       'vehicleNumber'         => $datos->placa,
       'modelYear'             => $datos->year,
       'vehicleDocumentInfo'   => $vehicleDocuments,
       'serviceAreaIds'        => [
           '780c138e4cc34ad9ac9052222327e1d7'
        ],
        'serviceTypeIds'        => [
            'tenantServiceTypes00000000000001',
         ],
     ];
     // var_dump(json_encode($vehicle, true));
     echo "Vehicle";
     echo('<pre>');
     var_dump ($vehicle);
     echo('</pre>');
   }


   public function sendAppDataDriver($id){

     $datos =  file_drivers::where('id',$id)->with('getUserOffice')->first();

     $dniF  = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'National card',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->doc_front,
         'fileName'=> 'National card'
       ],
     ];
     $dniP  = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'National card',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->doc_back,
         'fileName'=> 'National card'
       ],
     ];

     $licenciaF = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'Registration document',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->lic_frontal,
         'fileName'=> 'National card'
       ],
     ];
     $licenciaP = [
       'driverDocumentTypeId'  => 'driverDocumentType0000000000004',
       'name'                  => 'Registration document',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [
         'fileUrl' => $datos->lic_back,
         'fileName'=> 'National card'
       ],
     ];

     $driverDocuments[0] = $dniF;
     $driverDocuments[1] = $dniP;
     $driverDocuments[2] = $licenciaF;
     $driverDocuments[3] = $licenciaP;

     $driver = [
       'serviceAreaIds'        => [
           '780c138e4cc34ad9ac9052222327e1d7',
           '1641bcaaf8704b9486cff4f64209cdc7'
        ],
        'serviceTypeIds'        => [
          'tenantServiceTypes00000000000001',
          'tenantServiceTypes00000000000002'
        ],
        'vehicleTypeId'    => '3a41f03e08484788baf35f0e74118e1d', //VALIDAR
        'vehicleId'        => '58d9001882234ce197090e310e7d3569',
        'driverInfo'       => [
          'tenantId'       => 'tenantIdForWinRideShareDev000001', //VALIDAR
          'firstName'      => $datos->getUserOffice->first_name,
          'lastName'       => $datos->getUserOffice->last_name,
          'email'          => $datos->getUserOffice->email,
          'numCountryCode' => '+51',
          'phoneNum'       => $datos->getUserOffice->phone,
        ],
        'driverDocumentInfo' => $driverDocuments
     ];

       echo "Conductor";
       echo('<pre>');
       var_dump ($driver);
       echo('</pre>');
    }

    public function getCustomerValidate(){
    $typesearc = request()->search;
    if (Customer::where('document',"70848650")->exists()){
        $data = Customer::where('document',"70848650")->with('getDtTypeCustomer','getCountry','getState','getCity')->first();
        if ($typesearc == "Conductor"){
            $datas    =  array(
                      "dni"                => "".request()->document."",
                      "id_type_document"  => 1);
            $string  = json_encode($datas);
            $datos   = json_decode($string);

            $ch = curl_init('https://test.conductores.wintecnologies.com/api/driver/getDriverNrodoc');
                  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                      'Content-Type: application/json',
                      'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
                  );
              $cQ = curl_exec($ch);
              $datos  = json_decode($cQ);

            if ($datos->object == "success"){
              $object  = "success";
              $message = $datos->message;
              $datacond = $datos->datacond;
              $type = 2;
            }else{
              $message = $datos->message;
              $object = "error";
              $datacond = null;
              $type = null;
            }
        }else if($typesearc == "Accionista"){
          if (dtCustomerType::where('id_customer', $data->id)->where('id_customerType',4)->exists()){
            $datacond = null;
            $message = 'ACCIONISTA ENCONTRADO CORRECTAMENTE';
            $object = 'success';
            $type = 4;
          }else{
            $message = 'NO SE ENCUENTRA REGISTRADO COMO ACCIONISTA';
            $object = 'error';
            $datacond = null;
            $type = null;
          }
        }else{
          $message  = 'CLIENTE ENCONTRADO CORRECTAMENTE';
          $datacond = null;
          $object   = 'success';
          if ($typesearc == "Pasajero"){
            $type = 3;
          }else if ($typesearc == "Embajador"){
            $type = 5;
          }else{
            $type = 1;
          }
        }
        return response()->json([
         'object'   => $object,
         'data'     => $data,
         'datacond' => $datacond,
         'type'     => $type,
         'message'  => $message,
         'portal'   => 'interno'
        ]);
    }else{
      if ($typesearc == "Pasajero"){
        $data1    =  array(
                  "dni"                => "".request()->dni."",
                  "id_type_documents"  => request()->type);
        $string  = json_encode($data1);

        $ch = curl_init('https://pasajeros.wintecnologies.com/api/customer/getPassenger');
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json',
                  'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
              );
          $cQ = curl_exec($ch);
          $datos  = json_decode($cQ);

          if ($datos->object == "error"){
          if (request()->type == 1){
             $val  = $this->reniecPeruApi2(request()->dni);
             $val2 =  $this->reniecPeruApi1(request()->dni);
             if ($val->object == true){
               $data = $val;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else if ($val2->object == true){
               $data  = $val2;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else{
               $a = new stdClass();
               $a->first_name = null;
               $a->last_name  = null;
               $a->date_birth = null;
               $data = $a;
               $object = "error";
               $message = "EL DNI NO SE ENCUENTRA";
             }
          }else{
            $a = new stdClass();
            $a->first_name = null;
            $a->last_name  = null;
            $a->date_birth = null;
            $data = $a;
            $object = "success";
            $message = "COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
          }

          return response()->json([
            'object'  => $object,
            'message' => $message,
            'type'    => 3,
            'data'    => $data,
            'portal'  => 'reniec'
         ]);
        }else{
          $data = $datos->data;
          $object  = $datos->object;
          $message = $datos->message;
          $type = 3;

           return response()->json([
            'object'  => $object,
            'message' => $message,
            'type'    => $type,
            'data'    => $datos->data,
            'portal'  => 'webpasajero'
          ]);
        }
      }

      if($typesearc == "Usuario" || $typesearc == "Embajador"){
          if (request()->type == 1){
             $val  = $this->reniecPeruApi2(request()->dni);
             $val2 =  $this->reniecPeruApi1(request()->dni);
             if ($val->object == true){
               $data = $val;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else if ($val2->object == true){
               $data  = $val2;
               $object = "success";
               $message = "DNI ENCONTRADO CORRECTAMENTE";
             }else{
               $a = new stdClass();
               $a->first_name = null;
               $a->last_name  = null;
               $a->date_birth = null;
               $a->dni = null;
               $data = $a;
               $object = "error";
               $message = "EL DNI NO SE ENCUENTRA";
             }
          }else{
            $a = new stdClass();
            $a->first_name = null;
            $a->last_name  = null;
            $a->date_birth = null;
            $a->dni = null;
            $data = $a;
            $object = "success";
            $message = "COLOCAR CORRECTAMENTE SUS NOMBRES Y APELLIDOS";
          }

          if ($typesearc == "Usuario"){
            $tpe = 1;
          }else if ($typesearc == "Embajador"){
            $tpe = 5;
          }

          return response()->json([
              'object'  => $object,
              'message' => $message,
              'type'    => $tpe,
              'data'    => $data,
              'portal'  => 'reniec'
           ]);
       }

       if($typesearc == "Accionista"){
           $data = null;
           $message = 'NO SE ENCUENTRA REGISTRADO COMO ACCIONISTA';
           $datacond = null;
           $object = 'error';

           return response()->json([
            'object'   => $object,
            'data'     => $data,
            'datacond' => $datacond,
            'type'     => null,
            'message'  => $message,
            'portal'   => 'valaccionista'
           ]);
        }

        if ($typesearc == "Conductor"){
          $datas    =  array(
                    "dni"               => request()->dni,
                    "id_type_document"  => 1);
          $string  = json_encode($datas);
          $datos   = json_decode($string);

          $ch = curl_init('https://test.conductores.wintecnologies.com/api/driver/getDriverNrodoc');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
                );
          $cQ = curl_exec($ch);
          $datos  = json_decode($cQ);

          if ($datos->object == "success"){
            $data = $datos->data;
            $object  = "success";
            $message = $datos->message;
            $datacond = $datos->datacond;
            $type = 2;
          }else{
            $message = $datos->message;
            $object = "error";
            $datacond = null;
            $type = null;
            $data = null;
          }

          return response()->json([
           'object'   => $object,
           'data'     => $data,
           'datacond' => $datacond,
           'type'     => $type,
           'message'  => $message,
           'portal'   => 'webconductor'
          ]);
      }

  }
}

}
