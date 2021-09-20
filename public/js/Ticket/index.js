$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    var url = window.location.pathname;
    var   url = url.split("/")[1];
$(document).ready(function(){

getDataTable();
function getDataTable()
{
   $('#tickets').DataTable({
    'responsive'  : false,
    'autoWidth': true,
    'destroy'   : true,
    "scrollX": true,
    'language': {
      'buttons': {
             copyTitle: 'Realizado exitosamente',
             copySuccess: {
                 _: '%d lineas copiadas',
                 1: '1 linea copiada'
             },
           },
      "decimal": "",
      "emptyTable": "",
      "info": "Mostrando START a END de TOTAL Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de MAX total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar MENU Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "",
      "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
      }
    }

  });

}

function fillDataTable(d)
{
  var table = $('#tickets').DataTable({
    'responsive'  : false,
    'autoWidth': true,
    'destroy'   : true,
    "scrollX": true,
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
      "info": "Mostrando START a END de TOTAL Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de MAX total entradas)",
      "infoPostFix": "",
      "thousands": ",",
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

            var   d = "";
           if (url == 'tickets')   {    d = "/customers/";  }
           if (url == 'admin')     {    d = "/admin/customers/";  }
           if (url == 'atencion')  {    d = "/atencion/customers/";   }


                 return '<div class="tickets"  ><a href="'+d+full.get_customer.id+'"><i class="fa fa-cog" title="Detalles del Cliente"></i></a></div>';
               }
      },
      {
             sortable: false,
             "render": function ( data, type, full, meta ) {

                 return '<div class="tickets"  ><a href="/tickets/pdf/'+full.id+'"><i class="fa fa-download" title="Descargar"></i></a></div>';
               }
      },
      {
             sortable: false,
             "render": function ( data, type, full, meta ) {

                 return '<div class="tickets"  ><a data-target="#modal-viewTicketbyID" data-toggle="modal" data-id='+full.id+' id="viewticketid"><i class="fa fa-eye" title="Vista"></i></a></div>';
               }
       },
        {data:"cod_ticket"},
        {data:"get_customer.first_name"},
        {data:"get_customer.last_name"},
        {data:"get_customer.document"},
        {data:"get_invited.last_name"},
        {data:"get_product[0].description"},
        {data:"get_country_inv.description"},
        {data:"created_at"},
        {data:"get_money[0].description"},
        {data:"total"},
        {data:"get_status.description"},
        {data:"get_modify_by.username"},
        {data:"get_create_by.username"}

    ]
    });

    var deta = $("#tickets").attr("details");
    var download = $("#tickets").attr("download");
    var seegene = $("#tickets").attr("see");
    var seespe = $("#tickets").attr("seespec");
    var rolid = $("#tickets").attr("rolid");

    console.log(deta);
    // Get the column API object
    var columndeta = table.column(0);
    var columndowload = table.column(1);
    var columnver = table.column(2);

    // Toggle the visibility
    if (deta == true || rolid == 4){

    }else{
      columndeta.visible(!columndeta.visible());
    }

    if (download == true || rolid == 4){

    }else{
      columndowload.visible(!columndowload.visible());
    }

    if (seegene == true || seespe == true || rolid == 4){

    }else{
      columnver.visible(!columnver.visible());
    }


}

fill();
function fill()
{
  $.ajax({
    url: "/tickets/getAllTickets",
    type:"get",
    beforeSend: function () {
      $( "#tickets" ).before( "<b>Cargando....</b>" );
    },
  }).done( function(d) {
    fillDataTable(d);


}).fail( function() {

}).always( function() {

  });
}
});

$('#tickets tbody').on('click','#viewticketid',function () {
     var id  = $(this).attr("data-id");
     $.fn.btnSee();
     var url = $.fn.getUrl(null, 'getTicketforID');
     $.ajax({
       type: "GET",
       url: url,
       data: {id : id },
       dataType : 'json',
       beforeSend: function(){
       },
       success: function(data) {
          $('#codregticket').html(data.cabecera['cod_ticket']);
          $('#prodregticket').html(data.ticket.get_product[0]['name_product']);
          var fechatot = data.ticket['created_at'];
          var newfecha = fechatot.substring(11, 0);
          $('#fecharegticket').html(newfecha);
          $('#compradticket').html(data.ticket.get_customer['last_name']+ ',' +data.ticket.get_customer['first_name']);
          $('#dnicompradticket').html(data.ticket.get_customer['document']);
          $('#paiscompradticket').html(data.country);
          $('#ciucompradticket').html(data.city);
          $('#estcompradticket').html(data.state);
          $('#direccompradticket').html(data.ticket.get_customer['address']);
          $('#corrcompradticket').html(data.ticket.get_customer['email']);
          $('#telfcompradticket').html(data.ticket.get_customer['phone']);
          $('#montcompra').html(data.ticket['total']+' '+data.ticket.get_money[0]['description']);
          $('#tippaycompra').html(data.pay['name_pay']);
          $('#nroopecompra').html(data.ticket['number_operation']);
          $('#fechpagcompra').html(data.ticket['date_pay']);
          $('#nameinvtcomp').html(data.ticket.get_invited['last_name']+ ',' +data.ticket.get_invited['first_name']);
          $('#paisainvert').html(data.ticket.get_country_inv['description']);
          $('#observaticket').html(data.ticket['note']);
          if (url == 'tickets')   {    $("#download-voucher").attr('href','https://www.w3schools.com/jquery/');   }
          if (url == 'admin')     {    $("#download-voucher").attr('href','admin/ticket/'+id);   }
          if (url == 'atencion')  {    $("#download-voucher").attr('href','atencion/ticket/'+id);   }
       },
       error: function(data) {
       }
     });


   });

$.fn.getUrl = function (id,name) {
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

$.fn.btnSee = function(){
  var url = window.location.pathname;
      url = url.split("/")[1];
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
