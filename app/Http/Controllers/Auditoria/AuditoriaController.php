<?php

namespace App\Http\Controllers\Auditoria;


use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

use App\Models\Auditoria\Auditoria;
use App\Models\General\Rol_User;
use App\Models\General\Rol_Main;
use App\Models\General\Main;
use App\Classes\MainClass;

use Flash;
use Response;

class AuditoriaController extends AppBaseController
{

  /* @funcion: Valida que el usuario tenga permiso en el menu  */
    public function validPermisoMenu()
    {

      $roles = Rol_User::where('id_user', auth()->user()->id)->get();

      foreach ($roles as $key) {
        /* @desc: Rol -> 2 SuperUser , acceso a todos los menu. */
        if($key->id_role == 4){
          return true;
        }
        /* Validamos que el rol contenga el menu disponible */
        else{
          $menu = Rol_Main::where('id_role', $key->id_role)->where('id_main', $id_main)->first();
          if($menu){
            return true;
          }
        }
      }

      return false;

    }

  public function get()
  {
    ini_set('memory_limit','-1');

    $formulario = request()->formulario;

    $data = (new Auditoria)->newQuery();

    if($formulario{'campo_search'})    {
      $data = $data->where('old_values', 'like', '%' . $formulario{'campo_search'} . '%')->orWhere('new_values', 'like', '%' . $formulario{'campo_search'} . '%');
    }

     $data = $data->with('userModified')->get();


   return response()->json([
     'data' => $data,
   ]);
  }

  public function index()
  {
    $main = new MainClass();
    $main = $main->getMain();

    $valor = $this->validPermisoMenu(4);
    if ($valor == false){
      return view('errors.403', compact('main'));
    }
      $auditoria = Auditoria::all();

      return view('auditoria.index')
      ->with('main', $main)
      ->with('auditoria', $auditoria);
  }

  public function create()
  {
    $main = new MainClass();
    $main = $main->getMain();
    return view('errors.403', compact('main'));
  }

  public function store(CreateAuditoriaRequest $request)
  {
    $input = $request->all();

      $auditoria = Auditoria::create($input);

    return redirect(route('auditoria.index'));
  }

  public function show($id)
  {
    $main = new MainClass();
    $main = $main->getMain();
    $valor = $this->validPermisoMenu();
    if ($valor == false){
      return view('errors.403', compact('main'));
    }

      $auditoria = Auditoria::with('userModified')->find($id);

      if (empty($auditoria)) {
          // Flash::error('Office Virtual not found');

          return redirect(route('auditoria.index'));
      }

      return view('auditoria.show')
      ->with('main', $main)
      ->with('auditoria', $auditoria);
  }

  public function edit($id)
  {
    $main = new MainClass();
    $main = $main->getMain();
    return view('errors.403', compact('main'));
  }

}
