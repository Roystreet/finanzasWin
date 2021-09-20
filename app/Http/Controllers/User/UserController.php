<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use App\Models\General\Country;
use App\Models\General\User;
use App\Models\General\Rol_User;
use App\Models\General\Roles;
use App\Models\Views\vw_menu_roles;
use App\Models\General\Rol_permissions;
use App\Models\General\permission;
use App\Models\General\Main;
use App\Classes\MainClass;
use \stdClass;

class UserController extends Controller
{
  public function __construct(){
		$this->middleware('auth');
	}

  public function UserPermisos(){
    $a = new stdClass();

    $a->view = false;
    $a->create = false;
    $a->edit = false;
    $a->delete = false;
    $a->rol = false;
	  $a->password = false;

    return $a;
  }

  public function index(){

    $main = new MainClass();
    $main = $main->getMain();
    $roles = Roles::WHERE('status_system', '=', 'TRUE')->where('status_user', '=', 'TRUE')
                   ->orderBy('description', 'ASC')->pluck('description', 'id');

    $title ='Listado de Usuarios';
    $users = User::where('status_system', '=', 'TRUE')
             ->with('getCountry', 'getModifyBy')
             ->orderBy('created_at', 'asc')
             ->get();

   $permisos = permission::where('status_system', '=', 'TRUE')
            ->pluck('description', 'id');

    $t = $this->PermisosUser();
    $permisover = $t->view;
    $rolid = $t->rolid;

    if ($permisover == true || $rolid == 4){
      return view('user.index',compact('users', 'main', 'title', 'roles','permisos'));
      //return $tickets;
    }else{
      return view('errors.403', compact('main'));
    }

  }

  public function create(){
    $main    = new MainClass();
    $main    = $main->getMain();

    $roles = Roles::WHERE('status_system', '=', 'TRUE')->where('status_user', '=', 'TRUE')
                   ->orderBy('description', 'ASC')->pluck('description', 'id');

    $country = Country::WHERE('status_system', '=', 'TRUE')->where('status_user', '=', 'TRUE')
                ->orderBy('description', 'ASC')->pluck('description', 'id');

    $t = $this->PermisosUser();
    $permisocrear = $t->create;
    $rolid = $t->rolid;

    if ($permisocrear == true || $rolid == 4){
      return view('user.create', compact('main', 'roles', 'country'));
    }else{
      return view('errors.403', compact('main'));
    }
  }

  public function store (){
    try{
      DB::beginTransaction();
      $data =[
        'name'         => request()->first_name,
        'lastname'     => request()->last_name,
        'document'          => request()->document,
        'address'      => request()->address,
        'phone'        => request()->phone,
        'email'        => request()->email,
        'gender'       => request()->gender,
        'birthdate'    => request()->birthdate,
        'username'     => request()->username,
        'password'     => Hash::make(request()->password),
        'id_country'   => request()->cod_country,
      ];

      $id_user = User::create($data)->id;
      $roles   = request()->id_rol;
      foreach ($roles as $r) {
        $userRole =[
          'id_role'         => $r,
          'id_user'        => $id_user,
        ];
        Rol_User::create($userRole);

    }

      DB::commit();
     }catch(\Exception $e){
          DB::rollback();
          dd($e);
      }

   return  redirect()->route('user.create');
  }

  public function usersAll(){
    if (request()->ajax( )){

      $t = $this->PermisosUser();


      $usersQuery = User::where('status_system', '=', 'TRUE')
      ->with('getCountry', 'getModifyBy')
      ->orderBy('created_at', 'asc')
      ->get();
      $users = [];
      foreach ($usersQuery as $r) {
        $status  = ($r->status_user === TRUE)? "FALSE" : "TRUE";
        $titleSt = ($r->status_user === TRUE)? 'Activo' : 'Inactivo';
        $iconSt  = ($r->status_user === TRUE)? 'fa-check-square-o' : 'fa-close';

        $action  = ($t->view == true || $t->rolid == '4') ?
                    '<a data-toggle="modal" data-target="#modal-show" class="btn-modalShow" data-id="'.$r->id.'"><i class="fa fa-eye" title="Ver Usuario"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;' : '';

        $action  .= ($t->rol == true || $t->rolid == '4') ?
                    '<a data-toggle="modal" data-target="#modal-rol" class="btn-modalRol" data-id="'.$r->id.'"><i class="fa fa-cogs" title="Ver Roles"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;' : '';

        $action  .= ($t->view == true || $t->rolid == '4')?
                    '<a data-toggle="modal" data-target="#modal-permisos" class="btn-modalPermisos" data-id="'.$r->id.'"><i class="fa fa-unlock-alt" title="Asignar Permisos"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;' : '';


        $action  .= ($t->password == true || $t->rolid == '4')?
                    '<a data-toggle="modal" data-target="#modal-passw" class="btn-modalPass" data-id="'.$r->id.'"><i class="fa fa-key" title="Cambiar Password"></i></a>' : '';

        $status = ($t->delete == true || $t->rolid == '4')?
                  '<a status="'.$status.'"  data-id="'.$r->id.'" id="status"><i class="fa '.$iconSt.'" title='.$titleSt.'></i></a>' : '';

        $user   = [
          'action'       => $action,
          'username'     => $r->username,
          'name'         => $r->name.' '.$r->lastname,
          'document'          => $r->document,
          'phone'        => $r->phone,
          'email'        => $r->email,
          'id_country'   => $r->getCountry->description,
          'usermodifyby' => $r->getModifyBy->username,
          'status_user'  => $status
        ];
        array_push($users, $user);
      }


      return response()->json([
        'data' => $users,
      ]);
    }
  }

  public function userDetails(){
    if (request()->ajax( )){
        $user = User::where('status_system', '=', 'TRUE')
        ->where('id', '=', request()->id)
        ->with('getCountry', 'getModifyBy', 'getRoles')
        ->orderBy('created_at', 'asc')
        ->first();

        return response()->json([
          'id'   => request()->id,
          'user' => $user,
        ]);
      }
  }

  public function rolDetails(){

    if (request()->ajax( )){

      $rol_user =  Rol_User::where('rol_user.id_user', '=', request()->id)
         ->join('vw_menu_roles', 'vw_menu_roles.id_rol', '=', 'rol_user.id_role')
         ->join('main', 'main.id', '=', 'vw_menu_roles.id')
         ->select('main.description as main', 'vw_menu_roles.ramanombre',
         'vw_menu_roles.id',  'vw_menu_roles.id_rol','vw_menu_roles.descripcion as rol')
         ->get();

      return response()->json([
          "id"       => request()->id,
          "rol_user" => $rol_user
        ]);
      }
  }

  public function PermisosDetails(){

    if (request()->ajax( )){



      $rol = Main::where('users.id', '=', request()->id)
        ->where('main.status_user', '=', 'TRUE')
        ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
        ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
        ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
        ->join('users',    'users.id',              '=',   'rol_user.id_user')
        ->select('roles.id','rol_user.id as id_roluser')
        ->first();

      $roluser = $rol{'id_roluser'};

      $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                    ->select('id_permission')
                    ->get();

      return response()->json([
          "id"       => request()->id,
          "permisos_user" => $permissions,
          "id_roluser" => $roluser
        ]);
      }
  }




  public function rolDetailsSelect(){

    if (request()->ajax( )){
      $rol =  vw_menu_roles::where('id_rol', '=', request()->id)
         ->join('main', 'main.id', '=', 'vw_menu_roles.id')
         ->select('main.description as main', 'vw_menu_roles.ramanombre',
         'vw_menu_roles.id',  'vw_menu_roles.id_rol','vw_menu_roles.descripcion as rol')
         ->get();

      return response()->json([
          "id"       => request()->id,
          "rol" => $rol
        ]);
      }
  }

  public function updateRolUser(){
    if (request()->ajax( )){
      try{
        DB::beginTransaction();

        $roles    = request()->id_rol;
        $id_user  = request()->id_user;

        $rol = Main::where('users.id', '=', $id_user)
          ->where('main.status_user', '=', 'TRUE')
          ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
          ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
          ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
          ->join('users',    'users.id',              '=',   'rol_user.id_user')
          ->select('roles.id','rol_user.id as id_roluser')
          ->first();
        $roluser = $rol{'id_roluser'};

        $permissions = Rol_permissions::where('id_roluser', '=', $roluser);
        $permissions->delete();

        $Rol_User = Rol_User::where('id_user', '=', $id_user);
        $Rol_User->delete();

        foreach ($roles as $r) {
          $userRole =[
            'id_role'        => $r,
            'id_user'        => $id_user,
          ];
          Rol_User::create($userRole);
        }

        DB::commit();
       }catch(\Exception $e){  DB::rollback(); }


      return response()->json([
          "mensaje"       => 'Actualizacion de roles ejecutada de forma satisfactoria',
        ]);
      }
  }

  public function updatePermisoUser(){


        $Permisos = request()->id_permisos;
         $Rol_User  = request()->id_roluserp;
          if(Rol_permissions::where('id_roluser',$Rol_User)->exists())
          {
            $s = Rol_permissions::where('id_roluser',$Rol_User);
            $s->delete();
          }

        foreach ($Permisos as $key => $value) {
          $u= new Rol_permissions();
            $u->id_permission = $value;
            $u->id_roluser = $Rol_User;
            $u->save();
        }


      return response()->json([
          "mensaje"       => 'Actualizacion de permisos ejecutada de forma satisfactoria'
        ]);
      }




  public function validUser(){
    $num = true;
    if (request()->ajax( )){
        $user = User::where('status_system', '=', 'TRUE')
        ->where('username', '=', request()->username)
        ->first();
        if ($user) {$num = false;}
        return response()->json($num);
      }
  }

  public function validUserDni(){
    $num = true;
    if (request()->ajax( )){
        $user = User::where('status_system', '=', 'TRUE')
        ->where('document', '=', request()->document)
        ->first();
        if ($user) {$num = false;}
        return response()->json($num);
      }
  }

  public function updatePassword(){
    if (request()->ajax( )){
      $user = User::findOrFail(request()->id_user);

      try{
        DB::beginTransaction();

          $user->password = Hash::make(request()->password);
          $user->note     = request()->note;
          $user->save();

        DB::commit();
      }catch(\Exception $e){  DB::rollback(); }


      return response()->json([
          "mensaje"       => 'Actualizacion'
        ]);
      }
  }

  public function updateStatus(){
    if (request()->ajax( )){
      $user = User::findOrFail(request()->id);
      try{
        DB::beginTransaction();
          $user->status_user = request()->status;
          $user->save();
        DB::commit();
      }catch(\Exception $e){  DB::rollback(); }
      $mensaje;
      if (request()->status == 'FALSE'){
        $mensaje = 'El usuario '.$user->username.' ha sido desactivado de forma satisfactoria';
      }else{
        $mensaje = 'El usuario '.$user->username.' ha sido activado de forma satisfactoria';
      }

      return response()->json([
          "mensaje"       => $mensaje
        ]);
      }
  }

  //permisosUsers
  public function PermisosUser(){

    $rol = Main::where('users.id', '=', auth()->user()->id)
      ->where('main.status_user', '=', 'TRUE')
      ->join('rol_main', 'main.id',               '=',   'rol_main.id_main')
      ->join('roles',    'roles.id',              '=',   'rol_main.id_role')
      ->join('rol_user', 'rol_user.id_role',      '=',   'roles.id')
      ->join('users',    'users.id',              '=',   'rol_user.id_user')
      ->select('roles.id','rol_user.id as id_roluser')
      ->first();

    $roluser = $rol{'id_roluser'};

    $t = $this->UserPermisos();

    $permissions = Rol_permissions::where('id_roluser', '=', $roluser)
                  ->select('id_permission')
                  ->get();

    foreach ($permissions as $rs) {
      if ($rs->id_permission == 29){
         $t->create = true;
      }else if ($rs->id_permission == 28){
         $t->view = true;
      }else if ($rs->id_permission == 30){
         $t->edit = true;
      }else if ($rs->id_permission == 31){
         $t->delete = true;
      }else if ($rs->id_permission == 32){
         $t->reporte = true;
      }else if ($rs->id_permission == 33){
         $t->rol = true;
      }else if ($rs->id_permission == 34){
         $t->password = true;
      }
    }

    $t->rolid = $rol{'id'};

    return $t;
  }
  public function getRolValid()
  {
    $externo = Rol_User::where('id_user', auth()->user()->id)->where('id_role', 7);
    if (Rol_User::where('id_user', auth()->user()->id)->where('id_role', 7)->exists()){
      return 'true';
    }
    return 'false';
  }

}
