@extends('layouts.app')
@section('title', 'Listado de Saldo - AppWIN')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />

@endsection

@section('content')

<section class="content-header"></section>

<section class="content">

<div class="box box-info">
 <div class="box-header with-border">
   <h3 class="box-title">Listado de Recargas</h3>
 </div>

 <div class="box-body">
   <div class="hero-callout">
      <table id="saldo"  class="display compact nowrap" >
        <thead class="thead-dark">
          <tr>
            <th>Licencia</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Pais</th>
            <th>Moneda</th>
            <th>Saldo</th>
            <th>Aproved</th>
            <th>Blocked</th>

          </tr>
        </thead>
        <tbody>
          <div class="loader"></div>
        </tbody>
        <tfoot class="thead-dark">
          <tr>
            <th>Licencia</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Pais</th>
            <th>Moneda</th>
            <th>Saldo</th>
            <th>Aproved</th>
            <th>Blocked</th>

          </tr>
        </tfoot>
      </table>
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

</section>





@endsection

@section('js')

  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

  <script src="{{ asset('js/CapitalDriver/indexApp.js')}} "></script>

@endsection
