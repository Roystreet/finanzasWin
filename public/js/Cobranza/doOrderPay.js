$(document).ready(function(){
  var table;

  $('#range_date_ride' ).daterangepicker({
       "locale": {
           "format": "YYYY-MM-DD",
           "separator": " - ",
           "applyLabel": "Guardar",
           "cancelLabel": "Cancelar",
           "fromLabel": "Desde",
           "toLabel": "Hasta",
           "customRangeLabel": "Personalizar",
           "daysOfWeek": [
               "Do",
               "Lu",
               "Ma",
               "Mi",
               "Ju",
               "Vi",
               "Sa"
           ],
           "monthNames": [
               "Enero",
               "Febrero",
               "Marzo",
               "Abril",
               "Mayo",
               "Junio",
               "Julio",
               "Agosto",
               "Setiembre",
               "Octubre",
               "Noviembre",
               "Diciembre"
           ],
           "firstDay": 1
       },
       "startDate": "2019-01-01",
       "opens": "center"
   });
  table = $('#carreras').DataTable({
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

  $("#searchRides").unbind('click');
  $('#searchRides').on('click', function () {
     var start = $('#range_date_ride').data('daterangepicker').startDate.format('YYYY-MM-DD');
     var end   = $('#range_date_ride').data('daterangepicker').endDate.format('YYYY-MM-DD');
     var porcentaj_ret   = $('#porcentaj_ret').val();

    $.fn.getData(start, end, porcentaj_ret);
   });

  $('#select-all').click(function(event) {

    if(this.checked) {
      $(':checkbox').each(function() {
        this.checked = true;
      });
    }
    else {
      $(':checkbox').each(function() {
        this.checked = false;
      });
    }
  });

  $("#allRides").unbind('click');
  $('#allRides').on('click', function () {
    $.fn.saveRides(table);
   });

});


$.fn.getData              = function(start_date, end_date, porcentaj_ret) {

  $.ajax({
    url: "/cobranza/getridesByOrderPay",
    type:"get",
    data:{start_date : start_date, end_date : end_date, porcentaj_ret : porcentaj_ret},
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

    $('#carreras').DataTable({  'responsive'  : true,
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
          {data:"check"},
          {data:"codigo_ride"},
          {data:"id_driver"},

          {data:"license_number"},
          {data:"last_name"},
          {data:"first_name"},
          {data:"money"},
          {data:"country"},

          {data:"pay"},
          {data:"date_ride"},
          {data:"total_pay"},
          {data:"porcentaj_ret"},
          {data:"mto_ret"},
          {data:"mto_abono"},
          {data:"status"},
      ]
      });

}

$.fn.saveRides             = function(table) {

  var codigos = [];

  $('input:checkbox[name="cod_rides[]"]').each(function(){
    if($(this).is(':checked'))
    codigos.push($(this).val());
  });

  if (codigos.length != 0){
    alertify.confirm('Con esta opcion estará realizando una recarga de forma masiva', '\t\t Confirma que desea continuar con la operación!',
    function(){

      var ridesArray = new Array();

      $("input[type=checkbox]:checked").each(function(){
      	//cada elemento seleccionado
        var ride  = new Object();
          ride.license_number = $(this).parent().parent().find('td').eq(3).html();
          ride.cod_ride       = $(this).val();
          ride.pay            = $(this).parent().parent().find('td').eq(8).html();
          ride.date_ride      = $(this).parent().parent().find('td').eq(9).html();
          ride.total_pay      = $(this).parent().parent().find('td').eq(10).html();
          ride.porcentaj_ret  = $(this).parent().parent().find('td').eq(11).html();
          ride.mto_ret        = $(this).parent().parent().find('td').eq(12).html();
          ride.mto_abono      = $(this).parent().parent().find('td').eq(13).html();
          ride.status         = $(this).parent().parent().find('td').eq(14).html();
          ride.money          = $(this).parent().parent().find('td').eq(6).html();
          ride.id_driver      = parseInt($(this).parent().parent().find('td').eq(2).html());

          ridesArray.push(ride);

      });
      var rides = JSON.parse(JSON.stringify(ridesArray));

      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      $.ajax({
          url: "/cobranza/generandoOrder",
          type:"get",
          data: {'rides': rides },
          dataType: "json",
          beforeSend: function () {
            },
      }).done( function(d) {
         alertify.alert('Excelente!',d.dato, function(){
           var start = $('#range_date_ride').data('daterangepicker').startDate.format('YYYY-MM-DD');
           var end   = $('#range_date_ride').data('daterangepicker').endDate.format('YYYY-MM-DD');
           var porcentaj_ret   = $('#porcentaj_ret').val();

          $.fn.getData(start, end, porcentaj_ret);

         });

      }).fail( function() {
        alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
      }).always( function() {

      });
    },
    function(){  alertify.error('Cancel')  });

    }else{      alertify.alert('Advertencia', 'Selecciona al menos un items', function(){});   }
}

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
