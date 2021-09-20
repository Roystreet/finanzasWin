@extends('layouts.app')
@section('title', 'Editar ticket')
@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
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
<style>
#myImg {
border-radius: 5px;
cursor: pointer;
transition: 0.3s;
}
#myImg:hover {opacity: 0.7;}
</style>
@endsection


@section("content")
<section class="content">

  {!!Form::open(['url' => '/ticket/editarTicket/editar/{id}', 'method' => 'post','files'=>true ,'id'=>'formticket'])!!}
  {{ csrf_field() }}
<meta name="csrf-token" content="{{ csrf_token() }}">
  <table class="table">

    {{-- inicio el accionista  --}}
      <div class="panel panel-primary">
          <div class="panel-heading">Datos del Ticket</div>
            <div class="panel-body">

              <div class="form-group">
                <div class="row">
                  <div class="col-xs-12"><label for="Datos"></label>

                    <div style="display:none;" id="load_shareholder"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i></div>
                  </div>

                </div>
              </div>
              @if(session()->has('message'))
                  <div class="alert alert-success">
                    <b>  {{ session()->get('message') }}</b>
                  </div>
              @endif

{{--  inicio del contenedor customer--}}
    <div class="customer">


            <div class="">
              <div class="row">
                <div class="col-xs-6 form-group"><label for="Datos">Codigo Ticket: <code>*Obligatorio</code></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-user"></i>
                    </div>
                    {!!Form::text('codticket',($ticket->cod_ticket)? $ticket->cod_ticket:null,['id'=>'codticket','class'=>'form-control','autofill'=>'off',
                  'placeholder' => 'Codigo de ticket','maxlength'=>'80'])!!}
                  <div >
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
                </div>
                <div class="col-xs-6 form-group"><label for="Datos">Fecha de pago: <code>*Obligatorio</code></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar "></i>
                    </div>
                      <input type="datetime-local" name="fechapago" value="{!!$ticket->date_pay!!}" class="form-control" id=fechapago>
                  </div>
                  <div style="color:red">
                    @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                    @endif
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
              </div>
            </div>

	    {{-- OBSERVACIONES (Interna y General) --}}
            <div class="">
              <div class="row">
                <div class="col-xs-6 form-group"><label for="Datos">Observación General (Se muestre en el ticket):</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-commenting-o"></i>
                    </div>
                    {!! Form::textarea('note',($ticket->note)? $ticket->note:null,['id'=>'note', 'class'=>'form-control', 'value'=> old('note'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                </div>
                <div >
                  <span class="help-block" id="error"></span>
                </div>
                </div>
                <div class="col-xs-6 form-group"><label for="Datos">Observación Interna (Únicamente lo ve el personal de la empresa):</label>
                  <div class="input-group clockpicker">
                    <div class="input-group-addon">
                      <i class="fa fa-commenting"></i>
                    </div>
                    {!! Form::textarea('obser_int',($ticket->obser_int)? $ticket->obser_int:null,['id'=>'obser_int', 'class'=>'form-control', 'value'=> old('obser_int'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                  </div>
                  <div >
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
              </div>
            </div>

          <div >{{--  panel de validar customer --}}
            <div class="">
              <div class="row">
                <div class="col-xs-6 form-group"><label for="Datos" >Tipo de pago: <code>*Obligatorio</code></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-credit-card"></i>
                    </div>
                    {!! Form::select('tipago',$gettipopay,($ticket->getPay->id)?$ticket->getPay->id:null,['id'=>'tipago','value'=>old('tipago'),'placeholder'=>'Seleccione el tipo de pago','class'=>'form-control select2', 'style'=>'width:100%'] ) !!}
                      <p id="tutorial"></p>
                    </div>
                    <div >
                      <span class="help-block" id="error"></span>
                    </div>
                </div>


                <div class="col-xs-6 form-group"><label for="Datos">Pais a invertir: <code>*Obligatorio</code></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-credit-card"></i>
                    </div>
                       {!! Form::select('painvertir', $countryinver , ($ticket->getCountryInv->id)?$ticket->getCountryInv->id:null ,['id'=>'painvertir','placeholder'=>'Seleccione el pais a invertir','class'=>'form-control select2', 'style'=>'width:100%']) !!}
                  </div>
                  <div >
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
              </div>
            </div>

          </div>{{-- panel que se oculta accionista --}}

          <div >{{--  panel de validar customer --}}
            <div class="">
              <div class="row">
                <div class="col-xs-6 form-group no"  ><label for="Datos" id="textCodigoOperacion"><span ></span>Codigo de operacion: <code>*Obligatorio</code></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-credit-card"></i>
                    </div>
                    {!!Form::text('numopera',($ticket->number_operation)? $ticket->number_operation:null,['id'=>'numopera','class'=>'form-control',
                  'placeholder' => 'Numero de operacion','maxlength'=>'80'])!!}
                    </div>
                    <div >
                      <span class="help-block" id="error"></span>
                    </div>
                </div>


                <div class="col-xs-6 form-group" id="cont_banks"><label for="Datos" >Banco: <code>*Obligatorio</code></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-bank"></i>
                    </div>
                       {!! Form::select('id_banck', $bankslist , ($ticket->id_banck)?$ticket->id_banck:null ,['id'=>'id_banck','placeholder'=>'Seleccione el banco','class'=>'form-control select2', 'style'=>'width:100%']) !!}
                  </div>
                  <div >
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
              </div>
            </div>

          </div>{{-- panel que se oculta accionista --}}
          <div class="">

            <div class="row ni">
              <div class="">

              </div>
              <?php if($img <> null): ?>

                <input type="button" value="Cargar Otra imagen" onclick="mostrar();">
              <?php endif; ?>
              <?php if ($img <> null): ?>
                <img id="myImg" onclick="javascript:this.width=600;this.height=600" src="{{$img->route_img }}" width="100" height="100" ondblclick="javascript:this.width=150;this.height=115" src="URL de la imagen" width="100"/>
              <?php endif; ?>
              <div class="col-xs-6 form-group"  id="cont_voucher_pago"><label for="Datos">Vaucher de pago: <code>*Obligatorio</code></label>
                <div class="input-group provincia">
                  <div class="input-group-addon">
                    <i class="	fa fa-upload"></i>
                  </div>
                  <div class="input-group paisval"  name="voucher">

                    <input type="file" class="form-control" id="voucher" value=""  name="voucher" accept="image/png, image/jpeg" >
                  </div>
                </div>
                <div >
                  <span class="help-block" id="error"></span>
                </div>
              </div>
              <div class="col-xs-6 form-group">

                <div >
                  <span class="help-block" id="error"></span>
                </div>
              </div>
            </div>
          </div>
          </div>
          <br>
          </div>  <!--  fin panel-body -->
      </div> <!--  fin panel-primary -->
    {{-- termina el accionista --}}


    {{-- INICIO PRODUCTO--}}

      <div class="panel panel-primary">
          <div class="panel-heading">Datos del Producto</div>
            <div class="panel-body">

              <div class="form-group">
                <div class="row">
                  <div class="col-xs-12"><label for="Datos"></label>

                    <div style="display:none;" id="load_shareholder"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i></div>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-xs-4 form-group"><label for="Datos">Codigo del Producto:</label>
                    {!! Form::text('cod_product',($ticket->getProduct[0]{'cod_product'})? $ticket->getProduct[0]{'cod_product'}:null,['id'=>'cod_product', 'class'=>'form-control', 'value'=> old('note'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                <div >
                  <span class="help-block" id="error"></span>
                </div>
                </div>
                <div class="col-xs-4 form-group"><label for="Datos">Nombre del Producto:</label>
                    {!! Form::text('name_product',($ticket->getProduct[0]{'name_product'})? $ticket->getProduct[0]{'name_product'}:null,['id'=>'name_product', 'class'=>'form-control', 'value'=> old('obser_int'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                  <div >
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
                <div class="col-xs-4 form-group"><label for="Datos">Cantidad de Acciones:</label>
                    {!! Form::text('cant',($cantAccions->getProductAction->cant)? $cantAccions->getProductAction->cant:null,['id'=>'cant', 'class'=>'form-control', 'value'=> old('note'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                <div >
                  <span class="help-block" id="error"></span>
                </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-4 form-group"><label for="Datos">Precio:</label>
                    {!! Form::text('price',($ticket->getTicketDs->price)? $ticket->getTicketDs->price:null,['id'=>'price', 'class'=>'form-control', 'value'=> old('note'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                <div >
                  <span class="help-block" id="error"></span>
                </div>
                </div>
                <div class="col-xs-4 form-group"><label for="Datos">Moneda:</label>
                    {!! Form::text('money',($moned)? $moned:null,['id'=>'money', 'class'=>'form-control', 'value'=> old('obser_int'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                  <div >
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
                <div class="col-xs-4 form-group"><label for="Datos">Total:</label>
                    {!! Form::text('total',($ticket->getTicketDs->total)? $ticket->getTicketDs->total:null,['id'=>'total', 'class'=>'form-control', 'value'=> old('note'), 'placeholder'=>'', 'rows'=>'2'] ) !!}
                <div >
                  <span class="help-block" id="error"></span>
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-4 form-group"><label for="Datos">Producto:</label>
                  <div class="input-group pais">
                    <div class="input-group-addon">
                      <i class="fa  fa-map-marker"></i>
                    </div>
                    {!! Form::select('idnameproduct',$pricelist,($pricenow)?$pricenow:null,['id'=>'idnameproduct','placeholder'=>'Seleccione el producto que desea cambiar ...','class'=>'form-control select2', 'style'=>'width: 100%', 'onchange'=>"return selectproduct(this.value);"] ) !!}
                  </div>
                  <div >
                    <span class="help-block" id="error"></span>
                  </div>
                </div>
              </div>



          <br>
          </div>  <!--  fin panel-body -->
      </div> <!--  fin panel-primary -->

    {{-- FIN PRODUCTO--}}

            {{-- inicio el accionista  --}}
              <div class="panel panel-primary">
                  <div class="panel-heading">Datos Personales</div>
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


                    <div class="">
                      <div class="row">
                        <div class="col-xs-6 form-group"><label for="Datos">Nombres: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa  fa-user"></i>
                            </div>
                            {!!Form::text('firstname',($ticket->getCustomer->first_name)?$ticket->getCustomer->first_name:null,['class'=>'form-control','autofill'=>'off',
                          'placeholder' => 'Nombres','maxlength'=>'80'])!!}
                        </div>
                        <div >
                          <span class="help-block" id="error"></span>
                        </div>
                        </div>
                        <div class="col-xs-6 form-group"><label for="Datos">Apellidos: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa  fa-user"></i>
                            </div>
                            {!! Form::text('lastname',($ticket->getCustomer->last_name)?$ticket->getCustomer->last_name:null,['class'=>'form-control',
                              'placeholder' => 'Apellidos','maxlength'=>'80'] ) !!}
                          </div>
                          <div >
                            <span class="help-block" id="error"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  <div >{{--  panel de validar customer --}}
                    <div class="">
                      <div class="row">
                        <div class="col-xs-6 form-group"><label for="Datos">Telefono: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                            {!! Form::text('phone',($ticket->getCustomer->phone)?$ticket->getCustomer->phone:null,['class'=>'form-control',
                              'placeholder' => '917.000.00','maxlength'=>'30'] ) !!}
                            </div>
                            <div >
                              <span class="help-block" id="error"></span>
                            </div>
                        </div>
                        <div class="col-xs-6 form-group"><label for="Datos">Correo: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope-o"></i>
                            </div>
                            {!! Form::email('email',($ticket->getCustomer->email)?$ticket->getCustomer->email:null,['class'=>'form-control keyup-email',
                             'placeholder' => 'ejemplo@dominio.com'] ) !!}
                          </div>
                          <div >
                            <span class="help-block" id="error"></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-6 form-group"><label for="Datos">Pais: <code>*Obligatorio</code></label>
                          <div class="input-group pais">
                            <div class="input-group-addon">
                              <i class="fa  fa-map-marker"></i>
                            </div>
                            {!! Form::select('country',$country,($ticket->getCustomer->id_country)?$ticket->getCustomer->id_country:null,['id'=>'country','placeholder'=>'Seleccione el pais donde reside ...','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                          </div>
                          <div >
                            <span class="help-block" id="error"></span>
                          </div>
                        </div>
                        <div class="col-xs-6 form-group"><label for="Datos">Departamento: <code>*Obligatorio</code></label>
                          <div class="input-group departamento">
                            <div class="input-group-addon">
                              <i class="fa  fa-map-marker"></i>
                            </div>
                            {!! Form::select('state',$state,($ticket->getCustomer->id_state)?$ticket->getCustomer->id_state:null,['id'=>'state','placeholder'=>'Seleccione la provincia donde reside','class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                          </div>
                          <div >
                            <span class="help-block" id="error"></span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="">
                      <div class="row">
                        <div class="col-xs-6 form-group"><label for="Datos">Provincia: <code>*Obligatorio</code></label>
                          <div class="input-group provincia">
                            <div class="input-group-addon">
                              <i class="fa  fa-map-marker"></i>
                            </div>
                            {!! Form::select('city',$city,($ticket->getCustomer->id_city)?$ticket->getCustomer->id_city:null,['id'=>'city','placeholder'=>'Seleccione la ciudad donde reside','class'=>'form-control select2','style'=>'width:100']) !!}
                          </div>
                          <div >
                            <span class="help-block" id="error"></span>
                          </div>
                        </div>
                        <div class="col-xs-6 form-group"><label for="Datos">Dirección: <code>*Obligatorio</code></label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa  fa-map-marker"></i>
                            </div>
                            {!! Form::textarea('address',($ticket->getCustomer->address)?$ticket->getCustomer->address:null,['class'=>'form-control','style'=>'width:100%', 'placeholder'=>'Av/Calle/Edificio...', 'rows'=>'2'] ) !!}
                          </div>
                          <div >
                            <span class="help-block" id="error"></span>
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
{!! Form::hidden('id_ticket',$ticket->id, array('id' => 'id_ticket'))!!}

<tr>
  <th></th>
    <td>
      <b>  {!!Form::submit('Actualizar', array('class' => 'btn btn-success '))!!}</b>
    </td>
</tr>

  </table>
{!! Form::close() !!}
</section>
@endsection

@section('js')

<script src="{{ asset('plugins/jqueryvalidate/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jqueryvalidate/jquery.validate.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('js/Ticket/editarticket.js')}} "></script>

<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>

@endsection
