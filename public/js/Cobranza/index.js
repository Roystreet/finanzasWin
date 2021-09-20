$(document).ready(function(){
  var table;

  $('#range_date' ).daterangepicker({
   "locale"    : {
      "format": "YYYY-MM-DD",
      "separator": " - ",
      "applyLabel": "Guardar",
      "cancelLabel": "Cancelar",
      "fromLabel": "Desde",
      "toLabel": "Hasta",
      "customRangeLabel": "Personalizar",
      "daysOfWeek": [
        "Do",         "Lu",         "Ma",         "Mi",
        "Ju",         "Vi",         "Sa"
      ],
      "monthNames": [
        "Enero",      "Febrero",    "Marzo",      "Abril",
        "Mayo",       "Junio",      "Julio",      "Agosto",
        "Setiembre",  "Octubre",    "Noviembre",  "Diciembre"
      ],
      "firstDay": 1
   },
   "startDate" : "2019-01-01",
   "opens"     : "center"
  });

  table = $('#orders').DataTable({
    'responsive'  : false,
    'autoWidth'   : false,
    'destroy'     : true,
    'scrollX'     : true,
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

  $("#search").unbind('click');
  $('#search').on('click', function () {
    $.fn.getData();
  });



});


$.fn.getData              = function() {
  var start_date  = $('#range_date').data('daterangepicker').startDate.format('YYYY-MM-DD');
  var end_date    = $('#range_date').data('daterangepicker').endDate.format('YYYY-MM-DD');
  var cod_order   = $('#cod_order').val();

  $.ajax({
    url: "/cobranza/getOrders",
    type:"GET",
    data:{start_date : start_date, end_date : end_date, cod_order : cod_order},
    beforeSend: function () {
    },
  }).done( function(d) {
    $.fn.fillDataTable(d.data);
  }).fail( function() {
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });

}

$.fn.fillDataTable        = function(data) {

    $('#orders').DataTable({  'responsive'  : true,
      'responsive'  : false,
      'autoWidth': false,
      'destroy'   : true,
      "scrollX": true,
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
      "columns":[
          {data:"action"},
          {data:"cod_order"},
          {data:"id_pay"},
          {data:"id_money"},
          {data:"total"},
          {data:"total_ret"},
          {data:"total_abono"},
          {data:"total_ride"},
          {data:"status_user"},
          {data:"date_pay"},
          {data:"created_at"},
          {data:"modified_by"}
      ]
      });

}
