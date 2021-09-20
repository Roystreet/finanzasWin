<?php

namespace App\Http\Controllers\AtencionCliente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\MainClass;
use App\Models\Customer\Customer;
use App\Models\General\StatusT;
use App\Models\General\TypeRequirements;
use App\Models\RegisterAtencion\RegisterAtencion;
use App\Models\RegisterAtencion\Conversations;
use App\Models\RegisterAtencion\Subjects;
use App\Models\General\Type_document_identy;
use App\Models\General\Country;
use App\Models\General\Brands;
use App\Models\General\GroupsTicket;
use App\Models\General\Operators;
use App\Models\General\User;
use App\Models\General\Notifications;
use App\Models\General\Status;
use App\Models\General\Priority;
use App\Models\General\Category;
use App\Models\Customer\dtCustomerType;
use Illuminate\Support\Facades\DB;
use App\Models\General\Rol_permissions;
use Auth;
use \stdClass;
use App\Models\General\Main;

class AtencionClienteController extends Controller
{

    public function __construct(){
  		$this->middleware('auth');
      $this->middleware('role');
  	}

    public function AtencionPermisos(){
      $a = new stdClass();
      $a->reporte = false;
      $a->viewticketagente = false;
      $a->viewticketadmin = false;
      $a->superUsuario = false;
      return $a;
    }


    public function index(){
        $main = new MainClass();
        $main = $main->getMain();

        $customer       =  Customer::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "customers.id as id")
                          ->orderBy('name',  'ASC')
                          ->pluck( '(last_name||" " ||first_name)as name', 'customers.id as id');

        $country       = Country::orderBy('description', 'ASC')->pluck('description', 'id');

        $Type         = TypeRequirements::select(DB::raw("UPPER(description) AS description"), "id")->where('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');

        $statusT      = StatusT::select(DB::raw("UPPER(description) AS description"), "id")->where('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');

        $groups       = GroupsTicket::orderBy('description', 'ASC')->pluck('description', 'id');

        $modified_by   = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "id")->where('status_system', '=', 'TRUE')->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');

        $status        = Status::select(DB::raw("UPPER(description) AS description"), "id")->where('status_system', '=', 'FALSE')->orderBy('description', 'ASC')->pluck('description', 'id');

        $verAdmin     = true;
        $superUser    = true;

        return view('AtencionCliente.show',  compact('main', 'customer', 'country', 'modified_by', 'statusT','Type','verAdmin','groups','superUser'));

    }

    public function registerservice($id){
      $main = new MainClass();
      $main = $main->getMain();

      $typedniv = null;
      $dniv = null;
      $idcust = null;
      $ckecked = null;
      $priorityv = null;
      $idatt = null;

      $type_docs = Type_document_identy::WHERE('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
      $status        = TypeRequirements::select(DB::raw("UPPER(description) AS description"), "id")->where('status_system', '=', 'true')->orderBy('description', 'ASC')->pluck('description', 'id');
      $country       = Country::orderBy('description', 'ASC')->pluck('description', 'id');
      $operators     = Operators::orderBy('description', 'ASC')->pluck('description', 'id');
      $brands        = Brands::orderBy('description', 'ASC')->pluck('description', 'id');
      $groups        = GroupsTicket::orderBy('description', 'ASC')->pluck('description', 'id');
      $priorities    = Priority::orderBy('response_time', 'ASC')->pluck('description', 'id');
      return view('AtencionCliente.registerservice',  compact('main', 'status', 'country','operators','brands', 'groups','type_docs','priorities','dniv','typedniv','idcust','ckecked','priorityv','idatt'));
    }

    public function store()
    {
       $dt = new \DateTime();
       $fecha = $dt->format('Y-m-d H:i:s');

       if(Customer::where('document', '=',request()->dni)->exists())
       {
           $DataCus = Customer::where('document', '=',request()->dni)->first();
           $idcustomer = $DataCus->id;
           $datacustomer =  Customer::findOrFail($idcustomer);
           $datacustomer->email = request()->email;
           $datacustomer->phone = request()->phone;
           $datacustomer->document = request()->dni;
           $datacustomer->first_name = request()->first_name;
           $datacustomer->last_name = request()->last_name;
           $datacustomer->date_birth = request()->datebirth;
           $datacustomer->id_type_documents = request()->type_docs;
           $datacustomer->id_country = request()->cod_country;
           $datacustomer->id_state = request()->cod_state;
           $datacustomer->id_city = request()->cod_city;
           $datacustomer->address = request()->district;
           $datacustomer->modified_by  =  auth()->user()->id;
           $datacustomer->save();
           $datos = dtCustomerType::updateOrCreate(['id_customer' => $idcustomer, 'id_customerType' => request()->typecustomer] , ['id_customer' => $idcustomer, 'id_customerType' => request()->typecustomer] );
       }else{
         $data = [
           'first_name'      =>  request()->first_name,
           'last_name'       =>  request()->last_name,
           'document'        =>  request()->document,
           'date_birth'      =>  request()->datebirth,
           'document'        =>  request()->dni,
           'phone'           =>  request()->phone,
           'email'           =>  request()->email,
           'id_country'      =>  request()->cod_country,
           'id_state'        =>  request()->cod_state,
           'id_city'         =>  request()->cod_city,
           'address'         =>  request()->district,
           'admission_date'  =>  $dt->format('Y-m-d H:i:s'),
           'created_by'      =>  auth()->user()->id,
           'id_type_documents' => request()->type_docs
         ];
         $idcustomer = Customer::create($data)->id;
         $datos = dtCustomerType::updateOrCreate(['id_customer' => $idcustomer, 'id_customerType' => request()->typecustomer] , ['id_customer' => $idcustomer, 'id_customerType' => request()->typecustomer] );
       }

       if (request()->checkCustomerExt == "on"){
         if(Customer::where('document', '=',request()->dni_ext)->where('id_type_documents', '=',request()->type_docs_ext)->exists())
         {
             $DataCustExt = Customer::where('document', '=',request()->dni_ext)->where('id_type_documents', '=',request()->type_docs_ext)->first();
             $idcustomerExt = $DataCustExt->id;
             $datacustomerExt =  Customer::findOrFail($idcustomerExt);
             $datacustomer->email = request()->email_ext;
             $datacustomer->phone = request()->phone_ext;
             $datacustomer->document = request()->dni_ext;
             $datacustomer->first_name = request()->first_name_ext;
             $datacustomer->last_name = request()->last_name_ext;
             $datacustomer->date_birth = request()->datebirth_ext;
             $datacustomer->id_type_documents = request()->type_docs_ext;
             $datacustomer->modified_by  =  auth()->user()->id;
             $datacustomer->save();
             $datosExt = dtCustomerType::updateOrCreate(['id_customer' => $idcustomerExt, 'id_customerType' => request()->typecustomerext] , ['id_customer' => $idcustomerExt, 'id_customerType' => request()->typecustomerext] );
         }else{
           $dataExt = [
             'first_name'      =>  request()->first_name_ext,
             'last_name'       =>  request()->last_name_ext,
             'date_birth'      =>  request()->datebirth_ext,
             'document'             =>  request()->dni_ext,
             'phone'           =>  request()->phone_ext,
             'email'           =>  request()->email_ext,
             'admission_date'  =>  $dt->format('Y-m-d H:i:s'),
             'created_by'      =>  auth()->user()->id,
             'id_type_documents' => request()->type_docs_ext
           ];
           $idcustomerExt = Customer::create($dataExt)->id;
           $typecustomerext = request()->typecustomerext;
           $datosExt = dtCustomerType::updateOrCreate(['id_customer' => $idcustomerExt, 'id_customerType' => request()->typecustomerext] , ['id_customer' => $idcustomerExt, 'id_customerType' => request()->typecustomerext] );
           $cumpleanos2 = new \DateTime(request()->datebirth_ext);
           $hoy2 = new \DateTime();
           $annos2 = $hoy2->diff($cumpleanos2);
           $yearold = $annos2->y;
         }

         $relationship = request()->relationship;
       }else{
         $idcustomerExt = null;
         $relationship = null;
         $typecustomerext = null;
         $yearold = null;
       }


       $correo = request()->email;
       $telefono = request()->phone;
       $nombre = request()->first_name;
       $apellido = request()->last_name;

       $type = request()->status_user;

       $description = request()->description;

       $allstatus = TypeRequirements::where('id', '=',request()->status_user)->first();

       $dataUser = User::where('id', '=',auth()->user()->id)->first();

       $correouser = $dataUser->email;
       $checkticket = request()->checkticket;

       $grupst = GroupsTicket::where('id', '=',request()->group)->first();

       if($type != 9 || $checkticket == "on"){

             $api_key = $dataUser->api_key;
             $password = "x";
             $yourdomain = "wintecnologies";

             if ($type == 2){
               if (request()->category == 6){
                 $operator = Operators::where('id', '=',request()->operator)->first();
                 $brand = Brands::where('id', '=',request()->brand)->first();
                 $question = request()->appred == 'TRUE' ? "Si" : "No";
                 $SO = request()->OS == 1 ? "Android" : "IOS";
                 $descriptions = "Cliente: ".$nombre." ".$apellido."<br>  Telefono: ".$telefono." <br> Correo: ".$correo." <br> Operador: ".$operator->description." <br> ¿Utiliza el aplicativo en un red Wi-Fi?: ".$question." <br> Marca del equipo: ".$brand->description." <br> Modelo del equipo: ".request()->model." <br> Sistema operativo: ".$SO." <br> Version del android: ".request()->veros;
                 $descriptions .= "<br> Fecha del incidente: ".request()->fechven."<br> Hora (aproximada) del incidente: ".request()->hourven." <br> Descripcion: ".$description;
               }else{
                 $descriptions = "Cliente: ".$nombre." ".$apellido."<br>  Telefono: ".$telefono." <br> Correo: ".$correo;
                 $descriptions .= "<br> Lugar del incidente: ".request()->placeincident."<br> Fecha del incidente: ".request()->fechven."<br> Hora (aproximada) del incidente: ".request()->hourven." <br> Descripcion: ".$description;
               }
            }else{
                 $descriptions = "Cliente: ".$nombre." ".$apellido."<br>  Telefono: ".$telefono." <br> Correo: ".$correo." <br> ".$description;
            }

             $name =  $_FILES["myFile"]['name'];
             if(!empty($name))
             {
              $type =  $_FILES["myFile"]['type'];
              $mimetype = $_FILES["myFile"]['tmp_name'];
              $ticket_payload = array(
                'email' => $correouser,
                'subject' => $subject,
                'cc_emails[]' => $correo,
                'description' => $descriptions,
                'priority' => request()->id_priority,
                'status' => 2,
                'type' => $allstatus->description,
                'attachments[]' =>  curl_file_create($mimetype, $type, $name),
                'source' => 2,
                'group_id' => $grupst->idGroupFdesk,
              );
            }
            else
            {
                $ticket_payload = array(
                  'email' => $correouser,
                  'subject' => request()->subject,
                  'cc_emails[]' => $correo,
                  'description' => $descriptions,
                  'priority' => request()->id_priority,
                  'status' => 2,
                  'type' => $allstatus->description,
                  'source' => 2,
                  'group_id' => $grupst->idGroupFdesk,
                );


            }

         $url = "https://$yourdomain.freshdesk.com/api/v2/tickets";
         $ch = curl_init($url);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HEADER, true);
         curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
         curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_payload);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $server_output = curl_exec($ch);
         $info = curl_getinfo($ch);
         $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
         $headers = substr($server_output, 0, $header_size);
         $response = substr($server_output, $header_size);
         curl_close($ch);
         $res =  json_decode($response);

         if(!empty($name)){
           $attachments = $res->attachments[0]->attachment_url;
         }else{
           $attachments = null;
         }
         $nroticket = $res->id;
       }else{
         $nroticket = 0;
         $attachments = null;
       }

       if (request()->status_user == 2){
          $fechainci = request()->fechven;
          $horainci = request()->hourven.":00.0000-05";
          $fechafina = $fechainci." ".$horainci;
        }else{
          $fechafina = null;
        }

        if ($type == 10){
          $subject = request()->id_travel." - ".request()->gestionado;
          $category = request()->category;
        }else if ($type == 2){
          $subject = $nroticket." - ".request()->subject;
          $category = request()->category;
        }else{
          $subject = $nroticket." - ".request()->subject;
          $category = null;
        }

        $datcus = Customer::where('id', '=',$idcustomer)->first();

        $dateby = new \DateTime();
        $dateby->modify('+48 hours');
        $fr_due_by = $dateby->format('Y-m-d H:i:s');

        $date_due = new \DateTime();
        if(request()->id_priority == 1){
          $date_due->modify('+30 minute');
        }else if (request()->id_priority == 2){
          $date_due->modify('+25 minute');
        }else if (request()->id_priority == 3){
          $date_due->modify('+20 minute');
        }else{
          $date_due->modify('+15 minute');
        }
        $date_dues = $date_due->format('Y-m-d H:i:s');

        if (request()->typecustomer == 2){
          $placa = request()->placa;
          $marca = request()->marca;
          $modelo = request()->modelo;
          $color = request()->color;
          $year = request()->year;
          $typeSafe = request()->typesafe;
          $companyName = request()->company;
          $typeSoat = request()->typesoat;
          $fecEmi = request()->soatemi;
          $fecVen = request()->soatven;
        }

        $cumpleanos = new \DateTime(request()->datebirth);
        $hoy = new \DateTime();
        $annos = $hoy->diff($cumpleanos);

        $dataregister = [
          'id_customer' => $idcustomer,
          'id_customer_ext' => $idcustomerExt,
          'relationship' => $relationship,
          'age' => $annos->y,
          'age_ext' => $yearold,
          'subject' => $subject,
          'description' => $description,
          'nro_ticket' => $nroticket,
          'date_register' => $fecha,
          'time_register' => request()->timeregister,
          'time_start_register' => request()->timestaregister,
          'due_by' => $date_dues,
          'st_due_by' => false,
          'fr_due_by' => $fr_due_by,
          'st_fr_due_by' => false,
          'attachments' => $attachments,
          'id_type_requirements' => request()->status_user,
          'id_status_ts' => 2,
          'id_group' => request()->group,
          'ubication' => ($type == 2 && $category == 5) ? request()->placeincident : request()->ubication,
          'id_travel' => request()->id_travel,
          'id_category'  => $category,
          'referenceubi' => request()->referenceubi,
          'id_priorities' => request()->id_priority,
          'id_country' => $datcus->id_country,
          'id_type_customer' => request()->typecustomer,
          'id_type_customer_ext' => $typecustomerext,
          'placa' => (request()->typecustomer == 2) ? $placa : null,
          'marca' => (request()->typecustomer == 2) ? $marca : null,
          'model' => (request()->typecustomer == 2) ? $modelo : null,
          'color_car' => (request()->typecustomer == 2) ? $color : null,
          'year' => (request()->typecustomer == 2) ? $year  : null,
          'type_safe' => (request()->typecustomer == 2) ? $typeSafe  : null,
          'enterprisesoat' => (request()->typecustomer == 2) ? $companyName : null,
          'type_soat' => (request()->typecustomer == 2) ? $typeSoat : null,
          'soatfecemi' => (request()->typecustomer == 2) ? $fecEmi : null,
          'soatfecven' => (request()->typecustomer == 2) ? $fecVen : null,
          'motive' => request()->subject,
          'id_operator' => request()->operator,
          'appwifi' => request()->appred,
          'id_brand' => request()->brand,
          'models' => request()->model,
          'OS' => request()->OS,
          'verOS'  => request()->veros,
          'date_time'  => $fechafina,
          'details' => request()->description,
          'created_by' => auth()->user()->id,
          'type_servicedesk' => request()->typeTK
        ];
        $registerAtencion = RegisterAtencion::create($dataregister)->id;

        $dataUser = User::where('id','=',auth()->user()->id)->first();
        $dataticket = [
          'comment_subject' => $nroticket,
          'comment_text' => $dataUser->name." ".$dataUser->lastname." creó un nuevo ticket ".$subject,
          'comment_status' => 0,
          'comment_ip' => '0',
          'assigned_to' =>  $grupst->id_rol,
          'created_by' => auth()->user()->id,
          'modified_by' => $registerAtencion,
        ];
        $notickets = Notifications::create($dataticket);

        $dataAPI = array(
          'dni' => request()->dni,
          'type_docs'  => request()->type_docs,
          'email'  => request()->email,
          'phone'  => request()->phone,
          'first_name'  => request()->first_name,
          'last_name'  => request()->last_name,
          'datebirth'  => request()->datebirth,
          'cod_country'  => request()->cod_country,
          'cod_state'  => request()->cod_state,
          'cod_city'  => request()->cod_city,
          'district'  => request()->district,
          'id_user'  => auth()->user()->id,
          'typecustomer' => request()->typecustomer,
          'checkCustomerExt'  => request()->checkCustomerExt,
          'dni_ext'  => request()->dni_ext,
          'type_docs_ext'  => request()->type_docs_ext,
          'email_ext'  => request()->email_ext,
          'phone_ext'  => request()->phone_ext,
          'dni_ext'  => request()->dni_ext,
          'first_name_ext'  => request()->first_name_ext,
          'last_name_ext'  => request()->last_name_ext,
          'datebirth_ext'  => request()->datebirth_ext,
          'type_docs_ext'  => request()->type_docs_ext,
          'typecustomerext'  => request()->typecustomerext,
          'datebirth_ext'  => request()->datebirth_ext,
          'relationship'  => request()->relationship,
          'status_user'  => request()->status_user,
          'description' => request()->description,
          'checkticket' => request()->checkticket,
          'group' => request()->group,
          'category' => request()->category,
          'operator' => request()->operator,
          'brand' => request()->brand,
          'appred' => request()->appred,
          'OS' => request()->OS,
          'model' => request()->model,
          'veros' => request()->veros,
          'placeincident' => request()->placeincident,
          'fechven' => request()->fechven,
          'hourven' => request()->hourven,
          'subject' => request()->subject,
          'id_priority' => request()->id_priority,
          'id_travel' => request()->id_travel,
          'gestionado' => request()->gestionado,
          'placa' => request()->placa,
          'marca' => request()->marca,
          'modelo' => request()->modelo,
          'color' => request()->color,
          'year' => request()->year,
          'typesafe' => request()->typesafe,
          'company' => request()->company,
          'typesoat' => request()->typesoat,
          'soatemi' => request()->soatemi,
          'soatven' => request()->soatven,
          'timeregister' => request()->timeregister,
          'timestaregister' => request()->timestaregister,
          'placeincident' => request()->placeincident,
          'ubication' => request()->ubication,
          'referenceubi' => request()->referenceubi,
          'typeTK' => request()->typeTK,
          'file' => !empty($_FILES["myFile"]['name']) ? $_FILES["myFile"]['name'] : null,
          'attachment_url' => $attachments,
          'nro_ticket' => $nroticket,
          'date_register' => $fecha,
          'due_by' => $date_dues,
          'fr_due_by' => $fr_due_by
        );
        $stringAPI  = json_encode($dataAPI);
        $chAPI = curl_init('https://test.conductores.wintecnologies.com/api/insert/servicedesk');
                 curl_setopt($chAPI, CURLOPT_CUSTOMREQUEST, "PUT");
                 curl_setopt($chAPI, CURLOPT_POSTFIELDS, $stringAPI);
                 curl_setopt($chAPI, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($chAPI, CURLOPT_HTTPHEADER, array(
                     'Content-Type: application/json',
                     'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
                 );
         $resultAPI   = curl_exec($chAPI);
         curl_close($chAPI);
         $myArray  = json_decode($resultAPI);

        if ($registerAtencion > 0){
          return response()->json(["message" => "creado","apicon" => $stringAPI]);
        }else{
          return response()->json(["message" => "error","apicon" => $stringAPI]);
        }

        }

        public function allservice(){
          $rol = Main::where('users.id', '=', auth()->user()->id)
            ->where('main.status_user', '=', 'TRUE')
            ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
            ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
            ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
            ->join('users',    'users.id',              '=',   'rol_user.id_user')
            ->select('roles.id')
            ->first();

            $start_datec     = request()->start_datec ? request()->start_datec." 00:00:00.0000-05" : null;
            $end_datec       = request()->end_datec   ? request()->end_datec." 23:59:59.0000-05"   : null;
            $id_customer     = request()->datos{'id_customer'};
            $id_country      = request()->datos{'id_country'};
            $status_user     = request()->datos{'status_user'};
            $num_ticket      = request()->datos{'num_ticket'};
            $statusT         = request()->datos{'id_statusT'};
            $created_by      = request()->datos{'created_by'};


          $registerate = RegisterAtencion::query();

          if (isset(request()->datos{'modified_by'})){
            $modified_by     = request()->datos{'modified_by'};
            if ($modified_by) $registerate->Where('created_by' ,'=', $modified_by)->Where('status_system','=',TRUE);
          }

          if (isset(request()->datos{'group'})){
            $Groups          = request()->datos{'group'};
            if ($Groups)      $registerate->Where('id_group','=',$Groups)->Where('status_system','=',TRUE);
          }

          $myGroups = GroupsTicket::select('id')->where('id_rol', '=', $rol->id)->get();

          if ($num_ticket)  $registerate->Where('nro_ticket', 'LIKE', '%' . $num_ticket . '%')->Where('status_system','=',TRUE);
          if ($id_customer) $registerate->Where('id_customer','=',$id_customer)->Where('status_system','=',TRUE);
          if ($id_country)  $registerate->where('id_country', '=', $id_country)->Where('status_system','=',TRUE);
          if ($status_user) $registerate->Where('id_type_requirements','=',$status_user)->Where('status_system','=',TRUE);
          if ($statusT)     $registerate->Where('id_status_ts','=',$statusT)->Where('status_system','=',TRUE);

          if ($start_datec && $end_datec)  $registerate->WhereBetween('created_at', [$start_datec, $end_datec])->Where('status_system','=',TRUE);

          $t = $this->PermisosAtencion();
          $superUser  = true;

          if ($superUser == true){
            if ($created_by == "1"){
              $registerate = $registerate->Where('created_by' ,'=', auth()->user()->id)->with('getCustomer','getCreateBy', 'getStatusT','getCountry','getTypeRequirements','getGroups','getAssigned')->get();
            }else if($created_by == "2"){
              $registerate = $registerate->Where('asignated_to' ,'=', auth()->user()->id)->with('getCustomer','getCreateBy', 'getStatusT','getCountry','getTypeRequirements','getGroups','getAssigned')->get();
            }else{
              $registerate = $registerate->Where('status_system' ,'=', 'true')->with('getCustomer','getCreateBy', 'getStatusT','getCountry','getTypeRequirements','getGroups','getAssigned')->get();
            }
          }else{
            if ($created_by == "1"){
              $registerate = $registerate->Where('created_by' ,'=', auth()->user()->id)->with('getCustomer','getCreateBy', 'getStatusT','getCountry','getTypeRequirements','getGroups','getAssigned')->get();
            }else if($created_by == "2"){
              $registerate = $registerate->Where('asignated_to' ,'=', auth()->user()->id)->with('getCustomer','getCreateBy', 'getStatusT','getCountry','getTypeRequirements','getGroups','getAssigned')->get();
            }else{
              $registerate = $registerate->whereIn('id_group', $myGroups)->orWhere('asignated_to' ,'=', auth()->user()->id)->with('getCustomer','getCreateBy', 'getStatusT','getCountry','getTypeRequirements','getGroups','getAssigned')->get();
            }
          }

          $registeratesAll = [];
          foreach ($registerate as $r) {
            if ($r->type_servicedesk == 1){
              $canalgestion = "<i class='fa fa-user' style='color: #F7821A;'></i> presencial";
            }else if ($r->type_servicedesk == 2){
              $canalgestion = "<i class='fa fa-phone' style='color: #F1E40B;'></i> llamada";
            }else if ($r->type_servicedesk == 3){
              $canalgestion = "<i class='fa fa-commenting' style='color: #18E72E;'></i> chat";
            }else if($r->type_servicedesk == 3){
              $canalgestion = "<i class='fa fa-envelope' style='color: #0A488E;'></i> correo";
            }else{

            }

            if ($t->rolid == 2 || $t->rolid == 6){
              $imprimir = '<a href="/atencion/tickets/download/'.$r->id.'"><i class="fa fa-download" title="Descargar"></i></a>';
            }else{
              $imprimir = '<a onclick="callatentions('.$r->id.')"><i class="fa fa-phone" title="Llamar"></i></a>';
            }

            $date = new \DateTime($r->created_at);
            $register   = [
              'id'          => $r->subject,
              'name'        => $r->getCustomer  ? strtoupper($r->getCustomer->first_name) :'-',
              'lastname'    => $r->getCustomer  ? strtoupper($r->getCustomer->last_name)  :'-',
              'num_ticket'  => $r->nro_ticket   ? "<a href='https://wintecnologies.freshdesk.com/a/tickets/".$r->nro_ticket."' target='_blank'>".$r->nro_ticket."</a>"   : '-',
              'id_reqi'     => $r->getTypeRequirements    ? $r->getTypeRequirements->description : '-',
              'area'        => $r->getGroups    ? $r->getGroups->description :'-',
              'created_at'  => $date->format('Y-m-d H:i'),
              'status'      => $r->getStatusT    ? $r->getStatusT->description : '-',
              'imprimir'    => $imprimir,
              'ver'         => '<a href="/atencion/tickets/views/'.$r->nro_ticket.'/'.$r->id.'"><i class="fa fa-eye" title="er"></i></a>',
              'assigned'    => $r->getAssigned    ? $r->getAssigned->name.' '.$r->getAssigned->lastname : '--',
              'channel'     => $canalgestion
            ];
            array_push($registeratesAll, $register);
          }

          return response()->json([
            'data'     =>  $registeratesAll,
          ]);

        }

        public function getTicketDetails($idt,$id){
          $title = 'Ticket Detalle';
          $main = new MainClass();
          $main = $main->getMain();
          $dataUser = User::where('id', '=',auth()->user()->id)->first();
          $api_key = $dataUser->api_key;
          $password = "x";
          if ($idt <> 0){
            $yourdomain = "wintecnologies";
            $ticket_id = $idt;
            // Return the tickets that are new or opend & assigned to you
            // If you want to fetch all tickets remove the filter query param
            $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id?include=conversations";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $info = curl_getinfo($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($server_output, 0, $header_size);
            $response = substr($server_output, $header_size);
            if($info['http_code'] == 200) {
              $resp = json_decode($response,true);
            } else {
              if($info['http_code'] == 404) {
                echo "Error, Please check the end point \n";
              } else {
                echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
                echo "Headers are ".$headers;
                echo "Response are ".$response;
              }
            }
            curl_close($ch);
         }

          $ticketreg = RegisterAtencion::where('id','=',$id)->with('getCustomer','getCreateBy', 'getStatusT','getCountry','getGroups','getTypeRequirements','getCategory','getPriority','getCustomerType','getOperators','getBrands','getCustomerExt','getCustomerTypeExt','getAssigned')->first();
          $conversation = Conversations::where('id_ticket','=',$id)->where('type_conversation',1)->with('getCreatedBy','getNotified')->orderBy('id','asc')->get();
          $notesTK      = Conversations::where('id_ticket','=',$id)->where('type_conversation',2)->with('getCreatedBy','getNotified')->get();
          $subject = $ticketreg->subject;

          if ($ticketreg->type_servicedesk == 1){
            $canalgestion = "Presencial";
          }else if ($ticketreg->type_servicedesk == 2){
            $canalgestion = "Llamada";
          }else if ($ticketreg->type_servicedesk == 3){
            $canalgestion = "Chat";
          }else{
            $canalgestion = "Correo electronico";
          }

          $datebys = new \DateTime();
          $fechaInicial = $ticketreg->created_at;
          $fechaFinal   = $datebys->format('d-m-Y H:i:s');
          $seg = strtotime($fechaFinal) - strtotime($fechaInicial);

          $d = floor($seg / 86400);
          $h = floor(($seg - ($d * 86400)) / 3600);
          $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
          $s = $seg % 60;
          $times = '';
          if ($d > 0){
            $times =  ($d == 1) ? $d." Día " : $d." Días ";
          }else if ($h > 0){
            $times = ($h == 1) ? $h." hora " : $h." horas ";
          }else if ($m > 0){
            $times = ($m == 1) ? $m." minuto " : $m." minutos ";
          }else{
            $times = ($s == 1) ? $s." segundo " : $s." segundos ";
          }
          $ccs = $ticketreg->getCustomer->email;

          if ($ticketreg->getCustomerType->id == 2){
            $desc1 = "<br><br> <b>VEHICULO</b>".
                     "<br> <b>Placa/Matricula: </b>".$ticketreg->placa.
                     "<br> <b>Marca: </b>".$ticketreg->marca.
                     "<br> <b>Modelo: </b>".$ticketreg->model.
                     "<br> <b>Color: </b>".$ticketreg->color_car.
                     "<br> <b>Año: </b>".$ticketreg->year.
                     "<br><br> <b>SEGURO</b>".
                     "<br> <b>Tipo: </b>".$ticketreg->type_safe.
                     "<br> <b>Compañia: </b>".$ticketreg->enterprisesoat.
                     "<br> <b>Tipo de Soat: </b>".$ticketreg->type_soat.
                     "<br> <b>Fecha vigencia: </b>".$ticketreg->soatfecemi.
                     "<br> <b>Fecha Vencimiento: </b>".$ticketreg->soatfecven;
          }else{
            $desc1 = "";
          }

          if ($ticketreg->id_customer_ext > 0){
            $desc2 = "<br><br> <b>TERCERO INVOLUCRADO</b>".
                     "<br> <b>Tipo: </b>".$ticketreg->getCustomerTypeExt->description.
                     "<br> <b>Nombre Completo: </b>".$ticketreg->getCustomerExt->first_name." ".$ticketreg->getCustomerExt->last_name.
                     "<br> <b>Tipo de Doc.: </b>".$ticketreg->getCustomerExt->getTypeDocuments->description.
                     "<br> <b>Numero de Doc.: </b>".$ticketreg->getCustomerExt->dni.
                     "<br> <b>Edad: </b>".$ticketreg->age_ext.
                     "<br> <b>Telefono: </b>".$ticketreg->getCustomerExt->phone.
                     "<br> <b>Correo: </b>".$ticketreg->getCustomerExt->email.
                     "<br> <b>Parentesco: </b>".$ticketreg->relationship;
          }else{
            $desc2 = "";
          }



          if ($ticketreg->getTypeRequirements->id == 10){
            $locat= explode(",", $ticketreg->ubication);
            $lat = substr($locat[0],1);
            $long = substr($locat[1],0,-1);
            $desc = "<b>GESTIONADO: </b>".strtoupper($ticketreg->getCustomerType->description).
                    "<br><br> <b>CLIENTE: </b>".
                    "<br> <b>Nombre Completo: </b>".$ticketreg->getCustomer->first_name." ".$ticketreg->getCustomer->last_name.
                    "<br> <b>Tipo de Doc.: </b>".$ticketreg->getCustomer->getTypeDocuments->description.
                    "<br> <b>Numero de Doc.: </b>".$ticketreg->getCustomer->dni.
                    "<br> <b>Edad: </b>".$ticketreg->age.
                    "<br> <b>Telefono: </b>".$ticketreg->getCustomer->phone.
                    "<br> <b>Correo: </b>".$ticketreg->getCustomer->email.
                    "<br> <b>Pais: </b>".$ticketreg->getCustomer->getCountry->description.
                    "<br> <b>Departamento: </b>".$ticketreg->getCustomer->getState->description.
                    "<br> <b>Ciudad: </b>".$ticketreg->getCustomer->getCity->description.
                    "<br> <b>Direccion: </b>".$ticketreg->getCustomer->address.
                    "<br><br> <b>EMERGENCIA</b>".
                    "<br><br> <b>REFERENCIA: </b>".$ticketreg->referenceubi.
                    "<br> <b>UBICACION: </b> <input type='button' value='ver' onClick='initialize(".$lat.",".$long.");' /><div id='map' style='height: 400px; width: 450px;'></div><br>".
                    "<br><br> <b>DESCRIPCION: </b>".$ticketreg->description;
          }else if ($ticketreg->getTypeRequirements->id == 2){
            $fechas = explode(" ", $ticketreg->date_time);
            $SO = ($ticketreg->OS == "1") ? "Android" : "IOS";
            $redWF = ($ticketreg->appwifi == false) ? "No" : "Si";
            $desc = "<b>GESTIONADO: </b>".strtoupper($ticketreg->getCustomerType->description).
                    "<br><br> <b>CLIENTE: </b>".
                    "<br> <b>Nombre Completo: </b>".$ticketreg->getCustomer->first_name." ".$ticketreg->getCustomer->last_name.
                    "<br>  Telefono: ".$ticketreg->getCustomer->phone.
                    "<br> Correo: ".$ticketreg->getCustomer->email.
                    "<br> Operador: ".$ticketreg->getOperators->description.
                    "<br> ¿Utiliza el aplicativo en un red Wi-Fi?: ".$redWF.
                    "<br> Marca del equipo: ".$ticketreg->getBrands->description.
                    "<br> Modelo del equipo: ".$ticketreg->models.
                    "<br> Sistema operativo: ".$SO.
                    "<br> Version del android: ".$ticketreg->verOS.
                    "<br> Fecha del incidente: ".$fechas[0].
                    "<br> Hora (aproximada) del incidente: ".$fechas[1].
                    "<br><br> Descripcion: ".$ticketreg->description;
          }else {
            $desc = "<b>GESTIONADO: </b>".strtoupper($ticketreg->getCustomerType->description).
                    "<br><br> <b>CLIENTE: </b>".
                    "<br> <b>Nombre Completo: </b>".$ticketreg->getCustomer->first_name." ".$ticketreg->getCustomer->last_name.
                    "<br> <b>Tipo de Doc.: </b>".$ticketreg->getCustomer->getTypeDocuments->description.
                    "<br> <b>Numero de Doc.: </b>".$ticketreg->getCustomer->dni.
                    "<br> <b>Edad: </b>".$ticketreg->age.
                    "<br>  <b>Telefono: </b>".$ticketreg->getCustomer->phone.
                    "<br> <b>Correo: </b>".$ticketreg->getCustomer->email.
                    "<br> <b>Pais: </b>".$ticketreg->getCustomer->getCountry->description.
                    "<br> <b>Departamento: </b>".$ticketreg->getCustomer->getState->description.
                    "<br> <b>Ciudad: </b>".$ticketreg->getCustomer->getCity->description.
                    "<br> <b>Direccion: </b>".$ticketreg->getCustomer->address.$desc1.$desc2.
                    "<br><br> <b>DESCRIPCION: </b>".$ticketreg->description;
          }

          $agent = $this->getDataAgent($api_key,$password,$dataUser->agent_id);
          $firma = $agent['signature'];
          $convs = $conversation;
          $idregt = $ticketreg->id;

          if (Conversations::where('id_ticket','=',$id)->where('type_conversation',1)->with('getCreatedBy')->orderBy('id','desc')->exists()){
              $countconv = Conversations::where('id_ticket','=',$id)->where('type_conversation',1)->with('getCreatedBy')->orderBy('id','desc')->count();
              if ($countconv > 1){
                $Datacon = Conversations::where('id_ticket','=',$id)->where('type_conversation',1)->with('getCreatedBy')->orderBy('id','desc')->first();
                $toresp = $Datacon->getCreatedBy->email;
                $createdby = $Datacon->getCreatedBy->name." ".$Datacon->getCreatedBy->lastname;
              }else{
                $toresp = $ticketreg->getCreateBy->email;
                $createdby = $ticketreg->getCreateBy->name." ".$ticketreg->getCreateBy->lastname;
              }
          }else{
                $toresp = $ticketreg->getCreateBy->email;
                $createdby = $ticketreg->getCreateBy->name." ".$ticketreg->getCreateBy->lastname;
          }

          $tocreate = $ticketreg->getCreateBy->email;
          $tocreateNL = $ticketreg->getCreateBy->name." ".$ticketreg->getCreateBy->lastname;


          $name   = $dataUser->name." ".$dataUser->lastname;
          $idti   = $idt;
          $type   = $ticketreg->getTypeRequirements->id;
          $status = $ticketreg->getStatusT->id;
          $priority = $ticketreg->getPriority->id;
          $groupT  = $ticketreg->getGroups->id;
          $due_by = $ticketreg->due_by;
          $fr_due_by  = $ticketreg->fr_due_by;
          $agentT  = $ticketreg->asignated_to;
          $typeRs     = TypeRequirements::select(DB::raw("UPPER(description) AS description"), "id")->pluck('description', 'id');
          $priorities = Priority::orderBy('description', 'ASC')->pluck('description', 'id');
          $statusT    = StatusT::select(DB::raw("UPPER(description) AS description"), "id")->pluck('description', 'id');
          $groups     = GroupsTicket::orderBy('description', 'ASC')->pluck('description', 'id');

          $rolGroup   = GroupsTicket::select('id_rol')->where('id', '=', $groupT)->first();

          $agentsG    = User::select(DB::raw("UPPER(CONCAT(username, ' - ', lastname,'  ', name)) AS name"), "users.id")
                          ->join('rol_user', 'users.id', '=', 'rol_user.id_user')
                          ->where('id_role', '=', $rolGroup->id_rol)->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');

          $agentsGID    = User::select(DB::raw("UPPER(CONCAT(lastname,'  ', name,' (',email,') ')) AS name"), "users.id")
                          ->where('status_user', '=', true)->orderBy('name',  'ASC')->pluck( '(lastname||" " ||name)as name', 'id');

          return view('AtencionCliente.ticketDetails',  compact('main', 'title','canalgestion','tocreate','tocreateNL','subject','createdby','times','ccs','desc','convs','firma','name','toresp','idti','status','type','priority','groupT','due_by','fr_due_by','typeRs','priorities','statusT','groups','idregt','agentsG','agentT','agentsGID','notesTK'));
        }

        function getDataAgent($api_key,$password,$id){

          $url = "https://wintecnologies.freshdesk.com/api/v2/agents/$id";
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_HEADER, true);
          curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $server_output = curl_exec($ch);
          $info = curl_getinfo($ch);
          $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
          $headers = substr($server_output, 0, $header_size);
          $response = substr($server_output, $header_size);
          if($info['http_code'] == 200) {
            $res = json_decode($response,true);
            return $res;
          } else {
            if($info['http_code'] == 404) {
              echo "Error, Please check the end point \n";
            } else {
              echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
              echo "Headers are ".$headers;
              echo "Response are ".$response;
            }
          }
          curl_close($ch);
        }

        function GetAgentsByGroupID(){

          $rolGroups   = GroupsTicket::select('id_rol')->where('id', '=', request()->id)->first();

          $agentsGroup    = User::select("username","lastname","name","users.id")
                          ->join('rol_user', 'users.id', '=', 'rol_user.id_user')
                          ->where('id_role', '=', $rolGroups->id_rol)->orderBy('name',  'ASC')->get();

          return response()->json([
              'data'     =>  $agentsGroup,
          ]);
        }

        public function updateRegTick(Request $r){
          $idT = $r->idregti;
          $nroT = $r->nroti;
          $typeR = $r->typeRs;
          $status = $r->id_status;
          $Priority = $r->id_priority;
          $Group = $r->group;
          $Agent = $r->agentID;
          $dataAgent = User::where('id', '=',$Agent)->first();

          $GroupsID = GroupsTicket::where('id', '=',$Group)->first();
          $TypeRs = TypeRequirements::where('id', '=',$typeR)->first();

          //if ($nroT <> 0){
            $dataUser = User::where('id', '=',auth()->user()->id)->first();
            $api_key = $dataUser->api_key;
            $password = "x";
            $yourdomain = "wintecnologies";
            if ($Agent > 0){
              $ticket_update = array(
                "status" => $status,
                "priority" => $Priority,
                "group_id" => $GroupsID->idGroupFdesk,
                "type"     => $TypeRs->description,
                "responder_id" =>  $dataAgent->agent_id
              );
            }else{
              $ticket_update = array(
                "status" => $status,
                "priority" => $Priority,
                "group_id" => $GroupsID->idGroupFdesk,
                "type"     => $TypeRs->description
              );
            }

            $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$nroT";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_update);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $info = curl_getinfo($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($server_output, 0, $header_size);
            $response = substr($server_output, $header_size);
            curl_close($ch);
           //}



           $TicketsDet = RegisterAtencion::where('id','=',$idT)->with('getCustomer','getCreateBy','getAssigned')->first();
           // if ($TicketsDet->id_group != $Group){
           //   $toresp = $TicketsDet->getAssigned->id;
           // }else{
           //   $toresp = $TicketsDet->getCreateBy->id;
           // }

           $rol = GroupsTicket::select('id_rol')->where('id', '=', $Group)->first();

           if ($TicketsDet->id_type_requirements != $typeR){
               $dataticket = [
                 'comment_subject' => $nroT,
                 'comment_text' => $dataUser->name." ".$dataUser->lastname." actualizo el tipo de ".$TicketsDet->subject." para ".$TypeRs->description,
                 'comment_status' => 0,
                 'comment_ip' => '0',
                 'modified_by' => $idT,
                 'assigned_to' =>  $rol->id_rol,
                 'created_by' => auth()->user()->id
               ];
               Notifications::create($dataticket);
           }


           if ($TicketsDet->id_status_ts != $status){
               $DataSta = StatusT::where('id','=',$status)->first();
               $dataticket1 = [
                 'comment_subject' => $nroT,
                 'comment_text' => $dataUser->name." ".$dataUser->lastname." actualizo el estado de ".$TicketsDet->subject." para ".$DataSta->description,
                 'comment_status' => 0,
                 'comment_ip' => '0',
                 'modified_by' => $idT,
                 'assigned_to' =>  $rol->id_rol,
                 'created_by' => auth()->user()->id
               ];
               Notifications::create($dataticket1);
           }

           if ($TicketsDet->id_group != $Group){
               $dataticket2 = [
                 'comment_subject' => $nroT,
                 'comment_text' => $dataUser->name." ".$dataUser->lastname." actualizó el grupo de ".$TicketsDet->subject." para ".$GroupsID->description,
                 'comment_status' => 0,
                 'comment_ip' => '0',
                 'modified_by' => $idT,
                 'assigned_to' =>  $rol->id_rol,
                 'created_by' => auth()->user()->id
               ];
               Notifications::create($dataticket2);
           }


           if ($TicketsDet->id_priorities != $Priority){
               $dataPriority = Priority::where('id','=',$Priority)->first();
               $dataticket3 = [
                 'comment_subject' => $nroT,
                 'comment_text' => $dataUser->name." ".$dataUser->lastname." actualizó la prioridad de ".$TicketsDet->subject." para ".$dataPriority->description,
                 'comment_status' => 0,
                 'comment_ip' => '0',
                 'modified_by' => $idT,
                 'assigned_to' =>  $rol->id_rol,
                 'created_by' => auth()->user()->id
               ];
               Notifications::create($dataticket3);
           }

           if ($TicketsDet->asignated_to != $Agent){
               $dataticket4 = [
                 'comment_subject' => $nroT,
                 'comment_text' => $dataUser->name." ".$dataUser->lastname." asignó ".$TicketsDet->subject." para ".$dataAgent->name." ".$dataAgent->lastname,
                 'comment_status' => 0,
                 'comment_ip' => '0',
                 'modified_by' => $idT,
                 'assigned_to' =>  $rol->id_rol,
                 'created_by' => auth()->user()->id
               ];
               Notifications::create($dataticket4);
           }

           if ($status == 5){
             $datebys = new \DateTime();
             $timereg = Timeregisters::where('id_reg_att','=',$idT)->first();
             $timereg->dt_finished_ticket_attention = $datebys->format('d-m-Y H:i:s');
             $timereg->save();
           }

           $dataupdateT = RegisterAtencion::where('id','=',$idT)->first();
           $dataupdateT->id_type_requirements = $typeR;
           $dataupdateT->id_status_ts = $status;
           $dataupdateT->id_group = $Group;
           $dataupdateT->id_priorities = $Priority;
           $dataupdateT->asignated_to = $Agent;
           $dataupdateT->save();

           return response()->json([
               "message" => "oki"
           ]);
         }

         function reply(Request $request){
          $main = new MainClass();
          $main = $main->getMain();

          $id_ticket = $request->idti;
          $descri =    $request->desc;
          $status =    $request->type;
          $idregt =    $request->idregt;

          $TicketsDet = RegisterAtencion::where('id','=',$idregt)->with('getCustomer','getCreateBy','getAssigned')->first();
          $dataUser = User::where('id','=',auth()->user()->id)->first();
          if ($id_ticket <> 0){
              $api_key = $dataUser->api_key;
              $password = "x";
              $yourdomain = "wintecnologies";


              // Reply will be added to the ticket with the following id
              $note_payload = array(
                "body" => "<div>".$descri."</div>",
                "cc_emails[]" => $TicketsDet->getCustomer->email,
              );
              $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$id_ticket/reply";
              $ch = curl_init($url);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_HEADER, true);
              curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $note_payload);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              $server_output = curl_exec($ch);
              $info = curl_getinfo($ch);
              $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
              $headers = substr($server_output, 0, $header_size);
              $response = substr($server_output, $header_size);
              // if($info['http_code'] == 201) {
              //   echo "Note added to the ticket, the response is given below \n";
              //   echo "Response Headers are \n";
              //   echo $headers."\n";
              //   echo "Response Body \n";
              //   echo "$response \n";
              // } else {
              //     if($info['http_code'] == 404) {
              //     echo "Error, Please check the end point \n";
              //     } else {
              //         echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
              //         echo "Headers are ".$headers."\n";
              //         echo "Response is ".$response;
              //     }
              //  }
              curl_close($ch);
          }

          if (Conversations::where('id_ticket','=',$idregt)->where('type_conversation',1)->with('getCreatedBy')->orderBy('id','desc')->exists()){
              $countconv = Conversations::where('id_ticket','=',$idregt)->where('type_conversation',1)->with('getCreatedBy')->orderBy('id','desc')->count();
              if ($countconv > 1){
                $Datacon = Conversations::where('id_ticket','=',$idregt)->where('type_conversation',1)->with('getCreatedBy')->orderBy('id','desc')->first();
                $toresp1 = $Datacon->getCreatedBy->id;
              }else{
                $toresp1 = $Datacon->getCreatedBy->id;
              }
          }else{
                $toresp1 = $TicketsDet->getCreateBy->id;
          }

          $r = $this->updateTicket($status,$id_ticket,$idregt);
          $data = [
            'description' => "<div>".$descri."</div>",
            'id_ticket' => $idregt,
            'created_by' => auth()->user()->id,
            'type_conversation' => 1,
            'notified_to' => $toresp1
          ];
          $id = Conversations::create($data);

          $count = Conversations::where('id_ticket','=',$idregt)->count();
          if ($count == 1){
            $TicketsD = RegisterAtencion::where('id','=',$idregt)->first();
            $TicketsD->asignated_to = auth()->user()->id;
            $TicketsD->save();
          }

          if (auth()->user()->id == $TicketsDet->getCreateBy->id){
            $toresp = $TicketsDet->getCreateBy->id;
          }else{
            $toresp = $TicketsDet->getCreateBy->id;
          }

          $rol = Main::where('users.id', '=', $toresp)
            ->where('main.status_user', '=', 'TRUE')
            ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
            ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
            ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
            ->join('users',    'users.id',              '=',   'rol_user.id_user')
            ->select('roles.id')
            ->first();

          $dataticket = [
            'comment_subject' => $id_ticket,
            'comment_text' => $dataUser->name." ".$dataUser->lastname." envió una respuesta al ticket ".$TicketsDet->subject,
            'comment_status' => 0,
            'comment_ip' => '0',
            'modified_by' => $idregt,
            'assigned_to' =>  $rol->id,
            'created_by' => auth()->user()->id
          ];
          $notickets = Notifications::create($dataticket)->id;



          $dataAPI = array(
            'idti' => $id_ticket,
            'desc' => $descri,
            'type' => $status,
            'id_user' => auth()->user()->id,
            'rol_id' => $rol->id,
            'subject' => $TicketsDet->subject,
            'notified_to' => $toresp1
          );
          $stringAPI  = json_encode($dataAPI);
          $chAPI = curl_init('https://test.conductores.wintecnologies.com/api/reply/servicedesk');
                   curl_setopt($chAPI, CURLOPT_CUSTOMREQUEST, "PUT");
                   curl_setopt($chAPI, CURLOPT_POSTFIELDS, $stringAPI);
                   curl_setopt($chAPI, CURLOPT_RETURNTRANSFER, true);
                   curl_setopt($chAPI, CURLOPT_HTTPHEADER, array(
                       'Content-Type: application/json',
                       'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
                   );
           $resultAPI   = curl_exec($chAPI);
           curl_close($chAPI);
           $myArray  = json_decode($resultAPI);


          if ($notickets > 0){
            return response()->json(["message" => "creado", "apirest" => $myArray]);
          }else{
            return response()->json(["message" => "error", "apirest" => $myArray]);
          }
        }

        public function replyNote(request $request){
          $main = new MainClass();
          $main = $main->getMain();

          $id_ticket = $request->idti;
          $descri =    $request->desc;
          $status =    $request->type;
          $idregt =    $request->idregt;

          $GetDataUser = User::where('id', '=',$request->agentsGID)->first();

          if ($request->typeConv == 1){
            $private = "true";
          }else{
            $private = "false";
          }

          $dataUser = User::where('id', '=', auth()->user()->id)->first();
          if ($id_ticket <> 0){
              $api_key = $dataUser->api_key;
              $password = "x";
              $yourdomain = "wintecnologies";
              // Reply will be added to the ticket with the following id
              $note_payload = array(
                "body" => "<div>".$descri."</div>",
                "private" => $private,
                "notify_emails[]" => $GetDataUser->email,
              );
              $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$id_ticket/notes";
              $ch = curl_init($url);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_HEADER, true);
              curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $note_payload);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              $server_output = curl_exec($ch);
              $info = curl_getinfo($ch);
              $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
              $headers = substr($server_output, 0, $header_size);
              $response = substr($server_output, $header_size);
              // if($info['http_code'] == 201) {
              //   echo "Note added to the ticket, the response is given below \n";
              //   echo "Response Headers are \n";
              //   echo $headers."\n";
              //   echo "Response Body \n";
              //   echo "$response \n";
              // } else {
              //     if($info['http_code'] == 404) {
              //     echo "Error, Please check the end point \n";
              //     } else {
              //         echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
              //         echo "Headers are ".$headers."\n";
              //         echo "Response is ".$response;
              //     }
              //  }
              curl_close($ch);
          }

          $r = $this->updateTicket($status,$id_ticket,$idregt);
          $data = [
            'description' => "<div>".$descri."</div>",
            'id_ticket' => $idregt,
            'created_by' => auth()->user()->id,
            'type_conversation' => 2,
            'notified_to' => $request->agentsGID,
            'status' => $request->typeConv,
          ];
          $id = Conversations::create($data);

          $TicketsDet = RegisterAtencion::where('id','=',$idregt)->with('getCustomer','getCreateBy','getAssigned')->first();

          if (auth()->user()->id == $TicketsDet->getCreateBy->id){
            $toresp = $TicketsDet->getAssigned->id;
          }else{
            $toresp = $TicketsDet->getCreateBy->id;
          }

          $rol = Main::where('users.id', '=', $toresp)
            ->where('main.status_user', '=', 'TRUE')
            ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
            ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
            ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
            ->join('users',    'users.id',              '=',   'rol_user.id_user')
            ->select('roles.id')
            ->first();

          $dataticket = [
            'comment_subject' => $id_ticket,
            'comment_text' => $dataUser->name." ".$dataUser->lastname." añadió una nota al ticket ".$TicketsDet->subject,
            'comment_status' => 0,
            'comment_ip' => '0',
            'modified_by' => $idregt,
            'assigned_to' =>  $rol->id,
            'created_by' => auth()->user()->id
          ];

          $notickets = Notifications::create($dataticket)->id;

          if ($notickets > 0){
            return response()->json(["message" => "creado"]);
          }else{
            return response()->json(["message" => "error"]);
          }
        }

        public function updateTicketStatus(){
          $attencionsRegs = RegisterAtencion::where('id','=',request()->id)->first();
          $attencionsRegs->id_status_ts = request()->status;
          $attencionsRegs->save();
          $message = "Se actualizo la atencion correctamente";
          return response()->json([
              "message" => $message,
              "object" => "success",
          ]);
        }

        public function updateTicket($status,$id_ticket,$idregt){
          $main = new MainClass();
          $main = $main->getMain();

          if ($id_ticket <> 0){
            $dataUser = User::where('id','=',auth()->user()->id)->first();
            $api_key = $dataUser->api_key;
            $password = "x";
            $yourdomain = "wintecnologies";
            $ticket_update = array(
              "status" => $status
            );

            $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$id_ticket";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_update);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $info = curl_getinfo($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($server_output, 0, $header_size);
            $response = substr($server_output, $header_size);
              // if($info['http_code'] == 201) {
              //   echo "Note added to the ticket, the response is given below \n";
              //   echo "Response Headers are \n";
              //   echo $headers."\n";
              //   echo "Response Body \n";
              //   echo "$response \n";
              // } else {
              //     if($info['http_code'] == 404) {
              //     echo "Error, Please check the end point \n";
              //     } else {
              //         echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
              //         echo "Headers are ".$headers."\n";
              //         echo "Response is ".$response;
              //     }
              //  }
              curl_close($ch);
           }

             $dataupdate = RegisterAtencion::where('id','=',$idregt)->first();
             $dataupdate->id_status_ts = $status;
             $dataupdate->save();

             return "oki";
        }

        public function getNotifications(){
            $regiservice = RegisterAtencion::where('status_system','=',TRUE)->get();
            $hoy = new \DateTime();
            foreach ($regiservice as $r) {

              if ($r->due_by > $hoy && $r->id_status_ts == 2){
                if ($r->st_due_by == FALSE){
                  $dataticket = [
                    'comment_subject' => $r->nro_ticket,
                    'comment_text' => "Se vencio la primera respuesta para el ticket Nro #".$r->nro_ticket,
                    'comment_status' => 0,
                    'comment_ip' => '0',
                    'assigned_to' =>  3,
                    'created_by' => 1,
                    'modified_by' => $r->id,
                  ];
                  $notickets = Notifications::create($dataticket);
                }

                $service = RegisterAtencion::where('id', $r->id)->first();
                $service->st_due_by = TRUE;
                $service->save();
              }


              if ($r->fr_due_by > $hoy && $r->id_status_ts != 5){
                if ($r->st_fr_due_by == FALSE){
                  $dataticket = [
                    'comment_subject' => $r->nro_ticket,
                    'comment_text' => "Se vencio la resolucion del ticket Nro #".$r->nro_ticket,
                    'comment_status' => 0,
                    'comment_ip' => '0',
                    'assigned_to' =>  3,
                    'created_by' => 1,
                    'modified_by' => $r->id,
                  ];
                  $notickets = Notifications::create($dataticket);
                }

                $service2 = RegisterAtencion::where('id', $r->id)->first();
                $service2->st_fr_due_by = TRUE;
                $service2->save();
              }
            }

            $rol = Main::where('users.id', '=', auth()->user()->id)
              ->where('main.status_user', '=', 'TRUE')
              ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
              ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
              ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
              ->join('users',    'users.id',              '=',   'rol_user.id_user')
              ->select('roles.id')
              ->first();

            if (request()->view != ''){
              $notifi = Notifications::where('id', request()->view)->first();
              $notifi->comment_ip = 1;
              $notifi->save();
            }



            $query  = Notifications::where('comment_status',0)->where('assigned_to',$rol->id)->orderBy('id')->with('getCreateBy')->get();
            $query2 = Notifications::where('status_system',true)->where('assigned_to',$rol->id)->orderBy('id','DESC')->with('getCreateBy')->get();

            $querynumrows = Notifications::where('comment_status',0)->where('assigned_to',$rol->id)->count();
            $querynumrows2 = Notifications::where('status_system',true)->where('assigned_to',$rol->id)->count();

            $output = '';
            $output2 = '';

            if ($querynumrows >= 1){
                  $output  .= $query;
                  $ps = Notifications::where('comment_status',0)->where('assigned_to',$rol->id)->update(['comment_status'=>1]);
            }else{
                  $output .= "";

            }

            if ($querynumrows2 >= 1){
                $output2 .= $query2;
            }else{
                $output2 .= "No hay notificaciones";
            }



            return response()->json([
              'notification'     =>  $output,
              'unseen_notification' => $querynumrows,
              'notification2'     => $output2,
              'unseen_notification2' => $querynumrows2
            ]);

        }

        public function getCategoryDesc(){
          return  Category::where('id', '=', request()->id)->first();
        }

        public function getCategoryForTypes(){
          return  Category::where('id_type_requeriments', '=', request()->id)->get();
        }

        public function searchsubject($id,$key){
          $notifi = Subjects::where('id_groups_tickets','=',$id)->where('description','like','%'.$key.'%')->get();
          $array = array();
          foreach ($notifi as $row) {
            $array[] = $row['description'];
          }
          echo json_encode($array);
        }

        public function PermisosAtencion(){

          $rol = Main::where('users.id', '=', auth()->user()->id)
            ->where('main.status_user', '=', 'TRUE')
            ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
            ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
            ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
            ->join('users',    'users.id',              '=',   'rol_user.id_user')
            ->select('roles.id','rol_user.id as id_roluser')
            ->first();

          $roluser = $rol{'id_roluser'};

          $t = $this->AtencionPermisos();

          $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                        ->select('id_permission')
                        ->get();

          foreach ($permissions as $rs) {
              if ($rol{'id'} == 4){
                 $t->superUsuario = true;
              }else if ($rs->id_permission == 46){
                 $t->viewticketagente = true;
              }else if ($rs->id_permission == 47){
                 $t->viewticketadmin = true;
              }else if ($rs->id_permission == 48){
                 $t->reporte = true;
              }
          }

          $t->rolid = $rol{'id'};

          return $t;
        }

}
