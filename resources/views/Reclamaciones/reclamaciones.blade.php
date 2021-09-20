@extends('layout-simple')
@section('title', 'PQRS')
@section('content')
<div id="LoginForm" style="color:black;-webkit-text-stroke: 0.1px black; ">
  <div class="container" >
      <h1 class="form-heading"></h1>
      <div class="login-form"  >
      <p><div class="">

	<meta name="csrf-token" content="{{ csrf_token() }}">


		<div class="box box-primary borderdiv" style="  margin-left:2%;
      width:100%;
      border: 9px
      solid black;
      border-top-left-radius: 100px;
      border-bottom-right-radius: 100px;
      border-top-right-radius: 100px;
      border-bottom-left-radius: 100px;
      " >



				<section id="global-content" class="cf">
            <section id="main-content">
              <!-- <img src="https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flibro%20de%20reclamaciones%20(1).png?alt=media&token=539813b0-a2cc-417c-a8ec-1b658ac501dc" style="display: block; margin-left: auto; margin-right: auto; width: 70%;"> -->
              <div style=" width: 66.66%; margin: 0 auto;">
                 <!-- <h4>Conforme a lo establecido en el CÃ³digo de ProtecciÃ³n y Defensa del Consumidor esta instituciÃ³n cuenta con un Libro de Reclamaciones a tu disposiciÃ³n.</p><br> -->

<tr>

  <td align="center">

    <h2>WIN TECNOLOGIES INC S.A</h2>
    <h3>CONTACTANOS<br></h3>
    <div class="fa fa-whatsapp fa-3x"></div>
    <div class="fa fa-google fa-3x"></div>
    <div class="fa fa-envelope fa-3x"></div>
    <br><br>
  </td>
</tr>





  <!-- <h5>Jr. Pataz 1253, Los olivos, Peru</h5>              </div><br> -->
                  <form class="form-horizontal" action="#" id="formfreshdeks" enctype="multipart/form-data">
                        <div class="form-group">
                          <div class="col-sm-2"></div>
                          <label class="col-10 col-sm-2" for="group_id">Seleccione pais:</label>
                          <div class="col-10 col-sm-6">
                            <select class="form-control" id="group_id" name="group_id">
                              <option value="">Seleccionar pais</option>
                              <option value="43000602573">WIN BOLIVIA</option>
                              <option value="43000578275">WIN COLOMBIA</option>
                              <option value="43000589488">WIN ECUADOR</option>
                              <option value="43000603572">WIN MEXICO</option>
                              <option value="43000603562">WIN PERU</option>
                            </select>
                            <div class="paisvalidate error">

                            </div>

                          </div>
                        </div>

                    <div class="form-group">
                      <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="tipo">Tipo de solicitud:</label>
                      <div class="col-10 col-sm-6">
                        <select class="form-control" id="tipo" name="tipo">
                          <option value="">Seleccionar tipo de solicitud</option>
                          <option value="5">Peticion</option>
                          <option value="6">Queja</option>
                          <option value="7">Reclamo</option>
                          <option value="8">Sugerencia</option>
                        </select>
                        <div class="tipovalidate error">

                        </div>
                        <div class="col-sm-2"></div>

                      </div>
                    </div>


                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="name">Nombres:</label>
                      <div class="col-10 col-sm-6">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese sus nombres" >
                        <div class="namevalidate error">

                        </div>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>

                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="lastname">Apellidos:</label>
                      <div class="col-10 col-sm-6">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Ingrese sus apellidos" >
                        <div class="lastnamevalidate error">

                        </div>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>

                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="email">Correo Electr&oacute;nico:</label>
                      <div class="col-10 col-sm-6">
                        <input type="email" class="form-control" id="email" placeholder="Ej: nombre@correo.com" name="email">
                        <div class="emailvalidate error">

                        </div>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>


                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="telefono">Numero de tel&eacute;fono:</label>
                      <div class="col-10 col-sm-2">
                          {!! Form::select('prefpais', $country, null, ['id'=>'prefpais','placeholder'=>'Selecciona Codigo de pais ejemplo(+51)','class'=>'form-control select2 ', 'style'=>'width: 100%'] ) !!}
                          <div class="codigvalidate error">

                          </div>
                      </div>

                      <div class="col-10 col-sm-4">
                        <input type="text" class="form-control" id="telefono" placeholder="Numero telefono Ej: 999944222" name="telefono">
                        <div class="telefonovalidate error">

                        </div>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>

                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="pwd">Motivo o titulo del mensaje:</label>
                      <div class="col-10 col-sm-6">
                        <input type="text" class="form-control" id="subject" placeholder="Ingresar asunto" name="subject">
                        <!-- <input type="hidden" id="group-id" id="group-id" value="43000447177"> -->
                        <div class="motivovalidate error">

                        </div>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>

                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="pwd">Descripci&oacute;n:</label>
                      <div class="col-10 col-sm-6">
                        <textarea class="form-control" id="description" name="description" placeholder="Ingresar descripcion" style="height: 50%;" maxlength="3000"></textarea>
                        <div class="descripvalidate error">

                        </div>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>

                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="pwd" >Seleccion un archivo adjunto:</label>
                      <div class="col-10 col-sm-6">
                        <input type='file' class="dropzone" id="myFile" name="myFile" multiple>Se puede enviar maximo 20MB
                      </div>
                      <div class="col-sm-2"></div>
                    </div>

                    <div class="form-group justify-content-md-center">
                      <div class="col-sm-12 text-center">
                        <button type="button" onclick="validateData()" class="btn btn-success"><b>Enviar</b></button>
                      </div>
                      <div class="col-sm-2"></div>

                    </div>
		    <div id="divurl">HI</div>
			<!-- <div class="form-group">
      <p>NOTA: La respuesta a la presente queja o reclamo serÃ¡ brindada mediante comunicaciÃ³n electrÃ³nica enviada a la direcciÃ³n que usted
         ha consignado en la presente Hoja de ReclamaciÃ³n. En caso de que usted desee que la respuesta le sea enviada a su domicilio deberÃ¡
         expresar ello en el detalle del reclamo o queja.</p>
    </div> -->
                  </form>
    </div>


<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
            <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
              <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
            </div>
          </div>





          </div>
      </div>
  </div>
</div>


@endsection
