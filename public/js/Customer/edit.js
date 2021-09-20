
$(document).ready(function(){
  $('.select2').select2();

  $("#editCustomer").validate({
    rules: {
      document:         { required: true, minlength: 7, uniqueDNIDB: true },
      first_name:  {  required: true,minlength: 2 },
      last_name:   {  required: true,minlength: 4 },
      phone:       {  minlength: 9 },
      email:       {  email : true },
      id_country:  {  required: true },
      id_state:    {  required: true },
      id_city:     {  required: true },
      address:     {  required: true, minlength: 5, maxlength: 150        },

    },
    onkeyup :false,
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

       alertify.confirm('CAMBIO DE DATOS', '¿Está usted seguro que desea cambiar el los datos de este Usuario?', function(){

        updateCustomer();
       },function(){
       }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});


   }


  });
  $('#id_country'  ).on('change', $.fn.getState);
  $('#id_state'    ).on('change', $.fn.getCity );

});

function updateCustomer()
{
  $.ajax({
    data: {
      'id_customer': $('#id_customer').val(),
      "document" : $('#document').val(),
      'first_name': $('#first_name').val(),
      'last_name': $('#last_name').val(),
      'phone': $('#phone').val(),
      'email': $('#email').val(),
      'id_country': $('#id_country').val(),
      'id_city': $('#id_city').val(),
      'id_state': $('#id_state').val(),
      'address':$('#address').val()
    },
    type: "post",
    url: '/customers/edit',
		  success: function(data) {


          location.reload();
      },
      error: function(data) {
      }
	});
}


$.fn.getState = function(id){
	var id = $(this).val();
	$.ajax({
    data: {"id" : $(this).val() },
    type: "GET",
    url: "/states/"+id,
		dataType : 'text',
		  success: function(data) {
				var datos =  '<option value="placeholder">Selecciona</option>';
				if (data){
					$.each( JSON.parse(data), function( key, value ) {
						datos += '<option value="'+key+'">'+value+'</option>';
					});
				}
				$("#id_state"   ).empty();
				$("#id_city"    ).empty();
				$("#id_state").append(datos);
      },
      error: function(data) {
      }
	});
}
$.fn.getCity = function(){
	var id = $(this).val();
	$.ajax({
		data: {"id" : $(this).val() },
		type: "GET",
		url: "/cities/"+id,
		dataType : 'text',
			success: function(data) {
				var datos =  '<option value="placeholder">Selecciona</option>';
				if (data){
					$.each( JSON.parse(data), function( key, value ) {
						datos += '<option value="'+key+'">'+value+'</option>';
					});
				}
				$("#id_city" ).empty();
				$("#id_city" ).append(datos);
			},
			error: function(data) {
			}
	});
}


jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[ a-z0-9áéíóúüñ]*$/i.test(value);
}, "Este campo solo permite datos alfabeticos");

var check =false;
jQuery.validator.addMethod("uniqueDNIDB", function(value, element) {
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
         type: "POST",
         url: "/customers/validUserDni",
         dataType: "text",
         data: { document : value },
         success: function (response) { check = response;       }
     });
     return this.optional(element) || check;
}, "Este usuario ya tiene cuenta");


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
