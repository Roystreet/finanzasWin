// var f = [
//    {id: 1,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    {id: 2,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true},
//    // {id: 3,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    // {id: 4,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true},
//    // {id: 5,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    // {id: 6,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true},
//    // {id: 7,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    // {id: 8,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true}
//  ];
// formCreate('#midiv',f);
 $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
$("#boton").click(function () {

if(estado&& ($('#document').val() != "" || $('#document').val() != null) ){
  $.ajax(
    {
      url: "/customer/form/register",
      type:"POST",
      data : {
        document : $('#document').val(),
        doc : $('input:radio[name=doc]:checked').val(),
         p1 : $('input:radio[name=optradio]:checked').val(),
         p2 : $('input:radio[name=optradio1]:checked').val(),
         p3 : $('input:radio[name=optradio2]:checked').val(),
         p4 : $('input:radio[name=optradio3]:checked').val()
      },//
      dataType: "json",
      beforeSend: function () {


            },
    }).done(function(d)
    {
      if(d.mensaje !="warning")
      {
        alert("Su voto a sido exitoso. Gracias");
      }
      else {
        alert("Ya Voto");
      }

      window.location.href = "/customer/form";
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });

}
else {
  alert("Datos Incorrectos");
}
    });

var estado=false;
    $("#condni").click(function () {


          $.ajax(
            {
              url: "/customer/testDB",
              type:"POST",
              data : {
                 document : $('#document').val(),
              },//
              dataType: "json",
              beforeSend: function () {


                    },
            }).done(function(d)
            {
              if(d.objet!="warning")
              {
                estado=true;
                $('#datos').html(d.data.first_name +", "+d.data.last_name);
              }
              else {
                alert("No esta registrado");
                estado=false;
              }
            }).fail(function(){
              estado=false;
              alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
            });
        });
