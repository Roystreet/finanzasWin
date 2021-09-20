@extends('layouts.app')
@section('title', 'Listado de Ordenes')
@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">

  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">

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
          <input type="text" class="form-control pull-right" id="range_date">
        </div>
      </div>

      <div class="form-group">
        <label>Numero de Orden: </label>
        <div class="input-group">
          <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
          <input type="text" class="form-control pull-right" id="cod_order">
        </div>
      </div>
    </div>


    <div class="box-footer">
      <div class="form-group">
        <div class="input-group">
          <button type="button" class="btn btn-primary" id="search" >Buscar</button>
        </div>
      </div>
    </div>

  </div>



 <div class="box box-info">
   <div class="box-header with-border">
     <h3 class="box-title">Listado de Ordenes</h3>
   </div>

   <div class="box-body">
     <div class="hero-callout">

        <table id="orders"  class="display responsive nowrap">
          <thead class="thead-dark">
            <tr>
              <th>Accion</th>
              <th>Codigo</th>
              <th>Forma de Pago</th>
              <th>Moneda</th>
              <th>Total</th>
              <th>Mto Comision</th>
              <th>Mto Abonar</th>
              <th>CantCarreras</th>
              <th>Estatus</th>
              <th>Pagado</th>
              <th>Creado</th>
              <th>Estatus</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot class="thead-dark">
            <tr>
              <th>Accion</th>
              <th>Codigo</th>
              <th>Forma de Pago</th>
              <th>Moneda</th>
              <th>Total</th>
              <th>Mto Comision</th>
              <th>Mto Abonar</th>
              <th>CantCarreras</th>
              <th>Estatus</th>
              <th>Pagado</th>
              <th>Creado</th>
              <th>Estatus</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>






</section>

@endsection






@section('js')

<script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>


<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<!-- date-range-picker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="{{ asset('js/Cobranza/index.js')}} "></script>
@endsection
