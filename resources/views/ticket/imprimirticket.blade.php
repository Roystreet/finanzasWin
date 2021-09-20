


<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Styles -->
   <style>
* {
  font-size: 12px;
  font-family: 'Times New Roman';
}

td,
th,
tr,
table {
  border-top: 1px solid black;
  border-collapse: collapse;
}

td.producto,
th.producto {
  width: 100px !important;
  min-width: 100px !important;
}

td.cantidad,
th.cantidad {
  width: 110px !important;
  min-width: 110px !important;
  word-break: break-all;
}

.centrado {
  text-align: center;
  align-content: center;
}

.ticket {

  width: 210px !important;
  min-width: 210px !important;
}

img {
  min-width: inherit;
  width: 60%;
}
   </style>
</head>
<body>
          <div style="position: absolute; color: rgba(0, 0, 0, 0.3); z-index: -1; font-size: 54px; -webkit-transform: rotate(-65deg); -ms-transform: rotate(-65deg);      /* to support IE 9 */ transform: rotate(-65deg); top: 250px; left: -165px;letter-spacing: 0.3em">BONO DIRECTO</div>
          <?php

                  $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4");
                  $base64 = 'data:image/png;base64,' . base64_encode($data);
              ?>
          <div class="ticket">
              <img src="{{$base64}}" alt="Logotipo">
              <p class="centrado"><b>PAGO DE BONO DIRECTO</b></p>
              <p class="centrado"><b>{{$cabecera->cod_ticket}}</b>
              <br><b>FECHA:</b><?php echo date("Y-m-d", strtotime($cabecera->created_at)); ?></p>
                  <table>
                    <thead>
                      <tr>
                        <th class="cantidad" colspan="2" align="center" style="background-color:#ededed; font-weight: bold;" >DATOS DEL ANFITRION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="cantidad">ANFITRION</td>
                        <td class="producto">{{ $cabecera->getInvited->last_name }}, {{ $cabecera->getInvited->first_name }}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">DNI</td>
                        <td class="producto">{{$cabecera->getInvited->document}}</td>
                      </tr>

                      <tr>
                        <td class="cantidad">TELEFONO</td>
                        <td class="producto">{{$cabecera->getInvited->phone}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">CORREO</td>
                        <td class="producto">{{$cabecera->getInvited->email}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">BONO A COBRAR</td>
                        <td class="producto">BONO DIRECTO</td>
                      </tr>
                      <tr>
                        <td class="cantidad">MONTO A COBRAR</td>
                        <td class="producto">{{$cabecera->getGuestPayment->bono_directo}}  {{$namemoney}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">TIPO DE PAGO</td>
                        <td class="producto">{{$modo_pay}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">BONO A COBRAR</td>
                        <td class="producto">BONO DIRECTO</td>
                      </tr>
                      <tr>
                        <th class="cantidad" colspan="2" align="center" style="background-color:#ededed; font-weight: bold;" >DATOS DEL INVITADO</th>
                      </tr>

                      <tr>
                        <td class="cantidad">NOMBRES</td>
                        <td class="producto">{{$cabecera->getCustomer->last_name}}, {{$cabecera->getCustomer->first_name}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">DNI</td>
                        <td class="producto">{{$cabecera->getCustomer->document}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">FECHA DE PAGO</td>
                        <td class="producto">{{$cabecera->date_pay}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">MODO DE PAGO</td>
                        <td class="producto">{{$cabecera->getPay->name_pay}}</td>
                      </tr>

                      <tr>
                        <td class="cantidad">MONTO CANCELADO</td>
                        <td class="producto">{{$cabecera->getTicketDs->total}}</td>
                      </tr>
                      <?php
                        if ($cabecera->getPay->name_pay != "EFECTIVO"){
                      ?>
                      <tr>
                        <td class="cantidad">N° DE OPERACION</td>
                        <td class="producto">{{$cabecera->number_operation}}</td>
                      </tr>
                      <?php
                        }else{
                        }
                      ?>
                      <tr>
                        <td class="cantidad">CORREO</td>
                        <td class="producto">{{$cabecera->getCustomer->email}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">TELEFONO</td>
                        <td class="producto">{{$cabecera->getCustomer->phone}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">OBSERVACION</td>
                        <td class="producto">{{$cabecera->getGuestPayment->observaciones}}</td>
                      </tr>
                      <tr>
                        <td class="cantidad">FIRMA</td>
                        <td class="producto"></td><br>
                      </tr>



                    </tbody>
                </table>
                <br>
              <p style="font-size: 10px !important;" class="centrado">*Este comprobante solo es valido para el anfitrión.
        </div>
</body>
</html>
