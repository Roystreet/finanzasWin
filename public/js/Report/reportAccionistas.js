$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function(){

  accionistas();
  function accionistas(){
    allproduct=  $('#productos').DataTable({
      'ajax':{
        'url':"/accionar/productos",
        'type':"post",
      },
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
      'columns':[
        {data:"id",
        "render": function (data,type,row){
          return (data)? data : '-';
        }},
        {data:"cod_product",
        "render": function (data,type,row){
          return (data)? data : '-';
        }},
        {data:"name_product",
        "render": function (data,type,row){
          return (data)? data : '-';
        }},
        {data:"description",
        "render": function (data,type,row){
          return (data)? data : '-';
        }},
        {data:"status_user",
        "render": function (data,type,row){
          var d = row.status_user;
          if(d)
           return '<a href="#"><i type="button" class="btn btn-success fa fa-check" onclick="accionProducto('+row.id+',0);this.onclick=null;"></i></a> <dd>';
           else {
             return '<a href="#"><i class="btn btn-primary fa fa-times"  onclick="accionProducto('+row.id+',1);this.onclick=null;"></i></a> <dd>';
           }
        }},
      ]

    });
  }
}
