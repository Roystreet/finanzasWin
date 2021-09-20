$('#cod_country').select2();
$('#cod_state').select2();
$('#cod_city').select2();
$('#cod_pago').select2();
$('#type_docu').select2();
$('#type_docu_inv').select2();
$('.number').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g,'');
});
$( "#first_name" ).prop( "disabled", true );
$( "#last_name" ).prop( "disabled", true );
$( "#lastname_inv" ).prop( "disabled", true );
$( "#type_docu_inv" ).prop( "disabled", true );
$( "#name_inv" ).prop( "disabled", true );
$( "#dni_inv" ).prop( "disabled", true );
$( "#search_inv" ).prop( "disabled", true );
$('.customer-data-hide').hide();
$('#divoperacion').hide();
$('#cont_voucher_pago').hide();
$('#voucher_pago').html('<input type="file" class="form-control" id="voucher" name="voucher" accept="image/png, image/jpeg">');
var accionista = false;
var sponsorinv = false;
var actulizarinv = false;
var codigoPais;
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

var formulario = $("#customer-form").validate({
  debug: true,
  success: "valid",
  rules:{ document:{ required:true },
        type_docu:{ required:true }
        },

    errorPlacement: function (error, element) {
        $('.error-customer').remove();
        $(element).after("<p class='error-customer'>"+error[0].innerText+"</p>");

    },
    highlight: function(element, errorClass) {//los objetos que no cumplan con la validación parpadearan
      $('.error-customer').remove();
                $(element).fadeOut(function() {
                    $(element).fadeIn();
                });
    },
    submitHandler: function(form) {
      $('.error-customer').remove();


        getCustomer();
        return false;

     }
   });

   //Obtener Pais

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
     alert("hola");
       console.log("Browser doesn't support geolocation!");
   }

 }
getCodPais();

alertify.alert('Si tiene Desactivado la ubicacion del navegador, por favor activela antes de continuar, otorgar permisos para mejorar la personalización de su compra <i class="fa fa-map-marker">   Conocer tu ubicación "Permitir" ').setHeader('<i class="fa fa-map-marker"></i><em>ADVERTENCIA!</em> ');

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



var settings = $("#customer-form").validate().settings;

  $("#type_docu").change(function() {
  var td =$( "#type_docu" ).val();
  for (var i in settings.rules){
    delete settings.rules[i];
  }
  switch (td) {
              case '1':
              $("#document").attr('placeholder','Ingrese el numero de identificacion');
              $( "#type_docu" ).rules("add" , {required: true });
              $( "#document" ).rules("add", {required: true,
                                        maxlength:15,
                                        minlength:2 });
              break;
                case '2':
                $("#document").attr('placeholder','Ingrese el numero de DNI');
                $( "#type_docu" ).rules("add" , {required: true });
                $( "#document" ).rules("add" , { required: true,
                                            number:true,
                                            maxlength:8,
                                            minlength:8 });
                break;
                  case '3':
                  $("#document").attr('placeholder','Ingrese el numero de cedula de identidad');
                  $( "#type_docu" ).rules("add" , {required: true });
                  $( "#document" ).rules("add" , {required: true,
                                             maxlength:10,
                                             minlength:2 });
                  break;
                    case '4':
                    $("#document").attr('placeholder','Ingrese el numero de CURP');
                    $( "#type_docu" ).rules("add" , {required: true });
                    $( "#document" ).rules("add" , { required: true,
                                                maxlength:18,
                                                minlength:2 });
                    break;
              default:
                  $( "#type_docu" ).rules("add" , {required: true});
              break;
              }
            });


            var formulario_inv = $("#customer-form-inv").validate({
              debug: true,
              success: "valid",
              rules:{ dni_inv:{ required:true },
                    type_docu_inv:{ required:true },
                    name_inv:{ required:true },
                    lastname_inv:{ required:true }
                    },

                errorPlacement: function (error, element) {
                    $('.error-customer').remove();
                    $(element).after("<p class='error-customer'>"+error[0].innerText+"</p>");

                },
                highlight: function(element, errorClass) {//los objetos que no cumplan con la validación parpadearan
                  $('.error-customer').remove();
                            $(element).fadeOut(function() {
                                $(element).fadeIn();
                            });
                },
                submitHandler: function(form) {
                  $('.error-customer').remove();


                    getCustomerInv();
                    return false;

                 }
               });

               var settings = $("#customer-form-inv").validate().settings;

                 $("#type_docu_inv").change(function() {
                 var td =$( "#type_docu_inv" ).val();
                 for (var i in settings.rules){
                   delete settings.rules[i];
                 }
                 switch (td) {
                             case '1':
                             $("#dni_inv").attr('placeholder','Ingrese el numero de identificacion');
                             $( "#type_docu_inv" ).rules("add" , {required: true });
                             $( "#dni_inv" ).rules("add", {required: true,
                                                       maxlength:15,
                                                       minlength:2 });
                             break;
                               case '2':
                               $("#dni_inv").attr('placeholder','Ingrese el numero de DNI');
                               $( "#type_docu_inv" ).rules("add" , {required: true });
                               $( "#dni_inv" ).rules("add" , { required: true,
                                                           number:true,
                                                           maxlength:8,
                                                           minlength:8 });
                               break;
                                 case '3':
                                 $("#dni_inv").attr('placeholder','Ingrese el numero de cedula de identidad');
                                 $( "#type_docu_inv" ).rules("add" , {required: true });
                                 $( "#dni_inv" ).rules("add" , {required: true,
                                                            maxlength:10,
                                                            minlength:2 });
                                 break;
                                   case '4':
                                   $("#dni_inv").attr('placeholder','Ingrese el numero de CURP');
                                   $( "#type_docu_inv" ).rules("add" , {required: true });
                                   $( "#dni_inv" ).rules("add" , { required: true,
                                                               maxlength:18,
                                                               minlength:18 });
                                   break;
                             default:
                                 $( "#type_docu" ).rules("add" , {required: true});
                             break;
                             }
                           });


                             $('.customer-data-hide').validate({

                               rules: {


                                 phone:            {  required: true     },
                                 email:            {  required: true,  email: true      },
                                 cod_country:            {  required: true     },
                                 cod_state:            {  required: true     },
                                 cod_city:            {  required: true     },
                                 district:            {  required: true     },
                                 type_docu_inv:            {  required: true     },
                                 dni_inv:            {  required: true     },
                                 name_inv:            {  required: true     },
                                 lastname_inv:            {  required: true     },


                               },

                               onkeyup :false,
                               errorPlacement : function(error, element) {
                                 $(element).closest('.form-group').find('.help-block').html(error.html());
                               },
                               highlight : function(element) {
                                 $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                               },
                               unhighlight: function(element, errorClass, validClass) {
                                 $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                                 $(element).closest('.form-group').find('.help-block').html('');
                               },
                               submitHandler: function(form) {
                                 alertify.confirm('Registrado', 'Confirma que desea realizar la siguiente actualizacion de ticket?', function(){
                                   form.submit(); },function(){  }).set({labels:{ok:'Guardar', cancel: 'Cancelar'}, padding: false});
                                 }
                               });

                               $.extend( $.validator.messages, {
                                 required: "Este campo es obligatorio.",
                                 remote: "Por favor, rellena este campo.",
                                 email: "Por favor, escribe una dirección de correo válida.",
                                 url: "Por favor, escribe una URL válida.",
                                 date: "Por favor, escribe una fecha válida.",
                                 dateISO: "Por favor, escribe una fecha (ISO) válida.",
                                 number: "Por favor, escribe un número válido.",
                                 digits: "Por favor, escribe sólo dígitos.",
                                 creditcard: "Por favor, escribe un número de tarjeta válido.",
                                 equalTo: "Por favor, escribe el mismo valor de nuevo.",
                                 extension: "Por favor, escribe un valor con una extensión aceptada.",
                                 maxlength: $.validator.format( "Por favor, no escribas más de {0} caracteres." ),
                                 minlength: $.validator.format( "Por favor, no escribas menos de {0} caracteres." ),
                                 rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
                                 range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
                                 max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
                                 min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),
                                 nifES: "Por favor, escribe un NIF válido.",
                                 nieES: "Por favor, escribe un NIE válido.",
                                 cifES: "Por favor, escribe un CIF válido.",
                               });


            });

            //buscar invitado

          // });

  function getCustomer()
          {
            valor= $('#document').val();
            type_docum=$('#type_docu').val();


            $.ajax(
              {
                url: "/customer/register/get",
                type:"POST",
                data : { document: valor, type_docum:type_docum },//
                dataType: "json",
                beforeSend: function () {
                  $('#load_customer').show(300);
                }

              }).done(function(d)
              {
                $('#load_customer').hide(300);
                $('#search_inv').attr("disabled", true);
                if(d.objet != "error")
                {
                      //customer
                      $('.customer-data-hide').hide();
                      $('#first_name').val(d.data.first_name);
                      $('#last_name').val(d.data.last_name);
                      $('#first_name').prop( "disabled", true );
                      $('#last_name').prop( "disabled", true );
                      accionista = true;
                      //invitado
                      if(d.inv != null)
                      {
                        $( "#dni_inv" ).prop( "disabled", true );
                        $( "#type_docu_inv" ).prop( "disabled", true );
                        $('#dni_inv').val(d.inv.document);
                        $("#type_docu_inv option[value='1']").attr("selected", true);
                        $('#lastname_inv').val(d.inv.last_name);
                        $('#name_inv').val(d.inv.first_name);
                        $('#lastname_inv').val(d.inv.last_name);
                        sponsorinv = true;
                      }
                      else
                      {
                        actulizarinv = true;
                        $( "#dni_inv" ).prop( "disabled", false );
                        $( "#type_docu_inv" ).prop( "disabled", false );
                        $('#search_inv').attr("disabled", false);
                        $('#dni_inv').val("");
                        $( "#type_docu_inv" ).val("");
                        $('#lastname_inv').val("");
                        $('#name_inv').val("");
                        $('#lastname_inv').val("");
                        sponsorinv = false;
                      }

                }
                else if(d.objet == "error" && d.message == "registrar")
                {
                  $('#first_name').prop( "disabled", false );
                  $('#last_name').prop( "disabled", false );
                  $('.customer-data-hide').show();
                  $( "#dni_inv" ).prop( "disabled", false );
                  $( "#type_docu_inv" ).prop( "disabled", false );
                  nombres = d.data[0].preNombres;
                  $('#first_name').val(nombres);
                  apellidos = d.data[0].apePaterno;
                  apellidos += " " + d.data[0].apeMaterno;
                  $('#last_name').val(apellidos);
                  $('#phone').val("");
                  $('#email').val("");
                  $("#cod_country").val("").change();
                  $('#cod_state').val("").change();
                  $('#cod_city').val("").change();
                  $('#district').val("");
                  $('#dni_inv').val("");
                  $( "#type_docu_inv" ).val("");
                  $('#lastname_inv').val("");
                  $('#name_inv').val("");
                  $('#lastname_inv').val("");

                  $('#search_inv').attr("disabled", false);
                  alertify.alert('Registrate','Aun no se encuentra registrado, porfavor ingrese sus datos.!');
                  accionista = false;
                }
                else
                {
                  if(d.message == "Menor de Edad"){
                    alertify.alert('Ingrese Otro DNI','El usuario ingresado es '+d.message+' Porfavor ingrese otro DNI', function(){
                      location.reload(); },).set({labels:{ok:'ok'}});
                  }else{
                    $('#first_name').prop( "disabled", false );
                    $('#last_name').prop( "disabled", false );
                    $('.customer-data-hide').show();
                    $( "#dni_inv" ).prop( "disabled", false );
                    $( "#type_docu_inv" ).prop( "disabled", false );
                    $('#first_name').val("");
                    $('#last_name').val("");
                    $('#phone').val("");
                    $('#email').val("");
                    $("#cod_country").val("").change();
                    $('#cod_state').val("").change();
                    $('#cod_city').val("").change();
                    $('#district').val("");
                    $('#dni_inv').val("");
                    $( "#type_docu_inv" ).val("");
                    $('#lastname_inv').val("");
                    $('#name_inv').val("");
                    $('#lastname_inv').val("");

                    $('#search_inv').attr("disabled", false);
                    alertify.alert('Registrate','Aun no se encuentra registrado, porfavor ingrese sus datos.!');
                    accionista = false;
                  }
                }

              }).fail(function(){
                alertify.alert('¡Ha ocurrido un error en la operación!','Si el problema persiste comuniquese por nuestros canales de atencion <b> <a href="https://winescompartir.com/" target="_blank">https://winescompartir.com/</a></b>');//alerta del ticket no resgistrado
              setTimeout(function () { location.reload(1); }, 12000);
              });
            }//fin del customer

  function getCustomerInv()
            {
              valor= $('#dni_inv').val();
      if($('#dni_inv').val() != $('#document').val())
        {
              $.ajax(
              {
                url: "/customer/register/get",
                type:"POST",
                data : { document: valor },//
                dataType: "json",
                beforeSend: function () {
                $('#load_inv').show(300);
              }
              }).done(function(d)
              {
                $('#load_inv').hide(300);
                if(d.objet != "error")
                {
                  //customer
                  $('#name_inv').val(d.data.first_name);
                  $('#lastname_inv').val(d.data.last_name);
                  sponsorinv = true;
                }
                else
                {
                  sponsorinv = false;

                  $('#name_inv').val("");
                  $('#lastname_inv').val("");
                  alertify.alert('Registrate','Patrocinador/Sponsor NO se encuentra registrado, porfavor ingrese otro numero de identificacion!');
                }

              }).fail(function(){
                alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
              });

            }else alertify.alert('Notificacion','El Accionista no puede ser igual al Patrocinador/Sponsor');

          }//fin del customer invitado

  // }

// });
// $( "#search_inv" ).click(function() {
//   var d = $('#dni_inv').val();
//
//       if(d ==null || d =="")
//       {
//         alert("Por favor, ingrese de documento de identidad nacional o DNI o Cédula de identidad o CURP.");
//         $('#dni_inv').css("border", "2px solid red");
//
//       }
//       else
//       {
//         getCustomerInv();
//       }
// });

function getCustomerByApi(dni){
  type_docum=$('#type_docu').val();
  $.ajax(
  {
    url: "/customer/getCustomerByApi",
    type:"POST",
    data : { document: dni ,type_docum:type_docum },//
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(300);
  }
  }).done(function(d)
  {
    $('#load_inv').hide(300);
    if(d.objet != "error")
    {
      //customer
      $('#name_inv').val(d.first_name);
      $('#lastname_inv').val(d.last_name);
      sponsorinv = true;
    }
    else
    {
      sponsorinv = false;

      $('#name_inv').val("");
      $('#lastname_inv').val("");
      alertify.alert('Registrate','Aun no se encuentra registrado, porfavor ingrese sus datos.!');
    }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  });
}


//
$("#dni_inv").keydown(function(event){
      $('#name_inv').val("");
      $('#lastname_inv').val("");
	});

  var respuestaDniInvValidate = false;
  var respuestaDniShareValidate = false;

   $('#document').keyup(function() {
   validateDNIShareholder();
  });


  function validateDNIShareholder()
  {
    var id = $('#document').val();
    numcar = id.length;

    if (numcar > 5){
    $.ajax(
      {
        url: "/customer/register/valiteDNI",
        type:"POST",
        data : {cod: id },
        dataType: "json",
      }).done(function(d)
      {
        if(d.mensaje){
           $('.alertdni').remove();
           // $('#dni').css("border", "2px solid red");
           $('#document').focus();
         respuestaDniShareValidate = false;
       }else{
         //$('#dni').css("border", "2px solid green");
         $('.alertdni').remove();
         respuestaDniShareValidate = true;
     }
      }).fail(function(){

      });
    }
  }
  //-------- Obtener stado
  $(document).on('change', '#cod_country', function(event) {
       var id = $("#cod_country option:selected").val();
       $('.alertpaisacc').remove();
       $('.depval').show();

       $.ajax(
         {
           url: "/customer/register/getState",
           type:"POST",
           data : {  id: id},//
           dataType: "json",
         }).done(function(d)
         {

           $('#cod_state').empty();
           var fila = '<option value="">Seleccione...</option>';
           $.each(d,function(key, registro)
           {
             fila += '<option value='+registro.id+'>'+registro.description+'</option>';
           });
           $("#cod_state").append(fila);

         }).fail(function(){
           alert("No se cargaron los datos para el departamento, por favor intente de nuevo.");//alerta del ticket no resgistrado
         });
  });
  //obtener city
  $(document).on('change', '#cod_state', function(event) {
       var id = $("#cod_state option:selected").val();
       $.ajax(
         {
           url: "/customer/register/getCity",
           type:"POST",
           data : {  id: id},//
           dataType: "json",
         }).done(function(d)
         {

           $('#cod_city').empty();
           var filas = '<option value="">Seleccione...</option>';
           $.each(d,function(key, registro)
           {
             filas += '<option value='+registro.id+'>'+registro.description+'</option>';

          });
            $("#cod_city").append(filas);

         }).fail(function(){
           alert("No se cargaron los datos para la provincia, por favor intente de nuevo.");//alerta del ticket no resgistrado
         });
  });
  //validar tipo de Pago
  $(document).on('change', '#cod_pago', function(event) {
       var id = $("#cod_pago option:selected").val();
       $('#number_operation').val("");
       if (id == 2 || id == 9 || id == ""){
         $("#divoperacion").hide();
       }else{
         $("#divoperacion").show();
         $('#cont_voucher_pago').removeAttr("style",'display:none;');
       }
  });

//validar letras
function validaLetras(event) {
      if(event.charCode >= 65 && event.charCode <= 241 || event.charCode == 32 ){
        return true;
       }
       return false;
  }
  //al borar el dni borrar los daots
  var input_inv = $('#document');
  input_inv.on('keydown', function() {
    if(event.keyCode == 9){
    }else{
      var key = event.keyCode || event.charCode;
        $("#last_name").val("");
        $("#first_name").val("");
        $("#dni_inv").val("");
        $("#name_inv").val("");
        $("#lastname_inv").val("");
    }
  });
  //accion comprar
  function comprar()
  {
   var registrar = false;
   if (accionista == false){
     var validar = validarcustomer();
     if (validar == true){
        if ($("#cod_pago option:selected").val() != ""){
                if ($("#cod_pago option:selected").val() == 2 || $("#cod_pago option:selected").val() == 9){
                   registrar = true;
                }else if ($("#number_operation").val() != ""){

                         if ($("#bank").val() != ""){
                           if ($("#date_pay").val() != ""){
                             if ($("#voucher").val() != ""){
                               registrar = true;
                             }else{
                               alert('Falta seleccionar voucher de pago');
                               $("#voucher").focus();
                             }
                           }else{
                             alertify.alert('Cuidado!','Falta seleccionar la fecha!');
                             $("#date_pay").focus();
                           }

                         }else{
                           alertify.alert('Cuidado!','Falta seleccionar el banco');
                           $("#bank").focus();
                         }

                }else{
                  $("#number_operation").focus();
                  alertify.alert('Cuidado!','¡Falta completar codigo de operación!');
                }
        }else{
          alertify.alert('Cuidado!','Por favor, seleccione tipo de pago.');
          $("#cod_pago").focus();
        }
     }else{
       validar;
     }
   }else if (accionista == true && sponsorinv == true){
     if ($("#cod_pago option:selected").val() != ""){
           if ($("#cod_pago option:selected").val() == 2 || $("#cod_pago option:selected").val() == 9){
              registrar = true;
           }else if ($("#number_operation").val() == ""){
              alertify.alert('Cuidado!','¡Falta completar el código de operación!');
              $("#number_operation").focus();
           }else if ($("#bank").val() == ""){
               alertify.alert('Cuidado!','¡Falta seleccionar el banco!');
               $("#bank").focus();
           }else if ($("#date_pay").val() == ""){
             alertify.alert('Cuidado!','¡Falta completar fecha de pago!');
             $("#date_pay").focus();
           }else if ($("#voucher").val() == ""){
             alertify.alert('Cuidado!','Falta seleccionar voucher de pago');
             $("#voucher").focus();
           }else{
             registrar = true;
           }
     }else{
       alertify.alert('Cuidado!','Por favor, seleccione tipo de pago.');
       $("#cod_pago").focus();
     }
   }else{
     alertify.alert('Cuidado!','El patrocinador o sponsor debe estar registrado.');
     $("#dni_inv").focus();
   }

    $( "#document" ).prop( "disabled", false );
    $( "#first_name" ).prop( "disabled", false );
    $( "#last_name" ).prop( "disabled", false );
    $( "#phone" ).prop( "disabled", false );

    var dni = $('#document').val();
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var cod_country = $('#cod_country').val();
    var cod_state = $('#cod_state').val();
    var cod_city = $('#cod_city').val();
    var district = $('#district').val();
    var cod_product = $('#cod_product').attr("data-id");
    var id_price = $('#id_price').attr("data-id");
    var id_pay = $("#cod_pago option:selected").val();
    var nro_ope = $("#number_operation").val();
    var note = $("#note").val();
    var date_pay = $("#date_pay").val();
    var banck = $("#bank").val();

    var customer =
    {
      document:dni,
      first_name:first_name,
      last_name:last_name,
      phone:phone,
      email:email,
      id_country:cod_country,
      id_state:cod_state,
      id_city:cod_city,
      district:district,
      actulizar:false,
      note: note
    };

    var pay =
    {
      id_pay: id_pay,
      nro_ope: nro_ope,
      banck: banck,
      date_pay: date_pay
    }

    var product =
    {
      cod_product: cod_product,
      id_price: id_price
    };


    var dniInv = $('#dni_inv').val();

    var invitado =
    {
      document: dniInv,
      actulizar: actulizarinv
    };
    if(codigoPais != undefined){
      if (registrar == true){
        $.ajax(
          {
            url: "/customer/register/exeterno",
            type:"POST",
            data : {  customer: customer,invitado:invitado,product:product,pay:pay,codigoPais:codigoPais},
            dataType: "json",
          }).done(function(d)
          {
            if(upimg(d.id_ticket))
            {
              $('.loader-container').show(300);
              setTimeout(function() {
                window.location.href = "/checkout/ticket/"+d.id_ticket;
              }, 5000);
            }
          }).fail(function(error){
            $('.loader-container').hide(300);
            console.log(error);
            alert("No se registró, intente nuevamente por favor.");
          });
        }
    }else{
      alertify.alert('Por favor active la Ubicacion del navegador ').setHeader('<i class="fa fa-map-marker"></i><em> ESTA DESACTIVADO LA UBICACION EN EL NAVEGADOR </em> ');
    }
  }

redirec= $('#redirigir').attr("data-redi");

if(redirec == 1){
$('.loader-container').hide(300);
  alertify.alert('Compra registrada','La informacion de la compra se ha enviado a su correo electronico', function(){
    window.location.href = "/productos/acciones";  },).set({labels:{ok:'ok'}});
}

  function validarcustomer(){
    // alert($("#date_pay").val());

    if ($("#document").val() != ""){
      if ($("#first_name").val() != ""){
        if ($("#last_name").val() != ""){
          if ($("#phone").val() != ""){
             if ($("#email").val() != ""){
               if ($("#cod_country option:selected").val() != ""){
                 if ($("#cod_state option:selected").val() != ""){
                   if ($("#cod_city option:selected").val() != ""){
                     if ($("#district").val() != ""){
                       if($("#type_docu_inv").val() != ""){
                         if (sponsorinv == true){
                           return true;
                         }else{
                           alert('Falta completar el sponsor');
                           $("#dni_inv").focus();
                         }
                       }else{
                         alert('Falta seleccionar tipo de documento del sponsor');
                         $("#dni_inv").focus();
                       }
                     }else{
                       alert('!Falta completar la dirección!');
                       $("#district").focus();
                     }
                   }else{
                     alert('¡Falta indicar la provincia!');
                     $("#cod_city").focus();
                   }
                 }else{
                   alert('¡Falta indicar el departamento!');
                   $("#cod_state").focus();
                 }
               }else{
                 alert('¡Falta indicar el país!');
                 $("#cod_country").focus();
               }
             }else{
               alert('¡Falta completar su correo electrónico!');
               $("#email").focus();
             }
          }else{
            alert('¡Falta completar su teléfono!');
            $("#phone").focus();
          }
        }else{
          alert('¡Falta completar sus apellidos!');
          $("#last_name").focus();
        }
      }else{
        alert('¡Falta completar sus nombres!');
        $("#first_name").focus();
      }
    }else{
      alert('¡Falta completar su DNI!');
      $("#document").focus();
    }
  }

  fichero = document.getElementById("voucher");
  function upimg(id_ticket)
  {//inicio up img

    if($("#voucher").is(':visible'))
    {
      var respuesta = false;
      if (fichero.files.length >= 1){
        var metadata = {
          contentType: 'image/jpeg'
        };
      storageRef = firebase.storage().ref();
      var imagenASubir = fichero.files[0];
      var uploadTask = storageRef.child('imgPago/' + id_ticket).put(imagenASubir, metadata);
      uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
      function(snapshot){
      //se va mostrando el progreso de la subida de la imagenASubir
      var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
      console.log('Upload is ' + progress + '% done');

      }, function(error) {
        console.log('Ha ocurrido un inconveniente al tratar de subir la imágen '+error);
        //gestionar el error si se produce
        alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
      }, function() {
        //cuando se ha subido exitosamente la imagen
        pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
          var data = {
          'id_ticket': id_ticket,
          'voucherURL': downloadURL,
          'voucherName': imagenASubir.name};
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          $.ajax({
            url: "/tickets/imgSave",
            type:"POST",
            data : data,
            dataType: "json",
            beforeSend: function () {
              console.log("Esto es la data : "+data.voucherURL+" "+data.id_ticket+" "+data.voucherName);    },
          }).done(function(d){
            respuesta = true;
            console.log('exito '+downloadURL);
          }).fail(function(error){
            $('.loader-container').hide(300);
            console.log('No se enlazo la imágen con el ticket '+error);
            alert("No se enlazo la imágen con el ticket, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net");
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
  }
