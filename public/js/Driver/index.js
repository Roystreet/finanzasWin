$(function () {
$('#divdocumento').hide();
$('#divdatos').hide();
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
});

$('.select2').select2({
	placeholder: 'Selecciona'
});

$('#id_country_address').val('');
$('#id_country_address').trigger('change');
$('#id_nationality').val('');
$('#id_nationality').trigger('change');

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


$('.validarDocumento').on('click', function() {
	var documento = $('#document').val();
	 if (documento == ""){
		 alert('Ingresa DNI, campo vacio');
		 $('#document').focus();
	 }else{
		 $.ajax({
	     data: {"data" : documento},
	     type: "GET",
	     url: "/customer/valiteDocumento",
	 		dataType : 'JSON',
	 		  success: function(data) {
	 				if (data.dato == 'vacio'){
						$('#divdatos').hide();
						alert('No se ha hecho el pre-registro');
					}else{
						$('#divdatos').show();
						$("#name").val(data.mensaje.first_name);
						$("#lastname").val(data.mensaje.last_name);
						$("#document").prop( "disabled", true );
						$("#name").prop( "disabled", true );
		        $("#lastname").prop( "disabled", true );
				  }
	       },
	       error: function(data) {
	       }
	 	});
	 }
});

});




$('#id_country').on('change', function(){
	var countryval = $('#id_country').val();
	if (countryval == 172){
		$('#divdocumento').show();
		$('#titledocumento').text('DNI');
	}else{
		$('#divdocumento').hide();
	}
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
