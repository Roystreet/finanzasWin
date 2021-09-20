
@extends('layouts.app')
@section('title', 'Editar del Conductor')

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<!-- include a theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')

<section class="content">
	<div  name="customer" class="box">
		<div class="box-body">
		    <div class="box-header">
		      <h3 class="box-title">Crear un conductor</h3>
		    </div>

		    <div class="box-body">

            <form >
              <meta name="csrf-token" content="{{ csrf_token() }}">
              {{-- inicio el accionista  --}}
                <div class="panel panel-primary">
                    <div class="panel-heading"></div>
                      <div class="panel-body">

                     <div class="customer">
                       <div class="form-group">
                         <div class="row">
                           <div class="col-xs-12"><label for="Datos">nacionalización</label>

                             <div id="load_inv"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i></div>
                           </div>
                           <div class="col-xs-4">
														 {!! Form::select('cod_country_nationaily', $country, null, ['id'=>'cod_country_nationaily','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}

                           </div>
                         </div>
                       </div>





                      <div class="form-group">
                        <div class="row">
                          <div class="col-xs-6">
                            <label for="Datos">Cedula de identificación/DNI:<code>Opcional (Buscar al accionista por el DNI Registrado en winistoshare.com)</code></label>
                            <div class="input-group dniaccionista">
                              <div class="input-group-addon">
                                <i class="fa fa-500px"></i>
                              </div>
                              {!! Form::text('document', null,['id'=>'document', 'class'=>'form-control keyup-dni','placeholder' => 'DNI',
                                'onkeypress'=>'onKeyDownHandler(event);return ','maxlength'=>'20'] ) !!}

                              </div>
                          </div>
                          <div class="col-xs-6">
                            <label for="Datos">Buscar</code></label>
                            <div class="input-group dniaccionista">
                              <div class="input-group-addon">
                                <i class="fa fa-500px"></i>
                              </div>
                              <input type="button" id="btn_sheart" data-form="fCreateSahreHolder" class="btn btn-success btn_sheart" value="Buscar" onclick="getCustomer()">

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
<div class="conductor" >
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

                        <div class="form-group proval">
                          <div class="row">
                            <div class="col-xs-6"><label for="Datos">Licencia: <code>*Obligatorio</code></label>
                              <div class="input-group provincia">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
                                {!! Form::text('number_license', null,['id'=>'number_license', 'class'=>'form-control', 'value'=> old('licencia'),  'placeholder'=>'A76654', 'rows'=>'2'] ) !!}
                              </div>
                            </div>
                            <div class="col-xs-6"><label for="Datos">Categoria: <code>*Obligatorio</code></label>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
                                {!! Form::text('category', null,['id'=>'category', 'class'=>'form-control', 'value'=> old('category'),  'placeholder'=>'A1', 'rows'=>'2'] ) !!}
                              </div>
                            </div>
                          </div>
                        </div><!--   -->

                        <div class="form-group proval">
                          <div class="row">
                            <div class="col-xs-6"><label for="Datos">Fecha de expiración: <code>*Obligatorio</code></label>
                              <div class="input-group provincia">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
                                {!! Form::date('date_exp', date('Y-m-d') ,['id'=>'date_exp', 'class'=>'form-control']) !!}
                              </div>
                            </div>
                            <div class="col-xs-6"><label for="Datos">Puntos: <code>*Obligatorio</code></label>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
                                {!! Form::text('points', null,['id'=>'points', 'class'=>'form-control', 'value'=> old('points'),  'placeholder'=>'100', 'rows'=>'2'] ) !!}
                              </div>
                            </div>
                          </div>
                        </div><!--   -->


												<div class="form-group">
                          <div class="row">
                            <div class="col-xs-6"><label for="Datos">Pais de trabajo : <code>*Obligatorio</code></label>
                              <div class="input-group pais">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
                                {!! Form::select('cod_country_driver', $country, null, ['id'=>'cod_country_driver','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                              </div>
                            </div>
                            <div class="col-xs-6 depval"><label for="Datos">PLACA: <code>*Obligatorio (SIN GUION)</code></label>
                              <div class="input-group departamento">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
																{!! Form::text('matricula', null,['id'=>'matricula', 'class'=>'form-control', 'value'=> old('matricula'),  'placeholder'=>'a2a5685', 'rows'=>'2'] ) !!}
                              </div>
                            </div>
                          </div>
                        </div>

												<div class="form-group">
                          <div class="row">
                            <div class="col-xs-6"><label for="Datos">Modelo: <code>*Obligatorio</code></label>
                              <div class="input-group pais">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
																{!! Form::select('model', $t, null, ['id'=>'model','placeholder'=>'Selecciona' ,'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                              </div>
                            </div>
                            <div class="col-xs-6 depval"><label for="Datos">Color: <code>*Obligatorio (SIN GUION)</code></label>
                              <div class="input-group departamento">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
																{!! Form::text('color', null,['id'=>'color', 'class'=>'form-control', 'value'=> old('color'),  'placeholder'=>'rojo', 'rows'=>'2'] ) !!}
                              </div>
                            </div>
                          </div>
                        </div>


												<div class="form-group">
                          <div class="row">
                            <div class="col-xs-6"><label for="Datos">nro Puertas: <code>*Obligatorio</code></label>
                              <div class="input-group pais">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
																{!! Form::text('nro_doors', null,['id'=>'nro_doors', 'class'=>'form-control', 'value'=> old('4'),  'placeholder'=>'4', 'rows'=>'2'] ) !!}
                              </div>
                            </div>
                            <div class="col-xs-6 depval"><label for="Datos">año: <code>*Obligatorio</code></label>
                              <div class="input-group departamento">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
																<input type="text" class="form-control" id="datepicker3"
								placeholder="año del vehículo" />
                              </div>
                            </div>
                          </div>
                        </div>


												<div class="form-group">
                          <div class="row">
                            <div class="col-xs-6"><label for="Datos">marca: <code>*Obligatorio</code></label>
                              <div class="input-group pais">
                                <div class="input-group-addon">
                                  <i class="fa  fa-map-marker"></i>
                                </div>
																{!! Form::text('brand', null,['id'=>'brand', 'class'=>'form-control', 'value'=> old('marca'),  'placeholder'=>'marca', 'rows'=>'2'] ) !!}
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
                <input type="button" id="btnCreateShareholder" data-form="fCreateSahreHolder" class="btn btn-success"  onclick="storeDriver()" value="Registrar">
              </div>
            </form>

				</div>  <!--  fin panel-body -->

		</div> <!--  fin body -->
	</div> <!--  fin body -->
</section> <!--  fin body -->

@endsection

@section('js')
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
  <script src="{{ asset('js/Driver/create.js')}}"></script>

@endsection
