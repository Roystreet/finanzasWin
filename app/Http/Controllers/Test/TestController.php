<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\NumberBookSave;
use App\Models\General\historical;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\External\User_office;
use App\Models\External\file_drivers;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\External\ProcesoValCond;
use App\Models\Book\Book;
use App\Models\Product\Product;
use App\Models\General\permission;
//use App\Models\Book\Book;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use PDF;
use App\Models\Product\ProductAction;
use App\Models\GuestPayment\guestPayment;
use Carbon\Carbon;


class TestController extends Controller
{

  public function customerDNI()
  {
    $customers = DB::table('customers')
    ->select(DB::raw('count(*) as contador'),'dni')
    ->where('status_system',true)
    ->groupBy('dni')
    ->get();
    return $customers;
  }

  public function imprimirCertificados(){
                                        //IMPRIMIR CERTIFICADOS DE MANERA MASIVA

/*
      $ids = Customer::where('id_city', '=' ,  48406)
      ->join('books' , 'books.id_customer' , '=' , 'customers.id')
      ->join('tickets' , 'tickets.id_customer' , '=' , 'books.id_customer')
      ->where('tickets.nro_book', '<>' , null)
      ->where('books.sign_book', '=' , false)
      ->select('tickets.id as id')
      ->orderBy('id','ASC')
      ->distinct()
      ->get();

    $city='Mexico';
    $date='2020-11-05';
    $letras= false;
    $pdf=[];
    $count=0;
    $countsbreak=0;
    $nrobreak=0;
    $totalcertificados = count($ids);

    $totalfor=(int)(($totalcertificados / 10) + 1);

    try{
      DB::beginTransaction();

for ($i=0; $i < $totalfor ; $i++) {
  // code...

  foreach ($ids as $key => $id) {
    // var_dump($id);
    $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
    'Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    $respuesta = true;
    $month = "indefinido";
    $m = date("m", strtotime($date));
    $d = date("d", strtotime($date));
    $y = date("Y", strtotime($date));
    $month = $meses[$m-1];

    $queryT = Ticket::where('status_system', '=', 'TRUE')
    ->where('id', '=', $id->id)
    ->with('getCustomer','getInvited','getModifyBy', 'getTicketDs', 'getProduct',
    'getMoney', 'getCountryInv', 'getPay','getStatus')
    ->first();

    $book = book::where('nro_book',$queryT->nro_book)->first();
    $book->cant_print_book = $book->cant_print_book +1;
    $book->save();
    $payBono = guestPayment::where('id_ticket', '=', $id->id)->exists();
    if($queryT->status_user == '2' || $queryT->status_user == '7'){
      $ticket = Ticket::findOrFail($id->id);
      $ticket->status_user = $payBono ? '4' : '3';
      $ticket->save();
    }
    $product  = $queryT->getProduct ? $queryT->getProduct[0]->id : '-';
    $product  = ProductAction::where('id_product', '=', $product)->first();
    $cantidad = $product->cant;
    if($cantidad == 1||$cantidad == 5 || $cantidad==10 ||$cantidad==20)
    $cantidad = $cantidad*11;
    //colocar producto si es igual a cant 1,5,10,20 para q no lo multiplique
    if(97 == $queryT->getProduct[0]->id ||98 == $queryT->getProduct[0]->id ||99 == $queryT->getProduct[0]->id || 90 == $queryT->getProduct[0]->id || 105 == $queryT->getProduct[0]->id || 116 == $queryT->getProduct[0]->id)
    {
      $cantidad = $product->cant;
    }
    $cantidad = str_pad($cantidad, 2, "0", STR_PAD_LEFT);
    if ($cantidad == 1){
      $valor1=$cantidad*7;     $valor2=$valor1*10;
    }else {
      $valor1=$cantidad*5;     $valor2=$valor1*10;
    }
    // $valor1=$cantidad*11;     $valor2=$valor1*11;
    if(91 == $queryT->getProduct[0]->id || 84 == $queryT->getProduct[0]->id || 88 == $queryT->getProduct[0]->id || 89 == $queryT->getProduct[0]->id
    || 95 == $queryT->getProduct[0]->id || 97 == $queryT->getProduct[0]->id ||98 == $queryT->getProduct[0]->id ||99 == $queryT->getProduct[0]->id)
    {
      $letras =  0;
    }
    else
    {
      $letras = 1;
    }
    $cabecera  = $queryT->getCustomer ? $queryT->getCustomer : '-';
    $fecha     = $queryT->updated_at  ? $queryT->updated_at  : '-';
    $nro       = $queryT->nro_book    ? $queryT->nro_book    : '-';
    $modo_pay  = $queryT->getPay      ? $queryT->getPay->name_pay : '-';
    $namemoney = $queryT->getMoney    ? $queryT->getMoney[0]{'description'} : '-';

    $filename = "quote-0".$count.".pdf";
    $count++;
    $pdf = PDF::loadView('customer.imprimirCertificado', compact('letras','cabecera'
    ,'cantidad', 'nro','fecha','modo_pay','namemoney','city','month','d','y','respuesta','valor1','valor2'));
    $pdf->setPaper('A4', 'landscape')->setWarnings(false);
    $pdf->save('pdfs/'.$filename);

    unset($ids[$key]);
    $countsbreak++;
    if($countsbreak == 10){
        $countsbreak =0;
      break ;
    }

  }
}
DB::commit();
 }catch(\Exception $e){  dump($e);  DB::rollback(); }

  $pdfMerger = PDFMerger::init();
  for ($i=0; $i < $totalcertificados; $i++) {
    // code...
    $pdfMerger->addPDF(public_path('pdfs/quote-0'.$i.'.pdf'), 'all');
  }
  $pdfMerger->merge();
  $pdfMerger->save(public_path('pdfs/quote-all.pdf'), "file");
*/

  }

  public function actualizarTicket($idcustomer,$idticket){
        $ticket  =  Ticket::where('id',$idticket)->first();
        $ticket->id_customer  = $idcustomer;
        return $ticket->save();


  }

  public function deletecustomer($idcustomer){
    $deleCustomer = Customer::where('id', $idcustomer)->first();

      $deleCustomer->status_system = "false";
      $deleCustomer->save();



  }

  public function getTicketbyIdCustomer($id)
  {
    return  DB::table('tickets')
    ->select('id')
    ->where('id_customer', '=', $id)
    ->get();
  }

  public function getHistoricalbyIdCustomerAntes($id){
    return  DB::table('historicals')
    ->select('id')
    ->where('id_customer_ant', '=', $id)
    ->get();
  }


 public function actualizarHistoricalAnt($idcustomer,$id_ticket){
   $historical  =  historical::where('id',$id_ticket)->first();
   $historical->id_customer_ant  = $idcustomer;

   return response()->json([
       "mensaje"   => $historical->save()
     ]);
 }

 public function getHistoricalbyIdCustomerActu($id){
   return  DB::table('historicals')
    ->select('id')
    ->where('id_customer_act', '=', $id)
    ->get();
 }

 public function actualizarHistoricalACT($idcustomer,$id_ticket){
   $historical  =  historical::where('id',$id_ticket)->first();
   $historical->id_customer_act  = $idcustomer;
   $historical->save();

   return response()->json([
       "mensaje"   => 'exito'
     ]);
 }

 public function getGrupCustomerDNI($dni){
   $customersID = DB::table('customers')
   ->select('id')
   ->where('dni','=',$dni)
   ->get();
   return $customersID;
 }


 public function getTicketIDINVITEDBYbyIdCustomer($id)
 {
   return  DB::table('tickets')
   ->select('id')
   ->where('id_invited_by', '=', $id)
   ->get();
 }

 public function actualizarTicketidinvited($idinvited,$idticket){
       $ticket  =  Ticket::findOrFail($idticket);
       $ticket->id_invited_by  = $idinvited;
       $ticket->save();

       return response()->json([
           "mensaje"   => 'exito'
         ]);
 }






  public function CustomerDNIduplicados(){
      $dnidupli = $this->customerDNI();
    $arrayTest = array();

    foreach ($dnidupli as $key => $value)
    {
      if($value->dni != null)
      {
        if($value->contador >= 2)
        {
           $goupIdCustomer =$this->getGrupCustomerDNI($value->dni);//retorna el id de los customer


           foreach ($goupIdCustomer as $key2 => $value2)
           {
              $idCustomerFist = $goupIdCustomer[0]->id;
              $grupoTicketsDniDuplicado = $this->getTicketbyIdCustomer($value2->id);//retorna el id de los tickets
              $grupoHistorialAct = $this->getHistoricalbyIdCustomerActu($value2->id);
              $grupoHistorialAnt = $this->getHistoricalbyIdCustomerAntes($value2->id);
              foreach ($grupoTicketsDniDuplicado as $key3 => $value3)
              {
                if($this->actualizarTicket($idCustomerFist,$value3->id))
                {

                }

                else
                {


                }
              }

              foreach ($grupoHistorialAct as $key4 => $value4)
              {
                $this->actualizarHistoricalACT( $idCustomerFist,$value4->id);
              }
              foreach ($grupoHistorialAnt as $key5 => $value5)
              {
                $this->actualizarHistoricalAnt($idCustomerFist,$value5->id);
              }

           }

        }

      }
    }

    return $arrayTest;




  }
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

  public function exportar()
  {

  // $d =  \Excel::load(public_path().'/data.xls', function($reader) {
  //
  //       // reader methods
  //
  //   })->get();
        $list = collect([
        [ 'id' => 1, 'name' => 'Jane' ],
        [ 'id' => 2, 'name' => 'John' ],
    ]);
//return (new FastExcel($list))->download('file.xlsx');
    $sheets = (new FastExcel)->importSheets('data.xls');
    return 5;
  }


  public function actualizarLicencia()
  {
    $customersID = DB::table('file_drivers')
    ->join('user_offices','file_drivers.id_user_offices','=','user_offices.id')
    ->select('user_offices.dni','file_drivers.id')
    // ->where('file_drivers.id','=','28')
     ->where('file_drivers.licfecemi','=','1969-12-31')
    ->get();

    foreach ($customersID as $key => $value) {
      $licenciaval = file_get_contents('http://18.228.228.200/taxiwin/mtc.php?dni='.$value->dni, true);
      $licenciavals = json_decode($licenciaval);

      if($licenciavals->sucess == "OK")
      {
        $arrayfechaemision = explode(" ", $licenciavals->fechaemision);
        $arrayfechaemision2 = explode("/", $arrayfechaemision[0]);

        $arrayfechaexpedicion = explode(" ", $licenciavals->fecharevalidacion);
        $arrayfechaexpedicion2 = explode("/", $arrayfechaexpedicion[0]);

        $da = file_drivers::where('id',$value->id)->first();
        $da->licfecemi = $arrayfechaemision2[2]."/".$arrayfechaemision2[1]."/".$arrayfechaemision2[0];
        $da->licfecven = $arrayfechaexpedicion2[2]."/".$arrayfechaexpedicion2[1]."/".$arrayfechaexpedicion2[0];

         $da->save();
      }
    }

    $customersID2 = DB::table('file_drivers')
    ->join('user_offices','file_drivers.id_user_offices','=','user_offices.id')
    ->select('file_drivers.placa','file_drivers.id')
    // ->where('file_drivers.id','=','24')
    ->where('file_drivers.soatfecemi','=','1969-12-31')
    ->get();

    foreach ($customersID2 as $key => $value) {
      $valfechseguros = file_get_contents('http://18.228.228.200/taxiwin/soat.php?placa='.$value->placa, true);
      $segurosvals = json_decode($valfechseguros);
      if(!isset($segurosvals->Message))
      {

        $arrayfechaemision2 = explode("/", $segurosvals->FechaInicio);


        $arrayfechaexpedicion2 = explode("/",$segurosvals->FechaFin);

        $da = file_drivers::where('id',$value->id)->first();
        $da->soatfecemi = $arrayfechaemision2[2]."/".$arrayfechaemision2[1]."/".$arrayfechaemision2[0];
        $da->soatfecven = $arrayfechaexpedicion2[2]."/".$arrayfechaexpedicion2[1]."/".$arrayfechaexpedicion2[0];

         $da->save();
      }
    }

    return response()->json([
        "mensaje"   => "ok"
      ]);
  }


 public function excelReportUser()
 {
return   Excel::create('Laravel Excel', function($excel) {
               $excel->sheet('Excel sheet', function($sheet) {
                   //otra opción -> $products = Product::select('name')->get();
                   $products = file_drivers::all();
                   $sheet->fromArray($products);
                   $sheet->setOrientation('landscape');
               });
           })->export('xls');


 }


 public function actulizarRepetidos()
 {
    //80013
     $u = User_office::where('id_office','<>',null)
    ->with('getfile')
    ->get();


    $id_repetidos = [];
    $s = false;
    foreach ($u as $key => $value)
    {
      $arry = [];
      if($value->getfile->id != 0)
      {
        $d = ProcesoValCond::where('id_file_drivers', $value->getfile->id)->get();
        foreach ($d as $key_p => $value_p) {//procesval

          if(in_array($value_p->id_proceso_validacion, $arry ,false))
          {
            array_push($id_repetidos, $value_p->id);
          }else
          {
            array_push($arry,$value_p->id_proceso_validacion);
          }
        }
      }

    }

    foreach ($id_repetidos as $key => $value) {
      ProcesoValCond::where('id', $value)->delete();
    }
    return response()->json([
        "mensaje"   => $id_repetidos
      ]);
}


function actualizarTickets()
   {

     //$t = Ticket::where('status_user','<>','5')->get();
$t = [
2530,
];
     $arr = [];
     foreach ($t as $key => $value) {

       if(true)
       {


	 $numberbooksave = NumberBookSave::where('status_system', '=', 'TRUE')
     ->where('status_user', '=', 'TRUE')
     ->first();

	$TicketCount = Ticket::max('nro_book');

	$tt = Ticket::where('id',$value)->first();
	if ($numberbooksave !== null){
           $updatenumberbook = NumberBookSave::findOrFail($numberbooksave->id);
           $tt->nro_book    =  $numberbooksave->number_book;
           $updatenumberbook->status_user = false;
           $updatenumberbook->status_system = false;
           $updatenumberbook->save();
         }else{
           $tt->nro_book  =  $TicketCount +1;
         }



          $tt->status_user = 4;
          $tt->save();

         array_push($arr,$value);
       }else {
         continue;
       }
     }
return response()->json([
       "mensaje"   => $arr
     ]);
   }

function corregirNumeroBook(){
        //Agregar en books los nro libros que desea agregar en numberBookSave
	//$books=[7083,7167,7191,7243,7355,7379,7419,7435,7447,7462,7473,7573,7680,7696,7750,7787,7809,7874,7876,7887,7895,7902,7904,7911,7933,7934,7911,7944,7952,7974,7977,7989,8004,8005,8050,8073,8075,8100,8143,8193,8210,8215];
	//$books=[7678,8528,8529,8530,8533,8549,8555,8590,8625,8626,8710];
	//$books=[5005,5102,7150,7879,8217,8253,8257,8276,8278,8347,8349];
	//$books=[8735];
	//$books=[8916,8919,8922];
	//foreach($books as $key => $value){

		 //$updatenumberbook = new NumberBookSave();
		 //modificamos el numero de libro que quermos insertar
		 //$updatenumberbook->number_book = $value;
		 //$updatenumberbook->status_user = true;
	         //$updatenumberbook->status_system = true;
	         //Descomentar para que guarde los cambios
	         //$updatenumberbook->save();
	//}

}

 function booksExport()
 {
   set_time_limit(0);
   $t = Ticket::where('status_user','<>',1)->where('status_user','<>',5)
   ->where('id_customer','<>',3616)
   ->with('getTicketDs')
   ->get();
   $arr = [];
   $arrcus = [];
   foreach ($t as $key => $value) {
      $ts = $value{'getTicketDs'};


     if(Book::WHERE('nro_book',$value->nro_book)->exists())
     {
       array_push($arr,$value);
     }else {
        $pro = Product::where('id',$ts->id_product)->with('getProductAction')
       ->first();
       $pa = $pro{'getProductAction'} ;
       $b = new Book();
       $b->nro_book = $value->nro_book;
       $b->id_customer = $value->id_customer;
       $b->nro_acciones = $pa->cant;
       $b->cant_print_book = 0;
       $b->modified_by = 1;
       $b->created_by = 1;
       if(Customer::where('id',$value->id_customer)->exists())
       $b->save();
       else {
         array_push($arrcus,$value);
       }
     }
   }
   return response()->json([
       "ticketsRepedios"   => $arr
     ]);
 }

 function insertarRegistroBook(){
   $insertbook = new Book();
   //modificar el nro de libro
   //$insertbook->nro_book = ;
   //modificar el customer que pertenece
   //$insertbook->id_customer = ;
   //modificar la cantidad de acciones del ticket correspondiente
   //$insertbook->nro_acciones = ;
   //$insertbook->print_book = false;
   $insertbook->cant_print_book = 0;
   $insertbook->sign_book = false;
   $insertbook->file_book = false;
   //$insertbook->modified_by = ;
   $insertbook->created_by = 1;
   // $insertbook->created_at = ;
   // $insertbook->update_at = ;
   $insertbook->status_system = true;
   // $insertbook->note = ;
   //descomentar para guardara cambios lo de abajo
   //$insertbook->save();
 }

 function limpiarNumeros()
 {
   $c =  Customer::all();
   foreach ($c as $key => $value) {
     $cc = Customer::where('id',$value->id)->first();
     $cadena = $cc->phone;
     $resultado = intval(preg_replace('/[^0-9]+/', '', $cadena), 10);

     $cc->phone = $resultado;
     $cc->save();
   }
   return 'completado';
 }


function insertarnro_book()
{
	$b = new Book();
       $b->nro_book = 5947;
       $b->id_customer = 5510;
       $b->nro_acciones = 60;
       $b->cant_print_book = 0;
       $b->modified_by = 1;
       $b->created_by = 1;
$b->save();

}

 function about(){
   return view('external.app.about');
 }

 function faq(){
   return view('external.app.about');
 }

 function termsandconditions(){
   return view('external.app.about');
 }

 function privacity(){
   return view('external.app.about');
 }

 function reportfront(){
   return view('external.app.about');
 }

 function appPassenger(){
   return view('external.app.passenger');
 }

 function appDriver(){
   return view('external.app.driver');
 }





}
