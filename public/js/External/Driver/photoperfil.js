var codigoproceso        = 4;
var estatusproceso       = 1;

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var driver = false;

$( "#btn_search" ).click(function() {
  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un ID.");
    $('#idoffice').css("border", "2px solid red");
  }
  else
  {
    validarProceso($("#idoffice").val(), 4);
  }

});

function validarProceso(id_office, idproceso){
  var respuesta;
  $.ajax({
    url: "/driver/externo/validarProceso",
    type:"post",
    data:{id_office:id_office, idproceso: idproceso},
    beforeSend: function () {
    },
  }).done( function(d) {
    respuesta = d;
    if (respuesta == 'true'){
      getUser();
    }else if (respuesta == 'false'){
      alert("El ID Oficina no existe!");
    }else{
      alert("El ID Oficina ya paso por este proceso!");
    }
  }).fail( function() {   alert("Ocurrio un error en la operación! por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");   }).always( function() {  });
  return respuesta;
}

function getUser(){
  valor = $('#idoffice').val();
  $.ajax(
    {
      url: "/users/exeterno/id/validate",
      type:"POST",
      data : { id : valor },
      dataType: "json",
      beforeSend: function () {
      $('#load_customer').show(300);
    }
    }).done(function(d)
    {
      console.log(d);
      $('#load_customer').hide(300);
      if(d.objet != "error")
      {
          //user
          iduser = d.data.id;
          $('.customer-data-hide').hide();
          if (d.data.first_name == "FALSO"){
            $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user" >');
          }else{
            $('#nameuser').html(d.data.first_name);
          }

          if (d.data.last_name == "FALSO"){
            $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" >');

          }else{
            $('#apeuser').html(d.data.last_name);

          }

          if (d.data.phone == "FALSO"){
            $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" >');

          }else{
            $('#phoneuser').html(d.data.phone);

          }

          if (d.data.email == "FALSO"){
            $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" >');

          }else{
            $('#emailuser').html(d.data.email);

          }
          //$('#btn_search').prop("disabled", true);
      } else {
        iduser = 0;
        $('#btn_search').attr("disabled", false);
        if (d.vali == 2){
          alert("El conductor no se encuentra registrado.");
        } else if (d.vali == 3){
          alert("El conductor no se ha registrado en el primer formulario.");
        }

        $('#idoffice').val("");
        $('#nameuser').html("");
        $('#apeuser').html("");
        $('#phoneuser').html("");
        $('#emailuser').html("");
      }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación! por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");
  });
}

function validateFileType(id){
    var fileName = document.getElementById(id).value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
    }else{
      alert("Solo se aceptan imágenes");
      $('#'+id).val("");
    }
}

$("#btn_ajax").click(function() {
    var photoperfil = document.getElementById("photo_perfil");

    if ($('#idoffice').val() == ""){
      alert('ingrese un id');
    }else if (iduser == 0){
      alert('ingrese un ID válido');
    }else if (photoperfil.files.length < 1){
      alert('Seleccione una foto de perfil');
    }else{
      register();
    }
});


function register(){
  $.ajax(
    {
      url: "/users/exeterno/perfilSave",
      type:"POST",
      data :{ users : $('#formfiledrivers').serializeObject(), iduser : iduser},
      dataType: "json",
    }).done(function(d)
    {
          upimg(d.idfile,'photo_perfil','16','4', codigoproceso , estatusproceso);
          $('#idoffice').val("");
          $('#nameuser').html("");
          $('#apeuser').html("");
          $('#phoneuser').html("");
          $('#emailuser').html("");
          $('#photo_perfil').val("");
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}



function upimg(idfiledriver,id,tipo,proceso,codigopro,statusproceso){
  var array = new Uint32Array(1);
  var aleatorio = window.crypto.getRandomValues(array);

  fichero = document.getElementById(id);

  var metadata = {
    contentType: 'image/jpeg'
  };
  storageRef = firebase.storage().ref();
  var imagenASubir = fichero.files[0];
  var uploadTask = storageRef.child('imgUsersDriver/Peru/'+aleatorio+''+imagenASubir.name).put(imagenASubir, metadata);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){
  //se va mostrando el progreso de la subida de la imagenASubir
  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
  $('#load_inv').show();
  if (progress == 100){
    alertify.notify('Se guardó la imágen correctamente', 'success', 3, function(){ });
    $('#load_inv').hide();
  }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
       data = {
      'id_file': idfiledriver,
      'voucherURL': downloadURL,
      'tipo' : tipo,
      'voucherName': imagenASubir.name,
      'proceso' : proceso,
      'codigoproceso' : codigopro,
      'estatusproceso' : statusproceso };

      $.ajax({
        type: "POST",
        url: "/users/exeterno/fileSave",
        data : data,
        dataType: "json",
      }).done(function(d){
        return  1;
      }).fail(function(error){
        console.log('No se enlaso la imagen con el ticket '+error);
        alert("No se enlazó la imágen, por favor intente de nuevo, si el problema persiste, por favor envíe una captura de pantalla al correo: sistemas@winhold.net para reportar el incidente y comuníquelo con su supervisor.");
        return  2;
      });
      });
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
