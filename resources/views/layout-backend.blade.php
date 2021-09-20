<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Agregando JS -->
    <script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')         }}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')                              }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css')      }}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/bootstrap.min.css"/>


    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{  asset('css/style.css')}}" rel="stylesheet" type="text/css">
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
   }
   .fa:hover {
    color: red;
} */
    </style>
    @yield('css')
    <title>@yield('title') | WIN</title>
  </head>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <nav class="navbar navbar-static-top nav-backend">
          <a id="sidebar-toggle-backend" href="#" class="sidebar-toggle-backend sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <a href="">
            <div id="logo-backend" class="logo-backend"></div>
          </a>
          <!-- This nav content the user data :-->
          <div class="navbar-custom-menu-backend" >
            <ul class="nav navbar-nav">
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle dropdown-toggle-backend" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning countss"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Tu tienes <b class="countss"></b> notificationes</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu dropdown-menuss">

                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle dropdown-toggle-backend" data-toggle="dropdown">
                  <img src="{{ asset('dist/img/usuario.png')}}" class="user-image" alt="User Image">
                  <span class="hidden-xs"> {{ auth()->user()->lastname }} {{ auth()->user()->name }} </span>
                </a>
                <ul class="dropdown-menu"  style="width: 100%">
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
    <script src="{{ asset('js/push/bin/push.min.js') }}"></script>
    <script type="text/javascript">
      var report = 0;
      var audioElement = document.createElement('audio');
      audioElement.setAttribute('src', '../notify2.mp3');

      function notificaciones(name,lastname,subject,text,id){
          Push.Permission.request(this.onGranted, this.onDenied);
          Push.create(subject,{
              body: ' '+subject+' '+text,
              icon: '../imagenes/logo.png',
              timeout: 6000,
              onClick: function () {
                  window.focus();
                  this.close();
                  load_unseen_notification(id);
              }
          });
          //
          setTimeout(function() {
              audioElement.pause();
          },800);
      }

      var view;

      function load_unseen_notification(view = ''){
         $.ajax({
           url: "/atencion/notificationsget",
           type:"GET",
           data:{view:view},
           beforeSend: function () {
           },
         }).done( function(data) {
          if(data.unseen_notification > 0)
          {
           $.each(JSON.parse(data.notification), function( key, value ) {
              notificaciones(value.get_create_by.name,value.get_create_by.lastname,value.comment_subject,value.comment_text,value.id);
           });
          }
          $('.dropdown-menuss').html('');
          if (data.unseen_notification2 > 0){
            $.each(JSON.parse(data.notification2), function( key, value ) {
               if (value.comment_ip == 0){
                  $(".dropdown-menuss").append('<li><a style="white-space: normal !important;" href="#" class="dropdown-toggless" data-id="'+value.id+'" data-idT="'+value.modified_by+'" data-val="'+value.comment_subject+'"><i class="fa fa-users text-aqua"></i>'+value.comment_subject+' '+value.comment_text+'</a></li>');
               }else{
                  $(".dropdown-menuss").append('<li style="background: #fff !important; color: #444 !important;"><a style="white-space: normal !important;" href="#" class="dropdown-toggless" data-id="'+value.id+'" data-val="'+value.comment_subject+'" data-idT="'+value.modified_by+'"><i class="fa fa-users text-aqua"></i>'+value.comment_subject+' '+value.comment_text+'</a></li>');
               }
            });
            $('.countss').html(data.unseen_notification2);
          }else{
            $('.countss').html('0');
          }
         }).fail( function(error) {
           console.log(error);
           alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
         }).always( function() {
         });
      }

   // load_unseen_notification();

   $(document).on('click', '.dropdown-toggless', function(){
    $('.countss').html('');
    load_unseen_notification($(this).attr("data-id"));
    window.open("/atencion/tickets/views/"+$(this).attr("data-val")+"/"+$(this).attr("data-idT"), '_blank');
   });

  //  setInterval(function(){
  //   load_unseen_notification();
  // }, 2000);

    </script>
      @yield('js')
  </body>
</html>
