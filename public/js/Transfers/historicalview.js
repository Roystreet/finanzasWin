$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
function fillDataTable(d)
{
  $('#historicals').DataTable({
    'responsive'  : false,
    'autoWidth': true,
    'destroy'   : true,
    "scrollX": true,
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
    'language': {
      'buttons': {
             copyTitle: 'Realizado exitosamente',
             copySuccess: {
                 _: '%d lineas copiadas',
                 1: '1 linea copiada'
             },
           },
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
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
    "data": d,
    "columns":[
      {
             sortable: false,
             "render": function ( data, type, full, meta ) {
                 return '<div class="tickets"  ><a href="viewhistoricalid/'+full.get_ticket.id+'"><i class="fa fa-cog" title="Detalles del Cliente"></i></a></div>';
               }
      },
        {data:"get_ticket.cod_ticket"},
        {data:"get_ticket.nro_book"},
        {data:"get_customer_act.first_name"},
        {data:"get_customer_act.last_name"},
        {data:"get_customer_act.document"},
        {data:"get_ticket.total"},
    ]
    });

}
fill();
function fill()
{
  $.ajax({
    url: "/allhistorical",
    type:"get",
    beforeSend: function () {
      $( "#historicals" ).after( "<b>Cargando</b>" );
  },
  }).done( function(d) {
    fillDataTable(d);
}).fail( function() {

}).always( function() {

  });
}
