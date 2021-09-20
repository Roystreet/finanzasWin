@extends('layouts.app')
@section('title', 'Listado de Carreras')
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
<meta name="csrf-token" content="{{ csrf_token() }}">
{{--  inicio de la cabecera --}}

<div class="row" >
  <div class="col-xs-12 col-sm-6">
     <table id="facturacion" name="facturacturacion"  width="100%" align="left">
       <tr>
         <td colspan="4" height="20px"><pre><i class="fa fa-child"></i> - <b>Datos de facturación</b></pre></td>
       <tr>
       {{-- <tr>
         <th>Lugar</th>
          <td> Lima - Perú</td>
          <th>Fecha</th>
          <td>{{date('Y-m-d')}}</td>
        </tr>

       <tr>
         <th>Notas: </th>
           <td colspan="3">
            <textarea class="form-control" rows="3" id="note"></textarea>
           </td>
        </tr>

        <tr>
          <th> Cuenta a depositar:</th>
           <td colspan="3">
               {!!Form::select('donate', ['1'=>'Interback(1234564685)'], 'FALSE', ['id'=>'donate','class'=>'form-control select2'])!!}
             {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
               Listar Cuentas
             </button>
           </td>
       </tr> --}}
       <tr>
         <th>Monto total de las carreras:</th>
           <td >
            <span id="mount_total"></span>
           </td>
           <th>Monto total de Retención</th>
             <td>
              <span id="mount_ret"></span>
            </td>
      </tr>
      <tr>
        <th>Monto total a abonar:</th>
          <td colspan="3">
           <h3><span id="mount_abo"></span><h3>
          </td>
     </tr>
     </table>
   </div>



   </div>

   {{-- fin de la cabezera --}}

   <div class="row">
     <h3>Listado de las carreras faltantes por pagar</h3>
   </div>

{{-- inicio de la tabla carreras --}}
<table id="carreras"  class="display responsive nowrap">
  <thead class="thead-dark">
    <tr>
      <th>Licencia</th>
      <th>Apellidos</th>
      <th>Nombres</th>
      <th>Fecha de carrera</th>
      <th>Estado</th>
      <th>Retención(%)</th>
      <th>Monto Retención</th>
      <th>Monto Abonar por carrera</th>
      <th>Total Pago</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
  <tfoot class="thead-dark">
    <tr>
      <th>Licencia</th>
      <th>Apellidos</th>
      <th>Nombres</th>
      <th>Fecha de carrera</th>
      <th>Estado</th>
      <th>Retención(%)</th>
      <th>Monto Retención</th>
      <th>Monto Abonar por carrera</th>
      <th>Total Pago</th>
    </tr>
  </tfoot>
</table>

{{-- fin de la tabla carreras --}}



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

<script src="{{ asset('js/Cobranza/payBlock.js')}} "></script>
@endsection
