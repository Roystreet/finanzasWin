    @extends('layout-simple')
    @section('title', 'Registro de pago')
    <link href="{{ asset('plugins/clock/clockpicker.css')}}" rel="stylesheet" />
    <link href="{{ asset('alertify/css/alertify.min.css')}}" rel="stylesheet" />
    @section('content')
      <section class="content">
          <div class="box content-pay">
              <div class="box-header">
                  <h3 class="box-title">Registro de Accionistas</h3>
              </div>
              <div class="box-body">
                  <div class="row color-font">
                      {{-- inicio de llendar doatos personales --}}
                      <div class="col-lg-8 col-sm-12">

                            <meta name="csrf-token" content="{{ csrf_token() }}">
                              {{-- inicio el accionista  --}}<!--  panel-primary -->
                                  <div class="panel panel-primary">
                                      <div class="panel-heading">Datos del accionista</div>
                                      <div class="panel-body"> <!-- panel-primary-body -->
                                  		    <div class="customer" style="">
                                					    <div class="row">
                                                <form id="customer-form">
                                                      <div class="circle-loading" style="display:none; text-align: center;" id="load_customer">
                                                          <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
                                                      </div>
                                                      <code class="col-sm-12">Campos obligatorios ( * )</code>

                                                      <div >

                                                      <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                          <label class="label-form-external" for="type_docu">Tipo de documento:<code>*</code></label>
                                                          <div class="input-group dniaccionista">
                                                              <div class="input-group-addon">
                                                                  <i class="fa fa-500px"></i>
                                                              </div>
                                                              <select class="form-control select2" id="type_docu" name="type_docu" style="width:100%">
                                                                <option value="">Seleccionar tipo de documento</option>
                                                                <option value="1">Numero de identificacion</option>
                                                                <option value="2">DNI</option>
                                                                <option value="3">Cedula de identidad</option>
                                                                <option value="4">CURP</option>
                                                              </select>
                                                          </div>
                                                      </div>

                                          						<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                          <label class="label-form-external" for="document">Número de identificación:<code>*</code></label>
                                            							<div class="input-group dniaccionista">
                                              								<div class="input-group-addon">
                                                                  <i class="fa fa-500px"></i>
                                              								</div>
                                                              {!! Form::text('document', null,['id'=>'document', 'class'=>'form-control keyup-dni','placeholder' => 'Numero de documento','onkeypress'=>' ','maxlength'=>'20'] ) !!}
                                                          </div>
                                          						</div>
                                                      <div class="row" style="text-align: center;">
                                                        <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 btn-buscar">
                                                            <label class="label-form-external" for="search_customer" style="display:block;">Buscar</label>
                                                            <button type="submit" class="btn btn-primary" id="search_customer"><i class="fa fa-search"></i></button>
                                                        </div>
                                                      </div>

                                                        </div>


                                                      <div class="col-sm-3 col-xs-12">
                                                      </div>
                                                    </form>
                                              </div>
                                  				</div>
                                          <div class="row">
                                              <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                  <label class="label-form-external" for="first_name">Nombres: <code>*</code></label>
                                                  <div class="input-group">
                                                      <div class="input-group-addon">
                                                          <i class="fa  fa-user"></i>
                                                      </div>
                                                      {!! Form::text('first_name', null,['id'=>'first_name', 'class'=>'form-control tex','autofill'=>'off','placeholder' => 'Nombres','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                                                  </div>
                                              </div>
                                              <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                  <label for="last_name">Apellidos: <code>*</code></label>
                                                  <div class="input-group">
                                                      <div class="input-group-addon">
                                                          <i class="fa  fa-user"></i>
                                                      </div>
                                                      {!! Form::text('last_name', null,['id'=>'last_name', 'class'=>'form-control tex','placeholder' => 'Apellidos','maxlength'=>'80' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                                                  </div>
                                              </div>
                                              <div  class="col-sm-3 col-xs-12">

                                              </div>
                                          </div>
                                          {{--  Ocultar datos del customer--}}
                                          <div class="customer-data-hide" >
                                              <div class="row">
                                                  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                      <label class="label-form-external" for="phone">Teléfono: <code>*</code></label>
                                                      <div class="input-group">
                                                          <div class="input-group-addon">
                                                              <i class="fa fa-phone"></i>
                                                          </div>
                                                          {!! Form::input('phone','phone',null,['id'=>'phone', 'class'=>'form-control number',  'placeholder' => '917000001','maxlength'=>'30'] ) !!}
                                                      </div>
                                                      <div >
                                                        <span class="help-block" id="error"></span>
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                      <label class="label-form-external" for="email">Correo: <code>*</code></label>
                                                      <div class="input-group">
                                                          <div class="input-group-addon">
                                                              <i class="fa fa-envelope-o"></i>
                                                          </div>
                                                          {!! Form::email('email', null,['id'=>'email', 'class'=>'form-control keyup-email', 'placeholder' => 'ejemplo@dominio.com'] ) !!}
                                                      </div>
                                                      <div >
                                                        <span class="help-block" id="error"></span>
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                      <label class="label-form-external" for="cod_country">País: <code>*</code></label>
                                                      <div class="input-group pais">
                                                          <div class="input-group-addon">
                                                              <i class="fa  fa-map-marker"></i>
                                                          </div>
                                                          {!! Form::select('cod_country', $country, null, ['id'=>'cod_country','placeholder'=>'Seleccione...','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                                                      </div>
                                                      <div >
                                                        <span class="help-block" id="error"></span>
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 depval">
                                                      <label class="label-form-external" for="cod_state">Departamento: <code>*</code></label>
                                                      <div class="input-group departamento">
                                                          <div class="input-group-addon">
                                                              <i class="fa  fa-map-marker"></i>
                                                          </div>
                                                          {!! Form::select('cod_state', ['placeholder' => 'Seleccione...'], null,['id'=>'cod_state','class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                                                      </div>
                                                      <div >
                                                        <span class="help-block" id="error"></span>
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                      <label class="label-form-external" for="cod_city">Provincia: <code>*</code></label>
                                                      <div class="input-group provincia">
                                                          <div class="input-group-addon">
                                                              <i class="fa  fa-map-marker"></i>
                                                          </div>
                                                          {!! Form::select('cod_city', ['placeholder' => 'Seleccione...'], null,['id'=>'cod_city', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                                                      </div>
                                                      <div >
                                                        <span class="help-block" id="error"></span>
                                                      </div>
                                                  </div>
                                                  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                      <label class="label-form-external" for="district">Dirección: <code>*</code></label>
                                                      <div class="input-group">
                                                          <div class="input-group-addon">
                                                              <i class="fa  fa-map-marker"></i>
                                                          </div>
                                                          {!! Form::textarea('district', null,['id'=>'district', 'class'=>'form-control', 'value'=> old('district'),  'placeholder'=>'Av/Calle/Edificio/Casa...', 'rows'=>'2'] ) !!}
                                                      </div>
                                                      <div >
                                                        <span class="help-block" id="error"></span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                    	</div> <!-- fin panel-primary-body -->
                                  </div>
                              {{-- termina el accionista --}}<!--  fin panel-primary -->

                              {{-- Inicio del Invitado   --}}
                                <div class="panel panel-primary" style="display:hidden;">
                                    <div class="panel-heading">Patrocinador / Sponsor</div>
                                    <div class="panel-body">
                                        <div class="circle-loading" style="display:none; text-align: center;" id="load_inv">
                                            <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
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

                                                <form id="customer-form-inv">
                                                  <div >
                                                    <code class="col-sm-12">Campos obligatorios ( * )</code>

                                                      <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                                        <label class="label-form-external" for="type_docu_inv">Tipo de documento:<code>*</code></label>
                                                          <div class="input-group dniaccionista">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-500px"></i>
                                                            </div>
                                                            <select class="form-control select2" id="type_docu_inv" name="type_docu" style="width:100%">
                                                              <option value="">Seleccionar tipo de documento</option>
                                                              <option value="1">Numero de identificacion</option>
                                                              <option value="2">DNI</option>
                                                              <option value="3">Cedula de identidad</option>
                                                              <option value="4">CURP</option>
                                                            </select>
                                                        </div>
                                                        <div >
                                                          <span class="help-block" id="error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12"><label for="dni_inv">Número de identificación:<code>*</code></label>
                                                        <div class="input-group keyup-dniinv">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-500px"></i>
                                                            </div>
                                                            {!! Form::text('dni_inv', null,['id'=>'dni_inv', 'class'=>'form-control keyup-dni','placeholder' => 'DNI','onkeypress'=>'  ','maxlength'=>'20'] ) !!}
                                                        </div>
                                                        <div >
                                                          <span class="help-block" id="error"></span>
                                                        </div>
                                                    </div>
                                                    <div style="text-align: center; aling-items:center">
                                                      <div class=class="col-xl-2 col-lg-12 col-md-12 col-sm-12 btn-buscar" style=" align-items: center;">
                                                        <label for="search_inv">Buscar</label>
                                                        <div class="input-group keyup-dniinv" >
                                                            <button type="submit" class="btn btn-primary" id="search_inv"><i class="fa fa-search"></i></button>
                                                        </div>
                                                        <div >
                                                          <span class="help-block" id="error"></span>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                  <div >



                                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12"><label for="Datos">Nombres: <code>*</code></label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                            {!! Form::text('name_inv', null,['id'=>'name_inv', 'class'=>'form-control',  'placeholder' => 'Nombres','maxlength'=>'180' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                                                        </div>
                                                        <div >
                                                          <span class="help-block" id="error"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12"><label for="Datos">Apellidos: <code>*</code></label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-user"></i>
                                                            </div>
                                                            {!! Form::text('lastname_inv', null,['id'=>'lastname_inv', 'class'=>'form-control',  'placeholder' => 'Apellidos','maxlength'=>'180' , 'onkeypress'=>'return validaLetras(event)'] ) !!}
                                                        </div>
                                                        <div >
                                                          <span class="help-block" id="error"></span>
                                                        </div>
                                                      </div>

                                                      <div class="col-sm-2 col-xs-12">

                                                      </div>

                                                    </div>
                                                  </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--  fin panel-body -->
                                </div><!--  fin panel-success -->
                              {{-- fin de invitado       --}}

                      </div>
                      {{-- inicio de llendar pagos --}}
                      <div class="col-lg-4 col-sm-12">
                          <div class="panel panel-primary">
                              <div class="panel-heading">Forma de pago</div>
                              <div class="panel-body" style="padding: 5px;">
                                	<table id="cart" class="table table-hover table-condensed">
                              				<thead>
                              						<tr>
                                							<th style="width:50%">Producto</th>
                                							<th style="width:20%">Monto</th>
                                							<th style="width:30%" class="text-center">Sub-total</th>
                              						</tr>
                          					  </thead>
                            					<tbody>
                              						<tr>
                                							<td data-th="Product">
                                  								<div class="row">
                                    									<div class=" hidden-xs">
                                                          <img src="{{$product->product->url_imagen}}" width="100" height="100"/>
                                                      </div>
                                    									<div class="col-sm-10">
                                      										<h4 class="nomargin" id="cod_product" data-id="{{$product->product->id}}">{{$product->product->description}}</h4>
                                    									</div>
                                  								</div>
                                							</td>
                                							<td data-th="Price" id="id_price" data-id="{{$product->precio->id}}" > {{$product->precio->price}}</td>
                                							<td data-th="Subtotal" class="text-center">{{$product->precio->price}}</td>
                              						</tr>
                            					</tbody>
                            					<tfoot>
                              						<tr class="visible-xs">
                              							  <td class="text-center"><strong>{{$product->precio->price}}</strong></td>
                              						</tr>
                              						<tr>
                                							<td colspan="2" class="hidden-xs"></td>
                                							<td class="hidden-xs text-center"><strong>{{$product->moneda->symbol}} {{$product->precio->price}}</strong></td>
                              						</tr>
                            					</tfoot>
                            			</table>
                                  <div class="form-group">
                                      <div class="row">
                                          <div class="col-xs-9">
                                              <label for="cod_pago">Tipo de Pago: <code>*</code></label>
                                              <div class="input-group valpago">
                                                  <div class="input-group-addon">
                                                      <i class="fa  fa-credit-card"></i>
                                                  </div>
                                                  {!! Form::select('cod_pago', $pay, null,['id'=>'cod_pago', 'class'=>'form-control select2', 'style'=>'width: 100%' , 'placeholder' => 'Seleccionar']) !!}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group" id="divoperacion">
                                      <div class="row">
                                          <div class="col-xs-12  no">
                                              <label for="number_operation"><span id="textCodigoOperacion">Código de Operación:</span> <code>*</code></label>
                                              <div class="input-group">
                                                  <div class="input-group-addon">
                                                      <i class="fa   fa-500px"></i>
                                                  </div>
                                                  {!! Form::text('number_operation', null,['id'=>'number_operation', 'class'=>'form-control valOperation' , 'value'=> old('number_operation'),  'rows'=>'2'] ) !!}
                                              </div>
                                           </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-xs-9">
                                              <label for="bank">Banco: <code>*</code></label>
                                              <div class="input-group valpago">
                                                  <div class="input-group-addon">
                                                      <i class="fa  fa-credit-card"></i>
                                                  </div>
                                                  {!! Form::select('bank', $banks, null,['id'=>'bank', 'class'=>'form-control select2', 'style'=>'width: 100%' , 'placeholder' => 'Seleccionar']) !!}
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-xs-12">
                                              <label for="date_pay">Fecha de pago: <code>*</code></label>
                                              <div class="input-group date">
                                                  <div class="input-group-addon">
                                                      <i class="fa  fa-calendar"></i>
                                                  </div>
                                                  {!! Form::date('date_pay', null, ['id'=>'date_pay', 'class'=>'form-control']) !!}
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-xs-12">
                                            <label for="voucher">voucher: <code>*</code></label>
                                            <div class="input-group" id="voucher_pago" name="voucher_pago">

                                            </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="row">
                                          <div class="col-xs-9">
                                              <label for="Datos">observaciones: <code>(opcional)</code></label>
                                              <div class="input-group">
                                                  <div class="input-group-addon">
                                                      <i class="fa  fa-credit-card"></i>
                                                  </div>
                                                  {!! Form::textarea('note', null,['id'=>'note', 'class'=>'form-control'] ) !!}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>  <!--  fin panel-body -->
                              <div class="form-group" align="center">
                                  <input type="button" id="btnCreateShareholder" data-form="fCreateSahreHolder" class="btn btn-success btn_ajax" onclick="comprar()" value="Comprar">
                              </div>
                          </div> <!--  fin panel-primary -->
                      </div>
                  </div>
              </div><!-- box body -->
          </div><!-- box -->
          <div class="modal fade docs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                      <div class="bg-successe">
                          <div class="modal-header">
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
         </div><!--  fin panel-body -->
    {{--  --}}
      </section>
    @endsection

    @section('script')
    <script src="{{ asset('plugins/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('alertify/js/alertify.min.js')}}"></script>
    <script src="{{ asset('plugins/clock/clockpicker.js')}}"></script>
      <!-- <script src="{{ asset('plugins/jqueryvalidation/jqueryvalidation.min.js')}}"></script> -->
      <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    <script src="{{ asset('js/External/sales/registerExterno.js')}}"></script>
    @endsection
