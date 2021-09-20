var codigoproceso        = 2;
var estatusproceso       = 1;
$('#document').prop("disabled", true);
$('#placa').prop("maxlength", 6);

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var iduser = 0;
var fila = 0;
var dni = 0;
var phone = 0;
var email = 0;
$("#tipdocid").change(function(){
    $('#document').val("");
    var op = $("#tipdocid option:selected").text();
    if (op != 'SELECCIONAR') {
      $('#document').prop("disabled", false);
    }else{
      $('#document').prop("disabled", true);
    }
});

$(document).on('blur', '#document', function(event) {
  valnumid = $(this).val();
  tipdocids = $("#tipdocid option:selected").val();
  $.ajax(
  {
    url: "/driver/externo/dnival",
    type:"POST",
    data : { value : valnumid, tipdoc : tipdocids },
    dataType: "json",
  }).done(function(d){
    if (d.flag == true){
      dni = 1;
      alert(d.mensaje);
      $('#name-user').val("");
      $('#ape-user').val("");
    }else{
      dni = 0;
      getValDNI(valnumid);
    }

  }).fail(function(error){
    console.log(error);
    alert("No se registró, intente nuevamente por favor.");
  });
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
        $('#name-user').val(d.data.first_name);
        $('#ape-user').val(d.data.last_name);
        if (d.data.object == true){
          $('#name-user').prop("disabled", true);
          $('#ape-user').prop("disabled", true);
          $('#document').prop("disabled", true);
        }else{
          $('#name-user').prop("disabled", false);
          $('#ape-user').prop("disabled", false);
          $('#document').prop("disabled", false);
        }
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
  }
}

$(document).on('blur', '#phone-user', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/phoneval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
        $('#load_inv').hide();
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

$(document).on('blur', '#email-user', function(event) {
  if ($(this).val().length > 0){
  $.ajax(
  {
    url: "/driver/externo/emailval",
    type:"POST",
    data : { value : $(this).val() },
    dataType: "json",
    beforeSend: function () {
    $('#load_inv').show(30);
    }
  }).done(function(d){
        $('#load_inv').hide();
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


$( "#btn_search" ).click(function() {
  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un ID.");
    $('#idoffice').css("border", "2px solid red");
  }
  else
  {
    validarProceso($("#idoffice").val(), 2);
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
    console.log(d);
    respuesta = d;
    if (respuesta == 'true'){
      getUser();
    }else if (respuesta == 'false'){
      alert("El ID Oficina no existe!");
    }else{
      alert("El ID Oficina ya paso por este proceso!");
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
  return respuesta;
}

var placa = 0;
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
          $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user" value="'+d.data.first_name+'">');
          $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" value="'+d.data.last_name+'">');
          if(d.data.phone != null)
          $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="'+d.data.phone+'">');
          else $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="">');
          if(d.data.email != null)
          $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="'+d.data.email+'">');
          else $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="">');
          $('#document').val(d.data.document);
          if (d.data.document == null){
            $("#tipdocid").val("");
            $('#document').prop("disabled",false);
            $('#name-user').prop("disabled", false);
            $('#ape-user').prop("disabled", false);
          }else{
            $('#tipdocid').val(d.data.id_type_documents);
            $('#document').prop("disabled", true);
            $('#name-user').prop("disabled", true);
            $('#ape-user').prop("disabled", true);
          }

          $('#yearfile').html('');
          if (d.filemsj == "success"){
            if (d.file.placa != null){
              $('#placa').val(d.file.placa);
            }

            if (d.file.year == null){
              var  fila = '<select class="form-control select2" id="year" name="year">';
              $.each({ v : "SELECCIONAR", v1 : "2009", v2 : "2010", v3 : "2011" , v4 : "2012", v5 : "2013", v6 : "2014", v7 : "2015", v7 : "2016", v8 : "2017", v9 : "2018" , v10 : "2019"}, function( k, v ) {
                fila += '<option>'+v+'</option>';
              });
              fila += '</select>';
              $('#yearfile').append(fila);
            }else{
              $('#yearfile').html('<input type="text" class="form-control" id="year" name="year" value="'+d.file.year+'">');
            }
          }else{
            var  fila = '<select class="form-control select2" id="year" name="year">';
            $.each({ v : "Ingresar año", v1 : "2009", v2 : "2010", v3 : "2011" , v4 : "2012", v5 : "2013", v6 : "2014", v7 : "2015", v7 : "2016", v8 : "2017", v9 : "2018" , v10 : "2019"}, function( k, v ) {
              fila += '<option>'+v+'</option>';
            });
            fila += '</select>';
            $('#yearfile').append(fila);
            $('#placa').val("");
          }
          //$('#btn_search').prop("disabled", true);
      } else {
        iduser = 0;
        $('#btn_search').attr("disabled", false);
        alert("El conductor no se encuentra registrado.");
        $('#idoffice').val("");
        $('#nameuser').html("");
        $('#apeuser').html("");
        $('#phoneuser').html("");
        $('#emailuser').html("");
        $('#placa').val("");
        $('#document').val("");
        $('#year').val("");
      }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");
  });
}

$("#placa").keyup(function(){
  var val = $("#placa").val();
  if (val.length == 6){
    $.ajax(
    {
      url: "/driver/externo/placavalexi",
      type:"POST",
      data : { value : val },
      dataType: "json",
    }).done(function(d){
          console.log(d);
          if (d.flag == true){
            alert(d.mensaje);
            placa = 1;
          }else{
            placa = 0;
            validateplaca(val);
          }

    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
  }
});

function validateplaca(val) {
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
    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

$("#btn_ajax").click(function() {
    var carinterna1 = document.getElementById("carinterna1");
    var carinterna2 = document.getElementById("carinterna2");
    var carexterna1 = document.getElementById("carexterna1");
    var carexterna2 = document.getElementById("carexterna2");

    if ($('#idoffice').val() == ""){
      alert('ingrese un id');
    }else if (iduser == 0){
      alert('ingrese un id valido');
    }else  if ($('#phone-user').val() == ""){
      alert('Ingrese un telefono');
    }else if (phone == 1){
      alert('ingrese un telefono valido');
    }else  if ($('#email-user').val() == ""){
      alert('Ingrese un correo');
    }else if (email == 1){
      alert('ingrese un telefono valido');
    }else  if ($('#document').val() == ""){
      alert('ingrese dni');
    }else  if (dni == 1){
      alert('el documento de identidad ya existe');
    }else if ($('#placa').val() == ""){
      alert('ingrese una placa');
    }else if (placa == 1){
      alert('la placa ya existe o es invalida');
    }else  if ($("#year option:selected").text() == "SELECCIONAR"){
      alert('seleccione un año');
    }else if (carinterna1.files.length < 1){
      alert('seleccione la primera foto interna del auto');
    }else if (carinterna2.files.length < 1){
      alert('seleccione la segunda foto interna del auto');
    }else if (carexterna1.files.length < 1){
      alert('seleccione la primera foto externa del auto');
    }else if (carexterna2.files.length < 1){
      alert('seleccione la segunda foto externa del auto');
    }else{
      register();
    }
});

function register(){
  $('#document').prop("disabled",false);
  $('#name-user').prop("disabled", false);
  $('#ape-user').prop("disabled", false);
  $.ajax(
    {
      url: "/users/exeterno/register/docs",
      type:"POST",
      data :{ users : $('#formfiledrivers').serializeObject(), iduser : iduser},
      dataType: "json",
    }).done(function(d)
    {


      if(d.object == "success")
      {
        //1 foto car_interna
        upimg(d.idfile,'carinterna1','8', '2' , codigoproceso , estatusproceso);
        //2 foto car_interna
        upimg(d.idfile,'carinterna2','9', '2' , codigoproceso , estatusproceso);
        //1ra foto car_externa
        upimg(d.idfile,'carexterna1','10', '2' , codigoproceso , estatusproceso);
        //2da foto car_externa2
        upimg(d.idfile,'carexterna2','11', '2' , codigoproceso , estatusproceso);
        //2da foto car_externa2
        upimg(d.idfile,'carexterna3','14', '2' , codigoproceso , estatusproceso);

      }else{
        alert(d.menssage);
      }



    }).fail(function(error){
      console.log(error);
      alert("No se registró, intente nuevamente por favor.");
    });
}

function validateFileType(id){
    var fileName = document.getElementById(id).value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
    }else{
      alert("Solo se aceptan imagenes");
      $('#'+id).val("");
    }
}


var cantidadUpdateImg = 0;


function upimg(idfiledriver,id,tipo,proceso,codigopro,statusproceso){
  var array = new Uint32Array(1);
  var aleatorio = window.crypto.getRandomValues(array);

  fichero = document.getElementById(id);
  var metadata = {
    contentType: 'image/jpeg'
  };
  storageRef = firebase.storage().ref();
  var imagenASubir = fichero.files[0];
  var uploadTask = storageRef.child('imgUsersDriver/Pruebas/'+aleatorio+''+imagenASubir.name).put(imagenASubir, metadata);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){
  //se va mostrando el progreso de la subida de la imagenASubir
   progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
   if (progress == 100){
     alertify.notify('se guardo la imagen', 'success', 3, function(){ });

   }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net'+error);
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
      'estatusproceso' : statusproceso};




            $.ajax({
              type: "POST",
              url: "/users/exeterno/fileSave",
              data : data,
              dataType: "json",
            }).done(function(d){
              respuesta = true;
              console.log('exito '+downloadURL);

              cantidadUpdateImg++;
              $('#cantidadSubidas').html("");
              $('#cantidadSubidas').html("Se subieron : "+cantidadUpdateImg+ "");
              if(cantidadUpdateImg>5)
              {
                $("#cantidadSubidas").css("background-color", "#FFFF00");
              }
              if(cantidadUpdateImg == 5)
              {
                $("#cantidadSubidas").css("background-color", "#008000");
                  alert("Excelente, se registro correctamente.");
                  $('#load_inv').hide();
                  location.reload();
              }

            }).fail(function(error){
              console.log('No se enlaso la imagen con el ticket '+error);
              alert("No se enlazo la imágen con el ticket, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net"+error);
              respuesta = false;
            });
      });
    });
    return true;
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


var last_name;
var first_name;
var stateSave= false;
function getDataDni(){
dni =$('#dni_usuario').val()
    $.ajax(
    {
      url: "/customer/externo/reniecPeruValidate",
      type:"POST",
      data : { document:$('#dni_usuario').val() },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show();
      }
    }).done(function(d){
      $('#load_inv').hide();
      if (d.data.object){
        $('#apellido_dni').html(d.data.last_name);
        $('#nombre_dni').html(d.data.first_name);
        last_name = d.data.last_name;
        first_name = d.data.first_name;
        alert(d.data.message);
      }
    }).fail(function(error){
      console.log(error);
      alert("La página de dni no esta disponible");
    });

};

 function saveDNI(){

    $.ajax(
    {
      url: "/conductores/documentos/validate/save/dni",
      type:"POST",
      data : { id:iduser,last_name:last_name,first_name:first_name,document:dni },
      dataType: "json",
      beforeSend: function () {
      $('#load_inv').show();
    },
    }).done(function(d){
      if (d.object == "success"){
        alert(d.message);
        stateSave = true;
        alertify.closeAll();
        getUser();
      }else{
        alert(d.message);
      }
        $('#load_inv').hide();
    }).fail(function(error){
      alert("Error al guardar");
    });

};
