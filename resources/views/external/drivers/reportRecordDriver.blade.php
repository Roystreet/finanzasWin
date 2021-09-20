


<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <style>
* {
  font-size: 12px;
  font-family: 'Times New Roman';
}
.header
{
width: 100%;
height: 100px;
}
.footer
{
width: 100%;
height: 50px;
 display: flex;
}
.hoja
{
width: 100%;
height: 932px;
}
.contenedor
{
    width: 100%;
    height: 100%;

}
.auxiliar
{
  width: 100%;
  height: 742px;
  padding: 15px;
  	margin: 0;
  	background-color: #fff;

}

.page-break {
page-break-after: always;
}

table {
   width: 100%;
   border: 1px solid #000;
}
th, td {
   width: 25%;
   text-align: left;
   vertical-align: top;
   border: 1px solid #000;
   border-collapse: collapse;
}


   </style>
</head>
<body>

          {{-- <div style="position: absolute; color: rgba(0, 0, 0, 0.3); z-index: -1; font-size: 75px; -webkit-transform: rotate(-65deg); -ms-transform: rotate(-65deg);      /* to support IE 9 */ transform: rotate(-65deg); top: 250px; left: -10px;letter-spacing: 0.3em"> WIN RIDESHARE</div> --}}
          <?php

                  $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4");
                  $base64 = 'data:image/png;base64,' . base64_encode($data);

//----------------------------------------------------------
                  $dataImg1 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Fusuario.png?alt=media&token=90912901-d17d-498f-83d8-6151cbc6ca27");
                  $img1 = 'data:image/png;base64,' . base64_encode($dataImg1);
//----------------------------------------------------------




              ?>
    <div class="hoja">
      <div class="header">
       <img src="{{$base64}}" alt="logo">
      </div>

      <div class=".contenedor">
        <div class="auxiliar">
          <center><h3 class="box-title">REPORTE RECORD</h3></center>
              <table class="table table-striped" border="0">
                <tbody>
                  <tr>
                    <td>Apellidos y Nombres</td>
                    <td>{{ $first_name.' '.$last_name }}</td>
                  </tr>
                  <tr>
                    <td>DNI</td>
                    <td>{{ $document }}</td>
                  </tr>
                  <tr>
                    <td>Nro Licencia</td>
                    <td>{{ $licence }}</td>
                  </tr>
                  <tr>
                    <td>Clase categoria</td>
                    <td>{{ $clasecate }}</td>
                  </tr>
                  <tr>
                    <td>Estado</td>
                    <td>{{ $estadolic }}</td>
                  </tr>
                  <tr>
                    <td>Fecha de Expedición</td>
                    <td>{{ $licfecemi }}</td>
                  </tr>
                  <tr>
                    <td>Fecha de Revalidación</td>
                    <td>{{ $licfecven }}</td>
                  </tr>
                  <tr>
                    <td>Puntos firmes:</td>
                    <td>{{ $point }}</td>
                  </tr>
                </tbody>
            </table>
            <br><br>
            <center><h4 class="box-title">DETALLE DE PAPELETAS IMPUESTAS</h4></center>
            <table class="table table-striped">
              <tbody>
                <tr>
                  <th>ENTIDAD</th>
                  <th>PAPELETA</th>
                  <th>FECHA PAPELETA</th>
                  <th>FALTA</th>
                  <th>ESTADO</th>
                  <th>PUNTOS SALDO</th>
                  <th>PUNTOS FIRME</th>
                </tr>
                <?php
                if ($records[0]->entidad == "" || $records[0]->entidad == null){
                  echo "<tr>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "<td></td>";
                  echo "</tr>";
                }else{
                  foreach($records as $record)
                  {
                  echo "<tr>";
                  echo "<td>".$record->entidad."</td>";
                  echo "<td>".$record->papeleta."</td>";
                  echo "<td>".date("Y-m-d", strtotime($record->dinfranccion))."</td>";
                  echo "<td>".$record->cod_falta."</td>";
                  echo "<td>".$record->estado."</td>";
                  echo "<td>".$record->points_saldo."</td>";
                  echo "<td>".$record->points_firmes."</td>";
                  echo "</tr>";
                  }
                }
                ?>
              </tbody>
          </table>
        </div>
      </div>


      <div class="footer">
        <div class="cc" style=" float: left;">
            <h5>
                <p><b>Fecha de Emisión</b><?php  date_default_timezone_set('America/Lima');?>  {{  " " . date("d") . "/" . date("m") . "/" . date("Y") }}</p>
                <p><b>Hora de Emisión</b>  {{ " " . date("H:i:s") }}</p>
                - Este documento no autoriza a conducir vehículos</h5>
        </div>
      </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
