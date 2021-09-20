@extends('layouts.app')
@section('title', 'Listado de Ticket')
@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/loading.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
@endsection

@section('content')
<section class="content">
  <div  name="ticket" class="box">
  		<div class="box-body">

  		    <div class="box-header">
  		      <h3 class="box-title">Listado de Tickets(Sin Activar)</h3>
  		    </div>
          <meta name="csrf-token" content="{{ csrf_token() }}">

  					<table id="tickets" name="tickets"  class="table table-bordered table-striped">
  	        <thead>
  	          <tr>
               <th>Ver</th>
  	           <th>Activar</th>
  	           <th>Codigo</th>
  	           <th>Producto</th>
  						 <th>Cliente</th>
  						 <th>Pais Inversion</th>
  	           <th>Precio</th>
  						 <th>Cantidad</th>
  	           <th>Total</th>
               <th>Estatus</th>
               <th>Usuario</th>

  	         </tr>
  	        </thead>

  	        <tfoot>
  	         <tr>
               <th>Ver</th>
  	           <th>Activar</th>
  	           <th>Codigo</th>
  	           <th>Producto</th>
  						 <th>Cliente</th>
  						 <th>Pais Inversion</th>
  	           <th>Precio</th>
  						 <th>Cantidad</th>
  	           <th>Total</th>
               <th>Estatus</th>
               <th>Usuario</th>

  	         </tr>
  	        </tfoot>
  	      </table>
  		</div>
  	</div>
</section>
@endsection


@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/Ticket/activacion.js')}} "></script>
@endsection
