@include('partials.top')
@include('partials.header')
<main role="main" id="main" class="section-main" style="background-color : rgb(14, 27, 53);color:white;">
  <div id="loader-container" class="loader-container" style=" display:none; color: black; z-index: 10; position: fixed; padding-top: 20%;padding-left: 40%;padding-top: 20%;padding-right: 50%; padding-bottom: 50%; left: 0; top: 0; width: 100%; height: 100%;  background-color: rgb(0,0,0); background-color: rgba(255,255,255,0.4);">
    <div class="loader-container">
    <div class="loader"></div>
    <div style=" padding-top: 20%;padding-left: 33%;padding-top: 43%;padding-right: 50%; padding-bottom: 50%;"><b>Procesando</b></div>
    <div class="loader2"></div>
    </div>
  </div>
@yield('content')
</main>
@include('partials.footer')
<!-- JavaScript -->
