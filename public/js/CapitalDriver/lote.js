$(document).ready(function(){
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
           "firstDay": 1
       },
       "startDate": "2019-01-01",
       "opens": "center"
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

  $('#id_pay').on('select2:select', function (e) {
    $.fn.viewVoucher(e.params.data.id);
  });

  $('#recargas tbody').on('click','#changeStatus',           function () {
     var id     = $(this).attr("data-id");
     var status = $(this).attr("statussis");

     alertify.confirm('VALIDAR REGISTRO DE PAGO - RECARGA CONDUCTOR', '   ¿Está usted seguro que desea realizar esta operación?', function(){
        $.fn.updateStatus(id, status, table);
     },function(){
     }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});

  });
  $(".btn-modalImg").unbind('click');
  $('#recargas tbody' ).on('click','.btn-modalImg',  function () {
    var id = $(this).attr("data-id");
    $('#verimgTicket').html('<img src="'+id+'" class="img-responsive">');
  });

  $("#myform").validate({
     rules: {
     },
     onkeyup :false,
     errorPlacement : function(error, element) {
      $(element).closest('.form-group').find('.help-block').html(error.html());
      },
      highlight : function(element) {
      $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      unhighlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      $(element).closest('.form-group').find('.help-block').html('');
      },
     submitHandler: function(form) {
       $.fn.getData();
     }
   });


  $('.select-all').click(function(event) {
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


  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass   : 'iradio_flat-blue'
  });

  $("#allRecargas").unbind('click');
  $('#allRecargas').on('click', function () {
    $.fn.saveRides();
  });



});


$.fn.saveRides             = function() {

  var codigos = [];

  $('input:checkbox[name="saldo_id[]"]').each(function(){
    if($(this).is(':checked'))
    codigos.push($(this).val());
  });

  if (codigos.length != 0){

    alertify.confirm('Con esta opcion estará generando una nueva orden', '\t\t Confirma que desea continuar con la operación!',
    function(){
      $("#saldo_actual").prop('disabled', false);

      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      $.ajax({
          url: "/capitalDriver/recargando",
          type:"get",
          data: {'codigos': codigos },
          dataType: "json",
          beforeSend: function () {
            },
      }).done( function(d) {
        alertify.alert('Recarga de Lote', d.mensaje, function(){
          $.fn.getData();
        });
      }).fail( function() {
        alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
      }).always( function() {
      });


    },
    function(){  alertify.error('Cancelar')  });

  }else{
    alertify.alert('Advertencia', 'Selecciona al menos un items', function(){
    });
  }





}
$.fn.updateStatus       = function(id, status, table){

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
           data:  {status : status, id : id},
           url: "/capitalDriver/updateStatus",
           dataType: "json",
           type:  "POST",
           success:  function (response) {
              alertify.alert('Gestion de Estatus', response.mensaje, function(){
                $.fn.getData();
              });
             }
  });
 }

$.fn.viewVoucher        = function(data) {
  $("#id_bank"   ).removeAttr("required");
  $("#id_account_type").removeAttr("required");
  $('#id_bank'   ).val('').trigger('change');
  $('#id_account_type').val('').trigger('change');

      if(data == 1 || data == 4){
        //mostrar
        $('.banks').show();
        $("#id_bank"   ).attr('required', 'required');
        $("#id_account_type").attr('required', 'required');

      }
      else if (data == 2 || data == 8) {
        //ocultar
        $('.banks').hide();
      }else if (data == 9) {
        //ocultar
        $('.banks').hide();
      }else {
        $('.banks').hide();
      }
}

$.fn.getData            = function() {
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
    $.fn.fillDataTable(d.data);
  }).fail( function() {
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });

}

$.fn.fillDataTable      = function(data) {

    $('#recargas').DataTable({  'responsive'  : true,
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

}

$.fn.serializeObject    = function(){
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

$.extend( $.validator.messages, {
    required: "Este campo es obligatorio.",
    remote: "Por favor, rellena este campo.",
    email: "Por favor, escribe una dirección de correo válida.",
    url: "Por favor, escribe una URL válida.",
    date: "Por favor, escribe una fecha válida.",
    dateISO: "Por favor, escribe una fecha (ISO) válida.",
    number: "Por favor, escribe un número válido.",
    digits: "Por favor, escribe sólo dígitos.",
    creditcard: "Por favor, escribe un número de tarjeta válido.",
    equalTo: "Por favor, escribe el mismo valor de nuevo.",
    extension: "Por favor, escribe un valor con una extensión aceptada.",
    maxlength: $.validator.format( "Por favor, no escribas más de {0} caracteres." ),
    minlength: $.validator.format( "Por favor, no escribas menos de {0} caracteres." ),
    rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
    range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
    max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
    min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),
    nifES: "Por favor, escribe un NIF válido.",
    nieES: "Por favor, escribe un NIE válido.",
    cifES: "Por favor, escribe un CIF válido.",
});
