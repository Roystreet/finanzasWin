@extends('layouts.app')
@section('title', 'Registrar Ticket')

@section('css')
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<!-- include the core styles -->
<link rel="stylesheet" href="{{ asset('alertify/css/alertify.min.css') }}">
<!-- <link rel="stylesheet" href="PATH_TO_FILE/alertify.css" /> -->
<!-- include a theme, can be included into the core instead of 2 separate files -->
<!-- <link rel="stylesheet" href="PATH_TO_FILE/alertify.default.css" /> -->
{{-- <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css"> --}}

<!-- include the style -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<!-- include a theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>

<link href="{{ asset('plugins/clock/clockpicker.css')}}" rel="stylesheet" />

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
<style >
#true{
  background: green !important;
  align-items: center;
}
#false{
  background: red !important;
}
</style>


@endsection

@section('content')

<section class="content">
  <div class="box" style="padding: 35px;">

    <div class="box-header">
      <h3 class="box-title">Registro de Accionistas </h3>
    </div>
    <div class="box-body">
      <form method="POST" action="" id="myform">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{--  Inicio de los productos--}}
          <div class="panel panel-warning">
            <div class="panel-heading">Productos <code>*Obligatorio</code></div>
              <div class="box-body table-responsive no-padding">
                <tr>
                  <button type="button" class="btn btn-primary btn-cen btn_shoping" data-toggle="modal" data-target="#myModal">Ver Productos</button>
                </tr>
              </div>
              <table id="tabla" name="tabla"  class="table table-hover">
              <thead>
                <tr>
                  <th width="5%">Cod</th>
                  <th width="5%">Nombre</th>
                  <th width="5%">Valor</th>
                  <th width="5%">Precio</th>
                  <th width="5%">Moneda</th>
                  <th width="5%">Cantidad</th>
                  <th width="5%">Acción</th>
                </tr>
              </thead>
              <tbody class="cuerpo">
              </tbody>
            </table>
          </div>
        {{--  fin de los productos   --}}

        {{-- Inicio del Invitado   --}}
          <div class="panel panel-success" style="display:hidden;">
            <div class="panel-heading">Invitado por </div>
                <div class="panel-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12"><label for="Datos"></label>

                        <div style="display:none;" id="load_inv"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i></div>
                      </div>
                      <div class="col-xs-4">

                      </div>
                    </div>
                  </div>
                  <div class="invited" style="display:hidden">
                    <div class="form-group">
                      <div class="row">
                        {{-- <div class="col-xs-6"><label for="Datos">Usuario: <code style="color: black !important;">(Buscar al invitado por el usuario Registrado en taxiwin.in) para buscar ingrese el usuario y presione enter</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa  fa-user"></i>
                            </div>
                            {!! Form::text('user_inv', null,['id'=>'user_inv', 'class'=>'form-control',
                              'placeholder' => 'wintecno','onkeypress'=>'onKeyDownHandlerInv(event);'] ) !!}
                          </div>
                        </div> --}}
                        <div class="col-xs-6"><label for="Datos">Documento de identidad: <code>*Obligatorio</code></label>
                          <div class="input-group keyup-dniinv">
                            <div class="input-group-addon">
                              <i class="fa fa-500px"></i>
                            </div>
                            {!! Form::text('dni_inv', null,['id'=>'dni_inv', 'class'=>'form-control keyup-dni','placeholder' => 'DNI',
                              'onkeypress'=>' onKeyDownHandlerInvDNI(event);return ','maxlength'=>'20'] ) !!}                          </div>
                        </div>
                        <div class="col-xs-6"><label for="Datos">BUSCAR:</label>
                          <div class="input-group keyup-dniinv">
                            <button type="button" class="btn btn-success" name="btn_getInvitado" onclick="getCustomerTaxiWinandWinistoshare()">Buscar</button>
                                  </div>
                        </div>

                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-6"><label for="Datos">Nombres: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                            {!! Form::text('name_inv', null,['id'=>'name_inv', 'class'=>'form-control',  'placeholder' => 'Nombres','maxlength'=>'180' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                          </div>
                        </div>

                        <div class="col-xs-6"><label for="Datos">Apellidos: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-user"></i>
                            </div>
                            {!! Form::text('lastname_inv', null,['id'=>'lastname_inv', 'class'=>'form-control',  'placeholder' => 'Apellidos','maxlength'=>'180' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                          </div>
                        </div>
                      </div>
                    </div>
                <div id="validarinvitado">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-6"><label for="Datos">Telefono: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                            {!! Form::text('phone_inv', null,['id'=>'phone_inv', 'class'=>'form-control',  'placeholder' => '917.000.00'
                              ,'onkeypress'=>'return validaNumericos(event)','maxlength'=>'30'] ) !!}                      </div>
                        </div>
                        <div class="col-xs-6"><label for="Datos">Correo: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope-o"></i>
                            </div>
                            {!! Form::email('email_inv', null,['id'=>'email_inv', 'class'=>'form-control keyup-email', 'placeholder' => 'ejemplo@dominio.com'] ) !!}
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
                            {!! Form::select('cod_country_inv', $country, null, ['id'=>'cod_country_inv','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                          </div>
                        </div>
                        <div class="col-xs-6"><label for="Datos">Departamento: <code>*Obligatorio</code></label>
                          <div class="input-group departamento">
                            <div class="input-group-addon">
                              <i class="fa  fa-map-marker"></i>
                            </div>
                            {!! Form::select('cod_state_inv', ['placeholder' => 'Selecciona'], null,['id'=>'cod_state_inv',  'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group ">
                      <div class="row">
                        <div class="col-xs-6"><label for="Datos">Provincia: <code>*Obligatorio</code></label>
                          <div class="input-group provincia">
                            <div class="input-group-addon">
                              <i class="fa  fa-map-marker"></i>
                            </div>
                            {!! Form::select('cod_city_inv', ['placeholder' => 'Selecciona'], null,['id'=>'cod_city_inv', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                          </div>
                        </div>
                        <div class="col-xs-6"><label for="Datos">Dirección: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa  fa-map-marker"></i>
                            </div>
                            {!! Form::textarea('district_inv', null,['id'=>'district_inv', 'class'=>'form-control', 'value'=> old('district'),  'placeholder'=>'Av/Calle/Edificio...', 'rows'=>'2'] ) !!}
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
                  </div>
                </div><!--  fin panel-body -->
          </div><!--  fin panel-success -->
        {{-- fin de invitado       --}}

        {{-- inicio el accionista  --}}
          <div class="panel panel-primary">
              <div class="panel-heading">Accionista</div>
                <div class="panel-body">

                  <div class="form-group">
        						<div class="row">
        							<div class="col-xs-12"><label for="Datos"></label>

                        <div style="display:none;" id="load_shareholder"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i></div>
        							</div>

        						</div>
        					</div>

  {{--  inicio del contenedor customer--}}
        		      <div class="customer">

        				<div class="form-group">
        					<div class="row">
        						<div class="col-xs-6">
                      <label for="Datos">Cedula de identificación/DNI:<code>*Obligatorio (Buscar al accionista por el DNI Registrado en taxiwin.com)</code></label>
        							<div class="input-group dniaccionista">
        								<div class="input-group-addon">
        									<i class="fa fa-500px"></i>
        								</div>
                        {!! Form::text('document', null,['id'=>'document', 'class'=>'form-control keyup-dni','placeholder' => 'DNI',
                          'onkeypress'=>'onKeyDownHandler(event);return ','maxlength'=>'20'] ) !!}
                        </div>
        						</div>
                    <div class="col-xs-6"><label for="Datos">BUSCAR:</label>
                      <div class="input-group keyup-dniinv">
                        <button type="button" class="btn btn-success" name="btn_getInvitado" onclick="getCustomerWinIstoShare()">Buscar</button>
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
              <div id="validarCsutomer">{{--  panel de validar customer --}}
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
              </div>{{-- panel que se oculta accionista --}}
        			</div>
              <br>
              </div>  <!--  fin panel-body -->
          </div> <!--  fin panel-primary -->
        {{-- termina el accionista --}}



        {{--  inicio detalle de la compra --}}
          <div class="panel panel-info">
            <div class="panel-heading">Detalle de la compra</div>
            <div class="panel-body">

              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6">
                    <label for="Datos">Fecha de pago: <code>*Obligatorio</code></label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa  fa-calendar"></i>
                      </div>
                      {!! Form::date('date_pay', date('Y-m-d') ,['id'=>'date_pay', 'class'=>'form-control']) !!}
                    </div>
                  </div>

                  <div class="col-xs-6">
                    <label for="Datos">Hora de pago: <code>*Obligatorio</code></label>
                    <div class="input-group">
                      <div class="input-group clockpicker " data-autoclose="true">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                        </span>
                        <input type="text" id="hour_pay" name="hour_pay" class="form-control" value="09:30" />
                        </div>
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6"><label for="Datos">Tipo de Pago: <code>*Obligatorio</code></label>
                    <div class="input-group valpago">
                      <div class="input-group-addon">
                        <i class="fa  fa-credit-card"></i>
                      </div>
                      {!! Form::select('cod_pago', $pay, null,['id'=>'cod_pago', 'class'=>'form-control select2', 'style'=>'width: 100%' , 'placeholder' => 'Seleccionar']) !!}
                    </div>
                  </div>

                  <div class="col-xs-6  no"><label for="Datos"><span id="textCodigoOperacion">Código de Operacion:</span> <code>*Obligatorio</code></label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa   fa-500px"></i>
                      </div>
                      {!! Form::text('number_operation', null,['id'=>'number_operation', 'class'=>'form-control valOperation' , 'value'=> old('number_operation'),  'rows'=>'2'] ) !!}
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6" id="cont_banks">
                      <label >Banco: <code>*Obligatorio</code></label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa  fa-credit-card"></i>
                        </div>
                        {!! Form::select('id_banck', $banks, null, ['id'=>'id_banck', 'placeholder'=>'Selecciona banco','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                      </div>
                  </div>

                  <div class="col-xs-6" id="cont_voucher_pago">
                      <label ><span>Vaucher de pago:</span> <code>*Obligatorio</code></label>
                      <div class="input-group paisval" id="voucher_pago" name="voucher_pago">
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        {{-- Fin del detalle de la compra --}}

        <div class="form-group" id="paisainvertirform">
          <div class="row">
            <div class="col-xs-6">
                <label >Pais a Invertir: <code>*Obligatorio</code></label>
                <div class="input-group paisval">
                  <div class="input-group-addon">
                    <i class="fa  fa-credit-card"></i>
                  </div>
                  {!! Form::select('id_country_invs', $country_invs, null, ['id'=>'id_country_invs', 'placeholder'=>'Selecciona','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-xs-6"><label for="Datos">Monto a Pagar:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-money"></i>
                </div>
                {!! Form::text('pagar', 0.00, ['id'=>'pagar', 'class'=>'form-control', 'style'=>'text-align:right'] ) !!}
              </div>
            </div>
            <div class="col-xs-6"><label for="Datos">¿Accion cortesia de la empresa?</label>
              <div class="input-group">
                {!!Form::select('donate', ['TRUE'=>'SI', 'FALSE'=>'NO'], 'FALSE', ['id'=>'donate','class'=>'form-control select2', 'style'=>'width:80px'])!!}
              </div>
            </div>
          </div>
        </div>



        {{--  Inicio de los Observaciones --}}
          <div class="panel panel-warning">
            <div class="panel-heading">Observacion General Ticket (Se refleja en el ticket) <code style="color: black !important;">(opcional)</code></div>
              <div class="panel-body">
                <div class="form-group">
                 <div class="row">
                     <div class="col-xs-6">{!! Form::textarea('note', null,['id'=>'note', 'class'=>'form-control', 'value'=> old('note'), 'style'=>'width: 900px', 'placeholder'=>'...', 'rows'=>'2'] ) !!}</div>
                  </div>
                </div>
              </div>
              <div class="panel-heading">Observacion Interna ticket (Unicamente lo ve el personal de la empresa) <code style="color: black !important;">(opcional)</code></div>
                <div class="panel-body">
                  <div class="form-group">
                   <div class="row">
                       <div class="col-xs-6">{!! Form::textarea('obser_int', null,['id'=>'obser_int', 'class'=>'form-control', 'value'=> old('obser_int'), 'style'=>'width: 900px', 'placeholder'=>'...', 'rows'=>'2'] ) !!}</div>
                    </div>
                  </div>
                </div>
          </div>
        {{--  fin de los Observaciones--}}

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




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Productos</h4>
      </div>
      <div class="modal-body">
        <table id="tbProducts" name="tbProducts"  class="table table-bordered table-striped">
        <thead class="thead-dark">
          <tr>
            <th width="5%">Cod</th>
            <th width="5%">Nombre</th>
            <th  width="5%">Valor</th>
            <th  width="5%">Precio</th>
            <th  width="5%">Moneda</th>

            <th  width="5%">Acción</th>
          </tr>
        </thead>
        <tbody>
          {{-- @foreach ($products as $fila)
            <tr>
              <td width="5%">{{ $fila->cod_product }}</td>
              <td width="5%">{{$fila->name_product}}</td>
              <td width="5%">{{$fila->cant}}</td>
              <td width="5%">{{$fila->sale_price}}</td>
              <td width="5%">{{$fila->description}}</td>
              <td width="5%">prueba</td>
              <td width="5%"><button type="button" class="btn btn-primary btn_agregarCarrito fa fa-opencart"></button></td>
            </tr>
          @endforeach --}}
        </tbody>
        <tfoot class="thead-dark">
          <tr>
            <th width="5%">Cod</th>
            <th width="5%">Nombre</th>
            <th width="5%">Valor</th>
            <th width="5%">Precio</th>
            <th width="5%">Moneda</th>

            <th width="5%">Accion</th>
          </tr>
        </tfoot>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger fa fa-close" data-dismiss="modal"> Salir</button>
      </div>

    </div>
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
<script src="{{ asset('alertify/js/alertify.min.js') }}"></script>
    <!-- <script src="PATH_TO_FILE/alertify.min.js"></script> -->


<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script src="{{ asset('js/Customer/register.js')}}"></script>
{{--  --}}
@endsection
