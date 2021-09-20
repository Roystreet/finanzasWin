$('.customer-data-hide').hide();
$('.driver-data-hide').hide();
$('.register-data').hide();
$('.customer-ext-data-hide').hide();
$('#checkticket').hide();
$('#status_user').select2();
$('#group').select2();
$('#cod_city').select2();
$('#cod_country').select2();
$('#cod_state').select2();
$('#regincidencias').hide();
$('#brand').select2();
$('#operator').select2();
$('#type_docs_ext').select2();
$('#type_docs').select2();
$('#category').select2();
$('#id_priority').select2();
$('.categoryDiv').hide();
$('#dni').prop("disabled", true);
$('#dni_ext').prop("disabled", true);
$('#search_customer').attr("style",'display:none;');
$('#search_customer_ext').attr("style",'display:none;');
$('.emergencyapp').hide();
$('#typeTK').select2();
$('#subject').prop("disabled", true);
$('#addthreeperson').hide();

var setval = 0;
var setcity = 0;
var typecustomerext = 0;
var idAtPren = 0;

  function addZero(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }

   var tdate = new Date();
   var horus = addZero(tdate.getHours());
   var minu = addZero(tdate.getMinutes());
   var seconds = addZero(tdate.getSeconds());
   var currentDate = horus+":"+minu+":"+seconds;

    var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };

    var tiempo_corriendo = null;

    function cronometro(){
            tiempo_corriendo = setInterval(function(){
                // Segundos
                tiempo.segundo++;
                if(tiempo.segundo >= 60)
                {
                    tiempo.segundo = 0;
                    tiempo.minuto++;
                }

                // Minutos
                if(tiempo.minuto >= 60)
                {
                    tiempo.minuto = 0;
                    tiempo.hora++;
                }

                $("#hour").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
                $("#minute").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
                $("#second").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
            }, 1000);
    };
    cronometro();

    let today = new Date(),
    day = today.getDate(),
    month = today.getMonth()+1, //January is 0
    year = today.getFullYear();
    mayoyear = (year - 18);
         if(day<10){
                day='0'+day
            }
        if(month<10){
            month='0'+month
        }
        today = mayoyear+'-'+month+'-'+day;
    $("#datebirth").attr({"max" : today});

var idcustomer;
var idcustomerext;
var incidencias;
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$("#type_docs").change(function(){
    $('#dni').val("");
    $('#first_name').prop("disabled", false);
    $('#last_name').prop("disabled", false);
    $('#first_name').val("");
    $('#last_name').val("");
    $('#datebirth').val("");
    $('#phone').val("");
    $('#email').val("");
    $("#cod_country").val("").change();
    $('#cod_state').val("").change();
    $('#cod_city').val("").change();
    $('#district').val("");
    idcustomer = null;
    $('.customer-data-hide').hide();
    $('.register-data').hide();
    $('.driver-data-hide').hide();
    $('#marca').val("");
    $('#placa').val("");
    $('#modelo').val("");
    $('#color').val("");
    $('#year').val("");
    $('#typesafe').val("");
    $('#company').val("");
    $('#typesoat').val("");
    $('#soatemi').val("");
    $('#soatven').val("");
    var op = $("#type_docs option:selected").text();
    if (op == 'Selecciona') {
      $('#dni').prop("disabled", true);
      $('#search_customer').attr("style",'display:none;');
    }else if (op == 'DNI'){
      $('#dni').prop("disabled", false);
      $('#search_customer').attr("style",'display:block;');
    }else{
      $('#dni').prop("disabled", false);
      $('#search_customer').attr("style",'display:block;');
    }
 });

 $("#type_docs_ext").change(function(){
     $('#dni_ext').val("");
     $('#first_name_ext').prop("disabled", false);
     $('#last_name_ext').prop("disabled", false);
     $('#first_name_ext').val('');
     $('#last_name_ext').val('');
     var op = $("#type_docs_ext option:selected").text();
     if (op == 'Selecciona') {
       $('#dni_ext').prop("disabled", true);
       $('#search_customer_ext').attr("style",'display:none;');
     }else if (op == 'DNI'){
       $('#dni_ext').prop("disabled", false);
       $('#search_customer_ext').attr("style",'display:block;');
     }else{
       $('#dni_ext').prop("disabled", false);
       $('#search_customer_ext').attr("style",'display:none;');
     }
  });

 $(document).on('change', '#category', function(event) {
      var idcat = $("#category option:selected").val();
      $('#optioncategory').empty();
      $.ajax(
        {
          url: "/atencion/getDescCategory",
          type: "POST",
          data : {  id: idcat},//
          dataType: "json",
        }).done(function(d)
        {
          $('#optioncategory').text(d.description);
          if (idcat == 6){
            $('#regincidencias').show();
            $('#regincidents').show();
            $('#regincidentsecurity').hide();
          }else{
            $('#regincidencias').hide();
            $('#regincidents').show();
            $('#regincidentsecurity').show();
          }
        }).fail(function(){
          alert("No trajo datos de categoria");//alerta del ticket no resgistrado
        });
 });

$(document).on('change', '#status_user', function(event) {
     var id = $("#status_user option:selected").val();
     idAtPren =  $('.atepren').attr("data-id");
     if (id == 9){
       $('#checkticket').show();
       $('#regincidencias').hide();
       $('.emergencyapp').hide();
       $('.groupsval').show();
       $('.categoryDiv').hide();
       $("#group").val("").change();
       $('#group').prop("disabled", false);
       $('#id_priority').prop("disabled", false);
       $('#addthreeperson').hide();
       $('.gestemerg').show();
       $('#regincidents').hide();
       $('#regincidentsecurity').hide();
       if (idAtPren > 0){
         $("#id_priority").val(4).change();
       }else{
         $("#id_priority").val("").change();
       }
     }else if ( id == 2){
       $("#group").val(4).change();
       $('#group').prop("disabled", true);
       $('#addthreeperson').show();
       $('.groupsval').show();
       $('#regincidencias').hide();
       $('#regincidents').hide();
       $('#regincidentsecurity').hide();
       $('#checkticket').hide();
       $('.emergencyapp').hide();
       $('.categoryDiv').show();
       $("#id_priority").val(4).change();
       $('#id_priority').prop("disabled", true);
       getCategory(id);
       $('.gestemerg').hide();
     }else if (id == 10){
       $('.emergencyapp').show();
       $('.categoryDiv').show();
       $('#regincidencias').hide();
       $('#regincidents').hide();
       $('#regincidentsecurity').hide();
       $('#checkticket').hide();
       $('.groupsval').hide();
       $("#group").val(11).change();
       $('#group').prop("disabled", true);
       $('.gestemerg').hide();
       $('#addthreeperson').show();
       $("#id_priority").val(4).change();
       $('#id_priority').prop("disabled", true);
       getCategory(id);
     }else{
       $('.emergencyapp').hide();
       $('#regincidencias').hide();
       $('#regincidents').hide();
       $('#regincidentsecurity').hide();
       $('#checkticket').hide();
       $('.groupsval').show();
       $('.categoryDiv').hide();
       $("#group").val("").change();
       $('#group').prop("disabled", false);
       $('#addthreeperson').hide();
       $('.gestemerg').show();
       if (idAtPren > 0){
         $("#id_priority").val(4).change();
         $('#id_priority').prop("disabled", true);
       }else{
         $("#id_priority").val("").change();
         $('#id_priority').prop("disabled", false);
       }
     }
});

function getCategory(id){
  $.ajax(
    {
      url: "/atencion/getCategoryForType",
      type: "POST",
      data : {  id: id},//
      dataType: "json",
    }).done(function(d)
    {
      $('#category').empty();
      $('#optioncategory').empty();
      var fila = '<option value="">Seleccionar</option>';
      $.each(d,function(key, registro)
      {
        fila += '<option value='+registro.id+'>'+registro.name+'</option>';
      });
      $("#category").append(fila);
    }).fail(function(){
      alert("No trajo datos de categoria");//alerta del ticket no resgistrado
    });
}

$( "#search_customer" ).click(function() {
  var d = $('#dni').val();
  if(d ==null || d =="")
  {
    alert("Ingrese de documento");
    $('#dni').css("border", "2px solid red");
  }
  else
  {
    getCustomer();
  }
});

$( "#search_customer_ext" ).click(function() {
  var d = $('#dni_ext').val();
  if(d ==null || d =="")
  {
    alert("Ingrese de documento");
    $('#dni_ext').css("border", "2px solid red");
  }
  else
  {
    getCustomerExt();
  }
});


$('#checkCustomerExt').on('click',function () {

        var ckbox = $('#checkCustomerExt');
        if (ckbox.is(':checked')) {
            $('.customer-ext-data-hide').show();
        } else {
            $('.customer-ext-data-hide').hide();
        }
});

$("#brand").on('change',function () {
  var valu = $(this).val();
  if (valu == 7){
    $("#OS2").prop("checked", true);
  }else{
    $("#OS1").prop("checked", true);
  }
});



$("#divRadios input[name='gestionado']").on('change',function () {
  $("#type_docs").val("").change();
  $('#dni').val("");
  $('#dni').prop("disabled", true);
  $('#search_customer').attr("style",'display:none;');
  $('#first_name').prop("disabled", false);
  $('#last_name').prop("disabled", false);
  $('#first_name').val("");
  $('#last_name').val("");
  $('#datebirth').val("");
  $('#phone').val("");
  $('#email').val("");
  $("#cod_country").val("").change();
  $('#cod_state').val("").change();
  $('#cod_city').val("").change();
  $('#district').val("");
  idcustomer = null;
  $('.customer-data-hide').hide();
  $('.register-data').hide();
  $('.driver-data-hide').hide();
  $('#marca').val("");
  $('#placa').val("");
  $('#modelo').val("");
  $('#color').val("");
  $('#year').val("");
  $('#typesafe').val("");
  $('#company').val("");
  $('#typesoat').val("");
  $('#soatemi').val("");
  $('#soatven').val("");
});



function getCustomer()
{
  valor = $('#dni').val();
  typedoc = $("#type_docs option:selected").val();
  typesearch = $('input:radio[name=gestionado]:checked').val();
  if (!$("#divRadios input[name='gestionado']").is(':checked')){
    alert("Seleccionar Gestionado");
  }else{
    $.ajax(
    {
      url: "/customer/register/driver/getVal",
      type:"POST",
      data : { dni: valor, type: typedoc, search: typesearch },//
      dataType: "json",
      beforeSend: function () {
                    $('#load_inv').show(300);
                  }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      typecustomer = d.type;
      alertify.notify(d.message, d.object ,2, function(){});
      if (d.portal == "reniec" && d.object == "success"){
          $('#first_name').val(d.data.first_name);
          $('#last_name').val(d.data.last_name);
          $('#datebirth').val(d.data.date_birth);
          $('#phone').val("");
          $('#email').val("");
          $("#cod_country").val("").change();
          $('#cod_state').val("").change();
          $('#cod_city').val("").change();
          $('#district').val("");
          idcustomer = 0;
          $('.customer-data-hide').show();
          $('.register-data').show();
      }else if (d.portal == "webpasajero" && d.object == "success" || d.portal == "webaccionista" && d.object == "success"){
          idcustomer = 0;
          $('#first_name').val(d.data.first_name);
          $('#last_name').val(d.data.last_name);
          $('#datebirth').val(d.data.date_birth);
          $('#email').val(d.data.email);
          $('#phone').val(d.data.phone);
          $('#idcust').val(d.data.id);
          $('#cod_country').val(d.data.country).trigger('change');
          setval = d.data.state;
          setcity = d.data.city;
          $('#district').val(d.data.address);
          $('.customer-data-hide').show();
          $('.register-data').show();
      }else if (d.portal == "interno" && d.object == "success"){
          $('.customer-data-hide').show();
          $('.register-data').show();
          //customer
          idcustomer = d.data.id;
          $('#first_name').val(d.data.first_name);
          $('#last_name').val(d.data.last_name);
          $('#datebirth').val(d.data.date_birth);
          $('#email').val(d.data.email);
          $('#phone').val(d.data.phone);
          $('#idcust').val(d.data.id);
          $("#cod_country").val(d.data.id_country).change();
          setval = d.data.id_state;
          setcity = d.data.id_city;
          $('#district').val(d.data.address);
          if (d.type == 2){
            $('.driver-data-hide').show();
            $('#marca').val(d.datacond.marca);
            $('#placa').val(d.datacond.placa);
            $('#modelo').val(d.datacond.model);
            $('#color').val(d.datacond.color_car);
            $('#year').val(d.datacond.year);
            $('#typesafe').val(d.datacond.type_safe);
            $('#company').val(d.datacond.enterprisesoat);
            $('#typesoat').val(d.datacond.type_soat);
            $('#soatemi').val(d.datacond.soatfecemi);
            $('#soatven').val(d.datacond.soatfecven);
          }else{
            $('.driver-data-hide').hide();
          }
      }else{
          $('#first_name').val("");
          $('#last_name').val("");
          $('#datebirth').val("");
          $('#phone').val("");
          $('#email').val("");
          $("#cod_country").val("").change();
          $('#cod_state').val("").change();
          $('#cod_city').val("").change();
          $('#district').val("");
          idcustomer = null;
          $('.customer-data-hide').hide();
          $('.register-data').hide();
          $('.driver-data-hide').hide();
          $('#marca').val("");
          $('#placa').val("");
          $('#modelo').val("");
          $('#color').val("");
          $('#year').val("");
          $('#typesafe').val("");
          $('#company').val("");
          $('#typesoat').val("");
          $('#soatemi').val("");
          $('#soatven').val("");

      }
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
  }
}//fin del customer

function getCustomerExt(){
  valorext = $('#dni_ext').val();
  typedocext = $("#type_docs_ext option:selected").val();
  typesearchext = "Nuevo";

  $.ajax(
  {
    url: "/customer/register/driver/getVal",
    type:"POST",
    data : { dni: valorext, type: typedocext, search: typesearchext },//
    dataType: "json",
    beforeSend: function () {
      $('#load_inv').show(300);
    }
  }).done(function(d)
  {
    $('#load_inv').hide(300);
    typecustomerext = d.type;
    alertify.notify(d.message, d.object ,2, function(){});
    if (d.portal == "reniec" && d.object == "success"){
        $('#first_name_ext').val(d.data.first_name);
        $('#last_name_ext').val(d.data.last_name);
        $('#datebirth_ext').val(d.data.date_birth);
        $('#phone_ext').val("");
        $('#email_ext').val("");
        idcustomerext = 0;
    }else if (d.portal == "interno" && d.object == "success"){
          //customer
          idcustomerext = d.data.id;
          $('#first_name_ext').val(d.data.first_name);
          $('#last_name_ext').val(d.data.last_name);
          $('#datebirth_ext').val(d.data.date_birth);
          $('#email_ext').val(d.data.email);
          $('#phone_ext').val(d.data.phone);
          $('#idcust_ext').val(d.data.id);
     }else{
       $('#first_name_ext').val("");
       $('#last_name_ext').val("");
       $('#datebirth_ext').val("");
       $('#phone_ext').val("");
       $('#email_ext').val("");
       idcustomerext = null;
     }
  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  });
}

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
         var fila = '<option value="">Seleccionar departamento</option>';
         $.each(d,function(key, registro)
         {
           fila += '<option value='+registro.id+'>'+registro.description+'</option>';
         });
         $("#cod_state").append(fila);
         if (setval > 0){
           $('#cod_state').val(setval).trigger('change');
         }

       }).fail(function(){
         alert("No trajo datos de los estados ");//alerta del ticket no resgistrado
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
         var filas = '<option value="">Seleccionar provincia</option>';
         $.each(d,function(key, registro)
         {
           filas += '<option value='+registro.id+'>'+registro.description+'</option>';

        });
          $("#cod_city").append(filas);
          if (setcity > 0){
            $('#cod_city').val(setcity).trigger('change');
          }
       }).fail(function(){
         alert("No se Registro Intente Nueva Mente");//alerta del ticket no resgistrado
       });
});


// var idgroup;
$("#group").on('change',function () {
    idgroup = $(this).val();
    $('#subject').val("");
    if (idgroup == ""){
      $('#subject').val("");
      $('#subject').prop("disabled", true);
    }else{
      $('#subject').prop("disabled", false);
      $('#subject').val("");
      $('#subject').typeahead({
              name : 'subject',
              remote : '/atencion/search/'+idgroup+'/%QUERY',
              limit : 10
      });
    }
});





$("#btn_env").click(function() {
  var ckbox = $('#checkCustomerExt');

  if ($("#status_user option:selected").val() == 2){
    incidencias = 1;
  }else{
    incidencias = 0;
  }

   if (!$("#divRadios input[name='gestionado']").is(':checked') && idAtPren < 1){
     alert("Seleccionar por quien se esta gestionando");
   }else if ($('#typeTK option:selected').val() == ""){
      alert("Seleccionar canal de gestion");
   }else if ($('#status_user option:selected').val() == ""){
      alert("Seleccionar el tipo");
    }else if ($('#status_user option:selected').val() != 10 && $("#group option:selected").val() == ""){
      alert("Seleccionar el area");
    }else if ($('#status_user option:selected').val() == 10 && $("#id_travel").val() == ""){
      alert("Indicar el ID del Viaje");
    }else if ($('#status_user option:selected').val() == 10 && $('#category option:selected').val() == ""){
      alert("Seleccionar la categoria");
    }else if ($('#type_docs option:selected').val() == ""){
      alert("Seleccionar el tipo de documento de Identidad");
    }else if ($("#dni").val() == ""){
      alert('Falta completar Numero de Documento de Identidad');
      $("#dni").focus();
    }else if ($("#first_name").val() == ""){
      alert('Falta completar Nombres');
      $("#first_name").focus();
    }else if ($("#last_name").val() == ""){
      alert('Falta completar Apellidos');
      $("#last_name").focus();
    }else if ($("#phone").val() == ""){
      alert('Falta completar Telefono');
      $("#phone").focus();
    }else if ($("#email").val() == ""){
      alert('Falta completar email');
      $("#email").focus();
    }else if ($("#cod_country option:selected").val() == ""){
      alert('Falta completar pais');
      $("#cod_country").focus();
    }else if ($("#cod_state option:selected").val() == ""){
      alert('Falta completar departamento');
      $("#cod_state").focus();
    }else if ($("#cod_city option:selected").val() == ""){
      alert('Falta completar provincia');
      $("#cod_city").focus();
    }else if ($("#district").val() == ""){
      alert('Falta completar direccion');
      $("#district").focus();
    }else if (ckbox.is(':checked') && $('#type_docs_ext option:selected').val() == ""){
      alert("Seleccionar el tipo de documento de Identidad");
    }else if (ckbox.is(':checked') && $("#dni_ext").val() == ""){
      alert('Falta completar Numero de Documento de Identidad');
      $("#dni_ext").focus();
    }else if (ckbox.is(':checked') && $("#first_name_ext").val() == ""){
      alert('Falta completar Nombres');
      $("#first_name_ext").focus();
    }else if (ckbox.is(':checked') && $("#last_name_ext").val() == ""){
      alert('Falta completar Apellidos');
      $("#last_name_ext").focus();
    }else if (ckbox.is(':checked') && $("#phone_ext").val() == ""){
      alert('Falta completar Telefono');
      $("#phone_ext").focus();
    }else if (ckbox.is(':checked') && $("#email_ext").val() == ""){
      alert('Falta completar email');
      $("#email_ext").focus();
    }else if ($('#subject').val() == "" && $("#status_user option:selected").val() != 10){
      alert("Ingresa un asunto");
      $("#subject").focus();
    }else if ($('#status_user option:selected').val() == 10 && $("#ubication").val() == ""){
      alert("buscar ubicacion");

    }else if(!$("#operator option:selected").val() && incidencias == 1){
      alert('Favor de seleccionar una opción de operador');
      $("#operator").focus();
    }else if(!$("input[name='appred']").is(':checked') && incidencias == 1){
      alert('Favor de seleccionar una opción de la pregunta');
      $("input[name='appred']").focus();

    }else if(!$("#brand option:selected").val() && incidencias == 1){
      alert('Favor de seleccionar una opción de marca del equipo');
      $("#brand").focus();

    }else if($("#model").val() == "" && incidencias == 1){
      alert('Favor de completar una opción de modelo del equipo');
      $("#model").focus();

    }else if(!$("input[name='OS']").is(':checked') && incidencias == 1){
      alert('Favor de seleccionar una opción de sistema operativo');
      $("input[name='OS']").focus();

    }else if ($('#veros').val() == "" && incidencias == 1) {
      alert("Ingresa una version del android");
      $("#veros").focus();

    }else if ($('#fechven').val() == "" && incidencias == 1) {
      alert("Ingresa una fecha del incidente");
      $("#fechven").focus();

    }else if ($('#hourven').val() == "" && incidencias == 1) {
      alert("Ingresa una hora del incidente");
      $("#hourven").focus();

    }else if ($('#description').val() == "") {
      alert("Ingresa una description o detalle");
      $("#description").focus();
     }else{
      registerticketfreshdesk();
    }


});


function registerticketfreshdesk()
{
  $('#subject').prop("disabled", false);
  $('#group').prop("disabled", false);
  $('#id_priority').prop("disabled", false);
  $('#dni').prop("disabled", false);
  clearInterval(tiempo_corriendo);
  var timereg = $("#hour").text()+':'+$("#minute").text()+':'+  $("#second").text();
  var formData = new FormData($("#myform")[0]);
  formData.append("idcustomer", idcustomer);
  formData.append("incidencias", incidencias);
  formData.append("timeregister", timereg);
  formData.append("timestaregister", currentDate);
  formData.append("typecustomer", typecustomer);
  formData.append("typecustomerext", typecustomerext);
  formData.append("idcustomerExt", idcustomerext);
  formData.append("idAtPren", idAtPren);
  $.ajax(
    {
      url: "/atencion/store",
      type:"POST",
      data : formData,
      processData: false,
      contentType: false,
      beforeSend: function () {
        $('.docs-example-modal-sm').modal('toggle');
            },
    }).done(function(d)
    {
      console.log(d);
      if(d.message)
      {
        alertify.notify('Se creo exitosamente el ticket!', 'success',2, function(){
           // if (idAtPren > 0){
           //   window.location.href = "/atencion/tickets/download/"+d.idtk;
           // }else{
           //   window.location.href = "/atencion/register";
           // }
        });
      //gestionado
      $("#divRadios input[name='gestionado']").prop('checked', false);

      //canal de gestion
      $("#typeTK").val("").trigger('change');

      //tipo
      $('#status_user').val("").trigger('change');

      //Prioridad
      $('#id_priority').val("").trigger('change');


      //checkticket
      $("input[name='checkticket']").prop('checked', false);


      //checkcustomerext
      $('.customer-ext-data-hide').hide();
      $("input[name='checkCustomerExt']").prop('checked', false);
      $("#type_docs_ext").val("").trigger('change');
      $('#dni_ext').val("");
      $('#first_name_ext').val("");
      $('#last_name_ext').val("");
      $('#datebirth_ext').val("");
      $('#phone_ext').val("");
      $('#email_ext').val("");
      $('#relationship').val("");

      //area
      $("#group").val("").trigger('change');

      //div del customer
      $('.customer-data-hide').hide();
      $('#register-data').hide();
      //datos del customer
      $("#type_docs").val("").trigger('change');
      $('#dni').val("");
      $('#first_name').val("");
      $('#last_name').val("");
      $('#phone').val("");
      $('#email').val("");
      $('#datebirth').val("");
      $("#cod_country").val("").trigger('change');
      $('#cod_state').val("").trigger('change');
      $('#cod_city').val("").trigger('change');
      $('#district').val("");
      //fin datos del customer

      $( "#subject" ).val("");
      $("#description" ).val("");
      $("#myFile").val(null);

      //tipo emergencia
      $("#id_travel" ).val("B0000");
      $('#category').empty();
      $("#addressgoogle" ).val("");
      $("#referenceubi" ).val("");
      $("#ubication" ).val("");

      //Tipo incidente
      $("#operator").val("").trigger('change');
      $("input[name='appred']").prop('checked', false);
      $("#brand").val("").trigger('change');
      $('#model').val("");
      $("input[name='OS']").prop('checked', false);
      $("#veros").val("");
      $("#fechven").val("");
      $("#hourven").val("");

      //tipo conductor
      $('.driver-data-hide').hide();
      $('#marca').val("");
      $('#placa').val("");
      $('#modelo').val("");
      $('#color').val("");
      $('#year').val("");
      $('#typesafe').val("");
      $('#company').val("");
      $('#typesoat').val("");
      $('#soatemi').val("");
      $('#soatven').val("");

      tdate = new Date();
      horus = addZero(tdate.getHours());
      minu = addZero(tdate.getMinutes());
      seconds = addZero(tdate.getSeconds());
      currentDate = horus+":"+minu+":"+seconds;
      tiempo = {
           hora: 0,
           minuto: 0,
           segundo: 0
       };
      tiempo_corriendo = null;
      cronometro();


    } else {
      alert("no se pudo enviar el ticket");
    }
    }).fail(function(d){
      console.log(d);//alerta del ticket no resgistrado
    });


}
