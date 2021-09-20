@extends('layout-backend')
@section('title', 'Reporte del conductor')

@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyDQCZESZB5v0-ReeZYUcXWRbOb2IDaJR_8",
    authDomain: "voucher-img-fb702.firebaseapp.com",
    databaseURL: "https://voucher-img-fb702.firebaseio.com",
    projectId: "voucher-img-fb702",
    storageBucket: "voucher-img-fb702.appspot.com",
    messagingSenderId: "807276908227"
  };
  firebase.initializeApp(config);
  var storage = firebase.storage();
</script>
@endsection

@section('content')
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-md-6">
      {{-- DATOS PERSONALES --}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">PERSONAL</h3>
            <input id="id" name="id" type="hidden" value="{{$id}}">
            <div class="box-tools pull-right">
            {{-- <button type="button" class="btn btn-box-tool btn-expand" data-widget="collapse" id="ids" vergene = "{{ $permisover }}" verespe = "{{ $permisoverespe }}" rolid="{{ $rolid }}"><i class="fa fa-minus"></i></button> --}}
            </div>
          </div>
          <div class="box-body">
            <form  id=formPersonal>
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="form-group" id="personaltodo">
                <div class="row">
                  <div class="col-xs-6"><b>NOMBRES    </b></div>
                  <div class="col-xs-6">
                    <div class="verPersonal">{{ ($DriverQuery[0]->getUserOffice->first_name )? $DriverQuery[0]->getUserOffice->first_name : '-'}}</div>
                    <div class="editarPersonal" style="display:none">{!! Form::text('first_name', $DriverQuery[0]->getUserOffice->first_name, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>APELLIDOS  </b></div>
                  <div class="col-xs-6">
                    <div class="verPersonal">{{ ($DriverQuery[0]->getUserOffice->last_name )? $DriverQuery[0]->getUserOffice->last_name : '-'}}</div>
                    <div class="editarPersonal" style="display:none">{!! Form::text('last_name', $DriverQuery[0]->getUserOffice->last_name, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>CORREO     </b></div>
                  <div class="col-xs-6">
                    <div class="verPersonal">{{ ($DriverQuery[0]->getUserOffice->email )? $DriverQuery[0]->getUserOffice->email : '-'}}</div>
                    <div class="editarPersonal" style="display:none">{!! Form::text('email', $DriverQuery[0]->getUserOffice->email, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>TELÉFONO   </b></div>
                  <div class="col-xs-6">
                    <div class="verPersonal">{{ ($DriverQuery[0]->getUserOffice->phone )? $DriverQuery[0]->getUserOffice->phone : '-'}}</div>
                    <div class="editarPersonal" style="display:none">{!! Form::text('phone', $DriverQuery[0]->getUserOffice->phone, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>{{ ($DriverQuery[0]->getUserOffice->typeDocuments->description )? $DriverQuery[0]->getUserOffice->typeDocuments->description : 'DNI'}}  </b></div>
                  <div class="col-xs-6">
                    <div class="verPersonal"> {{ ($DriverQuery[0]->getUserOffice->document )? $DriverQuery[0]->getUserOffice->document : '-'}}</div>
                    <div class="editarPersonal" style="display:none">{!! Form::select('id_type_documents', $type_docs, $DriverQuery[0]->getUserOffice->id_type_documents, ['class' => 'form-control input-sm']) !!}</div>
                    <div class="editarPersonal" style="display:none">{!! Form::text('document', $DriverQuery[0]->getUserOffice->document, ['class' => 'form-control input-sm']) !!}</div>

                  </div>

                  <div class="col-xs-6"><b>PAIS:      </b></div>
                  <div class="col-xs-6">
                    {{ ($DriverQuery[0]->getUserOffice->country )? $DriverQuery[0]->getUserOffice->country : '-'}}
                  </div>

                  <div class="col-xs-6"><b>DOCUMENTOS </b></div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-primary fa fa-eye" onclick="viewModal('personal');"></button>
                  </div>

                  <div  class="col-xs-6" align="left">
                    @if (!$DriverQuery[0]->getDriverApi->driverid)
                      <div class="verPersonal"><a onclick="editarButtonPersonal({{$DriverQuery[0]->getUserOffice->id}});">Editar</a></div>
                    @endif

                    <div class="editarPersonal" style="display:none"><b>
                      <a onclick="guardarButton({{$DriverQuery[0]->getUserOffice->id}}, 'formPersonal');">Guardar</a>
                      <a onclick="editarButtonPersonal({{$DriverQuery[0]->getUserOffice->id}});">Cancelar</a>

                    </div>
                  </div>

                </div>
              </div>
            </form>
            <div id="personalcargando" class="row caruselphoto" align="center" style="display:none">
              <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" alt="User Image"  style="width: 200px;height: 150px">
              <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
            </div>
          </div>

        </div>
      {{-- DATOS PERSONALES --}}
    </div>
    <div class="col-xs-12 col-md-6">
      {{-- DETALLE CONDUCTOR --}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">CONDUCTOR</h3>
          </div>
          <div class="box-body">
            <form  id=formConductor>
              <div class="row" id="conductortodo">
                <div class="col-xs-6"><b>N° LICENCIA </b></div>
                <div class="col-xs-6">
                  <div class="verConductor">{{ ($DriverQuery[0]->licencia )? $DriverQuery[0]->licencia : '-'}}</div>
                  <div class="editarConductor" style="display:none">{!! Form::text('licencia', $DriverQuery[0]->licencia, ['class' => 'form-control input-sm']) !!}</div>
                </div>

                <div class="col-xs-6"><b>CATEGORIA   </b></div>
                <div class="col-xs-6">
                  <div class="verConductor">{{ ($DriverQuery[0]->classcategoria )? $DriverQuery[0]->classcategoria : '-'}}</div>
                  <div class="editarConductor" style="display:none">{!! Form::text('classcategoria', $DriverQuery[0]->classcategoria, ['class' => 'form-control input-sm']) !!}</div>
                </div>

                <div class="col-xs-6"><b>F. EMICIÓN  </b></div>
                <div class="col-xs-6">
                  <div class="verConductor">{{ ($DriverQuery[0]->licfecemi )? $DriverQuery[0]->licfecemi : '-'}}</div>
                  <div class="editarConductor" style="display:none">{!! Form::date('licfecemi', $DriverQuery[0]->licfecemi, ['class' => 'form-control input-sm']) !!}</div>
                </div>

                <div class="col-xs-6"><b>F. EXP      </b></div>
                <div class="col-xs-6">
                  <div class="verConductor">{{ ($DriverQuery[0]->licfecven )? $DriverQuery[0]->licfecven : '-'}}</div>
                  <div class="editarConductor" style="display:none">{!! Form::date('licfecven', $DriverQuery[0]->licfecven, ['class' => 'form-control input-sm']) !!}</div>
                </div>

                <div class="col-xs-6"><b>N° PUNTOS   </b></div>
                <div class="col-xs-6">{{ ($pun )? $pun : '-'}}</div>

                <div class="col-xs-6"><b>PERFIL</b></div><div class="col-xs-6">
                  <button type="button" class="btn btn-primary fa fa-eye" onclick="viewModal('perfil');"></button>
                </div>
                <div class="col-xs-6"><b>DOCUMENTOS</b></div><div class="col-xs-6">
                  <button type="button" class="btn btn-primary fa fa-eye" onclick="viewModal('conductor');"></button>
                </div>
                <div  class="col-xs-6" align="left">
                  @if (!$DriverQuery[0]->getDriverApi->driverid)
                    <div class="verConductor"><a onclick="editarButtonConductor({{$DriverQuery[0]->id}});">Editar</a></div>
                  @endif
                  <div class="editarConductor" style="display:none"><b>
                    <a onclick="guardarButton({{$DriverQuery[0]->id}}, 'formConductor');">Guardar</a>
                    <a onclick="editarButtonConductor({{$DriverQuery[0]->id}});">Cancelar</a>
                  </div>
                </div>
              </div>
            </form>
          <div id="conductorcargando" class="row caruselphoto" align="center" style="display:none">
            <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" alt="User Image" style="width: 200px;height: 150px">
            <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
          </div>
          </div>
        </div>
      {{-- DETALLE CONDUCTOR --}}
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-md-6">
      {{-- DETALLE VEHICULO --}}
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">VEHICULO</h3>
            </div>
            <div class="box-body">
              <form id="formVehiculo">
                <div class="row" id="vehiculotodo">
                  <div class="col-xs-6"><b>PLACA/MATRICULA   </b></div>
                  <div class="col-xs-6">
                    <div class="verVehiculo">{{ ($DriverQuery[0]->placa )? $DriverQuery[0]->placa : '-'}}</div>
                    <div class="editarVehiculo" style="display:none">{!! Form::text('placa', $DriverQuery[0]->placa, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>COLOR             </b></div>
                  <div class="col-xs-6">
                    <div class="verVehiculo">{{ ($DriverQuery[0]->color_car )? $DriverQuery[0]->color_car : '-'}}</div>
                    <div class="editarVehiculo" style="display:none">{!! Form::text('color_car', $DriverQuery[0]->color_car, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>MARCA             </b></div>
                  <div class="col-xs-6">
                    <div class="verVehiculo">{{ ($DriverQuery[0]->marca )? $DriverQuery[0]->marca : '-'}}</div>
                    <div class="editarVehiculo" style="display:none">{!! Form::text('marca', $DriverQuery[0]->marca, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>AÑO               </b></div>
                  <div class="col-xs-6">
                    <div class="verVehiculo">{{ ($DriverQuery[0]->year )? $DriverQuery[0]->year : '-'}}</div>
                    <div class="editarVehiculo" style="display:none">{!! Form::text('year', $DriverQuery[0]->year, ['class' => 'form-control input-sm']) !!}</div>
                  </div>

                  <div class="col-xs-6"><b>DOCUMENTOS        </b></div>
                  <div class="col-xs-6">
                    <button type="button" class="btn btn-primary fa fa-eye" onclick="viewModal('vehiculo');"></button>
                  </div>
                  <div  class="col-xs-6" align="left">
                    @if (!$DriverQuery[0]->getDriverApi->vehicleid)
                      <div class="verVehiculo"><a onclick="editarButtonVehiculo({{$DriverQuery[0]->id}});">Editar</a></div>
                    @endif
                    <div class="editarVehiculo" style="display:none"><b>
                      <a onclick="guardarButton({{$DriverQuery[0]->id}}, 'formVehiculo');">Guardar</a>
                      <a onclick="editarButtonVehiculo({{$DriverQuery[0]->id}});">Cancelar</a>
                    </div>
                  </div>
              </div>
              </form>
              <div id="vehiculocargando" class="row caruselphoto" align="center" style="display:none">
                <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" style="width: 200px;height: 150px">
                <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
              </div>
            </div>
          </div>
      {{-- DETALLE VEHICULO --}}
    </div>
    <div class="col-xs-12 col-md-6">
      {{-- DETALLE SEGURO --}}
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">SEGURO</h3>
          </div>
          <div class="box-body">
            <form id="formSeguro">
              <div class="row" id="segurotodo">
                <div class="col-xs-6"><b>COMPAÑIA           </b></div>
                <div class="col-xs-6">
                  <div class="verSeguro">{{ ($DriverQuery[0]->enterprisesoat )? $DriverQuery[0]->enterprisesoat : '-'}}</div>
                  <div class="editarSeguro" style="display:none">{!! Form::text('enterprisesoat', $DriverQuery[0]->enterprisesoat, ['class' => 'form-control input-sm']) !!}</div>
                </div>
                <div class="col-xs-6"><b>ESTADO         </b></div>
                <div class="col-xs-6">
                  <div class="verSeguro">{{ ($DriverQuery[0]->est_soat )? $DriverQuery[0]->est_soat : '-'}}</div>
                  <div class="editarSeguro" style="display:none">{!! Form::text('est_soat', $DriverQuery[0]->est_soat, ['class' => 'form-control input-sm']) !!}</div>
                </div>


              <div class="col-xs-6"><b>FECHA DE INICIO  </b></div>
              <div class="col-xs-6">
                <div class="verSeguro">{{ ($DriverQuery[0]->soatfecemi )? $DriverQuery[0]->soatfecemi : '-'}}</div>
                <div class="editarSeguro" style="display:none">{!! Form::date('soatfecemi', $DriverQuery[0]->soatfecemi, ['class' => 'form-control input-sm']) !!}</div>
              </div>

              <div class="col-xs-6"><b>FECHA DE FIN     </b></div>
              <div class="col-xs-6">
                <div class="verSeguro">{{ ($DriverQuery[0]->soatfecven )? $DriverQuery[0]->soatfecven : '-'}}</div>
                <div class="editarSeguro" style="display:none">{!! Form::date('soatfecven', $DriverQuery[0]->soatfecven, ['class' => 'form-control input-sm']) !!}</div>
              </div>

              <div class="col-xs-6"><b>DOCUMENTOS       </b></div>
              <div class="col-xs-6">
                <button type="button" class="btn btn-primary fa fa-eye" onclick="viewModal('seguro');"></button>
              </div>

              <div  class="col-xs-6" align="left">
                @if (!$DriverQuery[0]->getDriverApi->vehicleid)
                <div class="verSeguro"><a onclick="editarButtonSeguro({{$DriverQuery[0]->id}});">Editar</a></div>
                @endif
                <div class="editarSeguro" style="display:none"><b>
                  <a onclick="guardarButton({{$DriverQuery[0]->id}}, 'formSeguro');">Guardar</a>
                  <a onclick="editarButtonSeguro({{$DriverQuery[0]->id}});">Cancelar</a>
                </div>
              </div>
            </div>
            </form>
            <div id="segurocargando" class="row caruselphoto" align="center" style="display:none">
              <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" style="width: 200px;height: 150px">
              <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
            </div>
          </div>
        </div>
      {{-- DETALLE SEGURO --}}
    </div>
  </div>

  {{-- PROCESO DE VALIDACION --}}
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">PROCESO DE VALIDACION</h3>
      </div>
      <div class="box-body">
        <div class="table table-striped w-auto">
          <table id="tableprocesoValidacion"  class="table" >
            <thead>
              <tr>
                <th>PROCESO</th>
                <th>COMPLETADO</th>
                <th>USUARIO RESP.</th>
                <th>CREADO</th>
                <th>ACTUALIZACION</th>
                <th>ACCION</th>
                <th>ESTADO</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <tr>
                <th>PROCESO</th>
                <th>COMPLETADO</th>
                <th>USUARIO RESP.</th>
                <th>CREADO</th>
                <th>ACTUALIZACION</th>
                <th>ACCION</th>
                <th>ESTADO</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  {{-- PROCESO DE VALIDACION --}}

  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">REPORTES</h3>
    </div>
    <div class="box-body">
        <div class="row">
          <div class="col-xs-6"><b>GENERAL</b></div>
          <div class="col-xs-6">
            <button type="button" class="btn btn-primary fa fa-file-word-o" onclick="return reporte()"></button>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-xs-6"><b>RECORD</b></div>
          <div class="col-xs-6">
            <button type="button" class="btn btn-primary fa fa-file-word-o" onclick="return record()"></button>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-xs-6"><b>ANTECEDENTES PENALES</b></div>
          <div class="col-xs-6">
            <button type="button" class="btn btn-primary fa fa-file-word-o" onclick="openFile( '{{ ($DriverQuery[0]->url_antecedentes )?  $DriverQuery[0]->url_antecedentes : null }}'  )"></button>
            <button type="button" class="btn btn-primary fa fa-rotate-left" onclick="return updatePhotoButton('antecedente')"></button>
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-xs-6"><b>REVISION TECNICA</b></div>
          <div class="col-xs-6">
            <button type="button" class="btn btn-primary fa fa-file-word-o" onclick="revisiontecnica()"></button>
            <button type="button" class="btn btn-primary fa fa-rotate-left" onclick="return updatePhotoButton('revisiontecnica')"></button>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-xs-6"><b>RECIBO DE LUZ</b></div>
          <div class="col-xs-6">
            <button type="button" class="btn btn-primary fa fa-file-word-o" onclick="openFile( '{{ ($DriverQuery[0]->recibo_luz )? $DriverQuery[0]->recibo_luz : null }}' )"></button>
            <button type="button" class="btn btn-primary fa fa-rotate-left" onclick="return updatePhotoButton('reciboluz')"></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- detealle OK --}}


{!! Form::hidden('driverid',  ($DriverQuery[0]->getDriverApi->driverid) ? $DriverQuery[0]->getDriverApi->driverid : 'null',   ['id'=> 'driverid',  'class' => 'form-control input-sm']) !!}
{!! Form::hidden('vehicleid', ($DriverQuery[0]->getDriverApi->vehicleid) ? $DriverQuery[0]->getDriverApi->vehicleid : 'null', ['id'=> 'vehicleid', 'class' => 'form-control input-sm']) !!}


</section>


  <div class="modal fade" id="mymodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel panel-info">
            <div class="panel-heading">Fotos</div>
            {!! Form::hidden('buttonphoto',null, ['id'=> 'buttonphoto', 'class' => 'form-control input-sm']) !!}
            <div class="panel-body">
              <div id="personal" class="carousel slide carusel" style="display:none" >
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  </ol>
                  <div class="carousel-inner">
                   <div class="item active">
                      <img src="{{ ($DriverQuery[0]->doc_front)? $DriverQuery[0]->doc_front    :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                    </div>
                    <div class="item">
                      <img src="{{ ($DriverQuery[0]->doc_back)? $DriverQuery[0]->doc_back          :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                    </div>
                  </div>

                  <a class="left carousel-control" href="#personal" data-slide="prev">
                    <span class="fa fa-angle-left"></span>
                  </a>
                  <a class="right carousel-control" href="#personal" data-slide="next">
                    <span class="fa fa-angle-right"></span>
                  </a>
                </div>

              <div id="conductor" class="carousel slide carusel" style="display:none" >
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    </ol>
                    <div class="carousel-inner">
                     <div class="item active">
                        <img src="{{ ($DriverQuery[0]->lic_frontal)? $DriverQuery[0]->lic_frontal    :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                      </div>
                      <div class="item">
                        <img src="{{ ($DriverQuery[0]->lic_back)?    $DriverQuery[0]->lic_back       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                      </div>
                    </div>

                    <a class="left carousel-control" href="#conductor" data-slide="prev">
                      <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#conductor" data-slide="next">
                      <span class="fa fa-angle-right"></span>
                    </a>
                  </div>

              <div id="vehiculo" class="carousel slide carusel" style="display:none" >
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="4" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="5" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="6" class=""></li>

                </ol>
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="{{ ($DriverQuery[0]->tar_veh_frontal)?    $DriverQuery[0]->tar_veh_frontal       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                  <div class="item">
                    <img src="{{ ($DriverQuery[0]->tar_veh_back)?    $DriverQuery[0]->tar_veh_back       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                 <div class="item">
                    <img src="{{ ($DriverQuery[0]->car_interna)?    $DriverQuery[0]->car_interna    :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                  <div class="item">
                    <img src="{{ ($DriverQuery[0]->car_interna2)?   $DriverQuery[0]->car_interna2       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                  <div class="item">
                    <img src="{{ ($DriverQuery[0]->car_externa)?    $DriverQuery[0]->car_externa       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                  <div class="item">
                    <img src="{{ ($DriverQuery[0]->car_externa2)?    $DriverQuery[0]->car_externa2       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                  <div class="item">
                    <img src="{{ ($DriverQuery[0]->car_externa3)?    $DriverQuery[0]->car_externa3       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                </div>

                <a class="left carousel-control" href="#vehiculo" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#vehiculo" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>

              <div id="seguro"   class="carousel slide carusel" style="display:none" >
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                </ol>
                <div class="carousel-inner">
                 <div class="item active">
                    <img src="{{ ($DriverQuery[0]->soat_back)?     $DriverQuery[0]->soat_back    :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                  <div class="item">
                    <img src="{{ ($DriverQuery[0]->soat_frontal)?   $DriverQuery[0]->soat_frontal       :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                  </div>
                </div>

                <a class="left carousel-control" href="#seguro" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#seguro" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>

              <div id="perfil"   class="carousel slide carusel" style="display:none" >
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                </ol>
                <div class="carousel-inner">
                 <div class="item active">
                    <img src="{{ ($DriverQuery[0]->photo_perfil)?     $DriverQuery[0]->photo_perfil    :  asset('imagenes/noimage.png')  }}" alt=""  style="width: 500px;height: 300px">
                    <a href="{{ ($DriverQuery[0]->photo_perfil)?     $DriverQuery[0]->photo_perfil    :  asset('imagenes/noimage.png')  }}" target="_blank" download="FotoPerfil">VerCompleta</a>
                    <img id="imgSalida" width="50%" height="50%" src="" />
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" name="updbutton" id="updbutton" onclick="updatePhotoButton('null');">Actualizar</button>
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalupdphoto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel panel-info">
            <div class="panel-heading">Fotos</div>
            <div class="panel-body">

              <div id="personalupd" class="caruselphoto" style="display:none"  >
                <form id="formPersonalPhoto"  method = "POST" enctype= "multipart/form-data">
                  <label for="banner">DNI:</label>
                    <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      LADO A<input type='file' class="form-control" id="doc_front" name="doc_front" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="doc_front_cap" readonly="readonly" name="doc_front_cap" type="text" value="">
                    </div>
                    </div>
                  </div>

                    <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                      <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                        LADO B<input type='file' class="form-control" id="doc_back" name="doc_back" accept="image/x-png,image/gif,image/jpeg">
                        </span>
                        </label>
                        <input class="form-control" id="doc_back_captura" readonly="readonly" name="doc_back_captura" type="text" value="">
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div id="conductorupd" class="caruselphoto" style="display:none" >
                <form id="formConductorPhoto"  method = "POST" enctype= "multipart/form-data">
                  <label for="banner">LICENCIA:</label>
                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      (LADO A)<input type='file' class="form-control" id="lic_frontal" name="lic_frontal" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="lic_frontal_cap" readonly="readonly" name="lic_frontal_cap" type="text" value="">
                    </div>
                    </div>
                  </div>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                      <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                        (LADO B)<input type='file' class="form-control" id="lic_back" name="lic_back" accept="image/x-png,image/gif,image/jpeg">
                        </span>
                        </label>
                        <input class="form-control" id="lic_back_cap" readonly="readonly" name="lic_back_cap" type="text" value="">
                      </div>
                    </div>
                  </div>

                </form>
              </div>

              <div id="vehiculoupd" class="caruselphoto" style="display:none"  >
                <form id="formVehiculolPhoto"  method = "POST" enctype= "multipart/form-data">
                  <label for="banner">TARJETA VEHICULAR:</label>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      ( LADO A )<input type='file' class="form-control" id="tar_veh_frontal" name="tar_veh_frontal" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="tar_veh_frontal_cap" readonly="readonly" name="tar_veh_frontal_cap" type="text" value="">
                    </div>
                    </div>
                  </div>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                      <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                        ( LADO B  )<input type='file' class="form-control" id="tar_veh_back" name="tar_veh_back" accept="image/x-png,image/gif,image/jpeg">
                        </span>
                        </label>
                        <input class="form-control" id="tar_veh_back_cap" readonly="readonly" name="tar_veh_back_cap" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <label for="banner">INTERNA:</label>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      ( CONDUCTOR )<input type='file' class="form-control" id="car_interna" name="car_interna" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="car_interna_cap" readonly="readonly" name="car_interna_cap" type="text" value="">
                    </div>
                    </div>
                  </div>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                      <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                        (    PASAJERO    )<input type='file' class="form-control" id="car_interna2" name="car_interna2" accept="image/x-png,image/gif,image/jpeg">
                        </span>
                        </label>
                        <input class="form-control" id="car_interna2_cap" readonly="readonly" name="car_interna2_cap" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <label for="banner">EXTERNA:</label>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      ( FRONTAL)<input type='file' class="form-control" id="car_externa" name="car_externa" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="car_externa_cap" readonly="readonly" name="car_externa_cap" type="text" value="">
                    </div>
                    </div>
                  </div>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                      <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                        (   LADO A  )<input type='file' class="form-control" id="car_externa2" name="car_externa2" accept="image/x-png,image/gif,image/jpeg">
                        </span>
                        </label>
                        <input class="form-control" id="car_externa2_cap" readonly="readonly" name="car_externa2_cap" type="text" value="">
                      </div>
                    </div>
                  </div>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                      <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                        (  LADO B  )<input type='file' class="form-control" id="car_externa3" name="car_externa3" accept="image/x-png,image/gif,image/jpeg">
                        </span>
                        </label>
                        <input class="form-control" id="car_externa3_cap" readonly="readonly" name="car_externa3_cap" type="text" value="">
                      </div>
                    </div>
                  </div>

                </form>
              </div>

              <div id="seguroupd"   class="caruselphoto" style="display:none"  >
                <form id="formSeguroPhoto"  method = "POST" enctype= "multipart/form-data">
                  <label for="banner">SEGURO:</label>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      (LADO A)<input type='file' class="form-control" id="soat_frontal" name="soat_frontal" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="soat_frontal_cap" readonly="readonly" name="soat_frontal_cap" type="text" value="">
                    </div>
                    </div>
                  </div>

                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                      <div class="input-group">
                        <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                        (LADO B)<input type='file' class="form-control" id="soat_back" name="soat_back" accept="image/x-png,image/gif,image/jpeg">
                        </span>
                        </label>
                        <input class="form-control" id="soat_back_cap" readonly="readonly" name="soat_back_cap" type="text" value="">
                      </div>
                    </div>
                  </div>

                </form>
              </div>

              <div id="perfilupd"   class="caruselphoto" style="display:none"  >
                  <label for="banner">PERFIL:</label>
                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      (DE FRENTE)<input type='file' class="form-control" id="photo_perfil" name="photo_perfil" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="photo_perfil_cap" readonly="readonly" name="photo_perfil_cap" type="text" value="">
                    </div>
                    </div>
                  </div>
              </div>

              <div id="antecedenteupd"   class="caruselphoto" style="display:none"  >
                  <label for="banner">ANTECEDENTES PENALES:</label>
                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      PDF<input type='file' class="form-control" id="url_antecedentes" name="url_antecedentes" accept="application/pdf">
                      </span>
                      </label>
                      <input class="form-control" id="url_antecedentes_cap" readonly="readonly" name="url_antecedentes_cap" type="text" value="">
                    </div>
                    </div>
                  </div>
              </div>

              <div id="revisiontecnicaupd"   class="caruselphoto" style="display:none"  >
                  <label for="banner">REVISION TECNICA:</label>
                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      IMG<input type='file' class="form-control" id="revision_tecnica" name="revision_tecnica" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="revision_tecnica_cap" readonly="readonly" name="revision_tecnica_cap" type="text" value="">
                    </div>
                    </div>
                  </div>
              </div>

              <div id="reciboluzupd"   class="caruselphoto" style="display:none"  >
                  <label for="banner">RECIBO DE LUZ:</label>
                  <div class="container">
                    <div class="form-group col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-btn">
                      <span class="btn btn-primary btn-file">
                      IMG<input type='file' class="form-control" id="recibo_luz" name="recibo_luz" accept="image/x-png,image/gif,image/jpeg">
                      </span>
                      </label>
                      <input class="form-control" id="recibo_luz_cap" readonly="readonly" name="recibo_luz_cap" type="text" value="">
                    </div>
                    </div>
                  </div>
              </div>

              <div id="cargando" class="row caruselphoto" align="center" style="display:none">
                <img src="{{ asset('imagenes/cargando.gif')}}" class="user-image" alt="User Image">
                <div>NO CIERRE ESPERE MIENTRAS CARGA</div>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="nophoto"> <button type="button" class="btn btn-primary pull-left" onclick="verPhoto();">Ver Fotos</button></div>
          <button type="button" class="btn btn-primary" onclick="updatePhoto({{$DriverQuery[0]->id}}, {{$DriverQuery[0]->getUserOffice->id}} );">Actualizar</button>
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
      <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
    </div>
  </div> -->

  <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
      <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
      {{--
        <div id="row">
            <div id="cantidadSubidas" style="color: blue">
                <h2>  0</h2>
            </div> de 10
        </div>
      --}}
    </div>
  </div>
  @endsection

  @section('js')

  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>

  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>



  <script src="{{ asset('js/External/Driver/detalle.js')}} "></script>

  @endsection
