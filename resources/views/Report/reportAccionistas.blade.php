@extends('layouts.app')
@section('title', 'Listado de Accionistas')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>

  <style>
  .ui-autocomplete { z-index:2147483647 !important; }
</style>
@endsection

@section('content')

<div  name="accionistas" class="box">
  <div class="box-body">
      <div class="box-header">
        <h3 class="box-title">Listado de accionistas</h3>
      </div>
        <table id="accionistas" name="books"  class="table">
        <thead>
          <tr>
           <th width="5%">Documento</th>
           <th width="5%">nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">Correo</th>
           <th width="5%">Telefono</th>
           <th width="5%">Pais</th>
           <th width="5%">Id_customer</th>
           <th width="5%">Acciones_post</th>
         </tr>
        </thead>
        <tfoot>
         <tr>
           <th width="5%">Documento</th>
           <th width="5%">nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">Correo</th>
           <th width="5%">Telefono</th>
           <th width="5%">Pais</th>
           <th width="5%">Id_customer</th>
           <th width="5%">Acciones_post</th>
         </tr>
        </tfoot>
      </table>
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
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="{{ asset('js/Report/reportAccionistas.js')}} "></script>
@endsection
