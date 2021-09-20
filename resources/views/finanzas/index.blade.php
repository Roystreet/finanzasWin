@extends('layouts.app')
@section('title', 'Listado de Conductores')
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
      <h3 class="box-title">Listado de Conductores</h3>
      <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default">Registrar Chofer</button>

    </div>
    <div class="box-body">
      <div class="hero-callout">
        <table id="compras" name="compras"  class="display responsive nowrap">
        <thead>
          <tr>
           <th width="5%">Gestionar</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Telefono</th>
           <th width="5%">Correo</th>
           <th width="5%">Pais</th>
           <th width="5%">Estatus</th>
         </tr>
        </thead>
        <tbody>
          <!-- @foreach($drivers as $driver) -->
           <tr>
             <td align="center" width="5%">
               <a href="{{ route('driver.show', ['id' => $driver->id]) }}"><i class="fa fa-eye"></i></a>
               <a href="{{ route('driver.edit', ['id' => $driver->id]) }}"><i class="fa fa-edit"></i></a>
             </td>
             <td width="5%">{{ $driver->name }}</td>
             <td width="5%">{{ $driver->lastname }}</td>
             <td width="5%">{{ $driver->document }}</td>
             <td width="5%">{{ $driver->phone }}</td>
             <td width="5%">{{ $driver->email }}</td>
             <td width="5%" align="center">''</td>

             @if( $driver->status_user == 'TRUE')
                <td width="5%" align="center">Activo</i></td>
             @else
                <td width="5%" align="center">Inactivo</i></td>
              @endif
           </tr>
           @endforeach
        </tbody>
        <tfoot>
         <tr>
           <th width="5%">Gestionar</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Telefono</th>
           <th width="5%">Correo</th>
           <th width="5%">Pais</th>
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
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('js/Finanzas/compra.js')}} "></script>
@endsection
