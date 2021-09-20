$("#route_img").hide();
$("#token"    ).hide();

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
Culqi.publicKey = 'pk_test_f9Tgndd5Qnsx99Lj';
var amount = 3000;
$('#pay').on('click', function () {
  Culqi.settings({
   title: 'Recarga de capital taxistas.',
   currency: 'PEN',
   description: 'Venta de prueba',
   amount: amount
  });
  Culqi.open();
});

function culqi()
{
         var token = Culqi.token.id;
         console.log(Culqi);
          saveCustomer(token);
      };

function saveCustomer(token)
{
  var customer =
  {

    first_name : "Mario Jhony",
    last_name :"Gomez Lino",
    email : "mauro.gomez.lino.94@gmail.com",
    phone : "962888915",
    address : "Av Trapiche",
    id_city : 1,
    id_country : 1
  }
  $.ajax({
        url: "/customer/save",
        type:"post",
        data:{token:token,customer:customer,amount:amount},
        datatype:"json",
        beforeSend: function () {
              },
      }).done( function(d)
      {
        console.log(d);
        if(d.object=="error")
        {
          alert("Su pedido no fue procesada. Por el siguiente motivo: "+d.user_message);
        }
        else
        {
          saveSale(d);
        }
      }).fail( function() {

      }).always( function() {

        });
}

function saveSale(data)
{
        $.ajax({
              url: "/customer/sale",
              type:"post",

              data:{data:data},
              datatype:"json",
              beforeSend: function ()
            {
            },
            }).done( function(d)
            {
              console.log(d);
            }).fail( function() {

            }).always( function() {

              })
      }
//fin api Culqi


$(document).ready(function(){




  var f = new Date();

  $('#date').datepicker({
      today: "",
      clear: "Clear",
      autoclose: true,
      format: "yyyy/mm/dd",
      startDate: "1900/01/01",
      endDate:  f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate()
    }).val('');

  $('.select2').select2();

  $('.timepicker').timepicker({
      showMeridian: false,
      showInputs: false,
      format: 'HH:mm:ss',
      minuteStep: 1,
      showSeconds: true,
      maxDate : 'now'

    }).on('changeTime.timepicker', function(e) {
    var h= e.time.hours;
    var m= e.time.minutes;
    var mer= e.time.meridian;
    //convert hours into minutes
    m+=h*60;
    //10:15 = 10h*60m + 15m = 615 min
    if(mer=='AM' && m<615)
        $('.timepicker').timepicker('setTime', '10:15:14');
  });

  $("#search").unbind('click');

  $('#search').on('click', function () {
    var license_number   = $('#license_number').val();
    if(license_number){
      $.fn.getData(license_number);
    }else{
      alert("¡Debe rellenar el campo licencia!");//alerta del ticket no resgistrado
    }
   });

  $('#id_pay').on('select2:select', function (e) {
    $.fn.viewVoucher(e.params.data.id);
  });


  $("#searchAgain").unbind('click');

  $('#searchAgain').on('click', function () {
    $.fn.cleanData();
    $('#datos'       ).hide();
    $('#searchDiv'   ).hide();
    $('#search_panel').show();
   });

   $('#id_pay').on('select2:select', function (e) {
    $.fn.viewVoucher(e.params.data.id);
  });

  $("#myform").validate({
    rules: {
      saldo_recarga     : { range        : [50, 500]},
      number_operation  : { minlength    : 6, maxlength : 200},

    },
    onkeyup : true,
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
      $("#saldo_actual").prop('disabled', false);
      var id_pay = $("#id_pay").val();
      event.preventDefault();
      $.fn.submitForm(form,id_pay);

    }
  });




});


$.fn.submitForm     =  function (form, id_pay){
  if (id_pay == 9){
    $.fn.culqiPay();

  }else if (id_pay == 1 || id_pay == 4){
    if(upimg(form))
    {

    }
  }

  else{
    form.submit();

  }
}

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

$.fn.justNumbers    =  function (e){
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
  return true;
  return /\d/.test(String.fromCharCode(keynum));
}

$.fn.cleanData      = function(){

  $('#license'   ).empty();
  $('#first_name').empty();
  $('#last_name' ).empty();
  $('#phone'     ).empty();
  $('#email'     ).empty();

  $("#document"       ).val('');
  $("#date"      ).val('');
  $("#hour_pay"  ).val('');
  $('#id_driver' ).val('');


  $('#number_operation').val('');
  $('#saldo_actual'    ).val('');
  $('#saldo_recarga'   ).val('');
  $('#note'            ).val('');

  $('#id_pay'    ).val('').trigger('change');
  $('#id_country').val('').trigger('change');
  $('#id_bank'   ).val('').trigger('change');
  $('#id_account_type').val('').trigger('change');

}

$.fn.viewVoucher    = function(data) {
  $("#id_bank"        ).removeAttr("required");
  $("#id_account_type").removeAttr("required");
  $("#voucher_pago"   ).removeAttr("required");

  $('#id_bank'   ).val('').trigger('change');
  $('#id_account_type').val('').trigger('change');
  $("#number_operation").val('');


      if(data == 1 || data == 4){
        //mostrar
        $('#banks').show();
        $('#banks_2').show();

        $('#num'  ).show();
        $("#number_operation"   ).attr('required', 'required');
        $("#id_bank"   ).attr('required', 'required');
        $("#id_account_type").attr('required', 'required');
        $("#voucher_pago").attr('required', 'required');


      }
      else if (data == 2 || data == 8) {
        //ocultar
        $('#banks').hide();
        $('#banks_2').hide();

        $('#num'  ).hide();
      }else if (data == 9) {
        //ocultar
        $('#banks').hide();
        $('#banks_2').hide();
        $('#num').hide();
      }else {
        $('#banks').hide();
        $('#banks_2').hide();
        $('#num').show();
        $("#number_operation"   ).attr('required', 'required');
      }
}

$.fn.getData       = function(license_number) {
  $.ajax({
    url: "/capitalDriver/getDriver",
    type:"GET",
    data:{ license_number : license_number },
    beforeSend: function () {
    },
  }).done( function(d) {
    $.fn.fillDataTable(d.data);

  }).fail( function() {
    alert("¡Su busqueda ha sido fallida, valide los datos!");//alerta del ticket no resgistrado
  }).always( function() {
  });

}

$.fn.fillDataTable = function(data) {
  $('#datos').show();
  $('#searchDiv').show();
  $('#search_panel').hide();
  $('#id_driver').val(data.id);
  $('#phone').val(data.phone);

  document.getElementById('license'       ).innerHTML =  data.license_number;
  document.getElementById('first_name'    ).innerHTML =  data.first_name;
  document.getElementById('last_name'     ).innerHTML =  data.last_name;
  document.getElementById('phone'         ).innerHTML =  data.phone;
  document.getElementById('email'         ).innerHTML =  data.email;

  $("#document").val(data.document);
  $("#saldo_actual").val(data.saldo_actual);
  $("#saldo_actual").prop('disabled', true);
  $('#id_country').val( data.id_country ).trigger('change');

}

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
//------------------------------------------------------------------------------------------------------- subir img


fichero = document.getElementById("voucher_pago");
function upimg(form){//inicio up img
if($("#voucher_pago").is(':visible')){

  var respuesta = false;
  var d = new Date()
  var anio = d.getFullYear();
  var mes = d.getMonth()+1;
  var dia = d.getDay();
  var horas= d.getHours()
  var minutos = d.getMinutes()
  var segundos = d.getSeconds()
  var ramdom = Math.floor((Math.random() * 100) + 1);

  var nombreImg = ramdom.toString()+"_"+anio+"_"+mes+"_"+dia+" " +horas + ":" + minutos + ":" + segundos;
  if (fichero.files.length >= 1){
    storageRef = firebase.storage().ref();
    var imagenASubir = fichero.files[0];
    var uploadTask = storageRef.child('imgPago/'+nombreImg).put(imagenASubir);
    uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
    function(snapshot){
    //se va mostrando el progreso de la subida de la imagenASubir
    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    console.log('Upload is ' + progress + '% done');

    }, function(error) {
    //gestionar el error si se produce
    alert('Exite un error al tratar de subir la imagen');
    }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {

    console.log(downloadURL);
    $('#route_img').val(downloadURL);
    form.submit();

    });

    respuesta = true;
    });
  }else{  respuesta = false;    }
  } else respuesta = true;

  return respuesta;
}//fin de up img
