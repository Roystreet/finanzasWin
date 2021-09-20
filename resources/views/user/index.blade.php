@extends('layouts.app')
@section('title',  $title)
@section('css')
  <!-- Agregando Datos- -->
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')                              }}">


@endsection

@section('content')
  <section class="content">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Listado de Usuarios</h3>
      </div>
      <div class="box-body">
        <div class="hero-callout">
          <table id="users" name="users"  class="table table-bordered table-striped">
            <thead>
              <tr>
    					 <th align="center" width="auto" >Accion</th>
    					 <th align="center" width="auto" >User Login</th>
               <th align="center" width="auto" >Nombres</th>
               <th align="center" width="auto" >DNI</th>
               <th align="center" width="auto" >Telefono</th>
               <th align="center" width="auto" >Correo</th>
    					 <th align="center" width="auto" >Pais</th>
    					 <th align="center" width="auto" >Usuario</th>
               <th align="center" width="auto" >Estatus</th>
             </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
             <tr>
    					 <th align="center" width="auto" >Accion</th>
    					 <th align="center" width="auto" >User Login</th>
               <th align="center" width="auto" >Nombres</th>
               <th align="center" width="auto" >DNI</th>
               <th align="center" width="auto" >Telefono</th>
               <th align="center" width="auto" >Correo</th>
    					 <th align="center" width="auto" >Pais</th>
    					 <th align="center" width="auto" >Usuario</th>
               <th align="center" width="auto" >Estatus</th>
             </tr>
            </tfoot>
          </table>
        </div>
      </div>

    </div>
    <div class="modal fade" id="modal-rol">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header"> Roles Usuario  </div>

          <div class="modal-body">
            <form method="POST"  id="updateRol">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {!! Form::hidden('id_userR', null,['id'=>'id_userR', 'class'=>'form-control'] ) !!}
            {{-- Inicio: Rol  --}}
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-cogs"></i>
                  </div>
                  {!! Form::select('id_rolU', $roles, null, ['id'=>'id_rolU', 'name'=>'id_rolU[]', 'class'=>'form-control select2', 'multiple'=>'multiple', 'style'=>'width: 100%'] ) !!}
                </div>
              </div>
            {{-- Fin:  Rol --}}
            <div class="box-body no-padding">
              <table id="rol" name="rol"  width="100%" align="left" class="table">
                <thead>
                  <tr>
                    <th align="center" width="auto">Menu</th>
                    <th align="center" with="100px">Desglose</th>
                    <th align="center" with="100px">Rol</th>
                  </tr>
                </thead>
                <tbody id="rol_details"></tbody>
              </table>
            </div>


          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-SavedRol">Guardar</button>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-permisos">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header"> Permisos Usuario </div>

          <div class="modal-body">
            <form method="POST"  id="updatePermiso">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {!! Form::hidden('id_userP', null,['id'=>'id_userP', 'class'=>'form-control'] ) !!}
            {!! Form::hidden('id_roluserp', null,['id'=>'id_roluserp', 'class'=>'form-control'] ) !!}
            {{-- Inicio: Permisos  --}}
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-unlock-alt"></i>
                  </div>
                    {!! Form::select('id_permisos', $permisos, null, ['id'=>'id_permisos', 'name'=>'id_permisos[]', 'class'=>'form-control select2', 'multiple'=>'multiple', 'style'=>'width: 100%'] ) !!}
                </div>
              </div>
            {{-- Fin:  Permisos --}}
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-SavedPermisos">Guardar</button>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-show">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {!! Form::hidden('id_user', null,['id'=>'id_user', 'class'=>'form-control'] ) !!}
              <table id="datos"  name="datos"   width="100%" align="left">
                <tr>
                  <td colspan="2" height="20px"><pre><i class="fa fa-user"></i> - <b>Datos</b></pre></td>
                </tr>
                <tr>
                  <th width="200px">Nombre Completo</th>
                  <td id="fullName"></td>
                </tr>
                <tr>
                  <th>Cedula de Identindad/DNI:</th>
                  <td id="document"></td>
                </tr>
                <tr>
                  <th>Fecha de Nacimiento:</th>
                  <td id ="birthdate"></td>
                </tr>
                <tr>
                  <th>Telefono:</th>
                  <td id="phone"></td>
                </tr>
                <tr>
                  <th>Pais:</th>
                  <td id="id_country"></td>
                </tr>
                <tr>
                  <th>Dirección:</th>
                  <td id="address"></td>
                </tr>
                <tr>
                  <th>Usuario:</th>
                  <td id="username"></td>
                </tr>
                <tr>
                  <th>Sexo:</th>
                  <td id="gender"></td>
                </tr>
                <tr>
                  <th>permisos:</th>
                  <td></td>
                </tr>
              </table>
              <div id="id_rol"></div>
          </div><br>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-passw">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header"> Cambio de Contraseña </div>
          <div class="modal-body">
            <div width="80%">
              <form method="POST"  id="updatePassw" name="updatePassw">
              <meta name="csrf-token" content="{{ csrf_token() }}">
              {!! Form::hidden('id', null,['id'=>'id', 'class'=>'form-control'] ) !!}
              <label for="Datos">Contraseña:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-key"></i></div>
                      <input type="password" id="password" name="password" class="form-control required"  placeholder="***********">
                        <div class="input-group-addon"><code>*</code></div>
                    </div><div><span class="help-block" id="error"></span></div>
                </div>
              <label for="Datos">Observaciones:</label>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-pencil-square-o"></i></div>
                      {!! Form::textarea('note', null,['id'=>'note', 'class'=>'form-control required', 'value'=> old('note'), 'rows'=>'2'] ) !!}
                    </div><div><span class="help-block" id="error"></span></div>
                  </div>

            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <input  type="button" class="btn btn-primary"  id ="sendPassw" value="Guardar" />
          </div>
        </form>
        </div>
      </div>
    </div>

  </section>
  <!-- /.content -->

@endsection






@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/User/index.js')}} "></script>

@endsection
