<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Classes\MainClass;


class LoginController extends Controller
{
  public function __construct()
  {
      $this->middleware('guest', ['only' => 'showLoginForm']);
  }

  public function showLoginForm() {
    // Verificamos si hay sesión activa
    if (Auth::check())
    {
        // Si tenemos sesión activa mostrará la página de inicio
        return Redirect::to('/panel');
    }
    // Si no hay sesión activa mostramos el formulario
    return view('auth.welcome');
  }
  public function admin() {
    // Verificamos si hay sesión activa
    if (Auth::check())
    {
        // Si tenemos sesión activa mostrará la página de inicio
        return Redirect::to('/panel');
    }
    // Si no hay sesión activa mostramos el formulario
    return view('layouts.admin');
  }

  public function login(){

    $credentials = $this->validate(request(), [
      'username'    => 'required|string',
      'password'    => 'required|string',
    ],
    [
      'username.required'  => 'Este campo es obligatorio',
      'password.required'  => 'Este campo es obligatorio',
    ]);
    if(Auth::attempt($credentials)){
      if (auth()->user()->status_user == false){
        Auth::logout();
        return back()
        ->withErrors(['datos' => 'Usuario Inactivo'])
        ->withInput(request(['username']));
      }

        return redirect()->route('home');
    }
      return back()
      ->withErrors(['datos' => 'Valide los datos ingresados'])
      ->withInput(request(['username']));

  }
  public function logout() {
    Auth::logout();
    return redirect('/')->with('error_message', 'Session Finalizada');
  }
  public function home()
  {
    $main = new MainClass();
    $main = $main->getMain();
    return view('panel', compact('main'));
  }
}
