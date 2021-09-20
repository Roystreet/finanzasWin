@include('partials.top2')

<main role="main" id="main" class="section-main" style="background-color : rgb(14, 27, 53);color:white;">
@yield('content')
</main>
<!-- <script src="{{ asset('js/External/Driver/confirm.js')}} "></script> -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
<script src="{{ asset('js/Reclamaciones/reclamaciones.js')}} "></script>
</body>
</html>
