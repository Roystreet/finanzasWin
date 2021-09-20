<html lang="es">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
 @foreach ($data as  $key => $value)

<p style="position: absolute; right: 155px; top: 155px; font-size: 20px; font-family: arial !important;  font-weight: bold;">{{ $value{'number_books'} }}</p>
<p style="position: absolute; left: 365px;  top: 285px; font-size: 20px; font-family: arial !important;  font-weight: bold; ">{{ $value{'cliente'}{'last_name'} }} {{  $value{'cliente'}{'first_name'} }}</p>
<p style="position: absolute; left: 270px;  top: 340px; font-size: 25px; font-family: arial !important;  font-weight: bold;">{{  $value{'cant'} }}  </p>
<p style="position: absolute; left: 360px;  top: 440px; font-size: 14px; font-family: arial !important;  font-weight: bold;">Otorgado en la Ciudad de {{$city}}, {{$d}} de {{$month}} del {{$y}}</p>
  <div style="position: absolute; left: 180px;  top: 480px; font-size: 14px; font-family: arial !important;  font-weight: bold; width: 350px; height: 80px;">
    <p>Nota:</p>
      <p>En el transcurso del pr&oacute;ximo a&ntilde;o ser&aacute; cambiado por un certificado de {{ $value{'valor1'}  }} acciones y luego en los pr&oacute;ximos dos a&ntilde;os en {{ $value{'valor2'} }} aciones.</p>
  </div>
<div style="position: absolute; left: 650px;  top: 545px; font-size: 14px; font-family: arial !important;  font-weight: bold;"><img src="{{ URL::asset('imagenes/firma.png')}}" width="150px" height="150px"></div>


   @if(count($data)==($key+1))
    @else
      <div style="page-break-after:always;"></div>
    @endif
 @endforeach

</body>
</html>
