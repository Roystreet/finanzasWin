<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\dtCustomerType;
use App\Models\Customer\form;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Red\Red;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketDs;
use App\Models\General\Money;
use App\Models\Product\Product;
use App\Models\Product\Price;
use App\Models\General\Pay;
use App\Models\General\Banks;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\General\City;
use App\Models\GuestPayment\guestPayment;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Ticket\NumberBookSave;
use App\Models\Book\Book;
use Illuminate\Support\Facades\DB;
use App\Classes\MainClass;
use \PDF;
use Auth;
use \stdClass;
use Mail;
use Illuminate\Support\Facades\Validator;
//use App\Mail\ticketCompras;
use App\Models\Product\ProductAction;

class ApiCustomerController extends Controller{



  //actulizar
  //
  public function updateCustomerApi()
  {
    $dni = request()->all(){'document'};
    if(is_numeric($dni))
    {
      if(strlen($dni)==8)
      {

        $cu = new stdClass();
        $cu->document = $dni;
         // $cu->first_name =  $a->first_name;
         // $cu->last_name = $a->last_name;
         // $cu->dni = $dni;
         if(isset(request()->all(){'phone'}))
         $cu->phone = request()->all(){'phone'};
         if(isset(request()->all(){'email'}))
         $cu->email = request()->all(){'email'};
         if(isset(request()->all(){'phone'}))
         $cu->id_country = request()->all(){'phone'};
         if(isset(request()->all(){'id_state'}))
         $cu->id_state = request()->all(){'id_state'};
         if(isset(request()->all(){'id_city'}))
         $cu->id_city = request()->all(){'id_city'};
         if(isset(request()->all(){'address'}))
         $cu->address = request()->all(){'address'};
         return $this->actulizarCustomer($cu);

      }
      else
      {
        return response()->json([
          "resp"   => 'error',
          "org"=>"Perú",
          "message" => "El DNI son caracteres de 8 dígitos",
          "data" =>null
          ]);
      }
    }
    else
    {
      return response()->json([
          "resp"   => 'error',
          "org"=>"Perú",
          "message" => "DNI solo números",
          "data" =>null
        ]);
    }


  }

  public function actulizarCustomer($c)
  {
    if(Customer::where('document', $c->document)->exists())
    {
      $cu = Customer::where('document', $c->document)->first();
      if(isset($c->phone))
      $cu->phone = $c->phone;
      if(isset($c->email))
      $cu->email = $c->email;
      if(isset($c->id_country))
      $cu->id_country = $c->id_country;
      if(isset($c->id_state))
      $cu->id_state = $c->id_state;
      if(isset($c->id_city))
      $cu->id_city = $c->id_city;
      if(isset($c->address))
      $cu->address = $c->address;
      $cu->save();

      return response()->json([
          "resp"   => 'success',
          "org"=>"Perú",
          "message" => "Actulización de datos exitosa."
        ]);
    }
    else
    {
      return response()->json([
          "resp"   => 'error',
          "org"=>"Perú",
          "message" => "No se pudo actulizar. El DNI no Existe."
        ]);
    }
  }


  public function registerDriver()
  {
    try{
      DB::beginTransaction();

        $d =
        [
          "id_customerType"=>1,
          "id_customer"=>request()->id,
          "nota"=>"Registrado por la validación",
          "modified_by" =>1,
          "create_by" =>1
        ];

        dtCustomerType::create($d)->id;
        DB::commit();
        return response()->json([
            "resp"   => 'success',
            "org"=>"Perú",
            "message" => "Conductor registrado."
          ]);
        }catch(\Exception $e)
        {
          DB::rollback();
          return response()->json([
              "resp"   => 'error',
              "org"=>"Perú",
              "message" => $e
            ]);
         }
  }

  public function listDriver()
  {
    return dtCustomerType::where('id_customerType',1)
    ->with('getCustomer')->get();
  }


  //-------------------------registrar accionisytas Externo
  //-------------------------

  public function showCustomerExterno()
  {
    $country        = Country::WHERE ('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
    $pay            = Pay::WHERE     ('status_user', '=', 'TRUE')->orderBy('name_pay',    'ASC')->pluck('name_pay', 'id');
    $customer       = Customer::select(DB::raw("UPPER(CONCAT(document, ' - ', last_name,'  ', first_name)) AS name"), "id")->where('status_system', '=', 'TRUE')->whereIn('status_user', ['1', '6'])->orderBy('name',  'ASC')->pluck( '(last_name||" " ||first_name)as name', 'id');
    $country_invs   = Country::WHERE ('status_user', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');
    $banks          = Banks::WHERE ('status_system', '=', 'TRUE')->pluck('name', 'id');

    return view('customer.registroExterno', compact('country', 'pay', 'customer','products',
    'invited', 'country_invs','banks'));
  }

  public function store(Request $r){
    $id_ticket;

    try{
      DB::beginTransaction();

      //REGISTRO DEL QUIEN INVITA
      $dniExistsInv = Customer::where('document', '=', request()->invitado{'document'})->first();
      $id_invited_by = $dniExistsInv->id;

      //REGISTRO DEL CLIENTE
      $dniExists = Customer::where('document', '=', request()->customer{'document'})->exists();
      if (!$dniExists){
        $customer =
        [
          'first_name'      =>  request()->customer{'first_name'},
          'last_name'       =>  request()->customer{'last_name'},
          'document'             =>  request()->customer{'document'},
          'phone'           =>  request()->customer{'phone'},
          'email'           =>  request()->customer{'email'},
          'id_country'      =>  request()->customer{'id_country'},
          'id_state'        =>  request()->customer{'id_state'},
          'id_city'         =>  request()->customer{'id_city'},
          'address'         =>  request()->customer{'district'},
          'admission_date'  =>  "12-12-12",
          'modified_by'     =>  1,
          'invited_user'    =>  '-',
          'invited_by'      =>  $id_invited_by
        ];
        if($this->validateCustomerDni(request()->customer{'document'}))
        {
          $id_customer = $this->getCustomerDni(request()->customer{'document'})->id;
        }else {
          $id_customer = Customer::create($customer)->id;
        }

      }
      else{
        $pp = Customer::where('document', '=', request()->customer{'document'})->get()[0];
        $id_customer = $pp->id;
        if(request()->invitado{'actulizar'}=="true")
        {
          $pp->invited_by = $id_invited_by;
          $pp->save();
        }
      }
      $ccc = Customer::where('id',$id_customer)->first();

      //Registro de Tickes
      $total = 0;



      $pro = Product::where('id', '=', request()->product{'cod_product'})
      ->with('getProductAction')
      ->first();

      $total = $pro->getProductAction->sale_price;

      $priceee = Price::where('id', request()->product{'id_price'})->first();


      if (request()->pay{'id_pay'} == 2 || request()->pay{'id_pay'} == 9){
          $fecha = date("Y-m-d H:i:s").".0000-05";
      } else {
          $fecha = request()->pay{'date_pay'}." 00:00:00.0000-05";
      }


      $ticket = [
        'cod_ticket'          => $this->getCodeGenerate(request()->codigoPais),
        'id_customer'         => $id_customer,
        'id_invited_by'       => $id_invited_by,
        'id_pay'              => request()->pay{'id_pay'},
        'total'               => $priceee->price,
        'create_by'           => 1,
        'number_operation'    => request()->pay{'nro_ope'},
        'id_banck'            => request()->pay{'banck'},
        'id_country_invert'   => 172,
        'date_pay'            => $fecha,
        'note'                => request()->customer{'note'},
        'donate'              => 0,
        'status_user'         => '1'
      ];
      $id_ticket = Ticket::create($ticket)->id;
        $ticketds = [
          'id_ticket'      =>  $id_ticket,
          'id_product'     =>  $pro->id,
          'cant'           =>  '1',
          'price'          =>  $priceee->price,
          'id_money'       =>  $priceee->id_money,
          'total'          =>  $priceee->price,
          'create_by'      =>  1
        ];

        $id_ticketDs = TicketDs::create($ticketds)->id;
        $respuesta = true;


        //Mail::to($ccc->email)->send(new ticketCompras($ccc));
        DB::commit();
        }catch(\Exception $e){
          DB::rollback();
          dump($e);
          $respuesta = false;
        }

        return response()->json([
            "answer"   => $respuesta,
            "id_ticket" => $id_ticket
          ]);

  }

  public function actualizarticket(Request $r){
    $ticketdeta = Ticket::where('id',request()->ticketdet{'idticket'})
              ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
              ->first();


     $ticket = Ticket::findOrFail(request()->ticketdet{'idticket'});
     $fecha = date("Y-m-d H:i:s").".0000-05";
     $status = request()->ticketdet{'estado'};
     $id_product = $ticket->getTicketDs->id_product;
     $product    = ProductAction::where('id_product', '=', $id_product )->first();

     if ($status == 'success'){
       $numberbooksave = NumberBookSave::where('status_system', '=', 'TRUE')
       ->where('status_user', '=', 'TRUE')
       ->first();

       $TicketCount = Ticket::max('nro_book');

       if ($numberbooksave !== null){
         $updatenumberbook = NumberBookSave::findOrFail($numberbooksave->id);
         $ticket->nro_book = $numberbooksave->number_book;
         $numberbook = $numberbooksave->number_book;
         $updatenumberbook->status_user = false;
         $updatenumberbook->status_system = false;
         $updatenumberbook->save();
       }else{
         $ticket->nro_book    =  $TicketCount +1;
         $numberbook = $TicketCount +1;
       }
       if($product->cant > 0 ){
        $ticket->nro_book = $TicketCount +1;
      }else{
        $ticket->nro_book = null;
      }

         $ticket->status_user = 2;
         $ticket->number_operation = request()->ticketdet{'tokenid'};
         $ticket->date_pay    = $fecha;
         $resp = "exito";
     }else{
        $ticket->status_user = 8;
        $resp = "fallido";
     }
     $ticket->save();

     $booksave = [
       'nro_book' => $numberbook,
       'id_customer' => $ticketdeta->id_customer,
       'cant' => $ticketdeta->getProduct[0]->getProductAction->cant,
       'id_ticket'=>request()->ticketdet{'idticket'},
       'cant_print_book' => 0,
       'created_by' => 1
     ];
     if($ticketdeta->getProduct[0]->getProductAction->cant>0){

       $booksaves = Book::create($booksave);

     }

     return response()->json(["mensaje" => $resp]);
  }

  public function viewcheckout($id){

    $ticket = Ticket::where('id',$id)
              ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
              ->first();

     $monto = $ticket->total;

    if ($ticket->id_pay == 9){
      return view('external.inicio.sales.checkout',compact('monto','ticket','id'));
    }else{
      $cabecera         = $this->getTicket_id($id);
      $pay              = $this->getPay              ($cabecera->id_pay);

      $city             = $this->getCitys   ($ticket->getCustomer->id_city   ) ? $this->getCitys   ($ticket->getCustomer->id_city   )->description : '-';
      $state            = $this->getStates  ($ticket->getCustomer->id_state  ) ? $this->getStates  ($ticket->getCustomer->id_state  )->description : '-';
      $country          = $this->getCountrys($ticket->getCustomer->id_country) ? $this->getCountrys($ticket->getCustomer->id_country)->description : '-';

      $countryinvert    = $this->getCountrys($cabecera->id_country_invert) ? $this->getCountrys($cabecera->id_country_invert)->description : '';
      $detalleprod      = $this->getProduct($ticket->getProduct[0]->id);

      $fechaemi = date("Y-m-d", strtotime($ticket->created_at));

      $a = array("nombre" => $ticket->getCustomer->first_name , "apellido"=> $ticket->getCustomer->last_name , "codticket" => $ticket->cod_ticket, "pay" => $pay->name_pay, "dateemi" => $fechaemi,"document" => $ticket->getCustomer->document);
      $e = array("nombre"    => $ticket->getCustomer->first_name ,
                 "apellido"  => $ticket->getCustomer->last_name ,
                 "codticket" => $ticket->cod_ticket,
                 "pay"       => $pay->name_pay,
                 "dateemi"   => $fechaemi,
                 "document"  => $ticket->getCustomer->document,
                 "phone"     => $ticket->getCustomer->phone,
                 "email"     => $ticket->getCustomer->email,
                 "regis"     => 'Pre-Registro',
                 "observacion"=> $ticket->note);
      $s = $ticket->getCustomer->email;

      Mail::send('external.inicio.sales.sendticket', compact('a'),function($message) use ($s)
      {
        $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
        $message->to($s)->subject('PRE-REGISTRO EXITOSO');
      });
      $f = 'sistemas@winhold.net';
      Mail::send('external.inicio.sales.sendticketfinanza', compact('e'),function($message) use ($f)
      {
        $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
        $message->to($f)->subject('Aviso! Se ha realizado PRE-REGISTRO de compra de producto');
      });
      $ale=true;
      return view('external.inicio.sales.message',compact('ale'));
    }
  }

  public function checkoutpdf($id){

     $ticket = Ticket::where('id',$id)
              ->with('getCustomer','getInvited','getProduct', 'getTicketDs','getModifyBy', 'getMoney','getCountryInv', 'getStatus')
              ->first();

      $monto = $ticket->total;

      $cabecera         = $this->getTicket_id($id);
      $pay              = $this->getPay              ($cabecera->id_pay);

      $city             = $this->getCitys   ($ticket->getCustomer->id_city   ) ? $this->getCitys   ($ticket->getCustomer->id_city   )->description : '-';
      $state            = $this->getStates  ($ticket->getCustomer->id_state  ) ? $this->getStates  ($ticket->getCustomer->id_state  )->description : '-';
      $country          = $this->getCountrys($ticket->getCustomer->id_country) ? $this->getCountrys($ticket->getCustomer->id_country)->description : '-';

      $countryinvert    = $this->getCountrys($cabecera->id_country_invert) ? $this->getCountrys($cabecera->id_country_invert)->description : '';
      $detalleprod      = $this->getProduct($ticket->getProduct[0]->id);

        $fechaemi = date("Y-m-d", strtotime($ticket->created_at));

        $a = array("nombre" => $ticket->getCustomer->first_name , "apellido"=> $ticket->getCustomer->last_name , "codticket" => $ticket->cod_ticket, "pay" => $pay->name_pay, "dateemi" => $fechaemi,"document" => $ticket->getCustomer->document);
        $s = $ticket->getCustomer->email;
        Mail::send('external.inicio.sales.sendticket',compact('a'),function($message) use ($s,$ticket,$country,$state,$city,$cabecera,$pay,$detalleprod,$a)
        {
          $pdf = PDF::loadView('customer.imprimir',compact('a','ticket', 'country', 'state', 'city', 'cabecera', 'pay','detalleprod'));
          $message->from('no-reply@winhold.net','WIN TECNOLOGIES INC S.A.');
          $message->to($s)->subject('Registro exitoso');
          $message->attachData($pdf->output(), $ticket->cod_ticket.".pdf");
        });
        $ale =true;
        return view('external.inicio.sales.message',compact('ale'));
  }







  public function getTicket_id($id){
    return  DB::table('tickets')
     ->where('id', '=', $id)->first();
  }

  public function getPay($id)
  {
    return  DB::table('pays')
     ->where('id', '=', $id)->first();
  }

  public function getCustumer($id)
  {
    return  DB::table('customers')
     ->where('id', '=', $id)->first();
  }

  public function getCitys($id)
  {
    return  DB::table('city')
     ->where('id', '=', $id)->first();
  }

  public function getStates($id)
  {
    return  DB::table('state')
     ->where('id', '=', $id)->first();
  }


  public function getCountrys($id)
  {
    return  DB::table('country')
     ->where('id', '=', $id)->first();
  }

  public function getProduct($id){
     return  DB::table('products')
               ->join('product_actions', 'products.id', '=', 'product_actions.id_product')
               ->join('moneys', 'moneys.id', '=', 'product_actions.id_money')
               ->select('products.cod_product', 'products.id', 'products.description','products.name_product',
               'moneys.id as money','product_actions.cant','product_actions.sale_price')
                ->where('products.id', '=', $id)
               ->get();
   }

  public function getCodeGenerate($r){
     $now = new \DateTime();
     return  "TK-".$r."-".$now->format('d').$now->format('m').$now->format('Y').'-'.$this->getCodigo();
   }

   public function getCodigo(){
     $now = new \DateTime();
     $fecha = $now->format('Y')."-".$now->format('m')."-".$now->format('d');
     $fi = $fecha." 00:00:00";
     $ff = $fecha." 23:59:59";
      return DB::table('tickets')->whereBetween('created_at', [$fi, $ff])->count()+1;
    }

  //obtener cuidades
  public function getState()
  {
    return  DB::table('state')
     ->where('id_country', '=', request()->id)->get();
  }

  public function getCity()
  {
    return  DB::table('city')
     ->where('id_state', '=', request()->id)->get();
  }




    public function validateCustomerDni($dni)
    {
      return $p = Customer::where('document', $dni)
      ->exists();
    }

  public function getCustomer()
  {
    $dni = request()->document;
    if ($this->validateCustomerDni($dni))
    {
       $d = $this->getCustomerDni($dni);

       $in = Ticket::where("id_customer",$d->id)
       ->where("status_user","<>",5)
       ->get();

       if(Customer::where('id', $d->invited_by)->exists())
        $inv = Customer::where('id', $d->invited_by)->first();
        else
        $inv = null;
       return response()->json([
         "objet"=>"success",
         "message"=> "winsystem",
         "data" => $d,
         "inv" => $inv

       ]);
    }else if(request()->type_docum == 2){
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://rest.scrall.cc/v1/reniec/dni",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "TAX",
        CURLOPT_POSTFIELDS =>"{\n    \"dni\": \"$dni\"\n}",
        CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json",
          "Authorization: Basic ZjFmZTg3ZDYtMGRkYi00NGE2LThlZDctZjJjMzk4OTJlNjk5OjllZTA3MmU4LWY5M2ItNDkxOS04MzExLThlNmI1MDg5ODAxMA=="
        ),
      ));

      $response = curl_exec($curl);
      // var_dump($response);
      curl_close($curl);
      $datos = json_decode($response);

      $datis=$datos->result;
      $anio=$datis->feNacimiento;

      $year=strtotime($anio);
      $anionacim = date('Y',$year);
      $anioactual=date('Y');

          if(($anioactual-$anionacim) < 18){
            return Response()->json([
              "objet" => "error",
              "message"=> "Menor de Edad",
              "data"   => null
            ]);
          }else{
            $data = array();
            array_push($data,["preNombres"=>$datis->preNombres,"apePaterno"=>$datis->apePaterno,"apeMaterno"=>$datis->apeMaterno]);

            return Response()->json([
              "objet" => "error",
              "message"=> "registrar",
              "data"   => $data
            ]);

      }
    }
    else
    {
      return response()->json([
        "objet"=>"error",
        "message"=> "winsystem",
        "data" => null
      ]);
    }
  }

  public function validateDNI(Request $r){
     $respuesta =  DB::table('customers')
     ->where('document','=', $r->cod)
     ->exists();

     return response()->json([
         "mensaje"   => $respuesta
       ]);
   }

   public function index()
   {
     return view('external.inicio.inicio');
   }

   public function showCompras()
   {
     $p = $this->listProductsTienda();
     return view('external.inicio.sales.lis-products',['product'=>$p]);
   }

   public function showShopping($id)
   {
     $pri = Price::where('status_user',1)
      ->where('id',$id)->first();
      if(!$pri)
        return "El producto no esta disponible.";
     $pro = Product::where('id',$pri->id_product)
     ->with('getPrice','getProductAction')
     ->first();
     if(!$pro->store)
      return "El producto no esta disponible.";

      $a= new stdClass();
      $a->product = $pro;
      $a->moneda = $this->getMoney($pri->id_money);
      $a->precio = $pri;

      $pay            = Pay::WHERE     ('status_user', '=', 'TRUE')->where('id','=',4)->orWhere('id','=',2)->orWhere('id','=',9)->orWhere('id','=',1)->orderBy('name_pay',    'ASC')->pluck('name_pay', 'id');
      $banks          = Banks::WHERE ('status_system', '=', 'TRUE')->pluck('name', 'id');
      $country = Country::WHERE ('status_system', '=', 'TRUE')->orderBy('description', 'ASC')->pluck('description', 'id');

      return view('external.inicio.sales.registroExterno',["country"=>$country,"product"=>$a, 'pay'=>$pay,'banks'=>$banks]);

   }

   public function listProductsTienda()
   {
     $pri = Price::where('status_user',1)->get();
     $p = [];
     foreach ($pri as $key => $value)
     {

       $pro = Product::where('id',$value->id_product)
       ->with('getPrice','getProductAction')
       ->first();
       if(is_null($pro))
       {
         continue;
       }
       if($pro->store == false)
       {
         continue;
       }
        $a= new stdClass();
        $a->product = $pro;
        $a->moneda = $this->getMoney($value->id_money);
        $a->precio = $value;
        if($value->status_user)
       array_push($p, $a);
     }

     return $p;
   }



   function getMoney($f)
   {
       $b = Money::where("id","=",$f)
       ->first();

     return   $b;
   }
   public function getCustomerDni($dni)
   {
     return $p = Customer::where('document', $dni)
     ->with('getCountry', 'getState', 'getCity')
     ->first();
   }


  public function getCustomerByApi()
  {
    $dni = request()->document;
    if (Customer::where('document', $dni)->exists())
    {
      $d = $this->getCustomerDni($dni);
      return response()->json([
        "objet"=>"success",
        "message"=> "winsystem",
        "data" => $d
      ]);
    } else{

       // $url = 'http://taxiwin.wsdatosperu.com/reniec_dni.php?dni='.$dni;
       // $ch = curl_init($url);
       // $timeout=9;
       // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
       // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       // curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
       // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
       // $result = curl_exec($ch);
       // $a = new stdClass();
       // if ($error_number = curl_errno($ch)) {
       //     if (in_array($error_number, array(CURLE_OPERATION_TIMEDOUT, CURLE_OPERATION_TIMEOUTED))) {
       //         curl_close($ch);
       //         $a->object = false;
       //         $a->first_name = null;
       //         $a->last_name = null;
       //         $a->message = "El DNI ES INVALIDO O ES MENOR DE EDAD";
       //        return $a;
       //      }
       // }
       // $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
       // curl_close( $ch );
       //
       //  $result = [
       //    'result'       => $result,
       //    'status'       => $httpStatus
       //  ];
       return response()->json([
         "objet"=>"error",
         "message"=> "noregistra",

       ]);
    }
  }

  function getAPICustomer(Request $request){
       $validator = Validator::make($request->all(), [
            'document' => 'required'
        ]);

        if ($validator->fails()){
          $errors = $validator->errors();
          return response()->json([
            'object' => 'error',
            'data'   =>  '',
            'message' => 'INGRESE UN NUMERO DE DOCUMENTO'
          ]);
        }else{
          $dni = request()->document;
          if (Customer::WHERE('document', $dni)->exists()){
            $custo = Customer::where('document', $dni)->first();
            return response()->json([
              'object' => 'success',
              'data'   =>  $custo,
              'message' => 'EL NUMERO DE DOCUMENTO ESTA REGISTRADO CORRECTAMENTE'
            ]);
          }else{
            return response()->json([
              'object' => 'error',
              'data'   => '',
              'message' => 'EL NUMERO DE DOCUMENTO NO ESTA REGISTRADO'
            ]);
          }
       }
    }

}
