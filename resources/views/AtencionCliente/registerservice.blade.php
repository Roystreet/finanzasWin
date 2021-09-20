@extends('layout-backend')
@section('title', 'Registrar Ticket')

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
{{-- <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css"> --}}
<!-- include the style -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<!-- include a theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
<link href="{{ asset('plugins/clock/clockpicker.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/typeahead.css') }}">

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
<section class="content-header"></section>

<section class="content">


<div class="box box-primary">

  <div class="box-header with-border">
    <h3 class="box-title">TICKET DE SERVICE DESK</h3>
    <div id="timer">
          <div class="container" style="display: flex;">
              <div id="hour">00</div>
              <div class="divider">:</div>
              <div id="minute">00</div>
              <div class="divider">:</div>
              <div id="second">00</div>
          </div>
      </div>
  </div>



  <div class="box-body">
    <form  id="myform"enctype="multipart/form-data">
      {{ csrf_field() }}
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="row">
        <label class="col-md-2 col-md-offset-2 atepren" data-id="{{$idatt}}" for="pwd">Gestionado:</label>
        <div class="col-md-5">
          <div class="radio" id="divRadios">
                    <label class="col-md-5">
                      <input type="radio" name="gestionado" value="Pasajero" <?php echo $ckecked == 3 ? "checked" : "" ?>>
                      Pasajero
                    </label>
                    <label class="col-md-5">
                      <input type="radio" name="gestionado" value="Conductor" <?php echo $ckecked == 2 ? "checked" : "" ?>>
                      Conductor
                    </label>
                    <label class="col-md-5 gestemerg">
                      <input type="radio" name="gestionado" value="Accionista" <?php echo $ckecked == 4 ? "checked" : "" ?>>
                      Accionista
                    </label>
                    <label class="col-md-5 gestemerg">
                      <input type="radio" name="gestionado" value="Nuevo" <?php echo $ckecked == 1 ? "checked" : "" ?>>
                      Nuevo Cliente
                    </label>
                    <label class="col-md-5 gestemerg">
                      <input type="radio" name="gestionado" value="Embajador" <?php  echo $ckecked == 5 ? "checked" : "" ?>>
                      Embajador
                    </label>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <label class="col-md-2 col-md-offset-2" for="pwd">Canal de gestión:</label>
        <div class="col-md-5">
          <select id="typeTK" name="typeTK" class='form-control select2' style='width: 80%'>
              <option>Seleccionar</option>
              <option value="1" <?php echo $idatt > 0 ? "selected" : "" ?>>Presencial</option>
              <option value="2">Llamada</option>
              <option value="3">Chat</option>
              <option value="4">Correo electronico</option>
          </select>
        </div>
      </div>
      <br>


      <div class="row">
        <label class="col-md-2 col-md-offset-2" for="pwd">Tipo:</label>
        <div class="col-md-5">
          {!! Form::select('status_user', $status, null,['id'=>'status_user', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
        </div>
      </div>
      <br>

      <div class="row">
        <label class="col-md-2 col-md-offset-2" for="pwd">Prioridad:</label>
        <div class="col-md-5">
          {!! Form::select('id_priority', $priorities, $priorityv,['id'=>'id_priority', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
        </div>
      </div>
      <br>

      <div class="row" id="checkticket">
        <label class="col-md-2 col-md-offset-2" for="pwd">Crear ticket?:</label>
        <div class="col-md-5">
          <input type="checkbox" name="checkticket" id="checticket">
        </div>
      </div>


      <div class="row">
        <label class="col-md-2 col-md-offset-2" for="pwd">Area:</label>
        <div class="col-md-5" >
          {!! Form::select('group', $groups, null,['id'=>'group', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
        </div>
      </div>
      <br>

      <div class="row emergencyapp">
        <label class="col-md-2 col-md-offset-2" for="pwd">ID Viaje:</label>
        <div class="col-md-5" >
          {!! Form::text('id_travel', 'B0000',['id_travel'=>'id_travel', 'class'=>'form-control','autofill'=>'off',
            'placeholder' => 'ID del viaje','maxlength'=>'9', 'style'=>'width: 80%'] ) !!}
        </div>
      </div>
      <br>

      <div class="row categoryDiv">
        <label class="col-md-2 col-md-offset-2" for="pwd">Categoria:</label>
        <div class="col-md-3">
                    {!! Form::select('category', ['placeholder' => 'Selecciona'], null,['id'=>'category', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
        </div>
        <code class="col-md-4" id="optioncategory" style="font-weight: bold !important;"></code>
      </div>
      <br>




      {{-- inicio el accionista  --}}
        <div class="panel panel-primary">
            <div class="panel-heading">Cliente</div>
              <div class="panel-body">
                {{--  inicio del contenedor customer--}}
             <div class="customer" style="">

              <div class="form-group">
                <div class="row">
                  <div style="display:none;" id="load_customer"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i></div>

                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <label for="Datos">Tipo de Documento de Identidad:<code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-search"></i>
                        </div>
                        {!! Form::select('type_docs', $type_docs, $typedniv, ['id'=>'type_docs','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                        </div>
                  </div>

                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                     <label for="Datos">Numero de Documento de Identidad:<code>*Obligatorio</code></label>
                      <div class="input-group dniaccionista" style="display: flex;">
                        <div class="input-group-addon">
                          <i class="fa fa-500px"></i>
                        </div>
                        {!! Form::text('dni', $dniv,['id'=>'dni', 'class'=>'form-control keyup-dni','placeholder' => 'Numero de documento de identidad',
                          'onkeypress'=>' ','maxlength'=>'20'] ) !!}
                          <button type="button" class="btn btn-primary" id="search_customer">Buscar</button>
                         <input type="hidden" name="idcust" id="idcust" value="{{$idcust}}">
                        </div>
                  </div>
                </div>
              </div>

              <div class="form-group register-data">
                <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Nombres: <code>*Obligatorio</code></label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa  fa-user"></i>
                      </div>
                      {!! Form::text('first_name', null,['id'=>'first_name', 'class'=>'form-control','autofill'=>'off',
                        'placeholder' => 'Nombres','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}                      </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Apellidos: <code>*Obligatorio</code></label>
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

              <div class="form-group register-data" id="register-data">
                <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Telefono: <code>*Obligatorio</code></label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      {!! Form::text('phone', null,['id'=>'phone', 'class'=>'form-control',  'placeholder' => '917.000.00'
                        ,'maxlength'=>'30'] ) !!}
                      </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Correo: <code>*Obligatorio</code></label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-envelope-o"></i>
                      </div>
                      {!! Form::email('email', null,['id'=>'email', 'class'=>'form-control keyup-email', 'placeholder' => 'ejemplo@dominio.com'] ) !!}
                    </div>
                  </div>

                </div>
              </div>

              <div class="form-group register-data">
                <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Fecha de nacimiento:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar-check-o"></i>
                      </div>
                      <input type="date" class="form-control" id="datebirth" name="datebirth" data-date-format="mm/dd/yyyy">
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Pais: <code>*Obligatorio</code></label>
                    <div class="input-group pais">
                      <div class="input-group-addon">
                        <i class="fa  fa-map-marker"></i>
                      </div>
                      {!! Form::select('cod_country', $country, null, ['id'=>'cod_country','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                    </div>
                  </div>
                </div>
              </div>


              {{--  Ocultar datos--}}
              <div class="customer-data-hide" >
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 depval"><label for="Datos">Departamento: <code>*Obligatorio</code></label>
                      <div class="input-group departamento">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        {!! Form::select('cod_state', ['placeholder' => 'Selecciona'], null,['id'=>'cod_state', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Provincia: <code>*Obligatorio</code></label>
                      <div class="input-group provincia">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        {!! Form::select('cod_city', ['placeholder' => 'Selecciona'], null,['id'=>'cod_city', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group proval">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Dirección: <code>*Obligatorio</code></label>
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
              <div class="driver-data-hide" >
                <hr>
                <h5>VEHICULO</h5>
                <hr>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Placa/Matricula: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="placa" name="placa">
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Marca: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="marca" name="marca">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Modelo: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="modelo" name="modelo">
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Color: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="color" name="color">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Año: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="year" name="year">
                      </div>
                    </div>
                  </div>
                </div>

                <hr>
                <h5>SEGURO</h5>
                <hr>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Tipo: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="typesafe" name="typesafe">
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Compañia: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="company" name="company">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Tipo de SOAT: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="text" class="form-control" id="typesoat" name="typesoat">
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Fecha Vigencia: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="date" class="form-control" id="soatemi" name="soatemi" data-date-format="yyyy/mm/dd">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Fecha Vencimiento: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-map-marker"></i>
                        </div>
                        <input type="date" class="form-control" id="soatven" name="soatven" data-date-format="mm/dd/yyyy">
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <br>
            </div>  <!--  fin panel-body -->
        </div> <!--  fin panel-primary -->
      {{-- termina el accionista --}}

      <div class="row" id="addthreeperson">
        <label class="col-md-offset-4 col-md-2 " for="pwd"></label>
        <div class="col-md-5">
          <input type="checkbox" name="checkCustomerExt" id="checkCustomerExt"> Agregar a tercero
        </div>
      </div>
      <br>

      {{-- termina el accionista exterior  --}}
        <div class="panel panel-primary customer-ext-data-hide" >
            <div class="panel-heading">Cliente Externo</div>
              <div class="panel-body">
                {{--  inicio del contenedor customer--}}
               <div class="customer_ext" style="">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                      <label for="Datos">Tipo de Documento de Identidad:<code>*Obligatorio</code></label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-search"></i>
                          </div>
                          {!! Form::select('type_docs_ext', $type_docs, null, ['id'=>'type_docs_ext','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                          </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                       <label for="Datos">Numero de Documento de Identidad:<code>*Obligatorio</code></label>
                        <div class="input-group" style="display: flex;">
                          <div class="input-group-addon">
                            <i class="fa fa-500px"></i>
                          </div>
                          {!! Form::text('dni_ext', null,['id'=>'dni_ext', 'class'=>'form-control keyup-dni','placeholder' => 'Numero de documento de identidad',
                            'onkeypress'=>' ','maxlength'=>'20'] ) !!}
                            <button type="button" class="btn btn-primary" id="search_customer_ext">Buscar</button>
                           <input type="hidden" id="idcust_ext" id="idcust_ext" value="">
                          </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Nombres: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-user"></i>
                        </div>
                        {!! Form::text('first_name_ext', null,['id'=>'first_name_ext', 'class'=>'form-control','autofill'=>'off',
                          'placeholder' => 'Nombres','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Apellidos: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-user"></i>
                        </div>
                        {!! Form::text('last_name_ext', null,['id'=>'last_name_ext', 'class'=>'form-control',
                          'placeholder' => 'Apellidos','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group" id="register-data">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Telefono: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-phone"></i>
                        </div>
                        {!! Form::text('phone_ext', null,['id'=>'phone_ext', 'class'=>'form-control',  'placeholder' => '917.000.00'
                          ,'maxlength'=>'30'] ) !!}
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Correo: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-envelope-o"></i>
                        </div>
                        {!! Form::email('email_ext', null,['id'=>'email_ext', 'class'=>'form-control keyup-email', 'placeholder' => 'ejemplo@dominio.com'] ) !!}
                      </div>
                    </div>

                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Fecha de nacimiento:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar-check-o"></i>
                        </div>
                        <input type="date" class="form-control" id="datebirth_ext" name="datebirth_ext" data-date-format="mm/dd/yyyy">
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">Parentesco:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                        </div>
                        <input type="text" class="form-control" id="relationship" name="relationship">
                      </div>
                    </div>
                  </div>
                </div>
               </div>
               {{--  fin del contenedor customer--}}
            </div>  <!--  fin panel-body -->
        </div> <!--  fin panel-primary -->
      {{-- termina el customer exterior--}}

      <div class="row emergencyapp">
        <label class="col-md-2 col-md-offset-2" for="pwd">Ubicación:</label>
        <div class="col-md-5" style="display: flex;">
          <input id="addressgoogle" class="form-control" type="textbox" value="Lima, ">
          <input id="submit" type="button" class="btn btn-primary" onclick="codeAddress()" value="buscar">
        </div>
      </div>
      <div class="row emergencyapp">
        <label class="col-md-2 col-md-offset-2" for="pwd">Referencia:</label>
        <div class="col-md-5">
            <input type="text" id="referenceubi" class="form-control" name="referenceubi" placeholder="referencia ubicacion">
        </div>
      </div>
        <div class="row emergencyapp">
          <label class="col-md-2 col-md-offset-2" for="pwd">Mapa:</label>
          <div class="col-md-5">
              <div id="map" style="height: 400px; width: 450px;"></div>
              <input type="hidden" id="ubication" name="ubication" value="">
          </div>
        </div>

      <br>

      <div class="row groupsval">
        <label class="col-md-2 col-md-offset-2" for="pwd">Asunto o Motivo:</label>
        <div class="col-md-5 subjectdiv">
          {!! Form::text('subject', null,['id'=>'subject'] ) !!}
        </div>
      </div>
      <br>

      <div id="regincidencias">
        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">Operador:</label>
          <div class="col-md-4">
            {!! Form::select('operator', $operators, null, ['id'=>'operator','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
          </div>
        </div>
        <br>

        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">¿Utiliza el aplicativo en una red Wi-Fi?:</label>
          <div class="col-md-5">
                <div class="radio" >
                    <label>
                      <input type="radio" name="appred" id="appred1" value="TRUE">
                      Si
                    </label>
                  </div>
                  <div class="radio">
                      <label>
                        <input type="radio" name="appred" id="appred2" value="FALSE">
                        No
                      </label>
                    </div>
            </div>
        </div>
        <br>

        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">Marca del equipo:</label>
          <div class="col-md-4">
            {!! Form::select('brand', $brands, null, ['id'=>'brand','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
          </div>
        </div>
        <br>

        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">Modelo del equipo:</label>
          <div class="col-md-5">
            {!! Form::text('model', null,['id'=>'model', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
          </div>
        </div>
        <br>

        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">Sistema operativo:</label>
          <div class="col-md-5">
                <div class="radio" >
                    <label>
                      <input type="radio" name="OS" id="OS1" value="1">
                      Android
                    </label>
                  </div>
                  <div class="radio">
                      <label>
                        <input type="radio" name="OS" id="OS2" value="0">
                        IOS
                      </label>
                    </div>
            </div>
        </div>
        <br>

        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">Versión del Sistema operativo:</label>
          <div class="col-md-5">
            {!! Form::text('veros', null,['id'=>'veros', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
          </div>
        </div>
        <br>
      </div>

      <div id="regincidentsecurity">
        <div class="row groupsval">
          <label class="col-md-2 col-md-offset-2" for="pwd">Lugar del incidente:</label>
          <div class="col-md-5 subjectdiv">
            {!! Form::text('placeincident', null,['id'=>'placeincident','class'=>'form-control', 'style'=>'width: 80%'] ) !!}
          </div>
        </div>
        <br>
      </div>

      <div id="regincidents">
        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">Fecha del incidente:</label>
          <div class="col-md-5">
            {!! Form::date('fechven', null,['id'=>'fechven', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
          </div>
        </div>
        <br>

        <div class="row">
          <label class="col-md-2 col-md-offset-2" for="pwd">Hora (aproximada) del incidente:</label>
          <div class="col-md-5">
            {!! Form::time('hourven', null,['id'=>'hourven', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
          </div>
        </div>
        <br>
      </div>

      <div class="row">
        <label class="col-md-2 col-md-offset-2" for="pwd">Descripción o Detalle: <br> Intente ser lo mas detallado posible.</label>
        <div class="col-md-5">
          {!! Form::textarea('description', null,['id'=>'description', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
        </div>
      </div>
      <br>

      <div class="row">
        <label class="col-md-2 col-md-offset-2" for="pwd">Agregar archivo:</label>
        <div class="col-md-4">
          <input type='file' id='myFile' class="form-control" id="myFile" name="myFile" >
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-12 text-center">
          <button type="button" id="btn_env" class="btn btn-success">Enviar</button>
        </div>
        <div class="col-sm-2"></div>
      </div>
      <br>



  </div>
 </form>
</div>
</section>

<!-- Animación de carga de documento -->
<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 9999999; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
  <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
    <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
  </div>
</div>


@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
{{-- <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> --}}
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>
<script src="{{ asset('plugins/clock/clockpicker.js')}}"></script>
<script src="{{ asset('js/AtencionCliente/typeahead.min.js')}}"></script>
<script src="{{ asset('js/AtencionCliente/register.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9LCCfUHXYRZJEYOJcynZdl2M89DuA-do"></script>
<script>

  function initialize() {
    $('#map').html('');
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-11.9958973, -77.0781772);
    var mapOptions = {
      zoom: 16,
      center: latlng,
      disableDefaultUI: true
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    //para que aparezca la imagen con ubicacion
  //   var marcador = new google.maps.Marker({
  //     position: latlng,
  //     map: map,
  //     title: 'emergencia'
  // });

  }


  function codeAddress() {

    var address = $('#addressgoogle').val();

    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
        $('#ubication').val(results[0].geometry.location);
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

  $(document).ready(function() {
    var geocoder;
    var map;
    initialize();
  });


</script>

{{--  --}}
@endsection
