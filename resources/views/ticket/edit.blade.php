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
    <link rel="stylesheet" href="/resources/demos/style.css">


@endsection

@section('content')
<section class="content">
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <table id="facturacion" name="facturacturacion"  width="100%" align="left">
    <tr>
      <td colspan="5" height="20px"><pre><i class="fa fa-child"></i> - <b>Datos de facturación</b></pre></td>
    </tr>
    <tr>
      <th>Codigo Ticket: </th>
        <td>
          <span id="id_ticket"></span>
        </td>

   </tr>
   <tr>
     <th>DNI</th>
       <td>
        <span id="document"></span>
      </td>
      <th>Apellidos y nombres :(Propietario actual)</th>
        <td >
         <span id="name"></span>
        </td>

  </tr>
  <tr>
    <th>Número de libro:</th>
      <td>
       <h3><span id="nro_book"></span><h3>
      </td>
  </tr>
  </table>
  <table id="facturacion" name="destino"  width="100%" align="left">
    <tr>
      <td colspan="5" height="20px"><pre><i class="fa fa-child"></i> - <b>Datos de destino</b></pre></td>
    </tr>
   <tr>
     <th>DNI: buscar</th>
       <td>
        <input type="text" name="" value="" id="dni_destino">
      </td>
      <th>Apellidos y nombres :(Destino)</th>
        <td >
         <span id="name_destino"></span>
        </td>

  </tr>

  </table>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
  Guardar
</button>

<input id="id_ticket_import" name="id_ticket_import" type="hidden" value="{{$id}}">
</section>


{{--  --}}

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Mensaje de confirmación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Está seguro de realizar los cambios?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="edit()">Sí</button>
        <button type="button" class="btn btn-primary">No,Cancelar</button>
      </div>
    </div>
  </div>
</div>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/Ticket/edit.js')}} "></script>
@endsection
