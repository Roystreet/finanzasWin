$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
fillTable();
function fillTable()//Inicio Fill
{
  $.ajax({
    url: "/ticket/getTickets",
    type:"get",
    beforeSend: function () {
          },
  }).done( function(d) {
    $('#tickets').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
      'buttons': [
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
    {
           sortable: false,
           "render": function ( data, type, full, meta ) {
              var d = full.id;
               return '<a href="/ticket/editar/'+d+'"><i class="fa fa-pencil btn_edit"  id_edit="'+d+'" data-toggle="modal" data-target="#myModal"></i></a>';
           }
    },
      {data:"cod_ticket"},
      {data:"get_customer.first_name"},
      {data:"get_customer.last_name"},
      {data:"get_customer.document"},
      {data:"get_product.[0].description"},
      {data:"created_at"},
      {data:"get_money.[0].description"},
      {data:"total"},
      {data:"get_status.description"},
  ]
  });

}).fail( function() {

}).always( function() {


  });
}//fin de fillTable
