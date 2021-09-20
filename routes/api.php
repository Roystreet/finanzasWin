<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/test','api\reniec\reniecController@reniec');
Route::get('/generateExcel', 'api\driver\driverController@getGenerateExcel');



//ingresar customer -----------------------------------------------------------------
Route::get('/denied','api\reniec\reniecController@denied');// no borrar
Route::group(['middleware' => 'keyapi'], function () {
    Route::post('/custumer/peru/get', 'api\reniec\reniecController@customerPeruApi');
    Route::post('/custumer/update', 'Customer\ApiCustomerController@updateCustomerApi');
    Route::post('/freshdesk/support', 'api\freshdesk\freshdeskController@createTicketAPI');
    Route::post('/driver/sendcorreo', 'api\msm\msmController@enviarCorreo');
    //obtener vehículo
    Route::post('/vehicle/peru/get', 'api\MTC\MtcController@getVehiculoApi');

    //obtener la evaluacionFinal
    Route::post('/evaluar/final', 'validate\validateController@evaluacionFinal');

    //rutas para purevas
    Route::get('/inserttype','api\reniec\reniecController@type');


    Route::post('/get/user','api\OficinaVirtual\OffiViController@getOfficine');

    //----------------------------------------------------SAEG
    Route::post('/test/credenciales','api\Saeg\saegController@testGet');
    //----------------------------------------------------SAEG

    //GETACCIONISTAS
    Route::post('/customer/getAPICustomer', 'Customer\ApiCustomerController@getAPICustomer');

    //servicedesk
    Route::put('/reply/servicedesk', 'api\freshdesk\freshdeskController@reply');
});
