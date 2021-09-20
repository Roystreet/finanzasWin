<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Culqi | Docs</title>
  </head>
  <body>
      <form>
        <div>
           <label>
             <span>Correo Electrónico</span>
             <input type="text" size="50">
           </label>
         </div>
         <div>
           <label>
             <span>Número de tarjeta</span>
             <input type="text" size="20">
           </label>
         </div>
         <div>
           <label>
             <span></span>
             <input type="text" size="4">
           </label>
         </div>
         <div>
           <label>
            <button type="button" id="buyButton" name="buyButton">Pagar</button>
           </label>
         </div>
      </form>

      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <!-- Incluye Culqi Checkout en tu sitio web-->
      <script src="https://checkout.culqi.com/js/v3"></script>
      <script>
          // Configura tu llave pública
          Culqi.publicKey = 'Aquí inserta tu llave pública';
          // Configura tu Culqi Checkout
          Culqi.settings({
              title: 'WIN TECNOLOGIES INC',
              currency: 'USD',
              description: '1 ACCION',
              amount: 40000
          });
          // Usa la funcion Culqi.open() en el evento que desees
          $('#buyButton').on('click', function(e) {
              // Abre el formulario con las opciones de Culqi.settings
              Culqi.open();
              e.preventDefault();
          });
      </script>
  </body>
</html>
