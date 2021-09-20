<?php

namespace App\Http\Controllers\validate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Driver\Driver;
use \stdClass;

class validateController extends Controller
{
     function pesos()
     {
       $cu =  new stdClass();
       $cu->licencia = 100;
       $cu->vehicle = 100;
       $cu->safe = 100;
       $cu->crimial = 100;
     }


     function evaluarLicencia($s)
     {
       $restar = 100;
       if($s->date_expiration <= date("Y-m-d"))
       {
        return  $restar=-1;
       }
       if($s->nationality == "PE")
       {
         if($s->points <= 30)
         {
           $restar = 0;
         }
         else if($s->points >= 31 && $s->points <= 60)
         {
           $restar = 50;
         }
         else
         {
           $restar = 60;
         }
       }


       return $restar;
     }


     public function evaluacionFinal()
     {
       $d = Driver::where('number_license',request()->number_license)
       ->first();

       $cu =  new stdClass();
       $cu->nationality = $d->getCountry()->first()->nationality;
       $cu->points = $d->points;
       $cu->date_expiration = $d->date_expiration;

       $m =  new stdClass();
       $v = $this->evaluarLicencia($cu);
       if($v == -1)
       {
         $m->message_licencia = "Licencia vencida";
         $m->date_expiration = $d->date_expiration;
         $m->result_eval = -1;
       }
       else if($v==0)
       {
         $m->message_licencia = "Está dentro de los preferencial.";
         $m->result_eval = 0;
       }
       else if($v==50)
       {
         $m->message_licencia = "Está agotando los puntos de licencia.";
         $m->result_eval = 1;
       }
       else if($v==60)
       {
          $m->message_licencia = "Sus puntos de licencia excedieron los límites de nuestras políticas.";
          $m->result_eval = 2;
       }

       else
       {
          $m->message_licencia = "Ocurrio un  error en la validación";
          $m->result_eval = 0;
       }




       return response()->json([
         'object'  => "success",
          'data' =>$m
       ]);


     }


}
