
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var idg;
var idPre;

  $('.select2').select2();
  fillTable();
  function fillTable()//Inicio Fill
  {
    $.ajax({
      url: "/product/list",
      type:"get",
      beforeSend: function () {
            },
    }).done( function(d) {

      console.log(d.product);

      $('#products').DataTable({
      'responsive'  : true,
      'autoWidth': false,
      'destroy'   : true,
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
  "data": d.product,
  "columns":[
      {
             sortable: false,
             "render": function ( data, type, full, meta ) {
               var d = full.product.id;
               if (full.permiso || full.permisorol == 4){
                 return '<a href="#"><i class="fa fa-plus btn_price_add"  id_price_add="'+d+'" data-toggle="modal" data-target="#myModal"></i></a>';
               } else {
                 return 'no tiene permiso';
               }
             }
      },
      {data:"product.cod_product"},
      {data:"product.name_product"},
      {data:"product.description"},
      {data:"img"},
      {data:"visible"}
            ]
  });

  }).fail( function() {

  }).always( function() {

    });
  }//fin de fillTable
//inicio de Editar
$(document).on('click', '.btn_editP', function() {


    $.ajax({
      url: "/product/productEdit",
      type:"POST",
      data:{"product" :$( '#product' ).serializeObject(),id:idg},
      beforeSend: function () {
              $('.docs-example-modal-sm').modal('toggle');
            },
    }).done( function(d) {
      alertify.alert('Editado', '¡Producto Editado exitosamente!');
      $('#myModal').modal('toggle');
      console.log(d.products);
      $('#action').removeClass('btn_editP');
      $('#action').addClass('btn_registerP');
      $('#products').DataTable({
        'responsive'  : true,
        'autoWidth': false,
        'destroy'   : true,
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
    "data": d.products,
    "columns":[
        {
               sortable: false,
               "render": function ( data, type, full, meta ) {
                  var d = full.id;
                   return '<a href="#"><i class="fa fa-pencil btn_price_add"  id_price_add="'+d+'" data-toggle="modal" data-target="#myModal"></i></a>';
               }
        },
        {
               sortable: false,
               "render": function ( data, type, full, meta ) {
                  var d = full.id;
                   return '<a href="#"><i class="fa fa-trash btn_delete" id_del ="'+d+'"></i></a>';
               }
        },
        {data:"cod_product"},
        {data:"name_product"},
        {data:"description"},
        {data:"cant"},
        {data:"sale_price"},
        {data:"money"}
    ]
    });
      $('.docs-example-modal-sm').modal('hide');


  }).fail( function() {

  }).always( function() {

    });
});//fin de editar


$(document).on('click', '.btn_price_add', function() {//Inicio de Editar
  idg  = $(this).attr("id_price_add");

  $('#action').text("Agregar Precio");
  $('#action').removeClass('btn_price_edit_action');
  $('#action').addClass('btn_registerPrice_action');
  $('#coutnAction').removeAttr('style','display:none');

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/product/getPrice",
      type:"get",
      data: {'id':idg}
    }).done(function(d)
    {

      $('#price').DataTable({
        'responsive'  : true,
        'autoWidth': false,
        'destroy'   : true,
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
    "data": d,
    "columns":[
      {
             sortable: false,
             "render": function ( data, type, full, meta ) {
                var d = full.id;
                 return '<a href="#"><i class="fa fa-pencil btn_price_edit"  id_price_edit="'+d+'"></i></a> <dd>'+
                 '<a href="#"><i class="fa fa-trash btn_price_delete"  id_price_delete="'+d+'"></i></a>';
             }
      },
      {data:"price"},
      {data:"money.description"},
      {data:"money.symbol"},
      {
             sortable: false,
             "render": function ( data, type, full, meta ) {
                var d = full.status_user;
                if(d)
                 return '<a href="#"><i class="fa fa-check-square-o"  onclick=precioTienda("'+full.id+'",0)></i></a> <dd>';
                 else {
                   return '<a href="#"><i class="fa fa-exclamation"  onclick=precioTienda("'+full.id+'",1)></i></a> <dd>';
                 }
             }
      }

    ]
    });




    });
});//Fin de listar precio

$(document).on('click', '.btn_delete_action', function() {//Inicio de eliminar Producto

  var id = $(this).attr("id_del");
  $.ajax({
    url: "/product/productDelete",
    type:"POST",
    data:{id:id},
    beforeSend: function () {
          },
  }).done( function(d) {
    alertify.alert('Eliminado', "Exito");
    fillTable();
}).fail( function() {

}).always( function() {

  });

});
//Fin de Eliminar Producto

$("#register"  ).on('click',function() {

  $('#action2').text("Registrar");
  $('#action2').addClass('btn_product_insert_action');
  $('#product input').val("");
  $('#cant').val('0');
});


// ----------------------------------------------------------------------------------------------------------

function modalRegisterAction()
{
    $('#modalRegisterProducto').modal('show');
    $('#exampleModalCenter').modal('toggle');
    //$('#coutnAction').attr('style','display:block');
}

function modalRegisterPPP()
{
    $('#myModal').modal('show');
    $('#exampleModalCenter').modal('toggle');
    $('#coutnAction').attr('style','display:none');
}


$(document).on('click', '.btn_registerPrice_action', function() {

var id = idg;
var price = $('#sale_price').val();
var money = $('#id_money').val();

  $.ajax(
    {
      url: "/product/price/insert",
      type:"get",
      data:
      {
        id:id,
        price:price,
        money:money
      }
    }).done(function(d)
    {

       $('#myModal').modal('toggle');
       if(d.objet != "error")
       alertify.alert('Registrado', '¡Precio Registrado!');
      else alertify.alert('Ocurrio Un producto no registrado Error', d.message);
      // fillTable();
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

//Elimiar un precio
$(document).on('click', '.btn_price_delete', function() {//Inicio de Editar
  var idpp  = $(this).attr("id_price_delete");
  $.ajax(
    {
      url: "/product/money/delete",
      type:"get",
      data:
      {
        id:idpp
      }
    }).done(function(d)
    {
      if(d.objet != "error")
      alertify.alert('Eliminado', d.message);
     else alertify.alert('Ocurrio Un producto', d.message);
     $('#myModal').modal('toggle');
    });
});

//obtener el precio para editar
$(document).on('click', '.btn_price_edit', function() {//Inicio de Editar
  idPre  = $(this).attr("id_price_edit");
  $('#action').addClass('btn_price_edit_action');
  $('#action').removeClass('btn_registerPrice_action');
  $.ajax(
    {
      url: "/product/money",
      type:"get",
      data:
      {
        id:idPre
      }
    }).done(function(d)
    {
      $('#action').text("Editar");
      $('#id_money').val(d.money).change();
      $('#sale_price').val(d.price);
    });
});

//Editar el Precio
$(document).on('click', '.btn_price_edit_action', function() {//Inicio de Editar
  var price = $('#sale_price').val();
  var money = $('#id_money').val();
  $.ajax(
    {
      url: "/product/money/edit",
      type:"get",
      data:
      {
        id:idPre,
        id_money:money,
        price:price
      }
    }).done(function(d)
    {
       $('#myModal').modal('toggle');
      if(d.objet != "error")
      alertify.alert('Editado', d.message);
     else alertify.alert('Ocurrio Un producto no registrado Error', d.message);
    });
});

//Ingresar una producto
$(document).on('click', '.btn_product_insert_action', function() {//Inicio de Editar
  var cod_product = $('#cod_product').val();
  var name = $('#name').val();
  var description = $('#description').val();
  var cant = $('#cant').val();
  var price = $('#sale_price_product').val();
  var money = $('#id_money_product').val();

  $.ajax(
    {
      url: "/product/insert",
      type:"get",
      data:
      {
          cod_product : cod_product,
         name_product : name,
         description : description,
         cant : cant,
         price : price,
         id_money : money
      }
    }).done(function(d)
    {
       $('#myModal').modal('toggle');
      if(d.objet != "error")
      alertify.alert('Editado', d.message);
     else alertify.alert('Ocurrio Un producto no registrado Error', d.message);
    });
});
var id;
function uploadImg(ids)
{
  id = ids;
  $.ajax(
    {
      url: "/product/get/img",
      type:"post",
      data:
      {
        id_product:ids
      }
    }).done(function(d)
    {
      if(d.objet != "error")
      {
        $("#img-view-img").attr("src",d.data.url_imagen);
        $('#modal-imagen-product').modal('toggle');
      }

     else alertify.alert('Ocurrio Un producto', d.message);
    });

}


function viewModalUp()
{
    $('#modal-view-img').modal('toggle');
}


  function up(){
    storageRef = firebase.storage().ref();
    fichero = document.getElementById("doc-front");
    var imagenASubir = fichero.files[0];
    var uploadTask = storageRef.child('imgVoucher/' + id).put(imagenASubir);
    uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
    function(snapshot){
  //$('.load-img').modal('show');
    //se va mostrando el progreso de la subida de la imagenASubir
    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    }, function(error) {
      //gestionar el error si se produce

    }, function() {

      //cuando se ha subido exitosamente la imagen
      pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
        var formData = new FormData();
        formData.append('voucherURL', downloadURL);
        formData.append('voucherName', imagenASubir.name);
        $.ajax(
          {
            url: "/product/img",
            type:"post",
            data:
            {
              id_product:id,
              url_imagen:downloadURL
            }
          }).done(function(d)
          {
            if(d.objet != "error")
            {

              alertify.alert('completado', d.message);
              location.reload();
            }
           else alertify.alert('Ocurrio Un producto', d.message);
          });
     });
   });
  }


function store(id_product,data)
{
  $.ajax(
    {
      url: "/product/money/store",
      type:"post",
      data:
      {
        id_product:id_product,
        status:data
      }
    }).done(function(d)
    {
      if(d.objet != "error")
      {
        alertify.alert('Eliminado', d.message);
        location.reload();
      }

     else alertify.alert('Ocurrio Un producto', d.message);
    });
}

function precioTienda(id,status)
{
  $.ajax(
    {
      url: "/product/money/update",
      type:"post",
      data:
      {
        id_precio:id,
        status:status
      }
    }).done(function(d)
    {
      if(d.object != "error")
      {
        alertify.alert('Actializado', d.menssage);
        location.reload();
      }

     else alertify.alert('Ocurrio Un producto', d.message);
    });
}
