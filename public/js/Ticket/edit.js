$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
 var id_ticket;
 var id_customer
$.ajax(
  {
    url: "/ticket/getTicket",
    type:"GET",
    data : { id: $("#id_ticket_import").val() },//
    beforeSend: function () {

          }
  }).done(function(d)
  {
       $('#document').html(d.get_customer.document);
       $('#id_ticket').html(d.cod_ticket);
        $('#nro_book').html(d.nro_book);
        $('#name').html(d.get_customer.last_name+ ", "+d.get_customer.first_name);
      id_ticket = d.id;
      id_customer = d.get_customer.id;
  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket
  });


  $(function() {
     $( "#dni_destino" ).autocomplete({
                source: "/ticket/getCustomer",
                minLength: 2,
                select: function( event, ui ) {
                $( "#dni_destino" ).val( ui.item.desc );
                  $('#name_destino').html(ui.item.label);
                  id_customer = ui.item.value;
                  return false;
               }
             });
   });

   function edit()
   {
     if(id_ticket!=null || id_ticket !="")
     {
       if(id_customer!=null || id_customer !="")
       {
         guardar();
       }
       else
       {
         alert("Falta seleccionar la persona de destino . No se realizó ningun cambio.");
       }
     }
     else
     {
       alert("Falta el codigo de ticket. No se realizó ningun cambio.");
     }
   }

   function guardar()
   {
     $.ajax(
       {
         url: "/ticket/edit",
         type:"GET",
         data : {
           id_customer: id_customer,
           id_ticket:id_ticket//$("id_ticket").val()
       },//
         beforeSend: function () {

               }
       }).done(function(d)
       {
            location.reload();
       }).fail(function(){
         alert("¡Ha ocurrido un error en la operación!");//alerta del ticket
       });
   }
