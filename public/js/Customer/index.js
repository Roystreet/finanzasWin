$(document).ready(function(){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });




  var url = window.location.pathname;
      url = url.split("/")[1];

  $.fn.btnSee(url);

    var permiso = $('#permiso').val();
    var rolid = $('#rolid').val();
    var vista;
    function getData(){
      if(permiso == 1 || rolid == 4){
        vista = {
           dom: 'Bfrtip',
           buttons: [
               'copy', 'excel', 'pdf'
           ],
            'responsive'  : true,
            'autoWidth': false,
            'destroy'   : true,

            "ajax": {
              "url": '/tabla/customer',
              "type": "post",
              "dataType": 'json',
              "dataSrc": "",
            },

            "columns":[
            {data:"id",
                  "render": function ( data, type, full, meta) {
                  return '<div class="col-md-20 center-block"><a type="button" class="btn btn-primary fa fa-cog" href="/customers/'+full.id +'"></a></div>';
                }},
            {data:"first_name"},
            {data:"last_name"},
            {data:"document"},
            {data:"phone"},
            {data:"email"},
            {data:"status_system",
                  "render": function ( data, type, full, meta) {
                    if(full.status_system == false){
                        return data.status_system='inactivo';
                    }else
                      return data.status_system='activo';
                }}
            ],
            'pageLength': 15,
            'deferRender': true,
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
        }
      }else{
        vista = {
            'responsive'  : true,
            'autoWidth': false,
            'destroy'   : true,
            "ajax": {
              "url": '/tabla/customer',
              "type": "post",
              "dataType": 'json',
              "dataSrc": "",
          },
          "columns":[
            {data: "id"},
            {data:"first_name"},
            {data:"last_name"},
            {data:"document"},
            {data:"phone"},
            {data:"email"},
            {data:"status_system"}
          ],
            'pageLength': 15,
            'deferRender': true,
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






        }
      }
    }

    getData();
    var table = $('#customers').DataTable(vista);

});

$.fn.btnSee = function(url){

  if (url == 'customers'){
    $(".customers").css('display','block');
  }
  if (url == 'atencion') {
    $(".atencion").css('display','block');
  }
  if (url == 'admin')    {
    $(".admin").css('display','block');
  }

};
