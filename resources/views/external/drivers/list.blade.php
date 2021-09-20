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
        {{-- <div class="box-header with-border">
            <h3 class="box-title">Itéms de Busqueda</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool btn-expand" data-widget="collapse" id="ids" vergene = "{{ $permisover }}" verespe = "{{ $permisoverespe }}" rolid="{{ $rolid }}"><i class="fa fa-minus"></i></button>
            </div>
        </div> --}}
        <input type="hidden" id="rolid" value="{{ $rolid }}">
      <div class="box-body">
        <form  id="myform">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="num_ticket" class="control-label">Id Officina </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                        {!! Form::text('off_e', null,['id'=>'off_e', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                    </div>
                    <div><span class="help-block" id="error"></span></div>
                </div>
            </div>

          </div>
          @if ($rolid != 7)
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="num_ticket" class="control-label">Buscar de líderes.<code>(ingresar usuario) </code></label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                          {!! Form::text('search', null,['id'=>'search', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}

                      </div>
                      <button type="button" class="btn btn-info pull-right" onclick="search_id()">Buscar formato red</button>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                </div>
            </div>
          @endif

      </div>
      <div class="box-footer">
         <button type="button" class="btn btn-default" onclick="alldrivers()">Mostrar todos</button>
         <button type="button" class="btn btn-info pull-right" onclick="buscar()">Buscar</button>
     </div>
     </form>
    </div>
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Listado de conductores</h3>
        </div>
        <div class="box-body">
           <div class="table table-striped w-auto">
              <table id="driver"  class="table" >
                  <thead>
                    <tr>
                      <th>RECORD</th>
                      <th>RESUMEN</th>
                      <th>REPORTE</th>
                      <th>DNI</th>
                      <th>ID_OFFICE</th>
                      <th>NOMBRES</th>
                      <th>APELLIDOS</th>
                      <th>PHONE</th>
                      <th>CORREO</th>
                      <th>MARCA</th>
                      <th>PLACA</th>
                      <th>MODELO</th>
                      <th>ESTADO</th>
                      <th>FECHA</th>
                      <th>CREADO</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th>RECORD</th>
                      <th>RESUMEN</th>
                      <th>REPORTE</th>
                      <th>DNI</th>
                      <th>ID_OFFICE</th>
                      <th>NOMBRES</th>
                      <th>APELLIDOS</th>
                      <th>PHONE</th>
                      <th>CORREO</th>
                      <th>MARCA</th>
                      <th>PLACA</th>
                      <th>MODELO</th>
                      <th>ESTADO</th>
                      <th>FECHA</th>
                      <th>CREADO</th>
                    </tr>
                  </tfoot>
              </table>
           </div>
        </div>
    </div>
    <div class="row">

      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Leyenda de colores</h3>
          </div>
          <div class="box-body">
             <div class="table table-striped w-auto">
                <table id="driver"  class="table" >
                    <thead>
                      <tr>
                        <th><span>COLOR</span> </th>
                        <th>DESCRIPCIÒN</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="background-color:#ACF5B1">
                        <th>VERDE</th>
                        <th>APROBADO</th>
                      </tr>
                      <tr style="background-color:#F9E79F">
                        <th>AMARILLO</th>
                        <th>EN EVALUACIÓN</th>
                      </tr>
                      <tr style="background-color:#F1948A">
                        <th>ROJO</th>
                        <th>DESAPROBADO</th>
                      </tr>
                      <tr style="background-color:#D2B4DE">
                        <th>MORADO</th>
                        <th>PENDIENTE (NO PASO POR NINGUN PROCESO)</th>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>COLOR</th>
                        <th>DESCRIPCIÒN</th>
                      </tr>
                    </tfoot>
                </table>
             </div>
          </div>
      </div>


    </div>
</section>

<div class="modal fade" id="modal-viewTicketbyID">
	<div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">Fotos</div>
					<div class="panel-body">
						<div>

              <div class="row">
                  <div class="col-lg-2 col-md-1"></div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="created_at" class="control-label">Placa</label>
                          <div id="placa">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="date_pay" class="control-label">Marca</label>
                          <div id="marca">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-2 col-md-1"></div>
              </div>

              <div class="row">
                  <div class="col-lg-2 col-md-1"></div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="created_at" class="control-label">modelo</label>
                          <div id="model">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="date_pay" class="control-label">Año</label>
                          <div id="year">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-2 col-md-1"></div>
              </div>

              <div id="carousel-example-generic" class="carousel slide" >
                  {{-- <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  </ol> --}}
                  <div class="carousel-inner">
                    {{-- <div class="item active">
                      <img src="http://placehold.it/900x500/39CCCC/ffffff&text=I+Love+Bootstrap" alt="First slide">

                      <div class="carousel-caption">
                        First Slide
                      </div>
                    </div>
                    <div class="item">
                      <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">

                      <div class="carousel-caption">
                        Second Slide
                      </div>
                    </div>
                    <div class="item">
                      <img src="http://placehold.it/900x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">

                      <div class="carousel-caption">
                        Third Slide
                      </div>
                    </div> --}}
                  </div>
                  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="fa fa-angle-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="fa fa-angle-right"></span>
                  </a>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-2 col-md-1"></div>
                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12">
                    <div class="form-group">
                        <label for="created_at" class="control-label">Descripción</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-file-text"></i></div>
                            {!! Form::textarea('obser', null,['id'=>'obser', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                        </div>
                        <div><span class="help-block" id="error"></span></div>
                    </div>
                </div>
                {{-- <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="date_pay" class="control-label">Fecha de pago</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            {!! Form::text('date_pay', null,['id'=>'date_pay', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                        </div>
                        <div><span class="help-block" id="error"></span></div>
                    </div>
                </div> --}}
                <div class="col-lg-2 col-md-1"></div>
            </div>



					</div>
				</div>
			</div>
			<div class="modal-footer">
        <div><a type="button" class="btn btn-success pull-left" onclick="actulizarStado(2);">Aprobar</a></div>
        <div><a type="button" class="btn btn-success pull-left" onclick="actulizarStado(5);">Reprobar</a></div>
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-viewRecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="panel-heading">Record del Conductor</div>
        {!! Form::hidden('record_input', null,['id'=>'record_input', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
        {!! Form::hidden('id_send',   null,['id'=>'id_send',     'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
        {!! Form::hidden('recordSum', null,['id'=>'recordSum', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
        {!! Form::hidden('estatus',   null,['id'=>'estatus', '  class'=>'form-control', 'style'=>'width: 100%'] ) !!}
        {!! Form::hidden('baprobado', null,['id'=>'baprobado', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}

        <div class="row">
          <div class="col-lg-2 col-md-1"></div>
          <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="estatus" class="control-label">API SERVICIO</label>
              <div><a type="button" class="btn btn-success pull-left" onclick="apiRecord();">SERVICIO</a></div>
            </div>
          </div>
          <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="estatus" class="control-label">MANUAL</label>
              <div><a type="button" class="btn btn-success pull-left" onclick="apiIframe();">MANUAL</a></div>
            </div>
          </div>
        </div>


      </div>
      <div class="modal-body">
        <div class="modal-content">


            <div id="apidiv" style="display:none">
              <div class="row">
                <div class="col-lg-2 col-md-1"></div>

                <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label for="estatus" class="control-label">Análisis del Record</label>
                    <div id="estatushtml"></div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label for="estatus" class="control-label">Infraciones</label>
                    <div class="progress sm">
                      <div id="barra" class="progress-bar" style="width: 0%"></div>
                    </div>
                  </div>
                </div>

              </div>
              <table id="tbRecord" name="tbRecord"  class="table table-bordered table-striped compact stripe">
                 <thead>
                   <tr>
                     <th>ENTIDAD</th>
                     <th>PAPELETA</th>
                     <th>FECHA</th>
                     <th>FALTA</th>
                     <th>PTOS FIRMES</th>
                     <th>PTOS SALDO</th>
                     <th>ESTADO</th>
                   </tr>
                 </thead>
                 <tbody>

                 </tbody>
                 <tfoot>
                   <tr>
                     <th>ENTIDAD</th>
                     <th>PAPELETA</th>
                     <th>FECHA</th>
                     <th>FALTA</th>
                     <th>PTOS FIRMES</th>
                     <th>PTOS SALDO</th>
                     <th>ESTADO</th>
                   </tr>
                 </tfoot>
             </table>
            </div>
              {{-- cierre del api --}}

            <div id="iframediv" style="display:none">
                <div>
                  <iframe src="https://slcp.mtc.gob.pe/" height="500px" width="100%" frameborder="0" id="frameId"></iframe>
                </div>
                <div>
                  <div class="row">
                    <div class="col-xs-6"><b><label for="estatus" class="control-label">NO POSEE INFRACCIONES</label></b></div>
                    <div class="col-xs-6">
                      <input type="checkbox" id="noinfraccion"  name="noinfraccion" autocomplete="off">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6"><b><label for="estatus" class="control-label">ANALISIS</label></b></div>
                    <div class="col-xs-6">
                      <div id="estatushtmlm"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6"><b><label for="estatus" class="control-label">INFRACCIONES</label></b></div>
                    <div class="col-xs-6">
                      <div class="progress sm">
                        <div id="barram" class="progress-bar" style="width: 0%"></div>
                      </div>
                    </div>
                  </div>

                  <div><a type="button" class="btn btn-success pull-right" id="addRow">+</a></div>
                  <form id="recordForm" action="" method="post">
                    <table id="tbRecordManual" name="tbRecordManual"  class="table table-striped compact">
                       <thead>
                         <tr>
                           <th>ENTIDAD</th>
                           <th>PAPELETA</th>
                           <th>FECHA</th>
                           <th>FALTA</th>
                           <th>PTOS FIRMES</th>
                           <th>X</th>
                         </tr>
                       </thead>
                       <tbody>

                        </tbody>
                       <tfoot>
                         <tr>
                           <th>ENTIDAD</th>
                           <th>PAPELETA</th>
                           <th>FECHA</th>
                           <th>FALTA</th>
                           <th>PTOS FIRMES</th>
                           <th>X</th>
                         </tr>
                       </tfoot>
                   </table>
                 </form>

                 {!! Form::hidden('recordSumM', null,['id'=>'recordSumM', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                </div>
            </div>
            {{-- cierre del iframe --}}

        </div>
      </div>

      <div class="modal-footer" style="display:none" id="buttons">
        <div><a type="button" class="btn btn-success pull-left" onclick="manejarRecord(5);">Aprobar</a></div>
        <div><a type="button" class="btn btn-success pull-left" onclick="manejarRecord(7);">Reprobar</a></div>
        <div><a type="button" class="btn btn-success pull-left" onclick="manejarRecord(8);">Detener</a></div>
        <button type="button" class="btn btn-danger fa fa-close" data-dismiss="modal"> Salir</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-viewHistorico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="modal-content">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">PROCESO DE VALIDACION</h3>
            </div>
            <div class="box-body">
              <div class="table table-striped w-auto">
                 <table id="tableprocesoValidacion"  class="table" >
                     <thead>
                       <tr>
                         <th>PROCESO</th>
                         <th>ESTATUS</th>
                         <th>USUARIO RESP.</th>
                         <th>CREADO</th>
                         <th>ACTUALIZACION</th>
                       </tr>
                     </thead>
                     <tbody>

                     </tbody>
                     <tfoot>
                       <tr>
                         <th>PROCESO</th>
                         <th>ESTATUS</th>
                         <th>USUARIO RESP.</th>
                         <th>CREADO</th>
                         <th>ACTUALIZACION</th>
                       </tr>
                     </tfoot>
                 </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger fa fa-close" data-dismiss="modal"> Salir</button>
      </div>
    </div>
  </div>
</div>


<!--  -->
<div id="la" style="display: none">
    <form id="loginForm">
      <h4>Esta persona no cuenta con DNI</h4>
      <div  class="col-lg-12 padd2">
        <label class="col-xs-12 col-sm-4 col-md-3 padd" for="dni_usuario">Ingrese DNI porfavor:<code>*</code> </label>
        <div class="col-xs-8 col-sm-5 col-md-7 padd" style="display: flex;">
            <input type="text" class="form-control" id="dni_usuario" placeholder="DNI" name="dni_usuario">
        </div>
        <div class="col-xs-4 col-sm-3 col-md-2 padd" style="display: flex;">
            <button type="button" id="btn_dni_buscar" class="btn btn-success" onclick="getDataDni()">Buscar</button>
        </div>
      </div>
      <div  class="col-lg-12 padd2">
          <div class="col-xs-12 padd" style="display: flex;">
              Nombres:<span id="nombre_dni">-</span>
          </div>
          <div class="col-xs-12 padd" style="display: flex;">
              Apellidos :<span id="apellido_dni">-</span>
          </div>
      </div>
      <div class="col-xs-12 padd" style="display: flex;">
          <button type="button" id="btn_dni_save" class="btn btn-success" onclick="saveDNI()">Guardar</button>
      </div>
    </form>
</div>

<!--  -->



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



  <script src="{{ asset('js/External/Driver/list.js')}} "></script>

@endsection
