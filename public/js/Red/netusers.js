$(document).ready(function(){

  var table;
  table = $('#netusers').DataTable({
      'ajax': {
        'url': "/net/UsersAjax",
        'type':"GET",
      },
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
       'columns':[
          {data:"action"},
          {data:"user"},
          {data:"name"},
					{data:"lastname"},
          {data:"document"},
          {data:"sponsor"},
          {data:"parent"},
          {data:"status_user"}]
    });



});
