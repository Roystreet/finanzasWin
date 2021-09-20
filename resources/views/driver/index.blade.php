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
  <div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">Itéms de Busqueda</h3>
    </div>

    <div class="box-body">
      <form  id="myform">
        {{ csrf_field() }}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Conductor</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                  {!! Form::select('id_customer', $customer, null,['id'=>'id_customer', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-check-circle"></i></div>
                  {!! Form::select('status_user', $status, null,['id'=>'status_user', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                  </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Placa</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-car"></i></div>
                  {!! Form::select('id_pay', $pay,     null,['id'=>'id_pay', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Anfitrion</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-car"></i></div>
                  {!! Form::select('id_invited_by', $customer, null,['id'=>'id_invited_by', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Responsable</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                  {!! Form::select('modified_by', $modified_by, null,['id'=>'modified_by', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Pais/Inversion</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                  {!! Form::select('id_country_inv', $country, null,['id'=>'id_country_inv', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Fecha/Creación</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  {!! Form::text('created_at', null,['id'=>'created_at', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
                  </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Fecha/Pago</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  {!! Form::text('date_pay', null,['id'=>'date_pay', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
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
          <div class="col-xs-6">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">N°Libro</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-book"></i></div>
                  {!! Form::text('num_libro', null,['id'=>'num_libro', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
                  </div>
                <div><span class="help-block" id="error"></span></div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div class="box-footer">
     <button type="button" class="btn btn-default" id="clean">Limpiar</button>
     <button type="button" class="btn btn-info pull-right" id="search">Buscar</button>
   </div>
   </form>
  </div>

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Listado de Conductores</h3>
      <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default">Registrar Chofer</button>

    </div>
    <div class="box-body">
      <div class="hero-callout">
        <table id="drivers" name="drivers"  class="display responsive nowrap">
        <thead>
          <tr>
           <th width="5%">Gestionar</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Telefono</th>
           <th width="5%">Correo</th>
           <th width="5%">Ruta/Provincia</th>
           <th width="5%">Modelo</th>
           <th width="5%">Placa</th>
           <th width="5%">Estatus</th>
         </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
         <tr>
           <th width="5%">Gestionar</th>
           <th width="5%">Nombres</th>
           <th width="5%">Apellidos</th>
           <th width="5%">DNI</th>
           <th width="5%">Telefono</th>
           <th width="5%">Correo</th>
           <th width="5%">Ruta/Provincia</th>
           <th width="5%">Modelo</th>
           <th width="5%">Placa</th>
           <th width="5%">Estatus</th>
         </tr>
        </tfoot>
      </table>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <form method="POST" id="myform">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="Datos">Pais:</label>
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                 {!! Form::select('id_country', $country, null,['id'=>'id_country', 'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
            </div>
          </div>
          <div class="form-group" id="divdocumento">
              <label for="Datos" id="titledocumento">Documento de Identidad:</label>
            <div class="input-group">
             <div class="input-group-addon">
               <i class="fa fa-500px"></i>
             </div>
              {!! Form::text('document', null,['id'=>'document', 'class'=>'form-control', 'placeholder' => '00000000'] ) !!}
            </div>
          </div>
          <div class="form-group" id="divdatos">
            <label for="Datos">Nombres - Apellidos:</label>
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  {!! Form::text('name', null,['id'=>'name', 'class'=>'form-control',  'placeholder' => 'Pablo Andres'] ) !!}
                 <div class="input-group-addon">
                   <i class="fa fa-user"></i>
                 </div>
                  {!! Form::text('lastname', null,['id'=>'lastname', 'class'=>'form-control', 'placeholder' => 'Castillo Suarez'] ) !!}
            </div>
          </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary validarDocumento">Siguiente</button>
        </form>
        </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-car">
  <div class="modal-dialog">
    <div class="modal-content">


      <div class="modal-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <h6>Por favor corrige los errores debajo:</h6>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ url('vehicle') }}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="Datos">Datos de Vehiculo: </label>
            {!! Form::hidden('id_driver', null,['id'=>'id_driver', 'class'=>'form-control'] ) !!}

            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-car"></i>
                  </div>
                  {!! Form::text('model_year', null,['id'=>'model_year', 'class'=>'form-control', 'placeholder' => 'Año. Ej:.2018'] ) !!}
                 <div class="input-group-addon">
                   <i class="fa fa-car"></i>
                 </div>
                  {!! Form::text('model', null,['id'=>'model', 'class'=>'form-control', 'placeholder' => 'Modelo. Ej:. Toyota'] ) !!}
            </div>

            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-car"></i>
                  </div>
                  {!! Form::text('color', null,['id'=>'color', 'class'=>'form-control', 'placeholder' => 'Color. Ej:.Negro'] ) !!}
                 <div class="input-group-addon">
                   <i class="fa fa-car"></i>
                 </div>
                  {!! Form::text('serial', null,['id'=>'serial', 'class'=>'form-control', 'placeholder' => 'Serial. Ej:. ACBAUJ585SAJHD5'] ) !!}
            </div>
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-car"></i>
                  </div>
                  {!! Form::text('plate', null,['id'=>'plate', 'class'=>'form-control', 'placeholder' => 'Placa. Ej:.A-858A'] ) !!}
            </div>
            <div class="input-group">
             <div class="input-group-addon">
               <i class="fa fa-car"></i>
             </div>
             {!! Form::textarea('note', null,['id'=>'note', 'class'=>'form-control',  'placeholder'=>'Observaciones/Notas...', 'rows'=>'2'] ) !!}
            </div>


          </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        </div>

    </div>
  </div>
</div>
@endsection






@section('js')
<script src="{{ asset('plugins/jqueryvalidate/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jqueryvalidate/jquery.validate.min.js') }}"></script>

<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>



<script src="{{ asset('js/Driver/index.js')}} "></script>
@endsection
