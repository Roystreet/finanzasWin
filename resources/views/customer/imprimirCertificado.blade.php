<html lang="es">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="" rel="stylesheet">
<style type="text/css">
@font-face {
  font-family: Hind;
  font-style: normal;
  font-weight: normal;
  src: url(https://fonts.googleapis.com/css?family=Roboto&display=swap) format('truetype');
}
	.s{ font-family: Hind, DejaVu Sans, sans-serif;color:rgb(77, 76, 76);}
  </style>
</head>
<body>

      <p></p>
      <p style="position: absolute; right: 140px; top: 130px; font-size: 20px; font-family: arial !important;  font-weight: bold;">{{ strtoupper($nro)}}</p>
      <p style="position: absolute; left: 350px;  top: 290px; font-size: 20px; font-family: arial !important;  font-weight: bold; ">{{ strtoupper($cabecera->last_name)}} {{ strtoupper($cabecera->first_name)}}</p>
      <p style="position: absolute; left: 310px;  top: 338px; font-size: 25px; font-family: arial !important;  font-weight: bold;">{{ strtoupper($cantidad)}}  </p>
      <p style="position: absolute; left: 340px;  top: 405px; font-size: 17px;" class="s">
	Otorgado en la Ciudad de {{$city}}, {{$d}} de {{$month}} del {{$y}}
	</p>
        <div style="position: absolute; left: 130px;  top: 456px; font-size: 17px;; width: 350px; height: 80px;" >



</div>

  <?php

          $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Ffirma.png?alt=media&token=d893b0b4-ed02-4091-897c-bbf2773a59ec");
          $base64 = 'data:image/png;base64,' . base64_encode($data);
      ?>

   <div style="position: absolute; left: 640px;  top: 458px; font-size: 14px; font-family: arial !important;  font-weight: bold;"><img src="{{ $base64 }}" width="150px" height="150px"></div>

  <div style="position: absolute; left: 956px;  top: 445px; font-size: 14px; font-family: arial !important;  font-weight: bold;">
    <img src="data:image/png;base64, {!!
      base64_encode(QrCode::encoding('ISO-8859-1')->format('png')
        ->merge('https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2F800X800.png?alt=media&token=909d301b-c5b9-4c9b-a5b8-f1ec1709921e',0.2, true)
        ->size(500)
        ->generate('Win Tecnologies INC S.A. reconoce a '. strtoupper($cabecera->last_name).', '. strtoupper($cabecera->first_name).' con la cantidad de acciones de '.$cantidad.' y con el nÃºmero de certificado: '.strtoupper($nro).', que figura en el libro de matrÃ­cula de accionistas.'))
      !!} " width="120" height="120">

  </div>

  {{--<div style="position: absolute; left: 966px;  top: 443px; font-size: 14px; font-family: arial !important;  font-weight: bold;">
    <img src="data:image/png;base64, {!!
      base64_encode(QrCode::encoding('UTF-8')->format('png')
        ->merge('https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2F800X800.png?alt=media&token=909d301b-c5b9-4c9b-a5b8-f1ec1709921e',0.2, true)
        ->size(500)
        ->generate('Win Tecnologies INC S.A reconoce a '. strtoupper($cabecera->last_name).', '. strtoupper($cabecera->first_name).'  con la tenencia de la siguiente cantidad de acciones de '.$cantidad.' con el nÃƒÂºmero de libro: '.strtoupper($nro)))
      !!} " width="120" height="120">
  </div> --}}

</div>
</body>
</html>
