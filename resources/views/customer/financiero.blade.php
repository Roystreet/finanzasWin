<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Panel Financiero</title>
</head>
<link rel="stylesheet" href="{{ asset('js/Tree/TreeStyle/tree.css')}}">
<link rel="stylesheet" href="{{ asset('js/Tree/TreeStyle/colored.css')}}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<body>






<div class="row">
  <div class="col-md-11">
             <div class="panel with-nav-tabs panel-default">
                 <div class="panel-heading">
                         <ul class="nav nav-tabs">
                             <li class="active"><a href="#tab1primary" data-toggle="tab">Geonología</a></li>
                             <li><a href="#tab2primary" data-toggle="tab">Perfil</a></li>
                             <li><a href="#tab3primary" data-toggle="tab">Residuales</a></li>
                             {{-- <li class="dropdown">
                                 <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                                 <ul class="dropdown-menu" role="menu">
                                     <li><a href="#tab4primary" data-toggle="tab">Primary 4</a></li>
                                     <li><a href="#tab5primary" data-toggle="tab">Primary 5</a></li>
                                 </ul>
                             </li> --}}
                         </ul>
                 </div>
                 <div class="panel-body">
                     <div class="tab-content">
                         <div class="tab-pane fade in active" id="tab1primary">

                            <input type="text" name="user" value="" id="user">
                            <button type="button" class="btn btn-primary" onclick="cargarArbol();">Ver arbol</button>
                            cantidad de Personas:
                            <p id="countTree"></p>
                         </div>



                         <div class="tab-pane fade" id="tab2primary">
                           <div class="row">
                             <div class="col-md-12">


                               <div class="content">
                                 <div class="row">
                                   <div class="col-md-6">
                                     <label for="">Sponsor</label>
                                         <div class="name" id="sponsor">

                                         </div>
                                         <label for="">Parent</label>
                                             <div class="name" id="parent">

                                             </div>
                                         <label for="">Directos</label>
                                             <div class="name" id="directos">

                                             </div>
                                             <label for="">Red</label>
                                                 <div class="name" id="red">

                                                 </div>
                                   </div>
                                   {{--  --}}
                                   <div class="col-md-5">
                                     <div class="card" style="width: 18rem;">
                                       <img class="card-img-top" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR5OHx-TMWfARd_dFC_3PDEMmeMzwCIV_qbLCEasDInZsu6LEvlKg" alt="Card image cap">
                                       <div class="card-body">
                                       </div>
                                     </div>
                                   </div>
                                   {{--  --}}
                                 </div>

                                 <div class="row">
                                   <div class="col-md-12">
                                           <form>
                                               <meta name="csrf-token" content="{{ csrf_token() }}" />
                                             <div class="form-row">
                                               <div class="form-group col-md-6">
                                                 <label for="Nombre">Nombre</label>
                                                 <input type="text" class="form-control" id="first_name" placeholder="Nombre" name="first_name">
                                               </div>
                                               <div class="form-group col-md-6">
                                                 <label for="inputPassword4">Apellido</label>
                                                 <input type="text" class="form-control" id="last_name" placeholder="Apellido" name="last_name">
                                               </div>
                                             </div>

                                             <div class="form-row">
                                               <div class="form-group col-md-6">
                                                 <label for="usuario">Usuario</label>
                                                 <input type="tex" class="form-control" id="user" placeholder="user" name="user">
                                               </div>
                                               <div class="form-group col-md-6">
                                                 <label for="Password">Contraseña</label>
                                                 <input type="text" class="form-control" id="password" placeholder="Password" name="password">
                                               </div>
                                             </div>

                                             <div class="form-row">
                                               <div class="form-group col-md-6">
                                                 <label for="phone">Teléfono</label>
                                                 <input type="text" class="form-control" id="phone" placeholder="telefono" name="phone">
                                               </div>
                                               <div class="form-group col-md-6">
                                                 <label for="correo">Correo</label>
                                                 <input type="text" class="form-control" id="email" placeholder="correo" name="email">
                                               </div>
                                             </div>

                                             {{-- <div class="form-row">
                                               <div class="form-group col-md-6">
                                                 <label for="inputState">Pais</label>
                                                  <select id="inputState" class="form-control">
                                                    <option selected>Choose...</option>
                                                    <option>...</option>
                                                  </select>
                                               </div>
                                               <div class="form-group col-md-6">
                                                 <label for="inputState">Estado</label>
                                                    <select id="inputState" class="form-control">
                                                      <option selected>Choose...</option>
                                                      <option>...</option>
                                                    </select>
                                               </div>
                                             </div>

                                             <div class="form-row">
                                               <div class="form-group col-md-6">
                                                 <label for="inputState">Cuidad</label>
                                                      <select id="inputState" class="form-control">
                                                        <option selected>Choose...</option>
                                                        <option>...</option>
                                                      </select>
                                               </div>
                                               <div class="form-group col-md-6">
                                                 <label for="inputPassword4">Dirección</label>
                                                 <input type="text" class="form-control" id="inputPassword4" placeholder="Password">
                                               </div>
                                             </div> --}}

                                             <button type="submit" class="btn btn-primary">Actualizar</button>
                                           </form>
                                   </div>
                                 </div>

                               </div>
                             </div>
                           </div>

                         </div>
                         <div class="tab-pane fade" id="tab3primary">RESIDULAES</div>
                     </div>
                 </div>
             </div>
         </div>
</div>

{{--inicio modal --}}
<div class="modal fade docs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content ">
      <div class="bg-successe">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Obteniendo datos, por favor espere ...</h5>
                </div>
                <div class="modal-body">
                  {{--  --}}
                          @include('load.loading')
                {{--  --}}
                </div>
      </div>

    </div>
  </div>
</div>
{{--fin modal --}}

<script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
         <!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js"></script>

<script src="{{ asset('js/Tree/raphael.js')}}"></script>
<script src="{{ asset('js/Tree/treant.js')}}"></script>


<script src="{{ asset('js/Customer/financiero.js')}}"></script>
</body>
</html>
