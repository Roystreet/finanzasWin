@include('partials.top-index')

@section('title', 'Inicio')
        <div id="layoutDefault_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
                  <nav class="navbar-index navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
                      <div class="container">
                          <a class="navbar-brand text-primary" href="index.html">
                              <img src="{{ asset('/img/logo.png') }}"alt="Logo WIN Perú">
                          </a>
                          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-bars"></i>
                          </button>
                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                              <ul class="navbar-nav ml-auto mr-lg-5">
                                  <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>

                                  <!-- Authentication Links -->
                                  @guest
                                      <li class="nav-item">
                                          <a class="nav-link" href="{{ url('/acceder') }}">{{ __('Iniciar sesión') }}</a>
                                      </li>
                                      @if (Route::has('register'))
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ route('logout') }}">{{ __('Cerrar sesión') }}</a>
                                          </li>
                                      @endif
                                  @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/panel') }}">{{ __('Panel Administrativo') }}</a>
                                    </li>
                                      <li class="nav-item dropdown">
                                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                              {{ Auth::user()->name }} <span class="caret"></span>
                                          </a>

                                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                              <a class="dropdown-item" href="{{ route('logout') }}"
                                                 onclick="event.preventDefault();
                                                               document.getElementById('logout-form').submit();">
                                                  {{ __('Cerrar sesión') }}
                                              </a>

                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                  @csrf
                                              </form>
                                          </div>
                                      </li>
                                  @endguest
                              </ul>
                          </div>
                      </div>
                  </nav>
                    <div class="page-header-content py-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-8 col-lg-10 text-center">
                                  <div data-aos="fade-up">
                                      <h1 class="page-header-title">WIN RIDESHARE</h1>
                                      <p class="page-header-text">¡La primera red monetizada de transporte!</p>
                                  </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="svg-border-waves text-white">
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
                </header>
                <section id="comunicado" class="bg-white py-10">
                    <div class="container">
                        <div class="row justify-content-center z-1">
                            <div class="col-lg-8">
                                <div class="card text-justify lift">
                                    <div class="card-body p-5">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase mb-2"><b>COMUNICADO</b></h3>
                                        <p class="card-text font-weight-light mb-4">Estimado(a) Accionista, se est&aacute; realizando la verificaci&oacute;n y actualizaci&oacute;n del sistema de accionistas, 
                                          para ello requerimos que rellene el formulario enviado a su correo electr&oacute;nico.<br>
                                          Si no le ha llegado el correo electr&oacute;nico, por favor escribanos a <a href="mailto:jga@winhold.net?subject=No me ha llegado la informaci&oacute;n">jga@winhold.net</a><br>
                                          Se est&aacute; realizando esta validaci&oacute;n para mantener toda la informaci&oacute;n de contacto actualizada y le pueda llegar nuestros
                                          anuncios importantes sobre la actualidad de la empresa as&iacute; como la correcta planificaci&oacute;n de los viajes para la firma
                                          del libro de matr&iacute;cula.<br><br>
                                          
                                          Atentamente <br><br>

                                          Jefatura de Acciones <br>

                                          WIN Tecnologies INC
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="video" class="bg-light py-10">
                    <div class="container">
                        <div class="row justify-content-center z-1">
                            <div class="col-lg-8" data-aos="fade-up">
                                <div class="card lift mb-n15">
                                    <div class="card-body p-2">
                                        <div class="video overlay bg-img-cover rounded">
                                            <iframe width="100%" height="400px" src="https://www.youtube.com/embed/dX0-gqZkYlk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="bg-img-cover overlay overlay-80 py-10">
                    <div class="container position-relative">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="display-4 text-center py-10 my-10 text-white">Tu vida es una mina de oro. </br><span class="text-primary">Y tus acciones </span> te daran la herramienta para optenerlo. <span class="text-primary">WIN</span> La Primera Red Social Monetizada de Transporte. </br><span class="text-primary">"WIN lo cambia todo"</span></div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="bg-light py-10">
                    <div class="container z-1">
                        <div class="card mb-5" data-aos="fade-right">
                            <div class="row no-gutters">
                                <div class="col-md-6"><img class="img-fluid" src="{{ asset('/img/moneda_cripto.jpg') }}" alt="Imágen representativa de win pack" /></div>
                                <div class="col-md-6">
                                    <div class="card-body d-flex align-items-center justify-content-center h-100 flex-column">
                                        <h3 class="card-title font-weight-bold text-uppercase mb-2">WIN Packs</h3>
                                        <p class="card-text font-weight-light mb-4">Paquetes de cripto-tokens</p>
                                        <a class="btn btn-outline-dark btn-marketing rounded-pill" href="{{ url('/productos/acciones') }}">Conoce más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-5" data-aos="fade-left">
                            <div class="row no-gutters">
                                <div class="col-md-6 order-1 order-md-0">
                                    <div class="card-body d-flex align-items-center justify-content-center h-100 flex-column">
                                        <h3 class="card-title font-weight-bold text-uppercase mb-2">Merchandiser</h3>
                                        <p class="card-text font-weight-light mb-4">Artículos de la marca</p>
                                        <a class="btn btn-outline-dark btn-marketing rounded-pill" href="{{ url('/productos/acciones') }}">Conoce más</a>
                                    </div>
                                </div>
                                <div class="col-md-6 order-0 order-md-1"><img class="img-fluid" src="{{ asset('/img/marchandiser.png') }}" alt="Imágen representativa de marchandiser" /></div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-right">
                            <div class="row no-gutters">
                                <div class="col-md-6"><img class="img-fluid" src="{{ asset('/img/embajador.png') }}" alt="Imágen representativa de win pack" /></div>
                                <div class="col-md-6">
                                    <div class="card-body d-flex align-items-center justify-content-center h-100 flex-column">
                                        <h3 class="card-title font-weight-bold text-uppercase mb-2">Activación de Embajador</h3>
                                        <p class="card-text font-weight-light mb-4">Accede a una oficina virtual completa para el monitoreo de tu red!</p>
                                        <a class="btn btn-outline-dark btn-marketing rounded-pill" href="{{ url('/productos/acciones') }}">Conoce más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="svg-border-rounded text-white mt-n15">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                    </div>
                </section>
                <section class="bg-white py-10">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-6 col-lg-8 col-md-10 text-center my-10 py-10">
                                <h2>¿Listo para participar?</h2>
                                <p class="lead text-gray-500 mb-5">Las palabras quizás inspiren, pero solo las acciones generan cambios.</p>
                                <a class="btn btn-primary btn-marketing rounded-pill" href="{{ url('/productos/acciones') }}">Ir a la tienda</a>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
@include('partials.footer-index')
