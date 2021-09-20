$(document).ready(function(){
  var url = $.fn.getUrl(null, 'allTicketsAct');



  var table =  $('#tickets').DataTable({
       "ajax": {
            "url": url,
            "type": "GET",
            "dataType": 'json',
        },
        "columns":[
          {data: "verCliente"},
          {data: "action"},
          {data:"cod_ticket"},
          {data:"name_product"},
          {data:"first_name"},
          {data:"country"},
          {data:"price"},
          {data:"cant"},
          {data:"total"},
          {data:"statussis"},
          {data:"username"},
         ],
         'responsive'  : false,
         'autoWidth': false,
         'destroy'   : true,
         "scrollX": true,
         'language': {
           "decimal": "",
           "emptyTable": "NO hay disponibles para su activación",
           "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
           "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
           "infoFiltered": "(Filtrado de MAX total entradas)",
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

   $('#tickets tbody').on('click','#statussis',           function () {
      var status = $(this).attr("statussis");
      var id     = $(this).attr("data-id");
      var url = $.fn.getUrl(null, 'updateStatus');
      alertify.confirm('ACTIVAR ACCIONISTA', '   ¿Está usted seguro que desea cambiar el estatus del usuario?', function(){
          $.fn.updateStatus(status, id, table, url);
      },function(){
      }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});

    });

});

$.fn.updateStatus       = function(status, id, table, url){

   $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
   $.ajax({
             data:  {status : status, id : id},
             url: url,
             dataType: "json",
             type:  "POST",
             success:  function (response) {
                alertify.alert('Gestion de Estatus', response.mensaje, function(){
                   table.ajax.reload();
                });
               }
       });
 }
$.fn.getUrl             = function (id,name) {
  var url = window.location.pathname;
    url = url.split("/")[1];

    if (url == 'atencion' || url == 'admin'){
      if (id != null){
        url = '/'+url+'/'+name+'/'+id;
      }else{
        url = '/'+url+'/'+name;
      }
    }else{
      if (id != null){
        url = '/'+url+'/'+name+'/'+id;
      }else{
        url = '/'+url+'/'+name;
      }
    }
    return url;
};
