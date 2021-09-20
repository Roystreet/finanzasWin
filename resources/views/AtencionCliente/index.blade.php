<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registrar Pasajeros</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <style>
    li {
      width: 2em;
      height: 2em;
      text-align: center;
      line-height: 3em;
      border-radius: 2em;
      background: #0d436b;
      margin: 0 1.5em;
      display: inline-block;
      color: white;
      position: relative;
      border: 1px solid #ffe23c;
    }

    li::before{
      content: '';
      position: absolute;
      top: 0.8em;
      left: -3.5em;
      width: 4em;
      height: .2em;
      background: #0d436b;
      z-index: -1;
    }

    li:first-child::before {
      display: none;
    }

    .active {
      background: #ffe23c;
      color: #0d436b;
    }

    .active ~ li {
      background: #aeb6bf;
      opacity:0.6;
    }

    .active ~ li::before {
      background: #aeb6bf;
      opacity:0.6;
    }
    #type_docs option {
      background: rgba(0, 0, 0, 0.5) !important;
      color: white !important;
      border: 4px solid #ffe23c !important;
    }
  </style>
</head>
<?php
        $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo.png?alt=media&token=c0d567df-b26c-43da-bf84-4ff4ab866889");
        $base64 = 'data:image/png;base64,' . base64_encode($data);

        $data2 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Ffondo-win-2.jpeg?alt=media&token=d0ca967f-b4df-4cee-81e7-54519f59cd78");
        $base642 = 'data:image/png;base64,' . base64_encode($data2);

        $data3 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2FWhatsApp%20Image%202020-02-27%20at%203.33.23%20PM.jpeg?alt=media&token=46ebf26e-96aa-47dd-903e-690aa5101a41");
        $base643 = 'data:image/png;base64,' . base64_encode($data3);
?>
<body style="background-image:  url('{{$base642}}'); background-repeat: no-repeat, repeat; background-size: cover;">
  <section class="content divregister">
      <div class="row">
        <center><h2 id="welcomediv" style="color: white; opacity:0.63; font-family: 'Quicksand', sans-serif;">Bienvenido a</h2></center>
        <center><img src="{{$base64}}" alt="logo" width="220"></center>
      </div>
      <div class="row" >
        <div class="col-xs-12" style="margin: 10px 0px 0px 0px;">
          <center><ul id="examples">
            <li id="v1" data-id="1" class="ordens active"></li>
            <li id="v2" data-id="2" class="ordens"></li>
            <li id="v3" data-id="3" class="ordens"></li>
            <li id="v4" data-id="4" class="ordens"></li>
            <li id="v5" data-id="5" class="ordens"></li>
          </ul></center>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
            <div class="col-xs-12 register1">
                <div class="row" style="margin: 10px 10px 0px 0px;">
                  <div class="row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8">
                    <h2 style="color: white;">Seleccione el tipo de cliente:</h2>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8">
                      <div class="row">
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" class="buttonwin" data-id="Pasajero" style="padding: 5px; margin: 10px; width: 210px; background: #0d436b; font-size: 40px; color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 15px; ">Pasajero</button>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" class="buttonwin" data-id="Embajador" style="padding: 5px; margin: 10px; width: 220px; background: #0d436b; font-size: 40px; color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 15px; float: right;">Embajador</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8">
                      <div class="row">
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" class="buttonwin" data-id="Conductor" style="padding: 5px; margin: 10px; width: 210px; background: #0d436b; font-size: 40px;  color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 15px; ">Conductor</button>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" class="buttonwin" data-id="Accionista" style="padding: 5px; margin: 10px; width: 220px; background: #0d436b; font-size: 40px;  color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 15px; float: right;">Accionista</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-xs-12 col-sm-12">
                    <center><button type="button" class="buttonwin" data-id="Usuario" style="padding: 5px; margin: 10px; width: 300px; background: #0d436b; font-size: 40px;  color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 15px; ">Nuevo Usuario</button></center>
                  </div>
                </div>
            </div>
            <div class="col-xs-12 register2">
                <div class="row">
                  <div class="row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8">
                      <center><h1 style="color: white; padding: 5px; margin: 10px 0px 0px; ">Tipo de requerimiento:</h1></center>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8">
                      <div class="row">
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" data-id="9" class="btn btn-lg btn-success btnrequeriments" style="padding: 5px; margin: 10px; width: 280px; background: #0d436b; font-size: 40px; color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 25px; ">Consulta</button>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" data-id="4" id="" class="btn btn-lg btn-success btnrequeriments" style="padding: 5px; margin: 10px; width: 280px; background: #0d436b; font-size: 40px; color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 25px; float: right;">Solicitud</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="row">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-8">
                      <div class="row">
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" data-id="11" class="btn btn-lg btn-success btnrequeriments" style="padding: 5px; margin: 10px; width: 280px; background: #0d436b; font-size: 40px; color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 25px;">Tramite</button>
                        </div>
                        <div class="col-lg-6 col-xs-6 col-sm-6">
                          <button type="button" data-id="12" class="btn btn-lg btn-success btnrequeriments" style="padding: 5px; margin: 10px; width: 280px; background: #0d436b; font-size: 40px; color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 25px; float: right;">Capacitacion</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-xs-12 col-sm-12">
                    <center><button type="button" data-id="1" class="btn btn-lg btn-success btnrequeriments" style="padding: 5px; margin: 10px; width: 210px; background: #0d436b; font-size: 40px; color: #ffe22b!important; border: 4px solid #fcbe00; border-radius: 25px; ">Otros</button></center>
                  </div>
                </div>
            </div>
            <div class="col-xs-12 register3" style="font-family: 'Quicksand', sans-serif;" >
              <form action="#" id="myform" method="POST">
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="row" style="margin: 0px;">
                <div class="row">
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-8">
                    <center><h1 style="color: white; padding: 5px; margin: 10px 0px 0px; ">Estimado(a) <b id="typeUsuario"></b></h1></center>
                  </div>
                  <div class="col-sm-2">
                  </div>
                </div>
              </div>
              <div class="row" style="margin: 0px;">
                <div class="row">
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-8">
                    <center><h3 style="color: #ffe23c;">INGRESAR IDENTIFICACION:</h3></center>
                  </div>
                  <div class="col-sm-2">
                  </div>
                </div>
              </div>
              <div class="row" style="margin: 10px;">
                <div class="row">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-6">
                    <label class="col-md-4" style="color: white; font-size: 18px;"  for="pwd">TIPO DE DOCUMENTO:</label>
                    <div class="col-md-8">
                      {!! Form::select('type_docs', $type_docs, null, ['id'=>'type_docs','placeholder'=>'Selecciona' , 'style'=>'width: 100%; background: rgba(0,0,0,0.5); color: white; border: 2px solid #fcbe00; border-radius: 15px; font-size: 18px;'] ) !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                  </div>
                </div>
                <div class="row typedocumentextra">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-6">
                    <label class="col-md-4" style="color: white; font-size: 18px;"  for="pwd">NOMBRE:</label>
                    <div class="col-md-8">
                      {!! Form::text('firstnameextra', null,['id'=>'firstnameextra', 'class'=>'form-control keyup-dni','placeholder' => 'Nombres','maxlength'=>'20', 'style'=>'width: 100%; background: rgba(0,0,0,0.5); color: white; border: 2px solid #fcbe00; border-radius: 15px; font-size: 18px;'] ) !!}
                    </div>
                    <label class="col-md-4" style="color: white; font-size: 18px;"  for="pwd">APELLIDO:</label>
                    <div class="col-md-8">
                      {!! Form::text('lastnameextra', null,['id'=>'lastnameextra', 'class'=>'form-control keyup-dni','placeholder' => 'Apellidos','maxlength'=>'20', 'style'=>'width: 100%; background: rgba(0,0,0,0.5); color: white; border: 2px solid #fcbe00; border-radius: 15px; font-size: 18px;'] ) !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                  </div>
                </div>
              </div>
              <div class="row" style="margin: 5px 5px 0px 5px;">
                <div class="row">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-6">
                    <label class="col-md-4" style="color: white; font-size: 18px;"  for="pwd">NUMERO DOCUMENTO:</label>
                    <div class="col-md-8">
                      {!! Form::text('dni', null,['id'=>'dni', 'class'=>'form-control keyup-dni input-number','placeholder' => 'Numero de documento','maxlength'=>'20', 'style'=>'width: 100%; background: rgba(0,0,0,0.5); color: white; border: 2px solid #fcbe00; border-radius: 15px; font-size: 18px;'] ) !!}
                    </div>
                  </div>
                  <div class="col-sm-3">
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-6">
                  </div>
                  <div class="col-sm-3">
                    <a href="#" id="" class="btn btnsearch"  style="color: white; font-size: 40px;">Continuar <i style="color: #fcbe00!important;" class="fa fa-angle-right"></i></a>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-xs-12 register4" style="font-family: 'Quicksand', sans-serif;">
              <div class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8">
                  <center><h1 style="color: white;">Estimado(a) <b id="typeUsuario1"></b></h1></center>
                </div>
                <div class="col-sm-2">
                </div>
              </div>
              <div class="row">
                <center><h2 style="color: #ffe22b;">Confirme sus datos:</h2></center>
              </div>
              <div class="row">
                <center><label id="first_name" style="width: 500px; color: white; background: #0d436b; font-size: 25px; color: #ffffff!important; border: 2px solid #fcbe00; border-radius: 15px; "  for="pwd"></label></center>
                <center><label id="nrodocs" style="color: white; background: #0d436b; width: 200px; font-size: 25px; color: #ffffff!important; border: 2px solid #fcbe00; border-radius: 15px;"  for="pwd"></label></center>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <center><a href="#" class="btn btnverf" data-id="1"  style="color: white; font-size: 90px;"><i style="color: #ff3823!important;" class="fa fa-times-circle"></i></a></center>
                </div>
                <div class="col-sm-6">
                  <center><a href="#" class="btn btnverf" data-id="2"  style="color: white; font-size: 90px;"><i style="color: #4fe601!important;" class="fa fa-check-circle"></i></a></center>
                </div>
              </div>
            </div>
        </div>
      </div>
  </section>
<!-- /.register-box -->

<div id="viewregister" class="viewregister" style="display: none; position: fixed; z-index: 1000;font-family: 'Quicksand', sans-serif; padding-top: 20px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-image:  url('{{$base643}}'); background-repeat: no-repeat, repeat; background-size: cover;">
  <div class="modal-content-load" style="width: 100%;">
    <div class="row">
      <div class="col-xs-2 col-sm-2">
      </div>
      <div class="col-xs-8 col-sm-8" id="divsaves" style="padding-right: 0px; padding-left: 0px;">
        <center><img src="{{$base64}}" alt="logo" width="250" style="margin: 30px;"></center>
        <center><h1 style="color: white; font-weight: bold;"><b id="namecust"></b>!</h1></center>
        <center><h3 style="color: #fcbe00; font-weight: bold;" id="numberaten"></h3></center>
        <center><button type="button" class="buttonwin" id="nrotic" style="font-weight: bold; padding: 10px; margin: 10px; width: 180px; background: #0d436b; font-size: 30px; color: #ffe23c !important; border: 2px solid #fcbe00; border-radius: 15px; "></button></center>
        <center><h3 id="notesave"></h3></center>
        <hr id="lineacss">
        <center><button type="button" class="btnback" style="margin: 10px; width: 150px; background: rgba(0,0,0,0.1); font-size: 40px; border-radius: 15px; ">OK</button></center>
      </div>
      <div class="col-xs-2 col-sm-2">
      </div>
    </div>
  </div>
</div>

<!-- Animación de carga de documento -->
<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 9999999; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
  <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
    <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
  </div>
</div>

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/AtencionCliente/index.js')}}"></script>
</body>
</html>
