$(document).ready(function()
{

$('#btn_ajax').on('click',function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     if($('#email').val() == "")
     {
       alert("Ingresa un email");
     }else if ($('#subject').val() == "") {
       alert("Ingresa un asunto");
     }else if ($('#description').val() == "") {
       alert("Ingresa un mensaje");
     }else{
       registerticketfreshdesk();
     }
  });

  function registerticketfreshdesk()
  {

    var formData = new FormData($("#formfreshdeks")[0]);

    $.ajax(
      {
        url: "/freshdesk/store",
        type:"POST",
        data : formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
          $('.docs-example-modal-sm').modal('toggle');
              },
      }).done(function(d)
      {
        console.log(d.message);
        // if(d.message)
        // {
        //     alertify.alert('WIN TECNOLOGIES INC','Se envio correctamente el mensaje!');
        //     console.log(d.message);
        // } else {
        //   alert("no se pudo enviar el ticket");
        // }
      }).fail(function(){
        alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
      });

      $( "#email" ).val("");
      $( "#subject" ).val("");
      $( "#description" ).val("");
      $('#myFile').val(null);
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

});
