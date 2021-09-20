<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\General\State;
use App\Models\General\City;



class ControllerGeneral extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function getStates(Request $request, $id)
	{
		if ($request->ajax( )){
			$state = State::getStates($id)->pluck('description', 'id');
			return response()->json($state);
		}
	}
	public function getCities(Request $request, $id){
		if ($request->ajax( )){
			$city = City::getCities($id)->pluck('description', 'id');
			return response()->json($city);
		}
	}
	public function getStateHtml($id)
			{
					if (!$id) {
							$html  = '<option value="">'.trans(' Seleccione la provincia donde reside ...').'</option>';
					} else {
							$html  = '<option selected="selected" value="">Seleccione la provincia donde reside ...</option>';
							$datos = State::where('status_user', '=', 'TRUE')->where('id_country', $id)->get();
							foreach ($datos as $dato) {
									$html .= '<option value="'.$dato->id.'">'.$dato->description.'</option>';
							}
					}

					return response()->json(['html' => $html]);
			}

			public function getCityHtml($id)
					{
							if (!$id) {
									$html  = '<option value="">'.trans(' Seleccione la ciudad donde reside ...').'</option>';
							} else {
									$html  = '<option selected="selected" value="">Seleccione la ciudad donde reside ...</option>';
									$datos = City::where('status_user', '=', 'TRUE')->where('id_state', $id)->get();
									foreach ($datos as $dato) {
											$html .= '<option value="'.$dato->id.'">'.$dato->description.'</option>';
									}
							}

							return response()->json(['html' => $html]);
					}
}
