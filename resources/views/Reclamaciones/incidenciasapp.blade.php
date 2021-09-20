
@include('partials.top-index')
@section('title', 'PQRS')
                <main class="bg-light">
                    <!-- <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
                  	    <nav class="navbar-index navbar navbar-marketing navbar-expand-lg bg-transparent">
                              <div class="container">
                                  <a class="navbar-brand text-primary" href="index.html">
                                      <img src="{{ asset('/img/logo_win.png') }}"alt="Logo WIN Perú">
                                  </a>
                                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                      <i class="fa fa-bars"></i>
                                  </button>
                                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                     <ul class="navbar-nav ml-auto mr-lg-5">
                                         <li class="nav-item"><a class="nav-link" href="https://winescompartir.com">P&aacute;gina principal</a></li>
                                     </ul>
                                  </div>
                              </div>
                          </nav>
    		                    <div class="page-header-content py-5" style="padding-top: 9rem !important;">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-8 col-lg-10 text-center">
                                          <div data-aos="fade-up">
                                              <h1 class="page-header-title">Cont&aacute;ctanos</h1>
                                              <p class="page-header-text">&iquest;Tienes alguna solicitud? Nosotros podemos ayudarte</p>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="svg-border-waves text-light">
                                <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                                    <defs>
                                        <style>
                                            .a {
                                                fill: none;
                                            }
                                            .b {
                                                clip-path: url(#a);
                                            }
                                            .d {
                                                opacity: 0.5;
                                                isolation: isolate;
                                            }
                                        </style>
                                        <clippath id="a"><rect class="a" width="1920" height="75"></rect></clippath>
                                    </defs>
                                    <title>wave</title>
                                    <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48"></path></g>
                                    <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10"></path></g>
                                    <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24"></path></g>
                                    <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150"></path></g>
                                </svg>
                            </div>
                    </header> -->
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
                                                   <h3 class="mb-5">Crea un ticket de incidencia</h3>
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
                                            <div class="form-group" >
                                                <label class="col-sm-12 text-bold" for="group_id">Usuario quien tuvo el incidente <i class="fa fa-question-circle" title="Ingrese el usuario con lo cual se registro en la aplicación u oficina virtual."></i></label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="user" name="user" placeholder="Ingrese su usuario" >
                                                    <div class="uservalidate error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class="col-sm-12 text-bold" for="agent">Embajador quien reporta <i class="fa fa-question-circle" title="Ingrese el usuario con lo cual se registro en la aplicación u oficina virtual."></i></label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="agent" name="agent" placeholder="Ingrese su usuario" >
                                                    <div class="agentvalidate error">
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
                                            <!-- customer inicio -->
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
                                            <!-- customer fin -->

                                            <!-- Embajador inicio -->
                                            <div id="divembajador">
                                                <div class="form-group justify-content-md-center">
                                                    <label class="col-sm-12 text-bold" for="name">Nombres</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" id="nameEmb" name="nameEmb" placeholder="Ingrese su nombre completo" >
                                                        <div class="namevalidate error">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group justify-content-md-center">
                                                    <label class="col-sm-12 text-bold" for="lastname">Apellidos</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" id="lastnameEmb" name="lastnameEmb" placeholder="Ingrese sus apellidos" >
                                                        <div class="lastnamevalidate error">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Embajador fin -->
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
                                            <div class="form-group">
                                                <label class="col-sm-12 text-bold" for="tipo">Tipo de solicitud <i class="fa fa-question-circle" title="Petición: El cliente o usuario solicita información o cambio. Incidente:Inconveniente que se presenta en el servicio o en los sistemas.  Sugerencia: El cliente formula una propuesta de mejora en el servicio o sistema. "></i></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" id="tipo" name="tipo">
                                                        <option value="Incidente">Incidente</option>
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
                                                        <option>No pude finalizar un servicio</option>
                                                        <option>La tarifa fue mas alta de la estimada</option>
                                                        <option>Se cerro la aplicación mientras lo estaba utilizando</option>
                                                        <option>Problemas en el registro</option>
                                                        <option>No puedo actualizar mis datos</option>
                                                        <option>Problemas al compartir mi usuario</option>
                                                        <option>No puedo iniciar sesión</option>
                                                        <option>Otros</option>
                                                    </select>
                                                    <div class="motivovalidate error">
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
                                <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
                                    <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
                                      <center><div style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="svg-border-waves text-dark"style="background: #eff3f9;">
                        <svg class="wave" style="background: #eff3f9; pointer-events: none; bottom: auto;" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                            <defs>
                                <style>
                                    .a {
                                        fill: none;
                                    }
                                    .b {
                                        clip-path: url(#a);
                                    }
                                    .d {
                                        opacity: 0.5;
                                        isolation: isolate;
                                    }
                                </style>
                                <clippath id="a"><rect class="a" width="1920" height="75"></rect></clippath>
                            </defs>
                            <title>wave</title>
                            <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48"></path></g>
                            <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10"></path></g>
                            <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24"></path></g>
                            <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150"></path></g>
                        </svg>
                    </div>
                </main>
            </div>
            <div id="layoutDefault_footer">
                <footer class="footer pt-10 pb-5 mt-auto bg-dark footer-dark">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="footer-brand">WIN RIDESHARE</div>
                                <div class="mb-3">Ticket de soporte</div>
                                <div class="icon-list-social mb-5">
                                    <a class="icon-list-social-link" href="https://www.instagram.com/win.tecnologies/?igshid=9smeb9ykslm7"><i class="fa fa-instagram"></i></a>
                                    <a class="icon-list-social-link" href="https://web.facebook.com/Win-Tecnologies-107937183898910/?_rdc=1&_rdr"><i class="fa fa-facebook-square"></i></a>
                                    <a class="icon-list-social-link" href="https://www.youtube.com/channel/UCHCWOH9Kizu91O0DgiLEZ3Q"><i class="fa fa-youtube"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                                        <div class="text-uppercase-expanded text-xs mb-4">Sistemas</div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="https://winescompartir.com/">WEB Principal</a></li>
                                            <li class="mb-2"><a href="https://mywinrideshare.com/">Oficina Virtual</a></li>
                                            <li class="mb-2"><a href="http://conductores.wintecnologies.com/">Validaci&oacute;n de conductor</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                                        <div class="text-uppercase-expanded text-xs mb-4">Pa&iacute;ses</div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="javascript:void(0);">Bolivia</a></li>
                                            <li class="mb-2"><a href="javascript:void(0);">Colombia</a></li>
                                            <li class="mb-2"><a href="javascript:void(0);">Ecuador</a></li>
                                            <li class="mb-2"><a href="javascript:void(0);">M&eacute;xico</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
                                        <div class="text-uppercase-expanded text-xs mb-4">Soporte</div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="https://help.wintecnologies.com/">Centro de ayuda</a></li>
                                            <li class="mb-2"><a href="https://comunidad.winrides.com/">Comunidad</a></li>
                                            <li class="mb-2"><a href="https://wintecnologies.com/soporte">Ticket de atenci&oacute;n</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="text-uppercase-expanded text-xs mb-4">Legal</div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="javascript:void(0);">Pol&iacute;ticas de privacidad</a></li>
                                            <li class="mb-2"><a href="javascript:void(0);">Terminos y condiciones</a></li>
                                            <li class="mb-2"><a href="javascript:void(0);">Licencia</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5" />
                        <div class="row align-items-center">
                            <div class="col-md-6 small">Copyright &copy; WIN RIDESHARE 2020</div>
                            <div class="col-md-6 text-md-right small">
                                <a href="javascript:void(0);">Pol&iacute;ticas de privacidad</a>
                                &middot;
                                <a href="javascript:void(0);">Terminos &amp; Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>
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
        <script src="{{ asset('js/Reclamaciones/incidenciasapp.js')}} "></script>
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
    </body>
</html>
