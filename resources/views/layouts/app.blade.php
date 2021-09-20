<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <!-- Agregando CSS -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')         }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')                              }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{  asset('css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('alertify/css/alertify.min.css') }}">
    <style type="text/css">
    /* tr:hover {
        background-color: transparent;
    }

   tr:hover td {
        background-color: #08426a !important;
        color:#FFFFFF !important;
    }
   .table-striped>tbody>tr:nth-child(odd)>td,
   .table-striped>tbody>tr:nth-child(odd)>th {
   background-color: #ECECEC; // Choose your own color here
  } */
    </style>
    @yield('css')
    <title>@yield('title') | WIN</title>

  </head>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <a href="">
          <div id="logo-backend" class="logo-backend"></div>
        </a>
        <nav class="navbar navbar-static-top">
          <a id="sidebar-toggle-backend" href="#" class="sidebar-toggle-backend sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- This nav content the user data :-->
          <div class="navbar-custom-menu-backend">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle dropdown-toggle-backend" data-toggle="dropdown">
                  <img src="{{ asset('dist/img/usuario.png')}}" class="user-image" alt="User Image">
                  <span class="hidden-xs"> {{ auth()->user()->lastname }} {{ auth()->user()->name }} </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{ asset('dist/img/usuario.png') }}" class="img-circle" alt="User Image">
                  </li>
                  <li class="user-footer">
                  <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                  </div> -->
                    <div class="pull-right">
                      <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat"> Salir</a>
                      <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image"><img src="{{ asset('dist/img/usuario.png') }}" class="img-circle" alt="User Image"></div>
            <div class="pull-left info"><p>{{ auth()->user()->username }}</p></div>
          </div>
          {!!html_entity_decode($main)!!}
        </section>
      </aside>
      <div class="content-wrapper">
          @yield('content')
      </div>
      <footer class="main-footer" align="center">
        <span>Copyright © {{ date('Y') }} - WIN TECNOLOGIES INC S.A.<br>Todos los derechos reservados</span>
      </footer>
    </div>
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('/js/myJs.js') }}"></script>
    <script src="{{ asset('alertify/js/alertify.min.js') }}"></script>
    <!-- <script src="PATH_TO_FILE/alertify.min.js"></script> -->
      @yield('js')
  </body>
</html>
