var codigoproceso        = 6;
var estatusproceso       = 1;
var table = $('#driver').DataTable();
var rolExterno;

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$('.carousel-example-generic').carousel();
$(document).ready(function(){
  $('#noinfraccion').change(function() {
    if(this.checked) {
        var returnVal = confirm("Estas seguro de que este usuario no posse infracciones?");
        $("#baprobado").val(true);
        $("#recordSum").val(0);
        $("#estatus").val('APROBADO');

    }else{
      $("#baprobado").val('');
      $("#recordSum").val('');
      $("#estatus").val('');

    }
    $('#noinfraccion').val(this.checked);
});

  var rol = getRol();
  if (rolExterno == 'true' ) {
    table.columns( [0,2] ).visible( false );
    table = $('#driver').DataTable();
  }

});
function getRol() {
  $.ajax({
    url: "/getRolValid",
    type:"get",
    beforeSend: function () {},
  }).done( function(d) {
    rolExterno= d;
  }).fail( function() {}).always( function() { });
}

function alldrivers(){
  table = $('#driver').DataTable({
  "ajax": {
         "url": "/driver/driverlist",
         "type": "GET",
         "dataType": 'json',
  },
  "order": [[ 12, "desc" ]],
  'autoWidth': true,
  'destroy'  : true,
  "scrollX"  : true,
  'buttons'  : [
    {
      'extend': 'pdf',
      'text': 'PDF',
      'messageBottom': null,
      'download': 'open',

    },

    {
      'extend': 'excel',
      'text' :   'EXCEL',
      'messageTop': null,

    },
    {   'extend': 'copy',
        'text': 'Copiar',

    },

    {
        'extend': 'print',
        'text' : 'Imprimir',
        'messageTop':null,
        'messageBottom': null,

    }
    ],
  'language' : {
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando START a END de TOTAL Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de MAX total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar MENU Entradas",
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
  "columns"  : [
      {data:"accion"},
      {data:"resumen"},
      {data:"reporte"},
      {data:"document"},
      {data:"id_office"},
      {data:"first_name"},
      {data:"last_name"},
      {data:"phone"},
      {data:"correo"},
      {data:"marca"},
      {data:"placa"},
      {data:"modelo"},
      {data:"estado"},
      {data:"date_create.date"},
      {data:"created.username"}
  ],
  "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

    $('td', nRow).css('font-weight', 'bold');
    if(aData.estado == "DESAPROBADO")
    {
      $('td', nRow).css('background-color', '#F1948A');
    }else if (aData.estado == "APROBADO") {
        $('td', nRow).css('background-color', '#ACF5B1');
    }else if (aData.estado == "EN EVALUACIÓN") {
    $('td', nRow).css('background-color', '#F9E79F');
    }else {
      $('td', nRow).css('background-color', '#D2B4DE');
    }

                  }


  });
  if (rolExterno == 'true' ) {
    table.columns( [0,2] ).visible( false );
  }
}

function buscar()
{
  // var dni = $('#dni_e').val();
  fillTable($('#off_e').val(),'id_office');
  // if(dni != "" || dni != null)
  // {
  //   alert(dni);
  //   //fillTable(dni,'dni');
  // }else {
  //   alert($('#off_e').val());
  //   //fillTable($('#off_e').val(),'id_office');
  // }
}





var idImpor;
function fillTable(dar,campo)//Inicio Fill
{
  $.ajax({
    url: "/driver/externo/get2",
    type:"post",
    data:{dar:dar,campo:campo},
    beforeSend: function () {
    },
  }).done( function(d) {
    $('#tbRecord').DataTable();
    $('#driver').DataTable();
    if(d.object == "success"){
      if(d.data.length > 0){
        idImpor = d.data[0].id_office;
      }else{
        idImpor = 0;
        alert('No tiene permisos,contactarse con el administrador');
      }

      $('#tbRecord').DataTable({
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


        table = $('#driver').DataTable({
        "order": [[ 12, "desc" ]],
        'autoWidth': true,
        'destroy'  : true,
        "scrollX"  : true,
        'buttons'  : [
          {
            'extend': 'pdf',
            'text': 'PDF',
            'messageBottom': null,
            'download': 'open',

          },

          {
            'extend': 'excel',
            'text' :   'EXCEL',
            'messageTop': null,

          },
          {   'extend': 'copy',
              'text': 'Copiar',

          },

          {
              'extend': 'print',
              'text' : 'Imprimir',
              'messageTop':null,
              'messageBottom': null,

          }
          ],
        'language' : {
          "decimal": "",
          "emptyTable": "No hay información",
          "info": "Mostrando START a END de TOTAL Entradas",
          "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
          "infoFiltered": "(Filtrado de MAX total entradas)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar MENU Entradas",
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
        "data": d.data,
        "columns"  : [
            {data:"accion"},
            {data:"resumen"},
            {data:"reporte"},
            {data:"document"},
            {data:"id_office"},
            {data:"first_name"},
            {data:"last_name"},
            {data:"phone"},
            {data:"correo"},
            {data:"marca"},
            {data:"placa"},
            {data:"modelo"},
            {data:"estado"},
            {data:"date_create.date"},
            {data:"created.username"}
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

          $('td', nRow).css('font-weight', 'bold');
          if(aData.estado == "DESAPROBADO")
          {
            $('td', nRow).css('background-color', '#F1948A');
          }else if (aData.estado == "APROBADO") {
              $('td', nRow).css('background-color', '#ACF5B1');
          }else if (aData.estado == "EN EVALUACIÓN") {
          $('td', nRow).css('background-color', '#F9E79F');
          }else {
            $('td', nRow).css('background-color', '#D2B4DE');
          }

                        }


        });
      if (rolExterno == 'true' ) {
        table.columns( [0,2] ).visible( false );
      }
    } else {
      $('#driver').DataTable();
      alert(d.message);
    }
  }).fail( function() {
    alert("Ocurrio un error en la operación");
  }).always( function() {


  });
}//fin de fillTable

//---------------------------------
//vieimg();
 var id;
function myFunction(elem) {
  id = elem;
  vieimg(elem);

}


function vieimg(id_s)
{
  $.ajax({
    url: "/driver/externo/get/img",
    type:"post",
    data:{id:id_s},
    beforeSend: function () {
          },
  }).done( function(d) {

    //$('.carousel-inner').html("");
    $("#placa").html(d.placa);
    $("#marca").html(d.marca);
    $("#model").html(d.model);
    $("#year").html(d.year);
     $('.carousel-inner').html(
      '<div class="item active" alt="Second slide">'+
          '<img src="'+d.car_externa+'">'+
          // '<div class="carousel-caption">'+
          //   'Externo'+
          // '</div>'+
        '</div>'+

        '<div class="item">'+
          '<img src="'+d.car_externa2+'" alt="Second slide">'+
          // '<div class="carousel-caption">'+
          //   'Externo'+
          // '</div>'+
        '</div>'+

        '<div class="item">'+
          '<img src="'+d.car_externa3+'" alt="Second slide">'+
          // '<div class="carousel-caption">'+
          //   'Externo'+
          // '</div>'+
        '</div>'+

        '<div class="item">'+
          '<img src="'+d.car_interna+'" alt="Second slide">'+
          // '<div class="carousel-caption">'+
          //   'Interna'+
          // '</div>'+
        '</div>'+

        '<div class="item">'+
          '<img src="'+d.car_interna2+'" alt="Second slide">'+
          // '<div class="carousel-caption">'+
          //   'Interna'+
          // '</div>'+
        '</div>'
  );

}).fail( function() {

}).always( function() {


  });
}


function actulizarStado(id_stado)
{
  $.ajax({
    url: "/driver/externo/updateObse",
    type:"post",
    data:{id:id, obs:$('#obser').val(),id_stado:id_stado},
    beforeSend: function () {
          },
  }).done( function(d) {

alert("Actualizado");
buscar();

}).fail( function() {

}).always( function() {


  });
}

//author:
//GLORIBEL DELGADO
//cerrar modal7
$("#modal-viewRecord").on('hidden.bs.modal', function () {
  limpiar();
});
function limpiar(){
  $( "#barra" ).removeClass( 'progress-bar-green' );
  $( "#barra" ).removeClass( 'progress-bar-yellow' );
  $( "#barra" ).removeClass( 'progress-bar-red' );

  $( "#barram" ).removeClass( 'progress-bar-green' );
  $( "#barram" ).removeClass( 'progress-bar-yellow' );
  $( "#barram" ).removeClass( 'progress-bar-red' );

  $("#recordSum").val('');
  $("#estatus").val('');
  $("#baprobado").val('');
  $("#estatushtml").empty();
  $("#estatushtmlm").empty();
  var table = $('#tbRecord').DataTable();
  table.clear().draw();
  $("#apidiv").hide();
  $("#iframediv").hide();
  $("#buttons").hide();
}

//add or delete columns
$('#addRow').click();
var t = $('#tbRecordManual').DataTable({ 'responsive'  : true,
  'autoWidth': false,
  'destroy'   : true,
  "bPaginate": false,
  "bLengthChange": false,
  "bFilter": true,
  "bInfo": false,
  "bAutoWidth": false,
  "searching": false
});
var c = 1;
$('#addRow').on( 'click', function () {
        t.row.add( [
            '<input name="aEntidad[]"          id="aEntidad_'+c+'"            minlength="3"  maxlength="20"  pattern="[A-Za-z0-9]+" required class="form-control form-control-sm" style="width: 100%"  type="text">',
            '<input name="aNro_Papeleta[]"     id="aNro_Papeleta_'+c+'"       minlength="3"  maxlength="20"  pattern="[A-Za-z0-9]+" required class="form-control form-control-sm" style="width: 100%"  type="text">',
            '<input name="aFecha_Infraccion[]" id="aFecha_Infraccion_'+c+'"   minlength="10" maxlength="10"  pattern="[A-Za-z0-9]+" required class="form-control form-control-sm" style="width: 100%"  type="date">',
            '<input name="aCod_Falta[]"        id="aCod_Falta_'+c+'"          minlength="3"  maxlength="8"   pattern="[A-Za-z0-9]+" required class="form-control form-control-sm" style="width: 100%"  type="text">',
            '<input name="aPuntos_Firmes[]"    id="aPuntos_Firmes_'+c+'"      minlength="2"  maxlength="3"   pattern="[A-Za-z0-9]+" required class="form-control form-control-sm ptosValid" style="width: 100%"  type="text">',
             '<button class="btn btn-primary fa  fa-trash-o del"></button>',
        ] ).draw( false );
});
$('#tbRecordManual').on('click', 'td button', function(){
  t.row($(this).closest('tr')).remove().draw();

});
//fin


//GESTION CARGA DE PTOS
$(document).on('change', '.ptosValid', function() {
  var sum = 0;
  $('.ptosValid').each(function(){
    sum += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
  });
  console.log($(this).val());
  $("#recordSumM").val(sum);
  $("#recordSum").val(sum);

  $.ajax({
    url: "/record/driver/getRecordRango",
    type:"post",
    data:{ sum:$("#recordSumM").val() },
    beforeSend: function () {
    },
  }).done( function(d) {
    // alert(d);
    $( "#barra" ).removeClass( 'progress-bar-green' );
    $( "#barra" ).removeClass( 'progress-bar-yellow' );
    $( "#barra" ).removeClass( 'progress-bar-red' );

    $("#estatus").val('');
    $("#baprobado").val('');
    $("#estatushtml").empty();

    $("#estatus").val(d[0].estatus);
    $("#baprobado").val(d[0].baprobado);
    $("#estatushtmlm").html(d[0].estatus);
    $("#barram").last().addClass( d[0].color );
    $("#barram").css("width", $("#recordSumM").val()+'%');
  }).fail( function() {
  }).always( function() {   });

});

//GESTION DE RECORD
function viewRecord(elem,idoffice,idusera){
  var rol = $("#rolid").val();
  if (rol == 7){
    alert("No tiene permisos, contactar administrador");
  }else{
    iduser  = idusera;
    idImpor = idusera;
    $("#id_send").val(elem);
    $("#off_e").val(idoffice);
    getUser(idoffice);
  }
  // if()
  // {
  //   // idImpor = iduser;
  //   // $("#id_send").val(elem);
  //   // $("#off_e").val(idoffice);
  //   // validarProceso($("#off_e").val(), 6);
  // }else {
  //   alert("No puede validar el record sin el DNI");
  // }



}

function viewHistorico(elem){
  var id_office = elem;
  $("#modal-viewHistorico").modal('show');
  var table = $('#tableprocesoValidacion').DataTable();
  table.clear().draw();
  getDataProceso(id_office);
}

function getDataProceso(id)//Inicio Fill
{
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

    }else {
      alert("No hay ningun proceso hecho");
      $('#tableprocesoValidacion').DataTable().clear().draw();
    }

}).fail( function() {
alert("Ocurrio un error en la operación");
}).always( function() {
  });
}//fin de fillTable

//IMPRIMIR RECORD
function imprimirRecord(){
  abrirNuevoTab("/driver/externo/report/record/"+idImpor);
}

function abrirNuevoTab(url) {
        // Abrir nuevo tab
        var win = window.open(url, '_blank');
        // Cambiar el foco al nuevo tab (punto opcional)
        win.focus();
      }

//api
function apiRecord(){
  limpiar();
  var table = $('#tbRecord').DataTable();
  table.clear().draw();
  var table = $('#tbRecordManual').DataTable();
  table.clear().draw();
  var elem =$("#id_send").val();
  $("#iframediv").hide();
  $.ajax({
    url: "/record/driver/"+elem,
    type:"get",
    beforeSend: function () {
          },
    }).done( function(d) {
      //API FUNCIONA
      if(d.data.length > 0){
        $("#recordSum").val(d.recordSum);
        $("#estatus").val(d.evaluo[0].estatus);
        $("#baprobado").val(d.evaluo[0].baprobado);
        $("#estatushtml").html(d.evaluo[0].estatus);
        $("#barra").last().addClass( d.evaluo[0].color );
        $("#barra").css("width", d.recordSum+'%');
        $("#record_input").val(JSON.stringify(d.data));
        $('#tbRecord').DataTable({
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
      "data": d.data,
      "columns":[
        {data:"aEntidad"},
        {data:"aNro_Papeleta"},
        {data:"aFecha_Infraccion"},
        {data:"aCod_Falta"},
        {data:"aPuntos_Firmes"},
        {data:"aPuntos_Saldo"},
        {data:"aEstado"},
      ],
      'createdRow': function (row, data, dataIndex){
        var valor = parseInt(d.aPuntos_Firmes);
        // if (valor <= 50){
        //   $('td', row).css('background-color', '#12ff12');
        // }
        // else
        if (valor > 80 ){
            $('td', row).css('background-color', 'Red');
            $('td', row).css('color', 'black');
            $('td', row).css('font-weight', 'bold');
        }
        // else if (valor > 50 && valor < 80){
        //   $('td', row).css('background-color', 'Yellow');
        // }
      },
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
      {
           "targets": 6,
           "className": "text-center",
      },
      ],

    });
    $("#apidiv").show();
    $("#buttons").show();

  }
      //IFRAME FUNCIONA
      else {
        limpiar();
        alert("EL conductor es extranjero, hacer el proceso manual.");
        $("#modal-viewRecord").modal('hide');
        // $("#iframediv").show();
        // $("#buttons").show();
        // alert("Error al conectarse con API Record");
        //
        // $('#tbRecordManual').DataTable({  'responsive'  : true,
        //   'autoWidth': false,
        //   'destroy'   : true,
        //   "bPaginate": false,
        //   "bLengthChange": false,
        //   "bFilter": true,
        //   "bInfo": false,
        //   "bAutoWidth": false,
        //   "searching": false,
        //   'language': {
        //     "decimal": "",
        //     "emptyTable": "No hay información",
        //     "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        //     "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        //     "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        //     "infoPostFix": "",
        //     "thousands": ",",
        //     "lengthMenu": "Mostrar _MENU_ Entradas",
        //     "loadingRecords": "Cargando...",
        //     "processing": "Procesando...",
        //     "search": "Buscar:",
        //     "zeroRecords": "Sin resultados encontrados",
        //     "paginate": {
        //         "first": "Primero",
        //         "last": "Ultimo",
        //         "next": "Siguiente",
        //         "previous": "Anterior"
        //     }
        //   },
        // });
      }




    }).fail( function() {
    }).always( function() { });

}

//iframe
function apiIframe(){
  limpiar();
  var table = $('#tbRecord').DataTable();
  table.clear().draw();
  var table = $('#tbRecordManual').DataTable();
  table.clear().draw();
  $("#apidiv").hide();
  $("#buttons").show();
  var elem =$("#id_send").val();
  $("#iframediv").show();
  $('#tbRecordManual').DataTable({  'responsive'  : true,
    'autoWidth': false,
    'destroy'   : true,
    "bPaginate": false,
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
    "bAutoWidth": false,
    "searching": false,
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


}


//GESTION DE RECORD estatus
function manejarRecord(id_estado){
  var id            = $("#id_send").val();
  var baprobado     = $("#baprobado").val();
  var recordSum     = $("#recordSum").val();
  var record ;
  var tipo;
  var noinfraccion  = 'false';

  if ($('#noinfraccion').prop('checked') ) {
      noinfraccion = 'true';
  }
  //EVITA APROBAR ESTATUS NO VALIDO
  if (id_estado == 5 && baprobado != 'true' ){
    alert("Ud, intenta aprobar un usuario que posee el limite de infracciones")
  }
   //EVALUAMOS DESDE DONDE SE ENVIAN LOS DATOS  else{
    //VEMOS EL IFRAME
    if(     $("#iframediv").css("display")  !== "none") {

      var validacion =  validar();
      if(validacion == false){
        return false;
      }
      else{

          var dataArray = $("#recordForm").serializeObject();
          record = JSON.stringify(dataArray);
          $("#record_input").val(record);
          tipo = 'iframe';
      }

    }
    //VEMOS LA API
    else if($("#apidiv").css("display")     !== "none") {
      record    = $("#record_input").val();
      tipo ='api';
    }
    //NO HACEMOS NADA
    else{ return false; }

    //AHORA HACEMOS EL ENVIO
    $.ajax({
        url: "/driver/externo/saveRecord",
        type:"post",
        data:{
            id_estado:id_estado,
            record:record,
            noinfraccion : noinfraccion,
            id:id,
            recordSum:recordSum,
            tipo:tipo,
            proceso:  6,
            codigoproceso: codigoproceso, estatusproceso: estatusproceso },
          beforeSend: function () {
            },
          })
          .done( function(d) {
              alert(d);
              $("#modal-viewRecord").modal('hide');//ocultamos el modal
              $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
              $('.modal-backdrop').remove();//eliminamos el backdrop del modal
              // window.location.href="/driver/externo/report/record/"+idImpor ;

            }).fail( function() { }).always( function() {   });


}

//VALIDATE
function validar(){
  var numError = 0;
  var ppal = 'Para continuar valida los siguientes campos obligatorios : \n\n';
  var msg  = '';
  var code  = 0;  var codf  = 0;   var ent = 0;
  var ptos  = 0;  var ptos2 = 0;  var ptosf = 0;  var ptof2 = 0;
  var finf  = 0;  var edo = 0;

  $("input[name='aEntidad[]']"         ).each(function(){
    if($(this).val()==""){
      ++ent;
      ++numError;
    }
  });
  if (ent>0){
    msg += 'Existen '+ent+' "ENTIDAD" vacia(s)\n';
  }

  $("input[name='aNro_Papeleta[]']"     ).each(function(){
    if($(this).val()==""){
      ++code;
      ++numError;
    }
  });
  if (code>0){
    msg += 'Existen '+code+' "PAPELETA" vacia(s)\n';;
  }

  $("input[name='aFecha_Infraccion[]']").each(function(){
    if($(this).val()==""){
      ++finf;
      ++numError;
    }

  });
  if (finf>0){
    msg += 'Existen '+finf+' "F-INFRACCIÓN" vacia(s)\n';
  }

  $("input[name='aCod_Falta[]']"       ).each(function(){
    if($(this).val()==""){
      ++codf;
      ++numError;
    }
  });
  if (codf>0){
    msg += 'Existen '+codf+' "COD. FALTA" vacia(s)\n';
  }

  $("input[name='aPuntos_Firmes[]']"   ).each(function(){
    if($(this).val()==""){
      ++ptosf;
      ++numError;
    }
    else{
      if ($(this).val().length > 3 || isNaN($(this).val())) {
          ++ptof2;
          $(this).val('');
        }
    }
  });
  if (ptosf>0 || ptof2>0){
    msg += 'Existen '+ptosf+' "PTOS FIRMES" vacia(s)\n';
    msg += 'Existen '+ptof2+' número de Ptos de Firmes errado(s)\n';
  }


  if (numError> 0){
    alert(ppal+msg);
    return false;
  }
  else{
    return true;
  }

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
    console.log(d);
    respuesta = d;
    if (respuesta == 'true'){
      $("#modal-viewRecord").modal('show');
    }else if (respuesta == 'false'){
      limpiar();
      alert("El ID Oficina no existe!");
    }else{
      limpiar();
      alert("El ID Oficina ya paso por este proceso!");
    }
  }).fail( function() {   alert("Ocurrio un error en la operación");   }).always( function() {  });
  return respuesta;
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

///





function getUser(id_user_offices){
  valor = id_user_offices;
  $.ajax(
    {
      url: "/users/exeterno/id/validate",
      type:"POST",
      data : { id : valor },
      dataType: "json",
      beforeSend: function () {

    }
    }).done(function(d)
    {
      if(d.objet != "error")
      {

    if(d.data.document==null)
          {
            alertify.genericDialog || alertify.dialog('genericDialog',function(){
          return {
              main:function(content){
                  this.setContent(content);
              },
              setup:function(){
                  return {
                      focus:{
                          element:function(){
                              return this.elements.body.querySelector(this.get('selector'));
                          },
                          select:true
                      },
                      options:{
                          basic:true,
                          // maximizable:false,
                          // resizable:false,
                          // padding:false
                      }
                  };
              },
              settings:{
                  selector:undefined
              }
          };
          });

alertify.genericDialog ($('#loginForm')[0]).set('selector', 'input[type="text"]');

}else{
  validarProceso($("#off_e").val(), 6);
}




          //$('#btn_search').prop("disabled", true);
      } else {

      }

  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");
  });
}

// ----------------------------
var last_name;
var first_name;
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
        $('#nombre_dni').html(d.data.first_name);
        $('#apellido_dni').html(d.data.last_name);
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

// -----------------------------------
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

         validarProceso($("#off_e").val(), 6);
        //getUser();
      }else{
        alert(d.message);
        stateSave = false;
      }
    }).fail(function(error){
      alert("Error al guardar");
      stateSave = false;
    });

};


function search_id()
{
  user = $('#search').val();
  $.ajax(
  {
    url: "/driver/driverlist/usuario/"+user,
    type:"get",
    dataType: "json",
  }).done(function(d){
    if (d.object == "success"){
      table = $('#driver').DataTable({
      "order": [[ 12, "desc" ]],
      'autoWidth': true,
      'destroy'  : true,
      "scrollX"  : true,
      'buttons'  : [
        {
          'extend': 'pdf',
          'text': 'PDF',
          'messageBottom': null,
          'download': 'open',

        },

        {
          'extend': 'excel',
          'text' :   'EXCEL',
          'messageTop': null,

        },
        {   'extend': 'copy',
            'text': 'Copiar',

        },

        {
            'extend': 'print',
            'text' : 'Imprimir',
            'messageTop':null,
            'messageBottom': null,

        }
        ],
      'language' : {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando START a END de TOTAL Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de MAX total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar MENU Entradas",
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
      "data": d.data,
      "columns"  : [
          {data:"accion"},
          {data:"resumen"},
          {data:"reporte"},
          {data:"document"},
          {data:"id_office"},
          {data:"first_name"},
          {data:"last_name"},
          {data:"phone"},
          {data:"correo"},
          {data:"marca"},
          {data:"placa"},
          {data:"modelo"},
          {data:"estado"},
          {data:"date_create.date"},
          {data:"created.username"}
      ],
      "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

        $('td', nRow).css('font-weight', 'bold');
        if(aData.estado == "DESAPROBADO")
        {
          $('td', nRow).css('background-color', '#F1948A');
        }else if (aData.estado == "APROBADO") {
            $('td', nRow).css('background-color', '#ACF5B1');
        }else if (aData.estado == "EN EVALUACIÓN") {
        $('td', nRow).css('background-color', '#F9E79F');
        }else {
          $('td', nRow).css('background-color', '#D2B4DE');
        }


                      }

      });




    }else{
      alert(d.message);
    }
  }).fail(function(error){
    alert("Error al buscar");
  });



}
