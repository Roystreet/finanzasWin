$(function () {

$(".btn-modalCar").on("click",function() {
	$("#id_driver").val('');
	$("#id_driver").val($(this).attr("data-id"));
});

$('#drivers').DataTable({
		'responsive'  : true,
		'language': {
			"decimal": "",
			"emptyTable": "No hay información",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
			"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
			"infoFiltered": "(Filtrado de _MAX_ total entradas)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ Entradas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar:",
			"zeroRecords": "Sin resultados encontrados",
			"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
			}
		},

})
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
$('#id_city_address'     ).on('change', getDistrict);



});



function getState(){
	var id = $(this).val();
	$.ajax({
    data: {"id" : $(this).val() },
    type: "GET",
    url: "states/"+id,
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
		url: "cities/"+id,
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
function getDistrict(){
	var id = $(this).val();
	$.ajax({
		data: {"id" : $(this).val() },
		type: "GET",
		url: "districts/"+id,
		dataType : 'text',
			success: function(data) {
				var datos =  '<option value="placeholder">Selecciona</option>';
				if (data){
					$.each( JSON.parse(data), function( key, value ) {
						datos += '<option value="'+key+'">'+value+'</option>';
					});
				}
				$("#id_district_address").empty();
				$("#id_district_address").append(datos);
			},
			error: function(data) {
			}
	});
}
