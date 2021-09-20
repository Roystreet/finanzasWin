var table;
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$(document).ready(function(){
  table =  $('#drivers').DataTable({
    'ajax': {
      'url': "/getDriverAprovedsView",
      'type':"GET",
    },
    'responsive'  : true,
    'autoWidth'   : false,
    'destroy'     : true,
    'language'    : {
    "decimal"     : "",
    "emptyTable"  : "No hay información",
    "info"        : "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty"   : "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    "infoPostFix" : "",
    "thousands"   : ",",
    "lengthMenu"  : "Mostrar _MENU_ Entradas",
    "loadingRecords" : "Cargando...",
    "processing"     : "Procesando...",
    "search"         : "Buscar:",
    "zeroRecords"    : "Sin resultados encontrados",
    "paginate"       : {
        "first"   : "Primero",
        "last"    : "Ultimo",
        "next"    : "Siguiente",
        "previous": "Anterior"
      }
    },
    "columns":[
      {data:"id_office"},
      {data:"dni"},
      {data:"first_name"},
      {data:"last_name"},
      {
         sortable: false,
         "render": function ( data, type, full, meta ) {
           return '<a  onclick="getDataProceso('+full.id_office+', '+full.id+')"><i class="glyphicon glyphicon-th-list"></i><a>';
          }
      },
      {data:"documentos",
        "render": function ( data, type, full, meta) {
        return data;

      }},
      {data:"vehiculo",
        "render": function ( data, type, full, meta) {
        return data;

      }},
      {data:"driver",
        "render": function ( data, type, full, meta) {
          return data;

      }},
      {data:"estatusapi",
        "render": function ( data, type, full, meta) {
        return data;

      }},
      {data:"migrado"}

    ],
    'columnDefs': [
      {
          "targets":0, // your case first column
          "className": "text-center",
     },
     {
         "targets":1, // your case first column
         "className": "text-center",
    },
     {
         "targets": 2 , // your case first column
         "className": "text-left",
    },
    {
         "targets": 3,
         "className": "text-left",
    },
    {
         "targets": 4,
         "className": "text-center",
    },
    {
         "targets": 5,
         "className": "text-center",
    },
    {
         "targets": 6,
         "className": "text-center",
    },
    {
         "targets": 7,
         "className": "text-center",
    },
    {
         "targets": 8,
         "className": "text-center",
    },
    {
         "targets": 9,
         "className": "text-center",
    }
    ],
});
});

//SUBIR DOCUMENTOS
function documentosUpload(id_office, id){
 $("#modal-cargando").modal('show');
  $.ajax({
    url: "/upDocumentos",
    type:"post",
    data:{id_office:id_office, id:id},
    beforeSend: function () {
    },
  }).done( function(d) {
    $("#modal-cargando").modal('hide');
    respuesta = d.flag;
    table.ajax.reload();
    if (respuesta == 'true'){
      alert(d.mensaje);
    }else{
      alert(d.mensaje);
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");    $("#modal-cargando").modal('hide'); }).always( function() {   });

}

//ENTRAMOS EN LA SECCION DEL DOCUMENTO
  function vehiculoGetForm(id_office, id){

    $('#serviceAreaList').val(null).trigger('change');
    $('#serviceTypeList').val(null).trigger('change');
    $('#vehicleTypeList').val(null).trigger('change');
    
    $(".datosSend").show();
    $(".waiting").hide();

    $.ajax({
      url: "/getModalValidate",
      type:"post",
      beforeSend: function () {
      },
    }).done( function(data) {

        //CAMPO 1
        var options1= "";
        $.each(data.serviceAreaList,function(key,value){
          options1+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
        });
        $("#serviceAreaList").find('option').remove().end().append(options1);

        //CAMPO 2
        var options2 = "";
        $.each(data.serviceTypeList,function(key,value){
          options2+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
        });
        $("#serviceTypeList").find('option').remove().end().append(options2);

        //CAMPO 2
        var options3 = "";
        $.each(data.vehicleTypeList,function(key,value){
          options3+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
        });
        $("#vehicleTypeList").find('option').remove().end().append(options3);


        $('#serviceAreaList').select2();
        $('#serviceTypeList').select2();
        $('#vehicleTypeList').select2();
        $('#tenantId').val(data.tenantId);
        $('#id_file_drivers_send').val(id);

        $('#serviceAreaList').val(null).trigger('change');
        $('#serviceTypeList').val(null).trigger('change');
        $('#vehicleTypeList').val(null).trigger('change');

        $("#modal-viewApiMeta").modal('show');


    }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
}

  function getDataSending(){

  var a = $('#serviceAreaList').val();
  var b = $('#serviceTypeList').val();
  var c = $('#vehicleTypeList').val();
  if (a && b && c){
    $(".datosSend").hide();
    $(".waiting").show();

    $.ajax({
      url: "/getDataSendingVehicle",
      type:"post",
      data:{ data : $("#formAprobar").serializeObject()},
      beforeSend: function () {
      },
    }).done( function(data) {
      table.ajax.reload();
      if(data.flag == 'true'){
        alert(data.mensaje);
        $("#modal-viewApiMeta").modal('hide');
      }
    }).fail( function() {   alert("Ocurrio un error en la operación"); $("#modal-viewApiMeta").modal('hide');  }).always( function() {  });
  }else {
    alert("DEBE RELLENAR TODOS LOS CAMPOS");
  }

}
//FIN DE LA SECCION DEL DOCUMENTO

function driverUpload(id_office, id){
  $("#modal-cargando").modal('show');
   $.ajax({
     url: "/upDriver",
     type:"post",
     data:{id_office:id_office, id:id},
     beforeSend: function () {
     },
   }).done( function(d) {
     $("#modal-cargando").modal('hide');
     respuesta = d.flag;
     table.ajax.reload();
     if (respuesta == 'true'){
       alert(d.mensaje);
     }else{
       alert(d.mensaje);
     }
   }).fail( function() {   alert("Ocurrio un error en la operación");    $("#modal-cargando").modal('hide'); }).always( function() {   });
}

function estatusUpload(id_office, id){
  $("#modal-cargando").modal('show');
   $.ajax({
     url: "/driverStatusApi",
     type:"POST",
     data:{id_office:id_office, id:id},
     beforeSend: function () {
     },
   }).done( function(d) {
     $("#modal-cargando").modal('hide');
     respuesta = d.flag;
     table.ajax.reload();
     if (respuesta == 'true'){
       alert(d.mensaje);
     }else{
       alert(d.mensaje);
     }
   }).fail( function() {   alert("Ocurrio un error en la operación");    $("#modal-cargando").modal('hide'); }).always( function() {   });
}


function validarDriverProceso(id_office,id, llave) {
  var respuesta;
  $('#id_file_drivers_send').val(id_office);
  $.ajax({
    url: "/validarDriverProceso",
    type:"post",
    data:{id_office:id_office},
    beforeSend: function () {
    },
  }).done( function(d) {
    console.log(d);
    respuesta = d.flag;
    if (respuesta == 'true'){
      switch(llave) {
        case 'documentos':
          documentosUpload(id_office, id);
        break;
        case 'vehiculos':
          vehiculoGetForm(id_office, id);
        break;
        case 'driver':
          driverUpload(id_office, id);
        break;
        default:
        alert("Ocurrio un error en la operación");
      }
    }else{
      alert(d.mensaje);
      alert('Aun no completa el proceso de validacion!');
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
}

//VER ESTA OPCION
function getModalValidate(){
  $.ajax({
    url: "/getModalValidate",
    type:"post",
    beforeSend: function () {
    },
  }).done( function(data) {

      //CAMPO 1
      var options1= "";
      $.each(data.serviceAreaList,function(key,value){
        options1+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
      });
      $("#serviceAreaList").find('option').remove().end().append(options1);

      //CAMPO 2
      var options2 = "";
      $.each(data.serviceTypeList,function(key,value){
        options2+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
      });
      $("#serviceTypeList").find('option').remove().end().append(options2);

      //CAMPO 2
      var options3 = "";
      $.each(data.vehicleTypeList,function(key,value){
        options3+='<option value="'+value["value"]+'">'+value["name"]+'</option>';
      });
      $("#vehicleTypeList").find('option').remove().end().append(options3);


      $('#serviceAreaList').select2();
      $('#serviceTypeList').select2();
      $('#vehicleTypeList').select2();
      $('#tenantId').val(data.tenantId);

      $('#serviceAreaList').val(null).trigger('change');
      $('#serviceTypeList').val(null).trigger('change');
      $('#vehicleTypeList').val(null).trigger('change');

      $("#modal-viewAprobarApi").modal('show');


  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
}

//VER HISTORICO
function getDataProceso(id){
  var table = $('#tableprocesoValidacion').DataTable();
  table.clear().draw();
  $.ajax({
    url: "/driver/externo/getDataProceso",
    type:"post",
    data:{ id:id},
    beforeSend: function () {
          },
  }).done( function(d) {
    if(d){

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
        "data": d,
        "columns":[
          {data:"get_proceso.nombre"},
          {data: "estatus_proceso",
            "render": function (data, type, row) {
            console.log(data);
            if (data === true) {
            return 'APROBADO';}  else {return 'RECHAZADO'};

          }},
          {data:"get_modify_by.username"},
          {data:"created_at"},
          {data:"updated_at"},
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
        ],
      });
      $("#modal-viewHistorico").modal('show');


    }else {
      alert("No hay ningun proceso hecho");
      $('#tableprocesoValidacion').DataTable().clear().draw();
    }

}).fail( function() {
alert("Ocurrio un error en la operación");
}).always( function() {
  });
}

//GET ARRAY FORM
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
