doc_frontvar codigoproceso        = 3;
var estatusproceso       = 1;
$('#document').prop("disabled", true);


$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var iduser = 0;
var dni = 0;
var licence = 0;

$( "#btn_search" ).click(function() {
  var d = $('#idoffice').val();
  if(d ==null || d =="")
  {
    alert("Por favor, ingrese un ID.");
    $('#idoffice').css("border", "2px solid red");
  }
  else
  {
    validarProceso($("#idoffice").val(), 3);
  }

});

$("#tipdocid").change(function(){
    $('#document').val("");
    $('#name-user').prop("disabled", false);
    $('#ape-user').prop("disabled", false);
    $('#name-user').val('');
    $('#ape-user').val('');
    var op = $("#tipdocid option:selected").text();
    if (op != 'SELECCIONAR') {
      $('#document').prop("disabled", false);
    }else{
      $('#document').prop("disabled", true);
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
      $('#load_customer').hide(300);
      if(d.objet != "error")
      {


          //user
          iduser = d.data.id;
          $('.customer-data-hide').hide();
          $('#nameuser').html('<input type="text" class="form-control" id="name-user" name="name-user" value="'+d.data.first_name+'">');
          $('#apeuser').html('<input type="text" class="form-control" id="ape-user" name="ape-user" value="'+d.data.last_name+'" >');
          if(d.data.phone != null)
          $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="'+d.data.phone+'">');
          else $('#phoneuser').html('<input type="text" class="form-control" id="phone-user" name="phone-user" value="">');
          if(d.data.email != null)
          $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="'+d.data.email+'">');
          else $('#emailuser').html('<input type="email" class="form-control" id="email-user" name="email-user" value="">');
          $('#yearfile').html('');

          if (d.data.document == null){
            $("#tipdocid").val("");
            $('#document').prop("disabled",false);
            $('#name-user').prop("disabled", false);
            $('#ape-user').prop("disabled", false);
            dni = 1;
          }else{
            dni = 0;
            $('#tipdocid').val(d.data.id_type_documents);
            $('#document').prop("disabled", true);
            $('#name-user').prop("disabled", true);
            $('#ape-user').prop("disabled", true);
            $('#document').val(d.data.document);
          }


          if (d.filemsj == "error"){
            var  fila = '<select class="form-control select2" id="year" name="year">';
            $.each({ v : "SELECCIONAR", v1 : "2009", v2 : "2010", v3 : "2011" , v4 : "2012", v5 : "2013", v6 : "2014", v7 : "2015", v7 : "2016", v8 : "2017", v9 : "2018" , v10 : "2019"}, function( k, v ) {
              fila += '<option>'+v+'</option>';
            });
            fila += '</select>';
            $('#yearfile').append(fila);
          }else{
              if (d.file.placa != null){
                $('#placa').val(d.file.placa);
                placa = 0;
              }else{
                placa = 1;
                $('#placa').val("");
              }

              if (d.file.year == null){
                var  filas = '<select class="form-control select2" id="year" name="year">';
                $.each({ v : "SELECCIONAR", v1 : "2009", v2 : "2010", v3 : "2011" , v4 : "2012", v5 : "2013", v6 : "2014", v7 : "2015", v7 : "2016", v8 : "2017", v9 : "2018" , v10 : "2019"}, function( k, v ) {
                  filas += '<option>'+v+'</option>';
                });
                filas += '</select>';
                $('#yearfile').append(filas);
              }else{
                $('#yearfile').html('<input type="text" class="form-control" id="year" name="year" value="'+d.file.year+'">');
              }

              if (d.file.licencia == null){
                $('#licencia').val("");
              }else{
                $('#licencia').val(d.file.licencia);
              }


              $("#div_doc_front").html("");
              $("#div_doc_back").html("");
              $("#div_lic-front").html("");
              $("#div_lic-back").html("");
              $("#div_tarj-vehi-front").html("");
              $("#div_tarj-vehi-back").html("");
              $("#div_soat-front").html("");
              $("#div_soat-back").html("");
              $("#div_recibo").html("");
              if (d.file.doc_front != null){
                $("#div_doc_front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_doc_front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.doc_back != null){
                $("#div_doc_back").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_doc_back").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.lic_frontal != null){
                $("#div_lic-front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_lic-front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.lic_back != null){
                $("#div_lic-back").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_lic-back").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.tar_veh_frontal != null){
                $("#div_tarj-vehi-front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_tarj-vehi-front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.tar_veh_back != null){
                $("#div_tarj-vehi-back").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_tarj-vehi-back").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.soat_frontal != null){
                $("#div_soat-front").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_soat-front").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.soat_back != null){
                $("#div_soat-back").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("#div_soat-back").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }

              if (d.file.recibo_luz != null){
                $("#div_recibo").html("<p style='color: green;'><b>Ya se subio este documento</b></p>");
              }else{
                $("div_#recibo").html("<p style='color: orange;'><b>Falta subir documento</b></p>");
              }
          }

          //$('#btn_search').prop("disabled", true);
      } else {
        iduser = 0;
        $('#btn_search').attr("disabled", false);
        $('#idoffice').val("");
        $('#nameuser').html("");
        $('#apeuser').html("");
        $('#phoneuser').html("");
        $('#emailuser').html("");
        $('#placa').val("");
        $('#licencia').val("");
        $('#year').val("");
        if (d.vali == 2){
          alert("El conductor no se encuentra registrado.");
        } else if (d.vali == 3){
          alert("El conductor no se ha registrado en el primer formulario.");
        }
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
        validatelicencia();
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
  }
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
        $("#licencia").val(d.data.nrolicencia);
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





var first_name;
var last_name;
var dni;
function getDataDni(){
dni =$('#dni_usuario').val()
    $.ajax(
    {
      url: "/customer/externo/reniecPeruValidate",
      type:"POST",
      data : { document:$('#dni_usuario').val() },
      dataType: "json",
    }).done(function(d){
      if (d.data.object){
        $('#apellido_dni').html(d.data.last_name);
        $('#nombre_dni').html(d.data.first_name);
        last_name = d.data.last_name;
        first_name = d.data.first_name;
        alert(d.data.message);
      }else{
      }
    }).fail(function(error){
      console.log(error);
      alert("La página de dni no esta disponible");
    });

};
var stateSave = false;
 function saveDNI(){

    $.ajax(
    {
      url: "/conductores/documentos/validate/save/dni",
      type:"POST",
      data : { id:iduser,last_name:last_name,first_name:first_name,document:dni },
      dataType: "json",
    }).done(function(d){
      if (d.object == "success"){
        alert(d.message);
        stateSave = true;
        alertify.closeAll();
        getUser();
      }else{
        alert(d.message);
      }
    }).fail(function(error){
      alert("Error al guardar");
    });

};


$("#btn_ajax").click(function() {
    if ($('#idoffice').val() == ""){
      alert('ingrese un id');
    }else if (iduser == 0) {
      alert('ingrese un id valido');
    }else  if ($("#tipdocid option:selected").text() == "SELECCIONAR"){
      alert('seleccione tipo de documento');
    }else  if ($('#document').val() == ""){
      alert('ingrese una numero de documento');
    }else if (dni == 1) {
      alert('el DNI ya existe');
    }else  if ($('#placa').val() == ""){
      alert('ingrese una placa');
    }else if (placa == 1) {
      alert('la placa ya existe o es invalida');
    }else  if ($("#year option:selected").text() == "SELECCIONAR"){
      alert('seleccione un año');
    }else if ($('#licencia').val() == ""){
      alert('ingrese licencia');
    }else if (licence == 1){
      alert('el numero de documento no tiene licencia');
    }else{
      register();
    }
});

function register(){
  $('#document').prop("disabled",false);
  $('#name-user').prop("disabled", false);
  $('#ape-user').prop("disabled", false);

  var dnifront = document.getElementById("dni-front");
  var dniback = document.getElementById("dni-back");
  var licfront = document.getElementById("lic-front");
  var licback  = document.getElementById("lic-back");
  var tarjvehifront = document.getElementById("tarj-vehi-front");
  var tarjvehiback = document.getElementById("tarj-vehi-back");
  var soatfront = document.getElementById("soat-front");
  var soatback = document.getElementById("soat-back");
  var reciboluz = document.getElementById("recibo");

  if (licfront.files.length < 1){
    alert('Queda pendiente subir licencia frontal');
  }

  if (licback.files.length < 1){
    alert('Queda pendiente subir licencia posterior');
  }

  if (tarjvehifront.files.length < 1){
    alert('Queda pendiente subir tarjeta vehicular frontal');
  }

  if (tarjvehiback.files.length < 1){
    alert('Queda pendiente subir tarjeta vehicular posterior');
  }

  if ($('#tarj-vehi-fec-emi').val() == ""){
    alert('Queda pendiente fecha de emision');
  }

  if (soatfront.files.length < 1){
    alert('Queda pendiente subir soat frontal');
  }

  if (soatback.files.length < 1){
    alert('Queda pendiente subir soat posterior');
  }

  if (dnifront.files.length < 1){
    alert('Queda pendiente subir DNI frontal');
  }

  if (dniback.files.length < 1){
    alert('Queda pendiente subir DNI Posterior');
  }

  $.ajax(
    {
      url: "/users/exeterno/register",
      type:"POST",
      data :{ users : $('#formfiledrivers').serializeObject(), iduser : iduser},
      dataType: "json",
    }).done(function(d)
    {
      $('#load_inv').show();
      var dnifront = document.getElementById("dni-front");
      var dniback = document.getElementById("dni-back");
      var licfront = document.getElementById("lic-front");
      var licback  = document.getElementById("lic-back");
      var tarjvehifront = document.getElementById("tarj-vehi-front");
      var tarjvehiback = document.getElementById("tarj-vehi-back");
      var soatfront = document.getElementById("soat-front");
      var soatback = document.getElementById("soat-back");
      var reciboluz = document.getElementById("recibo");
      var revision_ = document.getElementById("revision_tecnica");


      //licencia frontal
        if (licfront.files.length >= 1){
          cc++;
          upimg(d.idfile,'lic-front','1', '3' , codigoproceso , estatusproceso);

        }
      //licencia posterior
        if(licback.files.length >= 1){
          cc++;
      upimg(d.idfile,'lic-back','2', '3' , codigoproceso , estatusproceso);
    }
      //tarjeta vehicular frontal
      if(tarjvehifront.files.length >= 1){
        cc++;
      upimg(d.idfile,'tarj-vehi-front','3', '3' , codigoproceso , estatusproceso);
    }
      //tarjeta vehicular posterior
      if(tarjvehiback.files.length >= 1){
        cc++;
      upimg(d.idfile,'tarj-vehi-back','4', '3' , codigoproceso , estatusproceso);
    }
      //soat Frontal
      if(soatfront.files.length >= 1){
        cc++;
      upimg(d.idfile,'soat-front','5', '3' , codigoproceso , estatusproceso);
    }
      //soat posterior
      if(soatback.files.length >= 1){
        cc++;
      upimg(d.idfile,'soat-back','6', '3' , codigoproceso , estatusproceso);
    }
      if (revision_.files.length >= 1){
        //revision tecnica

        upimg(d.idfile,'revision_tecnica','7', '3' , codigoproceso , estatusproceso);
      }
      //dni frontal
      if (dnifront.files.length >= 1){
        cc++;
      upimg(d.idfile,'dni-front','12', '3' , codigoproceso , estatusproceso);
    }
    if (dniback.files.length >= 1){
      cc++;
      //dni posterior
      upimg(d.idfile,'dni-back','13', '3' , codigoproceso , estatusproceso);
    }
      //recibo
      if (reciboluz.files.length >= 1){
        cc++;
      upimg(d.idfile,'recibo','15', '3' , codigoproceso , estatusproceso);
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
var cc = 0;
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
  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;

  if (progress == 100){
    alertify.notify('se guardo la imagen', 'success', 3, function(){ });

  }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
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
        respuesta = true
        console.log('exito '+downloadURL);


        cantidadUpdateImg++;
        $('#cantidadSubidas').html("");
        $('#cantidadSubidas').html("Se subieron : "+cantidadUpdateImg+ "");
        if(cantidadUpdateImg>cc)
        {
          $("#cantidadSubidas").css("background-color", "#FFFF00");
        }
        if(cantidadUpdateImg == cc)
        {
          $("#cantidadSubidas").css("background-color", "#008000");
            alert("Excelente, se registro correctamente.");
            $('#load_inv').hide();
            location.reload();
        }

      }).fail(function(error){
        console.log('No se enlaso la imagen con el ticket '+error);
        alert("No se enlazo la imágen con el ticket, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net");
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
