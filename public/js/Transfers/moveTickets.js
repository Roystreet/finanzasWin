$(document).ready(function(){

  $('.select2').select2();

  $('#id_customerA'    ).on('change', $.fn.getTicketcustomerID );

  $("#moveTickets").validate({
    rules: {
      id_customerA:  {  required: true },
      id_customerB:  {  required: true },
      id_ticket   :  {  required: true },
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

       alertify.confirm('TRANSFERENCIA', '¿Está usted seguro que desea realizar la transferencia de datos de este Usuario?', function(){
          form.submit();
       },function(){
       }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});


   }



});

$.fn.getTicketcustomerID = function(id){
	var id = $(this).val();
	$.ajax({
    data: {id : id },
    type: "GET",
    url: "/transf/tickectsCustomer/"+id,
		dataType : 'text',
		  success: function(data) {
				var datos =  '<option value="placeholder">Selecciona</option>';
				if (data){
					$.each( JSON.parse(data), function( key, value ) {
						datos += '<option value="'+key+'">'+value+'</option>';
					});
				}
				$("#id_ticket"   ).empty();
				$("#id_ticket"   ).append(datos);
      },
      error: function(data) {
      }
	});
}
