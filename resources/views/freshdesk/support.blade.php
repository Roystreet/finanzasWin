<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>TICKET DE SOPORTE</h2>
  <h4>Si tengo alguna duda, inconveniente o sugerencia, ¿Como me puedo comunicar con ustedes?</h4>
  <p>Envíanos un ticket</p>
  <form action="/action_page.php">
    <div class="form-group">
      <label for="email">Correo Electrónico:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Asunto:</label>
      <input type="text" class="form-control" id="pwd" placeholder="enter subject" name="pwd">
    </div>
    <div class="form-group">
      <label for="pwd">Descripcion:</label>
      <textarea class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-default">Enviar</button>
  </form>
</div>

</body>
</html>
