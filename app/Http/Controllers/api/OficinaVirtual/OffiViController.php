<?php

namespace App\Http\Controllers\api\OficinaVirtual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \stdClass;

class OffiViController extends Controller
{
    public function getOfficine()
    {
        $cu = new stdClass();
        $cu->usuario = "mgomez";
        $cu->pass = md5('mypass');
        return response()->json(["object" => "success","data"=>$cu]);
    }

    public function juntageneral(){
      return view('external.accionistas.show', compact(''));
    }
}
