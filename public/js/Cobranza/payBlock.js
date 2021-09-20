  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
getCareer();
  function getCareer()
  {
    $.ajax({
      url: "/cobranza/career/blocks",
      type:"POST",
      data:{idDriver : "1"},
      beforeSend: function () {
      },
    }).done( function(d) {
      console.log(d.respuesta)
      // fillDataTableCareer(d.respuesta.career);
      // $('#mount_total').html(d.respuesta.totales.total);
      // $('#mount_ret').html(d.respuesta.totales.mto_reten);
      // $('#mount_abo').html(d.respuesta.totales.mto_abono);

    }).fail( function() {
      alert("¡Ha ocurrido un error en la operación!");
    }).always( function() {
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
          {data:"get_driver.license_number"},
          {data:"get_driver.first_name"},
          {data:"get_driver.last_name"},
          {data:"date_ride"},
          {data:"pay"},
          {data:"porcentaj_ret"},
          {data:"mto_ret"},
          {data:"mto_abono"},
          {data:"total_pay"},
      ]
      });
  }
