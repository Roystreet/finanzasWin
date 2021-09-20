@extends('layouts.app')
@section('title', 'Listado de Clientes')
@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

@endsection

@section('content')
<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Listado de Usuarios RED</h3>
    </div>
    <div class="box-body">
      <div class="hero-callout">
        <table id="netusers" name="netusers"  class="display responsive nowrap">
        <thead>
          <tr>
           <th width="5%">Accion</th>
					 <th width="5%">Usuario</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Sponsor</th>
           <th width="5%">Parent</th>
           <th width="5%">Estatus</th>
         </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
         <tr>
					 <th width="5%">Accion</th>
					 <th width="5%">Usuario</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Sponsor</th>
           <th width="5%">Parent</th>
           <th width="5%">Estatus</th>
         </tr>
        </tfoot>
      </table>
      </div>
    </div>
  </div>
</section>

@endsection






@section('js')

<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script src="{{ asset('js/red/netusers.js')}} "></script>
<script src="{{ asset('plugins/jquery/jquery.print.js') }}"></script>

@endsection
