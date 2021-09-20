<?php

namespace App\Http\Controllers\api\freshdesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\General\Country;

class freshdeskController2 extends Controller
{

    public function getTicketsbygroup(){
        $api_key = "L9OmkOrBUfNRahkIK";
        $password = "x";
        $yourdomain = "wintecnologies";
        // Return the tickets that are new or opend & assigned to you
        // If you want to fetch all tickets remove the filter query param
        $url = 'https://wintecnologies.freshdesk.com/api/v2/search/tickets?query="group_id:43000447070"';
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
          return json_decode($response,true);
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

    public function getTicketsbyid(){
        $api_key = "L9OmkOrBUfNRahkIK";
        $password = "x";
        $yourdomain = "wintecnologies";
        $ticket_id = 3187;
        // Return the tickets that are new or opend & assigned to you
        // If you want to fetch all tickets remove the filter query param
        $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id";
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
          return json_decode($response,true);
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




    public function agregarrespuesta(){
      $api_key = "L9OmkOrBUfNRahkIK";
      $password = "x";
      $yourdomain = "wintecnologies";

      // Reply will be added to the ticket with the following id
      $ticket_id = 3187;
      $note_payload = array(
        'body' => 'This is a sample reply3333',
        'status' => 3,
      );
      $url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id/reply";
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
      if($info['http_code'] == 201) {
        echo "Note added to the ticket, the response is given below \n";
        echo "Response Headers are \n";
        echo $headers."\n";
        echo "Response Body \n";
        echo "$response \n";
      } else {
          if($info['http_code'] == 404) {
          echo "Error, Please check the end point \n";
        } else {
          echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
          echo "Headers are ".$headers."\n";
          echo "Response is ".$response;
        }
      }
      curl_close($ch);

      return response()->json([
          "data" => 12
      ]);
    }

    public function createTicket_file2(Request $request){

          $api_key = "U2H7YQoww2UJsUykWAwh";
          $password = "";
          $yourdomain = "wintecnologies";
          $request->validate([
              'pais' => 'required',
              'tipo' => 'required',
              'nombre' => 'required',
              'motivo'=>'required',
              'email' => 'required|email',
              'telefono' => 'required|numeric',
              'descripcion' => 'required|max:3000',
              'codigo' => 'required',

          ]);

          return response()->json([
            'object'  => "success",
            'key' => $api_key,
            'dominio' => $yourdomain
          ]);

    }


    public function viewTicket(){
      $country = Country::orderBy('description', 'ASC')->pluck('description', 'id');
      return view('external.inicio.bookRecla', compact('country'));
    }

    public function createTicketAPI(Request $r){

      $api_key = "U2H7YQoww2UJsUykWAwh";
      $password = "x";
      $yourdomain = "wintecnologies";

      $ticket_data = json_encode(array(
      	   'email' => request()->email,
           'subject' => request()->subject,
           'description' => request()->description,
           'priority' => 1,
           'status' => 2,
           'type' => request()->tipo,
           'source' => 2,
           'group_id' => request()->group_id,
           'phone' => request()->telefono,
       ));

           $url = "https://$yourdomain.freshdesk.com/api/v2/tickets";
           $ch = curl_init($url);
           $header[] = "Content-type: application/json";
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
           curl_setopt($ch, CURLOPT_HEADER, true);
           curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
           curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           $server_output = curl_exec($ch);
           $info = curl_getinfo($ch);
           $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
           $headers = substr($server_output, 0, $header_size);
           $response = substr($server_output, $header_size);
           if($info['http_code'] == 201) {
            return response()->json(["message" => "Ticket created successfully", "object" => "success"]);
      	   } else {
             if($info['http_code'] == 404) {
               return response()->json(["message" => "Error 404, Please check the end point", "object" => "error"]);
             } else {
            	return response()->json(["message" => "Error, HTTP Status Code : " . $info['http_code']."", "object" => "error"]);
             }
           }
           curl_close($ch);
    }

    public function getGrupos(){
        $api_key = "U2H7YQoww2UJsUykWAwh";
        $password = "x";

        $url = "https://wintecnologies.freshdesk.com/api/v2/groups";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        return response()->json(["data" => json_decode($response)]);
    }

    public function index(){
      // $c=Country::all();
      // $country=[];
      // foreach ($c  as $key => $value) {
      //  $v = $value->nationality.' +'.$value->cod;
      //  array_push($country,$v);
      // }
      $countrycode = 'PE';
      $countrys = '43000602573';
      $countryid = 172;
      $ctrname = 'PE';

      return view('Reclamaciones.reclamaciones22',compact('countrys','countrycode','countryid','ctrname'));
    }
public function index2(){
      $ip = $_SERVER['REMOTE_ADDR'];
      // o haz la prueba con una IP de Google
      //$ip = '190.235.40.78';

      // Contiene el texto como JSON que retorna geoplugin a partir de la IP
      // Puedes usar un m�todo m�s sofisticado para hacer un llamado a geoplugin
      // usando librerias como UNIREST etc
      $informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

      // Convertir el texto JSON en un array
      $dataSolicitud = json_decode($informacionSolicitud);

      // Ver contenido del array
      $code = $dataSolicitud->geoplugin_countryCode;
      $ctrname = $dataSolicitud->geoplugin_countryName;

      $countryiu = Country::where('nationality','=',$code)->first();
      $countrycode = $countryiu->cod;


      if ($code == 'BO'){
        $countrys = '43000602573';
        $countryid = $countryiu->id;
      }else if ($code == 'CO'){
        $countrys = '43000578275';
        $countryid = $countryiu->id;
      }else if ($code == 'MX'){
        $countrys = '43000603572';
        $countryid = $countryiu->id;
      }else if ($code == 'EC'){
        $countrys = '43000589488';
        $countryid = $countryiu->id;
      }else{
        $countrys = '43000603562';
        $countryid = '172';
      }

      return view('Reclamaciones.reclamaciones2',compact('countrys','countrycode','countryid','ctrname'));
    }

    public function generateURLSignature($action) {
          $url    = 'https://mywinrideshare.com/api/xflow/'.$action;
          $secret = '82*O1Wj9eY#NcAJF29e2UWTMeqMzX%*Lxx';
          $expired = time() + 300;
          $url .= '?expires=' . $expired;
          $signature = hash_hmac('sha256', $url, $secret, false);
          return $url . '&signature=' . $signature;
    }

    public function getByUsernameOV(Request $r)
    {
        $query = $r->value;
        $data  = array("username" => $query);
        $data  = json_encode($data);

        $object  = 'error';
        $mensaje = '';
        $datos   = null;


        $urlComplete  = $this->generateURLSignature('user_get');

        $ch   = curl_init($urlComplete);
               curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
               curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'content-type:application/json',
                'secret: 82*O1Wj9eY#NcAJF29e2UWTMeqMzX%*Lxx'
        ));
        $result         = curl_exec($ch);
        $myArray        = json_decode($result);

        if($myArray->status == '200'){
          $object  = 'success';
          $mensaje = 'USUARIO ENCONTRADO EXITOSAMENTE';

          $datos =[
            'userid'           => $myArray->data->posts->profile->id,
            'username'         => $myArray->data->posts->profile->username,
            'first_name'       => $myArray->data->posts->profile->first_name,
            'last_name'        => $myArray->data->posts->profile->last_name,
            'email'            => $myArray->data->posts->profile->email,
            'phone'            => $myArray->data->posts->profile->public_phone,
            'country'          => $myArray->data->posts->address->country,
            'city'             => $myArray->data->posts->address->city,
            'address'          => $myArray->data->posts->address->address_1,
            'sponsor_username' => $myArray->data->posts->sponsor->username,
            'passenger'        => $myArray->data->posts->details->passenger,
            'driver'           => $myArray->data->posts->details->driver,
            'ambassador'       => $myArray->data->posts->details->ambassador
          ];
          $datos = (object) $datos;
        }
        //INVALID USER NAME
        else if($myArray->status == '460'){
          $mensaje = 'Lo sentimos, este usuario no esta registrado';
        }


        return response()->json([
         'object'    => $object,
         'mensaje'   => $mensaje,
         'datos'     => $datos
        ]);
  }


public function aplicacion($user,$usertype,$country){
      //$ip = $_SERVER['REMOTE_ADDR'];
      // o haz la prueba con una IP de Google
      $ip = '190.235.40.78';

      // Contiene el texto como JSON que retorna geoplugin a partir de la IP
      // Puedes usar un m�todo m�s sofisticado para hacer un llamado a geoplugin
      // usando librerias como UNIREST etc
      $informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

      // Convertir el texto JSON en un array
      $dataSolicitud = json_decode($informacionSolicitud);

      // Ver contenido del array
      $code = $dataSolicitud->geoplugin_countryCode;
      $ctrname = $dataSolicitud->geoplugin_countryName;

      $countryiu = Country::where('nationality','=',$code)->first();
      $countrycode = $countryiu->cod;

      if ($code == 'BO'){
        $countrys = '43000602573';
        $countryid = $countryiu->id;
      }else if ($code == 'CO'){
        $countrys = '43000578275';
        $countryid = $countryiu->id;
      }else if ($code == 'MX'){
        $countrys = '43000603572';
        $countryid = $countryiu->id;
      }else if ($code == 'EC'){
        $countrys = '43000589488';
        $countryid = $countryiu->id;
      }else{
        $countrys = '43000603562';
        $countryid = '172';
      }

      $data  =  array("username" => $user);
      $data  = json_encode($data);
      $urlComplete  = $this->generateURLSignature('user_get');

      $ch   = curl_init($urlComplete);
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'content-type:application/json',
              'secret: 82*O1Wj9eY#NcAJF29e2UWTMeqMzX%*Lxx'
      ));
      $result         = curl_exec($ch);
      $myArray        = json_decode($result);

      if($myArray->status == '200'){
         $userid = $myArray->data->posts->profile->id;
         $username = $myArray->data->posts->profile->username;
         $first_name = $myArray->data->posts->profile->first_name;
         $last_name = $myArray->data->posts->profile->last_name;
         $email = $myArray->data->posts->profile->email;
         $phone = $myArray->data->posts->profile->public_phone;
      }

      return view('Reclamaciones.aplicacion',compact('countrys','countrycode','countryid','ctrname','username','usertype','userid','first_name','last_name','email','phone'));
    }

    function errorapp($user,$usertype,$country){
    //$ip = $_SERVER['REMOTE_ADDR'];
    // o haz la prueba con una IP de Google
    $ip = '190.235.40.78';

    // Contiene el texto como JSON que retorna geoplugin a partir de la IP
    // Puedes usar un m�todo m�s sofisticado para hacer un llamado a geoplugin
    // usando librerias como UNIREST etc
    $informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

    // Convertir el texto JSON en un array
    $dataSolicitud = json_decode($informacionSolicitud);

    // Ver contenido del array
    $code = $dataSolicitud->geoplugin_countryCode;
    $ctrname = $dataSolicitud->geoplugin_countryName;

    $countryiu = Country::where('nationality','=',$code)->first();
    $countrycode = $countryiu->cod;

    if ($code == 'BO'){
      $countrys = '43000602573';
      $countryid = $countryiu->id;
    }else if ($code == 'CO'){
      $countrys = '43000578275';
      $countryid = $countryiu->id;
    }else if ($code == 'MX'){
      $countrys = '43000603572';
      $countryid = $countryiu->id;
    }else if ($code == 'EC'){
      $countrys = '43000589488';
      $countryid = $countryiu->id;
    }else{
      $countrys = '43000603562';
      $countryid = '172';
    }

    $data  =  array("username" => $user);
    $data  = json_encode($data);
    $urlComplete  = $this->generateURLSignature('user_get');

    $ch   = curl_init($urlComplete);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type:application/json',
            'secret: 82*O1Wj9eY#NcAJF29e2UWTMeqMzX%*Lxx'
    ));
    $result         = curl_exec($ch);
    $myArray        = json_decode($result);

    if($myArray->status == '200'){
       $userid = $myArray->data->posts->profile->id;
       $username = $myArray->data->posts->profile->username;
       $first_name = $myArray->data->posts->profile->first_name;
       $last_name = $myArray->data->posts->profile->last_name;
       $email = $myArray->data->posts->profile->email;
       $phone = $myArray->data->posts->profile->public_phone;
    }

    return view('Reclamaciones.aplicacion',compact('countrys','countrycode','countryid','ctrname','username','usertype','userid','first_name','last_name','email','phone'));
  }

  function problemapp($user,$usertype,$country){
    //$ip = $_SERVER['REMOTE_ADDR'];
    // o haz la prueba con una IP de Google
    $ip = '190.235.40.78';

    // Contiene el texto como JSON que retorna geoplugin a partir de la IP
    // Puedes usar un m�todo m�s sofisticado para hacer un llamado a geoplugin
    // usando librerias como UNIREST etc
    $informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

    // Convertir el texto JSON en un array
    $dataSolicitud = json_decode($informacionSolicitud);

    // Ver contenido del array
    $code = $dataSolicitud->geoplugin_countryCode;
    $ctrname = $dataSolicitud->geoplugin_countryName;

    $countryiu = Country::where('nationality','=',$code)->first();
    $countrycode = $countryiu->cod;

    if ($code == 'BO'){
      $countrys = '43000602573';
      $countryid = $countryiu->id;
    }else if ($code == 'CO'){
      $countrys = '43000578275';
      $countryid = $countryiu->id;
    }else if ($code == 'MX'){
      $countrys = '43000603572';
      $countryid = $countryiu->id;
    }else if ($code == 'EC'){
      $countrys = '43000589488';
      $countryid = $countryiu->id;
    }else{
      $countrys = '43000603562';
      $countryid = '172';
    }

    $data  =  array("username" => $user);
    $data  = json_encode($data);
    $urlComplete  = $this->generateURLSignature('user_get');

    $ch   = curl_init($urlComplete);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type:application/json',
            'secret: 82*O1Wj9eY#NcAJF29e2UWTMeqMzX%*Lxx'
    ));
    $result         = curl_exec($ch);
    $myArray        = json_decode($result);

    if($myArray->status == '200'){
       $userid = $myArray->data->posts->profile->id;
       $username = $myArray->data->posts->profile->username;
       $first_name = $myArray->data->posts->profile->first_name;
       $last_name = $myArray->data->posts->profile->last_name;
       $email = $myArray->data->posts->profile->email;
       $phone = $myArray->data->posts->profile->public_phone;
    }

    return view('Reclamaciones.aplicacion',compact('countrys','countrycode','countryid','ctrname','username','usertype','userid','first_name','last_name','email','phone'));
  }

  function inconvenientesapp($user,$usertype,$country){
    //$ip = $_SERVER['REMOTE_ADDR'];
    // o haz la prueba con una IP de Google
    $ip = '190.235.40.78';

    // Contiene el texto como JSON que retorna geoplugin a partir de la IP
    // Puedes usar un m�todo m�s sofisticado para hacer un llamado a geoplugin
    // usando librerias como UNIREST etc
    $informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

    // Convertir el texto JSON en un array
    $dataSolicitud = json_decode($informacionSolicitud);

    // Ver contenido del array
    $code = $dataSolicitud->geoplugin_countryCode;
    $ctrname = $dataSolicitud->geoplugin_countryName;

    $countryiu = Country::where('nationality','=',$code)->first();
    $countrycode = $countryiu->cod;

    if ($code == 'BO'){
      $countrys = '43000602573';
      $countryid = $countryiu->id;
    }else if ($code == 'CO'){
      $countrys = '43000578275';
      $countryid = $countryiu->id;
    }else if ($code == 'MX'){
      $countrys = '43000603572';
      $countryid = $countryiu->id;
    }else if ($code == 'EC'){
      $countrys = '43000589488';
      $countryid = $countryiu->id;
    }else{
      $countrys = '43000603562';
      $countryid = '172';
    }

    $data  =  array("username" => $user);
    $data  = json_encode($data);
    $urlComplete  = $this->generateURLSignature('user_get');

    $ch   = curl_init($urlComplete);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type:application/json',
            'secret: 82*O1Wj9eY#NcAJF29e2UWTMeqMzX%*Lxx'
    ));
    $result         = curl_exec($ch);
    $myArray        = json_decode($result);

    if($myArray->status == '200'){
       $userid = $myArray->data->posts->profile->id;
       $username = $myArray->data->posts->profile->username;
       $first_name = $myArray->data->posts->profile->first_name;
       $last_name = $myArray->data->posts->profile->last_name;
       $email = $myArray->data->posts->profile->email;
       $phone = $myArray->data->posts->profile->public_phone;
    }

    return view('Reclamaciones.aplicacion',compact('countrys','countrycode','countryid','ctrname','username','usertype','userid','first_name','last_name','email','phone'));
  }

  function accidenteapp($user,$usertype,$country){
    // Ver contenido del array
    $code = strtoupper($country);
    $countryiu = Country::where('nationality','=',$code)->first();
    $ctrname = $countryiu->description;
    $countrycode = $countryiu->cod;

    if ($code == 'BO'){
      $countrys = '43000602573';
      $countryid = $countryiu->id;
    }else if ($code == 'CO'){
      $countrys = '43000578275';
      $countryid = $countryiu->id;
    }else if ($code == 'MX'){
      $countrys = '43000603572';
      $countryid = $countryiu->id;
    }else if ($code == 'EC'){
      $countrys = '43000589488';
      $countryid = $countryiu->id;
    }else{
      $countrys = '43000603562';
      $countryid = '172';
    }

    $data  =  array("username" => $user);
    $data  = json_encode($data);
    $urlComplete  = $this->generateURLSignature('user_get');

    $ch   = curl_init($urlComplete);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
           curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'content-type:application/json',
            'secret: 82*O1Wj9eY#NcAJF29e2UWTMeqMzX%*Lxx'
    ));
    $result         = curl_exec($ch);
    $myArray        = json_decode($result);

    if($myArray->status == '200'){
       $userid = $myArray->data->posts->profile->id;
       $username = $myArray->data->posts->profile->username;
       $first_name = $myArray->data->posts->profile->first_name;
       $last_name = $myArray->data->posts->profile->last_name;
       $email = $myArray->data->posts->profile->email;
       $phone = $myArray->data->posts->profile->public_phone;
    }

    return view('Reclamaciones.aplicacion',compact('countrys','countrycode','countryid','ctrname','username','usertype','userid','first_name','last_name','email','phone'));
  }


}
