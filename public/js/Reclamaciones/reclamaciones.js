$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

var idoffice;
$('#divcustomer').hide();
$("#divcountry").hide();
$("#divusuario").hide();
$("#divcountry").hide();
$("#typeincidentes").hide();
$('#prefpais').prop("disabled", true);

$(document).on('change', '#tipo', function(event) {
  if ($(this).val() == "Incidente" && $('#subject').val() == "Aplicativo"){
     $("#typeincidentes").show();
  }else{
    $("#typeincidentes").hide();
  }

  if ($(this).val() == "Queja" || $(this).val() == "Reclamo" && $('#subject').val() == "Aplicativo"){
     $("#typequejas").show();
  }else{
    $("#typequejas").hide();
  }
});

$(document).on('change', '#subject', function(event) {
  if ($('#tipo').val() == "Incidente" && $(this).val() == "Aplicativo"){
     $("#typeincidentes").show();
  }else{
    $("#typeincidentes").hide();
  }

  if ($('#tipo').val() == "Queja" || $('#tipo').val() == "Queja" && $(this).val() == "Aplicativo"){
     $("#typequejas").show();
  }else{
    $("#typequejas").hide();
  }

});

$(document).on('change', '#user', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/ofvalidate/user",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
    beforeSend: function () {
      $('#load_inv').show(30);
    },
  }).done(function(d){
    $('#load_inv').hide(30);

    if (d.object == "error"){
          alertify.notify('\u274C '+d.mensaje,d.object,2, function(){});
          alertify.notify('intenta nuevamente','error',2, function(){});
          $('#divcustomer').hide();
          $('#user').val("");
          $('#name').val("");
          $('#lastname').val("");
          $('#telefono').val("");
          $('#email').val("");
          idoffice = 0;
    }else{
          alertify.notify('\u2714 '+d.mensaje,d.object,2, function(){});
          countrys = d.datos.country;
          $('#divcustomer').hide();
          $('#name').val(d.datos.first_name);
          $('#lastname').val(d.datos.last_name);
            var tphone = d.datos.phone;
            if (countrys == "BO" || $('#group_id').val() == '43000602573'){
              if (tphone.length == 8){
                 $('#telefono').val(tphone);
              }else if (tphone.length == 11){
                $('#telefono').val(tphone.substring(3, 11));
              }else{
                 $('#telefono').val(tphone.substring(4, 12));
              }
            }else if (countrys == "EC" || $('#group_id').val() == '43000589488'){
              if (tphone.length == 9){
                 $('#telefono').val(tphone);
              }else if (tphone.length == 12){
                $('#telefono').val(tphone.substring(3, 12));
              }else{
                 $('#telefono').val(tphone.substring(4, 13));
              }
            }else if (countrys == "CO" || $('#group_id').val() == '43000578275'){
              if (tphone.length == 10){
                 $('#telefono').val(tphone);
              }else if (tphone.length == 12){
                $('#telefono').val(tphone.substring(2, 12));
              }else{
                 $('#telefono').val(tphone.substring(3, 13));
              }
            }else if (countrys == "MX" || $('#group_id').val() == '43000603572'){
              if (tphone.length == 10){
                 $('#telefono').val(tphone);
              }else if (tphone.length == 12){
                $('#telefono').val(tphone.substring(2, 12));
              }else{
                 $('#telefono').val(tphone.substring(3, 13));
              }
            }else{
              if (tphone.length == 9){
                 $('#telefono').val(tphone);
              }else if (tphone.length == 11){
                $('#telefono').val(tphone.substring(2, 11));
              }else{
                 $('#telefono').val(tphone.substring(3, 12));
              }
            }
          $('#email').val(d.datos.email);
          idoffice = d.datos.userid;
    }
  }).fail(function(error){
    console.log(error);
    $('#load_inv').hide(30);
    alert("No se registró, intente nuevamente por favor.");
  });
}
});


function registerticketfreshdesk(yourdomain,api_key)
{
      $('#btn-enviar').prop("disabled", true);
      $('#prefpais').prop("disabled", false);
      var prioridad;
      var subject;
      var description;

      if ($('#tipo').val() == 'Peticion'){
          prioridad = 4;
      }else if ($('#tipo').val() == "Incidente" && $('#subject').val() == "Aplicativo"){
          prioridad = 4;
      }else{
          prioridad = 3;
      }

      if ($('#tipo').val() == "Incidente" && $('#subject').val() == "Aplicativo"){
          subject = 'Incidencia App: '+$('#subject1').val()+' - '+$('#ctryname').val();
          description = "Rol: "+$('#tipocustomer').val()+'<br>'+"Sistema operativo: "+$('#so').val()+'<br>'+"Modelo: "+$('#model').val()+'<br>'+"Version del SO: "+$('#versionso').val()+'<br><br><br>'+"Descripcion: "+CKEDITOR.instances['description'].getData()+'<br><br><br>'+"Nombre Completo: "+$('#name').val()+' '+$('#lastname').val()+'<br>'+"Numero Telefonico: "+' '+$('#prefpais').val()+' '+$('#telefono').val()+'<br>'+"Correo Electronico: "+$('#email').val()+"<br>"+"Pais: "+$('#ctryname').val()+"<br>"+"Usuario: "+$('#user').val();
     }else if ($('#tipo').val() == "Queja" || $('#tipo').val() == "Reclamo" && $('#subject').val() == "Aplicativo"){
          subject = $('#subject').val()+' - '+$('#ctryname').val();
          description = CKEDITOR.instances['description'].getData()+'<br><br><br>'+"Nombre Completo: "+$('#name').val()+' '+$('#lastname').val()+'<br>'+"Numero Telefonico: "+' '+$('#prefpais').val()+' '+$('#telefono').val()+'<br>'+"Correo Electronico: "+$('#email').val()+"<br>"+"Pais: "+$('#ctryname').val()+"<br>"+"Usuario: "+$('#user').val()+"<br>"+"ID del viaje: "+$('#idtravel').val();
     } else {
          subject = $('#subject').val()+' - '+$('#ctryname').val();
          description = CKEDITOR.instances['description'].getData()+'<br><br><br>'+"Nombre Completo: "+$('#name').val()+' '+$('#lastname').val()+'<br>'+"Numero Telefonico: "+' '+$('#prefpais').val()+' '+$('#telefono').val()+'<br>'+"Correo Electronico: "+$('#email').val()+"<br>"+"Pais: "+$('#ctryname').val()+"<br>"+"Usuario: "+$('#user').val();
      }

      var formdata = new FormData();
      formdata.append('email', $('#email').val());
      formdata.append('name', $('#name').val());
      formdata.append('subject', subject);
      formdata.append('priority', prioridad);
      formdata.append('status', '2');
      if ($('#myFile').val() != "") {
        var array=[];
        for (var i = 0; i < $('#myFile')[0].files.length; i++) {
          formdata.append('attachments[]',$('#myFile')[0].files[i]);
        }
      }
      formdata.append('source', '2');
      formdata.append('phone', '+'+$('#prefpais').val()+$('#telefono').val());
      formdata.append('type', $('#tipo').val());
      formdata.append('group_id', $('#group_id').val());
      formdata.append('description', description);
      $.ajax(
          {
            url: "https://"+yourdomain+".freshdesk.com/api/v2/tickets",
            type: 'POST',
            contentType: false,
            processData: false,
            headers: {
              "Authorization": "Basic " + btoa(api_key + ":x")
            },
            data: formdata,
            beforeSend: function () {
		 $('#load_inv').show(30);
            },
            success: function(data, textStatus, jqXHR) {
              $('#result').text('Success');
              $('#code').text(jqXHR.status);
              $('#response').html(JSON.stringify(data, null, "<br/>"));

              $.ajax(
              {
                url: "/api/freshdesk",
                type:"POST",
                data : { id : data.id,
                        created_at        : data.created_at,
                        group_id          : data.group_id,
                        codigo            : $('#countryids').val(),
                        subject           : $("#subject").val() ,
                        email             : $("#email").val(),
                        telefono          : $("#telefono").val(),
                        description_text  : data.description_text,
                        due_by            : data.due_by,
                        fr_due_by         : data.fr_due_by,
                        date_register     : data.date_register,
                        type 		  : data.type,
                        priority          : data.priority,
                        source            : data.source,
                        name              : $("#name").val(),
                        lastname          : $('#lastname').val()
                      },

                dataType: "json",
                beforeSend: function () {
                }
              }).done(function(d){
                $('#load_inv').hide(30);
                alertify.alert('Su ticket ha sido registrado exitosamente con el número <b>#'+data.id+'</b>, será atendido dentro de un tiempo no máximo a 24 horas y se le enviará la  notificación al correo registrado <b>'+$('#email').val()+'</b>').setHeader('<h3 style="color: green; font-weight: bold;">Correcto \uD83D\uDDF9</h3>');
                $('#divcustomer').hide();
                $("#divcountry").hide();
                $("#divusuario").hide();
                $('#name').val("");
                $('#lastname').val("");
                $('#telefono').val("");
                $('#email').val("");
                $('#user').val("");
                $('#typeCustomer').val("");
                $('#tipocustomer').val("");
                $('#so').val("");
                $('#model').val("");
 	        $('#versionso').val("");
                $('#tipo').val("");
                $('#subject').val("");
                $("#typeincidentes").hide();
                CKEDITOR.instances.description.setData('');
                if ($('#myFile').val() != "") {
                  $('#myFile').val("");
                }
                $('#prefpais').prop("disabled", true);
                $('#btn-enviar').prop("disabled", false);

              }).fail(function(error){

             });
            },
            error: function(jqXHR, tranStatus) {
              $('#result').text('Error');
              $('#code').text(jqXHR.status);
              x_request_id = jqXHR.getResponseHeader('X-Request-Id');
              response_text = jqXHR.responseText;
              $('#response').html(" Error Message : <b style='color: red'>"+response_text+"</b>.<br/> Your X-Request-Id is : <b>" + x_request_id + "</b>. Please contact support@freshdesk.com with this id for more information.");
            }
          }
        );
}

function validateData(){
$('.error').html('');
$('.error').removeClass('alert alert-danger');
$('#prefpais').prop("disabled", false);
var desc = CKEDITOR.instances['description'].getData();
  if ($("#user").val() == ""){
    alertify.alert('Ingrese su usuario').setHeader('<h3 style="color: orange; font-weight: bold;">Alerta</h3>');
    $(".uservalidate").html('El campo usuario es requerido').css("color", "#FF0000");
    $('#user').focus();

  }else if ($("#tipo").val() == ""){
    alertify.alert('Ingrese el tipo de su solictud').setHeader('<h3 style="color: orange; font-weight: bold;">Alerta</h3>');
    $(".tipovalidate").html('El campo tipo de solicitud es requerido').css("color", "#FF0000");
    $('#tipo').focus();

  }else if ($("#subject").val() == ""){
    alertify.alert('Ingrese la categoria de su solictud').setHeader('<h3 style="color: orange; font-weight: bold;">Alerta</h3>');
    $(".motivovalidate").html('El campo categoria es requerido').css("color", "#FF0000");
    $('#subject').focus();

  }else if ($('#tipo').val() == "Incidente" && $('#subject').val() == "Aplicativo" && $("#tipocustomer").val() == ""){
    $(".tipocustomervalidate").html('El campo rol es requerido').css("color", "#FF0000");
    $('#tipocustomer').focus();

  }else if ($('#tipo').val() == "Incidente" && $('#subject').val() == "Aplicativo" && $("#subject1").val() == ""){
    $(".motivo1validate").html('El campo motivo de incidente es requerido').css("color", "#FF0000");
    $('#subject1').focus();

  }else if ($('#tipo').val() == "Incidente" && $('#subject').val() == "Aplicativo" && $("#so").val() == ""){
    $(".sovalidate").html('El campo sistema operativo es requerido').css("color", "#FF0000");
    $('#so').focus();

  }else if ($('#tipo').val() == "Incidente" && $('#subject').val() == "Aplicativo" && $("#model").val() == ""){
    $(".modelvalidate").html('El campo modelo es requerido').css("color", "#FF0000");
    $('#model').focus();

  }else if ($('#tipo').val() == "Incidente" && $('#subject').val() == "Aplicativo" && $("#versionso").val() == ""){
    $(".versionsovalidate").html('El campo version del sistema operativo es requerido').css("color", "#FF0000");
    $('#versionso').focus();

  }else if (desc == ""){
    alertify.alert('Ingrese el detalle del ticket').setHeader('<h3 style="color: orange; font-weight: bold;">Alerta</h3>');
    $(".descripvalidate").html('El campo detalle es requerido').css("color", "#FF0000");
  }else{
    $('#prefpais').prop("disabled", true);
    registerticketfreshdesk('wintecnologies','U2H7YQoww2UJsUykWAwh');
  }
}
