$(document).ready(function(){
  disabledform();
  $('#form-registro').on('keyup','#usuario', function (e) {
    if(e.which == 13){
      var usuario = $(this).val();
      numdig = usuario.length;
      if (numdig > 5){
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      $.ajax(
        {
          url: "/red/valiteUsuario",
          type:"POST",
          data : {data: usuario},
          dataType: "json",
        }).done(function(d)
        {
         console.log(d.mensaje);
         if(!(jQuery.isEmptyObject(d.mensaje))){
             $('#usuario').css("border", "2px solid red");
         }else{
             $('#usuario').css("border", "2px solid green");
         }

         $('#usuario').focus();
        }).fail(function(){

        });
      }
    }
  });

  $(document).on('change', '#tipodoc', function(event) {
    var selects = $(this).val();
    if (selects != 0){
      $("#documento").removeAttr("disabled");
    }else{
      $('#documento').attr('disabled','disabled');
    }
  });

  $('#form-registro').on('click','.register-red', function () {
      if ($('#usuario_inv').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el usuario que invita', function(){
           $('#usuario_inv').focus();
           $("#usuario_inv").css({"border":"3px solid red"});
        });
      }else if ($('#usuario_inv').css('border') == "2px solid rgb(255, 0, 0)") {
        alertify.alert('Advertencia', 'El usuario no esta registrado', function(){
           $('#usuario_inv').focus();
           $("#usuario_inv").css({"border":"3px solid red"});
        });
      }else if ($('#tipodoc').val() == 0){
        alertify.alert('Advertencia', 'Falta seleccionar el tipo de documento', function(){
           $('#tipodoc').focus();
           $("#tipodoc").css({"border":"3px solid red"});
        });
      }else if ($('#documento').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el documento', function(){
           $('#documento').focus();
           $("#documento").css({"border":"3px solid red"});
        });
      }else if ($('#nombre').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el nombre', function(){
           $('#nombre').focus();
           $("#nombre").css({"border":"3px solid red"});
        });
      }else if ($('#apellidos').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el apellido', function(){
           $('#apellidos').focus();
           $("#apellidos").css({"border":"3px solid red"});
        });
      }else if ($('#correo').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el correo', function(){
           $('#correo').focus();
           $("#correo").css({"border":"3px solid red"});
        });
      }else if ($('#pais').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el pais', function(){
           $('#pais').focus();
           $("#pais").css({"border":"3px solid red"});
        });
      }else if ($('#departamento').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el departamento', function(){
           $('#departamento').focus();
           $("#departamento").css({"border":"3px solid red"});
        });
      }else if ($('#provincia').val() == ""){
        alertify.alert('Advertencia', 'Falta completar la provincia', function(){
           $('#provincia').focus();
           $("#provincia").css({"border":"3px solid red"});
        });
      }else if ($('#direccion').val() == ""){
        alertify.alert('Advertencia', 'Falta completar la direccion', function(){
           $('#direccion').focus();
           $("#direccion").css({"border":"3px solid red"});
        });
      }else if ($('#telefono').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el telefono', function(){
           $('#telefono').focus();
           $("#telefono").css({"border":"3px solid red"});
        });
      }else if ($('#usuario').val() == ""){
        alertify.alert('Advertencia', 'Falta completar el usuario', function(){
           $('#usuario').focus();
           $("#usuario").css({"border":"3px solid red"});
        });
      }else if ($('#usuario').css('border') == "2px solid rgb(255, 0, 0)") {
        alertify.alert('Advertencia', 'El usuario no esta disponible', function(){
           $('#usuario').focus();
           $("#usuario").css({"border":"3px solid red"});
        });
      }else if ($('#contraseña').val() == ""){
        alert($('#usuario').css('border'));
        alertify.alert('Advertencia', 'Falta completar la contraseña', function(){
           $('#contraseña').focus();
           $("#contraseña").css({"border":"3px solid red"});
        });
      }else{
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax(
          {
            url: "/usernet/save",
            type:"POST",
            data : {  customer : $('#form-registro').serializeObject() },//
            dataType: "json",
            beforeSend: function () {

            },
            }).done(function(d)
            {
              console.log(d.mensaje);
             alertify.alert('Registro', 'Se registro correctamente', function(){
               emptyForm();
               disabledform();
               $("#nom_usuario_inv").val('');
               $("#metod_sponsor").val('');
               $("#id_sponsor").val('');
               $("#usuario_inv").val('');
               $("#usuario").val('');
               $("#clave").val('');
               $("#documento").val('');
               $("#tipodoc").val(0);
               $("#usuario_inv").removeAttr('style');
               $("#usuario").removeAttr('style');
             });
            }).fail(function(){
              alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
            });
      }

  });



  $('#form-registro').on('keyup','#usuario_inv', function (e) {
    if(e.which == 13){
      var usuario_inv = $(this).val();
      userinvdig = usuario_inv.length;
      if (userinvdig > 5){
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      $.ajax(
        {
          url: "/red/valiteUsuario",
          type:"POST",
          data : {data: usuario_inv},
          dataType: "json",
        }).done(function(d)
        {

        if (d.data == 'bdwin'){
          $("#sponsorid").val(d.sponsor);
          $("#metod_sponsor").val(d.data);
        }else if (d.data == 'taxiwin') {
          $("#sponsorid").val(usuario_inv);
          $("#metod_sponsor").val(d.data);
        }

        if(!(jQuery.isEmptyObject(d.mensaje))){
             $('#usuario_inv').css("border", "2px solid green");
             $("#nom_usuario_inv").val(d.mensaje.first_name+' '+d.mensaje.last_name);
         }else{
             $('#usuario_inv').css("border", "2px solid red");
             $('#nom_usuario_inv').val('');
         }
         $('#usuario_inv').focus();
        }).fail(function(){

        });
      }
    }else if (e.which == 8){
      $("#nom_usuario_inv").val('');
      $("#metod_sponsor").val('');
      $("#id_sponsor").val('');
    }
  });



  $('#form-registro').on('keyup','#documento', function (e) {

        if(e.which == 13){
        var dni = $(this).val();
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax(
          {
            url: "/red/valiteCustomer",
            type:"POST",
            data : {data: dni},
            dataType: "json",
          }).done(function(d)
          {
            console.log(d.mensaje);
            if(!(jQuery.isEmptyObject(d.mensaje))){
              $("#nombre").val(d.mensaje.first_name);
              $('#apellidos').val(d.mensaje.last_name);
              $('#correo').val(d.mensaje.email);
              $('#pais').val(d.mensaje.country);
              $('#departamento').val(d.mensaje.state);
              $('#provincia').val(d.mensaje.city);
              $('#direccion').val(d.mensaje.adreess_1);
              $('#telefono').val(d.mensaje.phone);
              if (d.data == 'bdwin'){
                $("#id_customer").val(d.mensaje.id);
                $("#metod_customer").val(d.data);
              }else if (d.data == 'taxiwin' || d.data == 'winistoshare') {
                $("#id_customer").val(dni);
                $("#metod_customer").val(d.data);
              }
              disabledform();
            }else{
              $("#id_customer").val('');
              $("#metod_customer").val('');
                emptyForm();
            }
          }).fail(function(){

          });
        }else if (e.which == 8){
          emptyForm();
        }
    });
});

function disabledform(){
  $('#documento').attr('disabled','disabled');
  $('#nombre').attr('disabled','disabled');
  $('#apellidos').attr('disabled','disabled');
  $('#correo').attr('disabled','disabled');
  $('#pais').attr('disabled','disabled');
  $('#departamento').attr('disabled','disabled');
  $('#provincia').attr('disabled','disabled');
  $('#direccion').attr('disabled','disabled');
  $('#telefono').attr('disabled','disabled');
}


function emptyForm(){
  $('#nombre').val('');
  $('#apellidos').val('');
  $('#correo').val('');
  $('#pais').val('');
  $('#departamento').val('');
  $('#provincia').val('');
  $('#direccion').val('');
  $('#telefono').val('');
  $("#nombre").removeAttr("disabled");
  $('#apellidos').removeAttr("disabled");
  $('#correo').removeAttr("disabled");
  $('#pais').removeAttr("disabled");
  $('#departamento').removeAttr("disabled");
  $('#provincia').removeAttr("disabled");
  $('#direccion').removeAttr("disabled");
  $('#telefono').removeAttr("disabled");
};

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
