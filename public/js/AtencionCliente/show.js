$('#status_user').select2();
$('#id_customer').select2();
$('#modified_by').select2();
$('#id_country').select2();
$('#id_statusT').select2();
$('#created_by').select2();
$('#group').select2();

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function() {

  $('#created_at' ).daterangepicker({
    "autoUpdateInput": false,

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
           "firstDay": 1,
           "cancelLabel": 'Clear'
       },
       "startDate": "2019-01-01",
       "opens": "center",
   });
  $('input[name="created_at"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
  $('input[name="created_at"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
  table = $('#servicedesk').DataTable({
  'responsive'  : false,
  'autoWidth'   : false,
  'destroy'     : true,
  'scrollX'     : true,
	'scrollY'     : true,
  'language': {
    "decimal": "",
    "emptyTable": "No hay registro",
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

   $("#clean").unbind('click');
   $('#clean').on('click', function () {
    table.clear().draw();
 		$('#id_customer'  ).val('').trigger('change');
 		$('#modified_by'  ).val('').trigger('change');
 		$('#id_country'   ).val('').trigger('change');
 		$('#status_user'  ).val('').trigger('change');
    $('#id_statusT'  ).val('').trigger('change');
    $('#created_at'  ).val('');
    $('#num_ticket'  ).val('');
    });

    $.fn.getData  = function() {

      var start_datec;  var end_datec;

      var created_at = $('#created_at').val()
      if (created_at){
        var dates = created_at.split(" - ");
        start_datec = dates[0];     end_datec   = dates[1];
      }

      $.ajax({
        url: "/atencion/getDataregister",
        type:"GET",
        data:{ datos      : $( '#myform' ).serializeObject(),
    					start_datec  : start_datec,
    					end_datec    : end_datec,
    				 },
        beforeSend: function () {
        },
      }).done( function(d) {
        $.fn.fillDataTable(d.data);
      }).fail( function(error) {
        console.log(error);
        alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
      }).always( function() {
      });

    }

    $.fn.fillDataTable    = function(data) {
      var table= $('#servicedesk').DataTable({
          'responsive'  : true,
          'responsive'  : false,
          'autoWidth': false,
          'destroy'   : true,
          dom: 'Bfrtip',
          buttons: [
            {
              extend: 'excel',
              text :   'EXCEL',
              messageTop: null,

            }
            ],
          "scrollX": true,
    			"scrollY": true,
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
            "emptyTable": "No hay registro",
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
              {data:"channel"},
              {data:"created_at"},
              {data:"num_ticket"},
              {data:"id_reqi"},
              {data:"id"},
              {data:"area"},
              {data:"assigned"},
              {data:"name"},
              {data:"lastname"},
              {data:"status"},
              {data:"imprimir"},
              {data:"ver"},
        ]
      });
    }
});

function callatentions(id){
  $.ajax(
    {
      url  : "/atencion/updateTicketStatus",
      type : "POST",
      data : {  id: id, status : 6 },
      dataType: "json",
      beforeSend: function () {
        $('#load_inv').show(300);
      }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      alertify.notify(d.message,d.object,2, function(){});
      $.fn.getData();
    }).fail(function(d){
      $('#load_inv').hide(300);
      console.log(d);//alerta del ticket no resgistrado
    });
}

$.fn.serializeObject  = function(){
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
