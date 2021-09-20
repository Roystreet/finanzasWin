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

      <div class="box-body">
        <form  id="myform">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="num_ticket" class="control-label">ID OFICINA</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                        {!! Form::text('off_e', null,['id'=>'off_e', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                    </div>
                    <div><span class="help-block" id="error"></span></div>
                </div>
            </div>

             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                      <label for="num_ticket" class="control-label">DNI</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                          {!! Form::text('dni_e', null,['id'=>'dni_e', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                  </div>
              </div>
          </div>
      </div>

      <div class="box-footer">
         <button type="button" class="btn btn-default" id="clean">Limpiar</button>
         <button type="button" class="btn btn-info pull-right" onclick="buscar()">Buscar</button>
      </div>
      </form>
    </div>

  <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">GESTION APROBACIÓN DE CONDUCTORES</h3>
        </div>
        <div class="box-body">
           <div class="table table-striped w-auto">
             <table id="drivers" class="table table-striped compact">
                  <thead>
                    <tr>
                      <th>ID_OFFICE</th>
                      <th>DNI</th>
                      <th>NOMBRES</th>
                      <th>APELLIDOS</th>
                      <th>HISTORICO</th>
                      <th>DOCUMENTOS</th>
                      <th>VEHICULO</th>
                      <th>CONDUCTOR</th>
                      <th>ESTATUS</th>
                      <th>F. MIGRADO</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID_OFFICE</th>
                      <th>DNI</th>
                      <th>NOMBRES</th>
                      <th>APELLIDOS</th>
                      <th>HISTORICO</th>
                      <th>DOCUMENTOS</th>
                      <th>VEHICULO</th>
                      <th>CONDUCTOR</th>
                      <th>ESTATUS</th>
                      <th>F. MIGRADO</th>
                    </tr>
                  </tfoot>
              </table>
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

<div class="modal fade" id="modal-cargando" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-body">
          <div class="box-body">

          <div class="row" align="center">
            <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" alt="User Image">
            <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modal-viewApiMeta" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="panel-heading">Aprobar Conductor / Migrar a Aplicativo</div>
      </div>

      <div class="modal-body">
          <div class="box-body">
              <div class="row datosSend">
                <form id="formAprobar" action="" method="post">
                {!! Form::hidden('tenantId', null,['id'=>'tenantId', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                {!! Form::hidden('id_file_drivers_send', null,['id'=>'id_file_drivers_send', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}

                 <div class="form-group col-sm-6">
                    {!! Form::label('serviceTypeList', 'Tipo de Servicio:') !!}
                    <select  style="width: 100%;"  multiple="" id="serviceTypeList" name="serviceTypeList"></select>
                  </div>

                  <div class="form-group col-sm-6">
                      {!! Form::label('vehicleTypeList', 'Clase de Vehiculo:') !!}
                      <select style="width: 100%;" id="vehicleTypeList" name="vehicleTypeList"></select>
                  </div>

                  <div class="form-group" align="center">
                      {!! Form::label('serviceAreaList', 'Area de Servicio:') !!}
                      <select class="form-control select2" multiple="" style="width: 70%;" id="serviceAreaList" name="serviceAreaList"></select>
                  </div>
                </div>
                <div class="row waiting" align="center" style="display:none">
                  <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" alt="User Image">
                  <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
                </div>
        </div>
      </div>

      <div class="modal-footer datosSend">
        <div><a type="button" class="btn btn-success pull-left" onclick="getDataSending();">APROBAR</a></div>
        </form>
        <button type="button" class="btn btn-danger fa fa-close" data-dismiss="modal"> Salir</button>
      </div>
    </div>
  </div>
</div>

</section>

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



  <script src="{{ asset('js/External/Driver/aprovedlist.js')}} "></script>

@endsection
