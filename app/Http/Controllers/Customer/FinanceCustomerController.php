<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\MainClass;
use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Excel;
use App\Models\Red\red;
use \stdClass;
use App\Models\Customer\Customer;


class FinanceCustomerController extends Controller
{

  // public function __construct(){
  //   $this->middleware('auth');
  // }
    public function viewFinanceCustomer()
    {
      // $main = new MainClass();
      // $main = $main->getMain();
      
      return view('customer.financiero');
    }

    function person($id)
   {
     $r = red::where("id","=",$id)->first();
     $p = Customer::find($r->id_customer);
     $person = new stdClass();
     $person->id = $r->id;
     $person->user = $r->user;
     $person->id_sponsor = $r->id_sponsor;
     $person->first_name = $p->first_name;
     $person->last_name = $p->last_name;
     $person->countChildren = red::where("id_parent","=",$r->id)->count();
     $person->countDirect = red::where("id_sponsor","=",$r->id)->count();
     $person->cantidadRed = count($this->codigosRed($r->id,0,10));
     return $person;
   }


//----------------------------------------------------
//----------------------------------------------------
//----------------------------------------------------


    public function codigosRed($id,$nivel,$nivelStop)
    		{

             $Obj = red::where("id_parent",$id)->get();
    		      $a = [];
    		     $nivel++;
    		      foreach ($Obj as $row)
    			 {
    			    array_push($a,$row->id);

    			        if($nivelStop+1 == $nivel)
    			        {

    			        }
    			        else
    			        {
    			            $Obj2 = $this->codigosRed($row->id,$nivel,$nivelStop);
    			            foreach ($Obj2 as $row2)
    			            {
    			                array_push($a,$row2);
    			            }
    			        }
    			 }
    		     return $a;
    		}


//---------------------------------
    //---------------------------------
    //---------------------------------
    //---------------------------------
    //---------------------------------
    public function montoasignar($cantidadT,$cantidadL)
    {
      $valor = 0;
      if($cantidadL!=0)
      {
        $valor = round((($cantidadT)/$cantidadL), 4);
      }
      return $valor;
    }
    public function nodo($id,$nivel,$nivelStop)
		{
        $Obj = red::where("id_parent",$id)->get();
		      $a = [];
		      foreach ($Obj as $row)
			 {
			 $nodo = new stdClass();
		   $text = new stdClass();
			 $id = $row->id;
			 $p = $this->person($id);
			 if($p->first_name == null)
			 {
			     $text->name = "-";
			 }else {
			    $text->name =  $p->user ." - ". (($this->montoasignar(22,$p->cantidadRed)));
			  }
		     $text->title =" El Nivel ".$nivel;
		     $nodo->text = $text;
		     if($p->countChildren!=0)
		     {
		         $n = $nivel+1;
		         if($n == $nivelStop+1)
		         {

		         }else $nodo->children = $this->nodo($p->id,$n,$nivelStop);
		     }else
		     {
		        $nodo->HTMLclass = "first-draw";
		     }

		     array_push($a,$nodo);
			 }

		     return $a;
		}

    public function constructTree($id,$profundidad)
    {
      $p = $this->person($id);
      $arbol = new stdClass();
      $text = new stdClass();
      $name = new stdClass();

      $name->val = $p->countChildren ." - ";
      $name->href = "http://google.com";
      $text->name = $name;
      $arbol->text = $text;
      $arbol->children = $this->nodo($id,1,$profundidad);

      return ($arbol);
    }

    public function tree(Request $r)
    {
      $cod = str_replace(" ", "%20", $r->user);
      $data = json_decode(file_get_contents('https://www.taxiwin.in/Vistas/VistasWin/Conexion/ArbolRed/ArbolRed.php?user='.$cod.'&profundidad='.$r->pro.'&key=1234'), true);
      //$data = $this->constructTree(8,10);
      return response()->json(["mensaje"=>$data]);
    }


    public function reportRedExcel()
    {
      //$now = new \DateTime();
      //   $data = $r;
      //   $d = [];
      //
      //     $c = [
      //           'name' =>"No Hay Datos",
      //           'nivel'=>"No Hay Datos",
      //         ];
      //     array_push($d, $c);
      //
      //
      //   $list = collect($d);

      $list = $this->dataArbol();
          return  (new FastExcel($list))->download('12.xlsx');

    }


}
