
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var id_ticket;
$(document).ready(function(){
  var f = new Date();
  var table;
  $('.select2').select2();

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


	$('#date_pay' ).daterangepicker({
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
  $('input[name="date_pay"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
  $('input[name="date_pay"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });



  table = $('#tickets').DataTable({
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

	$("#clean").unbind('click');
  $('#clean').on('click', function () {
    $('#myform')[0].reset();
		$('#id_pay'       ).val('').trigger('change');
		$('#id_money'     ).val('').trigger('change');
		$('#id_customer'  ).val('').trigger('change');
		$('#id_invited_by').val('').trigger('change');
		$('#modified_by'  ).val('').trigger('change');
		$('#id_country_inv'   ).val('').trigger('change');
		$('#status_user'  ).val('').trigger('change');
		$('#id_product'   ).val('').trigger('change');




   });

  $(".btn-modalImg").unbind('click');
  $('#tickets tbody' ).on('click','.btn-modalImg',  function () {
     var id = $(this).attr("data-id");
     $('#verimgTicket').html('<img src="'+id+'" class="img-responsive">');
   });

});


$.fn.getData          = function() {

  var start_datec;  var end_datec;
  var start_datep;  var end_datep;

  var created_at = $('#created_at').val()
  if (created_at){
    var dates = created_at.split(" - ");
    start_datec = dates[0];     end_datec   = dates[1];
  }
	var date_pay = $('#date_pay').val()
	if (date_pay){
		var dates = date_pay.split(" - ");
		start_datep = dates[0];     end_datep   = dates[1];
	}

  $.ajax({
    url: "/tickets/getDataTickets",
    type:"GET",
    data:{ datos      : $( '#myform' ).serializeObject(),
          start_datep  : start_datep,
          end_datep    : end_datep,
					start_datec  : start_datec,
					end_datec    : end_datec,
				 },
    beforeSend: function () {
      $('#load_inv').show(300);
    },
  }).done( function(d) {
    $('#load_inv').hide(300);
    $.fn.fillDataTable(d.data);
  }).fail( function() {
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  }).always( function() {
  });

}

$.fn.fillDataTable    = function(data) {
  var details = true;
  var download = true;
  var vergene  = $('#ids').attr("vergene");
  var verespe  = $('#ids').attr("verespe");
  var rolid  = $('#ids').attr("rolid");

  var table= $('#tickets').DataTable({
      'destroy'   : true,
      'scrollX'     : true,
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
        {
               sortable: false,
               "render": function ( data, type, full, meta ) {
               var url = window.location.pathname;
               var url = url.split("/")[1];
               var d = "";
               if (url == 'tickets')   {    d = "/customers/";  }
               if (url == 'admin')     {    d = "/admin/customers/";  }
               if (url == 'atencion')  {    d = "/atencion/customers/";   }
                if (full.detailsticket){
                  return '<div class="tickets"  ><a href="'+d+full.customerid+'"><i class="fa fa-cog icon-report" title="Detalles del Cliente"></i></a></div>';
                }else{
                  details = false;
                  return details;
                }


                 }
        },
        {
               sortable: false,
               "render": function ( data, type, full, meta ) {
                 if (full.downloadticket){
                   return '<div class="tickets"  ><a href="/tickets/pdf/'+full.idticket+'"><i class="fa fa-download icon-report" title="Descargar"></i></a></div>';
                 }else{
                   download = false;
                   return download;
                 }



                 }
        },
        {
               sortable: false,
               "render": function ( data, type, full, meta ) {

                   return '<div class="tickets"  ><a data-target="#modal-viewTicketbyID" data-toggle="modal" data-id='+full.idticket+' id="viewticketid"><i class="fa fa-eye icon-report" title="Vista"></i></a></div>';
                 }
         },
          {data:"code_ticket"},
          {data:"name"},
          {data:"lastname"},
          {data:"document"},
          {data:"id_product"},
          {data:"cant_acc"},
          {data:"id_pay"},
          {data:"number_operation"},
          {data:"id_banck"},
          {data:"total"},
          {data:"id_money"},
          {data:"created_at"},
					{data:"date_pay"},
          {data:"name_inv"},
          {data:"lastname_inv"},
          {data:"dni_inv"},

					{data:"id_pay_inv"},
          {data:"total_inv"},
          {data:"fecha_cobro"},
					{data:"resp_inv"},
					{data:"observ_inv"},

					{data:"num_libro"},
          {data:"pais_inv"},
					{data:"note"},
          {data:"donate"},
					{data:"status_user"},
          {data:"modified_by"}
    ]
  });
  table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  if (!details){
  // Get the column API object
  var column = table.column(0);
  // Toggle the visibility
  column.visible(!column.visible());
  }

  if (!download){
    // Get the column API object
    var column1 = table.column(1);
    // Toggle the visibility
    column1.visible(!column1.visible());
  }
  console.log(rolid);
  if (vergene == false && rolid != 4){
     //visibilidad de columnas
     var column = table.column(7);
     column.visible(!column.visible());
     var column1 = table.column(9);
     column1.visible(!column1.visible());
     var column2 = table.column(10);
     column2.visible(!column2.visible());
     var column3 = table.column(11);
     column3.visible(!column3.visible());
     var column4 = table.column(12);
     column4.visible(!column4.visible());
     var column5 = table.column(13);
     column5.visible(!column5.visible());
     var column6 = table.column(14);
     column6.visible(!column6.visible());
     var column7 = table.column(18);
     column7.visible(!column7.visible());
     var column8 = table.column(19);
     column8.visible(!column8.visible());
     var column9 = table.column(20);
     column9.visible(!column9.visible());
     var column10 = table.column(21);
     column10.visible(!column10.visible());
     var column11 = table.column(22);
     column11.visible(!column11.visible());
     var column12 = table.column(24);
     column12.visible(!column12.visible());
     var column13 = table.column(25);
     column13.visible(!column13.visible());
     var column14 = table.column(26);
     column14.visible(!column14.visible());
     var column15 = table.column(27);
     column15.visible(!column15.visible());
     var column16 = table.column(28);
     column16.visible(!column16.visible());
  }




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

$('#tickets tbody').on('click','#viewticketid',function () {
     var id  = $(this).attr("data-id");
     id_ticket = id;
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
function descargarTicket()
{
   window.location.href = "/tickets/pdf/"+id_ticket;
}
