$('.register2').hide();
$('.register3').hide();
$('.register4').hide();
$('.typedocumentextra').hide();
var typeuser = 0;
var typereque = 0;
var idcustomer = 0;
var typedoc = 0;
var nrodoc = 0;
var idtypeuser = 0;
var firtsname;
var lastname;
var dni;

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(".buttonwin").click(function() {
  typeuser = $(this).attr("data-id");
  $('.register1').hide();
  $('.register2').show();
  $("#v1").removeClass("active");
  $("#v2").last().addClass("active");
  $('#welcomediv').hide();
});

$(".ordens").click(function() {
  if ($(this).attr("data-id") > $('.active').attr('data-id')){
  }else{
    $("#type_docs").val("").trigger('change');
    $('#dni').val("");
    $('#firstnameextra').val("");
    $('#lastnameextra').val("");
    var divah = $(this).attr("id");
    var numberdiv = $(this).attr("data-id");
    $('.divregister').show();
    $('.register'+$('.active').attr('data-id')).hide();
    $('.register'+$(this).attr("data-id")).show();
    $("#v"+$('.active').attr('data-id')).removeClass("active");
    $("#v"+numberdiv).last().addClass("active");
    if ($(this).attr("data-id") == 1){
      $('#welcomediv').show();
    }else{
      $('#welcomediv').hide();
    }
  }
});


$(".btnrequeriments").click(function() {
  typereque = $(this).attr("data-id");
  $('.register1').hide();
  $('.register2').hide();
  $('.register3').show();
  $("#v2").removeClass("active");
  $("#v3").last().addClass("active");
  $('#typeUsuario').html(typeuser);
  $('#welcomediv').hide();
});

$("#type_docs").change(function(){
    $('#dni').val('');
    var op = $("#type_docs option:selected").text();
    if (op == 'Selecciona') {
      $('.typedocumentextra').hide();
      $('#dni').prop("disabled", true);
    }else if (op == 'DNI'){
      $('.typedocumentextra').hide();
      $('#dni').prop("disabled", false);
    }else{
      $('#dni').prop("disabled", false);
      $('.typedocumentextra').show();
    }
 });

 $('.input-number').on('input', function () {
     var ops = $("#type_docs option:selected").text();
     if (ops == 'DNI'){
      this.value = this.value.replace(/[^0-9]/g,'');
      $(".input-number").prop('maxLength', 8);
     }else{
      $(".input-number").prop('maxLength', 30);
     }
 });

$(".btnsearch").click(function() {
  typedoc = $("#type_docs option:selected").val();
  nrodoc = $('#dni').val();
  if (typedoc == ""){
    alertify.notify('Selecciona tipo de documento','error',2, function(){});
  }else if (nrodoc == ""){
    alertify.notify('Ingrese numero de documento','error',2, function(){});
  }else if (typedoc != 1 && $('#firstnameextra').val() == ""){
    alertify.notify('Ingrese nombre','error',2, function(){});
  }else if (typedoc != 1 && $('#lastnameextra').val() == ""){
    alertify.notify('Ingrese apellido','error',2, function(){});
  }else{
    $.ajax(
    {
      url: "/atencion/customer/driver/getVal",
      type:"GET",
      data : { dni: nrodoc, type: typedoc, search: typeuser},//
      dataType: "json",
      beforeSend: function () {
                    $('#load_inv').show(300);
                  }
    }).done(function(d)
    {
      $('#load_inv').hide(300);
      $('.register1').hide();
      $('.register2').hide();
      $('.register3').hide();
      $('.register4').show();
      $("#v3").removeClass("active");
      $("#v4").last().addClass("active");
      $('#typeUsuario1').html(typeuser);
      idtypeuser = (d.type);
      if (d.portal == "reniec" && d.object == "success"){
          if (d.data.first_name == null){
            var firstextra =  $('#firstnameextra').val();
            var lastextra = $('#lastnameextra').val();
            var nrodoc   =  $('#dni').val();
            $('#first_name').html(firstextra+' '+lastextra);
            $('#nrodocs').html(nrodoc);
            firtsname = firstextra;
            lastname = lastextra;
            dni = dniextra;
          }else{
            $('#first_name').html(d.data.first_name+' '+d.data.last_name);
            $('#nrodocs').html(d.data.dni);
            idcustomer = 0;
            firtsname = d.data.first_name;
            lastname = d.data.last_name;
            dni = d.data.dni;
          }
      }else if (d.portal == "webpasajero" && d.object == "success" || d.portal == "webaccionista" && d.object == "success"){
          idcustomer = 0;
          $('#first_name').html(d.data.first_name+' '+d.data.last_name);
          $('#nrodocs').html(d.data.dni);
          firtsname = d.data.first_name;
          lastname = d.data.last_name;
          dni = d.data.dni;
      }else if (d.portal == "interno" && d.object == "success"){
          idcustomer = d.data.id;
          $('#first_name').html(d.data.first_name+' '+d.data.last_name);
          $('#nrodocs').html(d.data.dni);
          firtsname = d.data.first_name;
          lastname = d.data.last_name;
          dni = d.data.dni;
      }else if (d.portal == "reniec" && d.object == "error"){
          idcustomer = null;
          alertify.notify(d.message,d.object,2, function(){});
          $('.register1').hide();
          $('.register2').hide();
          $('.register4').hide();
          $('.register3').show();
          $("#v4").removeClass("active");
          $("#v3").last().addClass("active");
      }else if (d.object == "error"){
          idcustomer = null;
          alertify.notify(d.message,d.object,2, function(){});
          $("#type_docs").val("").trigger('change');
          $('#dni').val("");
          $('#firstnameextra').val("");
          $('#lastnameextra').val("");
          $('.register1').show();
          $('.register2').hide();
          $('.register3').hide();
          $('.register4').hide();
          $("#v4").removeClass("active");
          $("#v1").last().addClass("active");
      }
    }).fail(function(){
      $('#load_inv').hide(300);
      alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
    });
  }
});



$(".btnverf").click(function() {
  if ($(this).attr("data-id") == 1){
    $('.register1').hide();
    $('.register2').hide();
    $('.register4').hide();
    $('.register3').show();
    $("#v4").removeClass("active");
    $("#v3").last().addClass("active");
    $('#welcomediv').hide();
  }else{
    var formData = new FormData($("#myform")[0]);
    formData.append("idcustomer", idcustomer);
    formData.append("first_name", firtsname);
    formData.append("last_name", lastname);
    formData.append("dnis", dni);
    formData.append("typecustomer", idtypeuser);
    formData.append("typereque", typereque);
    $.ajax(
      {
        url: "/atencion/facetoface/store",
        type:"POST",
        data : formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
                      $('#load_inv').show(300);
        }
      }).done(function(d)
      {
        $('#load_inv').hide(300);
        console.log(d);
        if(d.message == "success")
        {
          alertify.notify('Se creo exitosamente el ticket!', 'success',8, function(){
             backatention();
          });
          typeuser = 0;
          typereque = 0;
          idcustomer = 0;
          typedoc = 0;
          nrodoc = 0;
          idtypeuser = 0;
          firtsname = 0;
          lastname = 0;
          dni = 0;
          if (d.id_type_requirements == 12){
            $('#namecust').html('¡Registrado correctamente');
            $('#numberaten').html('<i style="color: #fcbe00!important; font-size: 90px;" class="fa fa-cloud-download"></i>');
            $('#notesave').html('Tome asiento y en breve podrá subir a la capacitación');
            $("#notesave").css("color", "#ffe22b");
            $('#nrotic').hide();
            $(".btnback").css("color", "#ffe22b");
            $(".btnback").css("border", "2px solid #ffe22b");
            $(".btnback").css("background", "#08426a");
            $(".btnback").css("font-weight", "bold");
            $("#lineacss").css("border", "2px dashed #fcbe00");
            $("#divsaves").css("border", "0");
          }else{
            $('#namecust').html('¡GRACIAS '+d.first_name);
            $('#numberaten').html('Su numero de atención');
            $('#notesave').html('Tome asiento y en breve lo atenderan');
            $("#notesave").css("color", "white");
            $('#nrotic').show();
            $('#nrotic').html(d.codT);
            $(".btnback").css("color", "#fcbe00");
            $(".btnback").css("border", "2px solid #fcbe00");
            $("#lineacss").css("border", "2px dashed #9e9e9e");
            $("#divsaves").css("border", "3px dashed #9e9e9e");
          }
          //datos del customer
          $("#type_docs").val("").trigger('change');
          $('#dni').val("");
          $('#firstnameextra').val("");
          $('#lastnameextra').val("");
          $('.register1').hide();
          $('.register2').hide();
          $('.register3').hide();
          $('.register4').hide();
          $('.divregister').hide();
          $('.viewregister').show();
          $("#v4").removeClass("active");
        } else {
          alert("no se pudo enviar el ticket");
        }
      }).fail(function(d){
        $('#load_inv').hide(300);
        console.log(d);//alerta del ticket no resgistrado
      });
  }
});

function backatention(){
  $('.register1').show();
  $('.register2').hide();
  $('.register3').hide();
  $('.register4').hide();
  $('.viewregister').hide();
  $('.divregister').show();
  $("#v1").last().addClass("active");
  $('#welcomediv').show();
}

$(".btnback").click(function() {
  $('.register1').show();
  $('.register2').hide();
  $('.register3').hide();
  $('.register4').hide();
  $('.viewregister').hide();
  $('.divregister').show();
  $("#v1").last().addClass("active");
  $('#welcomediv').show();
});
