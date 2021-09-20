$(document).ready(function(){
  var f = new Date();
  var table;

  table = $('#saldo').DataTable({
    'processing': true,

  'responsive'  : false,
  'autoWidth'   : false,
  'destroy'     : true,
  'scrollX'     : true,
  'language': {
    'loadingRecords': '&nbsp;',
     'processing': '<div class="spinner"></div>',
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar _MENU_ Entradas",
    "loadingRecords": "Cargando...",
    // "processing": "Procesando...",
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

  $("#search").unbind('click');
  $('#search').on('click', function () {
    $.fn.getData(table);
   });

});


$.fn.getData          = function(table) {

  $.ajax({
    url: "/capitalDriver/getRecargasApp",
    type:"GET",
    beforeSend: function () {

    },
  }).done( function(d) {
    $.fn.fillDataTable(d.data);
  }).fail( function() {
     alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });

}

$.fn.fillDataTable    = function(data) {

  var table= $('#saldo').DataTable({
    'processing': true,
    "serverSide": false,
    'responsive'  : true,
    'responsive'  : false,
    'autoWidth': false,
    'destroy'   : true,
    "scrollX": true,
    "dom": '<"top"Bf>rt<"bottom"lip><"clear">',
    buttons: ['pageLength',
            {
              extend: 'pdfHtml5',
              text: 'PDF',
              messageBottom: null,
              download: 'open',
              orientation: 'landscape',
              pageSize: 'LEGAL',
              customize : function(doc) {doc.pageMargins = [30, 30, 30,30 ]; },


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
      'language': {
        'loadingRecords': '&nbsp;',
            'processing': 'Loading...',
        'buttons': {
               copyTitle: 'Realizado exitosamente',
               copySuccess: {
                   _: '%d lineas copiadas',
                   1: '1 linea copiada'
               },
               pageLength: {
                _: "Mostar %d Entradas",
                '-1': "Tout afficher"
            }
             },
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
      "columns":[
          {data:"licencia"},
          {data:"name"},
          {data:"lastname"},
          {data:"phone"},
          {data:"country"},
          {data:"money"},
          {data:"amount"},
          {data:"approved"},
          {data:"blocked"}

    ]
      });

  table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

}
