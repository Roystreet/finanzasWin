$('#phone').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g,'');
});

$('#nrodoc').on('input', function () {
    var op = $("#type_docs").val();
    if(op == 'DNI'){
      this.value = this.value.replace(/[^0-9]/g,'');
    }else{

    }
});

$("#type_docs").change(function(){
    $('#nrodoc').val("");
    $('#first_name').val('');
    $('#last_name').val('');
});


$("#btn_env").click(function() {
  var emailva = 1;
  var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
  if (regex.test($('#email').val().trim())) {
    emailva = 1;
  }else{
    emailva = 0;
  }

  if ($("#cod_country option:selected").val() == ""){
    alert('Falta completar pais');
    $("#cod_country").focus();
  }else if ($('#type_docs option:selected').val() == ""){
    alert("Seleccionar el tipo de documento de Identidad");
  }else if ($("#nrodoc").val() == ""){
    alert('Falta completar Numero de Documento de Identidad');
    $("#nrodoc").focus();
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
  }else if (emailva == 0){
    alert('La dirección de correo no es válida');
    $("#email").focus();
  }else {
    insert_value();
  }
});
var script_url = "https://script.google.com/macros/s/AKfycbz9pQ9c5tRZXX1-1onQUH3ikljUtrBTL-xlDYctVXI9drU5Beo/exec";

function insert_value() {
  var name =	$("#first_name").val().toUpperCase();
	var lastname = $("#last_name").val().toUpperCase();
  var countryid = $("#country").val();
  var tipodoc = $("#type_docs").val();
  var nrodoc = $('#nrodoc').val();
  var phone = $('#phone').val();
  var email = $('#email').val().toUpperCase();
  var url = script_url+"?callback=ctrlq&nombres="+name+"&apellidos="+lastname+"&countryid="+countryid+"&tipodoc="+tipodoc+"&nrodoc="+nrodoc+"&phone="+phone+"&email="+email;
    var request = jQuery.ajax({
        crossDomain: true,
        url: url ,
        method: "GET",
        dataType: "jsonp"
    });
      alertify.notify('Se confirmo correctamente!', 'success',2, function(){});
      //datos del customer
      $("#type_docs").val("").trigger('change');
      $('#nrodoc').val("");
      $('#first_name').val("");
      $('#last_name').val("");
      $('#phone').val("");
      $('#email').val("");
      $("#country").val("").trigger('change');
  }
