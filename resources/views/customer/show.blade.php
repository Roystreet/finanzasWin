
@extends('layouts.app')
@section('title', 'Detalles del cliente')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">

  <link rel="stylesheet" href="{{ asset('bower_components/jquery-ui-1.12.1/jquery-ui.css')}}">

  <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
  <script>
    // Initialize Firebase
    var config = {
      apiKey: "AIzaSyBqCfECYsTVmKVgqJW2MuG-nNeIM_Gj1cU",
      authDomain: "voucher-img.firebaseapp.com",
      databaseURL: "https://voucher-img.firebaseio.com",
      projectId: "voucher-img",
      storageBucket: "voucher-img.appspot.com",
      messagingSenderId: "264645547952"
    };
    firebase.initializeApp(config);
    var storage = firebase.storage();
  </script>
  {{--  --}}

<style>
  .ui-autocomplete { z-index:2147483647 !important; }
</style>
@endsection

@section('content')
<section class="content">
  	<div  name="customer" class="box">
    		<div class="box-body">
    		    <div class="box-header">
    		      <h3 class="box-title">Información</h3>
    		    </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
    		    <div class="box-body">
    					<div class="row">
    						<div class="col-xs-12 col-md-6">
                    <div id="personales" name="personales">
                        <pre><i class="fa fa-user"></i> - <b>Datos Personales</b></pre>
                        {!! Form::hidden('doc_front',  $customer->doc_front,['id'=>'doc_front', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                        {!! Form::hidden('doc_back',     $customer->doc_back,   ['id'=>'doc_back',    'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                        <div class="ids" data-id="{{ $customer->id }}" vergene = "{{ $vergene }}" verespe = "{{ $verespe }}" rolid="{{ $rolid }}">
          					        <div class="col-xs-3"><b>Nombres: </b></div>  <div class="col-xs-9">{{ $customer->first_name }}</div>
          					        <div class="col-xs-3"><b>Apellidos: </b></div>  <div class="col-xs-9">{{ $customer->last_name }}</div>
                            <div class="col-xs-3"><b>Correo: </b></div>  <div class="col-xs-9">{{ $customer->email }}</div>
          					        <div class="col-xs-3"><b>Teléfono: </b></div>  <div class="col-xs-9">{{ $customer->phone }}</div>
          					        <div class="col-xs-3"><b>DNI: </b></div>  <div class="col-xs-9">{{ $customer->document }}&nbsp;&nbsp;&nbsp;&nbsp;<a title="Ver DNI" onclick="viewDni({{ $customer->id }});"><i class="fa fa-eye"></i></a></div>
        					      </div>
                    </div>
                </div>
    						<div class="col-xs-12 col-md-6">
      							<div id="address" name="address">
      								  <pre><i class="fa fa-child"></i> - <b>Dirección</b></pre>
      					        <div class="col-xs-3"><b>País: </b></div>  <div class="col-xs-9">{{ $customer->getCountry ? $customer->getCountry->description : 'S/I' }}</div>
      					        <div class="col-xs-3"><b>Estado: </b></div> <div class="col-xs-9">{{ $customer->getState ? $customer->getState->description : 'S/I' }}</div>
      					        <div class="col-xs-3"><b>Provincia: </b></div>  <div class="col-xs-9">{{ $customer->getCity ? $customer->getCity->description : 'S/I' }}</div>
      					        <div class="col-xs-3"><b>Dirección: </b></div>  <div class="col-xs-9">{{ $customer->address ? $customer->address : 'S/I' }}</div>
      					        <div class="col-xs-3"><b>Total de acciones: </b></div>  <div class="col-xs-9"><div id="totalSalary"></div></div>
      					  	</div>
    						</div>
    					</div>
              <?php
              echo $permiso == true || $rolid == 4 ? '<a class="btn-a" href="'.route('customer.edit', $customer).'"><i class="fa fa-edit btn-a" aria-hidden="true"></i> Editar</a> ' : '-';
              ?>
             </div>
					</div>
		</div>

  <div  name="books" class="box">
		<div class="box-body">
		    <div class="box-header">
		      <h3 class="box-title">Listado de numero de Libro</h3>
		    </div>
					<table id="books" name="books"  class="table">
	        <thead>
	          <tr>
	           <th width="5%">Accion</th>
	           <th width="5%">N° Libro</th>
	           <th width="5%">N° Acciones</th>
             <th width="5%">Comentarios</th>
             <th width="5%">Cantidad Impresion</th>
             <th width="5%">Firmo libro</th>
             <th width="5%">File</th>
	         </tr>
	        </thead>
	        <tfoot>
	         <tr>
             <th width="5%">Accion</th>
	           <th width="5%">N° Libro</th>
	           <th width="5%">N° Acciones</th>
             <th width="5%">Comentarios</th>
             <th width="5%">Cantidad Impresion</th>
             <th width="5%">Firmo libro</th>
             <th width="5%">File</th>
	         </tr>
	        </tfoot>
	      </table>
		</div>
	</div>

	<div  name="ticket" class="box">
		<div class="box-body">

		    <div class="box-header">
		      <h3 class="box-title">Listado de Tickets</h3>
		    </div>

					<table id="tickets" name="tickets"  class="table">
	        <thead>
	          <tr>
	           <th width="5%">Accion</th>
	           <th width="5%">Codigo</th>
	           <th width="5%">Producto</th>
             <th width="5%">Descripcion producto</th>
						 <th width="5%">Invitado</th>
						 <th width="5%">Pais Inversion</th>
	           <th width="5%">Precio</th>
             <th width="5%">Banco</th>
						 <th width="5%">Moneda</th>
						 <th width="5%">N° Acciones</th>
	           <th width="5%">Total</th>
             <th width="5%">Estatus</th>
             <th width="5%">N° Libro</th>
             <th width="5%">Certificado</th>
             <th width="5%">Usuario</th>
             <th width="5%">Observacion (se muestra en el ticket)</th>
             <th width="5%">Observacion (Interna)</th>
	         </tr>
	        </thead>

	        <tfoot>
	         <tr>
						 <th width="5%">Accion</th>
	           <th width="5%">Codigo</th>
	           <th width="5%">Producto</th>
             <th width="5%">Descripcion producto</th>
						 <th width="5%">Invitado</th>
						 <th width="5%">Pais Inversion</th>
	           <th width="5%">Precio</th>
             <th width="5%">Banco</th>
						 <th width="5%">Moneda</th>
						 <th width="5%" >N° Acciones</th>
	           <th width="5%">Total</th>
             <th width="5%">Estatus</th>
             <th width="5%">N° Libro</th>
             <th width="5%">Certificado</th>
             <th width="5%">Usuario</th>
             <th width="5%">Observacion (se muestra en ticket)</th>
             <th width="5%">Observacion (Interna)</th>
	         </tr>
	        </tfoot>
	      </table>
		</div>
	</div>

<div class="modal fade" id="modal-viewDni">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="panel panel-info">
          <div class="panel-heading">Número de identificación / DNI / Cédula de identidad / CURP</div>
          <div class="panel-body">
            <div>
              <div id="carousel-example-generic" class="carousel slide" >
                <div class="carousel-inner"></div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"><span class="fa fa-angle-left"></span></a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"><span class="fa fa-angle-right"></span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div><a type="button" class="btn btn-success pull-left" onclick="actualizarDni();">Actualizar</a></div>
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  <!-- dialog -->
</div>

<div class="modal fade" id="modal-viewDniUpload">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="panel panel-info">
          <div class="panel-heading">Número de identificación / DNI / Cédula de identidad / CURP</div>
          {!! Form::hidden('id_customer',  $customer->id,['id'=>'id_customer', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
          {!! Form::hidden('country-name', $customer->getCountry ? $customer->getCountry->description : 'DEFAULT' ,   ['id'=>'country-name',    'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
          <div class="panel-body">
            <form class="form-horizontal" action="#" id="dniForm" enctype="multipart/form-data">
            <div class="section">

              <div class="container">
                <div class="form-group col-sm-6 col-md-4">
                  <label for="banner">Frontal:</label>
                <div class="input-group">
                  <label class="input-group-btn">
                  <span class="btn btn-primary btn-file">
                  LADO A <input type='file' class="form-control" id="doc-front" name="doc-front" accept="image/x-png,image/gif,image/jpeg">
                  </span>
                  </label>
                  <input class="form-control" id="doc_front_captura" readonly="readonly" name="doc_front_captura" type="text" value="">
                </div>
                </div>
              </div>

              <div class="container">
                <div class="form-group col-sm-6 col-md-4">
                  <label for="banner">Posterior:</label>
                  <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                    LADO B<input type='file' class="form-control" id="doc-back" name="doc-back" accept="image/x-png,image/gif,image/jpeg">
                    </span>
                    </label>
                    <input class="form-control" id="doc_back_captura" readonly="readonly" name="doc_back_captura" type="text" value="">
                  </div>
                </div>
              </div>

            </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <div><a type="button" class="btn btn-success pull-left" onclick="saveDni();">Guardar</a></div>
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-ticket">
  <div class="modal-dialog">
    <div class="modal-content">
			<form id="dataticket">
 			 <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="modal-body">
				{{--  inicio detalle de la compra --}}
          <div class="panel panel-info">
            <div class="panel-heading">Detalle de la compra</div>

            <div class="panel-body">

							<table id="compra"  name="compra"   width="100%" align="left">
								<tr>
									<td colspan="2" height="20px"><pre><i class="fa fa-user"></i> - <b>Compra</b></pre></td>
								</tr>

								<tr>
									<th width="200px">N° Ticket:</th>
									<td id="cod_ticket"> </td>
								</tr>
								<tr>
									<th>Pais a Invertir:</th>
									<td> <input type="text" name="" value="" id="id_country_invert"> </td>
								</tr>
								<tr>
									<th>Tipo de Pago:</th>
									<td id ="id_pay">  </td>
								</tr>
                <tr>
									<th>Banco:</th>
									<td id ="id_banck">  </td>
								</tr>
								<tr>
									<th>N° de Operacion :</th>
									<td id="number_operation"></td>
								</tr>
								<tr>
									<th>Fecha de Pago:</th>
									<td id="date_pay"></td>
								</tr>
							</table>
							<table id="product" name="product"  width="100%" align="left">
								<tr>
									<td colspan="4" height="20px"><pre><i class="fa fa-child"></i> - <b>Producto</b></pre></td>
									<input type="hidden" name="newproduct" id="newproduct" value="">
									<tr>
										<tr>
											<th width="200px"> Codigo:</th>
											<td id="cod_product"></td>
										</tr>
										<tr>
											<th>Nombre:</th>
											<td id="name_product"></td>
										</tr>
										<tr>
											<th>Cantidad:</th>
											<td id="cant"></td>
										</tr>
										<tr>
											<th>Precio:</th>
											<td id="price"></td>
										</tr>
										<tr>
											<th>Moneda:</th>
											<td id="id_money"></td>
										</tr>
										<tr>
											<th>Total:</th>
											<td id="total"></td>
										</tr>
                    <!-- <tr>
                      <td><td><button type="button" class="btn btn-success pull-left" id="recalProduct">Recalcular productos</button></td></td>
                    </tr> -->
										<tr id="calProduct">

										</tr>
										<tr id="selProduct">

										</tr>
                    </tr>
                    </tr>
							 </table>
							 <table id="st_ticket" name="st_ticket"  width="100%" align="left">
 								<tr>
 									<td colspan="4" height="20px"><pre><i class="fa fa-child"></i> - <b>Voucher de Pago</b></pre></td>
 									<tr>
 										<tr>
 											<th width="200px">Voucher :</th>
 											<td id="voucher_pago"></td>
 										</tr>
                    </tr>
                    </tr>
 							 </table>
               <table id="sponsor" name="sponsor"  width="100%" align="left">
                 <tr>
  									<td colspan="4" height="20px"><pre><i class="fa fa-child"></i> - <b>Sponsor</b></pre></td>
                    <input type="hidden" name="newsponsor" id="newsponsor" value="">
  									<tr>
                 <tr>
                   <th>Nombre Invita:</th>
                   <td id="name_inv"></td>
                 </tr>
                 <tr>
                   <th>DNI invita:</th>
                   <td id="dni_inv"></td>
                 </tr>
                 <tr>
                   <th>Telefono:</th>
                   <td id="phone_inv"></td>
                 </tr>
                 <tr id="calSponsor">

                 </tr>
                 <tr id="selSponsor">

                 </tr>
                 </tr>
                 </tr>
               </table>
							 <table id="bono-directo" name="bono-directo"  width="100%" align="left">
 								<tr>
 									<td colspan="4" height="20px"><pre><i class="fa fa-child"></i> - <b>Bono directo</b></pre></td>
 									<tr>
 										<tr>
 											<th width="200px">Fecha :</th>
 											<td id="fecha_bono_view"> </td>
 										</tr>
 										<tr>
											<th>Fecha cobro:</th>
 											<td id="fec_cob_inv"></td>
 										</tr>
										<tr>
											<th>Modo Pago:</th>
 											<td id="mod_pag_inv"></td>
 										</tr>
                    <tr>
											<th>Tipo de moneda:</th>
 											<td id="tip_moneda_inv"></td>
 										</tr>
										<tr>
 											<th>Bono directo:</th>
 											<td id="bono_inv_view"></td>
 										</tr>
										<tr>
											<th>Observacion general ticket bono: <b style="font-size: 12px;"> (opcional)</b></th>
 											<td id="obser_inv_view"></td>
 										</tr>
                    <tr>
											<th>Observación Interno Ticket Bono: <b style="font-size: 12px;"> (opcional)</b></th>
 											<td id="obser_int_view"></td>
 										</tr>
                    </tr>
                    </tr>
 							 </table>
							 <table id="st_ticket" name="st_ticket"  width="100%" align="left">
 								<tr>
 									<td colspan="4" height="20px"><pre><i class="fa fa-child"></i> - <b>Estado Ticket</b></pre></td>
 									<tr>
 										<tr>
 											<th width="200px">Estado :</th>
 											<td id="status_ticket"></td>
 										</tr>
                  </tr>
                </tr>
 							 </table>
            </div>

            <div class="modal-footer">
				<div id="status"></div>
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
      </div>

          </div>
        {{-- Fin del detalle de la compra --}}
      </div>
    </form>
  </div>
</div>
</div>
{{-- tranferir accion --}}
<div class="modal fade" id="modal-book-update">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="panel panel-info">
          <div class="panel-heading">Cambiar numero de libro <b id="titlebook" data-id="{{ $id }}"></b></div>
          <div class="panel-body">
            <table id="facturacion" name="destino"  width="100%" align="left">
              <tr>
                <td colspan="5" height="20px"><pre><i class="fa fa-child"></i> - <b>Datos de destino</b></pre></td>
              </tr>
             <tr>
               <th>DNI: buscar</th>
                 <td>
                  <input type="text" name="" value="" id="dni_destino">
                </td>
             </tr>
             <tr>
                <th>Apellidos y nombres :(Destino)</th>
                  <td >
                   <span id="name_destino"></span>
                  </td>
              </tr>

            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success pull-left change-book">Cambiar</button>
        <button type="button" id="cerrar" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Fin tranferir accion --}}

{{-- Cambiar imagen vaucher --}}
<div class="modal fade" id="modal-viewTicket">
  	<div class="modal-dialog">
      <div class="modal-content">
  			<div class="modal-body">
  				<div class="panel panel-info">
  					<div class="panel-heading">Vista del voucher</div>
  					<div class="panel-body">
  						<div id="verimgTicket"></div>
  					</div>
  				</div>
  			</div>
  			<div class="modal-footer">
          <div id="update-img"><button type="button" class="btn btn-success pull-left change-img">Cambiar imagen</button></div>
  				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
  			</div>
  		</div>
  	</div>
  </div>
{{-- Fin Cambiar imagen vaucher --}}

<div class="modal fade bd-example-modal-sm load-img" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        @include('load.loading')

    </div>
  </div>
</div>

<div class="modal fade" id="modal-print">
	<div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">imprimir certificado</div>
					<div class="panel-body">
						<div id="verimgTicket"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
        <div id="btn-imprimirCer"></div>
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



{{--  inicio modal--}}
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <div class="row">
          <div class="col-xs-5">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-map-o"></i></span>
              <input type="text" class="form-control" placeholder="" id="city" value="Lima">
            </div>
          </div>


          <div class="col-xs-6">

            <!-- Date -->


                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" value="{{date('Y-m-d')}}" >

                            </div>


                            <!-- /.input group -->


          </div>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary bnt-print">Imprimir</button>
      </div>
    </div>
  </div>
</div>
{{--  fin modal--}}

<div class="modal fade" id="modal-file">
	<div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">Subir documentos del file</div>
					<div class="panel-body">

            <!--  -->
            <div class="container">
              <div class="form-group col-sm-6 col-md-4">
                <label for="banner">contrato:</label>
              <div class="input-group">
                <label class="input-group-btn">
                <span class="btn btn-primary btn-file">
                contrato <input type='file' class="form-control" id="url_contrato" name="url_contrato" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/msword">
                </span>
                </label>
                <input class="form-control"  readonly="readonly"  type="text" value="">

              </div>
              <a href="#" target="_blank" id="ver_contrato">VER DOCUMENTO</a>
              </div>
            </div>


          <!--  -->
      <div class="container">
        <div class="form-group col-sm-6 col-md-4">
          <label for="banner">copia del certificado antiguo:</label>
          <div class="input-group">
            <label class="input-group-btn">
            <span class="btn btn-primary btn-file">
            Certificado Antiguo<input type='file' class="form-control" id="url_certificado_old" name="url_certificado_old" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/msword">
            </span>
            </label>
            <input class="form-control" readonly="readonly"  type="text" value="">
          </div>
          <a href="#" target="_blank" id="ver_certificado_old">VER DOCUMENTO</a>
        </div>
      </div>

      <!--  -->
  <div class="container">
    <div class="form-group col-sm-6 col-md-4">
      <label for="banner">copia del certificado nuevo:</label>
      <div class="input-group">
        <label class="input-group-btn">
        <span class="btn btn-primary btn-file">
        Certificado Nuevo<input type='file' class="form-control" id="url_certificado_new" name="url_certificado_old" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/msword">
        </span>
        </label>
        <input class="form-control"  readonly="readonly"  type="text" value="">
      </div>
      <a href="#" target="_blank" id="ver_certificado_new">VER DOCUMENTO</a>
    </div>
  </div>
  <!--  -->
<div class="container">
<div class="form-group col-sm-6 col-md-4">
  <label for="banner">Baucher antiguo:</label>
  <div class="input-group">
    <label class="input-group-btn">
    <span class="btn btn-primary btn-file">
    Baucher antiguo<input type='file' class="form-control" id="url_baucher_old" name="url_baucher_old" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/msword">
    </span>
    </label>
    <input class="form-control" readonly="readonly" type="text" value="">
  </div>
  <a href="#" target="_blank" id="ver_baucher_old">VER DOCUMENTO</a>
</div>
</div>

<!--  -->
<div class="container">
<div class="form-group col-sm-6 col-md-4">
<label for="banner">Baucher nuevo:</label>
<div class="input-group">
  <label class="input-group-btn">
  <span class="btn btn-primary btn-file">
  Baucher nuevo<input type='file' class="form-control" id="url_baucher_new" name="url_baucher_new" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/msword">
  </span>
  </label>
  <input class="form-control"  readonly="readonly"  type="text" value="">
</div>
<a href="#" target="_blank" id="ver_baucher_new">VER DOCUMENTO</a>
</div>
</div>
<!--  -->
<div class="container">
<div class="form-group col-sm-6 col-md-4">
<label for="banner">documento de traspaso:</label>
<div class="input-group">
  <label class="input-group-btn">
  <span class="btn btn-primary btn-file">
  Traspaso<input type='file' class="form-control" id="url_traspado" name="url_traspado" accept="image/x-png,image/gif,image/jpeg,application/pdf,application/msword">
  </span>
  </label>
  <input class="form-control"  readonly="readonly"  type="text" value="">
</div>
<a href="#" target="_blank" id="ver_traspado">VER DOCUMENTO</a>
</div>
</div>



					</div>
				</div>
			</div>
			<div class="modal-footer">
        <button type="button" class="btn btn-default pull-right" onclick="subirfoto();">Guardar Cambios</button>
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



<!--  -->

<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
      <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
    </div>
</div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>

  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
  <script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>

  {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
  <script src="{{ asset('bower_components/jquery-ui-1.12.1/jquery-ui.js') }}"></script>
  <script src="{{ asset('js/General/upimg.js')}} "></script>
  <script src="{{ asset('js/Customer/show.js')}} "></script>
@endsection
