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
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Listado de Tickets</h3>
    </div>
    <div class="box-body">
      <div class="hero-callout">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <table id="historicals" name="historicals"  class="table table-bordered table-striped">
        <thead>
          <tr>
           <th width="5%">Ver</th>
           <th width="5%">Codigo</th>
           <th width="5%">Numero de libro</th>
           <th width="5%">Nombre</th>
           <th width="5%">Apellido</th>
           <th width="5%">DNI</th>
           <th width="5%">Total</th>
         </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
         <tr>
           <th width="5%">Ver</th>
           <th width="5%">Codigo</th>
           <th width="5%">Numero de libro</th>
           <th width="5%">Nombre</th>
           <th width="5%">Apellido</th>
           <th width="5%">DNI</th>
           <th width="5%">Total</th>

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
<script src="{{ asset('js/Transfers/historicalview.js')}} "></script>
@endsection
