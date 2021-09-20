var valorAccion = 0;
$( "#user_inv" ).prop( "disabled", true );
$( "#dni_inv" ).prop( "disabled", true );
$( "#lastname_inv" ).prop( "disabled", true );
$( "#name_inv" ).prop( "disabled", true );
$( "#lastname_inv" ).prop( "disabled", true );
$( "#phone_inv" ).prop( "disabled", true );
$( "#email_inv" ).prop( "disabled", true );
$( "#district_inv" ).prop( "disabled", true );
$('#cont_voucher_pago').hide();
$('#cont_banks').hide();
var id_price;
var actualizarInvitado = false;
 var actualizarCustomer = false;



 $('.clockpicker').clockpicker();
$('#voucher_pago').html('<input type="file" class="form-control" id="voucher" name="voucher" accept="image/png, image/jpeg">');

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $(document).ready(function() {
  jQuery.extend(jQuery.validator.messages, {
    required: "Este campo es obligatorio.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número entero válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    accept: "Por favor, escribe un valor con una extensión aceptada.",
    maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
    minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
    rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
    range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
    max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
    min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
  });
  });

var numberOrperation = false;
$(document).ready(function()
{
  //
  $('input:radio[name="customer"]').filter('[value="T"]').attr('checked', true);
  $('input:radio[name="invited_by"]').filter('[value="T"]').attr('checked', true);
  $("#myform").attr('autocomplete', 'off');//desactiva el auto completado
  $('.no').attr("style",'display:none;');
  $('#cont_voucher_pago').attr("style",'display:none;');
  $("#pagar").prop('disabled', true);
  if($('#pagar').val() == 0) {
      $('#btnCreateShareholder').attr("disabled", true);
  }

  $('.depval').hide();
  $('.proval').hide();
  var f = new Date();


  $('.timepicker').timepicker({
      showMeridian: false,
      showInputs: false,
      format: 'HH:mm:ss',
      minuteStep: 1,
      showSeconds: true,
      maxDate : 'now'

    }).on('changeTime.timepicker', function(e) {
    var h= e.time.hours;
    var m= e.time.minutes;
    var mer= e.time.meridian;
    //convert hours into minutes
    m+=h*60;
    //10:15 = 10h*60m + 15m = 615 min
    if(mer=='AM' && m<615)
        $('.timepicker').timepicker('setTime', '10:15:14');
  });;

  $("#id_customer").change(function(){
      $('.alertaccionista').remove();
  });
  $("#id_invited_by").change(function(){
      $('.alertinvitado').remove();
  });

  $("#id_country_invs").change(function(){
      $('.alertpais').remove();
  });
  $("#cod_pago").change(function(){
      $('.alertpago').remove();
  });


  $('.select2').select2();
  fillTable();


  //Obtener Pais
  var codigoPais;
  var ip;
  var lat;
  var logi;

function getCodPais()
{

  if ("geolocation" in navigator){
      navigator.geolocation.getCurrentPosition(function(position){
        lat= position.coords.latitude;
        logi= position.coords.longitude;
        coodenadas();
          });
  }else{
      console.log("Browser doesn't support geolocation!");
  }

}

getCodPais();

function coodenadas()
{
  $.ajax(
    {
      url: "https://nominatim.openstreetmap.org/reverse",
      type:"get",
      data : {
        format:"json",
        addressdetails:"1",
        "accept-language":"es",
        zoom:18,
        lat:lat,
        lon:logi
       },//
      dataType: "json",
      beforeSend: function () {
            },
    }).done(function(d)
    {
      codigoPais=d.address.country_code.toUpperCase();
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
}



//recorrer un div
function valNull(variable)
{
  var id;
  var respuesta = false;
  $( variable ).each(function( index )
  {
    id = '#'+$(this).attr('id');
    if($( this ).val()=="")
    {
      $(id).attr('style',  'border:5px solid red');
      $(id).focus();
      respuesta = false;
    }
    else
    {
      if($(id).attr("style"))
      $(id).removeAttr('style',  'border:5px solid red');
      respuesta = true;
    }
  });
  return respuesta;
}

function valiteCompra()
{
      console.log($('#id_country_invs').val());
      var respuesta = false;
      if($('#cod_pago').val()=="")
      {
        alert("Selecciona el tipo de pago");
        $("#cod_pago").focus();
          $('#id_country_invs').removeAttr('style',  'border:5px solid red');
       return respuesta = false;
      }
      else if (codigoPais == undefined)
        {
             alertify.alert('Por favor active la ubicacion del navegador').setHeader('<em> ESTA DESACTIVADO LA UBICACION EN EL NAVEGADOR </em> ');
            alerty('Active la ubicacion del navegador');
            return respuesta = false;
        }

      else if($('#id_country_invs').val() == 'Seleccione' )
      {
        alert("Seleccione pais a invertir");
        $("#id_country_invs").focus();
          $('#id_country_invs').removeAttr('style',  'border:5px solid red');
        return respuesta = false;
      }
      else
      {
        if($("#cont_voucher_pago").is(':visible') && document.getElementById("voucher").files.length == 0 )
        {
          alert('Sube el Vaucher');
            $('#cont_voucher_pago').focus();
              $('#cont_voucher_pago').removeAttr('style',  'border:5px solid red');
            return respuesta = false;
        }

        else if ($("#number_operation").is(':visible') && $("#number_operation").val() == "")
        {
            alert('Llene el número de operación');
            $('#number_operation').focus();
            $('#number_operation').css("border", "2px solid red");
            return respuesta = false;
        }

        else if(!numberOrperation && $("#number_operation").is(':visible'))
        {
          alert('Número operación ya existe');
          $('#number_operation').focus();
          return respuesta = false;
        }
        else
        {
            return respuesta = true;
        }
          return respuesta = true;
      }

}


function registerTicket()
{
  //----------------------
  $( "#first_name" ).prop( "disabled", false );
  $( "#last_name" ).prop( "disabled", false );
  $( "#phone" ).prop( "disabled", false );
  $( "#email" ).prop( "disabled", false );
  $( "#name_inv" ).prop( "disabled", false );
  $( "#lastname_inv" ).prop( "disabled", false );
  $( "#phone_inv" ).prop( "disabled", false );
  $( "#email_inv" ).prop( "disabled", false );
  $( "#district_inv" ).prop( "disabled", false );
  $( "#dni_inv" ).prop( "disabled", false );
  $( "#user_inv" ).prop( "disabled", false );

  //agregar

  //------
  $.ajax(
    {
      url: "/customer/store",
      type:"POST",
      data : {  customer : $( '#myform' ).serializeObject(),codigoPais:codigoPais, id_price:id_price,actualizarInvitado :actualizarInvitado,actualizarCustomer:actualizarCustomer},//
      dataType: "json",
      beforeSend: function () {
        $('.docs-example-modal-sm').modal('toggle');
            },
    }).done(function(d)
    {
      if(d.answer)
      {
        if(upimg(d.id_ticket))
        {
          $("form select").each(function() { this.selectedIndex = 0 });
          $("form input[type=text] , form textarea").each(function() { this.value = '' });
          $("form input[type=email] , form textarea").each(function() { this.value = '' });
          $("#cod_city" ).empty();
          $("#cod_state" ).empty();

          $(".select2").select2({
              placeholder: "Seleciona"
          });
          $(".cuerpo").empty();
          $('.btn_shoping').attr("disabled", false);
          document.getElementById("voucher").value = "";
          alertify.confirm('Registrado', '¡El accionista ha sido registrado exitosamente! Desea Descargar el Ticket generado', function(){
              alertify.success('Procesando');
              window.location.href = "/tickets/pdf/"+d.id_ticket+"";
          },function(){
          }).set({labels:{ok:'Descargar Ticket', cancel: 'No Descargar'}, padding: false});
        }else
        {
          alert("No se pudo subir la imagen.");
        }
      }else
      {
        alert("no se pudo resgistrar Correctamente el ticket");
      }
      $('.docs-example-modal-sm').modal('hide');
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });

    $( "#name_inv" ).prop( "disabled", true );
    $( "#lastname_inv" ).prop( "disabled", true );
    $( "#dni_inv" ).prop( "disabled", true );
    $( "#user_inv" ).prop( "disabled", true );
}

        $('.btn_ajax').on('click',function(){
          var dinvitado = $("#dni_inv").val();
          var valor = $("#document").val();
          if(dinvitado == valor){
             alertify.alert('Corregir', 'El DNI del invitado es igual que el DNI del accionista, Ambos DNI NO deben ser iguales!');
          }else{
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          var dni = $('#document').val().length;
          var dniinv = $('#dni_inv').val().length;
          var nFilas = $("#tabla tbody tr").length;
          if(nFilas!=0)
          {
            if($('#user_inv').val() == "")
           {
             alert("Ingrese el Invitado");
             $("#dni_inv").focus();
           }else
           {

                if($('input:radio[name=customer]:checked').val() == 'F' )
               {
                 if(actualizarCustomer)
                 {
                   if(valNull(".customer input"))
                   {
                     if( $( "#cod_country" ).val() == "" )
                     {
                       alert("Ingrese El pais Accionista");
                       $("#cod_country").focus();
                     }

                     else if($("#cod_state").val() =="Seleccionar departamento")
                     {
                       alert("Ingrese Departamento");
                       $("#cod_state").focus();
                     }
                     else if($("#cod_city").val() =="Seleccionar provincia")
                     {
                       alert("Ingrese Provincia ");
                       $("#cod_city").focus();
                     }
                     else if($("#district").val()=="")
                     {
                       alert("Ingrese lugar donde vive(Dirección)");
                       $("#cod_city").focus();
                     }
                     else if(valiteCompra())
                     {
                       registerTicket();
                     }
                   }
                 }
                 else{
                   registerTicket();
                 }

               }else if($('input:radio[name=customer]:checked').val() == 'T' && $("#id_customer").val()=="")
               {
                 alert("Ingresa Accionista");
               }else if(valiteCompra())
               {
                   registerTicket();
               }

           }

          }else
          {
            alert("Ingresa Un Producto");
            $("#tabla").focus();
          }



        }
      });


//-----------------------------------
$(document).on('click', '.btn_eliminar', function (event) {
    event.preventDefault();
    $(this).closest('tr').remove();
    getMontoPagar();
    $('.btn_shoping').prop('disabled', false);

    $( "#user_inv" ).prop( "disabled", true );
    $( "#dni_inv" ).prop( "disabled", true );
    $('#user_inv').val('');
    $('#dni_inv').val('');
    $('#lastname_inv').val('');
    $('#name_inv').val('');
    $('#phone_inv').val('');
    $('#email_inv').val('');
    $('#district_inv').val('');

});

//-------------------inicio del select
//-------------------
        $('#service').delayPasteKeyUp(function()
       {
            if($('#service').val().length > 0)
            {
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
              var listar = $.ajax(
            {
                type: "POST",
                url: "/searchShareholder",
                data: {dato: $('#service').val()},
                success: function(d)
                {
                  console.log(d.shareholder);
                  if(d != "")
                  {
                    $("#Usuario-lista").empty();
                    //Escribimos las sugerencias que nos manda la consulta
                        $.each(d.shareholder, function(id,value)
                        {
                          $("#Usuario-lista").append('<option value="'+value.cod_shareholder+'">'+
                          value.first_name+ " - "+
                          value.last_name+" - "+
                          value.document+
                          '</option>');
                        });
                  }
                  else console.log("Cadena vacia");


                }
            });
            }
            else{console.log("No hay datos");}

        }, 500);//fin del buscar accionista

        $( "#Usuario-lista" ).click(function()
           {
              var s = $.trim($( "#Usuario-lista option:selected" ).val());//obtiene el usuario
              $("#cod_shareholder").val(s);

           });


// ---------------------------------




// ---------------------------------


});//fin del document
function getCustomerWinIstoShare()
{
  var dinvitado = $("#dni_inv").val();
  var valor = $("#document").val();
  if(dinvitado == valor){
     alertify.alert('Corregir', 'El DNI del invitado es igual que el DNI del accionista, Ambos DNI NO deben ser iguales!');
  }else{
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax(
      {
        url: "/customer/get",
        type:"POST",
        data : { document: valor },//
        dataType: "json",
        beforeSend: function () {
          $('#load_shareholder').show(300);
        }
      }).done(function(d)
      {
        $('#load_shareholder').hide(300);
        if(d.objet != "warning")
        {
          $('#first_name').val(d.data.first_name);
          $('#last_name').val(d.data.last_name);
          $('#phone').val(d.data.phone);
          $('#email').val(d.data.email);
          // $('#district_inv').removeAttr("disabled");
          if(d.message == "winsystem")
          {
            if(d.data.phone ==null)
            {
              actualizarCustomer = true;
              $('#validarCsutomer').show();
              $('#first_name').prop( "disabled", false );
              $('#last_name').prop( "disabled", false );
            }
            else
            {
              actualizarCustomer = false;
              $('#validarCsutomer').hide();
              $('#first_name').prop( "disabled", true );
              $('#last_name').prop( "disabled", true );
            }
          }
        }
        else {
          $('#validarCsutomer').show();

        }
        action = 0;
      }).fail(function(){
        alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
      });
  }
}
//obtener el invitado desde taxiwin.in
function getCustomerTaxiWin()
{
  var valor = $("#user_inv").val();
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/report/customerRedTaxiWin",
      type:"POST",
      data : { data: valor },//
      dataType: "json",
      beforeSend: function () {
                    $('#load_inv').show(300);
            }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      console.log(d.data);
      if(d.mensaje.length === 0)
      {
        alert("No se encontro Datos en taxiwin.in");
      } else {
      $("#dni_inv").val(d.mensaje.document);
      $("#name_inv").val(d.mensaje.first_name);
      $("#lastname_inv").val(d.mensaje.last_name);
      $('#phone_inv').val(d.mensaje.phone);
      $('#email_inv').val(d.mensaje.email);

        if (d.data == 'bdwin'){
          //$("#validarinvitado").hide();
          if (d.mensaje.phone == null){
            $("#validarinvitado").show();
          }else{
            $("#validarinvitado").hide();
          }
          $('#district_inv').val(d.mensaje.address);
        }else{
          $('#district_inv').val(d.mensaje.adreess_1);
          $("#validarinvitado").show();
        }
        $("#user_inv" ).prop( "disabled", true );
        $("#name_inv" ).prop( "disabled", true );
        $("#lastname_inv" ).prop( "disabled", true );
        $("#dni_inv" ).prop( "disabled", true );
        $("#email_inv" ).prop( "disabled", false );
        $("#phone_inv" ).prop( "disabled", false );
        $("#district_inv" ).prop( "disabled", false );
      }

    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
}
//al precionar borrar
jQuery(function($) {
  var input = $('#document');
  input.on('keydown', function() {
    var key = event.keyCode || event.charCode;
      $( "#first_name" ).prop( "disabled", false );
      $( "#last_name" ).prop( "disabled", false );
      $( "#phone" ).prop( "disabled", false );
      $( "#email" ).prop( "disabled", false );
      $("#first_name").val("");
      $("#last_name").val("");
      $("#phone").val("");
      $("#email").val("");

  });

  var input_inv = $('#user_inv');
  input_inv.on('keydown', function() {
    if(event.keyCode == 9)
    {

    }else{
      var key = event.keyCode || event.charCode;
        $("#dni_inv").val("");
        $("#name_inv").val("");
        $("#lastname_inv").val("");
        $('#phone_inv').val('');
        $('#email_inv').val('');
        $('#district_inv').val('');
        console.log(entonrno);
        if(entonrno==false)
        {
          $("#dni_inv").prop( "disabled", false );
        }
    }

  });

  var input_inv = $('#dni_inv');
  input_inv.on('keydown', function() {
    if(event.keyCode == 9)
    {

    }else{
      var key = event.keyCode || event.charCode;
        $("#user_inv").val("");
        $("#name_inv").val("");
        $("#lastname_inv").val("");
        $('#phone_inv').val('');
        $('#email_inv').val('');
        $('#district_inv').val('');
        if(entonrno==false)
        {
          $("#user_inv").prop( "disabled", false);
        }
    }
  });

});



function onKeyDownHandler(event)
{
    var codigo = event.which || event.keyCode;

    if(codigo === 13){//Al precionar enter
      getCustomerWinIstoShare();
    }

}
function onKeyDownHandlerInv(event)
{
    var codigo = event.which || event.keyCode;

    if(codigo === 13){//Al precionar enter
      //getCustomerTaxiWin()
    }

}


//validar números
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;
}


//buscar en la base de datos de taxi win win is toshare
function onKeyDownHandlerInvDNI(event)
{
    var codigo = event.which || event.keyCode;

    if(codigo === 13){//Al precionar enter
      getCustomerTaxiWinandWinistoshare()
    }

}

function getCustomerTaxiWinandWinistoshare()
{
  valor= $('#dni_inv').val();
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$.ajax(
  {
    url: "/customer/get",
    type:"POST",
    data : { document: valor },//
    dataType: "json",
    beforeSend: function () {
               $('#load_inv').show(300);
          }
  }).done(function(d)
  {
    $('#load_inv').hide(300);
    if(d.data != null)
    {
      $('#name_inv').val(d.data.first_name);
      $('#lastname_inv').val(d.data.last_name);
      $('#phone_inv').val(d.data.phone);
      $('#email_inv').val(d.data.email);
      $('#district_inv').removeAttr("disabled");
      if(d.message == "winsystem")
      {
        if(d.data.get_country == null)
        {
          $('#validarinvitado').show();
          $('#name_inv').prop('disabled', false);
          $('#lastname_inv').prop('disabled', false);
          actualizarInvitado = true;
        }else
        {
          $('#validarinvitado').hide();
          $('#name_inv').prop('disabled', true);
          $('#lastname_inv').prop('disabled', true);
          actualizarInvitado = false;
        }

      }
      else {
        actualizarInvitado = false;
      }
    }
    else {
        $('#name_inv').removeAttr("disabled");
        $('#lastname_inv').removeAttr("disabled");
        $('#phone_inv').removeAttr("disabled");
        $('#email_inv').removeAttr("disabled");
        $('#district_inv').removeAttr("disabled");
          $('#validarinvitado').show();
          actualizarInvitado = false;

    }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación");//alerta del ticket no resgistrado
  });
}//fin del customer invitado

//no permite copiar
$(document).ready(function(){
  $("#document").on('paste', function(e){
    //e.preventDefault();
  })

  $("#document").on('copy', function(e){
    e.preventDefault();
  })

  //validar valideEmail
  $('.keyup-email').keyup(function() {
      $('span.error-keyup-7').remove();
      var inputVal = $(this).val();
      var emailReg = /^([\w-+\.]+@([\w-]+\.)+[\w-+]{2,4})?$/;
      if(!emailReg.test(inputVal)) {
          //$(this).after('<span class="error error-keyup-7">Formato Inválido</span>');
          $('#btnCreateShareholder').attr("disabled", true);
          $(this).css("border", "2px solid red");
      }else{
        $(this).css("border", "2px solid green");
        $('#btnCreateShareholder').attr("disabled", false);
      }
  });

  //validar registro







//vaidar tipo Pago
$("#cod_pago").change(function(){
                var op = $("#cod_pago option:selected").text();
                if(op == "DEPÓSITO")
                {
                  $('#textCodigoOperacion').html("Número de operación");
                  $('#cont_voucher_pago').removeAttr("style",'display:none;');
                  $('.no').removeAttr("style",'display:none;');
                  $('#cont_banks').removeAttr("style",'display:none;');
                }
                else if(op == "POCKET")
                {
                  $('#textCodigoOperacion').html("Número de operación");
                  $('#cont_voucher_pago').removeAttr("style",'display:none;');
                  $('#cont_banks').attr("style",'display:none;');
                }
                else if(op == "TRANSFERENCIA")
                {
                  $('#textCodigoOperacion').html("Número de operación");
                  $('#cont_voucher_pago').removeAttr("style",'display:none;');
                  $('.no').removeAttr("style",'display:none;');
                  $('#cont_banks').removeAttr("style",'display:none;');
                }
                else if(op == "EFECTIVO")
                {
                  $('.no').attr("style",'display:none;');
                  $('#cont_banks').attr("style",'display:none;');
                  $('#cont_voucher_pago').attr("style",'display:none;');
                }
                else if(op == "CONTADO")
                {
                  $('#cont_banks').attr("style",'display:none;');
                  $('.no').attr("style",'display:none;');
                  $('#cont_voucher_pago').attr("style",'display:none;');

                }else if(op == "BITCOIN"){
                  $('#cont_banks').attr("style",'display:none;');
                  $('#textCodigoOperacion').html("Numero de operación");
                  $('.no').removeAttr("style",'display:none;');
                  $('#cont_voucher_pago').attr("style",'display:none;');
                }else{
                  $('#cont_banks').attr("style",'display:none;');
                  $('#textCodigoOperacion').html("Hash");
                  $('#number_operation').removeAttr("onkeypress");
                  $('.no').removeAttr("style",'display:none;');
                  $('#cont_voucher_pago').attr("style",'display:none;');
                }
                $('#number_operation').val("");
        });

})

//validar solo letras
function validaLetras(event) {
    if(event.charCode >= 65 && event.charCode <= 241 || event.charCode == 32 ){
      return true;
     }
     return false;
}

//maximo de caracteres..

var inputs = "input[maxlength], textarea[maxlength]";
    $(document).on('keyup', "[maxlength]", function (e) {
        var este = $(this),
            maxlength = este.attr('maxlength'),
            maxlengthint = parseInt(maxlength),
            textoActual = este.val(),
            currentCharacters = este.val().length;
            // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
            if (document.addEventListener && !window.requestAnimationFrame) {
                if (remainingCharacters <= -1) {
                    remainingCharacters = 0;
                }
            }
            if (!!maxlength) {
                var texto = este.val();
                if (texto.length >= maxlength) {
                    e.preventDefault();
                }
                else if (texto.length < maxlength) {
                }
            }
        });

//-------- Obtener stado
$(document).on('change', '#cod_country', function(event) {
     var id = $("#cod_country option:selected").val();
     $('.alertpaisacc').remove();
     $('.depval').show();
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getState",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_state').empty();
         var fila = '<option>Seleccionar departamento</option>';
         $.each(d,function(key, registro)
         {
           fila += '<option value='+registro.id+'>'+registro.description+'</option>';
         });
         $("#cod_state").append(fila);

       }).fail(function(){
         alert("No trajo datos de los estados ");//alerta del ticket no resgistrado
       });
});

$(document).on('change', '#cod_country_inv', function(event) {
     var id = $("#cod_country_inv option:selected").val();
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getState",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_state_inv').empty();
         var fila = '<option>Seleccionar departamento</option>';
         $.each(d,function(key, registro)
         {
           fila += '<option value='+registro.id+'>'+registro.description+'</option>';
         });
         $("#cod_state_inv").append(fila);

       }).fail(function(){
         alert("No trajo datos de los estados ");//alerta del ticket no resgistrado
       });
});
//---------------------

//-------- Obtener Cuidad
$(document).on('change', '#cod_state', function(event) {
     var id = $("#cod_state option:selected").val();
     $('.alertdepacc').remove();
     $('.proval').show();
     //alert("entre");
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getCity",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_city').empty();
         var filas = '<option>Seleccionar provincia</option>';
         $.each(d,function(key, registro)
         {
           filas += '<option value='+registro.id+'>'+registro.description+'</option>';

        });
          $("#cod_city").append(filas);

       }).fail(function(){
         alert("No se Registro Intente Nueva Mente");//alerta del ticket no resgistrado
       });
});

$(document).on('change', '#cod_state_inv', function(event) {
     var id = $("#cod_state_inv option:selected").val();
     //alert("entre");
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getCity",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_city_inv').empty();
         var filas = '<option>Seleccionar provincia</option>';
         $.each(d,function(key, registro)
         {
           filas += '<option value='+registro.id+'>'+registro.description+'</option>';

        });
          $("#cod_city_inv").append(filas);

       }).fail(function(){
         alert("No se Registro Intente Nueva Mente");//alerta del ticket no resgistrado
       });
});
//---------------------

$(document).on('change', '#cod_city', function(event) {
   $('.alertprovacc').remove();
});

function getInvited(){
  if ($('input:radio[name=invited_by]:checked').val() == 'F'){
      $('.invited').show(1000);      $('.invite_true').hide(1000);
      $(document).ready(function() {
        $('.invited').find('input:text').val('');
        $('#id_invited_by').select2().val('');
        $('#id_invited_by').select2().val('');

      });

  }
  if ($('input:radio[name=invited_by]:checked').val() == 'T'){
     $('.invited').hide(1000);      $('.invite_true').show(1000);
     $('#id_invited_by').select2().val('');      $('#id_invited_by').select2().val('');

  }
}
function getCustomer(){
  if ($('input:radio[name=customer]:checked').val() == 'F'){
    $('.dniselect').hide(1000);
    $('.customer').show(1000);
    $(document).ready(function()
    {
      $('.customer').find('input:text').val('');
      $("form input[type=email] , form textarea").each(function() { this.value = '' });
      $('#id_customer').select2().val('');
      $('#id_customer').select2().val('');

    });

  }
  if ($('input:radio[name=customer]:checked').val() == 'T'){
     $('.dniselect').show(1000);
     $('.customer').hide(1000);
     $('#id_customer').select2().val('');
     $('#id_customer').select2().val('');
  }
}



$('.valOperation').keyup(function() {
     var id = $(this).val();
     var fecha = $('#date_pay').val();
     var hora = $('#hour_pay').val();


     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/valiteOperation",
         type:"POST",
         data : {  cod: id , date:fecha,hour:hora},//
         dataType: "json",
       }).done(function(d)
       {
         if(d.mensaje){
           numberOrperation = false;
           console.log(numberOrperation);
           $('.alertoperation').remove();
          $('.valOperation').css("border", "2px solid Red");
          $('.valOperation').after("<span  class='alertoperation' style='color: red;'>*Existe ese numero de operación</span>");
        }else{
          numberOrperation = true;
          console.log(numberOrperation);
        $('.valOperation').css("border", "2px solid green");
        $('.alertoperation').remove();
      }
       }).fail(function(){

       });
});

$('#first_name').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#first_name').css("border", "2px solid green");
  }
});

$('#district').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#district').css("border", "2px solid green");
  }
});

$('#name_inv').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#name_inv').css("border", "2px solid green");
  }
});

$('#lastname_inv').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#lastname_inv').css("border", "2px solid green");
  }
});

$('#dni_inv').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#dni_inv').css("border", "2px solid green");
  }
});



$('#last_name').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#last_name').css("border", "2px solid green");
  }
});

$('#phone').keyup(function() {
  var ids = $(this).val();
  numcarw = ids.length;
  if(numcarw > 1){
    $('#phone').css("border", "2px solid green");
  }

});



var respuestaDniInvValidate = false;
var respuestaDniShareValidate = false;
 $('#dni').keyup(function() {
 validateDNIShareholder();
});


$('#dni_inv').keyup(function(e) {
     //valDNI();
});

function validateDNIShareholder()
{
  var id = $('#document').val();
  numcar = id.length;

  if (numcar > 5){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/customer/valiteDNI",
      type:"POST",
      data : {cod: id },
      dataType: "json",
    }).done(function(d)
    {
      if(d.mensaje){
         $('.alertdni').remove();
         $('#document').css("border", "2px solid red");
         $('#document').focus();
       respuestaDniShareValidate = false;
     }else{
       $('#document').css("border", "2px solid green");
       $('.alertdni').remove();
       respuestaDniShareValidate = true;
   }
    }).fail(function(){

    });
  }
  return respuestaDniShareValidate;
}
var entonrno
$(document).on('click', '.btn_agregarCarrito', function() {

//valores obtendra el dato del td por posciones [0]
var valor0 = $(this).parents('tr').find('td:eq(0)').text();
var valor1 = $(this).parents('tr').find('td:eq(1)').text();
var valor2 = $(this).parents('tr').find('td:eq(2)').text();
var valor3 = $(this).parents('tr').find('td:eq(3)').text();
var valor4 = $(this).parents('tr').find('td:eq(4)').text();
id_price = $(this).attr("id");

valorAccion = valor2;
var fila = '<tr>'+
          '<td>'+valor0+'</td>'+
          '<td>'+valor1+'</td>'+
          '<td>'+valor2+'</td>'+
          '<td>'+valor3+'</td>'+
          '<td>'+valor4+'</td>'+
          '<td>'+"1"+'</td>'+
          '<td><button type="button" class="btn btn-danger btn_eliminar" monto="'+valor4+'">Eliminar</button>'+
          '<div class="input-group"><input  id="cod_product" name="cod_product" class="form-control" type="hidden" value="'+valor0+'"></div></td>'
          +'</tr>';

$("#tabla").append(fila);
$('#myModal').modal('toggle');
getMontoPagar();
$('#btnCreateShareholder').attr("disabled", false);
$('.btn_shoping').prop('disabled', true);

  if(valorAccion==0)
  {
    $('#paisainvertirform').css("display", "block");
    entonrno = false;
    $( "#dni_inv" ).prop( "disabled", false );
    //$( "#user_inv" ).prop( "disabled", false );
  }else
  {
    $('#paisainvertirform').css("display", "block");
    entonrno = false;
    $( "#dni_inv" ).prop( "disabled", false );
    //$( "#user_inv" ).prop( "disabled", false );
  }

});
function getMontoPagar() {
  var arreglo = [];
  $('#tabla tr').each(function ()
    {
       arreglo.push($(this).find("td").eq(3).html());

     });
   n   = arreglo.length,
   sum = 0;
   while(n--)
  sum += parseFloat(arreglo[n]) || 0;

   $("#pagar").val("");
   $('#pagar').val(sum);
}


// -------------------------------------------------------------------------------------------------------------------------------------

fichero = document.getElementById("voucher");
function upimg(id_ticket)
{//inicio up img

  if($("#voucher").is(':visible'))
  {
    var respuesta = false;
    if (fichero.files.length >= 1){
    storageRef = firebase.storage().ref();
    var imagenASubir = fichero.files[0];
    var uploadTask = storageRef.child('imgVoucher/' + id_ticket).put(imagenASubir);
    uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
    function(snapshot){
    //se va mostrando el progreso de la subida de la imagenASubir
    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    console.log('Upload is ' + progress + '% done');

    }, function(error) {
      //gestionar el error si se produce
      alert('Exite un error al tratar de subir la imagen');
    }, function() {
      //cuando se ha subido exitosamente la imagen
      pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
        var data = {
        'id_ticket': id_ticket,
        'voucherURL': downloadURL,
        'voucherName': imagenASubir.name};

        $.ajax({
          type: "POST",
          url: "/tickets/imgSave",
          type:"POST",
          data : data,
          dataType: "json",
        }).done(function(d){
          respuesta = true
        }).fail(function(){
          alert("No se enlaso la imagen con el ticket");
          respuesta = false;
        });


        });
      });


      respuesta = true;
    }else{
  respuesta = false;
    }
  }
  else respuesta = true;

  return respuesta;
}//fin de up img



// ----------------------------------------------------------------------------------------------------------------------------------------

$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$.fn.delayPasteKeyUp = function(fn, ms)
{
 var timer = 0;
 $(this).on("keyup paste", function()
 {
 clearTimeout(timer);
 timer = setTimeout(fn, ms);
 });
};
function fillTable()//Inicio Fill
{
  $.ajax({
    url: "/tickets/products",
    type:"post",
    beforeSend: function () {
          },
  }).done( function(d) {
    $('#tbProducts').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
      'language': {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
      },
  "data": d,
  "columns":[
      {data:"product.cod_product"},
      {data:"product.name_product"},
      {data:"product.get_product_action.cant"},
      {data:"precio.price"},
      {data:"moneda.description"},
      {
             sortable: false,
             "render": function ( data, type, full, meta ) {
                 return '<button type="button" class="btn btn-primary btn_agregarCarrito fa fa-opencart"id="'+full.precio.id +'"></button>';
             }
      }
  ]
  });

}).fail( function() {

}).always( function() {

  });
}//fin de fillTable
function activarDesactivar(codigo, id_product){
                        $.ajax({
                                      url: '/tickets/products/activarDesactivar',
                                      type: 'post',
                                      data: {codigo:codigo, id_product:id_product},
                                      dataType: "json",
                                      beforeSend: function(){
                                          console.log("Enviando usuario...");
                                      }
                                  }).done( function(d) {
                                    console.log(d.message);
                                    fillTable();
                                    alert("ya active");
                                  }).fail( function() {
                                    alert("fallo el ajax");
                                  });
}// fin activarDesactivar
