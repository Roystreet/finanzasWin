<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>JUNTA GENERAL DE ACCIONISTAS</title>
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
  <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
</head>
<?php
        $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo.png?alt=media&token=c0d567df-b26c-43da-bf84-4ff4ab866889");
        $base64 = 'data:image/png;base64,' . base64_encode($data);

        $data2 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Ffondo.png?alt=media&token=48079391-f935-4cc0-9b8e-4eaa9e53d18c");
        $base642 = 'data:image/png;base64,' . base64_encode($data2);

        $data3 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2F1140px%20x%20315%20(1).png?alt=media&token=b5566f64-bb97-40e0-8e70-557fcfc3b23d");
        $base643 = 'data:image/png;base64,' . base64_encode($data3);
?>
<body style="background-image:  url('{{$base642}}'); background-repeat: no-repeat, repeat; background-size: cover; font-family: 'Quicksand', sans-serif;">
  <div class="container text-center" style="margin-bottom: 0px; height: 314px; background-image:  url('{{$base643}}'); background-repeat: no-repeat, repeat; background-size: cover;">
    <div class="row">
      <center><img src="{{$base64}}" alt="logo" width="220" style="padding-top: 60px;"></center>
      <h1 style="color: white;">JUNTA GENERAL DE ACCIONISTAS</h1>
      <h3 style="color: #ffe23c;">WIN TECNOLOGIES INC</h3>
    </div>
  </div>
  <div class="container">
    <div class="row" style="background: white; padding-top: 30px;  padding-bottom: 30px;">
      <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
        <div class="row">
          <div class="col-sm-12">
            <h3><b style="color: #ffe23c;">|</b> Confirmar su asistencia</h3>
          </div>
        </div>
        <form action="#" id="myform" method="POST">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="form-group">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">PAIS:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa  fa-map-marker"></i>
                  </div>
                  <select id="country" class="form-control select2" name="country">
                    <option selected="selected" value="">Selecciona</option>
                    <option>PERU</option>
                    <option>COLOMBIA</option>
                    <option>MEXICO</option>
                    <option>BOLIVIA</option>
                    <option>ECUADOR</option>
                    <option>CHILE</option>
                    <option>ARGENTINA</option>
                    <option>ESPAÑA</option>
                    <option>ITALIA</option>
                    <option>BRASIL</option>
                    <option>PUERTO RICO</option>
                    <option>ESTADOS UNIDOS</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">TIPO DE DOCUMENTO:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-map-marker"></i>
                    </div>
                    <select id="type_docs" class="form-control select2" name="type_docs">
                      <option selected="selected" value="">Selecciona</option>
                      <option>CARNET DE EXTRANJERIA</option>
                      <option>CARNET DE SOLICITANTE</option>
                      <option>CEDULA DE IDENTIDAD</option>
                      <option>CURP</option>
                      <option>DNI</option>
                      <option>PASAPORTE</option>
                      <option>PTP</option>
                    </select>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">NUMERO DE DOCUMENTO: </label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa  fa-map-marker"></i>
                    </div>
                    {!! Form::text('nrodoc', null,['id'=>'nrodoc', 'class'=>'form-control','placeholder' => 'Numero de documento','maxlength'=>'20'] ) !!}
                  </div>
                </div>
            </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">NOMBRES:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                {!! Form::text('first_name', null,['id'=>'first_name', 'class'=>'form-control','placeholder' => 'Numero de documento','maxlength'=>'20'] ) !!}
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">APELLIDOS: </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                {!! Form::text('last_name', null,['id'=>'last_name', 'class'=>'form-control','placeholder' => 'Numero de documento','maxlength'=>'20'] ) !!}
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">CORREO ELECTRONICO:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                {!! Form::text('email', null,['id'=>'email', 'class'=>'form-control','placeholder' => 'Numero de documento','maxlength'=>'20'] ) !!}
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"><label for="Datos">TELEFONO: </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa  fa-map-marker"></i>
                </div>
                {!! Form::text('phone', null,['id'=>'phone', 'class'=>'form-control','placeholder' => 'Numero de documento','maxlength'=>'20'] ) !!}
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <button type="button" style="width: 100%; background: #fcbe00;" id="btn_env" class="btn btn-warning">CONFIRMAR</button>
            </div>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
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
<script src="{{ asset('js/External/accionistas/show.js')}}"></script>
</body>
</html>
