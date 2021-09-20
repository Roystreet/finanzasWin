<?php

namespace App\Http\Controllers\api\Saeg;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Api\Saeg\antecedente;
use App\Models\Api\Saeg\antecedente_detail;
use App\Models\External\User_office;
use \stdClass;
use \PDF;
class saegController extends Controller
{
    //
    public function testGet()
    {
      return response()->json([
        'object'=>"success",
        "menssage" => "conección correcta"
      ]);
    }

    function getDataList()
    {
      $u =  User_office::where("id",'<>',null)->get();
      $b = [];
      foreach ($u as $key => $value) {
         $aa = $value->getAntedente()->get();
         $bb = $value->getSolicitudAntedentesDetalles()->first();
         $canti = count($aa);
          if($canti != 0)
          {
            $cc = 1;
          }else $cc = 0;
          $c =
          [
            "id" => $value->id,
            "dni" => $value->dni,
            "id_office"=> $value->id_office,
            "first_name"=> $value->first_name,
            "last_name"=> $value->last_name,
            "phone"=> $value->phone,
            "email"=> $value->email,
            "antecedentes"=> $cc,
            "status"=>$bb
          ];
          array_push($b, $c);
      }
      return response()->json([
        'object'=>"success",
        "data" =>$b
      ]);
    }

    function insertDataAntecedente()
    {
      $antede = new antecedente();
      $antede->description = "test 2";
      $antede->id_user_offices = 2;
      $antede->save();
      $variable = [1,2];
      foreach ($variable as $key => $value) {
        $a = new antecedente_detail();
        $a->id_antecedente = $antede->id;
        $a->id_type_reference = $value;
        $a->id_type_antecedente = $value;
        $a->crime = "nombree" .$value;
        $a->dependence = "nombree".$value;
        $a->number_office = "nombree".$value;
        $a->date_register = "12-12-12".$value;
        $a->situation = "12-12-12".$value;
        $a->part = "12-12-12".$value;
        $a->observation = "12-12-12".$value;
        $a->save();
      }

    }

    function pdfAntecedentes()
    {
      $u =  antecedente::where("id_user_offices",Request()->id)->get();

      $pdf = PDF::loadView('external.drivers.saeg.reportAntecedentes',compact(
        'u'
      ))->setPaper('a4', 'landscape');
      // $pdf->output();
      // $dom_pdf = $pdf->getDomPDF();
      //
      // $canvas = $dom_pdf->get_canvas();
      // $canvas->page_text(11, 11, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      // $canvas->page_text(522, 770, "Page {PAGE_NUM} / {PAGE_COUNT}", null, 8, array(.5,.5,.5));
      return $pdf->stream('reporteAntecedentes.pdf');
    }

}
