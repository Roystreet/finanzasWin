<!DOCTYPE html>
<html lang="en">
<head>
  <title>Libro de reclamaciones</title>
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

<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css')}}">

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
        $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flibro%20de%20reclamaciones%20(1).png?alt=media&token=539813b0-a2cc-417c-a8ec-1b658ac501dc");
        $base64 = 'data:image/png;base64,' . base64_encode($data);
      ?>

  <!-- <h2 class="text-center">LIBRO DE RECLAMACIONES</h2> -->
  <img src="{{$base64}}" style="display: block; margin-left: auto; margin-right: auto; width: 70%; padding: 10px;">
  <h4>Conforme a lo establecido en el Código de Protección y Defensa del Consumidor esta institución cuenta con un Libro de Reclamaciones a tu disposición.</p><br>
  <h3>WIN TECNOLOGIES INC SA <br> R.U.C. 20603216246</h3>
  <h5>Jr. Pataz 1253, Los olivos, Peru</h5>
  <hr>
  <p><span id="dateact"></span></p>
  <hr>
  <form class="form-horizontal" action="#" id="formfreshdeks" enctype="multipart/form-data">
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Nombre Cliente:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" placeholder="Ingresar nombre" name="name">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">DNI:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="document" placeholder="Ingresar DNI" name="document">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Telefono fijo:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="telephone" placeholder="Ingresar telefono fijo" name="telephone">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Telefono celular:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="phone" placeholder="Ingresar telefono celular" name="phone">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Pais:</label>
      <div class="col-sm-10">
        {!! Form::select('cod_country', $country, null, ['id'=>'cod_country','placeholder'=>'Seleccione...','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
      </div>
    </div>
    <div class="form-group depval">
      <label class="col-sm-2" for="pwd">Departamento:</label>
      <div class="col-sm-10">
          {!! Form::select('cod_state', ['placeholder' => 'Seleccione...'], null,['id'=>'cod_state','class'=>'form-control select2', 'style'=>'width: 100%']) !!}
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Provincia:</label>
      <div class="col-sm-10">
        {!! Form::select('cod_city', ['placeholder' => 'Seleccione...'], null,['id'=>'cod_city', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Dirección:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="address" name="address" placeholder="Ingresar direccion"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="email">Motivo:</label>
      <div class="col-sm-10">
        <select class="form-control" id="tipo" name="tipo">
          <option>Seleccionar</option>
          <option>Queja</option>
          <option>Reclamo</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2" for="email">Oficina-Servicio:</label>
      <div class="col-sm-10">
        <select class="form-control" id="tipo" name="tipo">
          <option>Seleccionar</option>
          <option>Oficina</option>
          <option>Servicio</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2" for="pwd">Numero de placa servicio WIN:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="placaserv" placeholder="Ingresar placa servicio WIN" name="placaserv">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2" for="pwd">Fecha de viaje:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" id="date" placeholder="Ingresar fecha" name="date">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="email">descripcion:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="description" placeholder="Ingresar descripcion" name="description">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="email">Cantidad:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="cant" placeholder="Ingresar Cantidad" name="cant">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2" for="pwd">Pedido del cliente:</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="ordercustomer" name="ordercustomer" placeholder="Ingresar pedido"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2" for="pwd">Adjuntos:</label>
      <div class="col-sm-10">
        <input type='file' id='myFile' class="form-control" id="myFile" name="myFile" >
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12 text-center">
        <button type="button" id="btn_ajax" class="btn btn-success">Enviar</button>
      </div>
    </div>

    <div class="form-group">
      <p>NOTA: La respuesta a la presente queja o reclamo será brindada mediante comunicación electrónica enviada a la dirección que usted
         ha consignado en la presente Hoja de Reclamación. En caso de que usted desee que la respuesta le sea enviada a su domicilio deberá
         expresar ello en el detalle del reclamo o queja.</p>
    </div>

  </form>
</div>
<script src="http://127.0.0.1:8000/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/external/bookrecla.js')}} "></script>

</body>
</html>
