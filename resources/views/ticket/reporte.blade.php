@extends('layout-backend')
@section('title', 'Buscar')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
@endsection

@section('content')
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Itéms de Busqueda</h3>
            <?php
            echo $permisocrear == true || $rolid == 4 ? '<div class="tickets"><a href="'.route('customer.create').'" class="btn btn-info pull-right">Registrar Accionista</a></div>' : '';
            ?>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool btn-expand" data-widget="collapse" id="ids" vergene = "{{ $permisover }}" verespe = "{{ $permisoverespe }}" rolid="{{ $rolid }}"><i class="fa fa-minus"></i></button>
            </div>
        </div>
      <div class="box-body">
        <form  id="myform">

          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="row">
              <div class="col-lg-2 col-md-1"></div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="id_pay" class="control-label">Tipo de pago</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-gg"></i></div>
                          {!! Form::select('id_pay', $pay, null,['id'=>'id_pay', 'class'=>'form-control select2',  'placeholder' => 'Seleccione...', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label for="status_user" class="control-label">Estatus del ticket</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-check-circle"></i></div>
                            {!! Form::select('status_user', $status, null,['id'=>'status_user', 'class'=>'form-control select2',  'placeholder' => 'Seleccione...', 'style'=>'width: 100%'] ) !!}
                        </div>
                        <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-2 col-md-1"></div>
          </div>
          <div class="row">
              <div class="col-lg-2 col-md-1"></div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="id_customer" class="control-label">Cliente</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-car"></i></div>
                          {!! Form::select('id_customer', $customer, null,['id'=>'id_customer', 'class'=>'form-control select2',  'placeholder' => 'Seleccione...', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="id_invited_by" class="control-label">Patrocinador</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-car"></i></div>
                          {!! Form::select('id_invited_by', $customer, null,['id'=>'id_invited_by', 'class'=>'form-control select2',  'placeholder' => 'Seleccione...', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-2 col-md-1"></div>
          </div>
          <div class="row">
              <div class="col-lg-2 col-md-1"></div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="modified_by" class="control-label">Responsable</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-user"></i></div>
                          {!! Form::select('modified_by', $modified_by, null,['id'=>'modified_by', 'class'=>'form-control select2',  'placeholder' => 'Seleccione...', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="id_country_inv" class="control-label">País a invertir</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                          {!! Form::select('id_country_inv', $country, null,['id'=>'id_country_inv', 'class'=>'form-control select2',  'placeholder' => 'Seleccione...', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-2 col-md-1"></div>
          </div>
          <div class="row">
              <div class="col-lg-2 col-md-1"></div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="created_at" class="control-label">Fecha/Creación</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                          {!! Form::text('created_at', null,['id'=>'created_at', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="date_pay" class="control-label">Fecha de pago</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                          {!! Form::text('date_pay', null,['id'=>'date_pay', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-2 col-md-1"></div>
          </div>
          <div class="row">
              <div class="col-lg-2 col-md-1"></div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="num_ticket" class="control-label">N° de Ticket</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                          {!! Form::text('num_ticket', null,['id'=>'num_ticket', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="num_libro" class="control-label">N° de Libro</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-book"></i></div>
                          {!! Form::text('num_libro', null,['id'=>'num_libro', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                        </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
              <div class="col-lg-2 col-md-1"></div>
          </div>
      </div>
      <div class="box-footer">
         <button type="button" class="btn btn-default" id="clean">Limpiar</button>
         <button type="button" class="btn btn-info pull-right" id="search">Buscar</button>
     </div>
     </form>
    </div>
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Listado de tickets</h3>
        </div>
        <div class="box-body">
           <div class="hero-callout">
              <table id="tickets"  class="table" >
                  <thead>
                    <tr>
                      <th>Detalles</th>
                      <th>Descargar</th>
                      <th>ver</th>
                      <th>Cod</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>DNI</th>
                      <th>Producto</th>
                      <th>N°Acciones</th>
                      <th>T/Pago</th>
                      <th>N°Operacion</th>
                      <th>Banco</th>
                      <th>Monto</th>
                      <th>Moneda</th>
                      <th>F/Creación</th>
                      <th>F/Pago</th>
                      <th>Nombres/Anfitrion</th>
                      <th>Apellidos/Anfitrion</th>
                      <th>DNI/Anfitrion</th>
                      <th>Pago/Anfitrion</th>
                      <th>Total/Anfitrion</th>
                      <th>Fecha/Cobro</th>
                      <th>Responsable/Anfitrion</th>
                      <th>Observaciones/Anfitrion</th>
                      <th>N°Libro</th>
                      <th>Pais/Inv</th>
                      <th>Observaciones</th>
                      <th>Donación</th>
                      <th>Estatus</th>
                      <th>Responsable</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Detalles</th>
                      <th>Descargar</th>
                      <th>ver</th>
                      <th>Cod</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>DNI</th>
                      <th>Producto</th>
                      <th>N°Acciones</th>
                      <th>T/Pago</th>
                      <th>N°Operacion</th>
                      <th>Banco</th>
                      <th>Monto</th>
                      <th>Moneda</th>
                      <th>F/Creación</th>
                      <th>F/Pago</th>
                      <th>Nombres/Anfitrion</th>
                      <th>Apellidos/Anfitrion</th>
                      <th>DNI/Anfitrion</th>
                      <th>Pago/Anfitrion</th>
                      <th>Total/Anfitrion</th>
                      <th>Fecha/Cobro</th>
                      <th>Responsable/Anfitrion</th>
                      <th>Observaciones/Anfitrion</th>
                      <th>N°Libro</th>
                      <th>Pais/Inv</th>
                      <th>Observaciones</th>
                      <th>Donación</th>
                      <th>Estatus</th>
                      <th>Responsable</th>
                    </tr>
                  </tfoot>
              </table>
           </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal-viewTicketbyID">
	<div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">Vista del voucher</div>
					<div class="panel-body">
						<div id="verimgTicket"><center>
                <img src="{{ URL::asset('imagenes/logotipo.png')}}" style="display: block; max-width: 30%; height: auto;" alt="Logotipo">
                 <p id="codregticket"></p>
                 <p id="prodregticket"></p>
                 <p id="fecharegticket"></p>
                 <table>
                   <thead>
                     <tr>
                       <th class="cantidad" colspan="2" align="center" style="background-color:#ededed" >DATOS DEL ACCIONISTA</th>
                     </tr>
                   </thead>
                   <tbody>
                     <tr>
                       <td class="cantidad">DNI</td>
                       <td class="producto" id="dnicompradticket"></td>

                     </tr>
                     <tr>
                       <td class="cantidad">Comprador</td>
                       <td class="producto" id="compradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Pais</td>
                       <td class="producto" id="paiscompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Estado</td>
                       <td class="producto" id="estcompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Ciudad</td>
                       <td class="producto" id="ciucompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Dirección</td>
                       <td class="producto" id="direccompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Teléfono</td>
                       <td class="producto" id="telfcompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Correo</td>
                       <td class="producto" id="corrcompradticket"></td>
                     </tr>
                     <tr>
                       <th class="cantidad" colspan="2" align="center" style="background-color:#ededed">DATOS DE LA COMPRA</th>
                     <tr>
                       <td class="cantidad">Monto</td>
                       <td class="producto" id="montcompra"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Tipo de pago</td>
                       <td class="producto" id="tippaycompra"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Nro Ope.</td>
                       <td class="producto"id="nroopecompra" ></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Fecha Pago</td>
                       <td class="producto" id="fechpagcompra"></td>
                     </tr>
                     <tr>
                       <th Classes="cantidad" colspan="2" align="center" style="background-color:#ededed">DATOS DEL ANFITRION</th>
                     </tr>
                     <tr>
                       <td class="cantidad">Nombre</td>
                       <td class="producto" id="nameinvtcomp"></td>
                     </tr>
                     <tr>
                       <th class="producto" colspan="2" align="center" style="background-color:#ededed">PAIS A INVERTIR</th>
                     </tr>
                     <tr>
                       <td class="producto" colspan="2" align="center" id="paisainvert"></td>
                     </tr>
                     <tr>
                       <th class="producto" colspan="2" align="center" style="background-color:#ededed">OBSERVACIONES</th>
                     </tr>
                     <tr>
                       <td class="producto" colspan="2" align="center" id="observaticket"></td>
                     </tr>
                   </tbody>
                 </table>
                 <br>
                <p style="font-size: 10px !important;" class="centrado">*Este es un comprobante de pago que será válido hasta que se emita el certificado de tenencia de acción
                </p>
              </center>
            </div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
        <div id="downloadvoucher"><a type="button" class="btn btn-success pull-left" id="download-voucher" onclick="descargarTicket()">Descargar</a></div>
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
            <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
              <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
            </div>
          </div>


@endsection

@section('js')

  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>

  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>



  <script src="{{ asset('js/Ticket/reporte.js')}} "></script>

@endsection
