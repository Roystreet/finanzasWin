<!DOCTYPE html>
<html lang="en">
<head>
  <title>Freshdesk Ecuador</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/bootstrap.min.css"/>
<style>
    #main-footer {
        font-size: 1.5rem;
    }
    input[type="text"], input[type="email"], input[type="tel"]{
        width: 100%;
    }
    #myFile{
        height: initial;
    }
    .btn-success {
        color: #333;
        background-color: #fcbe00;
        border-color: #fcbe00;
    }
    .btn-success:hover {
        color: #fff;
        background-color: #fcbe00;
        border-color: #ffe22b;
    }
    .btn-success.active.focus, .btn-success.active:focus, .btn-success.active:hover, .btn-success:active.focus, .btn-success:active:focus, .btn-success:active:hover, .open>.dropdown-toggle.btn-success.focus, .open>.dropdown-toggle.btn-success:focus, .open>.dropdown-toggle.btn-success:hover {
        color: #fff;
        background-color: #fcbe00;
        border-color: #ffe22b;
    }
    .btn-success.active, .btn-success:active, .open>.dropdown-toggle.btn-success {
        color: #fff;
        background-color: #fcbe00;
        background-image: none;
        border-color: #ffe22b;
    }
    .btn-success.focus, .btn-success:focus {
        color: #fff;
        background-color: #fcbe00;
        border-color: #ffe22b;
    }
    .btn {
        padding: 1% 10%;
    }

    #global-container {
    background: #0e3a59;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    color: white;
    font-size: 18px;
    font-weight: 300;
    line-height: 1.2;
    margin: 0;
    }

</style>
</head>
<body id="global-container">

<div class="container">
      <?php
        $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4");
        $base64 = 'data:image/png;base64,' . base64_encode($data);
      ?>
  <img src="{{$base64}}" style="display: block; margin-left: auto; margin-right: auto; width: 25%; padding: 10px;">
  <h2>TICKET DE SOPORTE</h2>
  <h4>Si tengo alguna duda, inconveniente o sugerencia, ¿Como me puedo comunicar con ustedes?</h4>
  <p>Envíanos un ticket</p><br>
  <form class="form-horizontal" action="#" id="formfreshdeks" enctype="multipart/form-data">
    <div class="form-group">
      <label class="col-sm-2" for="email">Tipo de solicitud:</label>
      <div class="col-sm-10">
        <select class="form-control" id="tipo" name="tipo">
          <option>Seleccionar tipo</option>
          <option>Pregunta</option>
          <option>Incidente</option>
          <option>Problema</option>
          <option>Solicitud del area</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Motivo:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="subject" placeholder="Ingresar asunto" name="subject">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="email">Correo Electrónico:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="Ej: nombre@correo.com" name="email">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="email">Numero de telefono:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="telefono" placeholder="Ej: 999944222" name="telefono">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2" for="pwd">Descripción:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="description" name="description" placeholder="Ingresar descripcion"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Seleccion un archivo adjunto:</label>
      <div class="col-sm-10">
        <input type='file' id='myFile' class="form-control" id="myFile" name="myFile" >
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12 text-center">
        <button type="button" id="btn_ajax" class="btn btn-success">Enviar</button>

      </div>
    </div>
  </form>
</div>
<script src="{{ asset('js/msm/ticketfreshdesk.js')}} "></script>
</body>
</html>
