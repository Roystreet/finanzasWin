<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Google Geocoder</title>
<style>
body,
body * {
	margin:0;
	font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
}

.buscador {
	text-align:center;
	padding:30px 0px;
}

.buscador #direccion {
	margin:10px auto;
	width:100%;
	padding:7px;
	max-width:250px;
}

.buscador #buscar {
	margin:0 auto;
	max-width:250px;
	padding:7px;
	color:#FFFFFF;
	background:#f2777a;
	border:2px solid #f2777a;
	cursor:pointer;
}

      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 70%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
</style>
</head>
<body onload="initialize()">

  <div id="floating-panel">
    <input id="addressgoogle" type="textbox" value="Lima, pataz 1253">
    <input id="submit" type="button" onclick="codeAddress()" value="buscar">
  </div>
  <div id="map" style="height: 100%;"></div>
  <input type="text" id="direccion">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>

   var geocoder;
   var map;
   function initialize() {
     $('#map').html('');
     geocoder = new google.maps.Geocoder();
     var latlng = new google.maps.LatLng(-11.9958973, -77.0781772);
     var mapOptions = {
       zoom: 16,
       center: latlng,
       disableDefaultUI: true
     }
     map = new google.maps.Map(document.getElementById('map'), mapOptions);
     //cambiar mapa por map
     var marcador = new google.maps.Marker({
				position: latlng,
				map: map,
				title: 'emergencia'
		});

   }

   function codeAddress() {

     var address = document.getElementById('addressgoogle').value;

     geocoder.geocode( { 'addressgoogle': address}, function(results, status) {
       if (status == 'OK') {
         map.setCenter(results[0].geometry.location);
         var marker = new google.maps.Marker({
             map: map,
             position: results[0].geometry.location
         });
         $('#direccion').val(results[0].geometry.location);
       } else {
         alert('Geocode was not successful for the following reason: ' + status);
       }
     });
   }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9LCCfUHXYRZJEYOJcynZdl2M89DuA-do"></script>
</body>
</html>
