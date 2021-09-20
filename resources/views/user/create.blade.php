@extends('layouts.app')
@section('title', 'Registrar Usuarios')

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<!-- include a theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />

@endsection

@section('content')


<section class="content-header">
  <a href="{{ route('user.index') }}"  class="btn btn-info pull-right">Listado</a><br><br>
</section>

<section class="content">
  <div class="box" style="padding: 35px;">

    <div class="box-body">
      <form method="POST" action="{{ url('/usernew') }}"  id="myform">
        {{ csrf_field() }}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Inicio: Usuario  --}}
          <div class="panel panel-primary">
            <div class="panel-heading">Usuario</div>
          </div> <!--  fin panel-primary -->

            <div class="row">
              <div class="col-xs-6"><label for="Datos">Nombres:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa  fa-user"></i></div>
                      {!! Form::text('first_name', null,['id'=>'first_name', 'class'=>'form-control required lettersonly', 'autofill'=>'off',  'placeholder' => 'Nombres','maxlength'=>'80']) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                </div>
                </div>
              <div class="col-xs-6"><label for="Datos">Apellidos:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa  fa-user"></i></div>
                      {!! Form::text('last_name', null,['id'=>'last_name', 'class'=>'form-control  required lettersonly ', 'placeholder' => 'Apellidos','maxlength'=>'80'] ) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                  </div>
                </div>
            </div> <!--  fin row -->

            <div class="row">
              <div class="col-xs-6"><label for="Datos">Cedula de identificación/DNI:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-500px"></i></div>
                      {!! Form::text('document', null,['id'=>'document', 'class'=>'form-control required digits','placeholder' => 'DNI','maxlength'=>'11'] ) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                </div>
                </div>
              <div class="col-xs-6"><label for="Datos">Fecha de Nacimiento:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        {!! Form::text('birthdate', date('Y-m-d') ,['id'=>'birthdate', 'class'=>'form-control required']) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                  </div>
                </div>
            </div> <!--  fin row -->

            <div class="row">
              <div class="col-xs-6"><label for="Datos">Telefono:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                      {!! Form::text('phone', null,['id'=>'phone', 'class'=>'form-control required digits',  'placeholder' => '917.000.00', 'maxlength'=>'11'] ) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                </div>
                </div>
              <div class="col-xs-6"><label for="Datos">Correo:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                      {!! Form::email('email', null,['id'=>'email', 'class'=>'form-control required email', 'placeholder' => 'ejemplo@dominio.com'] ) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                  </div>
                </div>
            </div> <!--  fin row -->

            <div class="row">
              <div class="col-xs-6"><label for="Datos">Pais:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-marker"></i></div>
                      {!! Form::select('cod_country', $country, null, ['id'=>'cod_country','placeholder'=>'Selecciona' ,'class'=>'form-control select2 required', 'style'=>'width: 100%'] ) !!}
                      <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                </div>
                </div>
              <div class="col-xs-6"><label for="Datos">Dirección:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-marker"></i></div>
                      {!! Form::textarea('address', null,['id'=>'address', 'class'=>'form-control required', 'value'=> old('address'),  'placeholder'=>'Av/Calle/Edificio...', 'rows'=>'2'] ) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                  </div>
                </div>
            </div> <!--  fin row -->

            <div class="row">
              <div class="col-xs-6"><label for="Datos">Usuario:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-user"></i></div>
                      {!! Form::text('username', null,['id'=>'username', 'class'=>'form-control keyup-dni','placeholder' => 'jperez','onkeypress'=>'','maxlength'=>'11'] ) !!}
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                </div>
                </div>
              <div class="col-xs-6"><label for="Datos">Contraseña:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-key"></i></div>
                      <input type="password" id="password" name="password" class="form-control"  placeholder="***********">
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                  </div>
                </div>
            </div> <!--  fin row -->

            <div class="row">
              <div class="col-xs-6"><label for="Datos">Sexo:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-venus-double"></i></div>
                        <label class="radio-inline">  {!! Form::radio('gender', 'F') !!} Mujer </label>
                        <label class="radio-inline">  {!! Form::radio('gender', 'M') !!} Hombre </label>
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                </div>
                </div>
              <div class="col-xs-6"><label for="Datos">Roles:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-cogs"></i></div>
                      {!! Form::select('id_rol', $roles, null, ['id'=>'id_rol', 'name'=>'id_rol[]', 'class'=>'form-control select2', 'multiple'=>'multiple', 'style'=>'width: 100%'] ) !!}
                      <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                  </div>
                </div>
            </div> <!--  fin row -->

        {{-- Fin:  Usuario --}}


        <div class="form-group" align="center">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        <div class="form-group"><div class="col-xs-6"><label for="Datos">Nota: <code>Los campos con (*) son obligatorios</code></label></div></div>

      </form>
    </div><!-- box body -->
  </div><!-- box -->
</section>








@endsection

@section('js')

<script src="{{ asset('plugins/jqueryvalidate/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jqueryvalidate/jquery.validate.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>
<script src="{{ asset('js/User/create.js')}}"></script>

@endsection
