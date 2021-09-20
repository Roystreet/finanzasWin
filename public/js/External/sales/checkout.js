
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

var key_private;
var monto = $('#pago').attr("data-amount");
var description = $('#pago').attr("data-desc");
var money = $('#pago').attr("data-mon");
var dni = $('#pago').attr("data-dni");
var idti = $('#pago').attr("data-id");
getkeyPublic();
  function getkeyPublic()
  {
    $.ajax(
      {
        url: "/customer/register/exeterno/keyPrivate",
        type:"POST",
        data : {  id:"Kjd$h-¨´f$fn55866d@fjjnan"},//
        dataType: "json",
      }).done(function(d)
      {
        key_private = d;
      }).fail(function(){
        alert("Error en Culqi");//alerta del ticket no resgistrado
      });
  }
var order;
getOrder();
  function getOrder()
  {
    $.ajax(
      {
        url: "/customer/register/exeterno/order",
        type:"POST",
        data : {  id:"Kjd$h-¨´f$fn55866d@fjjnan"},//
        dataType: "json",
      }).done(function(d)
      {
        order = d.data;
      }).fail(function(){
        alert("Error en Culqi");//alerta del ticket no resgistrado
      });
  }

  $('#btn_culqi').on('click', function(e) {
      // Crea el objeto Token con Culqi JS
      Culqi.publicKey = key_private;
      // Configura tu Culqi Checkout
      Culqi.settings({
        title: 'WIN TECNOLOGIES INC SA',
        currency: money,
        description: description,
        amount: monto.split(".")[0]+"00",
      });

      Culqi.open();
        e.preventDefault();
  });

  function culqi() {
    if (Culqi.token) { // ¡Objeto Token creado exitosamente!
        var token = Culqi.token.id;
        var register =
        {
          token: token,
          money: money,
          amount: monto.split(".")[0]+"00",
          document: dni
        }

        $.ajax(
          {
            url: "/customer/register/exeterno/tarjeta",
            type:"POST",
            data : {  register : register},
            dataType: "json",
            beforeSend: function () {
            $('.loader-container').show(300);
          }
          }).done(function(d)
          {
            $(".loader-container").css("display", "none");
            if (d.object == "error"){
              alertify.alert(d.data.type, d.data.merchant_message, function(){ alertify.error('error'); });
            }else{
              alertify.alert(d.data.outcome.type, d.data.outcome.user_message, function(){ alertify.success('Ok'); });
              actualizarticket(d.object,d.data.id);
            }

          }).fail(function(){
            alert("Error en tarjeta 1");
          });
    } else { // ¡Hubo algún problema!
        // Mostramos JSON de objeto error en consola
        alertify.alert(Culqi.error.type, Culqi.error.user_message, function(){ alertify.error('error'); });
    }
  };

  function actualizarticket(estado,tokenid){
    var ticketdet =
    {
      estado: estado,
      tokenid: tokenid,
      idticket: idti,
    }


    $.ajax(
      {
        url: "/customer/register/exeterno/actualizarti",
        type:"POST",
        data : {  ticketdet : ticketdet },
        dataType: "json",
        beforeSend: function () {
        $('.loader-container').show(300);
      }
      }).done(function(d)
      {
        // console.log(d);

          sendmail(idti);
            if (d.mensaje == "exito"){
              window.location.href = "/checkout/ticket/view/"+idti;
            }else{

            }

      }).fail(function(){
        alert("Error en tarjeta 3");
      });
  }
  function sendmail(idti){
    var external = 12;
    $.ajax({
      url: "/send/email/ticket",
      type: "POST",
      data: {id : idti , external : external},
      dataType: "json",
      beforeSend: function () {
        },
    }).done(function(d){
      $(".loader-container").css("display", "none");
      console.log("mensaje ticket activado enviado");
    }).fail(function(){
      alert("No se pudo procesar la solicitud");
    });
  }
