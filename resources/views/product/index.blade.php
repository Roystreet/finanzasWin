@extends('layout-backend')
@section('title', 'Listado de Productos')


{{--  --}}
@section('css')
@endsection

@section('content')
   <div class="box-header">
      <h3 class="box-title">Listado de Productos</h3>

      <?php
      echo $permisocrear == true || $rolid == 4 ? '<button type="button" class="btn btn-info pull-right" id="register" data-toggle="modal" data-target="#exampleModalCenter">Registrar Productos</button>' : '';
      ?>

    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="box-body" id="content">
      <div class="hero-callout">
        <table id="products"  class="table-striped table-hover">
          <thead class="thead-dark">
              <tr>
              <th >Acción</th>
              <th >Código</th>
              <th >Nombre</th>
              <th >Descripción</th>
              <th >editar Imagen</th>
              <th >visible en la tienda</th>
              </tr>
          </thead>
          <tbody>
        </tbody>
        <tfoot class="thead-dark">
          <tr>
            <th >Acción</th>
            <th >Código</th>
            <th >Nombre</th>
            <th >Descripción</th>
            <th >editar Imagen</th>
            <th >visible en la tienda</th>
          </tr>
        </tfoot>
    </table>
      </div>
    </div>
  </div>
</section>
<!-- Modal create-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Precios</h4>
      </div>
      <div class="modal-body">
          <form class="">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="form-group">
               <label>Moneda</label>
               {!! Form::select('id_money', $money, null,['id'=>'id_money', 'class'=>' select2'] ) !!}
               <label>Precio</label>
             {!! Form::text('sale_price', old('sale_price'),['id'=>'sale_price', 'class'=>'' ,'required' => 'required'] ) !!}
             <button type="button" class="btn btn-primary btn_registerPrice" id="action">Enviar</button>
             </div>
          </form>
        <table id="price"  class="table table-bordered table-striped">
          <thead class="thead-dark">
              <tr>
                <th >Acción</th>
                <th >Precio</th>
                <th >Moneda</th>
                <th >Símbolo</th>
                <th >Visible tienda</th>

              </tr>
          </thead>
          <tbody>

        </tbody>
        <tfoot class="thead-dark">
          <tr>
              <th >Acción</th>
              <th >Precio</th>
              <th >Moneda</th>
              <th >Símbolo</th>
              <th >Visible tienda</th>
          </tr>
        </tfoot>
    </table>

      </div>

      <div class="modal-footer">

      </div>

    </div>
  </div>
</div><!-- fin Modal create-->
{{-- Inicio del modal selección de registro producto --}}
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Opción de registro tipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Que tipo de producto de desea registrar?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnRegisterAction" onclick="modalRegisterAction()">Acción</button>
        <button type="button" class="btn btn-primary" id="btnRegisterPPP" onclick="modalRegisterPPP()">PPP</button>
      </div>
    </div>
  </div>
</div>
{{-- Fin del modal selección de registro producto --}}

<!-- Modal  Registrar un producto-->
<div class="modal fade" id="modalRegisterProducto" tabindex="-1" role="dialog" aria-labelledby="modalRegisterProducto" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRegisterProducto">Registrar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form >
          Fromulario de Registro Producto

          <div class="form-group">
             <label>Código</label>
             {!! Form::text('cod_product', old('cod_product'),['id'=>'cod_product', 'class'=>'' ,'required' => 'required'] ) !!}
             <label>Nombre Producto</label>
           {!! Form::text('Nombre', old('Nombre'),['id'=>'name', 'class'=>'' ,'required' => 'required'] ) !!}
           </div>

           <div class="form-group">
              <label>Descripción</label>
              {!! Form::text('description', old('description'),['id'=>'description', 'class'=>'' ,'required' => 'required'] ) !!}
              <label>Peso en Acciones</label>
            {!! Form::text('cant', old('cant'),['id'=>'cant', 'class'=>'' ,'required' => 'required'] ) !!}
            </div>
          <div class="form-group">
             <label>Moneda</label>
             {!! Form::select('id_money_product', $money, null,['id'=>'id_money_product', 'class'=>' select2'] ) !!}
             <label>Precio</label>
           {!! Form::text('sale_price_product', old('sale_price_product'),['id'=>'sale_price_product', 'class'=>'' ,'required' => 'required'] ) !!}
           {{-- <button type="button" class="btn btn-primary btn_registerPrice" id="action">Enviar</button> --}}
           </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn_product_insert_action" id="action2">Enviar</button>
      </div>
    </div>
  </div>
</div>
{{-- Fin del modal de registro producto --}}


<div class="modal fade" id="modal-imagen-product">
  	<div class="modal-dialog">
      <div class="modal-content">
  			<div class="modal-body">
  				<div class="panel panel-info">
  					<div class="panel-heading">imagen</div>
  					<div class="panel-body">
              <img src="" border="1" alt="No tiene imagen." width="400" height="300" id="img-view-img">
  					</div>
  				</div>
  			</div>
  			<div class="modal-footer">
          <div id="update-img"><button type="button" class="btn btn-success pull-left"onclick="viewModalUp();">Cambiar imagen</button></div>
  				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
  			</div>
  		</div>
  	</div>
  </div>



  <div class="modal fade" id="modal-view-img">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="panel panel-info">
            <div class="panel-heading">imagen</div>
            <div class="panel-body">
              <form class="form-horizontal" action="#" id="dniForm" enctype="multipart/form-data">
              <div class="section">

                <div class="container">
                  <div class="form-group col-sm-6 col-md-4">
                    <label for="banner">Frontal:</label>
                  <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                    imagen <input type='file' class="form-control" id="doc-front" name="doc-front" accept="image/x-png,image/gif,image/jpeg">
                    </span>
                    </label>
                    <input class="form-control" id="doc_front_captura" readonly="readonly" name="doc_front_captura" type="text" value="">
                  </div>
                  </div>
                </div>

              </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <div><a type="button" class="btn btn-success pull-left" onclick="up();">Guardar</a></div>
            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
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
<script src="{{ asset('js/Product/index.js') }}"></script>
@endsection
