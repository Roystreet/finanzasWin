@include('partials.top-index')
@section('title', 'PQRS')
                <main class="bg-light">
                    <div id="LoginForm" style="color:black;-webkit-text-stroke: 0.1px black;" class="bg-light">
                        <div class="container">
                        	  <meta name="csrf-token" content="{{ csrf_token() }}">
                        		<div class="box box-primary borderdiv">
                                <div class="row contenedor">
                                    <div class="caja col-lg-5 form-horizontal py-5 padding-card">
                                          <div class="col-sm-12 form-horizontal padding-form">
                                              <div class="form-group justify-content-md-center">
                                                  <h3 style="color: #0D436B;">¿Qué debo hacer después de enviar mi solictud?</h3>
                                              </div>
                                          </div>
                                          <div class="col-sm-12 form-horizontal padding-form">
                                              <div class="form-group justify-content-md-center">
                                                  <h4>Estás a punto de comunicarte con nosotros para recibir la respuesta que estás buscando.</h4>
                                              </div>
                                          </div>
                                          <div class="form-group justify-content-md-center">
                                              <div class="col-sm-offset-2 col-sm-10" style="max-width: 100% !important;">
                                                  <a class="card card-link border-top border-top-lg lift text-center o-visible h-100" style="border-color: #ffe22b !important;" nohref>
                                                      <div class="card-body">
                                                          <div class="icon-stack icon-stack-xl mb-4 mt-n5 z-1 shadow" style="background-color: #f5ebae !important;"><i class="fa fa-inbox"></i></div>
                                                          <h5><b>1. Recibiremos tu solicitud</b></h5>
                                                          <p class="card-text">Nuestro sistema te enviará un correo de confirmación y asignará automaticamente tu solictud a uno de nuestros agentes para que obtengas una rápida respuesta.</p>
                                                      </div>
                                                   </a>
                                              </div>
                                          </div>
                                          <div class="form-group justify-content-md-center">
                                              <div class="col-sm-offset-2 col-sm-10" style="max-width: 100% !important;">
                                                  <a class="card card-link border-top border-top-lg lift text-center o-visible h-100" style="border-color: #08426a !important;" nohref>
                                                      <div class="card-body">
                                                          <div class="icon-stack icon-stack-xl mb-4 mt-n5 z-1 shadow" style="background-color: #93bcd8 !important;"><i class="fa fa-cogs"></i></div>
                                                          <h5><b>2. Derivaremos tu solicitud</b></h5>
                                                          <p class="card-text">Nuestros agentes derivarón tu solictud al área correspondiente para que obtengas una respuesta asertiva.</p>
                                                      </div>
                                                   </a>
                                              </div>
                                          </div>
                                          <div class="form-group justify-content-md-center">
                                              <div class="col-sm-offset-2 col-sm-10" style="max-width: 100% !important;">
                                                  <a class="card card-link border-top border-top-lg lift text-center o-visible h-100" style="border-color: #666 !important;" nohref>
                                                      <div class="card-body">
                                                          <div class="icon-stack icon-stack-xl mb-4 mt-n5 z-1 shadow" style="background-color: #c3c3c3 !important;"><i class="fa fa-share-square"></i></div>
                                                          <h5><b>3. Te daremos una respuesta</b></h5>
                                                          <p class="card-text">En un lapso no mayor a 24 horas te estaremos comunicando una respuesta a tu solicitud via correo electrónico.</p>
                                                      </div>
                                                   </a>
                                              </div>
                                          </div>
                                    </div>
                                    <form class="caja col-lg-7 form-horizontal" action="#" id="formfreshdeks" enctype="multipart/form-data">
                                        <div class="col-sm-12" >
                                           <div class="row justify-content-center" style="padding-top: 3rem !important;">
                                               <div class="col-lg-8 text-center">
                                                   <h2><i class="fa fa-envelope" style="font-size: 2rem;"></i></h2>
                                                   <h3 class="mb-5">Crea un ticket de atención para ayudarte en tu solicitud</h3>
                                               </div>
                                           </div>
                                        </div>
                                        <div class="col-sm-10 card" style="margin: 0 auto; padding-top: 2rem;">
                                            <div class="form-group justify-content-md-center" id="divusuario">
                                                <label class="col-sm-12 text-bold" for="typeCustomer">¿Ya se encuentra registrado en win? <i class="fa fa-question-circle" title="Si ya te encuentras registrado en WIN, seleccione 'SI'. De lo contrario seleccione 'NO'"></i></label>
                                                <div class="col-sm-12">
                                                   <select class="form-control" id="typeCustomer" name="typeCustomer">
                                                         <option value="">-</option>
                                                         <option value="Si">Si</option>
                                                         <option value="No">No</option>
                                                   </select>
                                                   <div class="typecusvalidate error">
                                                   </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 text-bold" for="group_id">Usuario <i class="fa fa-question-circle" title="Ingrese el usuario con lo cual se registro en la aplicación u oficina virtual."></i></label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control input-number-letter" id="user" name="user" placeholder="Ingrese su usuario" >
                                                    <div class="uservalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="divcountry">
                                                <label class="col-sm-12 text-bold" for="group_id">Seleccione su paí­s</label>
                                                <div class="col-sm-12">
                                                    <input type="hidden" value="{{$countryid}}" id="countryids">
                                                    <input type="hidden" id="group_id" name="group_id" value="{{ $countrys }}">
                                                    <input type="hidden" id="ctryname" name="ctryname" value="{{ $ctrname }}">
                                                    <div class="paisvalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="divcustomer">
                                                <div class="form-group justify-content-md-center">
                                                    <label class="col-sm-12 text-bold" for="name">Nombres</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su nombre completo" >
                                                        <div class="namevalidate error">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group justify-content-md-center">
                                                    <label class="col-sm-12 text-bold" for="lastname">Apellidos</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Ingrese sus apellidos" >
                                                        <div class="lastnamevalidate error">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group justify-content-md-center">
                                                    <label class="col-sm-12 text-bold" for="email">Correo Electr&oacute;nico</label>
                                                    <div class="col-sm-12">
                                                        <input type="email" class="form-control" id="email" placeholder="Ej: nombre@correo.com" name="email">
                                                        <div class="emailvalidate error">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group justify-content-md-center" style="display: flex; flex-wrap: wrap;">
                                                    <label class="col-sm-4 text-bold" for="telefono">Código</label>
                                                    <label class="col-sm-8 text-bold" for="telefono">Número de tel&eacute;fono</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="prefpais" name="prefpais"  class="form-control" value="{{ $countrycode }}">
                                                        <div class="codigvalidate error">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="telefono" placeholder="Numero telefono Ej: 999944222" name="telefono">
                                                      <div class="telefonovalidate error">
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 text-bold" for="tipo">Tipo de solicitud <i class="fa fa-question-circle" title="Petición: El cliente o usuario solicita información o cambio. Incidente:Inconveniente que se presenta en el servicio o en los sistemas.  Sugerencia: El cliente formula una propuesta de mejora en el servicio o sistema. "></i></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="tipo" name="tipo">
                                                        <option value="">-</option>
                                                        <option value="Peticion">Peticion</option>
                                                        <option value="Incidente">Incidente</option>
                                                        <option value="Sugerencia">Sugerencia</option>
                                                        <option value="Queja">Queja</option>
                                                        <option value="Reclamo">Reclamo</option>
                                                    </select>
                                                    <div class="tipovalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group  justify-content-md-center">
                                                <label class="col-sm-12 text-bold" for="pwd"> Elija la categoría de su solicitud <i class="fa fa-question-circle" title="Seleccione el tema o asunto que va relacionado su solicitud. "></i></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="subject" name="subject">
                                                        <option>-</option>
                                                        <option>Oficina Virtual</option>
                                                        <option>Aplicativo</option>
                                                        <option>Sistema de validación</option>
                                                        <option>Comunidad</option>
                                                        <option>Acciones</option>
                                                        <option>Otros</option>
                                                    </select>
                                                    <div class="motivovalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- INCIO TIPO QUEJA  --}}
                                            <div id="typequejas">
                                              <div class="form-group" >
                                                  <label class="col-sm-12 text-bold" for="model">ID del viaje <i class="fa fa-question-circle"></i></label>
                                                  <div class="col-sm-12">
                                                      <input type="text" class="form-control" id="idtravel" name="idtravel" placeholder="Ingrese id del viaje" >
                                                      <div class="idtravelvalidate error">
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>

                                            {{-- INICIO TIPO DE INCIDENTE --}}
					    <div id="typeincidentes">
					    <div class="form-group">
                                                <label class="col-sm-12 text-bold" for="tipocustomer">Rol <i class="fa fa-question-circle" title="Petición: El cliente o usuario solicita información o cambio. Incidente:Inconveniente que se presenta en el servicio o en los sistemas.  Sugerencia: El cliente formula una propuesta de mejora en el servicio o sistema. "></i></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="tipocustomer" name="tipocustomer">
                                                        <option value="">-</option>
                                                        <option value="Pasajero">Pasajero</option>
                                                        <option value="Conductor">Conductor</option>
                                                    </select>
                                                    <div class="tipocustomervalidate error">
                                                    </div>
                                                </div>
                                            </div>
					    <div class="form-group  justify-content-md-center">
                                                <label class="col-sm-12 text-bold" for="pwd"> Elija el motivo de su solicitud <i class="fa fa-question-circle" title="Seleccione el tema o asunto que va relacionado su solicitud. "></i></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="subject1" name="subject1">
                                                        <option>-</option>
                                                        <option>No pude finalizar un servicio</option>
                                                        <option>La tarifa fue mas alta de la estimada</option>
                                                        <option>Se cerro la aplicación mientras lo estaba utilizando</option>
                                                        <option>Problemas en el registro</option>
                                                        <option>No puedo actualizar mis datos</option>
                                                        <option>Problemas al compartir mi usuario</option>
                                                        <option>No puedo iniciar sesión</option>
                                                        <option>Otros</option>
                                                    </select>
                                                    <div class="motivo1validate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 text-bold" for="so">Sistema operativo <i class="fa fa-question-circle" title="Petición: El cliente o usuario solicita información o cambio. Incidente:Inconveniente que se presenta en el servicio o en los sistemas.  Sugerencia: El cliente formula una propuesta de mejora en el servicio o sistema. "></i></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="so" name="so">
                                                        <option value="">-</option>
                                                        <option value="Android">Android</option>
                                                        <option value="IOS">IOS</option>
                                                    </select>
                                                    <div class="sovalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class="col-sm-12 text-bold" for="model">Modelo <i class="fa fa-question-circle" title="Ingrese el usuario con lo cual se registro en la aplicación u oficina virtual."></i></label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="model" name="model" placeholder="Ingrese modelo del telefono" >
                                                    <div class="modelvalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class="col-sm-12 text-bold" for="versionso">Version del sistema operativo <i class="fa fa-question-circle" title="Ingrese el usuario con lo cual se registro en la aplicación u oficina virtual."></i></label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="versionso" name="versionso" placeholder="Ingrese version del sistema operativo" >
                                                    <div class="versionsovalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                          {{-- FIN TIPO INCIDENTE --}}







                                            <div class="form-group justify-content-md-center">
                                                <label class="col-sm-12 text-bold" for="pwd">Bríndanos más detalle para poder ayudarte <i class="fa fa-question-circle" title="Ingrese mayor detalle o descripción de su solicitud."></i></label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" rows="10" cols="80" id="description" name="description" placeholder="Ingresar descripcion" style="height: 50%;" maxlength="3000" data-sample-short></textarea>
                                                    <div class="descripvalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group  justify-content-md-center">
                                                <label class="col-sm-12 text-bold" for="pwd" >Selecciona un archivo adjunto </label>
                                                <div class="col-sm-12">
                                                    <input type='file' class="dropzone" id="myFile" name="myFile" multiple>
                                                    <p>Se puede enviar maximo 20MB</p>
                                                </div>
                                            </div>
                                            <div class="form-group justify-content-md-center">
                                                <div class="col-sm-12 text-center">
                                                    <button type="button" id="btn-enviar" onclick="validateData()" class="btn btn-primary btn-block">Enviar solictud</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="load_inv" class="load_inv" style="display:none; color: black; z-index: 10; position: fixed; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
  				  <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
    				    <div class="d-flex justify-content-center">
      				       <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
        				<span class="sr-only">Loading...</span>
      				       </div>
    				    </div>
  				  </div>
				</div>
                           </div>
                        </div>
                    </div>
                </main>
            </div>
         </div>
        <script src="https://cdn.ckeditor.com/4.14.0/basic/ckeditor.js"></script>
        <script>CKEDITOR.replace('description');</script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/script-sb-ui-pro.js') }}"></script>
        <script src="{{ asset('js/script-sb-ui-pro_aos.js') }}"></script>
        <!-- JavaScript -->
        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
        <script src="js/Reclamaciones/reclamaciones.js?v=888888"></script>
        <!-- Start of HubSpot Embed Code -->
        <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/6883387.js"></script>
        <!-- End of HubSpot Embed Code -->
        <script>
            AOS.init({
                disable: 'mobile',
                duration: 600,
                once: true
            });
        </script>
        <script type="text/javascript">
         $('.input-number-letter').on('input', function () {
           this.value = this.value.replace(/[^a-z0-9\_]/,'');
         });
        </script>
    </body>
</html>
