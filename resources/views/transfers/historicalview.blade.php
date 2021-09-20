@extends('layouts.app')
@section('title', 'Listado de Ticket')
@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">

  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

@endsection
@section('content')
<section class="content">
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <table  width="100%" align="left">
    <tr>
      <td colspan="5" height="20px"><pre><i class="fa fa-child"></i> - <b>Datos de ticket</b></pre></td>
    </tr>
    <tr>
      <th>Codigo Ticket: </th>
        <td>
          <span id="id_ticket">{{ $tickets[0]->getticket->cod_ticket}}</span>
        </td>

   </tr>
  <tr>
    <th>Número de libro:</th>
      <td>
       <h3><span id="nro_book">{{ $tickets[0]->getticket->nro_book }}</span><h3>
      </td>
  </tr>
  </table>

  <table  width="100%" align="left">
    <tr>
      <td colspan="5" height="20px"><pre><i class="fa fa-child"></i> - <b>Datos de customer actual</b></pre></td>
    </tr>
   <tr>
     <th>DNI</th>
       <td>
        <span id="document">{{ $tickets[0]->getcustomeract->document}}</span>
      </td>
      <th>Apellidos y nombres :(Propietario actual)</th>
        <td >
         <span id="name">{{ $tickets[0]->getcustomeract->first_name}} {{ $tickets[0]->getcustomeract->last_name }}</span>
        </td>

  </tr>
  </table>

  @foreach ($tickets as $ticket)
    <table width="100%" align="left">
      <tr>
        <td colspan="5" height="20px"><pre><i class="fa fa-child"></i> - <b>Datos de customer anterior</b></pre></td>
      </tr>
      <tr>
        <th>DNI</th>
          <td>
           <span id="document">{{ $ticket->getcustomerAnt->document}}</span>
         </td>
         <th>Apellidos y nombres :</th>
           <td >
            <span id="name">{{ $ticket->getcustomerant->first_name}} {{ $ticket->getcustomerant->last_name }}</span>
           </td>
           <th>Fecha de cambio:</th>
           <td>
            <span id="document">{{ $ticket->fecha}}</span>
          </td>
          <th>Responsable:</th>
          <td>
           <span id="document">{{ $ticket->getModifyBy->username}}</span>
         </td>

     </tr>
    </table>
  @endforeach


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
<script src="{{ asset('js/Transfers/historicalviewid.js')}} "></script>
@endsection
