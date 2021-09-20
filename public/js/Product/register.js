$(document).ready(function()
{

  $('.select2').select2();
  $('#products').DataTable({
      'responsive'  : false,
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



    $(".btn_delete").on('click',function() {

          var codi = $(this).closest("tr").find('td:nth-child(0)').find("input").val();

            console.log(codi);
              $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
              $.ajax(
                {
                  url: "/deleteProduct",
                  type:"POST",
                  data:{cod:codi},
                  success: function(d)
                {

                    $('#tbProducts tbody').empty();
                    for(var i in d.productos)
                    {
                        // (o el campo que necesites)
                      $('#tbProducts tbody').append('<tr><td>' + d.productos[i].cod_product+
                      '</td><td>' + d.productos[i].description +
                      '</td><td>' + d.productos[i].name_product +
                      '</td><td>' + d.productos[i].number_action +
                      '</td><td>'+d.productos[i].sale_price+
                      '</td><td>'+d.productos[i].name+
                      '<td>'+
                      '<button type="button" class="btn btn-warning pull-righ fa fa-pencil btn_edit" data-toggle="modal" data-target="#myModal"></button>'+
                      '<button type="button" class="btn btn-danger pull-righ fa  fa-times btn_delete"></button>'+
                      '</td>'+
                      '</tr>');
                    }
                }
                }).done(function(d)
                {

                });
    });


    $("#register").on('click',function()
    {

          $('input[type="text"]').val('');
          
          $('#action').text("Registrar");
          $('#action').removeClass('btn_editP');
          $('#action').addClass('btn_registerP');
    });

    $(".btn_edit").on('click',function() {
          idg  = $(this).attr("id_edit")
          $('#action').text("Editar");
          $('#action').removeClass('btn_registerP');
          $('#action').addClass('btn_editP');

          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          $.ajax(
            {
              url: "/getProduct",
              type:"POST",
              data: {'id':idg}
            }).done(function(d)
            {
              $("#cod_product").val(d.product[0].cod_product);
              $("#name_product").val(d.product[0].name_product);
              $("#description").val(d.product[0].description);
              $("#cant").val(d.product[0].cant);
              $("#sale_price").val(d.product[0].sale_price);
            });

    });







});

var idg;

$(document).on('click', '.btn_editP', function() {
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/productEdit",
      type:"POST",
      data: {"product" :$( '#product' ).serializeObject(),id:idg}
    }).done(function(d)
    {
      $('#myModal').modal('toggle');
      alertify.alert('Editado', '¡Producto Editado exitosamente!');

      //

      $('#products tbody').empty();
      console.log(d.product);
      for(var i in d.products)
            {
                // (o el campo que necesites)
              $('#products tbody').append('<tr><td>'+'<input type="hidden" name="'+ d.products[i].id+'" value="'+ d.products[i].id+'">' + d.products[i].cod_product+
              '</td><td>' + d.products[i].name_product +
              '</td><td>' + d.products[i].description +
              '</td><td>' + d.products[i].cant +
              '</td><td>'+d.products[i].sale_price+
              '</td><td>'+d.products[i].money+
              '<td>'+
              '<button type="button" class="btn btn-warning pull-righ fa fa-pencil btn_edit" data-toggle="modal" data-target="#myModal"></button>'+
              '<button type="button" class="btn btn-danger pull-righ fa  fa-times btn_delete"></button>'+
              '</td>'+
              '</tr>');
            }
    });
});


$(document).on('click', '.btn_registerP', function() {

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/productStore",
      type:"POST",
      data: $( '#product' ).serializeObject()
    }).done(function(d)
    {
      $('#myModal').modal('toggle');
      alertify.alert('Registrado', '¡Producto registrado exitosamente!');

      //

      $('#products tbody').empty();

      for(var i in d.product)
            {
                // (o el campo que necesites)
              $('#products tbody').append('<tr><td>' + d.product[i].cod_product+
              '</td><td>' + d.product[i].name_product +
              '</td><td>' + d.product[i].description +
              '</td><td>' + d.product[i].cant +
              '</td><td>'+d.product[i].sale_price+
              '</td><td>'+d.product[i].money+
              '<td>'+
              '<button type="button" class="btn btn-warning pull-righ fa fa-pencil btn_edit" data-toggle="modal" data-target="#myModal"></button>'+
              '<button type="button" class="btn btn-danger pull-righ fa  fa-times btn_delete"></button>'+
              '</td>'+
              '</tr>');
            }
      //

    });
});



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
