$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function() {

  var table;

  table = $('#auditoria-table').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
      'responsive'  : true,
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
});

$("#clean"  ).click(function() {
  //de acuerdo a los campos q quiero limpiar
  $('#campo_search'   ).val('');
});


$("#search"  ).click(function() {
  var formulario = $("#formIndexAuditoria").serializeObject();

  table = $('#auditoria-table').DataTable({
      'ajax': {
        'url': "/getAuditoria",
        'type':"POST",
        'data' :{ formulario : formulario }
      },
       'responsive'  : false,
       'autoWidth'   : true,
       'destroy'     : true,
       'language': {
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
       "columnDefs": [
         {"className": "dt-left", "targets": "_all"}
        ],
        dom: 'lBfrtip',
        buttons: [
          {
            extend: 'excel',
            text :   'EXCEL',
            messageTop: null,
            exportOptions: {
              columns: [1, 2, 3, 4, 5]
           }

          },
          {
            extend: 'copy',
            text: 'Copiar',
            exportOptions: {
              columns: [1, 2, 3, 4, 5]
           }
          },
        ],
       'columns':[
           {data: "id",
           "render": function (data, type, row) {
             return '<a href="/auditoria/'+data+'" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a>';
           }},
           {data: "id",
           "render": function (data, type, row) {
             return (row.user_modified)? row.user_modified.username : '-';
           }},
          {data:"auditable_id"},
          {data:"auditable_type"},
          {data:"event"},
          {data:"created_at"},
        ]
    });
});

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
