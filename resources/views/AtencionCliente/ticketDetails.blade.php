@extends('layout-backend')
@section('title', 'Service Desk - Ticket Detalle')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
@endsection

@section('content')
<section class="content-header"></section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><label>{{$subject}}</label></h3>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="box box-primary">
       <div class="box-header with-border">
         <h3 class="box-title" style="font-size: 15px !important;">{{$tocreateNL}}<span> informado vía {{$canalgestion}} | Creado por {{$tocreateNL}}</span></h3>
       </div>
       <div class="box-body">
         <div class="row">
              <div class="col-md-12" >
                <!-- Box Comment -->
                <div class="box box-widget" style="border-color: #bbdcfe; background-image: linear-gradient(#e5f2fd,#e5f2fd); border-radius: 4px;">
                  <div class="box-header with-border" style="border-bottom: 1px solid #bbdcfe !important;">
                    <div class="user-block">
                      <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                      <span class="username" style="font-size: 14px !important;"><a href="#"><label>{{$tocreateNL}}</label> informado vía {{$canalgestion}}, hace {{$times}}</a></span>
                          <span class="description"><b>cc:</b> {{$ccs}}</span>
                    </div>
                    <!-- /.user-block -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                    <div style="font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif; font-size:14px">
                    <?php
                      echo $desc;
                    ?>

                    </div>
                  </div>
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->

              @foreach ($convs as $conv)
              <?php

                $datebys = new \DateTime();
                $fechaFinal1   = $datebys->format('d-m-Y H:i:s');
                $fechaInicial1 = $conv['created_at'];
                $seg = strtotime($fechaFinal1) - strtotime($fechaInicial1);

                $d = floor($seg / 86400);
                $h = floor(($seg - ($d * 86400)) / 3600);
                $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
                $s = $seg % 60;
                $timeres = '';
                if ($d > 0){
                  $timeres = ($d == 1) ? $d." Día " : $d." Días ";
                }else if ($h > 0){
                  $timeres = ($h == 1) ? $h." hora " : $h." horas ";
                }else if ($m > 0){
                  $timeres = ($m == 1) ? $m." minuto " : $m." minutos ";
                }else{
                  $timeres = ($s == 1) ? $s." segundo " : $s." segundos ";
                }
              ?>
                <div class="col-md-12" >
                  <!-- Box Comment -->
                  <div class="box box-widget" style="border-color: #ebeff3; background-image: linear-gradient(#f5f7f9,#f5f7f9); border-radius: 4px;">
                    <div class="box-header with-border" style="border-bottom: 1px solid #ebeff3 !important;">
                      <div class="user-block">
                        <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                        <span class="username" style="font-size: 14px !important;"><a href="#"><label>{{$conv->getCreatedBy->name.' '.$conv->getCreatedBy->lastname}}</label></a></span>
                        <span class="description">Para: {{$conv->getNotified->email}} - Respondió, hace {{$timeres}}</span>
                      </div>
                      <!-- /.user-block -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                      <?php
                        echo $conv['description'];
                      ?>
                    </div>
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              @endforeach
              <div class="col-md-12" >
                <div class="box box-widget">
                  <div class="box-header with-border">
                    <button class="btn btn-primary" id="respdiv" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;"><i class="fa fa-mail-reply"></i> Responder</button>
                    <button type="button" class="btn btn-primary" id="respNot" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;"><i class="fa fa-file-text-o"></i> Añadir nota</button>
                  </div>
                </div>
              </div>

              <div class="col-md-12" id="answerticket">
                <!-- Box Comment -->
                <div class="box box-widget" style="border-color: #ebeff3; border-radius: 4px;">
                  <div class="box-header with-border" style="border-bottom: 1px solid #ebeff3 !important; background-image: linear-gradient(#f5f7f9,#f5f7f9);">
                    <div class="user-block">
                      <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                      <span class="username"><a href="#">De <label>{{$name}}</label></a></span>
                      <span class="description" id="tic" data-id="{{$idti}}" data-idr="{{$idregt}}">Para: <label>{{$toresp}}</label></span>
                    </div>
                    <!-- /.user-block -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="background-image: linear-gradient(#fff,#fff);">
                    <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                    <div style="font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif; font-size:14px">
                      <meta name = "csrf-token" content = "{{csrf_token ()}}" />
                      <form action="#" id="myform" method="post">

                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <div class="img-push">

                          <textarea class="form-control" id="editor" name="editor" rows="10" cols="80" style="font-size: 14px !important;">Hola <strong>{{$createdby}}</strong>,

                            <?php
                            echo "<p>&nbsp;</p>".$firma;
                            ?>
                          </textarea>
                        </div>

                      </form>
                    </div>
                  </div>
                  <!-- /.box-footer -->
                  <div class="box-footer">
                    <form method="post">
                      <!-- .img-push is used to add margin to elements next to floating images -->
                      <div class="img-push">
                        <div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;" data-toggle="dropdown">
                          Enviar <span class="caret"></span></button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a class="pend" data-id="3">Enviar y configurado como Pendiente</a></li>
                            <li><a class="pend" data-id="4">Enviar y configurado como Resuelto</a></li>
                            <li><a class="pend" data-id="5">Enviar y configurado como Cerrado</a></li>
                          </ul>
                        </div>
                        <button type="button" class="btn btn-primary" id="respdelete" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;"><i class="fa fa-trash"></i></button>
                      </div>
                    </form>
                  </div>
                  <!-- /.box-footer -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->

              <div class="col-md-12" id="addnotadiv">
                <!-- Box Comment -->
                <form action="#" id="myform1" method="post">
                <div class="box box-widget" style="border-color: #ebeff3; border-radius: 4px;">
                  <div class="box-header with-border" style="border-bottom: 1px solid #ebeff3 !important; background-image: linear-gradient(#f5f7f9,#f5f7f9);">
                    <div class="user-block">
                      <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                      <span class="username"><select class="form-control select2" style="width: 20%" name="typeConv" id="typeConv"><option value="1">&#128274; Privado</option><option value="2">&#127760; Publico</option></select></span>
                      <span class="description" id="ticNot" data-id="{{$idti}}" data-idr="{{$idregt}}">Notificar a: {!! Form::select('agentsGID', $agentsGID, null,['id'=>'agentsGID', 'class'=>'form-control select2',  'placeholder' => '--', 'style'=>'width: 80%'] ) !!} </span>
                    </div>
                    <!-- /.user-block -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="background-image: linear-gradient(#fff,#fff);">
                    <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                    <div style="font-family:-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif; font-size:14px">
                      <meta name = "csrf-token" content = "{{csrf_token ()}}" />


                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <div class="img-push">

                          <textarea class="form-control" id="editor1" name="editor1" rows="10" cols="80" style="font-size: 14px !important;"></textarea>
                        </div>


                    </div>
                  </div>
                  <!-- /.box-footer -->
                  <div class="box-footer">
                    <form method="post">
                      <!-- .img-push is used to add margin to elements next to floating images -->
                      <div class="img-push">
                        <div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;" data-toggle="dropdown">
                          Añadir nota <span class="caret"></span></button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a class="noteSt" data-id="3">Añadir nota y configurado como Pendiente</a></li>
                            <li><a class="noteSt" data-id="4">Añadir nota y configurado como Resuelto</a></li>
                            <li><a class="noteSt" data-id="5">Añadir nota y configurado como Cerrado</a></li>
                          </ul>
                        </div>
                        <button type="button" class="btn btn-primary" id="respdeleteNot" style="background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;"><i class="fa fa-trash"></i></button>
                      </div>
                    </form>
                  </div>
                  <!-- /.box-footer -->
                </div>
                <!-- /.box -->
                </form>
              </div>
              <!-- /.col -->



            </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><label>Propiedades</label></h3>
        </div>
        <div class="box-body">
          <form id="updateTi">
            <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="row">
                <label class="col-md-12" for="pwd"><i style="color: red !important;" class="fa fa-dot-circle-o"></i> VENCIMIENTO DE LA PRIMERA RESPUESTA:</label>
                <div class="col-md-12">
                  by {{$due_by}}
                </div>
              </div>
              <br>
              <div class="row">
                <label class="col-md-12" for="pwd"><i style="color: green !important;" class="fa fa-dot-circle-o"></i> RESOLUCION PENDIENTE:</label>
                <div class="col-md-12">
                  by {{$fr_due_by}}
                </div>
              </div>
              <hr>
              <div class="row">
                <label class="col-md-12" for="pwd">Tipo:</label>
                <div class="col-md-12">
                  <!-- <select class="form-control select2" id="category" name="category">
                      <option>Seleccionar</option>
                  </select> -->
                  {!! Form::select('typeRs', $typeRs, $type,['id'=>'typeRs', 'class'=>'form-control select2',  'placeholder' => '--', 'style'=>'width: 80%'] ) !!}
                </div>
              </div>
              <hr>
              <div class="row">
                <label class="col-md-12" for="pwd">Estado:</label>
                <div class="col-md-12">
                  {!! Form::select('id_status', $statusT, $status,['id'=>'id_status', 'class'=>'form-control select2',  'placeholder' => '--', 'style'=>'width: 80%'] ) !!}
                </div>
              </div>
              <hr>
              <div class="row">
                <label class="col-md-12" for="pwd">Prioridad:</label>
                <div class="col-md-12">
                  {!! Form::select('id_priority', $priorities, $priority,['id'=>'id_priority', 'class'=>'form-control select2',  'placeholder' => '--', 'style'=>'width: 80%'] ) !!}
                </div>
              </div>
              <hr>
              <h5>Asignar a:</h5>
              <div class="row">
                <label class="col-md-12" for="pwd">Grupo:</label>
                <div class="col-md-12">
                  {!! Form::select('group', $groups, $groupT,['id'=>'group', 'class'=>'form-control select2',  'placeholder' => '--', 'style'=>'width: 80%'] ) !!}
                </div>
              </div>
              <hr>
              <div class="row">
                <label class="col-md-12" for="pwd">Agente:</label>
                <div class="col-md-12">
                  {!! Form::select('agentID',$agentsG, $agentT,['id'=>'agentID', 'class'=>'form-control select2',  'placeholder' => '--', 'style'=>'width: 80%'] ) !!}
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <button type="button" id="btn-updateT" class="btn btn-primary" disabled="disabled" style="width: 100%; background-color: #264966; border: 1px solid #12344d; background-image: linear-gradient(to bottom,#264966,#12344d); color: #fff !important;">ACTUALIZAR</button>
                </div>
              </div>
          </form>
        </div>
      </div>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><label>Notas</label></h3>
        </div>
        <div class="box-body">
          @foreach ($notesTK as $noteTK)
          <?php

            $datebyss = new \DateTime();
            $fechaFinal1   = $datebyss->format('d-m-Y H:i:s');
            $fechaInicial1 = $noteTK['created_at'];
            $seg = strtotime($fechaFinal1) - strtotime($fechaInicial1);

            $d = floor($seg / 86400);
            $h = floor(($seg - ($d * 86400)) / 3600);
            $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
            $s = $seg % 60;
            $timeres = '';
            if ($d > 0){
              $timeres = ($d == 1) ? $d." Día " : $d." Días ";
            }else if ($h > 0){
              $timeres = ($h == 1) ? $h." hora " : $h." horas ";
            }else if ($m > 0){
              $timeres = ($m == 1) ? $m." minuto " : $m." minutos ";
            }else{
              $timeres = ($s == 1) ? $s." segundo " : $s." segundos ";
            }
          ?>
          <div class="col-md-12" >
            <!-- Box Comment -->
            <div class="box box-widget" style="    border: 1px solid #fddbb5; background-image: linear-gradient(#fef1e1,#fef1e1); border-radius: 4px;">
              <div class="box-header with-border" style="border-bottom: 1px solid #ebeff3 !important;">
                <div class="user-block">
                  <img class="img-circle" src="../../../../dist/img/usuario.png" alt="User Image">
                  <span class="username" style="font-size: 14px !important;"><a href="#"><label>{{$noteTK->getCreatedBy->name.' '.$noteTK->getCreatedBy->lastname}} añadio una nota {{ ($noteTK->status == 1) ? "privada" : "publica" }}, hace {{$timeres}}</label></a></span>
                  <span class="description">notificacion enviada a: {{$noteTK->getNotified->email}} - </span>
                </div>
                <!-- /.user-block -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- <img class="img-responsive pad" src="../../imagenes/noimage.png" alt="Photo"> -->
                <?php
                  echo $noteTK['description'];
                ?>
              </div>
            </div>
            <!-- /.box -->
          </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{ asset('js/AtencionCliente/ticketDetails.js') }}"></script>
<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('editor');
CKEDITOR.replace('editor1');
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9LCCfUHXYRZJEYOJcynZdl2M89DuA-do"></script>
<script>
  function initialize(lat,long) {
    $('#map').html('');
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat,long);
    var mapOptions = {
      zoom: 16,
      center: latlng,
      disableDefaultUI: true
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    //para que aparezca la imagen con ubicacion
    var marcador = new google.maps.Marker({
      position: latlng,
      map: map,
      title: 'emergencia'
     });
  }

  $(document).ready(function() {
    var geocoder;
    var map;
  });
</script>
@endsection
