@extends('layouts.app')
@section('title', 'Editar del Conductor')

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')


<section class="content-header">
  <button type="button" href="{{route('driver.index')}}"  class="btn btn-info pull-right" >
     <i class="fa fa-list" aria-hidden="true"></i>  <a href="{{ route('driver.index') }}">Listado</a>
   </button>
    <br><br>
</section>

<section class="content">
  <div class="box">

    <div class="box-header">
      <h3 class="box-title">Información   -  |  {{ $driver->lastname }},{{ $driver->name }} </h3>
    </div>


    <div class="box-body">
      <form method="POST" action="{{ url("drivers/$driver->id") }}">
          {{ method_field('PUT') }}
          {{ csrf_field() }}


          <div class="row">
            <div class="col-xs-6">
                    <label for="Datos">Datos Personales:</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-user"></i></div>
                      {!! Form::text('name',     $driver->name,        ['id'=>'name',    'class'=>'form-control',] ) !!}
                     <div class="input-group-addon"><i class="fa fa-user"></i></div>
                      {!! Form::text('lastname', $driver->lastname,    ['id'=>'lastname','class'=>'form-control'] ) !!}
                    </div>

                    <div class="form-group">
                        <label for="Datos">Documento de Identidad:</label>
                      <div class="input-group">
                       <div class="input-group-addon">
                         <i class="fa fa-500px"></i>
                       </div>
                        {!! Form::text('document', $driver->document,['id'=>'document', 'class'=>'form-control', 'placeholder' => '99.9999.99', 'disabled' => 'disabled' ] ) !!}
                      </div>
                    </div>

                    <div class="form-group">
                     <div class="row">

                         <div class="col-xs-6"><label>Fecha de Nacimiento:</label>
                           <div class="input-group">
                             <div class="input-group-addon">
                               <i class="fa fa-calendar"></i>
                             </div>
                             {!! Form::text('birthdate', null,['id'=>'birthdate', 'class'=>'form-control', 'data-inputmask'=> 'alias:yyyy-mm-dd', 'data-mask',  'value'=> old('birthdate')] ) !!}
                          </div>
                        </div>

                          <div class="col-xs-6"><label>Pais de Nacimiento:</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-map"></i>
                              </div>
                              {!! Form::select('id_nationality', $country, null,['id'=>'id_nationality', 'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                           </div>
                         </div>
                    </div>
                    </div>

                    <label for="Datos">Correo Electrónico</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-envelope-o"></i>
                        </div>
                       {!! Form::email('email', $driver->email, ['id'=>'email', 'class'=>'form-control', 'placeholder' => 'taxiwin@conductores.com'] ) !!}
                    </div>

                    <label for="Datos">Telefono:</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                       {!! Form::text('phone',$driver->phone,['id'=>'phone', 'class'=>'form-control', 'data-inputmask'=> 'mask:(999) 999-9999', 'data-mask']) !!}
                    </div><br>

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa  fa-venus-double"></i>
                      </div>
                      @if($driver->gender == 'F')
                        <label class="radio-inline">{!! Form::radio('gender', 'F', 'TRUE') !!} Mujer </label>
                        <label class="radio-inline">{!! Form::radio('gender', 'M') !!} Hombre </label>
                      @else
                        <label class="radio-inline">{!! Form::radio('gender', 'F') !!} Mujer </label>
                        <label class="radio-inline">{!! Form::radio('gender', 'M', 'TRUE') !!} Hombre </label>
                      @endif
                    </div><br><br>
            </div>
            <div class="col-xs-6">

                  <label for="Datos">Dirección Completa:</label>
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Pais:</label>
                      {!! Form::select('id_country_address', $country, $driver->id_country_address,['id'=>'id_country_address', 'class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                    </div>
                    <div class="col-xs-6">
                      <label>Departamento:</label>
                      {!! Form::select('id_state_address', $state, $driver->id_state_address, ['id'=>'id_state_address', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                    </div>
                  </div>
                  <div class="row">
                     <div class="col-xs-6">
                        <label>Provincia:</label> {!! Form::select('id_city_address',$city, $driver->id_city_address, ['id'=>'id_city_address',     'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                      </div>
                      <div class="col-xs-6">
                        <label>Distrito:</label> {!! Form::select('id_district_address', $district, $driver->id_district_address,['id'=>'id_district_address', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                     </div>
                  </div> <br>
                  <div class="input-group">
                    <div class="input-group-addon"> <i class="fa fa-child"></i> </div>
                    {!! Form::textarea('address', $driver->address,['id'=>'address', 'class'=>'form-control', 'value'=> old('address'),  'placeholder'=>'Av/Calle/Edificio...', 'rows'=>'2'] ) !!}
                  </div>
                  <label for="Datos">Ruta del Conductor:</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-car"></i></div>
                     {!! Form::select('id_city_driver',$city, $driver->id_city_driver, ['id'=>'id_city_driver',     'class'=>'form-control select2',  'style'=>'width: 100%']) !!}
                  </div>

            </div>
          </div>
          @if( $driver->getVehicle )
          <div class="form-group">
            <label for="Datos">Datos de Vehiculo: </label>
            <div class="row">
              <div class="col-xs-6">
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-car"></i>
                  </div>
                  {!! Form::text('model_year', $driver->getVehicle->model_year,['id'=>'model_year', 'class'=>'form-control', 'placeholder' => 'Año. Ej:.2018'] ) !!}
                 <div class="input-group-addon">
                   <i class="fa fa-car"></i>
                 </div>
                  {!! Form::text('model', $driver->getVehicle->model,['id'=>'model', 'class'=>'form-control', 'placeholder' => 'Modelo. Ej:. Toyota'] ) !!}
            </div></div>
            <div class="col-xs-6">
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-car"></i>
                  </div>
                  {!! Form::text('color', $driver->getVehicle->color,['id'=>'color', 'class'=>'form-control', 'placeholder' => 'Color. Ej:.Negro'] ) !!}
                 <div class="input-group-addon">
                   <i class="fa fa-car"></i>
                 </div>
                  {!! Form::text('serial', $driver->getVehicle->serial,['id'=>'serial', 'class'=>'form-control', 'placeholder' => 'Serial. Ej:. ACBAUJ585SAJHD5'] ) !!}
            </div></div>
              <div class="col-xs-6"><br>
            <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-car"></i>
                  </div>
                  {!! Form::text('plate', $driver->getVehicle->plate,['id'=>'plate', 'class'=>'form-control', 'placeholder' => 'Placa. Ej:.A-858A'] ) !!}
            </div><br>
            <div class="input-group">
             <div class="input-group-addon">
               <i class="fa fa-car"></i>
             </div>
             {!! Form::textarea('note', $driver->getVehicle->note,['id'=>'note', 'class'=>'form-control',  'placeholder'=>'Observaciones/Notas...', 'rows'=>'2'] ) !!}
            </div>
            </div>    </div>

          </div>
          @endif


        <div class="input-group">
          <button type="submit" class="btn btn-primary pull-right">Actualizar</button><br><br><br>
        </div>
      </form>
    </div>


  </div>
</section>



@endsection

@section('js')

<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('js/Driver/edit.js')}}"></script>
@endsection
