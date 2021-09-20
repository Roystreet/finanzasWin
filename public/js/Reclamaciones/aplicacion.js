$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

var idoffice;
$('#divcustomer').hide();
$("#divcountry").hide();
$("#divusuario").hide();
$("#divcountry").hide();
$('#prefpais').prop("disabled", true);
$('#categ').hide();
$(".t1").hide();
$(".t2").hide();
$(".t3").hide();
$(".t4").hide();
$(".t5").hide();
$('.typepqrs').hide();
var typet;
var typedesc;
$(".errorapp").click(function() {
  typet = $(this).attr("data-id");
  typedesc = $(this).attr("data-des");
  $('#form-documentos-driver').hide();
  $('#formfreshdeks').show();
  $(".t"+typet).show();
  if (typet == 1){
    $('#tipo').val('Incidente');
    $('#categ').show();
    $('.typepqrs').hide();
  }else if (typet != 1 && typet != 5){
    $('#tipo').val('Incidente');
    $('#categ').hide();
    $('.typepqrs').hide();
  }else{
    $('#tipo').val('');
    $('#categ').hide();
    $('.typepqrs').show();
  }
});


function registerticketfreshdesk(yourdomain,api_key)
{
      $('#prefpais').prop("disabled", false);
      var prioridad;
      if ($('#tipo').val() == 'Incidente'){
          prioridad = 4;
      }else{
          prioridad = 3;
      }

      var formdata = new FormData();
      formdata.append('email', $('#email').val());
      formdata.append('name', $('#name').val());
      formdata.append('subject', typedesc);
      formdata.append('priority', prioridad);
      formdata.append('status', '2');
      if ($('#myFile').val() != "") {
        var array=[];
        for (var i = 0; i < $('#myFile')[0].files.length; i++) {
          formdata.append('attachments[]',$('#myFile')[0].files[i]);
        }
      }
      formdata.append('type', $('#tipo').val());
      formdata.append('source', '2');
      formdata.append('phone', '+'+$('#prefpais').val()+$('#telefono').val());
      formdata.append('type', $('#tipo option:selected').text());
      formdata.append('group_id', $('#group_id').val());
      if (typet == 1){
        formdata.append('description',  "<b>Usuario quien tuvo el incidente</b>: "+'<br>'+"Usuario: "+$('#user').val()+"<br><b>Nombre Completo:</b>"+$('#name').val()+' '+$('#lastname').val()+'<br><b>'+"Numero Telefonico: </b>"+$('#telefono').val()+'<br>'+"<b>Correo Electronico:</b> "+$('#email').val()+"<br><b>"+"Pais:</b> "+$('#ctryname').val()+"<br>Sistema operativo: "+$('#so').val()+"<br>"+"Modelo del celular: "+$('#model').val()+"<br>"+"Version del sistema operativo: "+$('#versionso').val()+'<br><br>'+CKEDITOR.instances['description'].getData());
      }else{
        formdata.append('description', "<b>Nombre Completo:</b>"+$('#name').val()+' '+$('#lastname').val()+'<br><b>'+"Numero Telefonico: </b>"+$('#telefono').val()+'<br>'+"<b>Correo Electronico:</b> "+$('#email').val()+"<br><b>"+"Pais:</b> "+$('#ctryname').val()+'<br><br>'+CKEDITOR.instances['description'].getData());
      }
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
                        type 		          : data.type,
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
                $('#tipo').val("");
                $('#subject').val("");
                $('#so').val("");
                $('#model').val("");
                $('#versionso').val("");
                CKEDITOR.instances.description.setData('');
                if ($('#myFile').val() != "") {
                  $('#myFile').val("");
                }
                typet = '';
                typedesc = '';
                $('#categ').hide();
                $(".t1").hide();
                $(".t2").hide();
                $(".t3").hide();
                $(".t4").hide();
                $(".t5").hide();
                $('#prefpais').prop("disabled", true);
                $('#formfreshdeks').hide();
                $('#form-documentos-driver').show();
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
  var desc = CKEDITOR.instances['description'].getData();
  if ($("#user").val() == ""){
    alertify.alert('Ingrese su usuario').setHeader('<h3 style="color: orange; font-weight: bold;">Alerta</h3>');
    $(".uservalidate").html('El campo usuario es requerido').css("color", "#FF0000");
  }else if ($("#tipo").val() == ""){
    alertify.alert('Ingrese la categoria de sus solictud').setHeader('<h3 style="color: orange; font-weight: bold;">Alerta</h3>');
    $(".tipovalidate").html('El campo categoria es requerido').css("color", "#FF0000");
  }else if (desc == ""){
    alertify.alert('Ingrese el detalle del ticket').setHeader('<h3 style="color: orange; font-weight: bold;">Alerta</h3>');
    $(".descripvalidate").html('El campo detalle es requerido').css("color", "#FF0000");
  }else{
    $('#prefpais').prop("disabled", true);
    registerticketfreshdesk('wintecnologies','U2H7YQoww2UJsUykWAwh');
  }
}
