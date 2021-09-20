$(document).on('change', '#cod_country', function(event) {
     var id = $("#cod_country option:selected").val();
     $('.alertpaisacc').remove();
     $('.depval').show();
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getState",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_state').empty();
         var fila = '<option>Seleccionar departamento</option>';
         $.each(d,function(key, registro)
         {
           fila += '<option value='+registro.id+'>'+registro.description+'</option>';
         });
         $("#cod_state").append(fila);

       }).fail(function(){
         alert("No trajo datos de los estados ");//alerta del ticket no resgistrado
       });
});


$(document).on('change', '#cod_state', function(event) {
     var id = $("#cod_state option:selected").val();
     $('.alertdepacc').remove();
     $('.proval').show();
     //alert("entre");
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax(
       {
         url: "/customer/getCity",
         type:"POST",
         data : {  id: id},//
         dataType: "json",
       }).done(function(d)
       {

         $('#cod_city').empty();
         var filas = '<option>Seleccionar provincia</option>';
         $.each(d,function(key, registro)
         {
           filas += '<option value='+registro.id+'>'+registro.description+'</option>';

        });
          $("#cod_city").append(filas);

       }).fail(function(){
         alert("No se Registro Intente Nueva Mente");//alerta del ticket no resgistrado
       });
});

var respuestaDniShareValidate = false;
$('#document').keyup(function() {
   validateDNIShareholder();
});

var respuestaUsuarioShareValidate = false;
$('#usuario').keyup(function() {
   validateUsuarioShareholder();
});

function validateUsuarioShareholder(){
  var valor = $("#usuario").val();
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/report/customerRedTaxiWin",
      type:"POST",
      data : { data: valor },//
      dataType: "json",
      beforeSend: function () {
         $('#load_inv').show(300);
    }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      if(d.mensaje.length === 0)
      {
        $('#usuario').css("border", "2px solid red");
      } else {
        $('#usuario').css("border", "2px solid green");
        $.each(d.mensaje, function( k, v )
        {
          var id = $("#document").val(v.document);
          validateDNIShareholder();
        });
      }
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");
    });
}

function validateDNIShareholder()
{
  var id = $('#document').val();
  numcar = id.length;

  if (numcar > 5){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/customer/valiteDNI",
      type:"POST",
      data : {cod: id },
      dataType: "json",
    }).done(function(d)
    {
      if(d.mensaje){
         $('.alertdni').remove();
         $('#document').css("border", "2px solid red");
         $('#document').focus();
       respuestaDniShareValidate = false;
     }else{
       $('#document').css("border", "2px solid green");
       $('.alertdni').remove();
       respuestaDniShareValidate = true;
   }
    }).fail(function(){

    });
  }
  return respuestaDniShareValidate;
}


//al precionar borrar
jQuery(function($) {
  var input = $('#document');
  input.on('keydown', function() {
    var key = event.keyCode || event.charCode;
      $( "#first_name" ).prop( "disabled", false );
      $( "#last_name" ).prop( "disabled", false );
      $( "#phone" ).prop( "disabled", false );
      $( "#email" ).prop( "disabled", false );
      $("#first_name").val("");
      $("#last_name").val("");
      $("#phone").val("");
      $("#email").val("");

  });
});

jQuery(function($) {
  var input = $('#usuario');
  input.on('keydown', function() {
    var key = event.keyCode || event.charCode;
      $( "#first_name" ).prop( "disabled", false );
      $( "#last_name" ).prop( "disabled", false );
      $( "#phone" ).prop( "disabled", false );
      $( "#email" ).prop( "disabled", false );
      $("#document").val("");
      $("#first_name").val("");
      $("#last_name").val("");
      $("#phone").val("");
      $("#email").val("");

  });
});

function onKeyDownHandler(event)
{
    var codigo = event.which || event.keyCode;

    if(codigo === 13){//Al precionar enter
      if ($("#document").css("border") == '2px solid rgb(255, 0, 0)'){
        alert('Ya existe un customer con ese DNI');
      }else{
        getCustomerWinIstoShare();
      }
    }

}

function onKeyDownHandleruser(event){
  var codigo = event.which || event.keyCode;
  if(codigo === 13){//Al precionar enter
    if ($("#document").css("border") == '2px solid rgb(255, 0, 0)'){
      alert('Ya existe un customer con ese DNI');
    }else{
      getCustomerTaxiWin();
    }
  }
}

function getCustomerWinIstoShare()
{
    var valor = $("#document").val();
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/report/customerWinIstoShareAndTaxiWin",
      type:"POST",
      data : { data: valor },//
      dataType: "json",
      beforeSend: function () {
                    $('#load_shareholder').show(300);
            }
    }).done(function(d)
    {
      $('#load_shareholder').hide(300);
      console.log(d.mensaje);
      if(d.mensaje.length === 0)
      {
        alert('no hay registros en winistoshare');
      }else{
        if (d.dato == 'reniec'){
          $("#first_name").val(d.mensaje.first_name);
          $("#last_name").val(d.mensaje.last_name);
          $( "#first_name" ).prop( "disabled", true );
          $( "#last_name" ).prop( "disabled", true );
          $( "#usuario" ).prop( "disabled", true );
        }else{
          $.each(d.mensaje, function( k, v )
          {
             $("#first_name").val(v.first_name);
             $("#last_name").val(v.last_name);
             $("#phone").val(v.phone);
             $("#email").val(v.email);
          });
          $( "#first_name" ).prop( "disabled", true );
          $( "#last_name" ).prop( "disabled", true );
          $( "#phone" ).prop( "disabled", true );
          $( "#email" ).prop( "disabled", true );
          $( "#usuario" ).prop( "disabled", true );
        }
        action = 0;
     }
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
}

function getCustomerTaxiWin()
{
  var valor = $("#usuario").val();
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/report/customerRedTaxiWin",
      type:"POST",
      data : { data: valor },//
      dataType: "json",
      beforeSend: function () {
                    $('#load_inv').show(300);
            }
    }).done(function(d)
    {
      $('#load_inv').hide(300);

      if(d.mensaje.length === 0)
      {
        alert("No se encontro Datos en taxiwin.in");
      }
      else
      {
        $.each(d.mensaje, function( k, v )
        {
           $("#document").val(v.document);
           $("#first_name").val(v.first_name);
           $("#last_name").val(v.last_name);
           $('#phone').val(v.billing_phone);
           $('#email').val(v.billing_email);
        });
        $( "#first_name" ).prop( "disabled", true );
        $( "#last_name" ).prop( "disabled", true );
        $( "#phone" ).prop( "disabled", true );
        $( "#email" ).prop( "disabled", true );
      }

    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
}


function registerTicket(){
  $( "#first_name" ).prop( "disabled", false );
  $( "#last_name" ).prop( "disabled", false );
  $( "#phone" ).prop( "disabled", false );
  $( "#email" ).prop( "disabled", false );

  $.ajax(
    {
      url: "/customer/savecustomer",
      type:"POST",
      data : { customer : $( '#myform' ).serializeObject()},//
      dataType: "json",
      beforeSend: function () {
        $('.docs-example-modal-sm').modal('toggle');
  },
    }).done(function(d)
    {
      if(d.answer){
          $("form select").each(function() { this.selectedIndex = 0 });
          $("form input[type=text] , form textarea").each(function() { this.value = '' });
          $("#cod_city" ).empty();
          $("#cod_state" ).empty();
          $("#email" ).empty();
          $(".cuerpo").empty();
          alertify.confirm('Registrado', '¡El cliente ha sido registrado correctamente', function(){
              alertify.success('Registrado');
          },function(){
          }).set();
      } else {
        alert("no se pudo resgistrar Correctamente el customer");
      }
    }).fail(function(){
      alert("¡Ha ocurrido un error en la operación!");//alerta del customer no resgistrado
    });

    $( "#first_name" ).prop( "disabled", true );
    $( "#last_name" ).prop( "disabled", true );
    $( "#phone" ).prop( "disabled", true );
    $( "#email" ).prop( "disabled", true );
}

$('#btnCreateShareholder').on('click',function(){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
           var dni = $('#document').val().length;
           if ($("#document").css("border") == '2px solid rgb(255, 0, 0)'){
             alert('El cliente ya esta registrado');
           }else{
           if(valNull(".customer input"))
           {
             if($( "#cod_country" ).val() == "")
             {
               alert("Ingrese El pais");
               $("#cod_country").focus();
             } else if($("#cod_state").val() =="Seleccionar departamento")
             {
               alert("Ingrese Departamento");
               $("#cod_state").focus();
             }
             else if($("#cod_city").val() =="Seleccionar provincia")
             {
               alert("Ingrese Provincia ");
               $("#cod_city").focus();
             }
             else if($("#district").val()=="")
             {
               alert("Ingrese lugar donde vive(Dirección)");
               $("#cod_city").focus();
             }else {
               registerTicket();
             }
           }
         }
});

function valNull(variable)
{
  var id;
  var respuesta = false;
  $( variable ).each(function( index )
  {
    id = '#'+$(this).attr('id');
    if($( this ).val()=="")
    {
      $(id).attr('style',  'border:5px solid red');
      $(id).focus();
      respuesta = false;
    }
    else
    {
      if($(id).attr("style"))
      $(id).removeAttr('style',  'border:5px solid red');
      respuesta = true;
    }
  });
  return respuesta;
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
