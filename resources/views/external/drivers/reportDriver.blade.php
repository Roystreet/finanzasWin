


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

//----------------------------------------------------------
                  $imgNull = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2FImagen_no_disponible.svg.png?alt=media&token=c206a85d-c160-413a-ad10-7aacd9ed4896");
                  if($lic_frontal!=null)
                  {
                    $imgLic_frontal = file_get_contents($lic_frontal);
                  }
                  else $imgLic_frontal = $imgNull;

                    $imgLic_frontal64 = 'data:image/png;base64,' . base64_encode($imgLic_frontal);
//----------------------------------------------------------

                    if($lic_back!=null)
                    {
                      $imglic_back = file_get_contents($lic_back);
                    }
                    else $imglic_back = $imgNull;


                      $imglic_back64 = 'data:image/png;base64,' . base64_encode($imglic_back);
//----------------------------------------------------------
                  if($tar_veh_frontal!=null)
                  $imgtar_veh_frontal = file_get_contents($tar_veh_frontal);
                  else $imgtar_veh_frontal = $imgNull;

                    $imgtar_veh_frontal64 = 'data:image/png;base64,' . base64_encode($imgtar_veh_frontal);
                    //----------------------------------------------------------
                            if($tar_veh_back!=null)
                                      $imgtar_veh_back = file_get_contents($tar_veh_back);
                                      else $imgtar_veh_back = $imgNull;

                                        $imgtar_veh_back64 = 'data:image/png;base64,' . base64_encode($imgtar_veh_back);
//----------------------------------------------------------
                    if($car_externa2!=null)
                    $imgcar_externa2 = file_get_contents($car_externa2);
                    else $imgcar_externa2 = $imgNull;

                      $imgcar_externa264 = 'data:image/png;base64,' . base64_encode($imgcar_externa2);
  //----------------------------------------------------------
                      if($car_externa!=null)
                      $imgcar_externa = file_get_contents($car_externa);
                      else $imgcar_externa = $imgNull;

                        $imgcar_externa64 = 'data:image/png;base64,' . base64_encode($imgcar_externa);

//----------------------------------------------------------
                      if($car_externa3!=null)
                      $imgcar_externa3 = file_get_contents($car_externa3);
                      else $imgcar_externa3 = $imgNull;

                      $imgcar_externa364 = 'data:image/png;base64,' . base64_encode($imgcar_externa3);

//----------------------------------------------------------
                                            if($car_externa3!=null)
                                            $imgcar_externa3 = file_get_contents($car_externa3);
                                            else $imgcar_externa3 = $imgNull;

                                            $imgcar_externa364 = 'data:image/png;base64,' . base64_encode($imgcar_externa3);
  //----------------------------------------------------------
                        if($car_interna!=null)
                        $imgcar_interna = file_get_contents($car_interna);
                        else $imgcar_interna = $imgNull;

                        $imgcar_interna64 = 'data:image/png;base64,' . base64_encode($imgcar_interna);
//----------------------------------------------------------
                        if($car_interna2!=null)
                        $imgcar_interna2 = file_get_contents($car_interna2);
                        else $imgcar_interna2 = $imgNull;

                        $imgimgcar_interna2 = 'data:image/png;base64,' . base64_encode($imgcar_interna2);



//----------------------------------------------------------
                        if($soat_back!=null)
                        $imgsoat_back = file_get_contents($soat_back);
                        else $imgsoat_back = $imgNull;

                        $imgsoat_back64 = 'data:image/png;base64,' . base64_encode($imgsoat_back);

//----------------------------------------------------------
                        if($soat_frontal!=null)
                        $imgsoat_frontal = file_get_contents($soat_frontal);
                        else $imgsoat_frontal = $imgNull;

                        $imgsoat_frontal64 = 'data:image/png;base64,' . base64_encode($imgsoat_frontal);

//----------------------------------------------------------
                        if($doc_back!=null)
                        $imgdni_back = file_get_contents($doc_back);
                        else $imgdni_back = $imgNull;

                        $imgdni_back64 = 'data:image/png;base64,' . base64_encode($imgdni_back);

//----------------------------------------------------------
                        if($doc_front!=null)
                        $imgdni_frontal = file_get_contents($doc_front);
                        else $imgdni_frontal = $imgNull;

                        $imgdni_frontal64 = 'data:image/png;base64,' . base64_encode($imgdni_frontal);

//----------------------------------------------------------
                        if($doc_front!=null)
                        $imgdni_frontal = file_get_contents($doc_front);
                        else $imgdni_frontal = $imgNull;

                        $imgdni_frontal64 = 'data:image/png;base64,' . base64_encode($imgdni_frontal);
//----------------------------------------------------------
                        if($photo_perfil!=null)
                        $imgphoto_perfil = file_get_contents($photo_perfil);
                        else $imgphoto_perfil = $imgNull;

                        $imgphoto_perfil64 = 'data:image/png;base64,' . base64_encode($imgphoto_perfil);
                        //----------------------------------------------------------
                                                                        if($revision_tecnica!=null)
                                                                        $imgrevision_tecnica = file_get_contents($revision_tecnica);
                                                                        else $imgrevision_tecnica = $imgNull;

                                                                        $imgrevision_tecnica64 = 'data:image/png;base64,' . base64_encode($imgrevision_tecnica);
//----------------------------------------------------------
                                                if($recibo_luz!=null)
                                                $imgprecibo_luz = file_get_contents($recibo_luz);
                                                else $imgprecibo_luz = $imgNull;

                                                $imgprecibo_luz64 = 'data:image/png;base64,' . base64_encode($imgprecibo_luz);


              ?>



    <div class="hoja">

      <div class="header">
<img src="{{$base64}}" alt="logo">
      </div>

      <div class=".contenedor">
        <div class="auxiliar">

            <h3 class="box-title">Información Personal</h3>
                <img src="{{ $imgphoto_perfil64}}" width="150" height="150" style="margin:5px;">
                <table class="table table-sm table-dark">
            <thead>
              {{-- <tr>
                <th scope="col"></th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Handle</th>
              </tr> --}}
            </thead>
            <tbody>
              <tr>
                <th scope="row">DNI</th>
                <td><span id="document">{{document}}</span></td>
                {{-- <td>Otto</td> --}}
              </tr>
              <tr>
                <th scope="row">NOMBRES</th>
                <td>{{$first_name}}</td>
                {{-- <td>Thornton</td>
                <td>@fat</td> --}}
              </tr>
              <tr>
                <th scope="row">APELLIDOS</th>
                <td>{{$last_name}}</td>
                {{-- <td>Thornton</td>
                <td>@fat</td> --}}
              </tr>
            </tbody>
          </table>

          <h4 class="box-title">Fotos</h4>

              <img src="{{ $imgdni_frontal64}}" width="200" height="200" style="margin:15px;">
              <img src="{{ $imgdni_back64}}" width="200" height="200" style="margin:15px;">

          <h3 class="box-title">Información Conductor  </h3>
              <table class="table table-sm table-dark">
          <thead>
            {{-- <tr>
              <th scope="col"></th>
              <th scope="col">Nombres</th>
              <th scope="col">Apellidos</th>
              <th scope="col">Handle</th>
            </tr> --}}
          </thead>
          <tbody>
            <tr>
              <th scope="row">NÚMERO DE LICENCIA</th>
              <td>{{$licencia}}</td>
              {{-- <td>Otto</td> --}}
            </tr>
            <tr>
              <th scope="row">F. EMICIÓN</th>
              <td>{{$licfecemi}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            <tr>
              <th scope="row">F. FIN</th>
              <td>{{$licfecven}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            <tr>
              <th scope="row">PUNTOS</th>
              <td>{{$point}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            <tr>
              <th scope="row">CATEGORIA</th>
              <td>{{$classcategoria}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>

            <tr>
              <th scope="row">ESTADO</th>
              <td>-</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
          </tbody>
        </table>



        </div>
      </div>

      <div class="footer">
        <div class="cc" style=" float: right;">
            <h4>Página 1</h4>
        </div>
      </div>
    </div>
{{-- ------------------------------------salto de hoja --}}
    <div class="page-break"></div>

    <div class="hoja">
      <div class="header">
    <img src="{{$base64}}" alt="logo">
      </div>

      <div class=".contenedor">
        <div class="auxiliar">
          <h4 class="box-title">Fotos</h4>
              <img src="{{ $imgLic_frontal64}}" width="200" height="200" style="margin:15px;">
              <img src="{{ $imglic_back64}}" width="200" height="200" style="margin:15px;">


          <h3 class="box-title">Información del Vehículo</h3>
              <table class="table table-sm table-dark">
          <thead>
            {{-- <tr>
              <th scope="col"></th>
              <th scope="col">Nombres</th>
              <th scope="col">Apellidos</th>
              <th scope="col">Handle</th>
            </tr> --}}
          </thead>
          <tbody>
            <tr>
              <th scope="row">PLACA/MATRÍCULA</th>
              <td>{{$placa}}</td>
              {{-- <td>Otto</td> --}}
            </tr>
            <tr>
              <th scope="row">COLOR</th>
              <td>{{$color}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            <tr>
              <th scope="row">MARCA</th>
              <td>{{$marca}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            <tr>
              <th scope="row">AÑO</th>
              <td>{{$color}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>

          </tbody>
          </table>

          <h4 class="box-title">Fotos</h4>
              <img src="{{ $imgcar_externa264}}" width="200" height="200" style="margin:15px;">
              <img src="{{ $imgcar_externa64}}" width="200" height="200" style="margin:15px;">
              <img src="{{ $imgcar_externa364}}" width="200" height="200" style="margin:15px;">
        </div>
      </div>

      <div class="footer">
        <div class="cc" style=" float: right;">
            <h4>Página 2</h4>
        </div>
      </div>
    </div>

    {{-- ------------------------------------salto de hoja --}}
        <div class="page-break"></div>

        <div class="hoja">
          <div class="header">
        <img src="{{$base64}}" alt="logo">
          </div>

          <div class=".contenedor">
            <div class="auxiliar">
              <img src="{{ $imgcar_interna64}}" width="200" height="200" style="margin:15px;">
              <img src="{{ $imgimgcar_interna2}}" width="200" height="200" style="margin:15px;">
              <img src="{{ $imgtar_veh_back64}}" width="200" height="200" style="margin:15px;">

              <img src="{{ $imgtar_veh_frontal64}}" width="200" height="200" style="margin:15px;">



            <h3 class="box-title">Información Seguro</h3>
              <table class="table table-sm table-dark">
            <thead>
            {{-- <tr>
              <th scope="col"></th>
              <th scope="col">Nombres</th>
              <th scope="col">Apellidos</th>
              <th scope="col">Handle</th>
            </tr> --}}
            </thead>
            <tbody>
            <tr>
              <th scope="row">EMPRESA</th>
              <td>{{$enterprisesoat}}</td>
              {{-- <td>Otto</td> --}}
            </tr>
            <tr>
              <th scope="row">F. EMICIÓN</th>
              <td>{{$soatfecemi}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            <tr>
              <th scope="row">F. FIN</th>
              <td>{{$soatfecven}}</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            <tr>
              <th scope="row">ESTADO</th>
              <td>vigente</td>
              {{-- <td>Thornton</td>
              <td>@fat</td> --}}
            </tr>
            </tbody>
            </table>

            <h4 class="box-title">Fotos</h4>
            <img src="{{ $imgsoat_frontal64}}" width="200" height="200" style="margin:15px;">
            <img src="{{ $imgsoat_back64}}" width="200" height="200" style="margin:15px;">


            </div>
          </div>

          <div class="footer">
            <div class="cc" style=" float: right;">
                <h4>Página 3</h4>
            </div>
          </div>
        </div>


        {{-- ------------------------------------salto de hoja --}}
            <div class="page-break"></div>

            <div class="hoja">
              <div class="header">
            <img src="{{$base64}}" alt="logo">
              </div>

              <div class=".contenedor">
                <div class="auxiliar">

                  <h4 class="box-title">Revisión técnica</h4>
                  <table class="table table-sm table-dark">
                <thead>
                {{-- <tr>
                  <th scope="col"></th>
                  <th scope="col">Nombres</th>
                  <th scope="col">Apellidos</th>
                  <th scope="col">Handle</th>
                </tr> --}}
                </thead>
                <tbody>
                <tr>
                  <th scope="row">F. EMICIÓN</th>
                  <td>{{$revfecemi}}</td>
                  {{-- <td>Thornton</td>
                  <td>@fat</td> --}}
                </tr>
                <tr>
                  <th scope="row">F. FIN</th>
                  <td>{{$revfecven}}</td>
                  {{-- <td>Thornton</td>
                  <td>@fat</td> --}}
                </tr>
                </tbody>
                </table>
                <h4 class="box-title">Foto</h4>
                <img src="{{ $imgrevision_tecnica64}}" width="300" height="300" style="margin:15px;">


                <h4 class="box-title">Recibo de luz</h4>
                <img src="{{ $imgprecibo_luz64}}" width="200" height="200" style="margin:15px;">





                </div>
              </div>

              <div class="footer">
                <div class="cc" style=" float: right;">
                    <h4>Página 4</h4>
                </div>
              </div>
            </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>
</html>
