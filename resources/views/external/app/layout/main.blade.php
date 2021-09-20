<!doctype html>
<html lang="es" dir="ltr">
  <head>
    <title>@yield('title') | WIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="favicon.ico">
<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- ICONS -->
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('css/new.css') }}" rel="stylesheet">
    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <script src="https://checkout.culqi.com/js/v3"></script>


  </head>
  <body class="wintech">
    <nav id="new-header" class="navbar sticky-top navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#win-nav" aria-controls="win-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon material-icons menu-icon">menu</span>
        </button>
        <a href="#">
          <img src="imagenes/logo.png" height="30px">
        </a>
        <div class="collapse navbar-collapse justify-content-md-center" id="win-nav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="#">Inicio</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Nosotros</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Contáctanos</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Acceder</a>
            </li>
          </ul>
        </div>
    </nav>


@yield('content')



<!-- Footer -->
<footer id="new-footer" class="page-footer font-small pt-4">
    <div class="container-fluid text-center text-md-left">
      <div class="row">
        <div class="col-md-6 mt-md-0 mt-3">
          <h5 class="text-uppercase">Win Technologies Inc.</h5>
          <p>Empresa dedicada al desarrollo de la tecnología para facilitar las necesidades esenciales y los deseos de la humanidad.</p>
        </div>
        <hr class="clearfix w-100 d-md-none pb-3">
        <div class="col-md-3 mb-md-0 mb-3">
          <h5>CONTÁCTANOS</h5>
          <a href="https://goo.gl/maps/ss2zu5Gxiitaz1ae9">Dirección de oficina principal:
            <br>Jirón Pataz 1253, urbanización COVIDA II Etapa, Los Olivos, Lima, Lima, Perú. 
          </a>
        </div>
        <div class="col-md-3 mb-md-0 mb-3">
          <h5>Redes Sociales</h5>
          <ul class="list-unstyled text-small">
            <li>
                <a id="footer-words" href="https://www.facebook.com/WinTecnologiesOficial"><i id="social-footer" class="fa fa-facebook-official fa-2x"></i>Facebook</a>
            </li>
            <li>
                <a id="footer-words" href="https://www.instagram.com/win.tecnologies"><i id="social-footer" class="fa fa-instagram fa-2x"></i>Instagram</a>
            </li>
            <li>
                <a id="footer-words" href="https://www.youtube.com/channel/UCHCWOH9Kizu91O0DgiLEZ3Q/videos"><i id="social-footer" class="fa fa-youtube-square fa-2x"></i>Youtube</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright text-center py-3">
        © 2020 Copyright: WIN TECNOLOGIES INC S.A.
    </div>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>