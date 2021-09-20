var codigoproceso        = 3;
var estatusproceso       = 1;
var placa = 0;
var idoffice = 0;
var dni = 0;
var phone = 0;
var email = 0;
var licence = 0;
var tipoid = 0;
$('#provincia').prop("disabled", true);
$('.numid').attr("style",'display:none;');

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$("#tipdocid").change(function(){
    $('#document').val("");
    $('#first_name').prop("disabled", false);
    $('#last_name').prop("disabled", false);
    $('#first_name').val('');
    $('#last_name').val('');
    var op = $("#tipdocid option:selected").text();
    if(op == 'DNI'){
      $('.numid').attr("style",'display:block;');
      $('#btn_search').attr("style",'display:block;');
      tipoid = 1;
    }else if (op != 'DNI' && op != 'SELECCIONAR') {
      $('.numid').attr("style",'display:block;');
      $('#btn_search').attr("style",'display:none;');
      tipoid = 0;
    }else{
      $('.numid').attr("style",'display:none;');
      tipoid = 0;
    }
});

function validateplaca() {
    val = $('#placa').val();
    $.ajax(
    {
      url: "/driver/externo/placaval",
      type:"POST",
      data : { placa : val },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.object == "success"){
        alert(d.menssage);
        placa = 0;
      }else{
        alert(d.menssage);
        placa = 1;
      }
      console.log(placa);
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

function validatelicencia(){
  val = $('#document').val();
  tipdocidv = $("#tipdocid option:selected").val();

  $.ajax(
  {
    url: "/driver/externo/validatelice",
    type:"POST",
    data : { licencia : val, tipodoc : tipdocidv},
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
    $('#load_inv').hide();
    if (d.object == "success"){
      alert(d.menssage);
      if (d.data.nrolicencia != null){
        $("#licence").val(d.data.nrolicencia);
      }
      licence = 0;
    }else{
      alert(d.menssage);
      licence = 1;
    }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
}

$(document).on('blur', '#idoffice', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/officeval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alertify.alert(d.mensaje).setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
          idoffice = 1;
        }else{
          idoffice = 0;
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
}
});

$(document).on('blur', '#document', function(event) {
  valnumid = $(this).val();
  tipdocids = $("#tipdocid option:selected").val();
  if (tipoid == 0 && valnumid != ""){
    $.ajax(
    {
      url: "/driver/externo/dnival",
      type:"POST",
      data : { value : valnumid , tipdoc : tipdocids},
      dataType: "json",
    }).done(function(d){
      if (d.flag == true){
        alert(d.mensaje);
        dni = 1;
      }else{
        dni = 0;
      }
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }
});

$(document).on('blur', '#phone', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/phoneval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alert(d.mensaje);
          phone = 1;
        }else{
          phone = 0;
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});

$(document).on('blur', '#licence', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/licencevalexi",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alert(d.mensaje);
          licence = 1;
        }else{
          licence = 0;
          validatelicencia();
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});


$(document).on('blur', '#email', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/emailval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alert(d.mensaje);
          email = 1;
        }else{
          email = 0;
        }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});

$(document).on('blur', '#placa', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/placavalexi",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
  }).done(function(d){
        if (d.flag == true){
          alert(d.mensaje);
          placa = 1;
        }else{
          placa = 0;
          validateplaca();
        }

  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
  }
});





$(document).on('keyup', '#document', function(event) {
  if(event.keyCode == 8){
    $("#first_name").val("");
    $("#last_name").val("");
  }
});



$("#btn_ajax").click(function() {
  if ($("#idoffice").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE ID OFICINA").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#idoffice").focus();
  }else if (idoffice == 1){
    alertify.alert("EL ID OFICINA YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#idoffice").focus();
  }else if (dni == 1){
    alertify.alert("EL DNI YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#document").focus();
  }else if (phone == 1){
    alertify.alert("EL TELEFONO YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#phone").focus();
  }else if (email == 1){
    alertify.alert("EL CORREO YA EXISTE").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#email").focus();
  }else if (placa == 1){
    alertify.alert("LA PLACA YA EXISTE O ES INCORRECTA").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#placa").focus();
  }else if (licence == 1){
    alertify.alert("LA LICENCIA YA EXISTE O ES INCORRECTA").setHeader('<h3 style="color: red; font-weight: bold;"> \u274C ¡Error! </h3>');
    $("#licence").focus();
  }else if ($("#sponsor").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE SPONSOR").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#sponsor").focus();
  }else if ($("#tipdocid option:selected").text() == "SELECCIONAR"){
    alertify.alert("SELECCIONAR TIPO DE DOCUMENTO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#tipdocid").focus();
  }else if ($("#document").val() == ''){
    alertify.alert("COMPLETE NUMERO DE DOCUMENTO DE IDENTIDAD").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#document").focus();
  }else if ($("#first_name").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE NOMBRES").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#first_name").focus();
  }else if ($("#last_name").val() == '') {
    alertify.alert("COMPLETE CAMPOS DE APELLIDOS").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#last_name").focus();
  }else if ($("#district").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE DIRECCION").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#district").focus();
  }else if  ($("#phone").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE TELEFONO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#phone").focus();
  }else if  ($("#email").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE CORREO").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#email").focus();
  }else if  ($("#licence").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE LICENCIA").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#licence").focus();
  }else if  ($("#placa").val() == ''){
    alertify.alert("COMPLETE CAMPOS DE PLACA").setHeader('<h3 style="color: orange; font-weight: bold;"> \u26A0 ¡Advertencia! </h3>');
    $("#placa").focus();
  }else{
    register();
  }
});

function validatedni(val){
  tipdocids = $("#tipdocid option:selected").val();
  $.ajax(
  {
    url: "/driver/externo/dnival",
    type:"POST",
    data : { value : val, tipdoc : tipdocids },
    dataType: "json",
  }).done(function(d){
    if (d.flag == true){
      dni = 1;
      alert(d.mensaje);
    }else{
      dni = 0;
      getValDNI(val);
    }
  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
}

$( "#btn_search" ).click(function() {
  var d = $('#document').val();
  validatedni(d);
});

function getValDNI(d){
    tipdocids = $("#tipdocid option:selected").val();
    if (tipdocids == 1){
    $.ajax(
      {
        url: "/customer/externo/reniecPeruValidate",
        type:"POST",
        data : {  document : d },//
        dataType: "json",
        beforeSend: function () {
        $('#load_inv').show(30);
        }
      }).done(function(d)
      {
        $('#load_inv').hide();
        alert(d.data.message);
        $('#first_name').val(d.data.first_name);
        $('#last_name').val(d.data.last_name);
        if (d.data.object == true){
          $('#first_name').prop("disabled", true);
          $('#last_name').prop("disabled", true);
        }else{
          $('#first_name').prop("disabled", false);
          $('#last_name').prop("disabled", false);
        }
        validatelicencia();
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
    }
}




function register(){
  $('#first_name').prop("disabled", false);
  $('#last_name').prop("disabled", false);
  $.ajax(
    {
      url: "/conductores/oficinaRegister",
      type:"POST",
      data :{ users : $('#formuseroffices').serializeObject()},
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show(30);
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.flag=='true'){
        alert(d.mensaje);
        location.reload(true);
      }
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}



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
