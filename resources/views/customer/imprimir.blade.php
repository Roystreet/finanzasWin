


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
  width: 80px !important;
  min-width: 80px !important;
}

td.cantidad {
  width: 60px !important;
  min-width: 60px !important;
  word-break: break-all;
},
th.cantidad {
  width: 60px !important;
  min-width: 60px !important;
  word-break: break-all;
}

.centrado {
  text-align: center;
  align-content: center;
}

.ticket {
  width: 180px !important;
  min-width: 180px !important;
}

img {
  min-width: inherit;
  width: 60%;
}
   </style>
</head>
<body>
  <div class="ticket">
        <?php
            $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4");
            $base64 = 'data:image/png;base64,' . base64_encode($data);
        ?>
    <img src="{{$base64}}" alt="Logotipo">

     <p class="centrado">{{$ticket->cod_ticket}}
     <br>{{ $ticket->getProduct[0]->cant }} {{ $ticket->getProduct[0]->name_product}}
     <br><?php echo date("Y-m-d", strtotime($ticket->created_at));   ?></p>
     <table>
       <thead>
         <tr>
           <th class="cantidad" colspan="2" align="center" style="background-color:#ededed" >DATOS DEL COMPRADOR</th>
         </tr>
       </thead>
       <tbody>
         <tr>
           <td class="cantidad">DNI</td>
           <td class="producto">{{ $ticket->getCustomer ? $ticket->getCustomer->document : ''  }}</td>

         </tr>
         <tr>
           <td class="cantidad">Comprador</td>
           <td class="producto">{{ $ticket->getCustomer ? $ticket->getCustomer->last_name   : '' }},
                                {{ $ticket->getCustomer ? $ticket->getCustomer->first_name  : '' }}</td>
         </tr>
         <tr>
           <td class="cantidad">Pais</td>
           <td class="producto">{{ $country }}</td>
         </tr>
         <tr>
           <td class="cantidad">Estado</td>
           <td class="producto">{{$state }}</td>
         </tr>
         <tr>
           <td class="cantidad">Ciudad</td>
           <td class="producto">{{$city }}</td>
         </tr>
         <tr>
           <td class="cantidad">Dirección</td>
           <td class="producto">{{ $ticket->getCustomer ? $ticket->getCustomer->address  : '-' }}</td>
         </tr>
         <tr>
           <td class="cantidad">Teléfono</td>
           <td class="producto">{{ $ticket->getCustomer->phone ? $ticket->getCustomer->phone  : '-' }}</td>
         </tr>
         <tr>
           <td class="cantidad">Correo</td>
           <td class="producto">{{  $ticket->getCustomer->email ? $ticket->getCustomer->email  : '-'  }}</td>
         </tr>
         <tr>
           <th class="cantidad" colspan="2" align="center" style="background-color:#ededed">DATOS DE LA COMPRA</th>
         <tr>
           <td class="cantidad">Monto</td>
           <td class="producto">{{$ticket->total }} {{ $ticket->getMoney[0]->{'description'} ?  $ticket->getMoney[0]->{'description'}    : '-'}}</td>
         </tr>
         <tr>
           <td class="cantidad">Tipo de pago</td>
           <td class="producto">{{$ticket->getPay->name_pay ? $ticket->getPay->name_pay : '' }}</td>
         </tr>
         <tr>
           <td class="cantidad">Banco</td>
           <td class="producto">{{ isset($banks) ? $banks : '-' }}</td>
         </tr>
         <tr>
           <td class="cantidad">Nro Ope.</td>
           <td class="producto">{{$ticket->number_operation ? $ticket->number_operation : '-' }}</td>
         </tr>
         <tr>
           <td class="cantidad">Fecha Pago</td>
           <td class="producto">{{$ticket->date_pay ? $ticket->date_pay : '-'}}</td>
         </tr>
         <tr>
           <th Classes="cantidad" colspan="2" align="center" style="background-color:#ededed">DATOS DEL ANFITRION</th>
         </tr>
         <tr>
           <td class="cantidad">Nombre</td>
           <td class="producto">{{ $ticket->getInvited ? $ticket->getInvited->last_name  : '' }} {{ $ticket->getInvited ? $ticket->getInvited->first_name  : '' }}</td>
         </tr>

         <?php
          if ($detalleprod[0]->cant > 0){
          ?>
         <tr>
           <th class="producto" colspan="2" align="center" style="background-color:#ededed">PAIS A INVERTIR</th>
         </tr>
         <tr>
           <td class="producto" colspan="2" align="center">{{ $ticket->getCountryInv->description ?  $ticket->getCountryInv->description  : '' }}</td>
         </tr>
         <?php
         }
         ?>
         <tr>
           <th class="producto" colspan="2" align="center" style="background-color:#ededed">{{ $ticket->note ?  'OBSERVACIONES'  : '' }}</th>
         </tr>
         <tr>
           <td class="producto" colspan="2" align="center">{{ $ticket->note ?  $ticket->note  : '' }}</td>
         </tr>
         <tr>
           <th class="producto" colspan="2" align="center" style="background-color:#ededed">FIRMA</th>
         </tr>
         <tr>
           <td class="producto" colspan="2" align="center"><br><br><br><p>_______________________________</p></td>
         </tr>
       </tbody>
     </table>
     <br>
     <p style="font-size: 10px !important;" class="centrado">s

Este documento sirve para realizar
reclamos. *Importante: Si usted perde este
documento tiene que volver a emitir este
mismo, tiene un costo de S/. 5 PEN solo en
Peru, $ 2.00 USD otros paises. *Este es un
comprobante de pago que será válido hasta
que se emita el certificado de tenencia de
acción.
</p>
  </div>
</body>
</html>
