@extends('layouts.app')
@section('title', 'Listado de Productos')


{{--  --}}
@section('css')
@endsection
@section('content')


   <div class="box-header">
      <h3 class="box-title">Listado de Productos</h3>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="box-body" id="content">
      <div class="hero-callout">
        <table id="productos"  class="table-striped table-hover">
          <thead class="thead-dark">
              <tr>
              <th >ID Producto</th>
              <th >Código</th>
              <th >Nombre</th>
              <th >Descripción</th>
              <th >Accion (Activar/Desactivar)</th>
              </tr>
          </thead>
          <tbody>
        </tbody>
        <tfoot class="thead-dark">
          <tr>
            <th >ID Producto</th>
            <th >Código</th>
            <th >Nombre</th>
            <th >Descripción</th>
            <th >Accion (Activar/Desactivar)</th>
          </tr>
        </tfoot>
    </table>
      </div>
    </div>
  </div>
</section>

@endsection

@section('js')

<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
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
  var storage = firebase.storage();
</script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="{{ asset('js/Product/activarproductos.js') }}"></script>
@endsection
