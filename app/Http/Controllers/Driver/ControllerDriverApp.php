<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\External\file_drivers;
use App\Models\External\User_office;
use App\Models\External\ProcesoValCond;
use App\Models\External\ProcesoValidacion;
use App\Models\External\DriverApi;
use App\Models\External\VwProcesosTotal;
use App\Models\External\DriverDocuments;
use App\Models\External\VehicleDocuments;
use App\Models\External\ServiceArea;
use App\Models\External\ServiceType;
use App\Classes\MainClass;
use Intervention\Image\ImageManagerStatic as Image;

use \PDF;
use \stdClass;
use Response;
use File;


class ControllerDriverApp extends Controller
{
  public function __construct(){
		$this->middleware('auth');
	}

  //CONEXION DE JS
  public function validDriverProcess() {
   $id          =  request(){'id_office'};
   $flag        = 'false';
   $mensaje     = null;
   $user_offices =  User_office::where('id_office',$id)->first();
   $cantpvc = 0;
   if(file_drivers::where('id_user_offices', $user_offices->id)->exists()){
      $file_driver = file_drivers::where('id_user_offices', $user_offices->id)->with('getUserOffice','getStatusUser')->first();

      //TRAZA DE PROCESO
      $proceso_validacion  = ProcesoValidacion::select('id')->where('estatus', true)->where('obligatorio', true)->get()->toarray();
      $cantpv = count($proceso_validacion);


      foreach ($proceso_validacion as $key ) {
        $proceso_val_cond    = ProcesoValCond::where('id_proceso_validacion', $key{'id'})
        ->where('id_file_drivers',$file_driver->id)->where('approved', true)->first();
        if($proceso_val_cond){
          ++$cantpvc;
        }
      }
      if ($cantpv = $cantpvc){

        if(!$file_driver->soat_frontal || !$file_driver->soat_back){
          $mensaje = "Debe contener los documentos del SOAT\n";
        }
        if (!$file_driver->tar_veh_frontal || !$file_driver->tar_veh_back){
          $mensaje .= "Debe contener los documentos de la TARJETA VEHICULAR\n";
        }
        if (!$file_driver->doc_front || !$file_driver->doc_back){
          $mensaje .= "Debe contener los documentos del DNI\n";
        }
        if (!$file_driver->lic_frontal || !$file_driver->lic_back){
          $mensaje .= "Debe contener los documentos de la LICENCIA\n";
        }
        if (!$file_driver->photo_perfil ){
          $mensaje .= "Debe contener la FOTO DE PERFIL\n";
        }
        if (!$file_driver->car_externa ){
          $mensaje .= "Debe contener la FOTO DEL AUTO \n";
        }
        if ($mensaje == null){
          $flag ='true';
        }

      }
   }
    return ['flag' =>  $flag, 'mensaje' => $mensaje];

  }

   //CONEXION DE JS
  public function getModalValidate() {
   return $this->getMetadataApi();
  }

  //CONEXION DE JS
  public function getDataSending(){

     $id_office   = request()->data{'id_file_drivers_send'};
     $data        = request()->data;
     $flag ='false';
     $mensaje = null;
     $data{'serviceAreaList'} =  is_array($data{'serviceAreaList'}) ? $data{'serviceAreaList'}  : $data{'serviceAreaList'} = [$data{'serviceAreaList'}];
     $data{'serviceTypeList'} =  is_array($data{'serviceTypeList'}) ? $data{'serviceTypeList'}  : $data{'serviceTypeList'} = [$data{'serviceTypeList'}];

     $user_offices     =  User_office::where('id_office',$id_office)->first();
     //VALIDAMOS SI EXISTE EL CODIGO
     if ($user_offices){
       $id_user_offices = $user_offices->id;
       $filedriver =  file_drivers::where('id_user_offices',$id_user_offices)->first();
         $vehicleId = $this->sendAppDataVehicle($filedriver->id,$id_office, $data);
         if($vehicleId != false){
           $driverId = $this->sendAppDataDriver($filedriver->id,$id_office, $data, $vehicleId);
           if($driverId != false){
             $datos =[
               'id_file_drivers'=>$filedriver->id,$id_office,
               'driverid'       =>$driverId,
               'vehicleid'      =>$vehicleId,
             ];
             DriverApi::create($datos);
             $flag = 'true';
             $mensaje =  'SE APROBO EXITOSAMENTE EL CONDUCTOR';
           }
         }
     }
     return ['mensaje' => $mensaje, 'flag'=> $flag];
   }


   //INTERNA

  //APROBACION DEL VEHICULO
  public function getDataSendingVehicle(){

     $id   = request()->data{'id_file_drivers_send'};
     $data = request()->data;

     $flag ='false';
     $mensaje = null;
     $data{'serviceAreaList'} =  is_array($data{'serviceAreaList'}) ? $data{'serviceAreaList'}  : $data{'serviceAreaList'} = [$data{'serviceAreaList'}];
     $data{'serviceTypeList'} =  is_array($data{'serviceTypeList'}) ? $data{'serviceTypeList'}  : $data{'serviceTypeList'} = [$data{'serviceTypeList'}];

     foreach ($data{'serviceAreaList'}  as $v) {
       if(ServiceArea::where('id_file_drivers',$id)->exists() ){
        ServiceArea::where('id_file_drivers',$id)->delete();
       }
        $datos       = ['id_file_drivers' => $id, 'service_area' => $v];
        ServiceArea::create($datos);
     }

     foreach ($data{'serviceTypeList'}  as $v) {
       if(ServiceType::where('id_file_drivers',$id)->exists() ){
        ServiceType::where('id_file_drivers',$id)->delete();
       }
        $datos       = ['id_file_drivers' => $id, 'service_type' => $v];
        ServiceType::create($datos);
     }

     $filedriver =  file_drivers::where('id',$id)->with('getUserOffice')->first();
     $vehicleId  = $this->sendAppDataVehicle($id,$filedriver->getUserOffice->id_office, $data);

    if($vehicleId != false){

         $datosapi = [
          'id_file_drivers' => $id,
          'vehicleTypeList' => $data{'vehicleTypeList'},
          'vehicleid'=> $vehicleId,
          'tenantid' => $data{'tenantId'}
        ];

         $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
         if($driveapi){
           $update =  DriverApi::find($driveapi->id);
           $update = $update->update((array)$datosapi);
         }
         else{
           DriverApi::create($datosapi);
         }

         $flag = 'true';
         $mensaje =  'SE APROBO EXITOSAMENTE EL VEHICULO';

       }

    return ['mensaje' => $mensaje, 'flag'=> $flag];
  }


  public function getDriverAproveds() {
    $main   = new MainClass();
    $main   = $main->getMain();
    // code...
    return view('external.drivers.aprovedlist', compact('main'));
  }
  //INTERNA CONSULTA
  public function getDriverAprovedsView() {
    if (request()->ajax( )){

      $drivers=[];
      //TRAZA DE PROCESO
      $proceso_validacion  = ProcesoValidacion::select('id')->where('estatus', true)->where('obligatorio', true)->get()->toarray();
      $cantpv = count($proceso_validacion);

      $procesototal = VwProcesosTotal::select('id_file_drivers')->where('cant_procesos', '>=', $cantpv)->get();
      $file_driver  = file_drivers::whereIn('id', $procesototal)->with('getUserOffice')->get();

      foreach ($file_driver as $k) {
        $default    = '<i class="glyphicon glyphicon-ban-circle"></i>';
        $final      = '<i class="glyphicon glyphicon-ok-circle"></i>';
        $driverapi  = DriverApi::where('id_file_drivers', $k->id)->first();

        $vehicleid  = null;   $driverid   = null;   $migrado    = null;   $estatusapi = null;
        $documents  =  '<a onclick="validarDriverProceso('.$k->getUserOffice->id_office.','.$k->id.',\'documentos\')"><i class="glyphicon glyphicon-ban-circle"></i><a>';

        if ($driverapi){
          if($driverapi->documents == true){
            $documents = ($driverapi->vehicleid == null)? '<a onclick="validarDriverProceso('.$k->getUserOffice->id_office.','.$k->id.',\'documentos\')"><i class="glyphicon glyphicon-arrow-up"></i><a>' : $final;

            if ($driverapi->vehicleid == null){
              $vehicleid  = '<a onclick="validarDriverProceso('.$k->getUserOffice->id_office.','.$k->id.',\'vehiculos\')" ><i class="glyphicon glyphicon-ban-circle"></i><a>';
              $driverid = $default;
            }else{
              $vehicleid = $final;
              $driverid  = ($driverapi->driverid == null) ?  '<a onclick="validarDriverProceso('.$k->getUserOffice->id_office.','.$k->id.',\'driver\')" ><i class="glyphicon glyphicon-ban-circle"></i><a>' : $final;
            }
          }

          $migrado    = ($driverapi->migrado    == true)? $driverapi->dmigrado : $default ;
          $estatus    = ($driverapi->estatusapi == true)? 'ok': 'ban';
          $estatusapi = ($driverapi->dmigrado)? '<a onclick="estatusUpload('.$k->getUserOffice->id_office.','.$k->id.')"><i class="glyphicon glyphicon-'.$estatus.'-circle"></i><a>' :  $default;
        }



        $datos =[
          'id'          => $k->id,
          'id_office'   => $k->getUserOffice->id_office,
          'document'         => $k->getUserOffice->document,
          'first_name'  => $k->getUserOffice->first_name,
          'last_name'   => $k->getUserOffice->last_name,
          'documentos'  => ($documents  == null) ?  $default : $documents,
          'vehiculo'    => ($vehicleid  == null) ?  $default : $vehicleid,
          'driver'      => ($driverid   == null) ?  $default : $driverid,
          'estatusapi'  => ($estatusapi == null) ?  $default : $estatusapi,
          'migrado'    =>  ($migrado    == null) ?  $default : $migrado,
        ];

        array_push($drivers, $datos);
      }
      return response()->json([
        'data' => $drivers,
      ]);
    }

  }
  //BUTON UP DOCUMENTOS
  public function upDocumentos() {
    $id          =  request(){'id'};
    $id_office   =  request(){'id_office'};
    $datos       =  file_drivers::where('id',$id)->with('getUserOffice')->getQuery()->first();
    $array   = []; $array2  = [];
    $flag    = true;
    $mensaje = 'Registrado existosamente';

    $vehicledoc = array("soat_back", "soat_frontal", "tar_veh_frontal", "tar_veh_back" , "car_externa");
    $driverdoc  = array("lic_frontal", "lic_back","doc_front","doc_back", "photo_perfil");

    foreach ($vehicledoc as $values) {
      $url = $datos->$values;
      $array[$values] = $url;
    }
    foreach ($driverdoc as $values)  {
      $url = $datos->$values;
      $array2[$values] = $url;
    }


    foreach ($array  as $key => $value) {
      $datos =  ['id_file_drivers'=> $id, 'fileurl'=> $this->fileDocumentUpload($value, $key),    'tpdocument'=> ''.$key.''];
      if ($url){
        $valorExiste = VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', ''.$key.'')->first();
        if($valorExiste){
          $update =  VehicleDocuments::find($valorExiste->id);
          $update = $update->update((array)$datos);
        }else{
          VehicleDocuments::create($datos);
        }
      }
    }

    foreach ($array2 as $key => $value) {
      $datos =  ['id_file_drivers'=> $id, 'fileurl'=> $this->fileDocumentUpload($value,$key),    'tpdocument'=> ''.$key.''];
      if ($url){
        $valorExiste = DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', ''.$key.'')->first();
        if($valorExiste){
          $update =  DriverDocuments::find($valorExiste->id);
          $update = $update->update((array)$datos);
        }else{
          DriverDocuments::create($datos);
        }
      }
    }

    $datosapi = ['id_file_drivers' => $id, 'documents' => true];
    $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
    if($driveapi){
      $update =  DriverApi::find($driveapi->id);
      $update = $update->update((array)$datosapi);
    }else{
      DriverApi::create($datosapi);
    }


    return ['flag'=>$flag, 'mensaje'=>$mensaje];


  }

  //BUTTON DE Driver
  public function upDriver(){
    $id          =  request(){'id'};
    $id_office   =  request(){'id_office'};
    $flag = 'false';
    $mensaje =  'ERROR';
    $dt = new \DateTime();
    $fecha = $dt->format('Y-m-d');

    // return $this->sendAppDataDriver($id);
    $driverid =  json_decode($this->sendAppDataDriver($id));

     if (isset($driverid->general[0]->messageCode)){
       return ['flag' => $flag , 'mensaje'=> $driverid->general[0]->messageCode];
     }
     else{

        $datosapi = [
          'id_file_drivers' => $id,
          'driverid'   => $driverid->driverId,
          'migrado'    => true,
          'estatusapi' => true,
          'dmigrado'   => $fecha,
        ];

         $driveapi  = DriverApi::where('id_file_drivers',$id)->first();
         if($driveapi){
           $update =  DriverApi::find($driveapi->id);
           $update = $update->update((array)$datosapi);
         }
         else{
           DriverApi::create($datosapi);
         }

         $flag = 'true';
         $mensaje =  'SE APROBO EXITOSAMENTE EL CONDUCTOR';
      }

    return ['mensaje' => $mensaje, 'flag'=> $flag];
  }

  //  INTERNA SENDING
  public function  getMetadataApi() {

      $vehicleTypeList = [];     $vehicleDocumentTypeList = [];     $serviceAreaList = [];
      $serviceTypeList = [];     $driverDocumentTypeList  = [];

      $ch = curl_init($this->setUrlApi().'/metadata');
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'content-type:application/json',
                    $this->setToken(),
                   'Accept-Language:en'
                  ));

      $result   = curl_exec($ch);
      $myArray  = json_decode($result);

      $tenantId = $myArray->tenantId;

      foreach ($myArray->vehicleTypeList         as $k) {
        $select = [
          'value' => $k->id,
          'name'  => strtoupper($k->name),
        ];
        array_push($vehicleTypeList, $select);
      }

      foreach ($myArray->vehicleDocumentTypeList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => mb_strtoupper($k->name),
        ];
        array_push($vehicleDocumentTypeList, $select);
      }

      foreach ($myArray->driverDocumentTypeList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => mb_strtoupper($k->name),
        ];
        array_push($driverDocumentTypeList, $select);
      }

      foreach ($myArray->serviceAreaList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => mb_strtoupper($k->name),
        ];
        array_push($serviceAreaList, $select);
      }

      foreach ($myArray->serviceTypeList as $k) {
        $select = [
          'value' => $k->id,
          'name'  => strtoupper($k->serviceType),
        ];
        array_push($serviceTypeList, $select);
      }

      $datosSelect =[
        'tenantId'              => $tenantId,
        'vehicleTypeList'        => $vehicleTypeList,
        'vehicleDocumentTypeList'=> $vehicleDocumentTypeList,
        'serviceAreaList'        => $serviceAreaList,
        'serviceTypeList'        => $serviceTypeList,
      ];

      return $datosSelect;
  }
  //  INTERNA
  private function convertMilisegundos($f){
    return strtotime($f) * 1000;
  }
  //  INTERNA
  private function getCurlValue($filename, $contentType, $postname){
    if (function_exists('curl_file_create')) {
      return curl_file_create($filename, $contentType, $postname);
    }

    $value = "@{$filename};filename=" . $postname;
    if ($contentType) {    $value .= ';type=' . $contentType;     }

    return $value;
  }

  //  INTERNA
  private function setUrlApi(){
    // return 'https://demoapi.winrideshare.com/api/tenantIdForWinRideShareDemo00001/';
    return 'https://api.winrideshare.com/api/T0001/';
  }

  //  INTERNA
  private function setToken(){
    // return 'secret-token:7CEA169C98FED3EA8336FBC69647D';
    return 'secret-token:BDCH349C98FED3EA8336FBC69647D7CEA169C98FED3EA8336FBCKJ45HJ';
  }

  //  INTERNA
  private function fileDocumentUpload($url, $key) {

      $info     = pathinfo($url);
      // $nameFile = $info['basename'];
      // $nameFile = explode('?', $nameFile);
      // $nameFile = explode('%', $nameFile[0]);
      $nameFile = $key.'.jpg';

      $contents = file_get_contents($url);
      $file = 'tmp\\'.$key.'.jpg';

      // $image_resize  = Image::make($contents);
      // $image_resize->resize(600, 600);
      // $image_resize->save(public_path($file));
      file_put_contents($file, $contents);

      $uploaded_file = new File($file, $info['basename']);



      $public_path   = public_path();
      $rutaFile      = $public_path."\\".$file;
      $cfile = $this->getCurlValue($rutaFile,'image/jpeg', $nameFile);
      $data = array('file[]' => $cfile);

      $ch = curl_init($this->setUrlApi().'/doc-upload');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'content-type:multipart/form-data',
              $this->setToken()
            ));

        $result   = curl_exec($ch);
        $myArray  = json_decode($result);
        if ($myArray->originalFileName){
          File::delete($rutaFile);
          return $myArray->fileId;
        }
   }

  //ESTATUS DEL CONDUSTOR
  public function driverStatusApi(){
     // return "hola";

    $id          =  request(){'id'};
    $id_office   =  request(){'id_office'};
    $driverid    =  DriverApi::where('id_file_drivers',$id)->getQuery()->first()->driverid;
    $estatus     =  DriverApi::where('id_file_drivers',$id)->getQuery()->first()->estatusapi;
    $mensaje = null;
    $flag    = null;
    $llave   = 1;

    $statusDriver = [
       'driverId' => $driverid,
       'approved' => ($estatus == true ) ? false : true
     ];
     if ($statusDriver{'approved'} == false){
       $llave = 0;
     }


     $statusDriver = json_encode($statusDriver);

       $ch = curl_init($this->setUrlApi().'/driver/approval-status');
               curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_POSTFIELDS,$statusDriver);
               curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                 'content-type:application/json',
                 $this->setToken(),
                 'Accept-Language:en'
              ));

       $result   = curl_exec($ch);
       $myArray  = json_decode($result);
       // return $result;
       if (isset($myArray->message)){

         $file_drivers   =  DriverApi::where('id_file_drivers',$id)->first();
         $estatus        =  DriverApi::find($file_drivers->id);
         $estatus->estatusapi = $llave;
         $estatus->save();

         $mensaje  =$myArray->message;
         $flag    = 'true';
         return ['mensaje' => $mensaje, 'flag'=> $flag];
       }

       $mensaje = 'Error al realizar actualización de estatus.';
       $flag    = 'false';
       return ['mensaje' => $mensaje, 'flag'=> $flag];

   }

  //  INTERNA SENDING
  private function sendAppDataVehicle($id, $id_office, $data){

      $tenantId         = $data{'tenantId'};
      $serviceAreaList  = $data{'serviceAreaList'};
      $serviceTypeList  = $data{'serviceTypeList'};
      $vehicleTypeList  = $data{'vehicleTypeList'};
      $id_office        = $id_office;

      $datos       =  file_drivers::where('id',$id)->with('getUserOffice')->first();
      $insureF  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000002',
       'name'                  => 'Insurance Document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'soat_frontal')->first()->fileurl,
         'fileName'=>  'Insurance Document',
       ]],
      ];
      $insureP  = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000002',
       'name'                  => 'Insurance Document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->soatfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->soatfecven),
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'soat_back')->first()->fileurl,
         'fileName'=> 'Insurance Document',
       ]],
      ];
      $tarVehiF = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'Registration document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'tar_veh_frontal')->first()->fileurl,
         'fileName'=> 'Registration document',
       ]],
      ];
      $tarVehiP = [
       'vehicleDocumentTypeId' => 'vehicleDocumentType0000000000001',
       'name'                  => 'Registration document',
       'documentNumber'        => $id_office,
       'dateOfIssue'           => $this->convertMilisegundos($datos->tar_vehfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->tar_vehfecven),
       'documentFileIds'       => [[
         'fileUrl' => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'tar_veh_back')->first()->fileurl,
         'fileName'=> 'Registration document'
        ]]
      ];

      $vehicleDocuments[0] = $insureF;
      $vehicleDocuments[1] = $insureP;
      $vehicleDocuments[2] = $tarVehiF;
      $vehicleDocuments[3] = $tarVehiP;

      $vehicle = [
        'vehicleInfo' =>[
          'tenantId'              => $tenantId, //VALIDAR
          'vehicleTypeId'         => $vehicleTypeList, //VALIDAR
          'makeModel'             => $datos->marca,
          'modelName'             => $datos->model,
          'vehicleNumber'         => $datos->placa,
          'modelYear'             => $datos->year,
          'vehicleImage'          => VehicleDocuments::where('id_file_drivers',$id)->where('tpdocument', 'car_externa')->first()->fileurl,
        ],
       'vehicleDocumentInfo'   => $vehicleDocuments,
       'serviceAreaIds'        => $serviceAreaList,
       'serviceTypeIds'        => $serviceTypeList
      ];
      $vehicle = json_encode($vehicle);

      $ch = curl_init($this->setUrlApi().'/add-vehicle');
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS,$vehicle);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'content-type:application/json',
                   $this->setToken()
                  ));

      $result   = curl_exec($ch);
      $myArray  = json_decode($result);
      if (isset($myArray->vehicleId)){
        return $myArray->vehicleId;
      }
      return false;
  }

  //  INTERNA SENDING
  private function sendAppDataDriver($id){
    $serviceAreaListQ =  ServiceArea::select(array('service_area'))->where('id_file_drivers',$id)->get()->toArray();
    $serviceTypeListQ =  ServiceType::select('service_type')->where('id_file_drivers',$id)->get()->toarray();
    $serviceTypeList =[];    $serviceAreaList =[];

    foreach ($serviceAreaListQ as $key) {
      array_push($serviceAreaList, $key{'service_area'});
    }

    foreach ($serviceTypeListQ as $key) {
      array_push($serviceTypeList, $key{'service_type'});
    }

     $datos =  file_drivers::where('id',$id)->with('getUserOffice')->first();

     $dniF  = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000005',
       'name'                  => 'National card',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'doc_front')->first()->fileurl,
         'fileName'=> 'National card'
       ]],
     ];
     $dniP  = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000005',
       'name'                  => 'National card',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->dnifecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->dnifecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'doc_back')->first()->fileurl,
         'fileName'=> 'National card'
       ]],
     ];

     $licenciaF = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000001',
       'name'                  => 'Driving License - DL',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'lic_frontal')->first()->fileurl,
         'fileName'=> 'Driving License - DL'
       ]],
     ];
     $licenciaP = [
       'driverDocumentTypeId'  => 'driverDocumentType00000000000001',
       'name'                  => 'Driving License - DL',
       'documentNumber'        => $datos->id_user_offices,
       'dateOfIssue'           => $this->convertMilisegundos($datos->licfecemi),
       'dateOfExpiry'          => $this->convertMilisegundos($datos->licfecven),//; $datos->soatfecven,
       'documentFileIds'       => [[
         'fileUrl' => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'lic_back')->first()->fileurl,
         'fileName'=> 'Driving License - DL'
       ]],
     ];

     $driverDocuments[0] = $dniF;
     $driverDocuments[1] = $dniP;
     $driverDocuments[2] = $licenciaF;
     $driverDocuments[3] = $licenciaP;

     $driver = [
        'serviceAreaIds'   => $serviceAreaList,
        'serviceTypeIds'   => $serviceTypeList,
        'vehicleTypeId'    => DriverApi::where('id_file_drivers',$id)->first()->vehicleTypeList, //VALIDAR
        'vehicleId'        => DriverApi::where('id_file_drivers',$id)->first()->vehicleid,
        'driverInfo'       => [
          'tenantId'       => DriverApi::where('id_file_drivers',$id)->first()->tenantid, //VALIDAR
          'firstName'      => $datos->getUserOffice->first_name,
          'lastName'       => $datos->getUserOffice->last_name,
          'email'          => $datos->getUserOffice->email,
          'numCountryCode' => '+51',
          'phoneNum'       => $datos->getUserOffice->phone,
          'userDetails'    => [
            "profileImage" => DriverDocuments::where('id_file_drivers',$id)->where('tpdocument', 'photo_perfil')->first()->fileurl,
          ],
         ],
        'driverDocumentInfo' => $driverDocuments,
        'approved'           => 'true'
     ];
        //  return (($driver));
     $driver = json_encode($driver);

     $ch = curl_init($this->setUrlApi().'/add-driver');
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS,$driver);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'content-type:application/json',
                  $this->setToken()
                 ));

     $result   = curl_exec($ch);
     return $result;

    }




}
