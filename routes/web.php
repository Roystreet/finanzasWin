<?php
Route::get('/',            'HomeController@index');
Route::get('/acceder',            'Auth\LoginController@showLoginForm');

//------------------------ registrar ticket Externo
	//lista de PRODUCTOS
	Route::get('/productos/acciones', 	  'Customer\ApiCustomerController@showCompras');
	Route::get('/lista/productos/acciones/pruduct', 	  'Customer\ApiCustomerController@listProductsTienda');
	Route::get('/producto/registro-pago/{id}', 	  'Customer\ApiCustomerController@showShopping');
	Route::post('/customer/register/exeterno', 	  'Customer\ApiCustomerController@store');
	Route::get('/checkout/ticket/{id}', 	  'Customer\ApiCustomerController@viewcheckout');
	Route::get('/checkout/ticket/view/{id}', 	  'Customer\ApiCustomerController@checkoutpdf');
	Route::post('/customer/register/exeterno/actualizarti', 	'Customer\ApiCustomerController@actualizarticket');
	Route::post('/send/email/ticket',              'Ticket\TicketController@enviarcorreo');

	//
	Route::post('/customer/getCustomerByApi', 'Customer\ApiCustomerController@getCustomerByApi');
	//

	Route::get('/customer/register/add', 	  'Customer\ApiCustomerController@showCustomerExterno');
	Route::post('/customer/register/get',   'Customer\ApiCustomerController@getCustomer');
	Route::post('/customer/register/getState', 	'Customer\ApiCustomerController@getState');
	Route::post('/customer/register/getCity', 	  'Customer\ApiCustomerController@getCity');
	Route::post('/customer/register/valiteDNI', 	'Customer\ApiCustomerController@validateDNI');
	Route::post('/customer/register/exeterno/keyPrivate', 	'api\Culqi\CulqiController@keyPrivate');
	Route::post('/customer/register/exeterno/order', 	'api\Culqi\CulqiController@order');
	Route::post('/customer/register/exeterno/tarjeta', 	'api\Culqi\CulqiController@pay');



Route::get('/register',     'Customer\ApiCustomerController@registerOrder');
Route::get('/libro-de-reclamaciones',     'api\freshdesk\freshdeskController@viewTicket');
Route::post('/freshdesk/store',     'api\freshdesk\freshdeskController@createTicket');
Route::get('/panel',     'Auth\LoginController@home')->name('home');
Route::post('login',    'Auth\LoginController@login' )->name('login');
Route::post('logout',   'Auth\LoginController@logout')->name('logout');
Route::get('/registro-red',   'HomeController@viewRegistroRed');
Route::post('/red/valiteUsuario',   'Red\RedController@valitedUser');
Route::post('/red/valitedDNI',   'Red\RedController@valitedDNI');
Route::post('/customer/get',   'Customer\CustomerController@getCustomer');
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Reclamaciones
	Route::get('/pqrs', 'api\freshdesk\freshdeskController2@index2');
	Route::get('/incidencias', 'api\freshdesk\freshdeskController@incidencias');
	Route::get('/incidenciasapp', 'api\freshdesk\freshdeskController@incidenciasapp');
	Route::post('/pqrs/crear', 'api\freshdesk\freshdeskController@createTicket_file');
	Route::post('/api/freshdesk', 'api\freshdesk\freshdeskController@apiFreshdesk');
	Route::get('/ayuda', 'api\freshdesk\freshdeskController@ayuda');


  Route::post('/ofvalidate/user', 'api\freshdesk\freshdeskController2@getByUsernameOV');

//Reclamaciones vista oficina virtual
	Route::get('/pqrs2', 'api\freshdesk\freshdeskController2@index2');
	Route::post('/pqrs2/crear', 'api\freshdesk\freshdeskController2@createTicket_file2');

	Route::get('/tickets1', 'api\freshdesk\freshdeskController2@index');

//Reclamaciones
	Route::get('/reclamaciones/register', 'api\freshdesk\freshdeskController@index');
	Route::post('/reclamaciones/create', 'api\freshdesk\freshdeskController@createTicket_file');
	Route::get('/creartickets', 'api\freshdesk\freshdeskController2@index2');
	//Route::get('/creartickets', function(){ return view('mantenimiento'); });
	Route::get('/ticketsmantenimiento', 'api\freshdesk\freshdeskController2@index2');
  Route::get('/ayuda', 'api\freshdesk\freshdeskController@ayuda');


	 Route::get('/driver/externo/rtpdf/{id}', 	'Driver\Externo\ExternalDriverController@checkpdf');
	 //tickets para aplicativo
	 Route::get('/app/{user}/{usertype}/{country}', 'api\freshdesk\freshdeskController2@aplicacion');
	 Route::get('/errorapp/{user}/{usertype}/{country}', 'api\freshdesk\freshdeskController2@errorapp');
	 Route::get('/problema/{user}/{usertype}/{country}', 'api\freshdesk\freshdeskController2@problemapp');
	 Route::get('/inconvenientes/{user}/{usertype}/{country}', 'api\freshdesk\freshdeskController2@inconvenientesapp');
	 Route::get('/accidente/{user}/{usertype}/{country}', 'api\freshdesk\freshdeskController2@accidenteapp');


Route::get('/conductores/oficina',   'Driver\Externo\ExternalDriverController@userOffices');
Route::post('/conductores/oficinaRegister',   'Driver\Externo\ExternalDriverController@userOfficesRegister');

Route::get('/juntageneral', 'api\OficinaVirtual\OffiViController@juntageneral');

Route::group(['middleware' => 'auth'], function(){
//logs Errores
Route::get('oix1278_', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
//Auditoria
	Route::resource('auditoria',                  'Auditoria\AuditoriaController' );
	Route::match(['get', 'post'],'/getAuditoria', 'Auditoria\AuditoriaController@get');

//corregir books buscardni
Route::get('/corregir',  'Test\TestController@corregirNumeroBook');
Route::get('/verlibros',  'Test\TestController@verLibrosHuerfanos');
Route::get('/insertbook',  'Test\TestController@insertarRegistroBook');
//testDB
	Route::get('/test/update/licence',  'Test\TestController@actualizarLicencia');
	Route::get('/test/update/export',  'Test\TestController@excelReportUser');
	Route::get('/test/update/repetidos',  'Test\TestController@actulizarRepetidos');
	Route::get('/test/update/books',  'Test\TestController@booksExport');
		Route::get('/test/customer/update/number',  'Test\TestController@limpiarNumeros');
//Route::get('/test/update/permission',  'Test\TestController@insertPermisos');
	//DRIVER
	Route::get('/drivers/create',         			  					 			   'Driver\ControllerDriver@createDriverView'       );
	Route::post('/customer/register/driver/get',         			  					 			   'Driver\ControllerDriver@getCustomer'       );
	Route::post('/customer/register/driver/store',         			  					 			   'Driver\ControllerDriver@createDriver'       );
	Route::post('/customer/register/driver/get/nationality',         			  					 			   'Driver\ControllerDriver@getnationality'       );
	Route::get('/drivers',         			  					 			   'Driver\ControllerDriver@index'       )->name('driver.index');
	Route::get('/drivers/{driver}', 								 			   'Driver\ControllerDriver@show'        )->name('driver.show' );
	Route::post('/drivers',         								 			   'Driver\ControllerDriver@store'       );
	Route::post('/vehicle',         								 			   'Driver\ControllerDriver@storeVehicle');
	Route::get('/drivers/{driver}/edit',  					 			   'Driver\ControllerDriver@edit'        )->name('driver.edit' );
	Route::put('/drivers/{driver}',       					 			   'Driver\ControllerDriver@update'      );
	Route::get ('/MTCencript',         			             		  'api\MTC\MtcController@index'       );
	Route::post('/apiSoatPlaca',         			             	  'api\MTC\MtcController@apiSoatPlaca');

	Route::get('/conductores',   'Driver\Externo\ExternalDriverController@index');
	Route::get('/conductores/agenda',   'Driver\Externo\ExternalDriverController@schedule');
	Route::get('/conductores/documentos',   'Driver\Externo\ExternalDriverController@docs');
	Route::post('/conductores/documentos/validate/get/dni',   'Driver\Externo\ExternalDriverController@getDNIVaidar');
	Route::post('/conductores/documentos/validate/save/dni',   'Driver\Externo\ExternalDriverController@updateDni');
	Route::get('/conductores/perfil',   'Driver\Externo\ExternalDriverController@perfil');
	Route::get('/conductores/technicalreview',   'Driver\Externo\ExternalDriverController@technicalreview');
	Route::post('/users/exeterno/id/validate', 	'Driver\Externo\ExternalDriverController@getUsersvalidate');
	Route::post('/users/externo/savetechnicalreview', 	'Driver\Externo\ExternalDriverController@storetechnicalreview');

	//USUARIO
	Route::get ('/users',         			             			   'User\UserController@index'           )->name('user.index');
	Route::get ('/user/add',         	               			   'User\UserController@create'          )->name('user.create');
	Route::post('/usernew',         	               			   'User\UserController@store'           );
	Route::match(['get', 'post'],'/usersAll',        			   'User\UserController@usersAll'        );
	Route::match(['get', 'post'],'/userDetails',     			   'User\UserController@userDetails'     );
	Route::match(['get', 'post'],'/user/rolDetails',         'User\UserController@rolDetails'      );
	Route::match(['get', 'post'],'/user/rolDetailsSelect',   'User\UserController@rolDetailsSelect');
	Route::match(['get', 'post'],'/user/updateRolUser',      'User\UserController@updateRolUser'   );
	Route::match(['get', 'post'],'/user/validUser',          'User\UserController@validUser'       );
	Route::match(['get', 'post'],'/user/updatePassword',     'User\UserController@updatePassword'  );
	Route::match(['get', 'post'],'/user/updateStatus',       'User\UserController@updateStatus'    );
	Route::match(['get', 'post'],'/user/validUserDni',       'User\UserController@validUser'       );
	Route::match(['get', 'post'],'/user/PermisosDetails',    'User\UserController@PermisosDetails' );
	Route::match(['get', 'post'],'/user/updatePermisoUser',      'User\UserController@updatePermisoUser'   );
	//PRODUCTOS
	Route::get ('/product',       									 			   'Ticket\ProductController@index')->name('product.index');
	Route::get ('/product/getPrice',       									 			   'Ticket\ProductController@getPrice_id');
	Route::get('/product/list',  								   'Ticket\ProductController@getProducts');
	Route::get('/product/price/insert',  								   'Ticket\ProductController@savePrice');
	Route::get('/product/money',  								   'Ticket\ProductController@getPrice');
	Route::get('/product/money/edit',  								   'Ticket\ProductController@updatePrice');
	Route::get('/product/money/delete',  								   'Ticket\ProductController@deletePrice');
	Route::get('/product/insert',  								   'Ticket\ProductController@saveProduct');
	Route::get ('/ticket/getProductid/{id}',      				   'Ticket\TicketController@getProductid')->name('ticket.getProductid');
	Route::post('/product/money/store',  								   'Ticket\ProductController@store');
	Route::post('/product/img',  								   'Ticket\ProductController@imgsave');
	Route::post('/product/get/img',  								   'Ticket\ProductController@getProduct_id');
	Route::post('/product/money/update',  								   'Ticket\ProductController@updateStusProduct');
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------


	//TICKET
	Route::get('/tickets',                           			  'Ticket\TicketController@index'           )->name('ticket.index'); //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/tickets/getAllTickets',                           			  'Ticket\TicketController@getTicketsAll');
	Route::get('/tickets/myTickets',                 			  'Ticket\TicketController@myTickets'       ); //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/tickets/buscar',                          'Ticket\TicketController@reporte'); //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/tickets/getDataTickets',                   'Ticket\TicketController@getDataTickets'  ); //Correcta: Super Admin - Sistemas - Finanzas

	Route::get('/tickets/activacion',                       'Ticket\TicketController@activacion'      )->name('ticket.index'); //Correcta: Super Admin - Sistemas
	Route::get('/tickets/allTicketsAct',                    'Ticket\TicketController@allTicketsAct'   ); //Correcta: Super Admin - Sistemas
	Route::match(['get', 'post'], '/tickets/updateStatus',  'Ticket\TicketController@updateStatus'    ); //Correcta: Super Admin - Sistemas
	Route::match(['get', 'post'], '/tickets/updatePays',  'Ticket\TicketController@updatePays');
	Route::match(['get', 'post'], '/tickets/saveNumberBook',  'Ticket\TicketController@saveNumberBook'    );

	Route::get('/admin/tickets',                            'Ticket\TicketController@index'           )->name('ticket.index'); //Correcta: Administracion
	Route::get('/atencion/tickets',                         'Ticket\TicketController@index'           )->name('ticket.index'); //Correcta: Soporte

	Route::get('/customers/customersTickets/{id}',          'Ticket\TicketController@getTicketcustomerID');										 //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/atencion/customersTickets/{id}',           'Ticket\TicketController@getTicketcustomerID');										 //Correcta: Soporte
	Route::get('/admin/customersTickets/{id}',              'Ticket\TicketController@getTicketcustomerID');										 //Correcta: Administracion

	Route::get('/customers/ticketDetails',                	'Ticket\TicketController@getTicketDetails');										   //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/admin/ticketDetails',                	    'Ticket\TicketController@getTicketDetails');											 //Correcta: Administracion
	Route::get('/atencion/ticketDetails',                	  'Ticket\TicketController@getTicketDetails');
												 //Correcta: Administracion
											 //Correcta: Soporte

	Route::match(['get', 'post'], '/customers/updateStatus','Ticket\TicketController@updateStatus'    );											 //Correcta: Super Admin - Sistemas
	Route::match(['get', 'post'], '/customers/updatePays','Ticket\TicketController@updatePays'    );
	Route::match(['get', 'post'], '/customers/saveNumberBook','Ticket\TicketController@saveNumberBook');
	Route::get('/customers/printCertificado/{city}/{id}/{date}/{letras}',          'Ticket\TicketController@getImprimirCertIDTicket');                //Correcta: Super Admin - Sistemas
	Route::get('/admin/printCertificado/{city}/{id}/{date}/{letras}',              'Ticket\TicketController@getImprimirCertIDTicket');
Route::get('/certificados',              'Test\TestController@imprimirCertificados');
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------


	//TICKET
	Route::get('/transf/moveTickets',               			   'Transfers\TransfersController@moveTickets'); //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/transf/tickectsCustomer/{id}',							 'Transfers\TransfersController@tickectsCustomer'    );
											 //Correcta: Super Admin - Sistemas
	Route::get('/ticket/list',							 'Ticket\TicketController@indexEdit' );
	Route::get('/ticket/getTickets',							 'Ticket\TicketController@getTicketAll' );
	Route::get('/ticket/edit',							 'Ticket\TicketController@updateTicket_id' );
	Route::get('/ticket/editarTicket/{id}',							 'Ticket\TicketController@show' );
	Route::post('/ticket/editarTicket/editar/{id}',							 'Ticket\TicketController@editar' );
	Route::post('/ticket/editarTicket/product',							 'Ticket\TicketController@cambiarproduct' );
	Route::MATCH(['get', 'post'], '/state/{id}', 'General\ControllerGeneral@getStateHtml');
	Route::MATCH(['get', 'post'], '/city/{id}', 'General\ControllerGeneral@getCityHtml');
	Route::get('/ticket/editar/{id}',							 'Ticket\TicketController@viewEdidticket' );
	Route::get('/ticket/getTicket',							 'Ticket\TicketController@getTicket_id' );
	Route::get('/ticket/getCustomer',							 'Ticket\TicketController@getCustomer_id' );
	Route::post('/ticket/getCustomer/country',							 'Ticket\TicketController@getCodiCountry' );
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------
	//Cobranza
	//OrderPay
	Route::get('/cobranza/doOrderPay',               			   'Cobranza\OrderPayController@doOrderPay'); //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/cobranza/getridesByOrderPay',               'Cobranza\OrderPayController@getridesByOrderPay');//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/cobranza/orders', 					 			           'Cobranza\OrderPayController@index'             )->name('order.show' );
	Route::get('/cobranza/getOrders',                        'Cobranza\OrderPayController@getOrders'         );//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/cobranza/orderView/{id}', 								   'Cobranza\OrderPayController@show'              )->name('order.show' );
	Route::match(['get', 'post'],'/cobranza/generandoOrder',                  'Cobranza\OrderPayController@generandoOrder'   );//Correcta: Super Admin - Sistemas - Finanzas
	//-----------------------------------------------------------------------------------------------------------------------------------------------------------
	//Cobranza
	//OrderPay
	Route::get('/capitalDriver/index',                         'CapitalDriver\CapitalDriverController@index'      );//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/indexApp',                      'CapitalDriver\CapitalDriverController@indexApp'      );//Correcta: Super Admin - Sistemas - Finanzas

	Route::get('/capitalDriver/recargarLote',                  'CapitalDriver\CapitalDriverController@indexLote'  );//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/pendients',                     'CapitalDriver\CapitalDriverController@indexPendients'  );//Correcta: Super Admin - Sistemas - Finanzas

	Route::get('/capitalDriver/edit',                          'CapitalDriver\CapitalDriverController@edit'  );//Correcta: Super Admin - Sistemas - Finanzas
	Route::match(['get', 'post'], '/capitalDriver/updateRecarga','CapitalDriver\CapitalDriverController@updateRecarga');//Correcta: Super Admin - Sistemas

	Route::get('/capitalDriver/create',                         'CapitalDriver\CapitalDriverController@create'     )->name('capitaldriver.create');//Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/getDriver',                      'CapitalDriver\CapitalDriverController@getDriver'  );//Correcta: Super Admin - Sistemas - Finanzas
	Route::post('/capitalDriver/addSaldo',          			      'CapitalDriver\CapitalDriverController@addSaldo'   );
	Route::get('/capitalDriver/getRecargas',                    'CapitalDriver\CapitalDriverController@getRecargas');      //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/capitalDriver/getRecargasApp',                 'CapitalDriver\CapitalDriverController@getRecargasApp');      //Correcta: Super Admin - Sistemas - Finanzas

	Route::match(['get', 'post'], '/capitalDriver/updateStatus','CapitalDriver\CapitalDriverController@updateStatus');//Correcta: Super Admin - Sistemas
	Route::match(['get', 'post'],'/capitalDriver/recargando',   'CapitalDriver\CapitalDriverController@recargando'   );//Correcta: Super Admin - Sistemas - Finanzas

	Route::post('/capitalDriver/validaNumber',          'CapitalDriver\CapitalDriverController@validaNumber'   );
	Route::post('/capitalDriver/validaDni',            	'CapitalDriver\CapitalDriverController@validaDni'   );

	//-----------------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------driver pay
	Route::get('/cobranza/pay/{id}','Cobranza\PayDriverController@viewPay');
	Route::post('/cobranza/career','Cobranza\PayDriverController@career');
	Route::post('/cobranza/cereer/save','Cobranza\PayDriverController@saveOrder');

	Route::get('/cobranza/pay','Cobranza\PayDriverController@viewPayBlock');
	Route::post('/cobranza/career/blocks','Cobranza\PayDriverController@driverPending');
	//----------------------------------------------------------------------------------

	//CUSTOMER
	Route::post ('/tabla/customer', 										      'Customer\CustomerController@getCustomers' );
	Route::get ('/customers', 										          'Customer\CustomerController@index' );     //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/admin/customers', 						              'Customer\CustomerController@index' )->name('customers');			     //Correcta: Administracion
	Route::get('/atencion/customers', 						          'Customer\CustomerController@index' )->name('customers');          //Correcta: Soporte

	Route::get('/customers/edit/{customer}', 				        'Customer\CustomerController@edit' )->name('customer.edit');       //Correcta: Super Admin - Sistemas - Finanzas
	Route::post('/customers/edit',       					 	  'Customer\CustomerController@update');													   //Correcta: Super Admin - Sistemas - Finanzas
	Route::match(['get', 'post'],'/customers/validUserDni', 'Customer\CustomerController@validateDNI');												 //Correcta: Super Admin - Sistemas - Finanzas


	Route::get('/customers/{id}',       					          'Customer\CustomerController@show'  );   //Correcta: Super Admin - Sistemas - Finanzas
	//Route::get('/admin/customers/{id}',                     'Customer\CustomerController@show'  )->name('customerAd.show' );   //Correcta: Administracion
	//Route::get('/atencion/customers/{id}',       	          'Customer\CustomerController@show'  )->name('customerAt.show' );   //Correcta: Soporte

	Route::get ('/tickets/pdf/{id}', 						 	          'Customer\CustomerController@pdf'  )->name('ticket');	             //Correcta Super Admin - Sistemas - Finanzas
	Route::get ('/admin/pdf/{id}', 						 	            'Customer\CustomerController@pdf'  )->name('admin.ticket');	       //Correcta: Administracion
	Route::get ('/atencion/pdf/{id}', 						 	        'Customer\CustomerController@pdf'  )->name('atencion.ticket');     //Correcta: Soporte
	Route::get('/tickets/getTicketforID',                	  'Customer\CustomerController@getTicketforID');
	Route::get('/admin/getTicketforID',                	    'Customer\CustomerController@getTicketforID');
	Route::get('/atencion/getTicketforID',                	'Customer\CustomerController@getTicketforID');
	Route::get('/customers/pdfTicket/{id}',                 'Ticket\TicketController@pdfTicket');
	Route::get('/customer/new',                 						'Customer\CustomerController@createshow');
	Route::POST('/customer/savecustomer',                 	'Customer\CustomerController@customerstore');
	Route::POST('/customer/transferir/',                 		'Ticket\TicketController@customerTransferir');

	Route::POST('/customer/saveDniFile',                 		'Customer\CustomerController@saveDniFile');


	Route::get('/customers/customersbooks/{id}',          'Customer\CustomerController@getbookscustomerID');										 //Correcta: Super Admin - Sistemas - Finanzas
	Route::get('/atencion/customersbooks/{id}',           'Customer\CustomerController@getbookscustomerID');										 //Correcta: Soporte
	Route::get('/admin/customersbooks/{id}',              'Customer\CustomerController@getbookscustomerID');									 //Correcta: Administracion
	Route::post('/books/coments',              'Ticket\TicketController@updateNota');
	Route::post('/books/get',              'Ticket\TicketController@getBook');

	Route::post('/file/save',              'Ticket\TicketController@saveFile');
	Route::post('/file/get',              'Ticket\TicketController@getFile');
	Route::match(['get', 'post'], '/customers/updateBooks',  'Customer\CustomerController@UpdateBook');

	//-----------------------------------------------------------------------------------------------------------------------------------------------------------

	//RED
	Route::get ('/net/users', 										          'Red\NetUsersController@index' );     //Correcta: Super Admin - Sistemas - Finanzas
	Route::match(['get', 'post'],'/net/UsersAjax',    		  'Red\NetUsersController@netUsersAjax');

	//-----------------------------------------------------------------------------------------------------------------------------------------------------------


	//VALIDAR
	Route::get ('/productos',       				  				'Ticket\ProductController@getProductos');
	Route::post ('/accionar/productos',       				  				'Ticket\ProductController@getProductoss');
	Route::post ('/accionar/producto/estatus',       				  				'Ticket\ProductController@updateStatusProducto');
	Route::post ('/tickets/products',       				  				'Ticket\ProductController@listProductos');
	Route::post ('/tickets/products/activarDesactivar',       'Ticket\ProductController@activarDesactivarProductos');
	Route::get('/ticket/viewVoucher/{id}',                  'Ticket\TicketController@viewVoucherIDt')->name('ticket.viewVoucherIDt');

	Route::post('/customer/store', 					 		            'Customer\CustomerController@store');
	Route::get ('/customer/add',                            'Customer\CustomerController@create')->name('customer.create');
	Route::post('/customer/valiteOperation', 			          'Customer\CustomerController@valiDateCodePay');
	Route::post('/customer/valiteDNI', 						          'Customer\CustomerController@validateDNI');
	Route::get('/customer/valiteDocumento', 						    'Customer\CustomerController@valiteDocumento');
	Route::post('/customer/externo/reniecPeruValidate',     'api\reniec\reniecController@reniecPeruValidate');

	//INVITADO
  Route::post('/ticketActivation',      'GuestPayment\GuestPaymentController@resgisterGuestPayment');
	Route::post('/ticketActivationAdmin', 'GuestPayment\GuestPaymentController@resgisterGuestPaymentAdmin');
	Route::post('/tickets/imgUpdate',     'GuestPayment\GuestPaymentController@imgUpdate');



	//config imprimir
	Route::get ('/customers/imprimir/block',  'config\prints\printController@printBlock');
	Route::get ('/customers/print/blocks/{obj}/{date}/{city}',  'config\prints\printController@pdfBlock');
	//fin de imprimir reportes


	//Reportes
	// ---------------------------------------------------------------------------------- Inicio de Reportes
	//report acciones de accionistas
	Route::get ('/reporte/reporteAccionistas','Report\ReportController@reportAcciones');
	Route::post('/reporte/totalAcciones','Report\ReportController@getListAccionistas');
	//reporte ventas winIstoShare // Win ventas
	//--vista reporte
	Route::get('/report/reportView','Report\ReportController@reportView');
	//Execel
	Route::get('/report/orderWinIsToShareExcel','Report\ReportController@orderWinIsToShareExcel');
	//--vista register Ticket
	Route::post('/report/customerRedTaxiWin','Report\ReportController@getRedTaxiWin');
	Route::post('/report/customerWinIstoShareAndTaxiWin','Report\ReportController@customerWinIstoShareAndTaxiWin');

	//reporte ventas taxiwin // Win ventas --vista reporte
	Route::post('/report/customerTaxiwin','Report\ReportController@customerTaxiwin');
	//reporte ventas winistoshare // Win isto share --vista reporte
	Route::post('/report/customerWinistoshare','Report\ReportController@customerWinistoshare');

	// ---------------------------------------------------------------------------------- fin de  Reportes
	Route::get('/report/finanzas/usuario','Report\ReportFinanzasController@reportTicketGenerate');

	//---------------------------------------------------------------------------------------------Finansas customer

	//Vista de red Arbol
	Route::get('/customer/viewFinance','Customer\FinanceCustomerController@viewFinanceCustomer');
	Route::post('/customer/tree','Customer\FinanceCustomerController@tree');

	//reporte excel
	Route::get('/customer/reportRedExcel','Customer\FinanceCustomerController@reportRedExcel');

	//---------------------------------------------------------------------------------------------Finansas customer
	//enviar msm
	Route::post('/customer/mensaje','api\msm\msmController@enviarMsm');
	Route::get('/customer/msm/','api\msm\msmController@msmView');

	//api culqi
	Route::post('/customer/api/culqi/save', 'CapitalDriver\CapitalDriverController@saveCharge');
	Route::post('/customer/order', 'Customer\CustomerController@saveOrder');

	// AJAX
	Route::get('/states/{id}',          'General\ControllerGeneral@getStates');
	Route::get('/cities/{id}',          'General\ControllerGeneral@getCities');
	Route::get('/districts/{id}',       'General\ControllerGeneral@getDistricts');
	Route::post('/customer/getState', 	'Customer\CustomerController@getState');
	Route::post('/customer/getCity', 	  'Customer\CustomerController@getCity');

	// Historical
  Route::get('/viewhistorical',         'General\HistoricalController@show');
	Route::get('/allhistorical',          'General\HistoricalController@historicals');
	Route::get('/viewhistoricalid/{id}',  'General\HistoricalController@historicalsviewid');

	Route::get('/viewCustomersDup',  'Test\TestController@CustomerDNIduplicados');
	//api reniec------------------------------------------------
	//Route::get('/dni/reniec',  'Api\reniec\reniecController@migrarData');

	//
	Route::get('/customer/test',  'Customer\CustomerController@viewTest');
	Route::get('/customer/form',  'Customer\CustomerController@viewFormulario');
	Route::post('/customer/testDB',  'Customer\CustomerController@getCustomer');
	Route::post('/customer/form/register',  'Customer\CustomerController@registerForm');
	Route::get('/customer/form/votaciones',  'Customer\CustomerController@exporForm');
	Route::post('/customer/register/driver/getVal',  'Driver\ControllerDriver@getCustomerValidate');

	//ATENCION
  Route::get('/atencion/register',  'AtencionCliente\AtencionClienteController@index');
	Route::get('/atencion/listRegister',  'AtencionCliente\AtencionClienteController@listRegister');
	Route::get('/atencion/registerservice/{id}',  'AtencionCliente\AtencionClienteController@registerservice');
	Route::post('/atencion/store',  'AtencionCliente\AtencionClienteController@store');
	Route::get('/atencion/getDataregister',  'AtencionCliente\AtencionClienteController@allservice');
	Route::get('/freshdesk/listgroups',  'api\freshdesk\freshdeskController@getGrupos');
	Route::get('/dataoff',  'test\testController@exportar');
	Route::get('atencion/tickets/views/{idt}/{id}', 				'AtencionCliente\AtencionClienteController@getTicketDetails');
	Route::post('/atencion/freshdesk/GetAgentsByGroupID',  'AtencionCliente\AtencionClienteController@GetAgentsByGroupID');
	Route::post('/atencion/freshdesk/update',  'AtencionCliente\AtencionClienteController@updateRegTick');
	Route::post('/atencion/freshdesk/reply',  'AtencionCliente\AtencionClienteController@reply');
	Route::post('/atencion/freshdesk/replyNote',  'AtencionCliente\AtencionClienteController@replyNote');
	Route::post('/atencion/updateTicketStatus',     'AtencionCliente\AtencionClienteController@updateTicketStatus');
	Route::get('/atencion/notificationsget', 	'AtencionCliente\AtencionClienteController@getNotifications');
	Route::post('/atencion/getDescCategory',  'AtencionCliente\AtencionClienteController@getCategoryDesc');
	Route::post('/atencion/getCategoryForType',  'AtencionCliente\AtencionClienteController@getCategoryForTypes');
	Route::get('/atencion/search/{id}/{key}',  'AtencionCliente\AtencionClienteController@searchsubject');

	Route::post('/users/exeterno/perfilSave', 	'Driver\Externo\ExternalDriverController@storeperfil');
	Route::post('/users/exeterno/register', 	'Driver\Externo\ExternalDriverController@store');
	Route::post('/users/exeterno/fileSave', 	'Driver\Externo\ExternalDriverController@filesaves');

		Route::get('/driver/driverlist',          'Driver\Externo\ExternalDriverController@getDrivers');
		Route::get('/driver/driverlist/usuario/{user}',          'Driver\Externo\ExternalDriverController@listDriver_id');

		//saeg---------------------------------------------
		Route::get('/driver/saeg/list',          'Driver\Externo\ExternalDriverController@showLis');
		Route::post('/driver/saeg/list/drivers',          'Api\Saeg\saegController@getDataList');
		Route::get('/driver/saeg/get/antecedente',          'Api\Saeg\saegController@getData');
		Route::get('/driver/saeg/pdf/antecedente/{id}',          'Api\Saeg\saegController@pdfAntecedentes');
		////saeg---------------------------------------------

		Route::post('/driver/externo/placaval', 	'Driver\Externo\ExternalDriverController@validateplaca');
		Route::post('/driver/externo/officeval', 	'Driver\Externo\ExternalDriverController@validateoffice');
		Route::post('/driver/externo/dnival', 	'Driver\Externo\ExternalDriverController@validatedni');
		Route::post('/driver/externo/phoneval', 	'Driver\Externo\ExternalDriverController@validatephone');
		Route::post('/driver/externo/emailval', 	'Driver\Externo\ExternalDriverController@validateemail');
		Route::post('/driver/externo/licencevalexi', 	'Driver\Externo\ExternalDriverController@validatelicenceexi');
		Route::post('/driver/externo/placavalexi', 	'Driver\Externo\ExternalDriverController@validateplacaexi');
		Route::post('/driver/externo/validatelice', 	'Driver\Externo\ExternalDriverController@validatelic');
});
	Route::post('/tickets/imgSave',       'GuestPayment\GuestPaymentController@imgSave');

	//API VALIDACION
	Route::match(['get', 'post'],'/validarDriverProceso', 'Driver\ControllerDriverApp@validDriverProcess');
	Route::match(['get', 'post'],'/metadataApi',          'Driver\ControllerDriverApp@getMetadataApi');
	Route::match(['get', 'post'],'/getModalValidate',     'Driver\ControllerDriverApp@getModalValidate');
	Route::match(['get', 'post'],'/getDataSending',       'Driver\ControllerDriverApp@getDataSending');
	Route::match(['get', 'post'],'/getDriverAprovedsView','Driver\ControllerDriverApp@getDriverAprovedsView');
	Route::match(['get', 'post'],'/upDocumentos',         'Driver\ControllerDriverApp@upDocumentos');
	Route::match(['get', 'post'],'/upDriver',             'Driver\ControllerDriverApp@upDriver');
	Route::match(['get', 'post'],'/driverStatusApi',      'Driver\ControllerDriverApp@driverStatusApi');
	Route::match(['get', 'post'],'/getDataSendingVehicle','Driver\ControllerDriverApp@getDataSendingVehicle');
	Route::match(['get', 'post'],'/conductores/aprobados','Driver\ControllerDriverApp@getDriverAproveds');

	//GET ROL
	Route::match(['get', 'post'], '/getRolValid','User\UserController@getRolValid'    );											 //

///COnductor externo
	Route::post('/users/exeterno/id', 	'Driver\Externo\ExternalDriverController@getUsers');

	//agregue
	Route::post('/updateFormDriver', 	'Driver\ControllerDriver@updateDriver');
	Route::POST('/driver/saveFile',  	'Driver\ControllerDriver@updFile');

	Route::POST('/permisosProcessValid',  	'Driver\ControllerDriver@permisosProcessValid');




	Route::get ('/record/driver/{id}',       		    'Driver\ControllerDriver@recordDriver');
	Route::post('/record/driver/getRecordRango',    'Driver\ControllerDriver@recordRango');
	Route::post('/driver/externo/saveRecord', 	    'Driver\ControllerDriver@saveRecord');
	Route::post('/driver/externo/validarProceso',   'Driver\ControllerDriver@validarProceso');
	Route::get('/driver/externo/sendAppDataVehicle/{id}', 	'Driver\ControllerDriver@sendAppDataVehicle');
	Route::get('/driver/externo/sendAppDataDriver/{id}', 	'Driver\ControllerDriver@sendAppDataDriver');

	Route::get('/driver/externo/list', 	'Driver\ControllerDriver@listshow');
	Route::post('/driver/externo/get', 	'Driver\Externo\ExternalDriverController@getDriverFile');
	Route::post('/driver/externo/get2', 	'Driver\Externo\ExternalDriverController@getDrivers2');

	Route::post('/driver/externo/getDataProceso', 	'Driver\ControllerDriver@getDataProceso');

	Route::post('/users/exeterno/register/docs', 	'Driver\Externo\ExternalDriverController@storedocs');
	Route::post('/driver/externo/get/img', 	'Driver\Externo\ExternalDriverController@getimgfile');
	Route::post('/driver/externo/updateObse', 	'Driver\Externo\ExternalDriverController@updateObserva');
	Route::get('/driver/externo/details/{id}', 	'Driver\ControllerDriver@detailshow');
	Route::get('/driver/externo/details/reporte/{id}', 	'Driver\ControllerDriver@reportPDF');
	Route::get('/driver/externo/rtpdf/{id}', 	'Driver\Externo\ExternalDriverController@checkpdf');
	Route::post('/driver/externo/licenceval', 	'Driver\Externo\ExternalDriverController@validatelicense');
	Route::post('/driver/externo/placaval', 	'Driver\Externo\ExternalDriverController@validateplaca');
	Route::get('/driver/externo/subir', 	'Driver\ControllerDriver@uploadView');
	Route::post('/driver/externo/upload', 	'Driver\ControllerDriver@saveAntecendetes');
	Route::post('/driver/externo/getdad', 	'Driver\ControllerDriver@getuserDri');

	Route::get('/driver/externo/report/record/{id}', 	'Driver\ControllerDriver@reportePDFRecord');

	// viewfrontend
	Route::get('/acerca', function(){ return redirect()->away('https://winescompartir.com/about.html'); });
	Route::get('/faq', 	'Test\TestController@faq');
	Route::get('/terminosycondiciones', function(){ return redirect()->away('https://winescompartir.com/terminosycondiciones/'); });
	Route::get('/privacidad', function(){ return redirect()->away('https://winescompartir.com/privacidad/'); });
  Route::get('/legal', function(){ return redirect()->away('https://winescompartir.com/legal/'); });
	Route::get('/report', 	'Test\TestController@reportfront');
  Route::get('/app-pasajero', 	'Test\TestController@appPassenger');
  Route::get('/app-conductor', 	'Test\TestController@appDriver');
