$('#cod_country_driver').select2();
$('#model').select2();
$('#cod_state').select2();
$('#cod_city').select2();
$('#cod_country_nationaily').select2();
$('.conductor').hide();
$('#load_inv').hide();
$(function() {
  $('#datepicker3').datepicker( {
    dateFormat: "yy",
    yearRange: "c-12:c",
    changeMonth: false,
    changeYear: true,
    showButtonPanel: false,
    closeText:'Select',
    currentText: 'This year',
    onClose: function(dateText, inst) {
      var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
      $(this).val($.datepicker.formatDate('yy', new Date(year, 1, 1)));
    },
    onChangeMonthYear : function () {
      $(this).datepicker( "hide" );
    }
  }).focus(function () {
    $(".ui-datepicker-month").hide();
    $(".ui-datepicker-calendar").hide();
    $(".ui-datepicker-current").hide();
    $(".ui-datepicker-prev").hide();
    $(".ui-datepicker-next").hide();
    $("#ui-datepicker-div").position({
      my: "left top",
      at: "left bottom",
      of: $(this)
    });
  }).attr("readonly", false);
});
var id_Customer;
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
//buscar al conductor
function getCustomer()
{
	if(cod_country != null)
	$.ajax(
		{
			url: "/customer/register/driver/get",
			type:"POST",
			data : {  document: $('#document').val(),country:cod_country},
			dataType: "json",
		}).done(function(d)
		{

			if(d.object != "error")
			{
				$('#first_name').val(d.data.first_name);
				$('#last_name').val(d.data.last_name);
				id_Customer = d.data.id
			}
			else {
				alertify.alert('Alerta',d.message);
			}

		}).fail(function(){
			alert("No trajo datos de los estados ");
			id_Customer = null;
		});
		else if( $('#document').val() == null || $('#document').val() == "")
		{
			alertify.alert('Alerta','No s ellno el campo DNI.');
		}
		else{
			alertify.alert('Alerta','Seleccione el pais.');
		}

}

function storeDriver()
{
	var customer =
	{
		"id":id_Customer,
		"document":$('#document').val(),
		// "first_name":$('document').val(),
		// "last_name":$('document').val(),
		// "cod_country":172,
		// "cod_state":$('cod_state').val(),
		// "cod_city":$('cod_city').val(),
		// "create":false
	};
	var driver =
	{
		"number_license":$('#number_license').val(),
		"category":$('#category').val(),
		"cod_country_driver":$('#cod_country_driver').val(),
		//"number_license":$('#number_license').val(),
		"date_exp":$('#date_exp').val(),
		//"number_license":$('id_customer').val(),
	};

	var vehicle =
	{
		"matricula":$('#matricula').val(),
		"brand":$('#brand').val(),
		"model":$('#model').val(),
		"color":$('#color').val(),
		"nro_doors":$('#nro_doors').val(),
		"model_year":$('#datepicker3').val(),
	}

if(id_Customer != null)
	$.ajax(
		{
			url: "/customer/register/driver/store",
			type:"POST",
			data : {  customer: customer,driver:driver,vehicle:vehicle},
			dataType: "json",
		}).done(function(d)
		{

			if(d.object == "error")
			{
				alertify.alert(d.message);
			}

		}).fail(function(){
			alert("No trajo datos de los estadosertert ");//alerta del ticket no resgistrado
		});
		else{
			alertify.alert("No hay cliente");
		}
}

var cod_country;
$(document).on('change', '#cod_country_nationaily', function(event) {



	$.ajax(
		{
			url: "/customer/register/driver/get/nationality",
			type:"POST",
			data : {  id_country:$('#cod_country_nationaily').val()},
			dataType: "json",
		}).done(function(d)
		{

			cod_country = d.nationality;


		}).fail(function(){
			alert("No trajo datos de los estadosertert.");//alerta del ticket no resgistrado
		});

})
