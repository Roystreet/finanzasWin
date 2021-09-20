<html>
  <head>
  </head>
  <body>
    <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;" >
    	<tr>
    		<td style="background-color: #07466D; text-align: left; padding: 0">
    			<a href="https://winescompartir.com/" target="_blank">
    				<img width="20%" style="display:block; margin: 1.5% 3%" src="https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4" target="_blank">
    			</a>
    		</td>
    	</tr>
    	<tr>
    		<td style="background-color: #ecf0f1">
    			<div style="color: black; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
    				<p style="margin: 2px; font-size: 15px">
              <h2 style="color: black; margin: 0 0 7px">Se ha realizado un  <?php echo $e{'regis'} ?>  del siguiente ticket</h2><br><br>
              Los datos del cliente son los siguientes:
              <ul style="font-size: 15px;  margin: 10px 0">
                <li>Codigo del ticket :     <?php echo $e{'codticket'} ?></li>
                <li>Nombres y apellidos :   <?php echo $e{'nombre'}.' '.$e{'apellido'} ?></li>
                <li>Documento de Identidad :<?php echo $e{'document'} ?> </li>
                <li>Tipo de pago :          <?php echo $e{'pay'} ?></li>
                <li>Fecha :                 <?php echo $e{'dateemi'} ?></li>
                <li>Numero Telefonico :    <?php echo $e{'phone'} ?></li>
                <li>Email :    <?php echo $e{'email'} ?></li>
                <li>Observacion :    <?php echo $e{'observacion'} ?></li><br>
              </ul>
                <b>Nota: Este correo debe ser derivado al area de Finanzas</b>
            </p><br>

    				<p style="color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0">WIN TECNOLOGIES INC S.A RUC: 20603216246</p>
    			</div>
    		</td>
    	</tr>
    </table>
  </body>
</html>
