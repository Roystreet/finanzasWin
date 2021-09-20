$(document).ready(function()
{
  $('#cod_country').select2();
  $('#cod_state').select2();
  $('#cod_city').select2();

  var d = new Date();

  var month = d.getMonth()+1;
  var day = d.getDate();

  var output =
      (day<10 ? '0' : '') +  day + ' de ' +
      (month<10 ? '0' : '') + month + ' del ' +d.getFullYear()  ;

  $('#dateact').html('<b >Fecha: </b> '+output);


$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$('#btn_ajax').on('click',function(){

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

$(document).on('change', '#cod_country', function(event) {
     var id = $("#cod_country option:selected").val();
     $('.depval').show();
     $.ajax(
       {
         url: "/customer/register/getState",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_state').empty();
         var fila = '<option value="">Seleccionar departamento</option>';
         $.each(d,function(key, registro)
         {
           fila += '<option value='+registro.id+'>'+registro.description+'</option>';
         });
         $("#cod_state").append(fila);

       }).fail(function(){
         alert("No se cargaron los datos");//alerta del ticket no resgistrado
       });
});
//obtener city
$(document).on('change', '#cod_state', function(event) {
     var id = $("#cod_state option:selected").val();
     $.ajax(
       {
         url: "/customer/register/getCity",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_city').empty();
         var filas = '<option value="">Seleccionar provincia</option>';
         $.each(d,function(key, registro)
         {
           filas += '<option value='+registro.id+'>'+registro.description+'</option>';

        });
          $("#cod_city").append(filas);

       }).fail(function(){
         alert("No se cargaron los datos");//alerta del ticket no resgistrado
       });
});
