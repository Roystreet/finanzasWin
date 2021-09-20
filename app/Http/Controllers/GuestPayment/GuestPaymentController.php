<?php

namespace App\Http\Controllers\GuestPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GuestPayment\guestPayment;
use App\Models\Ticket\Ticket;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket\TicketDs;
use App\Models\General\voucherimg;
use App\Models\General\Rol_User;
use App\Models\Customer\Customer;
use App\Models\Product\ProductAction;
use App\Models\General\Money;
use App\Models\Product\Product;
use App\Models\Product\Price;
use App\Models\Book\Book;
use Auth;

class GuestPaymentController extends Controller
{
  public function __construct(){
    // $this->middleware('auth');
  }

  public function resgisterGuestPayment(Request $r)
    {

       $id_ticket = $r->id;
      $dt = new \DateTime();
$tt = Ticket::findOrFail($r->id);
      if($r->obser_int != "" || $r->obser_int!=null)
      {

        $tt->obser_int =  $r->obser_int;
        $tt->save();
      }



      if ($r->bono_inv != "" && $r->tip_moneda != null){
        $guestPayment = [
          'fecha'            =>  $dt->format('Y-m-d'),
          'bono_directo'     =>  $r->bono_inv,
          'fecha_cobro'      =>  $r->fec_cob,
          'modo_pago'        =>  $r->mod_pag,
          'tip_moneda'       =>  $r->tip_moneda,
          'observaciones'    =>  $r->obser_inv,
          'note'    =>  $r->obser_int,
          'id_ticket'        =>  $id_ticket,
          'id_user_register' =>  auth()->user()->id,
        ];
        if(!guestPayment::where('id_ticket',$id_ticket)->exists())
        $registropago = guestPayment::create($guestPayment);
        else {
         $gp  = guestPayment::where('id_ticket' ,$id_ticket);
        $gp->delete();
        $registropago = guestPayment::create($guestPayment);
        }
        $t = Ticket::findOrFail($id_ticket);
        $id_product = $t->getTicketDs->id_product;
        $product    = ProductAction::where('id_product', '=', $id_product )->first();
        $t->status_user = $t->status_user == 2 && $product->cant > 0  ? 7 : 4;
        $t->save();
      }

      $idPrice = $r->newproduct;

      if ($idPrice != ""){

        $price = Price::where('id',$idPrice)->first();
        $product = Product::where('id',$price->id_product)->with('getProductAction')->first();
        $money = Money::where('id',$price->id_money)->first();

        $ts = Ticket::findOrFail($id_ticket);
        $ts->total = $price->price;
        $nro_book= $ts->nro_book;
        $ts->save();
        $book = Book::where('nro_book',$nro_book)->first();
        $book->cant = $product->getProductAction->cant;
        $book->save();

        $queryTickedsid = DB::table('ticket_ds')
              ->join('tickets', 'ticket_ds.id_ticket', '=', 'tickets.id')
              ->select('ticket_ds.id as idticketds')
              ->where('ticket_ds.id_ticket','=',$id_ticket)
              ->first();

          $p = TicketDs::findOrFail($queryTickedsid->idticketds);
          $p->id_product = $product->id;
          $p->cant = $product->getProductAction->cant;
          $p->price = $price->price;
          $p->id_money = $money->id;
          $p->total = $price->price;
          $p->save();


      }

      if ($r->newsponsor != ""){
        $dniExists = Customer::where('document', '=', $r->dni_invi)->exists();
        if (!$dniExists){
            $invited = [
              'first_name'      =>  $r->first_name,
              'last_name'       =>  $r->last_name,
              'document'        =>  $r->dni_invi,
              'admission_date'  =>  "12-12-12",
              'modified_by'     =>  auth()->user()->id,
              'invited_user'    =>  '',
              'status_user'     => '6'
            ];
            $id_invited_by = Customer::create($invited)->id;
        }else {
            $id_invited_by = Customer::where('document', '=', $r->dni_invi)->get()[0]->id;
        }

        $tsa = Ticket::findOrFail($id_ticket);
        $tsa->id_invited_by = $id_invited_by;

        $tsa->save();
      }

      if ($r->voucherURL != null){
        $saveimg = [
          'route_img'        =>  $r->voucherURL,
          'type_img'         =>  $r->voucherName,
          'id_ticket'        =>  $id_ticket,
          'id_user_register' =>  auth()->user()->id,
        ];
        $registroIMG = voucherimg::create($saveimg);
      }



      return response()->json([
          "rol"=> "éxito",

      ]);
    }

//guarda la imagen del formulario
    public function imgSave(Request $r)
      {
// $validexist= Ticket::where('id','=',$r->id_ticket);

    $validatexist= voucherimg::where('id_ticket','=',$r->id_ticket)->first();

    if($validatexist != null){
        if ($r->voucherURL != null){

          $saveimg = [
            'route_img'        =>  $r->voucherURL,
            'type_img'         =>  $r->voucherName,
            'modified_by' =>  auth()->user()->id,
          ];
          //  $registroIMG = voucherimg::find($r->id_ticket);
          $validatexist->update($saveimg);
        }
    }else{
            if ($r->voucherURL != null){

              $saveimg = [
                'route_img'        =>  $r->voucherURL,
                'type_img'         =>  $r->voucherName,
                'id_ticket'        =>  $r->id_ticket,
                'modified_by'      =>  1
              ];

              $registroIMG = voucherimg::create($saveimg);

            }
          }


        return response()->json([
            "rol"=> "éxito"
        ]);
      }


    public function imgUpdate(Request $r){

        $id_img = $r->id_img;
        $timg = voucherimg::findOrFail($id_img);
        $timg->route_img = $r->voucherURL;
        $timg->type_img  = $r->voucherName;
        $timg->save();

      return response()->json([
          "rol"=> "éxito",
      ]);
    }


    public function resgisterGuestPaymentAdmin(Request $r){

      $TicketCount = Ticket::max('nro_book');
      $t = Ticket::findOrFail(request()->id);
      $t->status_user = 3;
      // $t->nro_book = $TicketCount + 1;
      $t->save();

      $queryTicket = Ticket::where('id', '=', request()->id)
      ->first();



      return response()->json([
          "rol"=> 'activado'
      ]);
    }



}
