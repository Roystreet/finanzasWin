<!DOCTYPE html>
<html >
<head>
	<title>Freshdesk Ecuador</title>
	<meta charset="utf-8">
            <!-- Sustituyo el "uft-8" por la función que trae la información de la instalacion de wordpress. |
            I substitute the "uft-8" for the function that brings the information of the wordpress installation.-->
    <meta name="description" content="Primer network taxi del mundo. Aplicativo que conecta usuarios con conductores."/>
    <meta name="author" content="Susana Piñero"/>
    <meta name="keywords" content="taxi, network, win, taxiwin, wakiy"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- Aquí llamo los script para cargar y ejecutar todas las funciones de cabecera. |
         I call the script to load and execute all the header functions.-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <style>
        #main-footer {
            font-size: 1.5rem;
        }
        input[type="text"], input[type="email"], input[type="tel"]{
            width: 100%;
        }
        #myFile{
            height: initial;
        }
        .btn-success {
            color: #333;
            background-color: #fcbe00;
            border-color: #fcbe00;
        }
        .btn-success:hover {
            color: #fff;
            background-color: #fcbe00;
            border-color: #ffe22b;
        }
        .btn-success.active.focus, .btn-success.active:focus, .btn-success.active:hover, .btn-success:active.focus, .btn-success:active:focus, .btn-success:active:hover, .open>.dropdown-toggle.btn-success.focus, .open>.dropdown-toggle.btn-success:focus, .open>.dropdown-toggle.btn-success:hover {
            color: #fff;
            background-color: #fcbe00;
            border-color: #ffe22b;
        }
        .btn-success.active, .btn-success:active, .open>.dropdown-toggle.btn-success {
            color: #fff;
            background-color: #fcbe00;
            background-image: none;
            border-color: #ffe22b;
        }
        .btn-success.focus, .btn-success:focus {
            color: #fff;
            background-color: #fcbe00;
            border-color: #ffe22b;
        }
        .btn {
            padding: 1% 10%;
        }
    </style>
</head>
<body id="body">
	<div id="global-container">
		<section id="global-content" class="cf">
            <section id="main-content">
              <img src="https://winrideshare.com/wp-content/uploads/2019/03/win_2019.png" style="display: block; margin-left: auto; margin-right: auto; width: 25%;">
              <div style=" width: 66.66%; margin: 0 auto;">
                 <h2>TICKET DE SOPORTE</h2>
                <h4>Si tengo alguna duda, inconveniente o sugerencia, ¿Como me puedo comunicar con ustedes?</h4>
                <p>Envíanos un ticket</p>
              </div><br>
                  <form class="form-horizontal" action="#" id="formfreshdeks" enctype="multipart/form-data">
                    <div class="form-group">
                      <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="email">Tipo de solicitud:</label>
                      <div class="col-10 col-sm-6">
                        <select class="form-control" id="tipo" name="tipo">
                          <option>Seleccionar tipo</option>
                          <option>Peticion</option>
                          <option>Queja</option>
                          <option>Reclamo</option>
                          <option>Sugerencia</option>
                        </select>
                        <div class="col-sm-2"></div>
                      </div>
                    </div>
                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="pwd">Motivo:</label>
                      <div class="col-10 col-sm-6">
                        <input type="text" class="form-control" id="subject" placeholder="Ingresar asunto" name="subject">
                        <input type="hidden" id="group-id" id="group-id" value="43000578275">
                      </div>
                      <div class="col-sm-2"></div>
                    </div>
                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="email">Correo Electrónico:</label>
                      <div class="col-10 col-sm-6">
                        <input type="email" class="form-control" id="email" placeholder="Ej: nombre@correo.com" name="email">
                      </div>
                      <div class="col-sm-2"></div>
                    </div>
                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="telefono">Numero de teléfono:</label>
                      <div class="col-10 col-sm-6">
                        <input type="tel" class="form-control" id="telefono" placeholder="Ej: 999944222" name="telefono">
                      </div>
                      <div class="col-sm-2"></div>
                    </div>
                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="pwd">Descripción:</label>
                      <div class="col-10 col-sm-6">
                        <textarea class="form-control" id="description" name="description" placeholder="Ingresar descripcion"></textarea>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>
                    <div class="form-group justify-content-md-center">
                        <div class="col-sm-2"></div>
                      <label class="col-10 col-sm-2" for="pwd">Seleccion un archivo adjunto:</label>
                      <div class="col-10 col-sm-6">
                        <input type='file' id='myFile' class="form-control" id="myFile" name="myFile" >
                      </div>
                      <div class="col-sm-2"></div>
                    </div>
                    <div class="form-group justify-content-md-center">
                      <div class="col-sm-12 text-center">
                        <button type="button" id="btn_ajax" class="btn btn-success">Enviar</button>
                      </div>
                      <div class="col-sm-2"></div>
                    </div>
                  </form>
                </section><!-- /#main-content -->
        </section><!-- /#global-content -->
			<footer id="main-footer">
	            <div class="contact">
	                <div class="col-1 col-padding-1 text-left">
	                    <p>Contáctanos</p>
	                </div>
	                <div class="row contacto">
	                    <div class="col-3 col-xs col-padding-1 text-left">
	                        <a href="https://www.facebook.com/WinPeru-Oficial-176076053110785/" target="_blank" type="text/html">
	                            <span class="icon-facebook"></span>
	                            Facebook.com
	                        </a>
	                    </div>
	                    <div class="col-3 col-xs col-padding-1 text-left">
	                        <a href="https://www.youtube.com/channel/UCHCWOH9Kizu91O0DgiLEZ3Q?view_as=subscriber" target="_blank" type="text/html">
	                            <span class="icon-youtube"></span>
	                            Youtube.com
	                        </a>
	                    </div>
	                </div>
	            </div>
			</footer><!-- footer -->
	</div><!-- /#global-container -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/msm/ticketfreshdesk.js')}} "></script>
</body>
</html>
