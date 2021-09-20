
@include('partials.top-index')
@section('title', 'PQRS')
<style>
.alertify .ajs-footer .ajs-buttons .ajs-button {
    background-color: transparent;
    color: #3593d2;
    border: 0;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    border: 1px solid #3593d2;
}
</style>

                <main class="bg-light">
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
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
                     </header>
                </main>
            </div>
         </div>
        <script src="https://cdn.ckeditor.com/4.14.0/basic/ckeditor.js"></script>
        <script>CKEDITOR.replace('description');</script>
        <script type="text/javascript">
            window.showAlert = function(){
	    alertify.confirm("<h4>Ahora para poder crear un ticket debes ingresar a la oficina virtual.</h4><p>1. Iniciar sesión</p><p>2. Menu: Información> ayuda</p><p>3. Agregar un nuevo ticket</p><br><p>Para mayor información comunicarse por el Winbot</p><p><a class='btn btn-info' style='background-color: #ffe22b; border-color: #ffe22b; border-radius: 2rem;' href='https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2F2020_06_20_06_30_24.mp4?alt=media&token=adb115a0-a6d7-4ab0-a02c-af785f148b48' target='_blank'><i class='fa fa-video-camera'></i> ver tutorial</a></p>",function(){
	        location.href = "https://winescompartir.com/";
	    },
	     function(){
		location.href = "https://mywinrideshare.com/";
	    }).setHeader('<p>¡Nuevo proceso de creación de tickets</p>').set('labels', {ok:'IR A LA PAGINA PRINCIPAL', cancel:'IR A LA OFICINA VIRTUAL'});
	    
            }
  	    window.showAlert();
        </script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/script-sb-ui-pro.js') }}"></script>
        <script src="{{ asset('js/script-sb-ui-pro_aos.js') }}"></script>
        <!-- JavaScript -->
        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
        <script src="{{ asset('js/Reclamaciones/reclamaciones.js')}} "></script>
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
