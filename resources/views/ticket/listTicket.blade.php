@extends('layouts.app')
@section('title', 'Editar')
@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">

  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
  <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link  href="/resources/demos/style.css">


@endsection

@section('content')
<section class="content">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <table id="tickets" name="tickets"  class="">
  <thead>
    <tr>
     <th width="5%">Editar</th>
     <th width="5%">Codigo</th>
     <th width="5%">Nombre</th>
     <th width="5%">Apellido</th>
     <th width="5%">DNI</th>
     <th width="5%">Producto</th>
     <th width="5%">Fecha de Creaccion</th>
     <th width="5%">Moneda</th>
     <th width="5%">Total</th>
     <th width="5%">Estatus</th>

   </tr>
  </thead>
  <tbody>


  </tbody>
  <tfoot>
   <tr>
     <th width="5%">Editar</th>
     <th width="5%">Codigo</th>
     <th width="5%">Nombre</th>
     <th width="5%">Apellido</th>
     <th width="5%">DNI</th>
     <th width="5%">Producto</th>
     <th width="5%">Fecha de Creaccion</th>
     <th width="5%">Moneda</th>
     <th width="5%">Total</th>
     <th width="5%">Estatus</th>

   </tr>
  </tfoot>
</table>

</section>
@endsection






@section('js')

  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
  <script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>


{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
<script src="{{ asset('js/Ticket/list.js')}} "></script>
@endsection
