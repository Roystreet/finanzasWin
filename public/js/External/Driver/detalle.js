$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var id;
var data;
var id_tecnical;
var linckAntecendetes;
var id_user_office;
var linkRecord;
var tableprocess;

$( document ).ready(function() {
  id = $('#id').val();
  getData();
  getDataProceso(id);
});

$('#tableprocesoValidacion').DataTable({
  'responsive'  : true,
  'autoWidth': false,
  'destroy'   : true,
  'language': {
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar _MENU_ Entradas",
    "loadingRecords": "Cargando...",
    "processing": "Procesando...",
    "search": "Buscar:",
    "zeroRecords": "Sin resultados encontrados",
    "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
    }
  },
});

function getData(){
  $.ajax({
    url: "/driver/externo/get",
    type:"post",
    data:{dar:id,campo:"id_office"},
    beforeSend: function () {
          },
  }).done( function(d) {
    console.log(d);
    if(d.object == "success"){
      data              = d.data;
      id_tecnical       = d.data[0].get_tecnical.id;
      linckAntecendetes = d.data[0].url_antecedentes;
      linkRecord        = d.statusrecord;
      id_user_office    = data[0].get_user_office.id;

      $('#puntos').html(d.points);
      if(d.dataapi){
        $("#buttondesactivar").show();
        $("#buttonaprobar").hide();
        console.log(dataapi);
      }else{
        $("#buttondesactivar").hide();
        $("#buttonaprobar").show();
      }

    }else {

        alert(d.message);
      }

  }).fail( function() {
  alert("Ocurrio un error en la operación");
  }).always( function() {  });
}

function openFile(url) {
  if (url){
    abrirNuevoTab(url);
  }else{
        alert("No existe este archivo");
  }

}
// PROCESOS DEL CONDUCTOR
function getDataProceso(id){
  $.ajax({
    url: "/driver/externo/getDataProceso",
    type:"post",
    data:{ id:id},
    beforeSend: function () {
          },
  }).done( function(d) {
  var full = d;
  console.log(full);
    if(d){
      tableprocess = $('#tableprocesoValidacion').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
      'language': {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
      }
    },
    "data": d,
    "columns":[
      {data:"get_proceso.nombre"},
      {data: "estatus_proceso",
        "render": function (data, type, row) {
        console.log(data);
        if (data === true) {
        return '<i class="glyphicon glyphicon-ok-circle"></i>';}  else {return '<i class="glyphicon glyphicon-ban-circle"></i>'};

      }},
      {data:"get_modify_by.username"},
      {data:"created_at"},
      {data:"updated_at"},
      {data: "approved",
        "render": function (data, type, row) {
        if (data === true) {
          return '<a onclick="validarPermisos('+row.id_proceso_validacion+', 0, '+row.id_file_drivers+')"><i class="glyphicon glyphicon-ok-circle"></i><a>';
        }
        else {
          return '<a onclick="validarPermisos('+row.id_proceso_validacion+', 1, '+row.id_file_drivers+')"><i class="glyphicon glyphicon-ban-circle"></i><a>';

      }}},
      {data: "approved",
        "render": function (data, type, row) {
        if (data === true) {
          return '<p>Aprobado</p>';
        }
        else if (data === false) {
          return '<p>Desaprobado</p>';
        }else{
          return '<p>Falta aprobar o desaprobar</p>';
       }},
    }
    ],
    'columnDefs': [
     {
         "targets": 0, // your case first column
         "className": "text-center",
    },
    {
         "targets": 1,
         "className": "text-center",
    },
    {
         "targets": 2,
         "className": "text-center",
    },
    {
         "targets": 3,
         "className": "text-center",
    },
    {
         "targets": 4,
         "className": "text-center",
    },
    {
         "targets": 5,
         "className": "text-center",
    },
    ],

  });
    }else {
      alert("Ocurrio un error en la operación");
    }

}).fail( function() {
alert("Ocurrio un error en la operación");
}).always( function() {


  });}
//VALIDAR PERMISOS
function validarPermisos(id, estatus, idfiledrivers) {

  $.ajax({
    url: "/permisosProcessValid",
    type:"post",
    data:{
      id : id, estatus : estatus, idfiledrivers : idfiledrivers
    },
    beforeSend: function () {        },
    }).done( function(d) {
      id = $('#id').val();
      getDataProceso(id);
      alert(d.mensaje);
    }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });



}
//GESTION DE EDITAR
function editarButtonPersonal (id) {
  if ($('.verPersonal').is(':visible')) {
    $(".verPersonal").hide();
    $(".editarPersonal").show();
  } else {
    $(".verPersonal").show();
    $(".editarPersonal").hide();
  }
}
function editarButtonConductor(id) {

  if ($('.verConductor').is(':visible')) {
    $(".verConductor").hide();
    $(".editarConductor").show();

  } else {
    $(".verConductor").show();
    $(".editarConductor").hide();

  }
}
function editarButtonVehiculo (id) {

  if ($('.verVehiculo').is(':visible')) {
    $(".verVehiculo").hide();
    $(".editarVehiculo").show();

  } else {
    $(".verVehiculo").show();
    $(".editarVehiculo").hide();

  }
}
function editarButtonSeguro   (id) {

  if ($('.verSeguro').is(':visible')) {
    $(".verSeguro").hide();
    $(".editarSeguro").show();

  } else {
    $(".verSeguro").show();
    $(".editarSeguro").hide();

  }
}
// GETSION DE FOTOS
function viewModal            (div){
  limpiar();
  var driverid   = $("#driverid").val();
  var vehicleid  = $("#vehicleid").val();
  $("#buttonphoto").val('');
  $("#buttonphoto").val(div);
  $(".carusel").hide();
  $('#'+div).show();
  $('#mymodal').modal('show');
  switch (div) {

    case 'personal':
    var a = data[0].doc_front;
    var b = data[0].doc_back;
    if(a  === null || b === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(driverid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        $('#updbutton').hide().find('button').prop('disabled', true);
      }
    }
    break;
    case 'perfil':
    var a = data[0].photo_perfil;
    if(a  === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(driverid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");

        $('#updbutton').hide().find('button').prop('disabled', true);
      }
    }
    break;
    case 'conductor':
    var a = data[0].lic_frontal;
    var b = data[0].lic_back;
    if(a  === null || b === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(driverid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");

        $('#updbutton').hide().find('button').prop('disabled', true);
      }
    }
    break;
    case 'seguro':
    var a = data[0].soat_frontal;
    var b = data[0].soat_back;
    if(a  === null || b === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(vehicleid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");

        $('#updbutton').hide().find('button').prop('disabled', true);
      }
    }

    break;
    case 'vehiculo':
    var a = data[0].car_interna;
    var b = data[0].car_interna2;
    var d = data[0].car_externa;
    var e = data[0].car_externa2;
    var f = data[0].car_externa3;

    if(a  === null || b === null || c  === null || d === null  || e === null || f === null){
      $('#updbutton').hide().find('button').prop('disabled', true);
    }
    else {

      if(vehicleid === 'null'){
        $('#updbutton').show().find('button').prop('disabled', false);
      }else{
        alert("migrado");

        $('#updbutton').hide().find('button').prop('disabled', true);
      }
    }

    break;
    default:
    $('#updbutton').show().find('button').prop('disabled', false);
  }

  // if ((div ==='personal' || div === 'perfil' || div === 'condutor') && (driverid === 'null')){
  //   $('#updbutton').show().find('button').prop('disabled', false);
  // }else if ( (div ==='vehiculo' || div === 'seguro') && ( vehicleid === 'null') ){
  //   $('#updbutton').show().find('button').prop('disabled', false);
  // }else{
  //   $('#updbutton').hide().find('button').prop('disabled', true);
  // }

}
function verPhoto() {
  $('#modalupdphoto').modal('hide');
  var div = $("#buttonphoto").val();
  viewModal(div)
}
function limpiar () {
  $("#buttonphoto").val('');
  $("#doc_front").val('');  $("#doc_back").val('');
  $("#dni_frontal_cap").val('');  $("#dni_back_cap").val('');

  $("#lic_frontal").val('');  $("#lic_back").val('');
  $("#lic_frontal_cap").val('');  $("#lic_back_cap").val('');


  $("#car_interna").val('');  $("#car_interna2").val('');
  $("#car_externa").val('');  $("#car_externa2").val('');
  $("#car_externa3").val('');

  $("#car_interna_cap").val('');  $("#car_interna2_cap").val('');
  $("#car_externa_cap").val('');  $("#car_externa2_cap").val('');
  $("#car_externa3_cap").val('');

  $("#soat_frontal").val('');      $("#soat_back").val('');
  $("#soat_frontal_cap").val('');  $("#soat_back_cap").val('');

  $("#photo_perfil").val('');      $("#photo_perfil_cap").val('');



}
//GESTION DE GUARDAR
function guardarButton (id, form) {
  var dni   = $('[name=document]').val();
  var placa = $('[name=placa]').val();
  placa     = placa.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'');
  var tpdocuments =  $('[name=id_type_documents]').val();

  if      (form == 'formPersonal' &&  tpdocuments == 1 ){
    $("#personaltodo").hide();
    $("#personalcargando").show();
    $.ajax({
      url: "/customer/externo/reniecPeruValidate",
      type:"POST",
      data : { document: dni},
      dataType: "json",
    }).done(function(d){
      if (d.data.object){
        var apellido = d.data.last_name;
        var nombres  = d.data.first_name;

        if (d.data.last_name  =! null){  $('[name=last_name]' ).val(apellido);  }
        if (d.data.first_name =! null){  $('[name=first_name]').val(nombres);   }

        alert(d.data.message);
        sendData(id, form);
      }
    }).fail(function(error){    });
  }
  else if (form == 'formConductor' ){
    $("#conductortodo").hide();
    $("#conductorcargando").show();
    $.ajax({
      url: "/driver/externo/validatelice",
      type:"POST",
      data : { licencia : dni, tipodoc : tpdocuments},
      dataType: "json",
    }).done(function(d){
      if (d.object === 'success'){

        if (d.data != null){
          var licencia           = d.data.nrolicencia;
          var clasecategoria     = d.data.clasecategoria;
          var fechaemision       = d.data.fechaemision;
          var fecharevalidacion  = d.data.fecharevalidacion;

          $('[name=licencia]' ).val(licencia);
          $('[name=classcategoria]').val(clasecategoria);
          $('[name=licfecemi]').val(fechaemision.substr(6,4)+'-'+fechaemision.substr(3,2)+'-'+fechaemision.substr(0,2));
          $('[name=licfecven]').val(fecharevalidacion.substr(6,4)+'-'+fecharevalidacion.substr(3,2)+'-'+fecharevalidacion.substr(0,2));

        }
        alert(d.menssage);
      }else{
        alert(d.menssage);
        $('[name=licencia]').val('');
      }
      sendData(id, form);
    }).fail(function(error){    });

  }
  else if (form == 'formVehiculo'  ){
    $("#vehiculotodo").hide();
    $("#vehiculocargando").show();
    $.ajax({
      url: "/driver/externo/placaval",
      type:"POST",
      data : { placa : placa },
      dataType: "json",
    }).done(function(d){
      if (d.object === 'success'){
        alert(d.menssage);

        if (d.data != null){
          var color  = d.data.color;
          var marca  = d.data.marca;
          $('[name=color_car]' ).val(color);
          $('[name=marca]'     ).val(marca);
          $('[name=placa]'     ).val(placa);

        }

        sendData(id, form);
      }else{
        alert(d.menssage);
        $('[name=placa]').val('');
      }
    }).fail(function(error){    });

  }
  else if (form == 'formSeguro'  ){
    $("#segurotodo").hide();
    $("#segurocargando").show();
    $.ajax({
      url: "/apiSoatPlaca",
      type:"POST",
      data : { placa : placa },
      dataType: "json",
    }).done(function(d){
      if (d.object === 'sucesss'){
        alert(d.message);
        if (d.data != null){
          var enterprisesoat  = d.data.NombreCompania;
          var est_soat        = d.data.Estado;
          var soatfecemi      = d.data.FechaInicio;
          var soatfecven      = d.data.FechaFin;

          $('[name=enterprisesoat]' ).val(enterprisesoat);
          $('[name=est_soat]'       ).val(est_soat);
          $('[name=soatfecemi]').val(soatfecemi.substr(6,4)+'-'+soatfecemi.substr(3,2)+'-'+soatfecemi.substr(0,2));
          $('[name=soatfecven]').val(soatfecven.substr(6,4)+'-'+soatfecven.substr(3,2)+'-'+soatfecven.substr(0,2));
        }
        sendData(id, form);
      }else{
        $("#segurotodo").show();
        $("#segurocargando").hide();
        alert(d.message);
      }
    }).fail(function(error){    });

  }


}
function sendData      (id, form) {
  $.ajax({
    url: "/updateFormDriver",
    type:"post",
    data:{ data : $("#"+form).serializeObject() , id : id, form : form  },
    beforeSend: function () {
    },
  }).done( function(data) {
    if(data.flag == 'true'){
      alert(data.mensaje);
      if (data.observaciones != null){
        alert('Los campos acontinuación NO han sido ACTUALIZADOS\n\n'+data.observaciones);

      }
      location.reload(true);
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
}
//VER FORM DE UPDATE PHOTO
function updatePhotoButton (d){

  $('#mymodal').modal('hide');
  $(".caruselphoto").hide();
  var div;
  if (d != 'null'){
    div = d;
    $(".nophoto").hide();
    $("#buttonphoto").val(d);
  }
  else{    div = $("#buttonphoto").val();   }

  $('#'+div+'upd').show();
  $('#modalupdphoto').modal('show');
}
//UPDATE PHOTO
var ccimg;
function updatePhoto(id, alterno){
  ccimg = 0;
  var div = $("#buttonphoto").val();
  var driverid   = $("#driverid").val();
  var vehicleid  = $("#vehicleid").val();
  var mensaje    = "No podemos continuar con su solicitud este usuario ya ha sido migrado al aplicativo";

  switch(div) {
    case 'personal':
    if ( ($('#doc_front').get(0).files.length === 0) && ($('#doc_back').get(0).files.length === 0) ) {
      alert("No has cargado ningun archivo aun");
    }
    else{
      if  ($('#doc_front').get(0).files.length != 0) { ccimg++; }
      if  ($('#doc_back'   ).get(0).files.length != 0) { ccimg++; }

      if  ($('#doc_front').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'doc_front', 'doc_front', 'PERU', 3);  }
      if  ($('#doc_back').get(0).files.length    != 0) {upImgDni(id,'file_drivers', 'doc_back',   'doc_back',     'PERU', 3);  }
      $(".caruselphoto").hide();
      $("#cargando").show();
    }

    break;
    case 'condutor':
      if ( ($('#lic_frontal').get(0).files.length === 0) && ($('#lic_back').get(0).files.length === 0) ) {
        alert("No has cargado ningun archivo aun");
      }
      else{
        if  ($('#lic_frontal').get(0).files.length != 0) { ccimg++; }
        if  ($('#lic_back'   ).get(0).files.length != 0) { ccimg++; }

        if  ($('#lic_frontal').get(0).files.length != 0) { upImgDni(id,'file_drivers', 'lic_frontal', 'lic_frontal', 'PERU',3); }
        if  ($('#lic_back').get(0).files.length    != 0) { upImgDni(id,'file_drivers', 'lic_back',   'lic_back',     'PERU',3); }
        $(".caruselphoto").hide();
        $("#cargando").show();
      }


    break;
    case 'vehiculo':

      if ( ($('#car_interna').get(0).files.length  === 0) && ($('#car_interna2').get(0).files.length    === 0)
        && ($('#car_externa').get(0).files.length  === 0) && ($('#car_externa2').get(0).files.length    === 0)
        && ($('#car_externa3').get(0).files.length === 0) && ($('#tar_veh_frontal').get(0).files.length === 0)
        && ($('#tar_veh_back').get(0).files.length === 0)  ) {
        alert("No has cargado ningun archivo aun");
      }else{

        if  ($('#car_interna' ).get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_interna2').get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_externa' ).get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_externa2').get(0).files.length  != 0) {ccimg++;   }
        if  ($('#car_externa3').get(0).files.length  != 0) {ccimg++;   }
        if  ($('#tar_veh_frontal').get(0).files.length  != 0) {ccimg++; }
        if  ($('#tar_veh_back'   ).get(0).files.length  != 0) {ccimg++; }

        if  ($('#car_interna' ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_interna', 'car_interna', 'PERU',2);  }
        if  ($('#car_interna2').get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_interna2','car_interna2','PERU',2);  }
        if  ($('#car_externa' ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_externa', 'car_externa', 'PERU',2);  }
        if  ($('#car_externa2').get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_externa2','car_externa2','PERU',2);  }
        if  ($('#car_externa3').get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'car_externa3','car_externa3','PERU',2);  }

        if  ($('#tar_veh_frontal').get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'tar_veh_frontal','tar_veh_frontal','PERU', 3); }
        if  ($('#tar_veh_back'   ).get(0).files.length  != 0) {upImgDni(id,'file_drivers', 'tar_veh_back','tar_veh_back','PERU', 3);       }

        $(".caruselphoto").hide();
        $("#cargando").show();


        }


    break;
    case 'seguro':

      if ( ($('#soat_frontal').get(0).files.length === 0) && ($('#soat_back').get(0).files.length === 0) ) {
        alert("No has cargado ningun archivo aun");
      }else{
        if  ($('#soat_frontal').get(0).files.length != 0) { ccimg++; }
        if  ($('#soat_back'   ).get(0).files.length != 0) { ccimg++; }

          if  ($('#soat_frontal').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'soat_frontal', 'soat_frontal', 'PERU', 3); }
          if  ($('#soat_back').get(0).files.length    != 0) {upImgDni(id,'file_drivers', 'soat_back',   'soat_back',     'PERU', 3); }
          $(".caruselphoto").hide();
          $("#cargando").show();

        }


    break;
    case 'perfil':

      if ( ($('#photo_perfil').get(0).files.length === 0) ) {
        alert("No has cargado ningun archivo aun");
      }else{
        if  ($('#photo_perfil').get(0).files.length != 0) { ccimg++; }

        if  ($('#photo_perfil').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'photo_perfil', 'photo_perfil', 'PERU', 4);}
        $(".caruselphoto").hide();
        $("#cargando").show();

        }


    break;
    case 'antecedente':

      if ( ($('#url_antecedentes').get(0).files.length === 0) ) {
      alert("No has cargado ningun archivo aun");
      }else{

      if  ($('#url_antecedentes').get(0).files.length != 0) {upPdf(id,'file_drivers', 'url_antecedentes', 'url_antecedentes', 'PERU'); validarPermisos(5, true, id);}
      $(".caruselphoto").hide();
      $("#cargando").show();

      setTimeout(function(){
        $('#modalupdphoto').modal('hide');
        alert("Actualizado de forma correcta!");
        location.reload();
      }, 20000);
    }
    break;
    case 'revisiontecnica':
    if(id_tecnical){
      alert("No esta permitido!");
    }
    else{
      if ( ($('#revision_tecnica').get(0).files.length === 0) ) {
        alert("No has cargado ningun archivo aun");
      }else{
        if  ($('#revision_tecnica').get(0).files.length != 0) { ccimg++;  }
        if  ($('#revision_tecnica').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'revision_tecnica', 'revision_tecnica', 'PERU',1); }
        $(".caruselphoto").hide();
        $("#cargando").show();

      }

    }

    break;
    case 'reciboluz':

    if ( ($('#recibo_luz').get(0).files.length === 0) ) {
      alert("No has cargado ningun archivo aun");
    }else{
      if  ($('#recibo_luz').get(0).files.length != 0) { ccimg++;  }

      if  ($('#recibo_luz').get(0).files.length != 0) {upImgDni(id,'file_drivers', 'recibo_luz', 'recibo_luz', 'PERU',3); }
      $(".caruselphoto").hide();
      $("#cargando").show();

    }
    break;
    default:
    alert("Ocurrio un error en la operación");
  }

}
//SUBIENDO PHOTO
var ccimgup;
function upImgDni(id,table, idinput, nameFile, country, id_process_validacion){
  ccimgup = 0;

  var array     = new Uint32Array(1);
  var aleatorio = window.crypto.getRandomValues(array);
  var metadata  = {  contentType: 'image/jpeg'  };

  ficherodni       = document.getElementById(idinput);
  storageRef       = firebase.storage().ref();
  var imagenASubir = ficherodni.files[0];
  var uploadTask   = storageRef.child('imgUsersDriver/Pruebas/'+aleatorio+''+imagenASubir.name).put(imagenASubir, metadata);

  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,  function(snapshot){
    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    if (progress == 100){      alertify.notify('se guardo la imagen', 'success', 3, function(){ });   }

  }, function(error) {
    console.log('error '+error);
    alert('Ha ocurrido un inconveniente al tratar de subir la imágen, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
       data = {
          'id': id,
          'url': downloadURL,
          'name': nameFile,
          'table':table,
          'idinput':idinput,
          'voucherName': imagenASubir.name
        };

      $.ajax({
        url: "/driver/saveFile",
        type:"post",
        data:{
          data : data
        },
        beforeSend: function () {        },
        }).done( function(d) {

          if(d == 'true'){
            ccimgup++;

            if(ccimgup == ccimg){
                alert("Excelente, se registro correctamente.");
                validarPermisos(id_process_validacion, true, id);
                location.reload();
            }

          }

        }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });


      });
    });
}

function upPdf(id,table, idinput, nameFile, country){

  var array      = new Uint32Array(1);
  var aleatorio  = window.crypto.getRandomValues(array);
      fichero    = document.getElementById(idinput);
  var metadata   = {    contentType: 'pdf'  };
      storageRef = firebase.storage().ref();

  var imagenASubir = fichero.files[0];
  var uploadTask   = storageRef.child('imgUsersDriver/Peru/'+aleatorio+''+imagenASubir.name).put(imagenASubir);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){

    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    if (progress == 100){      alertify.notify('Registro exitoso', 'success', 3, function(){ });    }

  }, function(error) {
    console.log('error '+error);
    alert('Ha ocurrido un inconveniente al tratar de subir el documento, por favor intente de nuevo, si el problema persiste, por favor comuníquese con soporteusuario@winhold.net');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {

       data = {
        'id': id,
        'url': downloadURL,
        'name': nameFile,
        'table':table,
        'idinput':idinput,
        'voucherName': imagenASubir.name
      };

      $.ajax({
        url: "/driver/saveFile",
        type:"post",
        data:{
          data : data
        },
        beforeSend: function () {        },
        }).done( function(d) {     }).fail( function() {          alert("Ha ocurrido un error en la operación");        }).always( function() {       });

      });
    });
}

function fechaTecnicas(){
  if(id_tecnical==0)
  alert("No tiene revisión técnica.");
  else
   abrirNuevoTab("/driver/externo/rtpdf/"+id_tecnical);
}

function abrirNuevoTab(url) {
        // Abrir nuevo tab
        var win = window.open(url, '_blank');
        // Cambiar el foco al nuevo tab (punto opcional)
        win.focus();
}

function reporte(){
   abrirNuevoTab(url="/driver/externo/details/reporte/"+id);
}

function record(){
  if(linkRecord == false)
    alert("No tiene record.");
  else
  abrirNuevoTab(url="/driver/externo/report/record/"+id_user_office);
}

function revisiontecnica() {
  if(id_tecnical){
    window.location.href = "/driver/externo/rtpdf/"+id_tecnical;
  }else{
    alert("No posee REVISION TECNICA");
  }

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

$(document).on('change','.btn-file :file',function(){
  var input = $(this);
  var numFiles = input.get(0).files ? input.get(0).files.length : 1;
  var label = input.val().replace(/\\/g,'/').replace(/.*\//,'');
  input.trigger('fileselect',[numFiles,label]);
});

$(document).ready(function(){
  $('.btn-file :file').on('fileselect',function(event,numFiles,label){
    var input = $(this).parents('.input-group').find(':text');
    var log = numFiles > 1 ? numFiles + ' files selected' : label;
    if(input.length){ input.val(log); }else{ if (log) alert(log); }
  });
});
