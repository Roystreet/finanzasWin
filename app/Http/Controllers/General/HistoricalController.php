<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\General\historical;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketDs;
use App\Classes\MainClass;
use App\Models\General\Rol_permissions;
use App\Models\General\Main;
use \stdClass;

class HistoricalController extends Controller
{

    public function HistoricalPermisos(){
      $a = new stdClass();

      $a->view = false;

      return $a;
    }

   public function show(){
       $main = new MainClass();
       $main = $main->getMain();

       $tickets = historical::select('id_ticket')->where('status_system', '=', 'TRUE')
       //->orderBy('created_at', 'DESC')
       ->with('getCustomerAnt','getCustomerAct','getTicket','getModifyBy')
       ->distinct()->get();


       $t = $this->PermisosHistorical();
       $permisover = $t->view;
       $rolid = $t->rolid;

       if ($permisover == true || $rolid == 4){
         return view('transfers.historical', compact( 'main'));
         //return $tickets;
       }else{
         return view('errors.403', compact('main'));
       }
   }

   public function historicals(){
     $t = historical::select('id_ticket')
      ->groupBy('id_ticket')
       ->get();

       $p = [];

       foreach ($t as $key => $value) {
         $h = $this->getTicket($value->id_ticket);
         $b =
         [
            "get_ticket" => $h,
            "get_customer_act" => $this->getCustomer($h{'id_customer'})
         ];
         array_push($p,$b);
       }

     return response()->json($p);
   }
   function getCustomer($id)
   {
     return Customer::where('id','=',$id)->first();
   }

   function getTicket($id)
   {
     return Ticket::where('id','=',$id)->first();
   }

   public function historicalsviewid($id){
     $main = new MainClass();
     $main = $main->getMain();

     $tickets = historical::where('id_ticket', '=', $id)
       ->orderBy('created_at', 'DESC')
       ->with('getCustomerAnt','getCustomerAct','getTicket','getModifyBy')
       ->get();

     return view('transfers.historicalview', compact( 'main','tickets'));
     //return $tickets;
   }

   //permisosHistorical
   public function PermisosHistorical(){

     $rol = Main::where('users.id', '=', auth()->user()->id)
       ->where('main.status_user', '=', 'TRUE')
       ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
       ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
       ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
       ->join('users',    'users.id',              '=',   'rol_user.id_user')
       ->select('roles.id','rol_user.id as id_roluser')
       ->first();

     $roluser = $rol{'id_roluser'};

     $t = $this->HistoricalPermisos();

     $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                   ->select('id_permission')
                   ->get();

     foreach ($permissions as $rs) {
         if ($rs->id_permission == 19){
            $t->view = true;
         }
     }

     $t->rolid = $rol{'id'};

     return $t;
   }

}
