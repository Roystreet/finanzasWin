$(document).ready(function() {

  $('#notify-button').on('click', function () {
    alert('holi');
    notificaciones(holi = 'fdg',boli ='dsdf');
    //audioElement.play();
   });

   var view;

   function load_unseen_notification(view = ''){
      $.ajax({
        url: "/atencion/notificationsget",
        type:"GET",
        data:{view:view},
        beforeSend: function () {
        },
      }).done( function(data) {
        console.log(data);
        $('.dropdown-menuss').html('');
       if(data.unseen_notification > 0)
       {
        $.each(JSON.parse(data.notification), function( key, value ) {
           $(".dropdown-menuss").append('<li><a href="#" class="dropdown-toggless" data-id="'+value.id+'"><i class="fa fa-users text-aqua"></i>'+value.comment_subject+' '+value.comment_text+'</a></li>');
           notificaciones(value.comment_subject,value.comment_text);
        });
        $('.countss').html(data.unseen_notification);
      }else{
        $('.countss').html('0');
      }
      }).fail( function(error) {
        console.log(error);
        alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
      }).always( function() {
      });
   }

load_unseen_notification();

$(document).on('click', '.dropdown-toggless', function(){
 $('.countss').html('');
 load_unseen_notification($(this).attr("data-id"));
});

setInterval(function(){
 load_unseen_notification();;
}, 2000);


});
