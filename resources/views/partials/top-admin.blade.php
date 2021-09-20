<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema interno de personal administrativo de WIN TECNOLOGIES INC S.A."/>
        <meta name="author" content="Diseño: Susana Piñero. Desarrollo: Mauro Gomez, Brenda Atto, Gloribel Delgado, Victor Pérez." />
        <title>@yield('title') | WIN</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <!-- CSS del tema -->
        <link href="css/style-sb-admin-pro.css" rel="stylesheet" />
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <!-- FUENTES Oficiales -->
        <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
        <!-- CSS del tema personalizado -->
        <link href="css/style-admin.css" rel="stylesheet" />
        <!-- Iserta css personalizado de cada vista -->
        @yield('css')
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
    </head>
    <!-- Integrción de HubSpot -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/6883387.js"></script>
    <!-- FIN Integrción de HubSpot -->
    <body>
