@extends('layouts.app')
@section('title', 'Listado de Carreras')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">

  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />



@endsection

@section('content')
<section class="content">

  <div class="box box-primary">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{ csrf_field() }}
    <div class="box-header with-border">
      <h3 class="box-title">Itéms de Busqueda</h3>
    </div>

    <form role="form">
    <div class="box-body">
      <div class="form-group">
        <label>Rango de Fechas: </label>
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
          <input type="text" class="form-control pull-right" id="range_date_ride">
        </div>
      </div>

      <div class="form-group">
        <label>Porcentaje de Retención: </label>
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-calculator"></i></div>
          <input type="text" class="form-control pull-right" id="porcentaj_ret" value="12.5">
        </div>
      </div>
    </div>


  <div class="box-footer">
  <div class="form-group">
  <div class="input-group">
  <button type="button" class="btn btn-primary" id="searchRides" >Procesar</button>
  </div>
  </div>
  </div>
  </div>





           <div class="box box-info">
             <div class="box-header with-border">
               <h3 class="box-title">Listado de Usuarios</h3>
               <div class="box-tools pull-right">
                 Seleccionas todas de esta pagina  <input type="checkbox" name="select-all" id="select-all" />
               </div>
             </div>

             <div class="box-body">
               <div class="hero-callout">

                  <table id="carreras"  class="display responsive nowrap">
                    <thead class="thead-dark">
                      <tr>
                        <th>Check</th>
                        <th>N°Carrera</th>
                        <th>Codigo</th>
                        <th>Licencia</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>TpMoneda</th>
                        <th>Pais</th>
                        <th>TpPago</th>
                        <th>Fecha de Carera</th>
                        <th>Pago</th>
                        <th>% Ret</th>
                        <th>Mto Comision</th>
                        <th>Mto Abonar</th>
                        <th>Estatus</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot class="thead-dark">
                      <tr>
                        <th>Check</th>
                        <th>N°Carrera</th>
                        <th>Codigo</th>
                        <th>Licencia</th>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>TpMoneda</th>
                        <th>Pais</th>
                        <th>TpPago</th>
                        <th>Fecha de Carera</th>
                        <th>Pago</th>
                        <th>% Ret</th>
                        <th>Mto Comision</th>
                        <th>Mto Abonar</th>
                        <th>Estatus</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="box-footer">

                  <div class="form-group">
                    <div class="input-group">
                      <button type="button" class="btn btn-primary" id="allRides" >Generar Orden</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>




</section>

@endsection






@section('js')

  <script src="{{ asset('plugins/jqueryvalidate/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/jqueryvalidate/jquery.validate.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>


  <!-- date-range-picker -->
  <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="../../bower_components/moment/min/moment.min.js"></script>
  <script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="../../plugins/iCheck/icheck.min.js"></script>


  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>


  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>

<script src="{{ asset('js/Cobranza/doOrderPay.js')}} "></script>
@endsection
