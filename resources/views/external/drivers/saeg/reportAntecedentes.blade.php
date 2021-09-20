


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
height: 332px;
}
.contenedor
{
    width: 100%;
    height: 100%;

}
.auxiliar
{
  width: 100%;
  height: 452px;
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

// //----------------------------------------------------------
//                   $dataImg1 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Fusuario.png?alt=media&token=90912901-d17d-498f-83d8-6151cbc6ca27");
//                   $img1 = 'data:image/png;base64,' . base64_encode($dataImg1);
// //----------------------------------------------------------




              ?>
    <div class="hoja">
      <div class="header">
       <img src="{{$base64}}" alt="logo">
      </div>

      <div class=".contenedor">
        <div class="auxiliar">
          <center><h3 class="box-title">Datos personales</h3></center>
              {{-- <table class="table table-sm" border="0">
                <tbody>
                  <tr>
                    <td>Apellidos y Nombres</td>
                    <td>{{ $first_name.' '.$last_name }}</td>
                  </tr>
                  <tr>
                    <td>DNI</td>
                    <td>{{ $dni }}</td>
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
                </tbody>
            </table> --}}
            <br><br>
            <center><h4 class="box-title">DETALLE DE ANTECEDENTES</h4></center>

                <?php
                foreach($u as $antede)
                {
                echo "<p> Descripción : ".$antede->description."</p> </br>";
                echo "<p> Fecha de valuación : ".$antede->updated_at."</p> </br>";
                $uu = $antede->getUserOffice()->first();
                echo "<p> Nombres y Apellidos : ".$uu->first_name.", ".$uu->last_name."</p> </br> ";

                     echo '<div class="table table-striped w-auto">'.
                       '<table id="driver"  class="table" >'.
                           '<thead>'.
                             '<tr>'.
                               '<th>ANTECEDENTE</th>'.
                               '<th>REFERENCIA</th>'.
                               '<th>DELITO</th>'.
                               '<th>DEPENDENCIA</th>'.
                               '<th>OFICIO</th>'.
                               '<th>FECHA-REFERENCIA</th>'.
                               '<th>SITUACION</th>'.
                               '<th>PARTE</th>'.
                               '<th>OBSERVACION</th>'.
                             '</tr>'.
                           '</thead>'.
                           '<tbody>';
                           foreach ($antede->getAntedenteDetails()->get() as $value)
                           {
                             echo "<tr>";
                             echo "<td>".$value->getTypeAntecedente()->first()->description."</td>";
                             echo "<td>".$value->getTypeReference()->first()->description."</td>";
                             echo "<td>".$value->crime."</td>";
                             echo "<td>".$value->dependence."</td>";
                             echo "<td>".$value->number_office."</td>";
                             echo "<td>".$value->date_register."</td>";
                             echo "<td>".$value->situation."</td>";
                             echo "<td>".$value->part."</td>";
                             echo "<td>".$value->observation."</td>";
                             echo "</tr>";
                             }
                           echo '</tbody>'.
                       '</table>'.
                    '</div>';

                }
                ?>
              </tbody>

        </div>
      </div>


      <div class="footer">
        <div class="cc" style=" float: left;">
            <h5>
                <p><b>Fecha de Emisión</b><?php  date_default_timezone_set('America/Lima');?>  {{  " " . date("d") . "/" . date("m") . "/" . date("Y") }}</p>
                <p><b>Hora de Emisión</b>  {{ " " . date("H:i:s") }}</p>
                - Este documento no tiene validades policial.</h5>
        </div>
      </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
