$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
fillDataTableCounts();
  $('#donate').select2();
function fillDataTableCounts()
{
  $('#cuentas').DataTable({  'responsive'  : true,
    'responsive'  : false,
    'autoWidth': false,
    'destroy'   : true,
    "scrollX": true,
    'language': {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
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
          "last": "Último",
          "next": "Siguiente",
          "previous": "Anterior"
      }
    },
    // data: data,
    // "columns":[
    //     {data:"date_ride"},
    //     {data:"pay"},
    //     {data:"total_pay"},
    //     {data:"porcentaj_ret"},
    //     {data:"mto_ret"},
    //     {data:"mto_abono"},
    // ]
    });
}
function fillDataTableCareer(data)
{
  $('#carreras').DataTable({  'responsive'  : true,
    'responsive'  : false,
    'autoWidth': false,
    'destroy'   : true,
    "scrollX": true,
    'language': {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
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
    data: data,
    "columns":[
        {data:"date_ride"},
        {data:"pay"},
        {data:"total_pay"},
        {data:"porcentaj_ret"},
        {data:"mto_ret"},
        {data:"mto_abono"},
    ]
    });
}
fillData($('meta[name="id"]').attr('content'));
function fillData(id)
{
  $.ajax({
    url: "/cobranza/career",
    type:"POST",
    data:{idDriver : id},
    beforeSend: function () {
    },
  }).done( function(d) {
    fillDataTableCareer(d.data);
    $('#first_name').text(d.driver.first_name);
    $('#last_name').text(d.driver.last_name);
    $('#phone').text(d.driver.email);
    $('#email').text(d.driver.phone);
    $('#dni').text(d.driver.dni);
    //datos de facturacion
    $('#mount_total').text(d.totalCareer);
    $('#mount_ret').text(d.totalRet);
    $('#mount_abo').text(d.totalAbo);

  }).fail( function() {
    alert("¡Ha ocurrido un error en la operación!");
  }).always( function() {
  });
}

function save()
{
  $.ajax({
    url: "/cobranza/cereer/save",
    type:"POST",
    data:{ total: 20,total_abono:150,total_ret:20,note:"nota"},
    beforeSend: function () {
    },
  }).done( function(d) {


  }).fail( function() {
    alert("¡Ha ocurrido un error en la operación!");
  }).always( function() {
  });
}
