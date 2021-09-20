<style>
.feather {
  height: 2rem !important;
  width: 2rem !important;
  vertical-align: top;
}

.col-lg-12, .col-sm-12 {
    position: relative;
    width: 100%;
    padding-right: 0.8rem !important;
    padding-left: 0.8rem !important;
}

.card-body {
    padding: 0.9rem !important;
}

@media (max-width: 850px){
  .h6 {
    font-size: 0.7rem !important;
  }

  h5{
    font-size: 0.7rem !important;
  }
}
</style>
@include('partials.top-index')
@section('title', 'PQRS')
                <main class="bg-white">
                    <div id="LoginForm" style="color:black;-webkit-text-stroke: 0.1px black;" class="bg-white">
                        <div class="">
                        	  <meta name="csrf-token" content="{{ csrf_token() }}">
                        		<div class="box box-primary borderdiv">
                                <div class="row contenedor">
                                  <form class="caja col-lg-12 form-horizontal" id="form-documentos-driver">
                                    <div class="z-1" style=" border-bottom: 1px solid gray;">
                                        <a class="card text-decoration-none lift errorapp" data-id="1" data-des="Error en la aplicación">
                                          <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-primary"><i data-feather="chevron-right"></i></div>
                                                    <div class="ml-2">
                                                        <h5 class="text-black text-uppercase">Error en la aplicación</h5>
                                                        <p class="card-text text-primary h6">Incidencias en el funcionamiento de la app. Ej: no te abre una opción en el menú, un botón no responde, te sale un mensaje de error, entre otros.</p>
                                                    </div>
                                                </div>
                                            </div>
                                          </a>
                                    </div>
                                    <div class="z-1" style=" border-bottom: 1px solid gray;">
                                        <a class="card text-decoration-none lift errorapp" data-id="2" data-des="Problemas generales">
                                          <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-primary"><i data-feather="chevron-right"></i></div>
                                                    <div class="ml-2">
                                                        <h5 class="text-black text-uppercase">Problemas generales</h5>
                                                        <p class="card-text text-primary h6">Para reportes de problema con tu cuenta, método de pago, factura, referidos o créditos.</p>
                                                    </div>
                                                </div>
                                            </div>
                                          </a>
                                    </div>
                                    <div class="z-1" style=" border-bottom: 1px solid gray;">
                                        <a class="card text-decoration-none lift errorapp" data-id="3" data-des="Inconveniente con el servicio/usuario">
                                          <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-primary"><i data-feather="chevron-right"></i></div>
                                                    <div class="ml-2">
                                                        <h5 class="text-black text-uppercase">Inconveniente con el servicio/usuario</h5>
                                                        <p class="card-text text-primary h6">Si presentas algún tipo de inconveniente relacionado con tu viaje. Ej: trayecto, cobro, vehículo, conductor, etc.</p>
                                                    </div>
                                                </div>
                                            </div>
                                          </a>
                                    </div>
                                    <div class="z-1" style=" border-bottom: 1px solid gray;">
                                        <a class="card text-decoration-none lift errorapp" data-id="4" data-des="Accidente">
                                          <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-primary"><i data-feather="chevron-right"></i></div>
                                                    <div class="ml-2">
                                                        <h5 class="text-black text-uppercase">Accidente</h5>
                                                        <p class="card-text text-primary h6">Presencia de una emergencia que impida que el servicio se complete. Ej: accidente de tránsito, emergencia médica, fallo mecánico, entre otro.</p>
                                                    </div>
                                                </div>
                                            </div>
                                          </a>
                                    </div>
                                    <div class="z-1" style=" border-bottom: 1px solid gray;">
                                        <a class="card text-decoration-none lift errorapp" data-id="5" data-des="PQRS">
                                          <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="text-primary"><i data-feather="chevron-right"></i></div>
                                                    <div class="ml-2">
                                                        <h5 class="text-black text-uppercase">PQRS</h5>
                                                        <p class="card-text text-primary h6">Realizar una petición, queja, reclamo o sugerencia a través de la creación de un ticket.</p>
                                                    </div>
                                                </div>
                                            </div>
                                          </a>
                                    </div>
                                   </form>
                                    <form style="display: none;" class="caja col-lg-12 form-horizontal" action="#" id="formfreshdeks" enctype="multipart/form-data">
                                        <div class="col-sm-12 card" style="margin: 0 auto; padding-top: 2rem;">
                                           <div class="form-group"  id="divusuario">
                                                <input type="text" class="form-control" id="user" name="user" value="{{$username}}" >
                                                <input type="hidden" value="{{$countryid}}" id="countryids">
                                                <input type="hidden" id="group_id" name="group_id" value="{{ $countrys }}">
                                                <input type="hidden" id="ctryname" name="ctryname" value="{{ $ctrname }}">
                                                <input type="text" class="form-control" id="name" name="name" value="{{$first_name}}" >
                                                <input type="text" class="form-control" id="lastname" name="lastname" value="{{$last_name}}" >
                                                <input type="email" class="form-control" id="email" value="{{$email}}" name="email">
                                                <input type="text" id="prefpais" name="prefpais"  class="form-control" value="{{ $countrycode }}">
                                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{$phone}}">
                                            </div>
                                            <div class="form-group typepqrs">
                                                <label class="col-sm-12 text-bold" for="tipo">Tipo de solicitud <i class="fa fa-question-circle" title="Petición: El cliente o usuario solicita información o cambio. Incidente:Inconveniente que se presenta en el servicio o en los sistemas.  Sugerencia: El cliente formula una propuesta de mejora en el servicio o sistema. "></i></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="tipo" name="tipo">
                                                        <option value="">-</option>
                                                        <option value="Peticion">Peticion</option>
                                                        <option value="Incidente">Incidente</option>
                                                        <option value="Sugerencia">Sugerencia</option>
                                                        <option value="Reclamo">Reclamo</option>
                                                        <option value="Queja">Queja</option>
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
                                                        <option class="t1">Demora en inicio de sesión</option>
                                                        <option class="t1">El menú lateral no responde</option>
                                                        <option class="t1">Los enlaces no apunta nada</option>
                                                        <option class="t1">La ruta  no se actualiza  a tiempo</option>
                                                        <option class="t1">No pude finalizar el viaje</option>
                                                        <option class="t1">Se cerro la aplicación inesperadamente</option>
                                                        <option class="t1">No me aparece la ruta</option>
                                                        <option class="t2">Me desconto de más  en el viaje</option>
                                                        <option class="t2">Se quedo pegada la aplicación</option>
                                                        <option class="t3">La tarifa no es la correcta</option>
                                                        <option class="t3">La dirección no  coincide con el punto de  inicio</option>
                                                        <option class="t3">La dirección  es errada al finalizar el servicio</option>
                                                        <option class="t3">El conductor fue  grosero (lenguaje inapropiado)</option>
                                                        <option class="t3">El vehículo no cumple con las medidas de BIoseguridad</option>
                                                        <option class="t3">El vehiculo esta en mal estado</option>
                                                        <option class="t4">Accidente de tránsito</option>
                                                        <option class="t4">Desperfecto mecánico</option>
                                                        <option class="t5">Oficina Virtual</option>
                                                        <option class="t5">Aplicativo</option>
                                                        <option class="t5">Sistema de validación</option>
                                                        <option class="t5">Comunidad</option>
                                                        <option class="t5">Acciones</option>
                                                        <option class="t5">Otros</option>
                                                    </select>
                                                    <div class="motivovalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div  id="categ">
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
                                                <label class="col-sm-12 text-bold" for="versionso">Version del sistema operativo <i class="fa fa-question-circle" title="Ingrese el usuario con lo cual se registro en la aplicación u oficina virtual."></i></label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="versionso" name="versionso" placeholder="Ingrese version del sistema operativo" >
                                                    <div class="versionsovalidate error">
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
                                            </div>
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
                                                    <button type="button" onclick="validateData()" class="btn btn-primary btn-block">Enviar solictud</button>
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
        <script src="{{ asset('js/Reclamaciones/aplicacion.js?v=555')}} "></script>
        <script>
            AOS.init({
                disable: 'mobile',
                duration: 600,
                once: true
            });
        </script>
        <script>
          feather.replace()
        </script>
    </body>
</html>
