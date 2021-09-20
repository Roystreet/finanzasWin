
    @extends('layout-simple')
    @section('title', 'Completado')
    @section('content')
    <!-- Main content -->
    <section class="content">
      <div class="callout callout-success">
        <h4>Completado!</h4>
        <p>La información de la compra se ha enviado por correo Electrónico.</p>
      </div>
      <p id=redirigir data-redi="{{ $ale }}"></p>
      <!-- Default box -->
    </section>
    <!-- /.content -->
    @endsection
    @section('script')
    <script src="{{ asset('js/External/sales/registerExterno.js')}}"></script>
    @endsection
