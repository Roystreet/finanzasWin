$(function () {

$('.select2').select2();
$('#cod_country'  ).on('change', getState);
$('#cod_state'    ).on('change', getCity);

});



function getState(){
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
				$("#cod_state"   ).empty();
				$("#cod_city"    ).empty();
				$("#cod_state").append(datos);
      },
      error: function(data) {
      }
	});
}
function getCity() {
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
				$("#cod_city"    ).empty();
				$("#cod_city").append(datos);
			},
			error: function(data) {
			}
	});
}
