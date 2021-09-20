$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
//taxi win______-------------------------------------------------------------------------------

//llenar dataTable
function fillDataTableTaxiWin(data)
{

  $('#taxiWin').DataTable({  'responsive'  : true,
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
    data: data,
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'pdf',
        text: 'PDF',
        messageBottom: null,
        download: 'open',

      },

      {
        extend: 'excel',
        text :   'EXCEL',
        messageTop: null,

      },
      {   extend: 'copy',
          text: 'Copiar',

      },
      {
          extend: 'print',
          text : 'Imprimir',
          messageTop:null,
          messageBottom: null,

      }
      ],
    "columns":[
        {data:"userLogin"},
        {data:"document"},
        {data:"last_name"},
        {data:"first_name"},
        {data:"email"},
        {data:"phone"},
        {data:"country"},
        {data:"state"},
        {data:"city"},
        {data:"adreess_1"},
        {data:"nameProduct"},
        {data:"sku"},
        {data:"total"},
        {data:"money"},
        {data:"DatePay"},
        {data:"statusOrder"},
        {data:"post"}
    ]
    });
}

//filtrar por PRODUCTOS
function filter(data)
{
  var d = new Date();
  $.ajax({
    url: "/report/customerTaxiwin",
    type:"POST",
    data:{data:data},
    beforeSend: function () {
            $('.docs-example-modal-sm').modal('toggle');
          },
  }).done( function(d) {
    var sales = d.mensaje.sales;
    if(document.getElementById("e2_4").value != " ")
    {
      var filtrado = sales.filter(function (v)
      {
        return v.sku === document.getElementById("e2_4").value;
      });
    }
    else filtrado = sales;
    fillDataTableTaxiWin(filtrado);
    $('.docs-example-modal-sm').modal('hide');


}).fail( function() {
aler("Error en el petición")
}).always( function() {

  });
}


//llenar Productos TaxiWin
getProductTaxiWin("products","e2_4");
function getProductTaxiWin(data,comboBox)
{
  $.ajax({
    url: "/report/customerTaxiwin",
    type:"POST",
    data:{data:data},
    beforeSend: function () {
          },
  }).done( function(d) {
    var products = d.mensaje.products;
    select = document.getElementById(comboBox);
    $.each(products, function( index, value )
    {
      option = document.createElement("option");
       option.value = value.sku;
       option.text = value.sku;
       select.appendChild(option);
    });
}).fail( function() {

}).always( function() {

  });
}



var table =$('#taxiWin').DataTable({  'responsive'  : true,
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
  dom: 'Bfrtip',
  buttons: [
    {
      extend: 'pdf',
      text: 'PDF',
      messageBottom: null,
      download: 'open',
    },

    {
      extend: 'excel',
      text :   'EXCEL',
      messageTop: null,

    },
    {   extend: 'copy',
        text: 'Copiar',

    },
    {
        extend: 'print',
        text : 'Imprimir',
        messageTop:null,
        messageBottom: null,
    }
    ],
});
$(function() {
 $('input[name="datetimes"]').daterangepicker({
   startDate: moment().startOf('hour'),
   endDate: moment().startOf('hour').add(32, 'hour'),
   locale: {
     format: 'Y-MM-DD'
   }
 });
});


$("#e2_2").select2({
placeholder: "Select a State"
});
$("#e2_3").select2({
placeholder: "Select a State"
});
$("#e2_4").select2({
placeholder: "Select a State"
});
$("#e2_5").select2({
placeholder: "Select a State"
});

function filterAdvance()
{
var accion = document.getElementById("e2_3").value;
var type = document.getElementById("e2_4").value;
var e = document.getElementById("rageTimes").value;
var list = e.split(' ');
var data = accion+"_"+list[0]+"_"+list[2]+"_"+type;
filter(data);
}

function salesAll()
{
var data = "sales";
conexionTaxiwin(data);
}

function salesToday()
{
  var fullDate = new Date();
  var twoDigitMonth = fullDate.getMonth()+1+"";if(twoDigitMonth.length==1)	twoDigitMonth="0" +twoDigitMonth;
  var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
  var currentDate = fullDate.getFullYear()+"-"+ twoDigitMonth+"-"+twoDigitDate;
 var data = "sales_"+currentDate+"_"+currentDate;
console.log(data);
conexionTaxiwin(data);
}


function salesMonth()
{
  var fullDate = new Date();
  var twoDigitMonth = fullDate.getMonth()+1+"";if(twoDigitMonth.length==1)	twoDigitMonth="0" +twoDigitMonth;
  var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
  var currentDate = fullDate.getFullYear()+"-"+ twoDigitMonth+"-"+twoDigitDate;
  console.log(currentDate);
var data = "sales_"+currentDate;
conexionTaxiwin(data);
}

function filterAdvance()
{
var accion = document.getElementById("e2_3").value;
var type = document.getElementById("e2_4").value;
var e = document.getElementById("rageTimes").value;
var list = e.split(' ');
var data = accion+"_"+list[0]+"_"+list[2]+"_"+type;
filter(data);
}
//
function conexionTaxiwin(data)
{
        $.ajax({
          url: "/report/customerTaxiwin",
          type:"POST",
          data:{data:data},
          beforeSend: function () {
                  $('.docs-example-modal-sm').modal('toggle');
                },
        }).done( function(d) {
          var sales = d.mensaje.sales;
        fillDataTableTaxiWin(sales);
          $('.docs-example-modal-sm').modal('hide');


      }).fail( function() {

      }).always( function() {

        });
}

//-------------------------------------------------------------------------------------fin de taxi // WARNING:
//-------------------------------------------------------------------------------------inicio win is to share

var tablew =$('#winistoshare').DataTable(
  {
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
     scrollX: true,
     dom: 'Bfrtip',
  buttons: [
    {
      extend: 'pdf',
      text: 'PDF',
      messageBottom: null,
      download: 'open',
    },

    {
      extend: 'excel',
      text :   'EXCEL',
      messageTop: null,

    },
    {   extend: 'copy',
        text: 'Copiar',

    },
    {
        extend: 'print',
        text : 'Imprimir',
        messageTop:null,
        messageBottom: null,
    }
    ],
  }
);
$("#w2_2").select2({
placeholder: "Select a State"
});
$("#w2_3").select2({
placeholder: "Select a State"
});
$("#w2_4").select2({
placeholder: "Select a State"
});
$("#w2_5").select2({
placeholder: "Select a State"
});

function fillDataTableWinIstoShare(data)
{

  $('#winistoshare').DataTable({
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
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'pdf',
        text: 'PDF',
        messageBottom: null,
        download: 'open',
      },

      {
        extend: 'excel',
        text :   'EXCEL',
        messageTop: null,

      },
      {   extend: 'copy',
          text: 'Copiar',

      },
      {
          extend: 'print',
          text : 'Imprimir',
          messageTop:null,
          messageBottom: null,
      }
      ],
    "data": data,
    "columns":[
        {data:"document"},
        {data:"last_name"},
        {data:"first_name"},
        {data:"email"},
        {data:"phone"},
        {data:"country"},
        {data:"state"},
        {data:"city"},
        {data:"adreess_1"},
        {data:"nameProduct"},
        {data:"sku"},
        {data:"total"},
        {data:"money"},
        {data:"DatePay"},
        {data:"statusOrder"},
        {data:"post"}
    ]
    });
}

function conexionWinistoshare(data)
{
        $.ajax({
          url: "/report/customerWinistoshare",
          type:"POST",
          data:{data:data},
          beforeSend: function () {
                  $('.docs-example-modal-sm').modal('toggle');
                },
        }).done( function(d) {
          var sales = d.mensaje.sales;
        fillDataTableWinIstoShare(sales);
          $('.docs-example-modal-sm').modal('hide');


      }).fail( function() {

      }).always( function() {

        });
}

function salesAllW()
{
var data = "sales";
conexionWinistoshare(data);
}
function salesMonthW()
{
  var fullDate = new Date();
  var twoDigitMonth = fullDate.getMonth()+1+"";if(twoDigitMonth.length==1)	twoDigitMonth="0" +twoDigitMonth;
  var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
  var currentDate = fullDate.getFullYear()+"-"+ twoDigitMonth+"-"+twoDigitDate;
var data = "sales_"+currentDate;
conexionWinistoshare(data);
}
function salesTodayW()
{
  var fullDate = new Date();
  var twoDigitMonth = fullDate.getMonth()+1+"";if(twoDigitMonth.length==1)	twoDigitMonth="0" +twoDigitMonth;
  var twoDigitDate = fullDate.getDate()+"";if(twoDigitDate.length==1)	twoDigitDate="0" +twoDigitDate;
  var currentDate = fullDate.getFullYear()+"-"+ twoDigitMonth+"-"+twoDigitDate;
var data = "sales_"+currentDate+"_"+currentDate;
conexionWinistoshare(data);
}

function filterAdvanceW()
{
var accion = document.getElementById("w2_3").value;
var type = document.getElementById("w2_4").value;
var e = document.getElementById("rageTimesW").value;
var list = e.split(' ');
var data = accion+"_"+list[0]+"_"+list[2]+"_"+type;
filterW(data);
}

function filterW(data)
{
  var d = new Date();
  $.ajax({
    url: "/report/customerWinistoshare",
    type:"POST",
    data:{data:data},
    beforeSend: function () {
            $('.docs-example-modal-sm').modal('toggle');
          },
  }).done( function(d) {
    var sales = d.mensaje.sales;
    if(document.getElementById("w2_4").value != " ")
    {
      var filtrado = sales.filter(function (v)
      {
        return v.sku === document.getElementById("w2_4").value;
      });
    }
    else filtrado = sales;
    fillDataTableWinIstoShare(filtrado);
    $('.docs-example-modal-sm').modal('hide');


}).fail( function() {
aler("Error en el petición")
}).always( function() {

  });
}

getProductWinIsToShare("products","w2_4");
function getProductWinIsToShare(data,comboBox)
{
  $.ajax({
    url: "/report/customerWinistoshare",
    type:"POST",
    data:{data:data},
    beforeSend: function () {
          },
  }).done( function(d) {
    var products = d.mensaje.products;
    select = document.getElementById(comboBox);
    $.each(products, function( index, value )
    {
      option = document.createElement("option");
       option.value = value.sku;
       option.text = value.sku;
       select.appendChild(option);
    });
}).fail( function() {

}).always( function() {

  });
}
