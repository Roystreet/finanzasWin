$(document).ready(function(){
  var f = new Date();
  var table;
  $('.select2').select2();
  $('#range_date' ).daterangepicker({
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
  $('input[name="range_date"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });
  $('input[name="range_date"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
  });

  table = $('#recargas').DataTable({
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

  $('#date_ed').datepicker({
    today: "",
    autoclose: true,
    format: "yyyy/mm/dd",
    startDate: "1900/01/01",
    endDate:  f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate()
  }).val('');

  $('.timepicker'  ).timepicker({
    showMeridian: false,
    showInputs: false,
    format: 'HH:mm:ss',
    minuteStep: 1,
    showSeconds: true,
    maxDate : 'now'
  }).on('changeTime.timepicker', function(e) {
    var h = e.time.hours;     var m = e.time.minutes;    var mer = e.time.meridian;
    //convert hours into minutes
    m+=h*60;
    //10:15 = 10h*60m + 15m = 615 min
    if(mer=='AM' && m<615)    $('.timepicker').timepicker('setTime', '10:15:14');
  });

  $("#search").unbind('click');
  $('#search').on('click', function () {
    $.fn.getData();
  });


  $('#id_pay_ed'  ).on('select2:select', function (e) {
    $.fn.viewVoucher(e.params.data.id);
  });

  $('#id_bank_ed' ).on('select2:select', function (e) {
    $.fn.maxMinimo(e.params.data.id);
  });

  $(".btn-modalImg"  ).unbind('click');
  $('#recargas tbody').on('click','.btn-modalImg',  function () {
    var id = $(this).attr("data-id");
    $('#verimgTicket').html('<img src="'+id+'" class="img-responsive">');
  });

  $(".btn-modalEdit" ).unbind('click');
  $('#recargas tbody').on('click','.btn-modalEdit',  function () {
    var id = $(this).attr("data-id");
    $.fn.getDataID(id);
  });

  $("#editar").unbind('click');
  $('#editar').on('click', function () {
    var form = $( '#myformedit' ).serializeObject();
    $.fn.updateRecarga(form);
  });

});

$.fn.validaNumber   =  function (){
  var id_pay   = $("#id_pay").val();

  var id_bank   = $("#id_bank").val();
  var number_op = $("#number_operation").val();
  var date      = $("#date").val();
  var hour      = $("#hour_pay").val();
  var dato;
 if(id_pay == 1 || id_pay == 4){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
         type: "post",
         url: "/capitalDriver/validaNumber",
         dataType: "json",
         data: {
           id_bank : id_bank,
           number_op : number_op,
           date : date,
           hour : hour
        },
         success: function (d) { console.log(d);
           if(!d){
             $("#number_operation"   ).removeAttr("required");
             $("#number_operation").closest('.form-group').removeClass('has-success').addClass('has-error');
             $("#number_operation").closest('.form-group').find('.help-block').html("Advertencia !Numero de operacion ya registrado.");
            }
          }


     });
  }

}

$.fn.viewVoucher      = function(data) {
  $("#id_bank_ed"   ).removeAttr("required");
  $("#id_account_ed").removeAttr("required");

  $('#id_bank_ed'   ).val('').trigger('change');
  $('#id_account_ed').val('').trigger('change');
  $("#number_operation_ed").val('');


      if(data == 1 || data == 4){
        //mostrar
        $('#banks').show();
        $('#num'  ).show();
        $("#number_operation_ed").attr('required', 'required');
        $("#id_bank_ed"   ).attr('required', 'required');
        $("#id_account_ed").attr('required', 'required');
      }
      else if (data == 2 || data == 8) {
        //ocultar
        $('#banks').hide();
        $('#num'  ).hide();
      }else if (data == 9) {
        //ocultar
        $('#banks').hide();
        $('#num').hide();
      }else {
        $('#banks').hide();
        $('#num').show();
        $("#number_operation_ed"   ).attr('required', 'required');
        document.getElementById('number_operation_ed').setAttribute('maxlength',200);
        document.getElementById('number_operation_ed').setAttribute('minlength',10);

      }
}

$.fn.maxMinimo        = function(data) {
  if(data == 1 ){
    document.getElementById('number_operation_ed').setAttribute('minlength',10);
  }
  else if (data == 2 ) {
    document.getElementById('number_operation_ed').setAttribute('minlength',10);

  }else  {
    document.getElementById('number_operation_ed').setAttribute('minlength',10);

  }


}

$.fn.justNumbers      = function (e){
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
  return true;
  return /\d/.test(String.fromCharCode(keynum));
}

$.fn.updateRecarga    = function(form){

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
           data:  {form : form},
           url: "/capitalDriver/updateRecarga",
           dataType: "json",
           type:  "POST",
           success:  function (response) {
              alertify.alert('Actualizacion de Datos', response, function(){
                $.fn.getData();
                $("#modal-edit").modal('hide');

              });
             }
  });
 }

$.fn.getData          = function() {

  var start_date;
  var end_date;

  var date_range = $('#range_date').val()
  if (date_range){
    var dates = date_range.split(" - ");
    start_date = dates[0];
    end_date   = dates[1];
  }

  $.ajax({
    url: "/capitalDriver/getRecargas",
    type:"GET",
    data:{ datos      : $( '#myform' ).serializeObject(),
          start_date  : start_date,
          end_date    : end_date },
    beforeSend: function () {
    },
  }).done( function(d) {
    console.log(d.data);
    $.fn.fillDataTable(d.data);
  }).fail( function() {
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });

}

$.fn.fillDataTable    = function(data) {

  var table= $('#recargas').DataTable({
      'responsive'  : true,
      'responsive'  : false,
      'autoWidth': false,
      'destroy'   : true,
      "scrollX": true,
      "dom": '<"top"Bf>rt<"bottom"lip><"clear">',
      buttons: ['pageLength',
            {
              extend: 'pdfHtml5',
              text: 'PDF',
              messageBottom: null,
              download: 'open',
              orientation: 'landscape',
              pageSize: 'LEGAL',
              customize : function(doc) {doc.pageMargins = [30, 30, 30,30 ]; },


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
      data: data,
      "columns":[
          {data:"action"},
          {data:"ver"},
          {data:"codigo"},
          {data:"licencia"},
          {data:"name"},
          {data:"lastname"},
          {data:"document"},
          {data:"id_pay"},
          {data:"id_bank"},
          {data:"id_account"},
          {data:"number_operation"},
          {data:"date_pay"},
          {data:"date_saldo"},
          {data:"saldo_actual"},
          {data:"saldo_recarga"},
          {data:"status_user"},
          {data:"modified_by"},
          {data:"note"}
    ]
      });

  table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

}

$.fn.getDataID        = function(id) {
  $("#date_ed"      ).val('');
  $("#hour_pay_ed"  ).val('');
  $('#id_pay_ed'    ).val('').trigger('change');
  $('#id_bank_ed'   ).val('').trigger('change');
  $('#id_account_ed').val('').trigger('change');
  $('#number_operation_ed').val('');
  $('#saldo_ed'    ).val('');
  $('#id'          ).val('');

  $.ajax({
    url: "/capitalDriver/edit",
    type:"GET",
    data:{  id  : id,    },
    beforeSend: function () {
    },
  }).done( function(d) {
    $('#id'            ).val(d.id);
    $('#date_ed'       ).val(d.date_ed);
    $('#hour_pay_ed'   ).val(d.hour_pay_ed);
    $('#id_pay_ed'     ).val(d.id_pay_ed).trigger('change.select2');
    data = d.id_pay_ed;

    if(data == 1 || data == 4){
      //mostrar
      $('#banks').show();
      $('#num'  ).show();
      $("#number_operation_ed").attr('required', 'required');
      $("#id_bank_ed"   ).attr('required', 'required');
      $("#id_account_ed").attr('required', 'required');
      $('#id_bank_ed'    ).val(d.id_bank_ed).trigger('change.select2');
      $('#id_account_ed' ).val(d.id_account_ed).trigger('change.select2');
    }
    else if (data == 2 || data == 8) {
      //ocultar
      $('#banks').hide();
      $('#num'  ).hide();
    }else if (data == 9) {
      //ocultar
      $('#banks').hide();
      $('#num').hide();
    }else {
      $('#banks').hide();
      $('#num').show();
      $("#number_operation_ed"   ).attr('required', 'required');
      document.getElementById('number_operation_ed').setAttribute('maxlength',200);
      document.getElementById('number_operation_ed').setAttribute('minlength',10);

    }


    $('#saldo_ed'           ).val(d.saldo_ed);
    $('#number_operation_ed').val(d.number_operation_ed);
    document.getElementById('code').innerHTML =  d.code;


  }).fail( function() {
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
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
