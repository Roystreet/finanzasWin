$(function () {

$('.select2').select2();
$('#birthdate').datepicker({
	format: 'yyyy-mm-dd',
	orientation: "auto left",
	forceParse: false,
	autoclose: true,
	todayHighlight: true,
	toggleActive: true,
	endDate: '0',
	language: 'es'
});

$('#id_country_address'  ).on('change', getState);
$('#id_state_address'    ).on('change', getCity);

});

function getState(){
	var id = $(this).val();
	$.ajax({
    data: {"id" : $(this).val() },
    type: "GET",
    url: "http://win.localhost/states/"+id,
		dataType : 'text',
		  success: function(data) {
				var datos =  '<option value="placeholder">Selecciona</option>';
				if (data){
					$.each( JSON.parse(data), function( key, value ) {
						datos += '<option value="'+key+'">'+value+'</option>';
					});
				}
				$("#id_state_address"   ).empty();
				$("#id_city_address"    ).empty();
				$("#id_district_driver" ).empty();
				$("#id_district_address").empty();
				$("#id_state_address").append(datos);
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
		url: "http://win.localhost/cities/"+id,
		dataType : 'text',
			success: function(data) {
				var datos =  '<option value="placeholder">Selecciona</option>';
				if (data){
					$.each( JSON.parse(data), function( key, value ) {
						datos += '<option value="'+key+'">'+value+'</option>';
					});
				}
				$("#id_city_address"    ).empty();
				$("#id_city_driver"     ).empty();
				$("#id_district_address").empty();
				$("#id_city_address").append(datos);
				$("#id_city_driver" ).append(datos);
			},
			error: function(data) {
			}
	});
}
