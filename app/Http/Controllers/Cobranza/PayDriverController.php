<?php

namespace App\Http\Controllers\Cobranza;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cobranza\Rides;
use App\Models\Cobranza\Driver_App;
use App\Classes\MainClass;
use App\Models\Cobranza\Order;
use App\Models\Cobranza\Order_ride;

class PayDriverController extends Controller
{
    function getCareerSoutstanding()
    {
      return Rides::where("id_status_pay", "1")->with('getDriver')->get();
    }

    function getCareerPaid()
    {
      return Rides::where("id_status_pay", "2")->with('getDriver')->get();
    }

    function getDriver_id($id)
    {
      return Driver_App::find($id)
      ->with('getCountry')->get();
    }

    function getCareerSoutstanding_id($id)
    {
      $respuesta = null;
      if(Rides::where("id_status_pay", "1")->where("id_driver", $id)->exists())
      {
      $respuesta = Rides::where("id_status_pay", "1")
        ->where("id_driver", $id)
        ->with('getDriver')->get();
      }
      return $respuesta;
    }

    function getCareerPaid_id()
    {
      return Rides::where("id_status_pay", "2")
      //->where("id_drive", "2")
      ->with('getDriver')->get();
    }

    function sumCareer($a)
    {
      $monto = new \stdClass();
      $monto->mto_abono=0;
      $monto->mto_reten=0;
      $monto->total=0;
      foreach ($a as $key => $value)
      {
          $monto->mto_abono+=$value->mto_abono;
          $monto->mto_reten+=$value->mto_ret;
          $monto->total+=$value->total_pay;
      }
      return $monto;
    }

    public function career()
    {
      $career = $this->getCareerSoutstanding_id(request()->idDriver);
      if($career != null)
      {
        $total = $this->sumCareer($career);
        $driver = $career[0]->getDriver;
      }else
      {
        $total = new \stdClass();
        $total->mto_abono=0;
        $total->mto_reten=0;
        $total->total=0;
        $driver = null;
      }


        return response()->json([
          'data'   =>$career,
          'driver' =>$driver,
          'totalAbo'  =>bcdiv($total->mto_abono, '1', 2),
          'totalCareer' => $total->total,
          'totalRet' => $total->mto_reten
      ]);
    }



    public function driverPending()
    {
      $respuesta = new \stdClass();
      $respuesta = Order::where("id", "1")
        ->with('getRides')->get();
        // dump($respuesta->getRides[0]->getDriver->first_name);
        // dump($respuesta->getRides[0]->getStatusRide->name);

      // $respuesta->totales = $this->sumCareer($respuesta->career);
      return response()->json([
        'respuesta'=>$respuesta
    ]);
    }



    public function viewPay($id)
    {
    //$banck = getBanck();
    $main = new MainClass();
    $main = $main->getMain();
      return view('cobranza.payView',compact('main','id'));
    }

    public function viewPayBlock()
    {
      $main = new MainClass();
      $main = $main->getMain();
        return view('cobranza.payBlock',compact('main'));
    }


}
