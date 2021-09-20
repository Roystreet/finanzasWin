<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head >
    <meta charset="utf-8">
    <title>@yield('title') | WIN</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1">
    <!-- CSS FRAMEWORK -->
    <link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    <!-- TABLES -->
      <script src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>
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
          a.nounderline:link {text-decoration: none;}
     </style>
  </head>
<!-- Start of HubSpot Embed Code -->
  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/6883387.js"></script>
<!-- End of HubSpot Embed Code -->
  <body>
