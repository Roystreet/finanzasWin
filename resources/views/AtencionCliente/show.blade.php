@extends('layout-backend')
@section('title', 'Service Desk')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
<section class="content-header"></section>

<section class="content">


<div class="box box-primary">

  <div class="box-header with-border">
    <h3 class="box-title">Itéms de Busqueda</h3>
    <div class="box-tools pull-right">
      <div class="tickets"><a href="/atencion/registerservice/0" class="btn btn-info pull-right">Registrar atencion</a></div>
      <button type="button" class="btn btn-box-tool" data-widget="collapse" id="ids"><i class="fa fa-minus"></i></button>
    </div>
  </div>

  <div class="box-body">
    <form  id="myform">
      {{ csrf_field() }}
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="row">
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Creado</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-check-circle"></i></div>
                <select class="form-control select2" name="created_by" id="created_by" style='width: 80%'>
                  <option>Seleccionar</option>
                  <option value="1">Yo</option>
                  <option value="2">Asignados a mi</option>
                </select>
                </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
        <?php
          if ($verAdmin == true || $superUser == true){
        ?>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Agentes</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                {!! Form::select('modified_by', $modified_by, null,['id'=>'modified_by', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Tipo</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-check-circle"></i></div>
                {!! Form::select('status_user', $Type, null,['id'=>'status_user', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Cliente</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                {!! Form::select('id_customer', $customer, null,['id'=>'id_customer', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-check-circle"></i></div>
                {!! Form::select('id_statusT', $statusT, null,['id'=>'id_statusT', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Pais</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                {!! Form::select('id_country', $country, null,['id'=>'id_country', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">N°Ticket</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                {!! Form::text('num_ticket', null,['id'=>'num_ticket', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
                </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
        <?php
          if ($superUser == true){
        ?>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Areas</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                {!! Form::select('group', $groups, null,['id'=>'group', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
  </div>

  <div class="box-footer">
   <button type="button" class="btn btn-default" id="clean">Limpiar</button>
   <button type="button" class="btn btn-info pull-right" id="search">Buscar</button>
 </div>
 </form>
</div>

<div class="box box-info">
 <div class="box-header with-border">
   <h3 class="box-title">Lista de registros</h3>
 </div>

 <div class="box-body">
   <div class="hero-callout">
     <table id="servicedesk"  class="table table-bordered table-striped">
       <thead>
           <tr>
             <th >Canal</th>
             <th >Fecha</th>
             <th >N° Ticket</th>
             <th >Tipo</th>
             <th >Asunto</th>
             <th >Area</th>
             <th >Asignado</th>
             <th >Nombre</th>
             <th >Apellidos</th>
             <th >Estado</th>
             <th >Imprimir</th>
             <th >Ver</th>
           </tr>
       </thead>
       <tbody>

     </tbody>
     <tfoot class="thead-dark">
       <tr>
         <th >Canal</th>
         <th >Fecha</th>
         <th >N° Ticket</th>
         <th >Tipo</th>
         <th >Asunto</th>
         <th >Area</th>
         <th >Asignado</th>
         <th >Nombre</th>
         <th >Apellidos</th>
         <th >Estado</th>
         <th >Imprimir</th>
         <th >Ver</th>
       </tr>
     </tfoot>
 </table>
    </div>
  </div>

</div>

</section>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{ asset('js/AtencionCliente/show.js') }}"></script>
@endsection
