<!DOCTYPE html>
<html lang="es-ES" >
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
</head>
<body style="background-color: black; color: white;">
  <center><form id="form-registro">
   <meta name="csrf-token" content="{{ csrf_token() }}">
      <table>
        <tr>
          <th width="200px">USUARIO QUE INVITA</th>
          <td><input type="text" class="form-control" name="usuario_inv" id="usuario_inv"></td>
        </tr>
        <tr>
          <th width="200px">NOMBRE DEL USUARIO QUE INVITA</th>
          <td><input type="text" class="form-control" name="nom_usuario_inv" id="nom_usuario_inv" disabled="disabled"></td>
        </tr>
        <tr>
          <th width="200px">SELECCIONAR TIPO DE DOCUMENTO</th>
          <td>
            <select name="tipodoc" id="tipodoc" class="form-control">
              <option value="0">SELECCIONAR</option>
              <option>DNI</option>
              <option>CARNET DE EXTRANJERIA</option>
              <option>PASAPORTE</option>
            </select>
          </td>
        </tr>
        <tr>
          <th width="400px">DOCUMENTO DE IDENTIDAD</th>
          <td><input type="text" class="form-control" name="documento" id="documento"></td>
        </tr>
        <tr>
          <th width="200px">NOMBRE</th>
          <td><input type="text" name="nombre" id="nombre"></td>
        </tr>
        <tr>
          <th width="200px">APELLIDOS</th>
          <td><input type="text" class="form-control" name="apellidos" id="apellidos"></td>
        </tr>
        <tr>
          <th width="200px">CORREO ELECTRONICO</th>
          <td><input type="text" class="form-control" name="correo" id="correo"></td>
        </tr>
        <tr>
          <th width="200px">PAIS</th>
          <td><input type="text" class="form-control" name="pais" id="pais"></td>
        </tr>
        <tr>
          <th width="200px">REGION/DEPARTAMENTO</th>
          <td><input type="text" class="form-control" name="departamento" id="departamento"></td>
        </tr>
        <tr>
          <th width="200px">PROVINCIA</th>
          <td><input type="text" class="form-control" name="provincia" id="provincia"></td>
        </tr>
        <tr>
          <th width="200px">DIRECCION</th>
          <td><textarea name="direccion" class="form-control" id="direccion"></textarea></td>
        </tr>
        <tr>
          <th width="200px">TELEFONO</th>
          <td><input type="text" class="form-control" name="telefono" id="telefono"></td>
        </tr>
        <tr>
          <input type="hidden" name="id_customer" id="id_customer" value="">
          <input type="hidden" name="metod_customer" id="metod_customer" value="">
        </tr>
        <tr>
          <th width="200px">NOMBRE DE USUARIO</th>
          <td><input type="text" class="form-control" name="usuario" id="usuario"></td>
        </tr>
        <tr>
          <th width="200px">CONTRASEÑA</th>
          <td><input type="password" class="form-control" name="clave" id="clave"></td>
        </tr>
        <tr>
          <input type="hidden" name="sponsorid" id="sponsorid" value="">
          <input type="hidden" name="metod_sponsor" id="metod_sponsor" value="">
        </tr>
        <tr>
          <th><center><button id="register-red" class="register-red" type="button">REGISTRAR</button></center></th>
        </tr>
      </table>
    </form></center>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/Red/red.js')}} "></script>
</body>
</html>
