
@extends('layouts.app')
@section('title', 'Editar del Conductor')

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

<section class="content">
	<div  name="customer" class="box">
		<div class="box-body">
		    <div class="box-header">
		      <h3 class="box-title">Información</h3>
		    </div>

		    <div class="box-body">


					<div class="customer" >
						<form  id="editCustomer" >
								<meta name="csrf-token" content="{{ csrf_token() }}">

								<input type="text" id="id_customer" value="{{ $customer->id }}" hidden= "true">
						<div class="form-group">
							<div class="row">
							<div class="col-xs-6 form-group ">
								<label for="Datos">Cedula de identificación/DNI:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-500px"></i>
									</div>
									{!! Form::text('document', $customer->document,['id'=>'document', 'class'=>'form-control keyup-dni','placeholder' => 'DNI',
										'onkeypress'=>'','maxlength'=>'90'] ) !!}

									</div>
									<div >
	                  <span class="help-block" id="error"></span>
	                </div>
							</div>
						</div>
						</div>
						<div class="form-group">
							<div class="row">
							<div class="col-xs-6 form-group"><label for="Datos">Nombres: <code>*Obligatorio</code></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa  fa-user"></i>
									</div>
									{!! Form::text('first_name',  $customer->first_name,['id'=>'first_name', 'class'=>'form-control','autofill'=>'off',
										'placeholder' => 'Nombres','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
									</div>
										<div >
		                  <span class="help-block" id="error"></span>
		                </div>
							</div>
							<div class="col-xs-6 form-group "><label for="Datos">Apellidos: <code>*Obligatorio</code></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa  fa-user"></i>
									</div>
									{!! Form::text('last_name', $customer->last_name,['id'=>'last_name', 'class'=>'form-control',
										'placeholder' => 'Apellidos','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
								</div>
								<div >
                  <span class="help-block" id="error"></span>
                </div>
							</div>
						</div>
						</div>

						<div class="form-group">
							<div class="row">
							<div class="col-xs-6 form-group "><label for="Datos">Telefono: <code>*Obligatorio</code></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-phone"></i>
									</div>
									{!! Form::text('phone', $customer->phone,['id'=>'phone', 'class'=>'form-control',  'placeholder' => '917.000.00'
										,'maxlength'=>'25'] ) !!}                      </div>
										<div >
		                  <span class="help-block" id="error"></span>
		                </div>
							</div>
							<div class="col-xs-6 form-group"><label for="Datos">Correo: <code>*Obligatorio</code></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope-o"></i>
									</div>
									{!! Form::email('email',  $customer->email,['id'=>'email', 'class'=>'form-control keyup-email', 'placeholder' => 'ejemplo@dominio.com'] ) !!}
								</div>
								<div >
                  <span class="help-block" id="error"></span>
                </div>
							</div>
						</div>
						</div>


						<div class="form-group">
							<div class="row">
							<div class="col-xs-6 form-group "><label for="Datos">Pais: <code>*Obligatorio</code></label>
								<div class="input-group pais">
									<div class="input-group-addon">
										<i class="fa  fa-map-marker"></i>
									</div>
									 {!! Form::select('id_country', $country, $customer->id_country,['id'=>'id_country', 'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
								</div>
								<div >
                  <span class="help-block" id="error"></span>
                </div>
							</div>
							<div class="col-xs-6 depval form-group "><label for="Datos">Departamento: <code>*Obligatorio</code></label>
								<div class="input-group departamento">
									<div class="input-group-addon">
										<i class="fa  fa-map-marker"></i>
									</div>
									{!! Form::select('id_state', $state, $customer->id_state,['id'=>'id_state', 'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
								</div>
								<div >
                  <span class="help-block" id="error"></span>
                </div>
							</div>
						</div>
						</div>

						<div class="form-group proval">
							<div class="row">
							<div class="col-xs-6  form-group"><label for="Datos">Provincia: <code>*Obligatorio</code></label>
								<div class="input-group provincia">
									<div class="input-group-addon">
										<i class="fa  fa-map-marker"></i>
									</div>
									{!! Form::select('id_city', $city, $customer->id_city,['id'=>'id_city', 'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
								</div>
								<div >
                  <span class="help-block" id="error"></span>
                </div>
							</div>
							<div class="col-xs-6 form-group "><label for="Datos">Dirección: <code>*Obligatorio</code></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa  fa-map-marker"></i>
									</div>
									{!! Form::textarea('address', $customer->address,['id'=>'address', 'class'=>'form-control', 'value'=> old('address'),  'placeholder'=>'Av/Calle/Edificio...', 'rows'=>'2'] ) !!}
								</div>
								<div >
                  <span class="help-block" id="error"></span>
                </div>
							</div>
						</div>
						</div>
						<div class="input-group">
							<button type="submit" class="btn btn-primary pull-right">Actualizar</button><br><br><br>
						</div>
					</form>
					</div>
					<br>
				</div>  <!--  fin panel-body -->

		</div> <!--  fin body -->
	</div> <!--  fin body -->
</section> <!--  fin body -->

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
<script src="{{ asset('js/Customer/edit.js')}}"></script>

@endsection
