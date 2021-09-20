@extends('layouts.app')
@section('title', 'Cargar Cap. de Trabajo')
@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<!-- include a theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">




@endsection

@section('content')
<section class="content">

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Itéms de Busqueda</h3>
      <div id="searchDiv" style="display:none;"  class="box-tools pull-right">
        <button type="button"  id="searchAgain" class="btn btn-info btn-flat">Nueva Busqueda</button>
      </div>
    </div>

  <div class="box-body">

    <div id="search_panel">
      <label class="col-sm-2 control-label">Licencia: </label>
      <div class="form-group">
       <div class="col-sm-10">
         <div class="input-group">
           <div class="input-group-addon"><i class="fa fa-500px"></i></div>
           {!! Form::text('license_number', null,['id'=>'license_number', 'class'=>'form-control',  'placeholder' => 'Selecciona', 'style'=>'width: 100%'] ) !!}
           <span class="input-group-btn">
             <button type="button"  id="search" class="btn btn-info">Buscar</button>
           </span>
          </div>
          <label for="Datos">Nota:<code>Es requisito principal que el conductor este registrado en el aplicativo Taxi WIN</code></label>
          @if(Session::has('flash_message'))
            <div class='alert alert-success'>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>{{ Session::get('flash_message') }}</strong>
            </div>
        @endif
        </div>
      </div>
    </div>

    <div id="datos" style="display:none;" >
      <form method="POST" action="{{ url('/capitalDriver/addSaldo') }}"  id="myform">
        {{ csrf_field() }}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <table width="100%" align="left" style="table-layout:fixed" border="1">
          <tr>
            <td colspan="4" height="30px"><pre><i class="fa fa-user"></i> - <b>Datos Personales</b></pre></td>
          </tr>
          <tr>
            <th width="5%" height="35px"<div class="form-group"><label class="col-sm-2 control-label">Nombres</label></div></th>
            <td width="45%" height="35px"  id="first_name"></td>
            <th width="5%" height="35px" ><div class="form-group"><label class="col-sm-2 control-label">Correo</label></div></th>
            <td width="45%" height="35px"  id="email"></td>
          </tr>
          <tr>
            <th width="5%" height="35px" ><div class="form-group"><label class="col-sm-2 control-label">Apellidos</label></div></th>
            <td width="45%" height="35px"  id="last_name"></td>
            <th width="5%" height="35px" ><div class="form-group"><label class="col-sm-2 control-label">Telefono</label></div></th>
            <td width="45%" height="35px"  id="phone"></td>
          </tr>
          <tr>
            <th width="5%" height="35px">  <div class="form-group"><label class="col-sm-2 control-label">Licencia</label></div></th>
            <td width="45%" height="35px"  colspan="3" id="license"></td>
          </tr>
          <tr>
            <td colspan="4" height="15px"><pre><i class="fa fa-user"></i> - <b>Datos Obligatorios</b></pre></td>
          </tr>
          <tr>
            <td width="50%" height="35px" colspan="2">
              <label class="col-sm-2 control-label">DNI</label>
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-500px"></i></div>
                    {!! Form::text('document', null,['id'=>'document', 'class'=>'form-control', 'placeholder' => '99.9999.99', 'required' => 'required'] ) !!}
                    {!! Form::hidden('id_driver', null,['id'=>'id_driver', 'class'=>'form-control', 'required' => 'required'] ) !!}
                    {!! Form::text('route_img', null,['id'=>'route_img', 'class'=>'form-control'] ) !!}
                    {!! Form::text('token', null,['id'=>'token', 'class'=>'form-control'] ) !!}
                    {!! Form::hidden('phone', null,['id'=>'phone', 'class'=>'form-control'] ) !!}

                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>

            <td width="50%" height="35px" colspan="2">
              <label class="col-sm-2 control-label">Pais</label>
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                    {!! Form::select('id_country', $country, null,['id'=>'id_country', 'placeholder' => 'Selecciona', 'class'=>'form-control select2', 'style'=>'width: 100%', 'required' => 'required'] ) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4" height="15px"><pre><i class="fa fa-user"></i> - <b>Datos Del Pago</b></pre></td>
          </tr>
          <tr>
            <th width="5%" height="35px" ><label class="col-sm-2 control-label">Fecha</label></th>
            <td width="45%" height="35px">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    {!! Form::text('date', null,['id'=>'date', 'class'=>'form-control', 'style'=>'width: 100%', 'required' => 'required'] ) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
            <th width="5%" height="35px" ><label class="col-sm-2 control-label">Hora:</label></th>
            <td width="45%" height="35px">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                    {!! Form::text('hour_pay', null ,['id'=>'hour_pay', 'class'=>'form-control timepicker', 'required' => 'required']) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="25%" height="35px" ><label class="col-sm-2 control-label">Tipo</label></td>
            <td width="75%" height="35px" colspan="3">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-gg"></i></div>
                    {!! Form::select('id_pay', $pay, null,['id'=>'id_pay', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 100%', 'required' => 'required'] ) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr id="banks"      style="display:none;">
            <th width="5%" height="35px" ><label class="col-sm-2 control-label">Banco</label></th>
            <td width="45%" height="35px">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-bank"></i></div>
                    {!! Form::select('id_bank', $bank, null,['id'=>'id_bank', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 100%'] ) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
            <th width="5%" height="35px" ><label class="col-sm-2 control-label">Cuenta:</label></th>
            <td width="45%" height="35px">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-bars"></i></div>
                    {!! Form::select('id_account_type', $account_type, null,['id'=>'id_account_type', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 100%'] ) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr id="banks_2"    style="display:none;">
            <td width="25%" height="35px" ><label class="col-sm-2 control-label">Vaucher/Pago</label></td>
            <td width="75%" height="35px" colspan="3">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-file-image-o"></i></div>

                      <div class="col-md-6">
                        <input name="voucher_pago" type="file" aria-invalid="false" id="voucher_pago">
                        {{-- {!! Form::file('voucher_pago', null,['id'=>'voucher_pago', 'class'=>'form-control',  'placeholder' => 'Selecciona', 'style'=>'width: 100%'] ) !!} --}}
                      </div>
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr id="num"        style="display:none;">
            <td width="25%" height="35px" ><label class="col-sm-2 control-label">N/Operacion</label></td>
            <td width="75%" height="35px" colspan="3">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-500px"></i></div>
                    {!! Form::text('number_operation', null,['id'=>'number_operation', 'class'=>'form-control', 'style'=>'width: 100%', 'onchange'=>"return $.fn.validaNumber();"] ) !!}
                    <div class="input-group-addon"><i class="fa fa-check-circle" title="Aprobar Registro"></i></div>

                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4" height="15px"><pre><i class="fa fa-user"></i> - <b>Saldo</b></pre></td>
          </tr>
          <tr>
            <th width="5%" height="35px" ><label class="col-sm-2 control-label">Actual</label></th>
            <td width="45%" height="35px">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-usd"></i></div>
                    {!! Form::text('saldo_actual', null,['id'=>'saldo_actual', 'class'=>'form-control', 'style'=>'width: 100%;  text-align:right;', 'required' => 'required'] ) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
            <th width="5%" height="35px" ><label class="col-sm-2 control-label">Recarga</label></th>
            <td width="45%" height="35px">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-usd"></i></div>
                    {!! Form::text('saldo_recarga', null,['id'=>'saldo_recarga', 'class'=>'form-control', 'style'=>'width: 100%; text-align:right;', 'required' => 'required', 'onKeypress'=>"return $.fn.justNumbers(event);"] ) !!}
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td width="25%" height="35px" ><label class="col-sm-2 control-label">Observaciones</label></td>
            <td width="75%" height="35px" colspan="3">
              <div class="form-group">
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-file-text-o"></i></div>
                    <div class="col-xs-6">{!! Form::textarea('note', null,['id'=>'note', 'class'=>'form-control', 'value'=> old('note'), 'style'=>'width: 830px', 'placeholder'=>'Observaciones...', 'rows'=>'3'] ) !!}</div>
                  </div>
                  <div><span class="help-block" id="error"></span></div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4" height="80px" align="center" ><button type="submit" class="btn btn-primary" >Guardar</button></td>
          </tr>
        </table>
      </form>
    </div>

  </div>




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
<!-- date-range-picker -->
<script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://checkout.culqi.com/js/v3"></script>


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


<script src="{{ asset('js/CapitalDriver/create.js')}} "></script>
@endsection
