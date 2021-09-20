<?php

namespace App\Http\Controllers\Red;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Classes\MainClass;
use App\Models\Red\red;

use Auth;


class NetUsersController extends Controller{

  public function __construct(){
		$this->middleware('auth');
    $this->middleware('role');
	}

  public function index(){
    $main = new MainClass();
    $main = $main->getMain();

    return view('red.netusers', compact('main'));
  }
	public function netUsersAjax(){
    if (request()->ajax( )){
			$netusersQuery = red::where('status_system', '=', 'TRUE')
			->orderBy('created_at', 'asc')
			->get();


      $users = [];
      foreach ($netusersQuery as $r) {
        $status  = ($r->status_user === TRUE)? "FALSE" : "TRUE";
        $titleSt = ($r->status_user === TRUE)? 'Activo' : 'Inactivo';
        $iconSt  = ($r->status_user === TRUE)? 'fa-check-square-o' : 'fa-close';
        $action  ='<a data-toggle="modal" data-target="#modal-show" class="btn-modalShow" data-id="'
                  .$r->id.'"><i class="fa fa-eye" title="Ver Usuario"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;'.
                  '<a data-toggle="modal" data-target="#modal-rol" class="btn-modalRol" data-id="'
                  .$r->id.'"><i class="fa fa-cogs" title="Ver Roles"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;'.
                  '<a data-toggle="modal" data-target="#modal-passw" class="btn-modalPass" data-id="'
                  .$r->id.'"><i class="fa fa-key" title="Cambiar Password"></i></a>';
        $user   = [
          'action'       => $action,
          'user'         => $r->user,
          'name'         => $r->id->customer,
					'lastname'     => $r->id->customer,
          'document'          => $r->document,
          'sponsor'      => $r->phone,
          'parent'       => $r->email,
          'status_user'  => '<a status="'.$status.'"  data-id="'.$r->id.'" id="status"><i class="fa '.$iconSt.'" title='.$titleSt.'></i></a>'
        ];
        array_push($users, $user);
      }


      return response()->json([
        'data' => $users,
      ]);
    }
  }


}
