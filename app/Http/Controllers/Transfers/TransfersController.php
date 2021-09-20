<?php

namespace App\Http\Controllers\Transfers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketDs;
use App\Models\General\Pay;
use App\Models\General\Money;
use App\Models\General\Status;
use App\Models\General\Main;
use App\Models\Customer\Customer;
use App\Models\General\voucherimg;
use App\Classes\MainClass;
use App\Models\Product\Product;
use App\Models\Product\ProductAction;

use App\Models\General\Rol_User;
use App\Models\GuestPayment\guestPayment;

use \PDF;

class TransfersController extends Controller{

  public function __construct(){
		$this->middleware('auth');
    $this->middleware('role');

	}
  public function moveTickets(){
    $main = new MainClass();
    $main = $main->getMain();
    $customer       = Customer::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "id")
                    ->where('status_system', '=', 'TRUE')
                    ->whereIn('status_user', ['1', '6'])->orderBy('name',  'ASC')->pluck( '(last_name||" " ||first_name)as name', 'id');

    return view('transfers.moveTickets', compact('main', 'customer'));
  }



    public function tickectsCustomer(Request $request, $id){
        if ($request->ajax( )){
        $tickets = Ticket::getTicketID($id)->pluck('cod_ticket', 'id');
        return response()->json($tickets);
      }
  	}


  public function updateStatus(){
   if (request()->ajax( )){
     $ticket     = Ticket::findOrFail(request()->id);
     $customer   = Customer::findOrFail($ticket->id_customer);
     $id_product = $ticket->getTicketDs->id_product;
     $product    = ProductAction::where('id_product', '=', $id_product )->first();




     try{
       DB::beginTransaction();
         $TicketCount = Ticket::max('nro_book');

         $ticket->status_user = $product->cant > 0 ?  request()->status : '4' ;
         $ticket->nro_book    = request()->status == 2 && $product->cant > 0 ? $TicketCount +1 : null ;
         $ticket->save();


         $customer->status_user = 6 ;
         $customer->save();

       DB::commit();
     }catch(\Exception $e){  dump($e);  DB::rollback(); }
     $mensaje;
     $mensaje = 'El Ticket N° '.$ticket->cod_ticket.' ha sido actualizado de forma satisfactoria';


     return response()->json([
         "mensaje"       => $mensaje
       ]);
     }
  }

}
