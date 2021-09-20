var codigoproceso        = 5;
var estatusproceso       = 1;
var dnival = 0;
$('#tipodoc').attr("style",'display:none;');

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var id;
 $("#ing").prop("disabled", true);
function getData()
{
  id_office = $('#idoffice').val();
  validarProceso(id_office, 5);
}
function getDataTrue(){
  id_office = $('#idoffice').val();
  $.ajax(
    {
      url: "/users/exeterno/id/validate",
      type:"POST",
      data : { id : id_office },
      dataType: "json",
      beforeSend: function () {
      $('#load_customer').show(300);
    }
    }).done(function(d)
    {
      console.log(d);
      $('#tipodoc').attr("style",'display:block;');
      $('#load_customer').hide(300);
      if(d.objet != "error")
      {
        $('#first_name').html('<input type="text" class="form-control" id="firstName-val" name="firstName-val" value="'+d.data.first_name+'">');
        $('#last_name').html('<input type="text" class="form-control" id="lastName-val" name="lastName-val" value="'+d.data.last_name+'">');
        $('#document').html('<input type="text" class="form-control" id="dni-val" name="dni-val" value="">');
        id = d.data.id;

        if (d.data.document == null){
          $("#tipdocid").val("");
          $('#dni-val').prop("disabled",false);
          $('#lastName-val').prop("disabled", false);
          $('#firstName-val').prop("disabled", false);
          dnival = 1;
        }else{
          dnival = 0;
          $('#tipdocid').val(d.data.id_type_documents);
          $('#dni-val').val(d.data.document);
          $('#dni-val').prop("disabled", true);
          $('#lastName-val').prop("disabled", true);
          $('#firstName-val').prop("disabled", true);

        }
      } else {
        iduser = 0;
        $('#btn_search').attr("disabled", false);
        $('#idoffice').val("");
        $('#first_name').html('<input type="text" class="form-control" id="lastName-val" name="lastName-val">');
        $('#last_name').html('<input type="text" class="form-control" id="firstName-val" name="firstName-val">');
        $('#document').html('<input type="text" class="form-control" id="dni-val" name="dni-val">');
      }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");
  });
}

$("#tipdocid").change(function(){
    $('#dni-val').val("");
    $('#firstName-val').prop("disabled", false);
    $('#lastName-val').prop("disabled", false);
    $('#firstName-val').val('');
    $('#lastName-val').val('');
    var op = $("#tipdocid option:selected").text();
    if (op != 'SELECCIONAR') {
      $('#dni-val').prop("disabled", false);
    }else{
      $('#dni-val').prop("disabled", true);
    }
});

$(document).on('blur', '#dni-val', function(event) {
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
      dnival = 1;
      alert(d.mensaje);
      $('#firstName-val').val("");
      $('#lastName-val').val("");
    }else{
      dnival = 0;
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
        $('#firstName-val').val(d.data.first_name);
        $('#lastName-val').val(d.data.last_name);
        if (d.data.object == true){
          $('#firstName-val').prop("disabled", true);
          $('#lastName-val').prop("disabled", true);
          $('#dni-val').prop("disabled", true);
        }else{
          $('#firstName-val').prop("disabled", false);
          $('#lastName-val').prop("disabled", false);
          $('#dni-val').prop("disabled", false);
        }
        validatelicencia();
      }).fail(function(){
        alert("error");//alerta del ticket no resgistrado
      });
  }
}

$('input[type="file"]').on('change', function(){
  var ext = $( this ).val().split('.').pop();
  if ($( this ).val() != '') {
    if(ext == "pdf"){
      if(false){
        console.log("El documento excede el tamaño máximo");
        $('#modal-title').text('¡Precaución!');
        $('#modal-msg').html("Se solicita un archivo no mayor a 1MB. Por favor verifica.");
        $("#modal-gral").modal();
        $(this).val('');
      }else{
        $("#modal-gral").hide();
      }
    }
    else
    {
      $( this ).val('');
      alert("Extensión no permitida: " + ext);
    }
  }
});

function registar(statusa)
{
  if ($('#idoffice').val() == ""){
    alert("Ingresar un ID de la oficina virtual");
  }else if ($('#dni-val').val() == ""){
    alert("Ingresar un numero de documento");
  }else if (dnival == 1){
    alert("El numero de documento esta vacio o ya existe");
  }else if (statusa == 1 && document.getElementById("file").files.length < 1){
    alert("Seleccionar un archivo para poder aprobar");
  }else if (statusa == 1 && document.getElementById("file").files.length > 0){
    upimg();
  }else{
    saveprocc();
  }
}

$("#file").on('change', function() {
    if ($('#file').val()) {
         $("#ing").prop("disabled", false);
    }
});

function saveprocc(){
  var dni = $('#dni-val').val();
  var firstName = $('#firstName-val').val();
  var lastName = $('#lastName-val').val();
  var tipodoc  = $('#tipdocid').val();

  var data = {
 'id': id,
 'voucherURL': "",
 'proceso'    : 5,
 'codigoproceso': codigoproceso,
 'estatusproceso': 0,
 'document' : dni,
 'first_name' : firstName,
 'last_name' : lastName,
 'tipo_doc' : tipodoc};

 $.ajax({
   type: "POST",
   url: "/driver/externo/upload",
   data : data,
   dataType: "json",
   beforeSend: function () {
   $('#load_inv').show(30);
   }
 }).done(function(d){
   id = null;
   $("#ing").prop("disabled", true);
   $('#idoffice').val("");
   $('#first_name').html("");
   $('#last_name').html("");
   $('#document').html("");
   $('#file').val("");
   $('#tipdocid').val("");
   $('#tipodoc').attr("style",'display:none;');
   $('#load_inv').hide();
   alertify.notify('Se desaprobo correctamente', 'success', 3, function(){ });
 }).fail(function(error){
   console.log('No se enlaso la imagen con el ticket '+error);
   alert("Error, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net");
   id = null;
   $("#ing").prop("disabled", true);
 });
}

function upimg(){

  var dni = $('#dni-val').val();
  var firstName = $('#firstName-val').val();
  var lastName = $('#lastName-val').val();
  var tipodoc  = $('#tipdocid').val();
  var array = new Uint32Array(1);
  var aleatorio = window.crypto.getRandomValues(array);

  fichero = document.getElementById("file");

  var metadata = {
    contentType: 'pdf'
  };
  storageRef = firebase.storage().ref();
  var imagenASubir = fichero.files[0];
  var uploadTask = storageRef.child('imgUsersDriver/Peru/'+aleatorio+''+imagenASubir.name).put(imagenASubir);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){
  //se va mostrando el progreso de la subida de la imagenASubir
  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
  $('#load_inv').show();
  if (progress == 100){
    alertify.notify('se guardo la imagen', 'success', 3, function(){ });
    $('#load_inv').hide();
  }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
       data = {
      'id': id,
      'voucherURL': downloadURL,
      'proceso'    : 5,
      'codigoproceso': codigoproceso,
      'estatusproceso': 1,
      'document' : dni,
      'first_name' : firstName,
      'last_name' : lastName,
      'tipo_doc' : tipodoc};

      $.ajax({
        type: "POST",
        url: "/driver/externo/upload",
        data : data,
        dataType: "json",
      }).done(function(d){
        id = null;
        $("#ing").prop("disabled", true);
        $('#idoffice').val("");
        $('#first_name').html("");
        $('#last_name').html("");
        $('#document').html("");
        $('#file').val("");
        $('#tipdocid').val("");
        $('#tipodoc').attr("style",'display:none;');
      }).fail(function(error){
        console.log('No se enlaso la imagen con el ticket '+error);
        alert("Error, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net");
        id = null;
        $("#ing").prop("disabled", true);
      });
      });
    });

}


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
      getDataTrue();
    }else if (respuesta == 'false'){
      alert("El ID Oficina no existe!");
    }else{
      alert("El ID Oficina ya paso por este proceso!");
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
  return respuesta;
}
