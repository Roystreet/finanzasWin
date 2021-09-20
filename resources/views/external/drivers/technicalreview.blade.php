@extends('layout-backend')
@section('title', 'Revision tecnica')
@section('css')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link href="{{  asset('css/style-driver.css')}}" rel="stylesheet" type="text/css">
@endsection


@section('content')
<section class="content">
  <h4>Control y analisis vehicular:</h4>
  <code>Campos obligatorios ( * )</code>
  <hr>
  <form class="form-horizontal" action="#" id="formtechnicalreview" enctype="multipart/form-data">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-12 col-sm-4 col-md-3 padd" for="idoffice">ID de la oficina virtual:<code>*</code></label>
            <div class="col-xs-8 col-sm-5 col-md-7 padd" style="display: flex;">
              <input type="text" class="form-control" id="idoffice" placeholder="Ingresar el ID" name="idoffice">
            </div>
              <div class="col-xs-4 col-sm-3 col-md-2 padd" style="display: flex;">
                <button type="button" id="btn_search" class="btn btn-success">Buscar</button>
              </div>
          </div>
          <div  class="col-md-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="document">Tipo de documento de identidad: <code>*</code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                {!! Form::select('tipdocid', $type_docs, null, ['id'=>'tipdocid','placeholder'=>'SELECCIONAR','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
            </div>
         </div>
          <div  class="col-md-12 col-md-6 padd2">
            <label class="col-xs-12 col-sm-3 col-md-4 padd" for="document">Numero de documento de identidad: <code>*</code></label>
            <div class="col-xs-12 col-sm-9 col-md-8 padd">
                <input type="text" class="form-control" id="document" placeholder="Ingresar DNI" name="document">
            </div>
         </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="nameuser">Nombres:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="nameuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="apeuser">Apellidos:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="apeuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="phoneuser">Telefono:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="phoneuser"></div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="emailuser">Correo:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="emailuser">
              </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="placafile">Placa:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="placafile">
                <input type="text" class="form-control" id="placa" placeholder="Ingresar placa" name="placa">
              </div>
          </div>
          <div  class="col-xs-12 col-md-6 padd2">
              <label class="col-xs-12 col-sm-3 col-md-4 padd" for="yearfile">Año carro:<code>*</code></label>
              <div class="col-xs-12 col-sm-9 col-md-8 padd" id="yearfile">
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
        <div  class="col-lg-12 padd2">
          <div class="col-xs-4"><button class="btn btn-success btn-rev" data-val="2" type="button" >Aprobar</button></div>
          <div class="col-xs-4"><button class="btn btn-success btn-rev" data-val="1" type="button" >Desaprobar</button></div>
          <div class="col-xs-4"><button class="btn btn-success" type="button"  data-toggle="collapse"   data-target="#reviewtec" aria-expanded="false" aria-controls="reviewtec">Revisar</button></div>
        </div>
      </div>
      <div class="seccion collapse" id="reviewtec">
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>Luces:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#luces" aria-expanded="false" aria-controls="luces">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="luces">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Luz baja: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_low" id="light_low" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_low" id="light_low" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_low" id="light_low" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz Alta: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_high" id="light_high" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_high" id="light_high" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_high" id="light_high" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz de freno: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_brake" id="light_brake" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_brake" id="light_brake" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_brake" id="light_brake" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz de emergencia: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_emergency" id="light_emergency" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_emergency" id="light_emergency" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_emergency" id="light_emergency" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz de retroceso: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_recoil" id="light_recoil" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_recoil" id="light_recoil" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_recoil" id="light_recoil" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz intermitente: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_intermittent" id="light_intermittent" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_intermittent" id="light_intermittent" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_intermittent" id="light_intermittent" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz Antiniebla: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_fog" id="light_fog" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_fog" id="light_fog" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_fog" id="light_fog" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz de placa: <code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_plate" id="light_plate" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="light_plate" id="light_plate" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="light_plate" id="light_plate" value="3">No aplica</label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>Arranque de motor:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#motor" aria-expanded="false" aria-controls="motor">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="motor">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Arrancador:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="engine_start" id="engine_start" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="engine_start" id="engine_start" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="engine_start" id="engine_start" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Alternador:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="alternator" id="alternator" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="alternator" id="alternator" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="alternator" id="alternator" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Bujias:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="plugs" id="plugs" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="plugs" id="plugs" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="plugs" id="plugs" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Cable de Bujias:<code>*</code></label>

              <div class="col-xs-3 radio">
                  <label><input type="radio" name="cable_plugs" id="cable_plugs" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="cable_plugs" id="cable_plugs" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="cable_plugs" id="cable_plugs" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Bobinas:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="coils" id="coils" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="coils" id="coils" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="coils" id="coils" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Inyectores:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="injectors" id="injectors" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="injectors" id="injectors" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="injectors" id="injectors" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-top">
              <label class="col-xs-12">Bateria:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="drums" id="drums" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="drums" id="drums" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="drums" id="drums" value="3">No aplica</label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>Frenos:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#frenos" aria-expanded="false" aria-controls="frenos">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="frenos">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Pastillas delanteras:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="front_pads" id="front_pads" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="front_pads" id="front_pads" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="front_pads" id="front_pads" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Pastillas Traseras:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="rear_pads" id="rear_pads" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="rear_pads" id="rear_pads" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="rear_pads" id="rear_pads" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Discos delanteros:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="front_discs" id="front_discs" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="front_discs" id="front_discs" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="front_discs" id="front_discs" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Discos traseros:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="rear_discs" id="rear_discs" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="rear_discs" id="rear_discs" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                <label><input type="radio" name="rear_discs" id="rear_discs" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Tambores traseros:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="rear_drums" id="rear_drums" value="1">Sí</label>
              </div>
              <div class="col-xs-3 radio">
                  <label><input type="radio" name="rear_drums" id="rear_drums" value="2">No</label>
              </div>
              <div class="col-xs-6 radio">
                  <label><input type="radio" name="rear_drums" id="rear_drums" value="3">No aplica</label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Zapatas traseros:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_shoes" id="rear_shoes" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_shoes" id="rear_shoes" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="rear_shoes" id="rear_shoes" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Freno de emergencia:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="emergency_break" id="emergency_break" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="emergency_break" id="emergency_break" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="emergency_break" id="emergency_break" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-top">
              <label class="col-xs-12">Liquido de freno:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="brake_fluid" id="brake_fluid" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="brake_fluid" id="brake_fluid" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="brake_fluid" id="brake_fluid" value="3">
                       no aplica
                  </label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>Neumáticos:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#neumaticos" aria-expanded="false" aria-controls="neumaticos">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="neumaticos">
        <div class="col-xs-12 col-sm-6 impar b-bottom">
            <label class="col-xs-12">Estado de neumáticos:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="tire_status" id="tire_status" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="tire_status" id="tire_status" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="tire_status" id="tire_status" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
          <label class="col-xs-12">Revision de tuercas:<code>*</code></label>
          <div class="col-xs-3 radio">
              <label>
                  <input type="radio" name="nut_revision" id="nut_revision" value="1">
                    Si
              </label>
          </div>
          <div class="col-xs-3 radio">
              <label>
                  <input type="radio" name="nut_revision" id="nut_revision" value="2">
                      No
              </label>
          </div>
          <div class="col-xs-6 radio">
              <label>
                  <input type="radio" name="nut_revision" id="nut_revision" value="3">
                   no aplica
              </label>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Presion de neumaticos:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="tire_pressure" id="tire_pressure" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="tire_pressure" id="tire_pressure" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="tire_pressure" id="tire_pressure" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Llanta de repuesto:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="spare_tire" id="spare_tire" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="spare_tire" id="spare_tire" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="spare_tire" id="spare_tire" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-top">
            <label class="col-xs-12">Aros:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="hoops" id="hoops" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="hoops" id="hoops" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="hoops" id="hoops" value="3">
                     no aplica
                </label>
            </div>
        </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>Carrosería y Chásis:</b>  <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#chasis" aria-expanded="false" aria-controls="chasis">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="chasis">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Parachoque Delantero:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="front_bumper" id="front_bumper" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="front_bumper" id="front_bumper" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="front_bumper" id="front_bumper" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Parachoque Posterior:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_bumper" id="rear_bumper" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_bumper" id="rear_bumper" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="rear_bumper" id="rear_bumper" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Puerta Del. Izquierda:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_front_door" id="left_front_door" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_front_door" id="left_front_door" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="left_front_door" id="left_front_door" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Puerta Del. Derecha:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_front_door" id="right_front_door" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_front_door" id="right_front_door" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="right_front_door" id="right_front_door" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Puerta Post. Izquierda:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="left_rear_door" id="left_rear_door" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="left_rear_door" id="left_rear_door" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="left_rear_door" id="left_rear_door" value="3">
                     no aplica
                </label>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Puerta Post. Derecha:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_rear_door" id="right_rear_door" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_rear_door" id="right_rear_door" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="right_rear_door" id="right_rear_door" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Guardafango Izquierda:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_fender" id="left_fender" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_fender" id="left_fender" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="left_fender" id="left_fender" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Guardafango Derecho:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_fender" id="right_fender" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_fender" id="right_fender" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="right_fender" id="right_fender" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Capota:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="soft_top" id="soft_top" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="soft_top" id="soft_top" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="soft_top" id="soft_top" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Vidrio Del. Izquierdo:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_front_glass" id="left_front_glass" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_front_glass" id="left_front_glass" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="left_front_glass" id="left_front_glass" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Vidrio Del. derecho:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_front_glass" id="right_front_glass" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_front_glass" id="right_front_glass" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="right_front_glass" id="right_front_glass" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Vidrio Post. Izquierdo:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_rear_glass" id="left_rear_glass" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="left_rear_glass" id="left_rear_glass" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="left_rear_glass" id="left_rear_glass" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Vidrio Post. Derecho:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_rear_glass" id="right_rear_glass" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="right_rear_glass" id="right_rear_glass" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="right_rear_glass" id="right_rear_glass" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Parabrisa Delantero:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="front_windshield" id="front_windshield" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="front_windshield" id="front_windshield" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="front_windshield" id="front_windshield" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Parabrisa Trasera:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_windshield" id="rear_windshield" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_windshield" id="rear_windshield" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="rear_windshield" id="rear_windshield" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Maletero:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="trunk" id="trunk" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="trunk" id="trunk" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="trunk" id="trunk" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-top">
              <label class="col-xs-12">Techo:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="ceiling" id="ceiling" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="ceiling" id="ceiling" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="ceiling" id="ceiling" value="3">
                       no aplica
                  </label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>Motor:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#motor2" aria-expanded="false" aria-controls="motor2">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="motor2">
        <div class="col-xs-12 col-sm-6 impar b-bottom">
            <label class="col-xs-12">Fuga de aceite:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="oil_leak" id="oil_leak" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="oil_leak" id="oil_leak" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="oil_leak" id="oil_leak" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Fuga de refrigerante:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="refrigerant_leak" id="refrigerant_leak" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="refrigerant_leak" id="refrigerant_leak" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="refrigerant_leak" id="refrigerant_leak" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Fuga de combustible:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="fuel_leak" id="fuel_leak" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="fuel_leak" id="fuel_leak" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="fuel_leak" id="fuel_leak" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Filtro de aceite:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="oil_filter" id="oil_filter" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="oil_filter" id="oil_filter" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="oil_filter" id="oil_filter" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Filtro de aire:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="air_filter" id="air_filter" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="air_filter" id="air_filter" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="air_filter" id="air_filter" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Filtro de combustible:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="fuel_filter" id="fuel_filter" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="fuel_filter" id="fuel_filter" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="fuel_filter" id="fuel_filter" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
            <label class="col-xs-12">Filtro de cabina:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="cabin_filter" id="cabin_filter" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="cabin_filter" id="cabin_filter" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="cabin_filter" id="cabin_filter" value="3">
                     no aplica
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 impar b-top">
            <label class="col-xs-12">Bomba de direccion:<code>*</code></label>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="steering_pump" id="steering_pump" value="1">
                      Si
                </label>
            </div>
            <div class="col-xs-3 radio">
                <label>
                    <input type="radio" name="steering_pump" id="steering_pump" value="2">
                        No
                </label>
            </div>
            <div class="col-xs-6 radio">
                <label>
                    <input type="radio" name="steering_pump" id="steering_pump" value="3">
                     no aplica
                </label>
            </div>
        </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8 padd"><b>Suspensión:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#suspension" aria-expanded="false" aria-controls="suspension">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="suspension">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Amortiguadores Delanteros:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="front_shock_absorbers" id="front_shock_absorbers" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="front_shock_absorbers" id="front_shock_absorbers" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="front_shock_absorbers" id="front_shock_absorbers" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Amortiguadores Posteriores:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_shock_absorbers" id="rear_shock_absorbers" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_shock_absorbers" id="rear_shock_absorbers" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="rear_shock_absorbers" id="rear_shock_absorbers" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Palieres:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="pallets" id="pallets" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="pallets" id="pallets" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="pallets" id="pallets" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Rotulas:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="pads" id="pads" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="pads" id="pads" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="pads" id="pads" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Terminales de Direccion:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="terminal_blocks" id="terminal_blocks" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="terminal_blocks" id="terminal_blocks" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="terminal_blocks" id="terminal_blocks" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Trapezios:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="trapezios" id="trapezios" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="trapezios" id="trapezios" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="trapezios" id="trapezios" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-top">
              <label class="col-xs-12">Resortes:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="springs" id="springs" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="springs" id="springs" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="springs" id="springs" value="3">
                       no aplica
                  </label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8">Transmisión:<code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#transmision" aria-expanded="false" aria-controls="transmision">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="transmision">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Aceite de caja:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="box_oil" id="box_oil" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="box_oil" id="box_oil" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="box_oil" id="box_oil" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Filtro de caja:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="case_filter" id="case_filter" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="case_filter" id="case_filter" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="case_filter" id="case_filter" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Caja de transferencia:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="transfer_case" id="transfer_case" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="transfer_case" id="transfer_case" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="transfer_case" id="transfer_case" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Cardan:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="cardan" id="cardan" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="cardan" id="cardan" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="cardan" id="cardan" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Diferencial:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="differential" id="differential" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="differential" id="differential" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="differential" id="differential" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Disco de embrague:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="clutch_disc" id="clutch_disc" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="clutch_disc" id="clutch_disc" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="clutch_disc" id="clutch_disc" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Collarin:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="collarin" id="collarin" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="collarin" id="collarin" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="collarin" id="collarin" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-top">
              <label class="col-xs-12">Cruzetas:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="crossbows" id="crossbows" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="crossbows" id="crossbows" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="crossbows" id="crossbows" value="3">
                       no aplica
                  </label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8"><b>Sistema de enfriamiento:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#enfriamiento" aria-expanded="false" aria-controls="enfriamiento">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="enfriamiento">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Radiador:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="radiator" id="radiator" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="radiator" id="radiator" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="radiator" id="radiator" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Ventiladores:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="ventilators" id="ventilators" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="ventilators" id="ventilators" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="ventilators" id="ventilators" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12" for="idoffice">Correa de ventilador:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="fan_belt" id="fan_belt" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="fan_belt" id="fan_belt" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="fan_belt" id="fan_belt" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-top">
              <label class="col-xs-12">Mangueras de agua:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="water_hoses" id="water_hoses" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="water_hoses" id="water_hoses" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="water_hoses" id="water_hoses" value="3">
                       no aplica
                  </label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8"><b>Interiores:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#interiores" aria-expanded="false" aria-controls="interiores">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="interiores">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Tablero:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="board" id="board" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="board" id="board" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="board" id="board" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz de tablero:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="dash_light" id="dash_light" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="dash_light" id="dash_light" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="dash_light" id="dash_light" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Luz de saloom:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="saloon_light" id="saloon_light" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="saloon_light" id="saloon_light" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="saloon_light" id="saloon_light" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Asiento piloto:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="pilot_seat" id="pilot_seat" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="pilot_seat" id="pilot_seat" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="pilot_seat" id="pilot_seat" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Asiento copiloto:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="passenger_seat" id="passenger_seat" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="passenger_seat" id="passenger_seat" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="passenger_seat" id="passenger_seat" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Asientos traseros:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_seats" id="rear_seats" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="rear_seats" id="rear_seats" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="rear_seats" id="rear_seats" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-top">
              <label class="col-xs-12">Claxon:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="horn" id="horn" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="horn" id="horn" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="horn" id="horn" value="3">
                       no aplica
                  </label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div  class="col-lg-12 padd2">
            <label class="col-xs-8"><b>Accesorios:</b> <code>*</code></label>
            <div class="col-xs-4"><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#accesorios" aria-expanded="false" aria-controls="accesorios">Desplegar</button></div>
          </div>
      </div>
      <div class="seccion collapse" id="accesorios">
          <div class="col-xs-12 col-sm-6 impar b-bottom">
              <label class="col-xs-12">Gata:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="gata" id="gata" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="gata" id="gata" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="gata" id="gata" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Llave de ruedas:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="wheel_wrench" id="wheel_wrench" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="wheel_wrench" id="wheel_wrench" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="wheel_wrench" id="wheel_wrench" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Estuche de herramientas:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="tool_kit" id="tool_kit" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="tool_kit" id="tool_kit" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="tool_kit" id="tool_kit" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Triangulo de seguridad:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="safety_triangle" id="safety_triangle" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="safety_triangle" id="safety_triangle" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="safety_triangle" id="safety_triangle" value="3">
                       no aplica
                  </label>
              </div>
          </div>
          <div class="col-xs-12 col-sm-6 impar b-bottom b-top">
              <label class="col-xs-12">Extintor:<code>*</code></label>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="extinguisher" id="extinguisher" value="1">
                        Si
                  </label>
              </div>
              <div class="col-xs-3 radio">
                  <label>
                      <input type="radio" name="extinguisher" id="extinguisher" value="2">
                          No
                  </label>
              </div>
              <div class="col-xs-6 radio">
                  <label>
                      <input type="radio" name="extinguisher" id="extinguisher" value="3">
                       no aplica
                  </label>
              </div>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <label class="col-xs-12">Observaciones:<code>*</code></label>
          <div class="col-xs-12 padd">
            <textarea id="observacion" name="observacion" class="form-control" ></textarea>
          </div>
      </div>
      <hr>
      <div class="seccion">
          <div class="col-sm-6 text-left">
            <button type="button" data-val="2" class="btn btn-success btn_ajax">Aprobar</button>
          </div>
          <div class="col-sm-6 text-right">
            <button type="button" data-val="7" class="btn btn-success btn_ajax">Desaprobar</button>
          </div>
      </div>
    </div>
  </form>
</section>
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
<script src="{{ asset('js/External/Driver/technicalreview.js')}} "></script>
@endsection
