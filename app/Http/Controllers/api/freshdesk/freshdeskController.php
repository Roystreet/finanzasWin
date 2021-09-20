<?php

namespace App\Http\Controllers\api\freshdesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\General\Country;
use Illuminate\Support\Facades\Cache;

class freshdeskController extends Controller
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

    public function createTicket_file(Request $request){

          $api_key = "U2H7YQoww2UJsUykWAwh";
          $password = "";
          $yourdomain = "wintecnologies";
          $request->validate([
              'pais' => 'required',
              'tipo' => 'required',
              'nombre' => 'required',
              'apellido'=>'required',
              'motivo'=>'required',
              'email' => 'required|email',
              'telefono' => 'required',
              'descripcion' => 'required|max:3000',
              'codigo' => 'required',

          ]);

          return response()->json([
            'object'  => "success",
            'key' => $api_key,
            'dominio' => $yourdomain
          ]);
    // Schema::connection('pgconductores')->create('users', function($table)
    // {
    //    $table->increments('id');
    // });

    }


    public function viewTicket(){
      $country = Country::orderBy('description', 'ASC')->pluck('description', 'id');
      return view('external.inicio.bookRecla', compact('country'));
    }

    public function createTicketAPI(Request $r){
      return request()->all;


      // $api_key = "U2H7YQoww2UJsUykWAwh";
      // $password = "x";
      // $yourdomain = "wintecnologies";
      //
      // $name =  $_FILES["myFile"]['name'];
      // $type =  $_FILES["myFile"]['type'];
      // $mimetype = $_FILES["myFile"]['tmp_name'];
      //
      // $ticket_data = json_encode(array(
      //   'email' => request()->email,
      //   'subject' => request()->subject,
      //   'description' => request()->description,
      //   'priority' => 1,
      //   'status' => 2,
      //   'attachments[]' =>  curl_file_create($mimetype, $type, $name),
      //   'type' => request()->tipo,
      //   'source' => 2,
      //   'group_id' => request()->group_id,
      //   'phone' => request()->telefono,
      // ));
      //
      //   $url = "https://$yourdomain.freshdesk.com/api/v2/tickets";
      //   $ch = curl_init($url);
      //   $header[] = "Content-type: application/json";
      //   curl_setopt($ch, CURLOPT_POST, true);
      //   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      //   curl_setopt($ch, CURLOPT_HEADER, true);
      //   curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
      //   curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
      //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //   $server_output = curl_exec($ch);
      //   $info = curl_getinfo($ch);
      //   $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
      //   $headers = substr($server_output, 0, $header_size);
      //   $response = substr($server_output, $header_size);
      //   if($info['http_code'] == 201) {
      //     return response()->json(["message" => "Ticket created successfully",
      //                              "rep" => "success"]);
      //   } else {
      //     if($info['http_code'] == 404) {
      //       return response()->json(["message" => "Error 404, Please check the end point",
      //                                "rep" => "error"]);
      //     } else {
      //       return response()->json(["message" => "Error, HTTP Status Code : " . $info['http_code']."",
      //                                "rep" => "error"]);
      //     }
      //   }
      //   curl_close($ch);
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

      // $id_country=Country::all()->pluck('id','cod');

  //     $pruebatabla=DB::connection('pgconductores')->table('type_requirements')
  //                                                 ->select('id')
  //                                                 ->where('description','=','Solicitud del area')
  //                                                 ->first();
  // dd($pruebatabla);
      $country=Country::all()->pluck('cod','id');
          // $id_country=Country::all()->pluck('id','cod');
// dd($id_country);

      $url = "https://winescompartir.com/";
      return  redirect()->away($url);
      //return view('Reclamaciones.Reclamaciones',compact('country'));

    }

  function index3(){
    $url = "https://winescompartir.com/";
    return  redirect()->away($url);
  }



    function apiFreshdesk(){

      $data=[
        "date_register"        =>  request()->created_at,
      	"subject"              =>  request()->subject,
      	"description"          =>  request()->description_text,
      	"nro_ticket"           =>  request()->id,
      	"due_by"               =>  request()->due_by,
      	"fr_due_by"            =>  request()->fr_due_by,
      	"type_requirements"    =>  request()->type,
      	"id_status_ts"         =>  2,
      	"id_group"             =>  request()->group_id,
      	"id_priorities"        =>  request()->priority,
      	"id_country"           =>  request()->codigo,
        "name"                 =>  request()->name,
        "lastname"             =>  request()->lastname,
        "telefono"             =>  request()->telefono,
        "email"                =>  request()->email,
        "source"               =>  request()->source
      ];
      $string             = json_encode($data);

      $ch = curl_init('https://test.conductores.wintecnologies.com/api/insert/freshdesk');
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'token: sgiII01cK589ysQUv9FP4GY7qPZA42Cq7439Aj9nSEDhWVrRyeKv7eC3NhCt')
          );
      $cQ = curl_exec($ch);
      return response()->json($cQ);
    return  $p  = json_decode($cQ);
   if ($p->object != "error")
   {
         $b = [
               'object'  => "success",
                'data' => $p
               ];
     return response()->json($b);

   }
   else
   {
     $b = [
              'object'  => "error",
               'data' =>$p
              ];
     return response()->json($b);
   }
    }

public function incidencias(){
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

      $value = Cache::rememberForever('js_version_numbers', function () {
       return time();
      });


      return view('Reclamaciones.incidencias',compact('countrys','countrycode','countryid','ctrname'));
    }

    public function incidenciasapp(){
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

      return view('Reclamaciones.incidenciasapp',compact('countrys','countrycode','countryid','ctrname'));
    }

    public function ayuda(){
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


      if ($code == 'PE'){
        $countrys = '43000603562';
        $countryid = '172';
        return view('Reclamaciones.ayuda',compact('countrys','countrycode','countryid','ctrname'));
      }else{
	$url = "https://winescompartir.com/";
        return  redirect()->away($url);
      }

    }


}
