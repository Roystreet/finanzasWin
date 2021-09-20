<?php

namespace App\Http\Controllers\Red;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Classes\MainClass;
use Auth;


class PaymentRedController extends Controller{

  public function __construct(){
		$this->middleware('auth');
    $this->middleware('role');
	}

  public function index(){
    $main = new MainClass();
    $main = $main->getMain();

    return view('red.paymentred', compact('main'));
  }


}
