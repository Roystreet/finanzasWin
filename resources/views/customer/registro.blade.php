@extends('layouts.app')
@section('title', 'Registrar Cliente')

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
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyBqCfECYsTVmKVgqJW2MuG-nNeIM_Gj1cU",
    authDomain: "voucher-img.firebaseapp.com",
    databaseURL: "https://voucher-img.firebaseio.com",
    projectId: "voucher-img",
    storageBucket: "voucher-img.appspot.com",
    messagingSenderId: "264645547952"
  };
  firebase.initializeApp(config);
</script>
@endsection

@section('content')
<section class="content">
  <div class="box" style="padding: 35px;">

    <div class="box-header">
      <h3 class="box-title">Registro de Clientes</h3>
    </div>
    <div class="box-body">
      <form method="POST" action="" id="myform">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- inicio el accionista  --}}
          <div class="panel panel-primary">
              <div class="panel-heading"></div>
                <div class="panel-body">

               <div class="customer">
        				<div class="form-group">
        					<div class="row">
        						<div class="col-xs-6">
                      <label for="Datos">Cedula de identificación/DNI:</label>
        							<div class="input-group dniaccionista">
        								<div class="input-group-addon">
        									<i class="fa fa-500px"></i>
        								</div>
                        {!! Form::text('document', null,['id'=>'document', 'class'=>'form-control keyup-dni','placeholder' => 'DNI',
                          'onkeypress'=>'onKeyDownHandler(event);return ','maxlength'=>'80'] ) !!}

                        </div>
        						</div>

        				  </div>
        				</div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6"><label for="Datos">Nombres: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-user"></i>
                        </div>
                        {!! Form::text('first_name', null,['id'=>'first_name', 'class'=>'form-control','autofill'=>'off',
                          'placeholder' => 'Nombres','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}                      </div>
                    </div>
                    <div class="col-xs-6"><label for="Datos">Apellidos: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-user"></i>
                        </div>
                        {!! Form::text('last_name', null,['id'=>'last_name', 'class'=>'form-control',
                          'placeholder' => 'Apellidos','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6"><label for="Datos">Telefono: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-phone"></i>
                        </div>
                        {!! Form::text('phone', null,['id'=>'phone', 'class'=>'form-control',  'placeholder' => '917.000.00'
                          ,'onkeypress'=>'return validaNumericos(event)','maxlength'=>'30'] ) !!}                      </div>
                    </div>
                    <div class="col-xs-6"><label for="Datos">Correo: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-envelope-o"></i>
                        </div>
                        {!! Form::email('email', null,['id'=>'email', 'class'=>'form-control keyup-email', 'placeholder' => 'ejemplo@dominio.com'] ) !!}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6"><label for="Datos">Pais: <code>*Obligatorio</code></label>
                      <div class="input-group pais">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        {!! Form::select('cod_country', $country, null, ['id'=>'cod_country','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                      </div>
                    </div>
                    <div class="col-xs-6 depval"><label for="Datos">Departamento: <code>*Obligatorio</code></label>
                      <div class="input-group departamento">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        {!! Form::select('cod_state', ['placeholder' => 'Selecciona'], null,['id'=>'cod_state',            'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group proval">
                  <div class="row">
                    <div class="col-xs-6"><label for="Datos">Provincia: <code>*Obligatorio</code></label>
                      <div class="input-group provincia">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        {!! Form::select('cod_city', ['placeholder' => 'Selecciona'], null,['id'=>'cod_city', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                      </div>
                    </div>
                    <div class="col-xs-6"><label for="Datos">Dirección: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        {!! Form::textarea('district', null,['id'=>'district', 'class'=>'form-control', 'value'=> old('district'),  'placeholder'=>'Av/Calle/Edificio...', 'rows'=>'2'] ) !!}
                      </div>
                    </div>
                  </div>
                </div>

        			</div>
              <br>
              </div>  <!--  fin panel-body -->
          </div> <!--  fin panel-primary -->
        {{-- termina el accionista --}}
        <div class="form-group" align="center">
          <input type="button" id="btnCreateShareholder" data-form="fCreateSahreHolder" class="btn btn-success btn_ajax" value="Registrar">
        </div>
      </form>
    </div><!-- box body -->
</div><!-- box -->
{{--  --}}

<div class="modal fade docs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content ">
      <div class="bg-successe">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Registrando...</h5>
                </div>
                <div class="modal-body">
                  {{--  --}}
                          @include('load.loading')
                {{--  --}}
                </div>
      </div>

    </div>
  </div>
</div>
{{--  --}}
</section>
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
<script src="{{ asset('js/Customer/create.js')}}"></script>
{{--  --}}
@endsection
