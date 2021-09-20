<?php

namespace App\Http\Controllers\Driver\Externo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\External\file_drivers;
use App\Models\External\User_office;
use App\Models\External\technical_review;
use App\Models\External\ProcessTrace;
use App\Models\External\Record_Driver;
use App\Models\External\ProcesoValCond;
use App\Models\External\ProcesoValidacion;
use App\Classes\MainClass;
use App\Models\General\Main;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\City;
use App\Models\General\User;
use App\Models\General\Type_document_identy;
use \stdClass;
use \PDF;

class ExternalDriverController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }

    public function index(){
        if(auth()->user()){
            $main = new MainClass();
            $main = $main->getMain();
            $title ='Conductores';
            $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
            return view('external.drivers.drivers',compact('title', 'main','type_docs'));
        }
    }
    public function schedule(){
        if(auth()->user()){
            $main = new MainClass();
            $main = $main->getMain();

           $title ='Conductores';
           return view('external.drivers.schedule',compact('title', 'main'));
        }
    }

    public function getUsers(Request $r){
      $idoffice = request()->id;

      $user = User_office::where("id_office",$idoffice)
      ->first();

      if(User_office::where('id_office', $idoffice)->exists()){
        $message = "success";
        $val = 1;

        $files = file_drivers::where("id_user_offices",$user->id)
        ->first();

         if (file_drivers::where("id_user_offices",$user->id)->exists()){
           $filesmessage = "success";
         }else{
           $filesmessage = "error";
         }
      }else{
        $val = 2;
        $message = "error";
        $files = "error";
        $filesmessage = "error";
      }

      return response()->json([
        "objet"=> $message,
        "data" => $user,
        "vali" => $val,
        "file" => $files,
        "filemsj" => $filesmessage
      ]);
    }

    public function getUsersvalidate(Request $r){
      $idoffice = request()->id;

      $user = User_office::where("id_office",$idoffice)
      ->first();

      if(User_office::where('id_office', $idoffice)->exists()){
        if(file_drivers::where("id_user_offices",$user->id)->exists()){
          $message = "success";
          $val = 1;
          $files = file_drivers::where("id_user_offices",$user->id)
          ->first();

           if (file_drivers::where("id_user_offices",$user->id)->exists()){
             $filesmessage = "success";
           }else{
             $filesmessage = "error";
           }
        }else{
          $val = 3;
          $message = "error";
          $files = "error";
          $filesmessage = "error";
        }
      }else{
        $val = 2;
        $message = "error";
        $files = "error";
        $filesmessage = "error";
      }



      return response()->json([
        "objet"=> $message,
        "data" => $user,
        "vali" => $val,
        "file" => $files,
        "filemsj" => $filesmessage
      ]);

    }

    function docs(){
      if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();

          $title ='Conductores';
          $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
          return view('external.drivers.documentos',compact('title', 'main','type_docs'));
      }
    }

    function perfil(){

      if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();

         $title ='Conductores';
         return view('external.drivers.photoperfil',compact('title', 'main'));
      }
    }

    function userOffices(){
      if(auth()->user()){
          $main = new MainClass();
          $main = $main->getMain();
          $title ='Registro';
          $rol= Main::where('users.id', '=', auth()->user()->id)
            ->where('main.status_user', '=', 'TRUE')
            ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
            ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
            ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
            ->join('users',    'users.id',              '=',   'rol_user.id_user')
            ->select('roles.id')
            ->first();

          $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
          return view('external.drivers.useroffices',compact('title', 'main','rol','type_docs'));
      }
    }

    function validateoffice(){
      $val = request()->value;

      if (User_office::where('id_office', '=', $val)->exists()){
        $update = User_office::where('id_office', '=', $val)->first();
        return [ 'mensaje' => 'ESTE ID DE OFICINA ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => true];
      }else{
        return ['flag' => false];
      }
    }

    function validatedni(){
      $val = request()->value;
      $tipdoc = request()->tipdoc;

      if (User_office::where('document', '=', $val)->where('id_type_documents', '=', $tipdoc)->exists()){
        $update = User_office::where('document', '=', $val)->where('id_type_documents', '=', $tipdoc)->first();
        return [ 'mensaje' => 'ESTE NUMERO DE DOCUMENTO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => true];
      }else{
        return ['flag' => false];
      }
    }

    function validatephone(){
      $val = request()->value;

      if (User_office::where('phone', '=', $val)->exists()){
         $update = User_office::where('phone', '=', $val)->first();
         return [ 'mensaje' => 'ESTE TELEFONO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
             'flag' => true];
     }else{
       return ['flag' => false];
     }

    }

    function validateemail(){
      $val = request()->value;

      if (User_office::where('email', '=', $val)->exists()){
        $update = User_office::where('email', '=', $val)->first();
        return [ 'mensaje' => 'ESTE CORREO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => true];
     }else{
       return ['flag' => false];
     }
    }

    function validatelicenceexi(){
      $val = request()->value;

      if (file_drivers::where('licencia', '=', $val)->exists()){
        $updatew = file_drivers::where('licencia', '=', $val)
                  ->join('user_offices', 'user_offices.id', '=', 'file_drivers.id_user_offices')
                  ->first();
        return [ 'mensaje' => 'ESTA LICENCIA ESTA REGISTRADA CON EL USUARIO: '. $updatew->first_name.' '.$updatew->last_name,
                   'flag' => true];
     }else{
       return ['flag' => false];
     }

    }

    function validateplacaexi(){
      $val = request()->value;
      if (file_drivers::where('placa', '=', $val)->exists()){
       $updates = file_drivers::where('placa', '=', $val)
                 ->join('user_offices', 'user_offices.id', '=', 'file_drivers.id_user_offices')
                 ->first();
       return [ 'mensaje' => 'ESTA PLACA ESTA REGISTRADA CON EL USUARIO: '. $updates->first_name.' '.$updates->last_name,
               'flag' => true];
        }else{
        return ['flag' => false];
        }
    }

    function userOfficesRegister(){
      // return request()->users;

      $rol= Main::where('users.id', '=', auth()->user()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('roles.id')
        ->first();

      $user = Main::where('users.id', '=', auth()->user()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('users.username')
        ->first();

      if ($rol->id == 7){
        $sponsor = $user->username;
      }else{
        $sponsor = request()->users{'sponsor'};
      }

      $datos=[
        'id_office'   => request()->users{'idoffice'},
        'first_name'  => strtoupper(request()->users{'first_name'}),
        'last_name'   => strtoupper(request()->users{'last_name'}),
        'email'       => request()->users{'email'},
        'document'         => "".request()->users{'document'}."",
        'phone'       => request()->users{'phone'},
        'country'     => 172,
        'city'        => 48357,
        'state'       => 2825,
        'sponsor'     => $sponsor,
        'address'     => request()->users{'district'},
        'created_by'  => auth()->user()->id,
        'id_type_documents' => request()->users{'tipdocid'}
      ];
      if (User_office::where('id_office', '=', request()->users{'idoffice'})->exists()){
        $update = User_office::where('id_office', '=', request()->users{'idoffice'})->first();
        return [ 'mensaje' => 'ESTE ID DE OFICINA ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => 'true'];

      }else if (User_office::where('document', '=', request()->users{'document'})->where('id_type_documents', '=', request()->users{'tipdocid'})->exists()){
        $update = User_office::where('document', '=', request()->users{'document'})->where('id_type_documents', '=', request()->users{'tipdocid'})->first();
        return [ 'mensaje' => 'ESTE DNI ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => 'true'];

      }else if (User_office::where('email', '=', request()->users{'email'})->exists()){
        $update = User_office::where('email', '=', request()->users{'email'})->first();
        return [ 'mensaje' => 'ESTE CORREO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
              'flag' => 'true'];

       }else if (User_office::where('phone', '=', request()->users{'phone'})->exists()){
          $update = User_office::where('phone', '=', request()->users{'phone'})->first();
          return [ 'mensaje' => 'ESTE TELEFONO ESTA REGISTRADO CON EL USUARIO: '. $update->first_name.' '.$update->last_name,
                'flag' => 'true'];

       }else if (file_drivers::where('licencia', '=', request()->users{'licence'})->exists()){
         $updatew = file_drivers::where('licencia', '=', request()->users{'licence'})
                    ->join('user_offices', 'user_offices.id', '=', 'file_drivers.id_user_offices')
                    ->first();
         return [ 'mensaje' => 'ESTA LICENCIA ESTA REGISTRADA CON EL USUARIO: '. $updatew->first_name.' '.$updatew->last_name,
                    'flag' => 'true'];

        }else if (file_drivers::where('placa', '=', request()->users{'placa'})->exists()){
          $updates = file_drivers::where('placa', '=', request()->users{'placa'})
                    ->join('user_offices', 'user_offices.id', '=', 'file_drivers.id_user_offices')
                    ->first();
          return [ 'mensaje' => 'ESTA PLACA ESTA REGISTRADA CON EL USUARIO: '. $updates->first_name.' '.$updates->last_name,
                      'flag' => 'true'];
        }else {
          $user = User_office::create($datos)->id;
          $data = [
              'placa' => strtoupper(request()->users{'placa'}),
              'licencia' => strtoupper(request()->users{'licence'}),
              'id_user_offices' => $user,
              'document' => request()->users{'document'}
           ];
           $filedriver = file_drivers::create($data)->id;
        }
        return [ 'mensaje' => 'REGISTRO EXITOSO',
              'flag' => 'true'];

    }


    public function store(Request $r){
        $iduser = request()->iduser;
        $licencia = request()->users{'licencia'};

        $cc = User_office::where('id', '=', $iduser)->first();
        $cc->first_name = request()->users{'name-user'};
        $cc->last_name = request()->users{'ape-user'};
        $cc->phone = request()->users{'phone-user'};
        $cc->email = request()->users{'email-user'};
        $cc->document = request()->users{'document'};
        $cc->id_type_documents = request()->users{'tipdocid'};
        $cc->save();

        //licencias
        if (request()->users{'tipdocid'} == 1){

          $licenciaval = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.request()->users{'document'}, true);
          $licenciavals = json_decode($licenciaval);

          if ($licenciavals->sucess == "OK" && $licenciavals->nrolicencia != null){
            $words = explode(" ", $licenciavals->fechaemision);
            $date1 = explode("/", $words[0]);
            $words2 = explode(" ", $licenciavals->fecharevalidacion);
            $date2 = explode("/", $words2[0]);

            $licenciafecemi = $date1[2]."-".$date1[1]."-".$date1[0];
            $licenciafecven = $date2[2]."-".$date2[1]."-".$date2[0];
            $nrolicencia    = $licenciavals->nrolicencia;
            $classcategoria = $licenciavals->clasecategoria;
            $licestado      = $licenciavals->estado;
          }else{
            $licenciafecemi = null;
            $licenciafecven = null;
            $nrolicencia    = null;
            $classcategoria = null;
            $licestado      = null;
          }
        }else{
          $licenciafecemi = null;
          $licenciafecven = null;
          $nrolicencia    = null;
          $classcategoria = null;
          $licestado      = null;
        }
        //fin licencia

        //getVehiculoResult
        $fichero = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.request()->users{'placa'}, true);
        $d = json_decode($fichero);
        $a = $d->getVehiculoPResult[0];

        if ($a->nu_plac_vige != null){
          $modelo = $a->modelo;
          $marca  = $a->marca;
          $color  = $a->color;
          $novin  = $a->no_vin;
          $nomtr  = $a->no_motr;
          $estado = $a->estado;
        }else{
          $modelo = null;
          $marca  = null;
          $color  = null;
          $novin  = null;
          $nomtr  = null;
          $estado = null;
        }
        // fin getvehiculoResult


        //seguros
        $valfechseguros = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.request()->users{'placa'}, true);
        $segurosvals = json_decode($valfechseguros);

        if (isset($segurosvals->NombreCompania)){
          $soatfecemi = explode("/", $segurosvals->FechaInicio);
          $soatfecven = explode("/", $segurosvals->FechaFin);

          $soatfecemiv =  $soatfecemi[2]."-".$soatfecemi[1]."-".$soatfecemi[0];
          $soatfecvenv =  $soatfecven[2]."-".$soatfecven[1]."-".$soatfecven[0];
          $namecompany =  $segurosvals->NombreCompania;
          $typesoat    =  $segurosvals->NombreUsoVehiculo;
          $estsoat     =  $segurosvals->Estado;
        }else{
          //seguros
          $soatfecemiv =  null;
          $soatfecvenv =  null;
          $namecompany =  null;
          $typesoat    =  null;
          $estsoat     =  null;
          //fin seguros
        }
        //fin seguros

        if (file_drivers::where('id_user_offices', '=', $cc->id)->exists()){
            $file = file_drivers::where('id_user_offices', '=', $cc->id)->first();
            $file->tar_vehfecemi = request()->users{'tarj-vehi-fec-emi'};
            $file->tar_vehfecven = request()->users{'tarj-vehi-fec-emi'};
            $file->revfecemi = (request()->users{'rev-fec-emi'} != "") ? request()->users{'rev-fec-emi'} : null;
            $file->revfecven = (request()->users{'rev-fec-ven'} != "") ? request()->users{'rev-fec-ven'} : null;
            $file->document = request()->users{'document'};
            $file->status_user = 2;
            $file->placa = strtoupper(request()->users{'placa'});
            $file->model = $modelo;
            $file->marca = $marca;
            $file->licencia = $licencia;
            $file->year  = request()->users{'year'};
            $file->dnifecemi = date("Y-m-d");
            $file->dnifecven = date("Y-m-d");
            $file->licfecemi = $licenciafecemi;
            $file->licfecven = $licenciafecven;
            $file->soatfecemi = $soatfecemiv;
            $file->soatfecven = $soatfecvenv;
            $file->color_car =  $color;
            $file->num_vin = $novin;
            $file->num_motor = $nomtr;
            $file->est_car =   $estado;
            $file->id_user_offices = $iduser;
            $file->licencia = $nrolicencia;
            $file->classcategoria = $classcategoria;
            $file->est_licencia = $licestado;
            $file->enterprisesoat = $namecompany;
            $file->type_soat = $typesoat;
            $file->est_soat = $estsoat;
            $file->save();
            $idfile = $file->id;
        }else{

            $filesdata = [
              'status_user' => 2,
              'placa' => strtoupper(request()->data{'placa'}),
              'year' => request()->data{'year'},
              'id_user_offices' => $iduser,
              'licencia' => $licencia,
              'tar_vehfecemi' => request()->users{'tarj-vehi-fec-emi'},
              'tar_vehfecven' => request()->users{'tarj-vehi-fec-emi'},
              'revfecemi' => (request()->users{'rev-fec-emi'} != "") ? request()->users{'rev-fec-emi'} : null,
              'revfecven' => (request()->users{'rev-fec-ven'} != "") ? request()->users{'rev-fec-ven'} : null,
              'status_user'  => 1,
              'model' => $modelo,
              'marca' => $marca,
              'document'   => request()->users{'document'},
              'dnifecemi' => date("Y-m-d"),
              'dnifecven' => date("Y-m-d"),
              'licfecemi' => $licenciafecemi,
              'licfecven' => $licenciafecven,
              'soatfecemi' => $soatfecemiv,
              'soatfecven' => $soatfecvenv,
              'color_car' => $color,
              'num_vin' => $novin,
              'num_motor' => $no_motr,
              'est_car' => $estado,
              'id_user_offices' => $iduser,
              'classcategoria' => $classcategoria,
              'est_licencia' => $licestado,
              'enterprisesoat' => $namecompany,
              'type_soat' => $typesoat,
              'est_soat'  => $estsoat
            ];

            $idfile = file_drivers::create($filesdata)->id;
        }

        return response()->json(["idfile" => $idfile]);
    }

    public function storeperfil(Request $r){
      $iduser = request()->iduser;


      $cc = User_office::where('id', '=', $iduser)->first();

      if (isset(request()->users{'name-user'})){
        $cc->first_name = request()->users{'name-user'};
      }
      if (isset(request()->users{'ape-user'})){
        $cc->last_name = request()->users{'ape-user'};
      }

      if (isset(request()->users{'phone-user'})){
        $cc->phone = request()->users{'phone-user'};
      }

      if (isset(request()->users{'email-user'})){
        $cc->email = request()->users{'email-user'};
      }
      $cc->save();
      $filedrivers = file_drivers::where('id_user_offices', '=', $iduser)->first();
      return response()->json(["idfile" => $filedrivers->id]);

    }

    public function validateplaca(Request $r){
      $placa = request()->placa;

      $url = 'http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.$placa;
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

        $ficheros = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.$placa, true);
        $ds = json_decode($ficheros);
        if(!isset($ds->getVehiculoPResult[0]->estado)){
          return response()->json([
            'object'=>"error",
            "menssage" => "No se encontró la placa.",
            "data"     => null
          ]);
        }else{
          return response()->json([
            'object'   =>"success",
            "menssage" => "placa valida.",
            "data"     => $ds->getVehiculoPResult[0]
          ]);
        }
      }else{
        return response()->json([
          'object'=>"success",
          "menssage" => "placa por validar.",
          "data"     => null

        ]);
      }

    }

    public function validatelicense(Request $r){
      $id = request()->iduser;
      $licence = request()->licval;
      $cc = User_office::where('id', '=', $id)->first();

      $ficheros = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.$cc->document, true);
      $ds = json_decode($ficheros);

      if($ds){
         if ($ds->nrolicencia == $licence){
           return response()->json([
             'object'=>"success",
             "menssage" => "licencia valida."
           ]);
         }else{
           return response()->json([
             'object'=> "error",
             "menssage" => "No coincide la licencia."
             ]);
         }
      }else{
        return response()->json([
          'object'=>"error",
          "menssage" => "No se encontró licencia."
        ]);
      }
    }

    public function validatelic(){
      $val = request()->licencia;
      $tipodoc = request()->tipodoc;

      if ($tipodoc == 1){

      $url = 'http://taxiwin.wsdatosperu.com/mtc.php?dni='.$val;
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

        $ficheros = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.$val, true);
        $ds = json_decode($ficheros);

        if($ds->sucess == "OK" && $ds->nrolicencia == null){
          return response()->json([
            'object' =>"success",
            "menssage" => "Licencia por validar",
            "data" => null
          ]);
        }else if ($ds->sucess == "OK" && $ds->nrolicencia != null){
          return response()->json([
            'object' =>"success",
            "menssage" => "Licencia valida.",
            "data" => $ds
          ]);
        }else{
          return response()->json([
            'object' =>"error",
            "menssage" => "El conductor no tiene licencia.",
            "data" => null
          ]);
        }

      }else{
        return response()->json([
          'object' =>"success",
          "menssage" => "Licencia por validar",
          "data" => null
        ]);
      }
    }else{
      return response()->json([
        'object' =>"success",
        "menssage" => "Licencia por validar",
        "data" => null
      ]);
    }

    }


    public function storedocs(Request $r){

        $iduser = request()->iduser;
        $placa = request()->users{'placa'};
        $dni = request()->users{'document'};
        $year = request()->users{'year'};
        $tipdoc = request()->users{'tipdocid'};

        $user = User_office::where('id', '=', $iduser)->first();
        $user->first_name = strtoupper(request()->users{'name-user'});
        $user->last_name  = strtoupper(request()->users{'ape-user'});
        $user->document = $dni;
        $user->id_type_documents = $tipdoc;
        $user->save();

        //licencias
        if ($tipdoc == 1){

          $licenciaval = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.$dni, true);
          $licenciavals = json_decode($licenciaval);

          if ($licenciavals->sucess == "OK" && $licenciavals->nrolicencia != null){
            $words = explode(" ", $licenciavals->fechaemision);
            $date1 = explode("/", $words[0]);
            $words2 = explode(" ", $licenciavals->fecharevalidacion);
            $date2 = explode("/", $words2[0]);

            $licenciafecemi = $date1[2]."-".$date1[1]."-".$date1[0];
            $licenciafecven = $date2[2]."-".$date2[1]."-".$date2[0];
            $nrolicencia    = $licenciavals->nrolicencia;
            $classcategoria = $licenciavals->clasecategoria;
            $licestado      = $licenciavals->estado;
          }else{
            $licenciafecemi = null;
            $licenciafecven = null;
            $nrolicencia    = null;
            $classcategoria = null;
            $licestado      = null;
          }
        }else{
          $licenciafecemi = null;
          $licenciafecven = null;
          $nrolicencia    = null;
          $classcategoria = null;
          $licestado      = null;
        }
        //fin licencia

        //getVehiculoResult
        $fichero = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.$placa, true);
        $d = json_decode($fichero);
        $a = $d->getVehiculoPResult[0];

        if ($a->nu_plac_vige != null){
          $modelo = $a->modelo;
          $marca  = $a->marca;
          $color  = $a->color;
          $novin  = $a->no_vin;
          $nomtr  = $a->no_motr;
          $estado = $a->estado;
        }else{
          $modelo = null;
          $marca  = null;
          $color  = null;
          $novin  = null;
          $nomtr  = null;
          $estado = null;
        }
        // fin getvehiculoResult


        //seguros
        $valfechseguros = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.$placa, true);
        $segurosvals = json_decode($valfechseguros);

        if (isset($segurosvals->NombreCompania)){
          $soatfecemi = explode("/", $segurosvals->FechaInicio);
          $soatfecven = explode("/", $segurosvals->FechaFin);

          $soatfecemiv =  $soatfecemi[2]."-".$soatfecemi[1]."-".$soatfecemi[0];
          $soatfecvenv =  $soatfecven[2]."-".$soatfecven[1]."-".$soatfecven[0];
          $namecompany =  $segurosvals->NombreCompania;
          $typesoat    =  $segurosvals->NombreUsoVehiculo;
          $estsoat     =  $segurosvals->Estado;
        }else{
          //seguros
          $soatfecemiv =  null;
          $soatfecvenv =  null;
          $namecompany =  null;
          $typesoat    =  null;
          $estsoat     =  null;
          //fin seguros
        }
        //fin seguros

            if (file_drivers::where('id_user_offices', $iduser)->exists()){
                $file = file_drivers::where('id_user_offices', '=', $iduser)->first();
                $file->document = document;
                $file->status_user = 3;
                $file->placa = strtoupper($placa);
                $file->model = $modelo;
                $file->marca = $marca;
                $file->year  = $year;
                $file->dnifecemi = date("Y-m-d");
                $file->dnifecven = date("Y-m-d");
                $file->licfecemi = $licenciafecemi;
                $file->licfecven = $licenciafecven;
                $file->soatfecemi = $soatfecemiv;
                $file->soatfecven = $soatfecvenv;
                $file->color_car =  $color;
                $file->num_vin = $novin;
                $file->num_motor = $nomtr;
                $file->est_car =   $estado;
                $file->id_user_offices = $iduser;
                $file->licencia = $nrolicencia;
                $file->classcategoria = $classcategoria;
                $file->est_licencia = $licestado;
                $file->enterprisesoat = $namecompany;
                $file->type_soat = $typesoat;
                $file->est_soat = $estsoat;
                $file->save();
                $id_filedrivers = $file->id;
            }else{
              $filedrivers = [
                'id_user_offices' =>  $iduser,
                'status_user' => 3,
                'placa' => strtoupper($placa),
                'model' => $modelo,
                'marca' => $marca,
                'year' => $year,
                'document'   => $dni,
                'dnifecemi' => date("Y-m-d"),
                'dnifecven' => date("Y-m-d"),
                'licfecemi' => $licenciafecemi,
                'licfecven' => $licenciafecven,
                'soatfecemi' => $soatfecemiv,
                'soatfecven' => $soatfecvenv,
                'licencia' => $nrolicencia,
                'color_car' => $color,
                'num_vin' => $novin,
                'num_motor' => $no_motr,
                'est_car' => $estado,
                'id_user_offices' => $iduser,
                'classcategoria' => $classcategoria,
                'est_licencia' => $licestado,
                'enterprisesoat' => $namecompany,
                'type_soat' => $typesoat,
                'est_soat'  => $estsoat
              ];

              $id_filedrivers = file_drivers::create($filedrivers)->id;

            }

            return response()->json([
              'object'=>"success",
              "idfile" => $id_filedrivers
            ]);
    }



    public function filesaves(Request $r){

          $file = file_drivers::where('id', '=', $r->id_file)->first();
          if ($r->tipo == '1'){
            $file->lic_frontal =  $r->voucherURL;
          }

          if ($r->tipo == '2'){
            $file->lic_back =  $r->voucherURL;
          }


          if ($r->tipo == '3'){
            $file->tar_veh_frontal =  $r->voucherURL;
          }

          if ($r->tipo == '4'){
            $file->tar_veh_back =  $r->voucherURL;
          }

          if ($r->tipo == '5'){
            $file->soat_frontal =  $r->voucherURL;
          }


          if ($r->tipo == '6'){
            $file->soat_back =  $r->voucherURL;
          }

          if ($r->tipo == '7'){
            $file->revision_tecnica =  $r->voucherURL;
          }

          if ($r->tipo == '8'){
            $file->car_interna =  $r->voucherURL;
          }

          if ($r->tipo == '9'){
            $file->car_interna2 =  $r->voucherURL;
          }

          if ($r->tipo == '10'){
            $file->car_externa =  $r->voucherURL;
          }

          if ($r->tipo == '11'){
            $file->car_externa2 =  $r->voucherURL;
          }

          if ($r->tipo == '12'){
            $file->doc_front =  $r->voucherURL;
          }

          if ($r->tipo == '13'){
            $file->doc_back =  $r->voucherURL;
          }

          if ($r->tipo == '14'){
            $file->car_externa3 =  $r->voucherURL;
          }

          if ($r->tipo == '15'){
            $file->recibo_luz =  $r->voucherURL;
          }

          if ($r->tipo == '16'){
            $file->photo_perfil =  $r->voucherURL;
          }

          $file->save();

          $proceso  =  $r->proceso;
          $codigoproceso = $r->codigoproceso;
          $estatusproceso = $r->estatusproceso;

          if ($proceso == 3){
            if (file_drivers::where('id', $r->id_file)
              ->where('doc_front','<>',null)
              ->where('doc_back','<>',null)
              ->where('lic_frontal','<>',null)
              ->where('lic_back','<>',null)
              ->where('tar_veh_frontal','<>',null)
              ->where('tar_veh_back','<>',null)
              ->where('soat_frontal','<>',null)
              ->where('soat_back','<>',null)
              ->exists()){

              $filedrivers = file_drivers::where('id', '=', $r->id_file)->first();
              $filedrivers->status_user = 2;
              $filedrivers->save();

              $process_model =  ProcessTrace::where('id_file_drivers', $r->id_file)->where('id_process_model', $proceso)->first();
              $process_model->estatus = 1 ;
              $process_model->save();


              $añoauto = $filedrivers->year;
              $añoactual = date("Y");

              if ($añoauto == $añoactual || $añoauto == ($añoactual - 1) || $añoauto == ($añoactual - 2)|| $añoauto == ($añoactual - 3) || $añoauto == ($añoactual - 4) || $añoauto == ($añoactual - 5)){

                if (ProcesoValCond::where('id_file_drivers', $r->id_file)
                ->where('id_proceso_validacion',1)->exists()){

                  $procevalconduc = ProcesoValCond::where('id_file_drivers', $r->id_file)
                  ->where('id_proceso_validacion',1)->first();

                  $procevalconduc->modified_by = auth()->user()->id;
                  $procevalconduc->save();

                }else{
                  $procesoConduc = [
                    'id_file_drivers'        => $r->id_file,
                    'id_proceso_validacion'  => 1,
                    'estatus_proceso'        => 1,
                    'modified_by'            => auth()->user()->id,
                    'approved'               => null
                  ];
                  ProcesoValCond::create($procesoConduc);
                }

                $process_model =  ProcessTrace::where('id_file_drivers', $r->id_file)->where('id_process_model', 1)->first();
                $process_model->estatus = 1;
                $process_model->save();
              }

              if (ProcesoValCond::where('id_file_drivers', $r->id_file)
              ->where('id_proceso_validacion',$codigoproceso)->exists()){

                $procevalcond = ProcesoValCond::where('id_file_drivers', $r->id_file)
                ->where('id_proceso_validacion',$codigoproceso)->first();

                $procevalcond->modified_by = auth()->user()->id;
                $procevalcond->save();

              }else{
                $procesoCond = [
                  'id_file_drivers'        => $r->id_file,
                  'id_proceso_validacion'  => $codigoproceso,
                  'estatus_proceso'        => $estatusproceso,
                  'modified_by'            =>  auth()->user()->id,
                  'approved'               => null
                ];
                ProcesoValCond::create($procesoCond);
              }
             }
         }

         if ($proceso == 4){
           if (file_drivers::where('id', $r->id_file)
             ->where('photo_perfil','<>',null)
             ->exists()){

            $filedrivers = file_drivers::where('id', '=', $r->id_file)->first();
            $filedrivers->status_user = 4;
            $filedrivers->save();



             $process_model =  ProcessTrace::where('id_file_drivers', $r->id_file)->where('id_process_model', $proceso)->first();
             $process_model->estatus = 1 ;
             $process_model->save();

             $procesoCond = [
               'id_file_drivers'        => $r->id_file,
               'id_proceso_validacion'  => $codigoproceso,
               'estatus_proceso'        => $estatusproceso,
               'approved'               => true,
               'modified_by'            =>  auth()->user()->id,
               'approved'               => null
             ];
             ProcesoValCond::create($procesoCond);
            }
         }

         if ($proceso == 2){
           if (file_drivers::where('id', $r->id_file)
             ->where('car_interna','<>',null)
             ->where('car_interna2','<>',null)
             ->where('car_externa','<>',null)
             ->where('car_externa2','<>',null)
             ->where('car_externa3','<>',null)
             ->exists()){

            $filedrivers = file_drivers::where('id', '=', $r->id_file)->first();
            $filedrivers->status_user = 3;
            $filedrivers->save();



             $process_model =  ProcessTrace::where('id_file_drivers', $r->id_file)->where('id_process_model', $proceso)->first();
             $process_model->estatus = 1 ;
             $process_model->save();

             $procesoCond = [
               'id_file_drivers'        => $r->id_file,
               'id_proceso_validacion'  => $codigoproceso,
               'estatus_proceso'        => $estatusproceso,
               'modified_by'            =>  auth()->user()->id,
               'approved'               => null
             ];
             ProcesoValCond::create($procesoCond);
            }

         }



          return response()->json([
              "rol"=> "éxito"
          ]);
    }


    public function getDriverFile()
    {
      if(User_office::where(request(){'campo'},request(){'dar'})->exists())
      {
         $u =  User_office::where(request(){'campo'},request(){'dar'})->first();
         if(Record_Driver::where('id_user_offices', $u->id)->exists())
         {
           $pg = Record_Driver::where('id_user_offices', $u->id)->get();
           $pun = 0;
           foreach ($pg as $key => $value) {
            $pun+= $value->points_firmes;
           }
           $statusrecord = true;
         }else{
           $pun = 0;
           $statusrecord = false;
         }


        if(file_drivers::where('id_user_offices', $u->id)->exists())
        {

          // -------------------------------------------------------------------------
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
                          ->with('getUserOffice','getStatusUser','getTecnical')
                          ->get();
         } else {
            $DriverQuery =  file_drivers::where('id_user_offices', $u->id)
                           ->with('getUserOffice','getStatusUser','getTecnical')
                           ->get();
         }



          return response()->json([
              "object"=> "success",
              "data"=> $DriverQuery,
              "points" => $pun,
              "statusrecord" => $statusrecord
          ]);
        }else
        {
          return response()->json([
              "object"=> "error",
              "message"=>"El id no tiene imagenes"
          ]);
        }

// -------------------------------------------------------------------------
      }else
      {
        return response()->json([
            "object"=> "error",
            "message"=>"No se encontro el ID"
        ]);
      }

    }
//-----------------------------saeg
    function showLis()
    {
      $main = new MainClass();
      $main = $main->getMain();
      return view('external.drivers.saeg.listSaeg',compact('main'));
    }

    function getDriversSaeg()
    {
      $drives = file_drivers::where('url_antecedentes','<>',null)
      ->with('getUserOffice','getStatusUser')->get();
      return response()->json([
          "object"=> "success",
          "data"=>$drives
      ]);
    }

//-----------------------------saeg
    function updateObserva()
    {
      $file = file_drivers::where('id', '=', request(){'id'})->first();
      $file->obs_vehi = request(){'obs'};
      $file->status_user =request(){'id_stado'};
      $file->save();

      return $file;
    }

    function technicalreview(){
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

       $type_docs  = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');

       $rolid = $rol->id;

        if ($rolid != 7){
          return view('external.drivers.technicalreview', compact('main','type_docs'));
        }else{
          return view('errors.403', compact('main'));
        }
    }

    function storetechnicalreview(Request $r){
      $iduser  = request()->iduser;
      $status  = request()->status;
      $proceso = request()->proceso;
      $codigoproceso = request()->codigoproceso;

      $cc = User_office::where('id', '=', $iduser)->first();
      if (isset(request()->data{'phone-user'})){
        $cc->phone = request()->data{'phone-user'};
      }
      if (isset(request()->data{'email-user'})){
        $cc->email = request()->data{'email-user'};
      }
      $cc->first_name = request()->data{'name-user'};
      $cc->last_name  = request()->data{'ape-user'};
      $cc->document        = request()->data{'document'};
      $cc->id_type_documents = request()->data{'tipdocid'};
      $cc->save();

      if ($status == 2){
      	$statusdriver = 1;
      }else{
      	$statusdriver = 7;
      }

      if (request()->data{'tipdocid'} == 1){

        $licenciaval = file_get_contents('http://taxiwin.wsdatosperu.com/mtc.php?dni='.request()->data{'document'}, true);
        $licenciavals = json_decode($licenciaval);

        if ($licenciavals->sucess == "OK" && $licenciavals->nrolicencia != null){
          $words = explode(" ", $licenciavals->fechaemision);
          $date1 = explode("/", $words[0]);
          $words2 = explode(" ", $licenciavals->fecharevalidacion);
          $date2 = explode("/", $words2[0]);

          $licenciafecemi = $date1[2]."-".$date1[1]."-".$date1[0];
          $licenciafecven = $date2[2]."-".$date2[1]."-".$date2[0];
          $nrolicencia    = $licenciavals->nrolicencia;
          $classcategoria = $licenciavals->clasecategoria;
          $licestado      = $licenciavals->estado;
        }else{
          $licenciafecemi = null;
          $licenciafecven = null;
          $nrolicencia    = null;
          $classcategoria = null;
          $licestado      = null;
        }
      }else{
        $licenciafecemi = null;
        $licenciafecven = null;
        $nrolicencia    = null;
        $classcategoria = null;
        $licestado      = null;
      }


      //registrar datos del auto
      $fichero = file_get_contents('http://taxiwin.wsdatosperu.com/sunarp_vehiculos.php?placa='.request()->data{'placa'}, true);
      $d = json_decode($fichero);
      $a = $d->getVehiculoPResult[0];

      if ($a->nu_plac_vige != null){
        $modelo = $a->modelo;
        $marca  = $a->marca;
        $color  = $a->color;
        $novin  = $a->no_vin;
        $nomtr  = $a->no_motr;
        $estado = $a->estado;
      }else{
        $modelo = null;
        $marca  = null;
        $color  = null;
        $novin  = null;
        $nomtr  = null;
        $estado = null;
      }
      // fin getvehiculoResult


      //seguros
      $valfechseguros = file_get_contents('http://taxiwin.wsdatosperu.com/soat.php?placa='.request()->data{'placa'}, true);
      $segurosvals = json_decode($valfechseguros);

      if (isset($segurosvals->NombreCompania)){
        $soatfecemi = explode("/", $segurosvals->FechaInicio);
        $soatfecven = explode("/", $segurosvals->FechaFin);

        $soatfecemiv =  $soatfecemi[2]."-".$soatfecemi[1]."-".$soatfecemi[0];
        $soatfecvenv =  $soatfecven[2]."-".$soatfecven[1]."-".$soatfecven[0];
        $namecompany =  $segurosvals->NombreCompania;
        $typesoat    =  $segurosvals->NombreUsoVehiculo;
        $estsoat     =  $segurosvals->Estado;
      }else{
        //seguros
        $soatfecemiv =  null;
        $soatfecvenv =  null;
        $namecompany =  null;
        $typesoat    =  null;
        $estsoat     =  null;
        //fin seguros
      }
      //fin seguros

      if (file_drivers::where('id_user_offices', '=', $cc->id)->exists()){
          $file = file_drivers::where('id_user_offices', '=', $cc->id)->first();
          $file->document = request()->data{'document'};
          $file->status_user = $statusdriver;
          $file->placa = request()->data{'placa'};
          $file->model = $modelo;
          $file->marca = $marca;
          $file->year  = request()->data{'year'};
          $file->dnifecemi = date("Y-m-d");
          $file->dnifecven = date("Y-m-d");
          $file->licfecemi = $licenciafecemi;
          $file->licfecven = $licenciafecven;
          $file->soatfecemi = $soatfecemiv;
          $file->soatfecven = $soatfecvenv;
          $file->color_car =  $color;
          $file->num_vin = $novin;
          $file->num_motor = $nomtr;
          $file->est_car =   $estado;
          $file->id_user_offices = $iduser;
          $file->licencia = $nrolicencia;
          $file->classcategoria = $classcategoria;
          $file->est_licencia = $licestado;
          $file->enterprisesoat = $namecompany;
          $file->type_soat = $typesoat;
          $file->est_soat = $estsoat;
          $file->save();
          $idfile = $file->id;
      } else {

          $filesdata = [
            'document'   => request()->data{'document'},
            'status_user' => $statusdriver,
            'placa' => strtoupper(request()->data{'placa'}),
            'model' => $modelo,
            'marca' => $marca,
            'year' => request()->data{'year'},
            'dnifecemi' => date("Y-m-d"),
            'dnifecven' => date("Y-m-d"),
            'licfecemi' => $licenciafecemi,
            'licfecven' => $licenciafecven,
            'soatfecemi' => $soatfecemiv,
            'soatfecven' => $soatfecvenv,
            'licencia' => $nrolicencia,
            'color_car' => $color,
            'num_vin' => $novin,
            'num_motor' => $no_motr,
            'est_car' => $estado,
            'id_user_offices' => $iduser,
            'classcategoria' => $classcategoria,
            'est_licencia' => $licestado,
            'enterprisesoat' => $namecompany,
            'type_soat' => $typesoat,
            'est_soat'  => $estsoat
          ];

          $idfile = file_drivers::create($filesdata)->id;
      }



      $tdata = [
        'id_file_drivers' =>  $idfile,
        'luz_baja' => request()->data{'light_low'},
        'luz_alta' => request()->data{'light_high'},
        'luz_freno' => request()->data{'light_brake'},
        'luz_emergencia' => request()->data{'light_emergency'},
        'luz_retroceso' => request()->data{'light_recoil'},
        'luz_intermitente' => request()->data{'light_intermittent'},
        'luz_antiniebla' => request()->data{'light_fog'},
        'luz_placa' => request()->data{'light_plate'},
        'arrancador' => request()->data{'engine_start'},
        'alternador' => request()->data{'alternator'},
        'bujias' => request()->data{'plugs'},
        'cable_bujias' => request()->data{'cable_plugs'},
        'bobinas' => request()->data{'coils'},
        'inyectores' => request()->data{'injectors'},
        'bateria' => request()->data{'drums'},
        'past_del' => request()->data{'front_pads'},
        'past_tras' => request()->data{'rear_pads'},
        'disc_del' => request()->data{'front_discs'},
        'disc_tras' => request()->data{'rear_discs'},
        'tamb_tras' => request()->data{'rear_drums'},
        'zapatas_tras' => request()->data{'rear_shoes'},
        'freno_emerg' => request()->data{'emergency_break'},
        'liq_freno' => request()->data{'brake_fluid'},
        'est_neumaticos' => request()->data{'tire_status'},
        'rev_tuercas' => request()->data{'nut_revision'},
        'pres_neumat' => request()->data{'tire_pressure'},
        'llanta_resp' => request()->data{'spare_tire'},
        'aros' => request()->data{'hoops'},
        'paracho_del' => request()->data{'front_bumper'},
        'paracho_post'  => request()->data{'rear_bumper'},
        'puert_del_izq'  => request()->data{'left_front_door'},
        'puert_del_der' => request()->data{'right_front_door'},
        'puert_post_izq' => request()->data{'left_rear_door'},
        'puert_post_der' => request()->data{'right_rear_door'},
        'guardafango_izq' => request()->data{'left_fender'},
        'guardafango_der' => request()->data{'right_fender'},
        'capota' => request()->data{'soft_top'},
        'vid_del_izq' => request()->data{'left_front_glass'},
        'vid_del_der' => request()->data{'right_front_glass'},
        'vid_post_izq' => request()->data{'left_rear_glass'},
        'vid_post_der' => request()->data{'right_rear_glass'},
        'parab_del' => request()->data{'front_windshield'},
        'parab_tras' => request()->data{'rear_windshield'},
        'maletero' => request()->data{'trunk'},
        'techo' => request()->data{'ceiling'},
        'fuga_aceite' => request()->data{'oil_leak'},
        'fuga_refrig' => request()->data{'refrigerant_leak'},
        'fuga_combust' => request()->data{'fuel_leak'},
        'filt_aceite' => request()->data{'oil_filter'},
        'filt_aire' => request()->data{'air_filter'},
        'filt_combus' => request()->data{'fuel_filter'},
        'filt_cabina' => request()->data{'cabin_filter'},
        'bomba_direc' => request()->data{'steering_pump'},
        'amorti_del' => request()->data{'front_shock_absorbers'},
        'amorti_post' => request()->data{'rear_shock_absorbers'},
        'palieres' => request()->data{'pallets'},
        'rotulas' => request()->data{'pads'},
        'termin_direc' => request()->data{'terminal_blocks'},
        'trapezios' => request()->data{'trapezios'},
        'resortes' => request()->data{'springs'},
        'aceite_caja' => request()->data{'box_oil'},
        'filtro_caja' => request()->data{'case_filter'},
        'caja_transf' => request()->data{'transfer_case'},
        'cardan' => request()->data{'cardan'},
        'diferencial' => request()->data{'differential'},
        'disco_embrague' => request()->data{'clutch_disc'},
        'collarin' => request()->data{'collarin'},
        'cruzetas' => request()->data{'crossbows'},
        'radiador' => request()->data{'radiator'},
        'ventiladores' => request()->data{'ventilators'},
        'correa_vent' =>  request()->data{'fan_belt'},
        'mangueras_agua' => request()->data{'water_hoses'},
        'tablero' => request()->data{'board'},
        'luz_tablero' => request()->data{'dash_light'},
        'luz_saloom' => request()->data{'saloon_light'},
        'asiento_piloto' => request()->data{'pilot_seat'},
        'asiento_copiloto' => request()->data{'passenger_seat'},
        'asientos_tras' => request()->data{'rear_seats'},
        'claxon' => request()->data{'horn'},
        'gata' => request()->data{'gata'},
        'llave_ruedas' => request()->data{'wheel_wrench'},
        'estuche_herra' => request()->data{'tool_kit'},
        'triangulo_seg' => request()->data{'safety_triangle'},
        'extintor' => request()->data{'extinguisher'},
        'note' => request()->data{'observacion'},
      ];
      $id_tec = technical_review::create($tdata)->id;

      if ($id_tec >= 1){
            $object = "success";
            $mensaje = "Se registro correctamente";
      }else{
            $object =  "error";
            $mensaje = "hubo un error en el registro";
      }

      if ($status == 2){
        $process_model =  ProcessTrace::where('id_file_drivers', $idfile)->where('id_process_model', $proceso)->first();
        $process_model->estatus = 1;
        $process_model->save();

        $procesoCond =[
          'id_file_drivers'        => $idfile,
          'id_proceso_validacion'  => $codigoproceso,
          'estatus_proceso'        => 1,
          'modified_by'            =>  auth()->user()->id
        ];
        ProcesoValCond::create($procesoCond);

      }else{
        $process_model =  ProcessTrace::where('id_file_drivers', $idfile)->where('id_process_model', $proceso)->first();
        $process_model->estatus = 0;
        $process_model->save();

        $procesoCond =[
          'id_file_drivers'        => $idfile,
          'id_proceso_validacion'  => $codigoproceso,
          'estatus_proceso'        => 0,
          'modified_by'            =>  auth()->user()->id
        ];
        ProcesoValCond::create($procesoCond);


      }



      return response()->json([
          "object"=> $object,
          "message" => $mensaje,
          "idtec" => $id_tec
      ]);

    }

    function checkpdf($idtec){
      $tecnicalreview = technical_review::where('id', '=', $idtec)->first();
      $filedrivers = file_drivers::where('id', '=', $tecnicalreview->id_file_drivers)->first();
      $id = $filedrivers->id_user_offices;

      if (true){
          if(file_drivers::where('id_user_offices', $id)->exists())
          {
            $d = file_drivers::where('id_user_offices',$id)->with('getUserOffice','getStatusUser')->first();
            $rt = technical_review::where('id_file_drivers', $filedrivers->id)->first();

            $dp= $d->getUserOffice()->first();
            $first_name = $dp->first_name;
            $last_name = $dp->last_name;
            $dni = $dp->document;
            $placa = $d->placa;
            $marca = $d->marca;
            $modelo = $d->model;
            $year = $d->year;
            $color = $d->color_car;
            $nro_vin = $d->num_vin;
            $nro_vin = $d->num_vin;
            $nro_motor = $d->num_motor;
            $luz_baja = $rt->luz_baja;
            $luz_alta = $rt->luz_alta;
            $luz_freno = $rt->luz_freno;
            $luz_emergencia = $rt->luz_emergencia;
            $luz_retroceso = $rt->luz_retroceso;
            $luz_intermitente = $rt->luz_intermitente;
            $luz_antiniebla = $rt->luz_antiniebla;
            $luz_placa = $rt->luz_placa;
            $arrancador = $rt->arrancador;
            $alternador = $rt->alternador;
            $bujias = $rt->bujias;
            $cable_bujias = $rt->cable_bujias;
            $bobinas = $rt->bobinas;
            $inyectores = $rt->inyectores;
            $bateria = $rt->bateria;
            $past_del = $rt->past_del;
            $past_tras = $rt->past_tras;
            $disc_del = $rt->disc_del;
            $disc_tras = $rt->disc_tras;
            $tamb_tras = $rt->tamb_tras;
            $zapatas_tras = $rt->zapatas_tras;
            $freno_emerg = $rt->freno_emerg;
            $liq_freno = $rt->liq_freno;
            $est_neumaticos = $rt->est_neumaticos;
            $rev_tuercas = $rt->rev_tuercas;
            $pres_neumat = $rt->pres_neumat;
            $llanta_resp = $rt->llanta_resp;
            $aros = $rt->aros;
            $paracho_del = $rt->paracho_del;
            $paracho_post  = $rt->paracho_post;
            $puert_del_izq  = $rt->puert_del_izq;
            $puert_del_der = $rt->puert_del_der;
            $puert_post_izq = $rt->puert_post_izq;
            $puert_post_der = $rt->puert_post_der;
            $guardafango_izq = $rt->guardafango_izq;
            $guardafango_der = $rt->guardafango_der;
            $capota = $rt->capota;
            $vid_del_izq = $rt->vid_del_izq;
            $vid_del_der = $rt->vid_del_der;
            $vid_post_izq = $rt->vid_post_izq;
            $vid_post_der = $rt->vid_post_der;
            $parab_del = $rt->parab_del;
            $parab_tras = $rt->parab_tras;
            $maletero = $rt->maletero;
            $techo = $rt->techo;
            $fuga_aceite = $rt->fuga_aceite;
            $fuga_refrig = $rt->fuga_refrig;
            $fuga_combust = $rt->fuga_combust;
            $filt_aceite = $rt->filt_aceite;
            $filt_aire = $rt->filt_aire;
            $filt_combus = $rt->filt_combus;
            $filt_cabina = $rt->filt_cabina;
            $bomba_direc = $rt->bomba_direc;
            $amorti_del = $rt->amorti_del;
            $amorti_post = $rt->amorti_post;
            $palieres = $rt->palieres;
            $rotulas = $rt->rotulas;
            $termin_direc = $rt->termin_direc;
            $trapezios = $rt->trapezios;
            $resortes = $rt->resortes;
            $aceite_caja = $rt->aceite_caja;
            $filtro_caja = $rt->filtro_caja;
            $caja_transf = $rt->caja_transf ;
            $cardan = $rt->cardan;
            $diferencial = $rt->diferencial;
            $disco_embrague = $rt->disco_embrague;
            $collarin = $rt->collarin;
            $cruzetas = $rt->cruzetas;
            $radiador = $rt->radiador;
            $ventiladores = $rt->ventiladores;
            $correa_vent =  $rt->correa_vent;
            $mangueras_agua = $rt->mangueras_agua;
            $tablero = $rt->tablero;
            $luz_tablero = $rt->luz_tablero;
            $luz_saloom = $rt->luz_saloom ;
            $asiento_piloto = $rt->asiento_piloto;
            $asiento_copiloto = $rt->asiento_copiloto;
            $asientos_tras = $rt->asientos_tras;
            $claxon = $rt->claxon;
            $gata = $rt->gata;
            $llave_ruedas = $rt->llave_ruedas;
            $estuche_herra = $rt->estuche_herra;
            $triangulo_seg = $rt->triangulo_seg;
            $extintor = $rt->extintor;
            $note = $rt->note;
            $fecha = date("Y-m-d", strtotime($rt->created_at));

            $pdf = PDF::loadView('external.drivers.trimprimir',compact(
              'document',
              'first_name',
              'last_name',
              'color',
              'placa',
              'marca',
              'year',
              'modelo',
              'nro_vin',
              'nro_motor',
              'luz_baja',
              'luz_alta',
              'luz_freno',
              'luz_emergencia',
              'luz_retroceso',
              'luz_intermitente',
              'luz_antiniebla',
              'luz_placa',
              'arrancador',
              'alternador',
              'bujias',
              'cable_bujias',
              'bobinas',
              'inyectores',
              'bateria',
              'past_del',
              'past_tras',
              'disc_del',
              'disc_tras',
              'tamb_tras',
              'zapatas_tras',
              'freno_emerg',
              'liq_freno',
              'est_neumaticos',
              'rev_tuercas',
              'pres_neumat',
              'llanta_resp',
              'aros',
              'paracho_del',
              'paracho_post' ,
              'puert_del_izq' ,
              'puert_del_der',
              'puert_post_izq',
              'puert_post_der',
              'guardafango_izq',
              'guardafango_der',
              'capota',
              'vid_del_izq',
              'vid_del_der',
              'vid_post_izq',
              'vid_post_der',
              'parab_del',
              'parab_tras',
              'maletero',
              'techo',
              'fuga_aceite',
              'fuga_refrig',
              'fuga_combust',
              'filt_aceite',
              'filt_aire',
              'filt_combus',
              'filt_cabina',
              'bomba_direc',
              'amorti_del',
              'amorti_post',
              'palieres',
              'rotulas',
              'termin_direc',
              'trapezios',
              'resortes',
              'aceite_caja',
              'filtro_caja',
              'caja_transf',
              'cardan',
              'diferencial',
              'disco_embrague',
              'collarin',
              'cruzetas',
              'radiador',
              'ventiladores',
              'correa_vent',
              'mangueras_agua',
              'tablero',
              'luz_tablero',
              'luz_saloom',
              'asiento_piloto',
              'asiento_copiloto',
              'asientos_tras',
              'claxon',
              'gata',
              'llave_ruedas',
              'estuche_herra',
              'triangulo_seg',
              'extintor',
              'note',
              'fecha'
            ));
            return $pdf->download('control-y-analisis-vehicular.pdf');
          }else
          {
            return response()->json([
                "object"=> "error",
                "message"=>"El id no tiene imagenes"
            ]);
          }


      }else{
        return view('errors.403', compact('main'));
  }
  }

  // --------------------------------------------
  function getDrivers2(){
    if(User_office::where(request(){'campo'},request(){'dar'})->exists())
    {
      $u =  User_office::where(request(){'campo'},request(){'dar'})->first();


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
      $DriverQuery =  User_office::where('status_system', 'true')
                      ->Where('created_by', '=', auth()->user()->id)
                        ->where('id', $u->id)
                      ->with('getfile','getCreate')
                      ->get();
    } else {

       $DriverQuery =   User_office::where('status_system', 'true')
                        ->where('id', $u->id)
                       ->with('getfile','getCreate')
                       ->get();
    }

   foreach ($DriverQuery as $r) {

     $action   =  $r->getfile->id ? '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$r->getfile->id.','.$r->id_office.','.$r->id.')"></button>' : '-';


     $reporte   = $r->getfile->id ? '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$r->id_office.'" target="_blank"></a>' : '-';

     $resumen = $r->id_office ? '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$r->id_office.')"></button>' : '-';



       $proces_val = ProcesoValCond::where('id_file_drivers',$r->getfile->id)->get();
       $proces_proce = ProcessTrace::where('id_file_drivers',$r->getfile->id)->get();
       $status = "";

       // -----------------------------------------------------------------------------------------------------------------------
       if(ProcesoValCond::where('id_file_drivers',$r->getfile->id)->exists())
       {
         $contador = 0;
         $cantidad_obli = 0;
         $canti = 0;
         $arr = [];

         foreach ($proces_proce as $key => $value) {

           if($value->getProcesModel->obligatorio)//si es obligatorio
           {
             $cantidad_obli++;
             foreach ($proces_val as $key_v => $value_v) {

               if($value_v->id_proceso_validacion == $value->id_process_model)//si los procesos son iguales
               {
                 if($value_v->approved == null)
                 {
                   $contador++;
                   continue;
                 }
                 elseif($value_v->approved)//si paso en  aprobado
                 {
                     $contador++;
                     $canti++;
                     continue;


                 }
                 else{
                   $contador = -1;
                   break;
                 }
               }
               else{
                 continue;
               }
             }


           }
           else {
             $contador++;
             continue;
           }

           if($contador == -1)
           {
             break;
           }

         }


       }else {
         $contador = 0;
       }




       if($contador == -1)
       {
           $status = "DESAPROBADO";
       }elseif ($contador==0) {
         $status = "PENDIENTE";
       }
       elseif ($cantidad_obli == $canti) {
         $status = "APROBADO";
       }elseif ($contador>0) {
         $status = "EN EVALUACIÓN";
       }else {
           $status = "INDEFINIDO";
       }
       // ------------------------------------------------------------------------------------------------------------------------

     $c = new stdClass();
     $c->date = "-";

     $b = new stdClass();
     $b->username = "-";

     $driver   = [
       'accion'         => $action,
       'resumen'        => $resumen,
       'reporte'        => $reporte,
       'document'            => $r->document        ?  $r->document  : '-',
       'id_office'      => $r->id_office  ?  $r->id_office : '-',
       'first_name'     => $r->first_name ?  $r->first_name : '-',
       'last_name'      => $r->last_name  ?  $r->last_name : '-',
       'phone'          => $r->phone      ?  $r->phone : '-',
       'correo'         => $r->email      ?  $r->email : '-',
       'marca'          => $r->getfile->marca                      ?  $r->getfile->marca  : '-',
       'placa'          => $r->getfile->placa                      ?  $r->getfile->placa  : '-',
       'modelo'         => $r->getfile->model                      ?  $r->getfile->model  : '-',
       'estado'         => $status,
       'date_create'    => $r->created_at                      ?  $r->created_at : $c,
       'created'    => $r->getCreate                      ?  $r->getCreate  : $b,
       "id_office"=>$r->id
     ];
     array_push($drivers, $driver);

   }
   return response()->json([
       "object"=> "success",
       "data"=> $drivers
   ]);
    }


  }
  // ------------------------------------------

  function getDrivers(){
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
       $DriverQuery =  User_office::where('status_system', 'true')
                       ->Where('created_by', '=', auth()->user()->id)
                       ->with('getfile','getCreate')
                       ->get();
     } else {

        $DriverQuery =   User_office::where('status_system', 'true')
                        ->with('getfile','getCreate')
                        ->get();
     }

    foreach ($DriverQuery as $r) {

      $action   =  $r->getfile->id ? '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$r->getfile->id.','.$r->id_office.','.$r->id.')"></button>' : '-';


      $reporte   = $r->getfile->id ? '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$r->id_office.'" target="_blank"></a>' : '-';

      $resumen = $r->id_office ? '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$r->id_office.')"></button>' : '-';



        $proces_val = ProcesoValCond::where('id_file_drivers',$r->getfile->id)->get();
        $proces_proce = ProcessTrace::where('id_file_drivers',$r->getfile->id)
        ->with('getProcesModel')
        ->get();
        $status = "";

        // -----------------------------------------------------------------------------------------------------------------------
        if(ProcesoValCond::where('id_file_drivers',$r->getfile->id)->exists())
        {
          $contador = 0;
          $cantidad_obli = 0;
          $canti = 0;
          $arr = [];

          foreach ($proces_proce as $key => $value) {

            if($value->getProcesModel->obligatorio)//si es obligatorio
            {
              $cantidad_obli++;
              foreach ($proces_val as $key_v => $value_v) {

                if($value_v->id_proceso_validacion == $value->id_process_model)//si los procesos son iguales
                {
                  if($value_v->approved == null)
                  {
                    $contador++;
                    continue;
                  }
                  elseif($value_v->approved)//si paso en  aprobado
                  {
                      $contador++;
                      $canti++;
                      continue;
                  }
                  else{
                    $contador = -1;
                    break;
                  }
                }
                else{
                  continue;
                }
              }


            }
            else {
              $contador++;
              continue;
            }

            if($contador == -1)
            {
              break;
            }

          }


        }else {
          $contador = 0;
        }




        if($contador == -1)
        {
            $status = "DESAPROBADO";
        }elseif ($contador==0) {
          $status = "PENDIENTE";
        }
        elseif ($cantidad_obli == $canti) {
          $status = "APROBADO";
        }elseif ($contador>0) {
          $status = "EN EVALUACIÓN";
        }else {
            $status = "INDEFINIDO";
        }

        // ------------------------------------------------------------------------------------------------------------------------

      $c = new stdClass();
      $c->date = "-";

      $b = new stdClass();
      $b->username = "-";

      $driver   = [
        'accion'         => $action,
        'resumen'        => $resumen,
        'reporte'        => $reporte,
        'document'            => $cantidad_obli,//$r->dni        ?  $r->dni  : '-',
        'id_office'      => $r->id_office  ?  $r->id_office : '-',
        'first_name'     => $canti,//$r->first_name ?  $r->first_name : '-',
        'last_name'      => $r->last_name  ?  $r->last_name : '-',
        'phone'          => $r->phone      ?  $r->phone : '-',
        'correo'         => $r->email      ?  $r->email : '-',
        'marca'          => $r->getfile->marca                      ?  $r->getfile->marca  : '-',
        'placa'          => $r->getfile->placa                      ?  $r->getfile->placa  : '-',
        'modelo'         => $r->getfile->model                      ?  $r->getfile->model  : '-',
        'estado'         => $status,
        'date_create'    => $r->created_at                      ?  $r->created_at : $c,
        'created'    => $r->getCreate                      ?  $r->getCreate  : $b
      ];
      array_push($drivers, $driver);

    }
    return response()->json(["data"=>$drivers]);
  }

  function listDriver_id()
  {
        if(!User::where('username', request()->user)->exists())
        {
          return response()->json([
            "object"=>"error",
            "message"=>"No existe el usuario"
          ]);
        }
        $user = User::where('username', request()->user)->first();

        $DriverQuery =   User_office::where('created_by',$user->id )
                        ->with('getfile','getCreate')
                        ->get();


    $drivers = [];

    foreach ($DriverQuery as $r) {

      $action   =  $r->getfile->id ? '<button type="button" class="btn btn-primary fa fa-history" onclick="viewRecord('.$r->getfile->id.','.$r->id_office.','.$r->id.')"></button>' : '-';


      $reporte   = $r->getfile->id ? '<a class="btn btn-primary fa fa-bar-chart" href="/driver/externo/details/'.$r->id_office.'" target="_blank"></a>' : '-';

      $resumen = $r->id_office ? '<button type="button" class="btn btn-primary fa fa-search" onclick="viewHistorico('.$r->id_office.')"></button>' : '-';




  $proces_val = ProcesoValCond::where('id_file_drivers',$r->getfile->id)->get();
  $proces_proce = ProcessTrace::where('id_file_drivers',$r->getfile->id)->get();
  $status = "";

  // -----------------------------------------------------------------------------------------------------------------------

  if(ProcesoValCond::where('id_file_drivers',$r->getfile->id)->exists())
  {
    $contador = 0;
    $cantidad_obli = 0;
    $canti = 0;
    $arr = [];

    foreach ($proces_proce as $key => $value) {

      if($value->getProcesModel->obligatorio)//si es obligatorio
      {
        $cantidad_obli++;
        foreach ($proces_val as $key_v => $value_v) {

          if($value_v->id_proceso_validacion == $value->id_process_model)//si los procesos son iguales
          {
            if($value_v->approved == null)
            {
              $contador++;
              continue;
            }
            elseif($value_v->approved)//si paso en  aprobado
            {
                $contador++;
                $canti++;
                continue;


            }
            else{
              $contador = -1;
              break;
            }
          }
          else{
            continue;
          }
        }


      }
      else {
        $contador++;
        continue;
      }

      if($contador == -1)
      {
        break;
      }

    }


  }else {
    $contador = 0;
  }




  if($contador == -1)
  {
      $status = "DESAPROBADO";
  }elseif ($contador==0) {
    $status = "PENDIENTE";
  }
  elseif ($cantidad_obli == $canti) {
    $status = "APROBADO";
  }elseif ($contador>0) {
    $status = "EN EVALUACIÓN";
  }else {
      $status = "INDEFINIDO";
  }


  // ------------------------------------------------------------------------------------------------------------------------




      $c = new stdClass();
      $c->date = "-";

      $b = new stdClass();
      $b->username = "-";

      $driver   = [
        'accion'         => $action,
        'resumen'        => $resumen,
        'reporte'        => $reporte,
        'document'            => $r->document        ?  $r->document  : '-',
        'id_office'      => $r->id_office  ?  $r->id_office : '-',
        'first_name'     => $r->first_name ?  $r->first_name : '-',
        'last_name'      => $r->last_name  ?  $r->last_name : '-',
        'phone'          => $r->phone      ?  $r->phone : '-',
        'correo'         => $r->email      ?  $r->email : '-',
        'marca'          => $r->getfile->marca                      ?  $r->getfile->marca  : '-',
        'placa'          => $r->getfile->placa                      ?  $r->getfile->placa  : '-',
        'modelo'         => $r->getfile->model                      ?  $r->getfile->model  : '-',
        'estado'         => $status,
        'date_create'    => $r->created_at                      ?  $r->created_at : $c,
        'created'    => $r->getCreate                      ?  $r->getCreate  : $b
      ];
      array_push($drivers, $driver);

    }
    return response()->json([
      "object"=>"success",
      "data"=>$drivers
    ]);
  }



   function updateDni()
   {
     if(User_office::where('document',request()->document)->exists())
     {
       return response()->json([
           "object"=> "WARNING",
           "message"=>"EL dni ya existe."
       ]);
     }else{
       $c = User_office::where('id',request()->id)->first();
       $c->first_name = request()->first_name;
       $c->last_name = request()->last_name;
       $c->document = request()->document;
       $c->save();
       return response()->json([
           "object"=> "success",
           "message"=>"El usuario fue actualizado."
       ]);
     }

   }


}
