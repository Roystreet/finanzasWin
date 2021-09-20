$('#cont_voucher_pago').hide();
$('#cont_banks').hide();
$('.no').hide();
document.getElementById('codticket').disabled = true;
document.getElementById('cod_product').disabled = true;
document.getElementById('name_product').disabled = true;
document.getElementById('cant').disabled = true;
document.getElementById('price').disabled = true;
document.getElementById('total').disabled = true;
document.getElementById('money').disabled = true;
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
function mostrar(){
  $("#cont_voucher_pago").show();
}
$(document).ready(function() {
  $("#painvertir").select2();
  $("#country").select2();
  $("#state").select2();
  $("#city").select2();
  $("#tipago").select2();
  $("#idnameproduct").select2();

  $("#country").change(function(){
    $('#state').html('<option value=""> Seleccione la provincia donde reside ...</option>');
    $('#city').html('<option value=""> Seleccione la ciudad donde reside ...</option>');
    $.ajax({
      url: '/state/'+$(this).val(),
      method: 'GET',
      success: function(data) {
        $('#state').html(data.html);
      }
    });
  });

  $("#state").change(function(){
    $('#city').html('<option value=""> Seleccione la ciudad donde reside ...</option>');
    $.ajax({
      url: '/city/'+$(this).val(),
      method: 'GET',
      success: function(data) {
        $('#city').html(data.html);
      }
    });
  });
  $("#voucher").change(function(){
    var id_ticket=$("#id_ticket").val();
    upimg(id_ticket);

  });


var tipop = $("#tipago").val();
if(tipop == '6' || tipop =='5'|| tipop =='9'||tipop == '7'){
$(".no").show();
}
if(tipop == '4'||tipop == '1'){
$(".no").show();
$("#cont_banks").show();


}

if(tipop == '3'){
$(".no").show();
$("#cont_voucher_pago").show();
}
  $("#tipago").change(function(){
                  var op = $("#tipago option:selected").text();
                  if(op == "DEPÓSITO")
                  {
                    $('#textCodigoOperacion').html("Número de operación");
                    $('#cont_voucher_pago').removeAttr("style",'display:none;');
                    $('.no').removeAttr("style",'display:none;');
                    $('#cont_banks').removeAttr("style",'display:none;');
                    $("#numopera").attr("required", "true");
                    $("#id_banck").attr("required", "true");
                    $("#voucher").attr("required", "true");
                  }
                  else if(op == "POCKET")
                  {
                    $('#textCodigoOperacion').html("Número de operación");
                    $('#cont_voucher_pago').removeAttr("style",'display:none;');
                    $('#cont_banks').attr("style",'display:none;');
                    $("#numopera").attr("required", "true");
                    $("#voucher").attr("required", "true");
                    $("#id_banck").attr("required", "false");
                  }
                  else if(op == "TRANSFERENCIA")
                  {
                    $('#cont_banks').removeAttr("style",'display:none;');
                    $('#cont_voucher_pago').removeAttr("style",'display:none;');
                    $("#numopera").attr("required", "true");
                    $("#id_banck").attr("required", "true");
                    $("#voucher").attr("required", "true");
                  }
                  else if(op == "EFECTIVO")
                  {

                    $('.no').attr("style",'display:none;');
                    $('#cont_banks').attr("style",'display:none;');
                    $('#cont_voucher_pago').attr("style",'display:none;');
                    $("#numopera").attr("required", "false");
                    $("#id_banck").attr("required", "false");
                    $("#voucher").attr("required", "false");
                  }
                  else if(op == "CONTADO")
                  {
                    $('#cont_banks').attr("style",'display:none;');
                    $('.no').attr("style",'display:none;');
                    $('#cont_voucher_pago').attr("style",'display:none;');
                    $("#numopera").attr("required", "false");
                    $("#id_banck").attr("required", "false");
                    $("#voucher").attr("required", "false");
                  }
                  else if(op == "BITCOIN"){
                    $('#cont_banks').attr("style",'display:none;');
                    $('#textCodigoOperacion').html("Numero de operación");
                    $('.no').removeAttr("style",'display:none;');
                    $('#cont_voucher_pago').attr("style",'display:none;');
                    $("#numopera").attr("required", "true");
                    $("#id_banck").attr("required", "false");
                    $("#voucher").attr("required", "false");
                  }else{
                    $('#cont_banks').attr("style",'display:none;');
                    $('#textCodigoOperacion').html("Hash");
                    $('#tipago').removeAttr("onkeypress");
                    $('.no').removeAttr("style",'display:none;');
                    $('#cont_voucher_pago').attr("style",'display:none;');
                    $("#numopera").attr("required", "true");
                    $("#id_banck").attr("required", "false");
                    $("#voucher").attr("required", "false");
                  }
                  $('#numopera').val("");
          });


  $("#formticket").validate({

      rules: {

        fechapago:            {  required: true, date:true     },
        tipago:            {  required: true     },
        painvertir:            {  required: true     },
        firstname:            {  required: true     },
        lastname:            {  required: true     },
        phone:            {  required: true     },
        email:            {  required: true,  email: true      },
        country:            {  required: true     },
        state:            {  required: true     },
        address:            {  required: true     },
        id_banck:            {  required: true     },
        numopera:            {  required: true     },
        voucher:            {  required: true     },
        idnameproduct:            {  required: true     },



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

function selectproduct(id){
  var idp = id;

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax({
       type: "POST",
       url: "/ticket/editarTicket/product",
       type:"POST",
       data:{id : idp},
       dataType: "json",
       beforeSend: function () {
       },
     }).done(function(d){
       document.getElementById('cod_product').value = d.price.cod_product;
       document.getElementById('name_product').value = d.price.name_product;
       document.getElementById('cant').value = d.price.cant;
       document.getElementById('price').value = d.price.price;
       document.getElementById('total').value = d.price.price;
       document.getElementById('money').value = d.money == 1 ? 'PEN' : "USD"  ;
     }).fail(function(){
       alert("Error de producto");
     });
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
          alert('cargado!!');
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
