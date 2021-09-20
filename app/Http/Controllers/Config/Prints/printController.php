<?php

namespace App\Http\Controllers\Config\Prints;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\MainClass;
use App\Models\Ticket\Ticket;
use App\Models\Product\Product;
use \PDF;
use Rap2hpoutre\FastExcel\FastExcel;

class printController extends Controller
{
    public function printBlock()
    {
      $main = new MainClass();
      $main = $main->getMain();
      return view("print.printBlock",compact('main'));
    }

    public function pdfBlock($obj,$date,$city)
    {
      $sheets = (new FastExcel)->importSheets('C:\Users\Admin\Desktop\Codigos.xlsx');

       $da = explode(",", $obj);
       $array=[];
       $arrayIdTi = [];

       $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
                  'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
       $respuesta = true;
       $month = "indefinido";
       $m = date("m", strtotime($date));
       $d = date("d", strtotime($date));
       $y = date("Y", strtotime($date));
       $month = $meses[$m-1];

       foreach ($sheets[0] as $key => $value)
       {
         $a = $this->getDateCusponer($value);
         $cantidad = $this->getProduct($a->getProduct[0]->id)->getProductAction->cant;
         $cantidad = str_pad($cantidad, 2, "0", STR_PAD_LEFT);
         if ($cantidad == 1){
           $valor1=$cantidad*7;     $valor2=$valor1*10;
         }else {
           $valor1=$cantidad*5;     $valor2=$valor1*10;
         }
        $s = [
          "cliente"=>$a->getCustomer,
          "number_books" => $a->nro_book,
          "cant" =>$cantidad,
          "valor1" => $valor1,
          "valor2" => $valor2
        ];
        array_push($array,$s);
       }
       $data = $array;
       $pdf = PDF::loadView('print.formatPrintBlock',compact('data','city','month','d','y'));
       $pdf->setPaper('A4', 'landscape');
       return $pdf->download('block.pdf');
    }

    public function getProduct($id)
    {
      return $queryT = Product::where('id', '=', $id)
      ->with('getProductAction')
      ->first();
    }

    public function getDateCusponer($id)
    {
      return $queryT = Ticket::where('cod_ticket', '=', $id)
      ->with('getCustomer', 'getTicketDs')
      ->first();
    }

    //-------------------------------enviar MensajeEnviar-------------------------------------------

}
