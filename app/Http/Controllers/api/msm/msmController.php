<?php

namespace App\Http\Controllers\api\msm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\MainClass;
use Rap2hpoutre\FastExcel\FastExcel;

class msmController extends Controller
{

  public function msmView()
  {
    $main = new MainClass();
    $main = $main->getMain();
    return view("msm.msm",compact('main'));
  }


  public function redondear($nu)
  {
    if(is_float($nu))
    {
      $var = explode(".",$nu);
      return $var[0]+1;
    }
    return $nu;
  }

  public function enviarMsm()
  {

    //$Number = (new FastExcel)->importSheets(request()->file);
      //
      // $a = [];
      // //partir los mensajes
      // foreach ($Number[0] as $key => $value)
      // {
      //   $mensaje  = $value{'Mensaje'};
      //   $phone = $value{'Phone'};
      //   $s  = $this->splitMsm($mensaje,$phone,0,strlen($mensaje));
      //   array_push($a, $s);
      // }
      //
      //
      // //ordenar la lista
      // $b = [];
      // foreach ($a as $key => $value)
      // {
      //   foreach ($value as $key => $value)
      //   {
      //     array_push($b, $value);
      //   }
      // }
      //
      // $c = $this->enviarMensajePeru($b);
      // //$c = $this->enviarMensajeColombia($b);
      // //$c = $this->enviarMensajeMexico($b);
      // $list = collect($c);
      // return (new FastExcel($list))->download('SistemaMsm'.date("Y-m-d H:i:s").'.xlsx');

  }



  function enviarMensajeMexico($b)
  {
    $c = [];
    foreach ($b as $key => $value)
    {

      $dataCustomer =  array(
        "apiKey" => "186",
        "country" => "MX",
        "dial" => "26262",
        "message" => $value{'MensajeEnviar'},
        "msisdns" => "[".$value{'Phone'}."]",
        "tag" => "tag-prueba"
      );
    $customer_string = json_encode($dataCustomer);
      $ch = curl_init('https://api.broadcastermobile.com/brdcstr-endpoint-web/services/messaging');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: v2UrllCfjhWGvyjQ+S+rc3EnqiE='

  )
);

$result = curl_exec($ch);

$myArray = json_decode($result);

$codigo = $myArray->info;
      $f =
      [
        "Celular"=>$value{'Phone'},
        "Estado"=>$codigo,
        "Fecha"=>date("Y-m-d H:i:s"),
        "mensaje" =>$m,
        "CantidadMensajeEnviar" =>$value{'CantidadMensajeEnviar'}
      ];
      array_push($c, $f);
    }

    return $c;
  }




  function enviarMensajeColombia($b)
  {
    $c = [];
    foreach ($b as $key => $value)
    {
      $m  = str_replace(" ","%20",$value{'MensajeEnviar'});
      $ch = curl_init('https://broadcaster.cm-operations.com/dashboard/broadcasterwebsms/colombia/bin/tu_empresa.php?msisdn='.$value{'Phone'}.'&message='.$m.'&tag=EXAMPLE&idu=5c4f59e833665&user=WINHOLD');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json')
        );

        $result = curl_exec($ch);

        $myArray = json_decode($result);

        $codigo = $myArray->info;
              $f =
              [
                "Celular"=>$value{'Phone'},
                "Estado"=>$codigo,
                "Fecha"=>date("Y-m-d H:i:s"),
                "mensaje" =>$value{'MensajeEnviar'},
                "CantidadMensajeEnviar" =>$value{'CantidadMensajeEnviar'}
              ];
              array_push($c, $f);
    }

    return $c;
  }

  function enviarMensajePeru($b)
  {
    $c = [];
    foreach ($b as $key => $value)
    {

      $m  = $value{'MensajeEnviar'};
      //str_replace(" ","%20",$value{'MensajeEnviar'});
      // $ch = curl_init('https://bcperu.cm-operations.com/dashboard/bin/tu_empresa.php?msisdn='.$value{'Phone'}.'&message='.$m.'&tag=EXAMPLE&idu=5c45f662cf248&user=WINHOLD');
      // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      //     'Content-Type: application/json'));
      // $result = curl_exec($ch);
      // $myArray = json_decode($result);
      // $codigo = $myArray->info;
      $f =
      [
        "Celular"=>$value{'Phone'},
        "Estado"=>"Enviar",
        "Fecha"=>date("Y-m-d H:i:s"),
        "mensaje" =>$value{'MensajeEnviar'},
        "CantidadMensajeEnviar" =>$value{'CantidadMensajeEnviar'}
      ];
      array_push($c, $f);
    }

    return $c;
  }

  public function splitMsm($mensaje,$phone,$contador,$cara)
  {
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

  public function enviarCorreo(){
    $correo = request()->all(){'email'};
    return view('msm.formTotacion',compact('correo'));
  }



}
