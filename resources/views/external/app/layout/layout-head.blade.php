<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">

    <title>@yield('title') | WIN</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <!-- CSS FRAMEWORK -->
    <link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    <!-- TABLES -->
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
    <!-- PICKER -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')              }}">
    @yield('css')
    <!-- ICONS -->
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <link href="{{  asset('css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="{{  asset('css/style-driver.css')}}" rel="stylesheet" type="text/css">
    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <script src="https://checkout.culqi.com/js/v3"></script>








    <script>
      // Initialize Firebase
      var config = {
        apiKey: "AIzaSyBqCfECYsTVmKVgqJW2MuG-nNeIM_Gj1cU",
        authDomain: "voucher-img.firebaseapp.com",
        databaseURL: "https://voucher-img.firebaseio.com",
        projectId: "voucher-img",
        storageBucket: "voucher-img.appspot.com",
        messagingSenderId: "264645547952"
      };
      firebase.initializeApp(config);
    </script>
    <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type=number] { -moz-appearance:textfield; }

          a.nounderline:link {text-decoration: none;}
          input {
              -moz-border-radius: 10px !important;
              -webkit-border-radius: 10px !important;
              border-radius: 10px !important;
              border: 1px solid #000000 !important;
           }
           button
           {
             -moz-border-radius: 10px !important;
             -webkit-border-radius: 10px !important;
             border-radius: 10px !important;
             border: 0px solid #000000 !important;
           }
    .font-app
    {
      font-family: 'Varela Round', sans-serif;
    }

.ph-center::-webkit-input-placeholder {
  font-family: 'Varela Round', sans-serif;
  text-align: center;
  line-height: 100px;/* Centrado vertical */
}
.text-center{text-align:center  !important;}
.ph-center
{
  text-align:center  !important;
}
          .col-centered{
    float: none;
    margin: 0 auto;
}



  /* tracionoen  */

  /* Enter and leave animations can use different */
  /* durations and timing functions.              */
  .slide-fade-enter-active {
    transition: all .3s ease;
  }
  .slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
  }
  .slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
  }

     </style>
  </head>
  <body>
@yield('content')
<footer class="page-footer font-small blue pt-4"><!-- Footer -->


    <!-- Copyright -->
    <div class="footer-copyright text-center py-3 copy"> Todos los Derechos Reservados  © {{date("Y")}} Copyright: WIN TECNOLOGIES INC S.A.</div>
  </footer><!-- End Footer -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/vue-hotel-datepicker@2.7.7/dist/vue-hotel-datepicker.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.min.js"></script>

  <script src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')     }}"></script>
  <script src="{{ asset('/bower_components/fastclick/lib/fastclick.js') }}"></script>
  <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('/dist/js/demo.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
  <script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>

  @yield('script')
  </body>
</html>
