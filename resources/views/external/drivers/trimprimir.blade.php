


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
            <table class="table table-sm">
                <tbody>
                  <tr>
                    <td colspan="3">FECHA: {{$fecha}}</span></td>
                  </tr>
                  <tr>
                    <td colspan="3" >NOMBRE COMPLETO: <b>{{$first_name}} {{$last_name}}</b></td>
                  </tr>
                  <tr>
                    <td colspan="3">DNI: {{$document}}</td>
                  </tr>
                  <tr>
                    <td><b>MARCA:</b> {{$marca}}</td>
                    <td ><b>MODELO:</b> {{$modelo}}</td>
                    <td ><b>PLACA:</b> {{$placa}}</td>
                  </tr>
                  <tr>
                    <td><b>AÑO:</b> {{$year}}</td>
                    <td><b>COLOR:</b> {{$color}}</td>
                    <td><b>KILOMETRAJE:</b></td>
                  </tr>
                  <tr>
                    <td><b>VIN#:</b> {{$nro_vin}}</td>
                    <td><b>MOTOR#:</b> {{$nro_motor}}</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>DESCRIPCION</td>
                    <td colspan="2">VALOR</td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>LUCES:</b></td>
                  </tr>
                  <tr>
                    <td><b>Luz Baja:</b></td>
                    <td colspan="2"><?php  if ($luz_baja == 1) : echo "SI";  elseif ($luz_baja == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz Alta:</b></td>
                    <td colspan="2"><?php  if ($luz_alta == 1) : echo "SI";  elseif ($luz_alta == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz de freno:</b></td>
                    <td colspan="2"><?php  if ($luz_freno == 1) : echo "SI";  elseif ($luz_freno == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz de emergencia:</b></td>
                    <td colspan="2"><?php  if ($luz_emergencia == 1) : echo "SI";  elseif ($luz_emergencia == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz de retroceso:</b></td>
                    <td colspan="2"><?php  if ($luz_retroceso == 1) : echo "SI";  elseif ($luz_retroceso == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz intermitente:</b></td>
                    <td colspan="2"><?php  if ($luz_intermitente == 1) : echo "SI";  elseif ($luz_intermitente == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz antiniebla:</b></td>
                    <td colspan="2"><?php  if ($luz_antiniebla == 1) : echo "SI";  elseif ($luz_antiniebla == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz de placa:</b></td>
                    <td colspan="2"><?php  if ($luz_placa == 1) : echo "SI";  elseif ($luz_placa == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>ARRANQUE DE MOTOR:</b></td>
                  </tr>
                  <tr>
                    <td><b>Arrancador:</b></td>
                    <td colspan="2"><?php  if ($arrancador == 1) : echo "SI";  elseif ($arrancador == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Alternador:</b></td>
                    <td colspan="2"><?php  if ($alternador == 1) : echo "SI";  elseif ($alternador == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Bujias:</b></td>
                    <td colspan="2"><?php  if ($bujias == 1) : echo "SI";  elseif ($bujias == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Cable de Bujias:</b></td>
                    <td colspan="2"><?php  if ($cable_bujias == 1) : echo "SI";  elseif ($cable_bujias == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Bobinas:</b></td>
                    <td colspan="2"><?php  if ($bobinas == 1) : echo "SI";  elseif ($bobinas == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Inyectores:</b></td>
                    <td colspan="2"><?php  if ($inyectores == 1) : echo "SI";  elseif ($inyectores == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Bateria:</b></td>
                    <td colspan="2"><?php  if ($bateria == 1) : echo "SI";  elseif ($bateria == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>FRENOS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Pastillas delanteras:</b></td>
                    <td colspan="2"><?php  if ($past_del == 1) : echo "SI";  elseif ($past_del == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Pastillas Traseras:</b></td>
                    <td colspan="2"><?php  if ($past_tras == 1) : echo "SI";  elseif ($past_tras == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Discos delanteros:</b></td>
                    <td colspan="2"><?php  if ($disc_del == 1) : echo "SI";  elseif ($disc_del == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Discos traseros:</b></td>
                    <td colspan="2"><?php  if ($disc_tras == 1) : echo "SI";  elseif ($disc_tras == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Tambores traseros:</b></td>
                    <td colspan="2"><?php  if ($tamb_tras == 1) : echo "SI";  elseif ($tamb_tras == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Zapatas traseras:</b></td>
                    <td colspan="2"><?php  if ($zapatas_tras == 1) : echo "SI";  elseif ($zapatas_tras == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Freno de emergencia:</b></td>
                    <td colspan="2"><?php  if ($freno_emerg == 1) : echo "SI";  elseif ($freno_emerg == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Liquido de freno:</b></td>
                    <td colspan="2"><?php  if ($liq_freno == 1) : echo "SI";  elseif ($liq_freno == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>NEUMATICOS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Estado de neumaticos:</b></td>
                    <td colspan="2"><?php  if ($est_neumaticos == 1) : echo "SI";  elseif ($est_neumaticos == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Revision de tuercas:</b></td>
                    <td colspan="2"><?php  if ($rev_tuercas == 1) : echo "SI";  elseif ($rev_tuercas == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Presion de neumaticos:</b></td>
                    <td colspan="2"><?php  if ($pres_neumat == 1) : echo "SI";  elseif ($pres_neumat == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>LLanta de repuesto:</b></td>
                    <td colspan="2"><?php  if ($llanta_resp == 1) : echo "SI";  elseif ($llanta_resp == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Aros:</b></td>
                    <td colspan="2"><?php  if ($aros == 1) : echo "SI";  elseif ($aros == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>CARROCERIA Y CHASIS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Parachoque Delantero:</b></td>
                    <td colspan="2"><?php  if ($paracho_del == 1) : echo "SI";  elseif ($paracho_del == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Parachoque Posterior:</b></td>
                    <td colspan="2"><?php  if ($paracho_post == 1) : echo "SI";  elseif ($paracho_post == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Puerta Del. Izquierda:</b></td>
                    <td colspan="2"><?php  if ($puert_del_izq == 1) : echo "SI";  elseif ($puert_del_izq == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Puerta Del. Derecha:</b></td>
                    <td colspan="2"><?php  if ($puert_del_der == 1) : echo "SI";  elseif ($puert_del_der == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Puerta Post. Izquierda:</b></td>
                    <td colspan="2"><?php  if ($puert_post_izq == 1) : echo "SI";  elseif ($puert_post_izq == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Puerta Post. Derecha:</b></td>
                    <td colspan="2"><?php  if ($puert_post_der == 1) : echo "SI";  elseif ($puert_post_der == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Guardafango Izquierdo:</b></td>
                    <td colspan="2"><?php  if ($guardafango_izq == 1) : echo "SI";  elseif ($guardafango_izq == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Guardafango Derecho:</b></td>
                    <td colspan="2"><?php  if ($guardafango_der == 1) : echo "SI";  elseif ($guardafango_der == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Capota:</b></td>
                    <td colspan="2"><?php  if ($capota == 1) : echo "SI";  elseif ($capota == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Vidrio Del. Izquierdo:</b></td>
                    <td colspan="2"><?php  if ($vid_del_izq == 1) : echo "SI";  elseif ($vid_del_izq == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Vidrio Del. Derecho:</b></td>
                    <td colspan="2"><?php  if ($vid_del_der == 1) : echo "SI";  elseif ($vid_del_der == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Vidrio Post. Izquierdo:</b></td>
                    <td colspan="2"><?php  if ($vid_post_izq == 1) : echo "SI";  elseif ($vid_post_izq == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Vidrio Post. Derecho:</b></td>
                    <td colspan="2"><?php  if ($vid_post_der == 1) : echo "SI";  elseif ($vid_post_der == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Parabrisa Delantera:</b></td>
                    <td colspan="2"><?php  if ($parab_del == 1) : echo "SI";  elseif ($parab_del == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Parabrisa Trasera:</b></td>
                    <td colspan="2"><?php  if ($parab_tras == 1) : echo "SI";  elseif ($parab_tras == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Maletero:</b></td>
                    <td colspan="2"><?php  if ($maletero == 1) : echo "SI";  elseif ($maletero == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Techo:</b></td>
                    <td colspan="2"><?php  if ($techo == 1) : echo "SI";  elseif ($techo == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>MOTOR:</b></td>
                  </tr>
                  <tr>
                    <td><b>Fuga de aceite:</b></td>
                    <td colspan="2"><?php  if ($fuga_aceite == 1) : echo "SI";  elseif ($fuga_aceite == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Fuga de refrigerante:</b></td>
                    <td colspan="2"><?php  if ($fuga_refrig == 1) : echo "SI";  elseif ($fuga_refrig == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Fuga de combustible:</b></td>
                    <td colspan="2"><?php  if ($fuga_combust == 1) : echo "SI";  elseif ($fuga_combust == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Filtro de aceite:</b></td>
                    <td colspan="2"><?php  if ($filt_aceite == 1) : echo "SI";  elseif ($filt_aceite == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Filtro de aire:</b></td>
                    <td colspan="2"><?php  if ($filt_aire == 1) : echo "SI";  elseif ($filt_aire == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Filtro de combustible:</b></td>
                    <td colspan="2"><?php  if ($filt_combus == 1) : echo "SI";  elseif ($filt_combus == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Filtro de cabina:</b></td>
                    <td colspan="2"><?php  if ($filt_cabina == 1) : echo "SI";  elseif ($filt_cabina == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Bomba de direccion:</b></td>
                    <td colspan="2"><?php  if ($bomba_direc == 1) : echo "SI";  elseif ($bomba_direc == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>SUSPENSION:</b></td>
                  </tr>
                  <tr>
                    <td><b>Amortiguadores Delanteros:</b></td>
                    <td colspan="2"><?php  if ($amorti_del == 1) : echo "SI";  elseif ($amorti_del == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Amortiguadores Posteriores:</b></td>
                    <td colspan="2"><?php  if ($amorti_post == 1) : echo "SI";  elseif ($amorti_post == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Palieres:</b></td>
                    <td colspan="2"><?php  if ($palieres == 1) : echo "SI";  elseif ($palieres == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Rotulas:</b></td>
                    <td colspan="2"><?php  if ($rotulas == 1) : echo "SI";  elseif ($rotulas == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Terminales de direccion:</b></td>
                    <td colspan="2"><?php  if ($termin_direc == 1) : echo "SI";  elseif ($termin_direc == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Trapezios:</b></td>
                    <td colspan="2"><?php  if ($trapezios == 1) : echo "SI";  elseif ($trapezios == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Resortes:</b></td>
                    <td colspan="2"><?php  if ($resortes == 1) : echo "SI";  elseif ($resortes == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>TRANSMISION:</b></td>
                  </tr>
                  <tr>
                    <td><b>Aceite de caja:</b></td>
                    <td colspan="2"><?php  if ($aceite_caja == 1) : echo "SI";  elseif ($aceite_caja == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Filtro de caja:</b></td>
                    <td colspan="2"><?php  if ($filtro_caja == 1) : echo "SI";  elseif ($filtro_caja == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Caja de transferencia:</b></td>
                    <td colspan="2"><?php  if ($caja_transf == 1) : echo "SI";  elseif ($caja_transf == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Cardan:</b></td>
                    <td colspan="2"><?php  if ($cardan == 1) : echo "SI";  elseif ($cardan == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Diferencial:</b></td>
                    <td colspan="2"><?php  if ($diferencial == 1) : echo "SI";  elseif ($diferencial == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Disco de embrague:</b></td>
                    <td colspan="2"><?php  if ($disco_embrague == 1) : echo "SI";  elseif ($disco_embrague == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Collarin:</b></td>
                    <td colspan="2"><?php  if ($collarin == 1) : echo "SI";  elseif ($collarin == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Cruzetas:</b></td>
                    <td colspan="2"><?php  if ($cruzetas == 1) : echo "SI";  elseif ($cruzetas == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>SISTEMA DE ENFRIAMIENTO:</b></td>
                  </tr>
                  <tr>
                    <td><b>Radiador:</b></td>
                    <td colspan="2"><?php  if ($radiador == 1) : echo "SI";  elseif ($radiador == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Ventiladores:</b></td>
                    <td colspan="2"><?php  if ($ventiladores == 1) : echo "SI";  elseif ($ventiladores == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Correa de ventilador:</b></td>
                    <td colspan="2"><?php  if ($correa_vent == 1) : echo "SI";  elseif ($correa_vent == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Mangueras de agua:</b></td>
                    <td colspan="2"><?php  if ($mangueras_agua == 1) : echo "SI";  elseif ($mangueras_agua == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>INTERIORES:</b></td>
                  </tr>
                  <tr>
                    <td><b>Tablero:</b></td>
                    <td colspan="2"><?php  if ($tablero == 1) : echo "SI";  elseif ($tablero== 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz de tablero:</b></td>
                    <td colspan="2"><?php  if ($luz_tablero == 1) : echo "SI";  elseif ($luz_tablero == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Luz de saloom:</b></td>
                    <td colspan="2"><?php  if ($luz_saloom  == 1) : echo "SI";  elseif ($luz_saloom  == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Asiento Piloto:</b></td>
                    <td colspan="2"><?php  if ($asiento_piloto == 1) : echo "SI";  elseif ($asiento_piloto == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Asiento Copiloto:</b></td>
                    <td colspan="2"><?php  if ($asiento_copiloto == 1) : echo "SI";  elseif ($asiento_copiloto == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Asientos Traseros:</b></td>
                    <td colspan="2"><?php  if ($asientos_tras == 1) : echo "SI";  elseif ($asientos_tras == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Claxon:</b></td>
                    <td colspan="2"><?php  if ($claxon == 1) : echo "SI";  elseif ($claxon == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>ACCESORIOS:</b></td>
                  </tr>
                  <tr>
                    <td><b>Gata:</b></td>
                    <td colspan="2"><?php  if ($gata == 1) : echo "SI";  elseif ($gata == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Llave de ruedas:</b></td>
                    <td colspan="2"><?php  if ($llave_ruedas == 1) : echo "SI";  elseif ($llave_ruedas == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Estuche de herramientas:</b></td>
                    <td colspan="2"><?php  if ($estuche_herra == 1) : echo "SI";  elseif ($estuche_herra == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Triangulo de seguridad:</b></td>
                    <td colspan="2"><?php  if ($triangulo_seg == 1) : echo "SI";  elseif ($triangulo_seg == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td><b>Extintor:</b></td>
                    <td colspan="2"><?php  if ($extintor == 1) : echo "SI";  elseif ($extintor == 2) : echo "NO"; else: echo "NO APLICA"; endif; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>OBSERVACIONES:</b></td>
                  </tr>
                  <tr>
                    <td colspan="3">{{ $note }}</td>
                  </tr>
                </tbody>
            </table>
        </div>
      </div>

      <div class="footer">
        <div class="cc" style=" float: right;">
            <h4>--</h4>
        </div>
      </div>
    </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>
</html>
