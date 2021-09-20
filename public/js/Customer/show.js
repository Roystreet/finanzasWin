$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
var fichero;
var storageRef;
var pathUrlImg;
var idImprimir;
var idPrice = 0;


$(document).ready(function(){


  var id  = $('.ids').attr("data-id");
  var vergene  = $('.ids').attr("vergene");
  var verespe  = $('.ids').attr("verespe");
  var rolid  = $('.ids').attr("rolid");
  $.fn.btnSee();
  var url = $.fn.getUrl(id, 'customersTickets');

  var table =  $('#tickets').DataTable({
     'destroy'   : true,
    "scrollX": true,
       "ajax": {
            "url": url,
            "type": "GET",
            "dataType": 'json',
        },
        "columns":[
          {data: "action"},
          {data:"cod_ticket"},
          {data:"name_product"},
          {data:"money"},
          {data:"first_name"},
          {data:"country"},
          {data:"price"},
          {data:"id_banck"},
          {data:"moneda"},
          {data:"cant"},
          {data:"total"},
          {data:"statussis"},
          {data:"nro_book"},
          {data:"download"},
          {data:"username"},
          {data:"note"},
          {data:"obser_int"},

        ],

         'language': {
           "decimal": "",
           "emptyTable": "No hay información",
           "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
           "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
           "infoFiltered": "(Filtrado de MAX total entradas)",
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
   if (vergene == false && rolid != 4){
      //visibilidad de columnas
      var column = table.column(0);
      column.visible(!column.visible());
      var column1 = table.column(2);
      column1.visible(!column1.visible());
      var column2 = table.column(4);
      column2.visible(!column2.visible());
      var column3 = table.column(5);
      column3.visible(!column3.visible());
      var column4 = table.column(6);
      column4.visible(!column4.visible());
      var column5 = table.column(8);
      column5.visible(!column5.visible());
      var column6 = table.column(12);
      column6.visible(!column6.visible());
      var column7 = table.column(13);
      column7.visible(!column7.visible());

   }

   var url1 = $.fn.getUrl(id, 'customersbooks');

   var tablebook =  $('#books').DataTable({
   'destroy'   : true,
   "scrollX": true,
        "ajax": {
             "url": url1,
             "type": "GET",
             "dataType": 'json',
         },
         "columns":[
           {data: "action"},
           {data:"nro_book"},
           {data:"cant"},
           {data:"download"},
           {data:"cant_print_book"},
           {data:"sign_book"},
           {data:"file_book"},
          ],
          "footerCallback": function ( row, data, start, end, display ) {
       				var api = this.api(), data;
               //console.log(data);

               var intVal = function ( i ) {
       					return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ?	i : 0;
       				};
       				// total_salary over all pages
       				total_salary = api.column(2).data().reduce( function (a, b) {
       					return intVal(a) + intVal(b);
       				},0);



       				// total_page_salary over this page
       				total_page_salary = api.column(2, { page: 'current'} ).data().reduce( function (a, b) {
       					return intVal(a) + intVal(b);
       				}, 0 );

       				// Update footer
       				$('#totalSalary').html(total_salary);
       			},

          'language': {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de MAX total entradas)",
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


  $('#tickets tbody').on('click','.btn-certif',       function () {
    idImprimir = $(this).attr("data-id");
   });



   $('#books tbody').on('click','.btn-book-update',       function () {
     $( "#dni_destino" ).val("");
     $('#name_destino').html("");
      idBook = $(this).attr("data-id");
      nroBook = $(this).attr("data-nro");
      $('#titlebook').html(nroBook);
    });




   $('.bnt-print').on('click',function () {
     var city = $('#city').val();
     var date = $('#datepicker').val();
     var x = false;
     //console.log(city+"-"+idImprimir+"-"+date);
     var url = $.fn.getUrl(null,'printCertificado');
     url =url+'/'+city+'/'+idImprimir+'/'+date+'/'+x;
     window.location.href = url;
     tablebook.ajax.reload();
    });

  $('#modal-ticket').on('click','#statussis',           function () {
     var status = $(this).attr("statussis");
     var id     = $(this).attr("data-id");
     var url = $.fn.getUrl(null, 'updateStatus');
     var url2 = $.fn.getUrl(null, 'updatePays');

     alertify.confirm('ACTIVAR ACCIONISTA', 'Está usted seguro que desea cambiar el estatus del ticket?', function(){
          $('#modal-ticket').modal('toggle');
          if (status == 2){
            $.fn.updatePays(id, url2);
          }
          $.fn.updateStatus(status, id, table, url, tablebook);
     },function(){
     }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});
   });

   $('#tickets tbody').on('click','#numberbook',           function () {
      var numberbook = $(this).attr("numberbook");
      var id     = $(this).attr("data-id");
      var url = $.fn.getUrl(null, 'saveNumberBook');

      alertify.confirm('Eliminar Ticket', 'Está usted seguro que desea eliminar el ticket?', function(){
          $.fn.saveNumberBook(numberbook, id, table, url);
      },function(){
      }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});
    });

    $('#books tbody').on('click','#signbook',           function () {
       var status = $(this).attr("statusbook");
       var id     = $(this).attr("data-id");
       var url    = $.fn.getUrl(null, 'updateBooks');

       if (status==1){
         var title = 'APROBAR FIRMA DE LIBRO';
       }else{
         var title = 'APROBAR FILE';
       }

       alertify.confirm(title, 'cambiar de estado.', function(){
           $.fn.updateBooks(status, id, tablebook, url);
       },function(){
       }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});


     });

var ticket;
  $('#tickets tbody').on('click','.btn-ticket',       function () {
      	$("#id_ticket").val('');
        emptyTable();
        var id = $(this).attr("data-id");

        var f = new Date();
        var url = $.fn.getUrl(null, 'ticketDetails');
        $.ajax({
          type: "GET",
          url: url,
          data: {id : id },
      		dataType : 'json',
          beforeSend: function(){
          },
          success: function(data) {
            $.fn.dataContent(data);
            ticket = data;
            //ESTATUS DEL TICKET
            if( (data.rol == 4 || data.rol == 2 || data.rol == 7  || data.rol == 1 ) && (true) ){
              if(data.date_cobro != undefined){
                $('#status').html('<button type="button" class="btn btn-success pull-left statuschange" id="'+id+'">Actualizar</button>');
                $('#fecha_bono_view').html('<input id="fecha_bono" class="form-control" name="fecha_bono" type="date" value="'+data.date_register_pay+'" max="'+data.date_register_pay+'" min="01-02-2018" disabled>');
                $('#bono_inv_view'  ).html('<input type="text" class="form-control" id="bono_inv" name="bono_inv" data-id="'+data.price+'" onkeypress="return validaNumericos(event)" disabled/>');
                $('#fec_cob_inv'    ).html('<input type="date" class="form-control" id="fec_cob"  name="fec_cob" value="'+data.date_cobro+'" max="'+data.date_cobro+'" min="01-02-2018" disabled/>');
                $('#obser_inv_view' ).html('<textarea id="obser_inv" class="form-control" name="obser_inv"  /></textarea>');
                $('#obser_int_view' ).html('<textarea id="obser_int" class="form-control" name="obser_int" value="'+data.obser_int+'"/></textarea>');
                if (data.valimg == null){
                  $('#voucher_pago').html('<input type="file" class="form-control" id="voucher" name="voucher" accept="image/png, image/jpeg">');
                }else{
                  $('#voucher_pago').html("<input type='file' id='voucher' name='voucher' style='display:none;'><a data-toggle='modal' data-target='#modal-viewTicket' class='btn-viewTicket' data-id='"+id+"'>ver imagen</a>");
                }
              }else{
                $('#status').html('<button type="button" class="btn btn-success pull-left statuschange" id="'+id+'">Actualizar</button>');
                $('#fecha_bono_view').html('<input id="fecha_bono" class="form-control" name="fecha_bono" type="date" value="'+data.date_register_pay+'" max="'+data.date_register_pay+'" min="01-02-2018">');
                $('#bono_inv_view'  ).html('<input type="text" class="form-control" id="bono_inv" name="bono_inv" data-id="'+data.price+'" onkeypress="return validaNumericos(event)"/>');
                $('#fec_cob_inv'    ).html('<input type="date" class="form-control" id="fec_cob"  name="fec_cob" value="'+data.date_cobro+'" max="'+data.date_cobro+'" min="01-02-2018"/>');
                $('#obser_inv_view' ).html('<textarea id="obser_inv" class="form-control" name="obser_inv"/></textarea>');
                $('#obser_int_view' ).html('<textarea id="obser_int" class="form-control" name="obser_int" value="'+data.obser_int+'"/></textarea>');
                if (data.valimg == null){
                  $('#voucher_pago').html('<input type="file" class="form-control" id="voucher" name="voucher" accept="image/png, image/jpeg">');
                }else{
                  $('#voucher_pago').html("<input type='file' id='voucher' name='voucher' style='display:none;'><a data-toggle='modal' data-target='#modal-viewTicket' class='btn-viewTicket' data-id='"+id+"'>ver imagen</a>");
                }
              }



                var pagos = data.pays;

                if(data.date_cobro != undefined){
                  var fila = '<select name="mod_pag" id="mod_pag" class="form-control" disabled><option value="select">Seleccionar metodo de pago</option>';
                }else{
                  var fila = '<select name="mod_pag" id="mod_pag" class="form-control"><option value="select">Seleccionar metodo de pago</option>';
                }


                $.each(pagos, function( index, value ) {
                  fila += '<option value='+value.id+'>'+value.name_pay+'</option>';
                });
                fila +='</select>';

                $("#mod_pag_inv").append(fila);


                var monedas = data.moneys;
                if(data.date_cobro != undefined){
                  var filas = '<select name="tip_moneda" id="tip_moneda" class="form-control" disabled><option value="select">Seleccionar tipo de moneda</option>';
                }else{
                  var filas = '<select name="tip_moneda" id="tip_moneda" class="form-control" ><option value="select">Seleccionar tipo de moneda</option>';
                }

                $.each(monedas, function( index, value ) {
                   filas += '<option value='+value.id+'>'+value.description+'</option>';
                });
                filas +='</select>';
                $("#tip_moneda_inv").append(filas);
                $('#calProduct').html('<button type="button" class="btn btn-success pull-left" id="recalProduct">Recalcular productos</button>');
                $('#calSponsor').html('<button type="button" class="btn btn-success pull-left" id="recalCustomer">Recalcular sponsor</button>');
              }

            else if ( (data.est_ticket == 4 || data.est_ticket == 7) ){

              if (data.valimg == null){
                $('#voucher_pago').html('No existe imagen del voucher');
              }else{
              $('#voucher_pago').html("<a data-toggle='modal' data-target='#modal-viewTicket' class='btn-viewTicket' data-id='"+id+"'>ver imagen</a>");
              }

              $('#fecha_bono_view').html(data.date_register_pay);
              $('#bono_inv_view').html(data.bono_direct);
              $('#fec_cob_inv').html(data.date_cobro);
              $('#mod_pag_inv').html(data.modo_pay);
              $('#obser_inv_view').html(data.obser_pay);
              $('#obser_int_view').html(data.obser_int);
              $('#tip_moneda_inv').html(data.namemoney);

              $('#status').html('<button type="button" class="btn btn-success pull-left" onclick="download_ticket('+id+')" data-dismiss="modal" >Descargar ticket</button>');
              $("b").remove();
            } else if (data.est_ticket == 2 || data.est_ticket == 3){
              $("b").remove();
              $('#status').html('<button type="button" class="btn btn-warning pull-left">Falta completar por finanzas</button>');
            }else if (data.est_ticket == 1 ){
              $('#bono-directo').html('');
              //$('#id_pay').html('<input type="text" class="form-control" id="type_pay" name="type_pay" value="'+data.id_pay+'"/>');
              var pagos = data.pays;
              $('#id_pay').html('');
              var filaspay = '<select name="pays_rec" id="pays_rec" class="form-control">';
              $.each(pagos, function( index, value ) {
                 filaspay += '<option value='+value.id+'>'+value.name_pay+'</option>';
              });
              filaspay +='</select>';
              $("#id_pay").append(filaspay);
              $("#pays_rec option[value="+data.id_payrec+"]").attr('selected', 'selected');

              $('#date_pay').html('<input id="fecha_pay" class="form-control" name="fecha_pay" type="datetime-local" value="'+data.date_pay+'">');


              if (data.valimg == null){
                $('#voucher_pago').html('<input type="file" class="form-control" id="voucher" name="voucher" accept="image/png, image/jpeg">');
              }else{
                $('#voucher_pago').html("<input type='file' id='voucher' name='voucher' style='display: none;'><a data-toggle='modal' data-target='#modal-viewTicket' class='btn-viewTicket' data-id='"+id+"'>ver imagen</a>");
              }
              // $('#status').html('<button type="button" statussis="2"  data-id="'+id+'" id="statussis" class="btn btn-success pull-left">Aprobar Registro</button>');
              if (data.number_operation == null){
                $('#number_operation').html('');
              }else{
                $('#number_operation').html('<input type="text" class="form-control" id="number_ope_pay" name="number_ope_pay" value="'+data.number_operation+'"/>');
              }
            }

              $( "#recalProduct" ).click(function() {
              $('#newproduct').val('');
              $('#selProduct').html('<th>Productos: </th><td id="ProductosT"></td>');
              var productos = data.productos;
              var filass = '<select name="products_cal" id="products_cal" class="form-control"><option value="select">Seleccionar productos</option>';
              $.each(productos, function( index, value ) {
                if(value.product != null)
                 filass += '<option value='+value.precio.id+'>'+value.product.name_product+' '+value.precio.price+' '+value.moneda.description+'</option>';
              });
              filass +='</select>';
              $("#ProductosT").append(filass);
              $('#productsP').append(filass);
              });
              $( "#recalCustomer" ).click(function() {
                  $('#newsponsor').val('');
                  $('#selSponsor').html('<th>Sponsor (Buscar por DNI): </th><td id="SponsorT" style="display: flex;"><input type="text" id="changeSponsor" placeholder="buscar por DNI" class="form-control" name="changeSponsor" onkeypress="return onKeyDownHandler(event);"></td>');
              });

              if(data.bono != null)
              {
                $('#bono_inv').val(data.bono.bono_directo);
                $('#obser_inv').val(data.bono.observaciones);
                $('#obser_int').val(data.bono.note);
                 document.getElementById("mod_pag").value = data.bono.modo_pago;
                 document.getElementById("tip_moneda").value = data.bono.tip_moneda;
              }
            },
            error: function(data) {
            }
      	});

  });

  $('#dataticket').on('click','.btn-viewTicket',      function () {
    id = $(this).attr('data-id');
    $.ajax({
      type: "GET",
      url: "/ticket/viewVoucher/"+id+"",
      data: {id : id },
      dataType : 'json',
      beforeSend: function(){

      },
      success: function(data) {

         $('#verimgTicket').html('<img src="'+data.route_img+'" class="img-responsive">');
         console.log(data.route_img);
      },
      error: function(data) {
      }
    });
  });

  $('#bono-directo').on('keyup','#bono_inv',          function () {
      var limit = parseInt($('#bono_inv').attr('data-id'));
      if ($(this).val() >= limit){
          $('#bono_inv').val(limit - 1);
      }
  });

  $('#modal-viewTicket').on('click','.change-img',    function () {
    id = $('.btn-viewTicket').attr('data-id');
    $('#verimgTicket').html('<input type="file" class="form-control" id="voucher-change" name="voucher-change" accept="image/png, image/jpeg">');
    $('#update-img').html('<button type="button" class="btn btn-success pull-left update-images" data-id="'+id+'">Actualizar</button>');
  });

  $('#modal-viewTicket').on('click','.update-images', function () {
    id = $(this).attr('data-id');
    fichero = document.getElementById("voucher-change");

    if (fichero.files.length >= 1){
        $.ajax({
          type: "GET",
          url: "/ticket/viewVoucher/"+id+"",
          data: {id : id },
          dataType : 'json',
          beforeSend: function(){

          },
          success: function(data) {

            var storageRef = firebase.storage().ref();
            // Create a reference to the file to delete
            var desertRef = storageRef.child('imgVoucher/'+data.id_ticket);

            // Delete the file
            desertRef.delete().then(function() {
              // File deleted successfully
              updateimage(id,data.id);
            }).catch(function(error) {
              // Uh-oh, an error occurred!
            });
          },
          error: function(data) {
          }
        });
    }else{
      alert('seleccionar imagen');
    }
  });

  fichero = document.getElementById("voucher-change");
  function updateimage(id,imgid){

    storageRef = firebase.storage().ref();
    var imagenASubir = fichero.files[0];
    var uploadTask = storageRef.child('imgVoucher/' + id).put(imagenASubir);
    uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
    function(snapshot){
    $('.load-img').modal('show');
    //se va mostrando el progreso de la subida de la imagenASubir
    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
    // alert('Upload is ' + progress + '% done');
    //show as confirm
    }, function(error) {
      //gestionar el error si se produce

    }, function() {
    $('.load-img').modal('hide');
      //cuando se ha subido exitosamente la imagen
      pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
        var formData = new FormData();
        formData.append('voucherURL', downloadURL);
        formData.append('voucherName', imagenASubir.name);
        formData.append('id_ticket', id);
        formData.append('id_img', imgid);
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
          type: "POST",
          url: "/tickets/imgUpdate",
          cache: false,
          contentType: false,
         processData: false,
          dataType: "html",
          data: formData,
          dataType : 'json',
        }).done(function(d){
          alertify.success('Se actualizo correctamente');
          $('#modal-viewTicket').modal('hide');
        }).fail(function(){
          alert("No se pudo procesar la solicitud");
        });
         return downloadURL;
     });
   });
  }

  $('#status').on('click','.statusAdmin', function () {
    var id = $(this).attr('id');
    var formData = new FormData();
    formData.append('id', id);

     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax({
       type: "POST",
       url: "/ticketActivationAdmin",
       cache: false,
       contentType: false,
       processData: false,
       dataType: "html",
       data: formData,
       dataType : 'json',
     }).done(function(d){
       console.log(d.rol);
       alertify.success('Se activo correctamente');
       alertify.confirm('Actualizado', 'Â¡El accionista ha sido activado exitosamente! Desea Descargar el Ticket generado', function(){
           alertify.success('Procesando');
           window.location.href = "/customers/pdfTicket/"+id+"";
       },function(){
           table.ajax.reload();
           $('#modal-ticket').modal('hide');
       }).set({labels:{ok:'Descargar Ticket', cancel: 'No Descargar'}, padding: false});
     }).fail(function(){
       alert("No se pudo procesar la solicitud");
     });
  });

  $('#status').on('click','.statuschange', function () {
        var id = $(this).attr('id');
        var formData = new FormData();
        formData.append('mod_pag', $('#mod_pag').val());
        formData.append('id', id);
        formData.append('bono_inv', $('#bono_inv').val());
        formData.append('tip_moneda', $('#tip_moneda').val());
        formData.append('obser_inv', $('#obser_inv').val());
        formData.append('obser_int', $('#obser_int').val());
        formData.append('fec_cob', $('#fec_cob').val());
        formData.append('newproduct', $('#newproduct').val());
        formData.append('dni_invi', $('#dni_invi').val());
        formData.append('first_name', $('#first_name').val());
        formData.append('last_name', $('#last_name').val());
        formData.append('newsponsor', $('#newsponsor').val());
        fichero = document.getElementById("voucher");

        if (fichero.files.length >= 1){
        storageRef = firebase.storage().ref();
        var imagenASubir = fichero.files[0];
        var uploadTask = storageRef.child('imgVoucher/' + imagenASubir.name).put(imagenASubir);
        uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
        function(snapshot){
        $('.load-img').modal('show');
        //se va mostrando el progreso de la subida de la imagenASubir
        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
        // alert('Upload is ' + progress + '% done');
        //show as confirm
        }, function(error) {
          //gestionar el error si se produce

        }, function() {
        $('.load-img').modal('hide');
          //cuando se ha subido exitosamente la imagen
          pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
            formData.append('voucherURL', downloadURL);
            formData.append('voucherName', imagenASubir.name);

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
              type: "POST",
              url: "/ticketActivation",
              cache: false,
              contentType: false,
     	       processData: false,
              dataType: "html",
              data: formData,
              dataType : 'json',
            }).done(function(d){
              console.log(d.rol);
              console.log(d.name);
              alertify.success('Se activo correctamente');
              alertify.confirm('Actualizado', 'Â¡El accionista ha sido activado exitosamente! Desea Descargar el Ticket generado', function(){
                  alertify.success('Procesando');
                  window.location.href = "/customers/pdfTicket/"+id+"";
              },function(){
                  table.ajax.reload();
                  $('#modal-ticket').modal('hide');
              }).set({labels:{ok:'Descargar Ticket', cancel: 'No Descargar'}, padding: false});
            }).fail(function(){
              alert("No se pudo procesar la solicitud");
            });
             return downloadURL;
         });
       });

     }else{
       $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
       $.ajax({
         type: "POST",
         url: "/ticketActivation",
         cache: false,
         contentType: false,
        processData: false,
         dataType: "html",
         data: formData,
         dataType : 'json',
       }).done(function(d){
         console.log(d.rol);
         console.log(d.name);
         alertify.success('Se activo correctamente');
         alertify.confirm('Actualizado', 'Â¡El accionista ha sido activado exitosamente! Desea Descargar el Ticket generado', function(){
             alertify.success('Procesando');
             window.location.href = "/customers/pdfTicket/"+id+"";
         },function(){
             table.ajax.reload();
             $('#modal-ticket').modal('hide');
         }).set({labels:{ok:'Descargar Ticket', cancel: 'No Descargar'}, padding: false});
       }).fail(function(){
         alert("No se pudo procesar la solicitud");
       });
     }

  });

  $(function() {
     $( "#dni_destino" ).autocomplete({
                source: "/ticket/getCustomer",
                minLength: 2,
                select: function( event, ui ) {
                $( "#dni_destino" ).val( ui.item.desc );
                $('#name_destino').html(ui.item.label);
                  id_customer_pasar = ui.item.value;
                  return false;
               }
             });
   });


$('#modal-book-update').on('click','.change-book',    function () {
    dnipaso = $('#dni_destino').val();
   if(dnipaso == null || dnipaso == ""){
     alert('Falta completar cliente de traspaso');
     $("#dni_destino").focus();
   } else {
     alertify.confirm('Mensaje de confirmaciÃ³n', 'Â¿EstÃ¡ seguro de realizar los cambios?',
     function(){
       id_customer_actual = $('#titlebook').attr('data-id');
       var transferir = {
         customer_act: id_customer_actual,
         customer_trans : id_customer_pasar,
         id_book: idBook,
         nroBook: nroBook
       }

       $.ajax({
          type: "POST",
          url: "/customer/transferir",
          data: { data : transferir},
          dataType : 'json',
          beforeSend: function(){

          },
          success: function(d) {
             if (d.data == "exito"){
               alertify.alert('Exito', "Se realizo la transferencia para el Nro "+nroBook, function(){ alertify.success('Ok'); });
               $('#cerrar').click();
               tablebook.ajax.reload();
             }
          },
          error: function(data) {
          }
       })

     }, function(){

     });
   }
});
});


$(document).on('change', '#pays_rec', function(event) {
  id_paysr = $(this).val();
  if (id_paysr == 2 || id_paysr == 8){
    $('#number_operation').html('');
  }else{
    $('#number_operation').html('<input type="text" class="form-control" id="number_ope_pay" name="number_ope_pay" value=""/>');
  }
});


$(document).on('change', '#products_cal', function(event) {
  idPrice = $(this).val();
  $.ajax({
     type: "GET",
     url: "/ticket/getProductid/"+idPrice+"",
     data: {},
     dataType : 'json',
     beforeSend: function(){
     },
     success: function(data) {
           $('#bono_inv').attr('data-id',data.total);
           $('#newproduct').val(data.id);
           $('#cod_product').html(data.codigo);
           $('#name_product').html(data.nombre);
           $('#cant').html(data.cantidad);
           $('#price').html(data.precio);
           $('#id_money').attr('data-id',data.moneda);
           $('#id_money').html(data.moneda);
           $('#total').html(data.total);
     },
     error: function(data) {
     }
  });
});

$(document).on('change', '#tip_moneda', function(event) {
    var tipomoneda = $(this).val();
    var precio = parseInt($('#bono_inv').attr('data-id'));
    var moneda = $('#id_money').attr('data-id');

    if (moneda == 'USD' && tipomoneda == 1){
      var total = precio * 3.3;
      $('#bono_inv').attr('data-id',total);
    }else if (moneda == 'PEN' && tipomoneda == 2){
        total = precio / 3.3;
        $('#bono_inv').attr('data-id',total);
    }else {
      var moneda = $('#id_money').attr('data-id');
    }


});

function openCertBook(id) {
  //var resp = validDniFile();
  idImprimir = id;
  if (true){
      $("#exampleModalCenter").modal('show');
  }

}
function openCertTicket() {
  var resp = validDniFile();
  if (resp == 'true'){
      $("#exampleModalCenter").modal('show');
  }

}
function emptyTable(){
  $('#cod_ticket').empty('');
  $('#voucher').empty('');
  $('#voucher_pago').empty('');
  $('#id_country_invert').empty('');
  $('#id_pay').empty('');
  $('#id_banck').empty('');
  $('#number_operation').empty('');
  $('#date_pay').empty('');
  $('#cod_product').empty('');
  $('#name_product').empty('');
  $('#cant').empty('');
  $('#price').empty('');
  $('#id_money').empty('');
  $('#total').empty('');
  $('#name_inv').empty('');
  $('#tip_moneda_inv').empty('');
  $('#dni_inv').empty('');
  $('#phone_inv').empty('');
  $('#status_ticket').empty('');
  $('#fecha_bono_view').empty('');
  $('#bono_inv_view').empty('');
  $('#fec_cob_inv').empty('');
  $('#mod_pag_inv').empty('');
  $('#obser_inv_view').empty('');
  $('#obser_int_view').empty('');
  $('#selProduct').empty('');
  $('#calProduct').empty('');
  $('#selSponsor').empty('');
  $('#calSponsor').empty('');
  $('#newsponsor').val('');
}


function download_ticket(id){
   alertify.confirm('Ticket', 'Â¿Desea descargar ticket?', function(){
       alertify.success('Procesando');
       window.location.href = "/customers/pdfTicket/"+id+"";
   },function(){
   }).set({labels:{ok:'Si', cancel: 'No'}, padding: false});
}

//validar solo numeros
function validaNumericos(event) {
    if(event.charCode <= 13 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46){
      return true;
    }else {
     return false;
    }
}

//validar solo letras
function validaLetras(event) {
    if(event.charCode >= 65 && event.charCode <= 241 || event.charCode == 32 ){
      return true;
     }
     return false;
}

$.fn.dataContent        = function (data){
  $('#cod_ticket').html(data.cod_ticket);
  $('#id_country_invert').val(data.id_country_invert);
  $('#id_pay').html(data.id_pay);
  $('#id_banck').html(data.id_banck);
  $('#number_operation').html(data.number_operation);
  $('#date_pay').html(data.date_pay);
  $('#cod_product').html(data.cod_product);
  $('#name_product').html(data.name_product);
  $('#cant').html(data.cant);
  $('#price').html(data.price);
  $('#id_money').html(data.id_money);
  $('#id_money').attr('data-id',data.id_money);
  $('#total').html(data.total);
  $('#name_inv').html(data.name_inv);
  $('#dni_inv').html(data.dni_inv);
  $('#phone_inv').html(data.phone_inv);
  $('#status_ticket').html(data.nom_estado);
}

$.fn.getUrl             = function (id,name) {
  var url = window.location.pathname;
    url = url.split("/")[1];

    if (url == 'atencion' || url == 'admin'){
      if (id != null){
        url = '/'+url+'/'+name+'/'+id;
      }else{
        url = '/'+url+'/'+name;
      }
    }else{
      if (id != null){
        url = '/'+url+'/'+name+'/'+id;
      }else{
        url = '/'+url+'/'+name;
      }
    }
    return url;
};

$.fn.updateStatus = function(id){

   $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
   $.ajax({
             data:  {status : 2, id : id},
             url:   '/customers/updateStatus',
             dataType: "json",
             type:  "POST",
             beforeSend: function () {
               $('#load_inv').show(300);

             },
             success:  function (response) {
                $('#load_inv').hide();

                alertify.alert('Gestion de Estatus', response.mensaje, function(){

                });
               }
       });
 }

     ///UPDATE pays
     $.fn.updatePays = function(id, url){
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax({
               data:  {data : $('#dataticket').serializeObject(), id : id},
               url:   url,
               dataType: "json",
               type:  "POST",
               success:  function (response) {

               }
         });
   }


$.fn.updateBooks = function(status, id, tablebook, url){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
              data:  {status : status, id : id},
              url:   url,// "/ticket/updateBooks",
              dataType: "json",
              type:  "POST",
              success:  function (response) {
                 alertify.alert('Gestion de Estatus', response.mensaje, function(){
                    tablebook.ajax.reload();
                 });
                }
        });
  }

$.fn.saveNumberBook = function(numberbook, id, table, url){

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
              data:  {numberbook : numberbook, id : id},
              url:   url,// "/ticket/saveNumberBook",
              dataType: "json",
              type:  "POST",
              beforeSend: function () {
                $('#load_inv').show(300);
              },
              success:  function (response) {
                 $('#load_inv').hide();
                 alertify.alert('Gestion de Estatus', response.mensaje, function(){
                    //table.ajax.reload();
                    location.reload();
                 });
                }
        });
  }

$.fn.btnSee = function(){
   var url = window.location.pathname;
       url = url.split("/")[1];
   if (url == 'customers'){
     $(".customers").css('display','block');
   }
   if (url == 'atencion') {
     $(".atencion").css('display','block');
   }
   if (url == 'admin')    {
     $(".admin").css('display','block');
   }

 };

$.fn.serializeObject    = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
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
///---------------------------------------------------------------editar ticket
function update(data)
{
  $.ajax(
    {
      url: "",
      type:"POST",
      data : {data:data},
      dataType: "json",
      beforeSend: function ()
      {

      },
    }).done(function(d)
    {

    }).fail(function(){
      alert("Â¡Ha ocurrido un error en la operaciÃ³n!");
    });
}

function getCustomerWinIstoShare()
{

  var valor = $("#changeSponsor").val();

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax(
    {
      url: "/report/customerWinIstoShareAndTaxiWin",
      type:"POST",
      data : { data: valor },//
      dataType: "json",
      beforeSend: function () {
        $('#load_shareholder').show(300);
     }
    }).done(function(d)
    {
      console.log(d);
      $('#load_shareholder').hide(300);
      if(d.dato == "error")
      {
        alert("No se encontro Datos");
        $("#name_inv").html('');
        $("#dni_inv").html('');
        $("#phone_inv").html('');
        $("#newsponsor").html('');
      }else{
      $("#name_inv").html('<input type="text" value="'+d.mensaje.first_name+'" name="first_name" id="first_name" disabled="disabled"><input type="text" value="'+d.mensaje.last_name+'" name="last_name" id="last_name" disabled="disabled">');
      $("#dni_inv").html('<input type="text" value="'+valor+'" name="dni_invi" id="dni_invi" disabled="disabled">');
      $("#phone_inv").html(d.mensaje.phone);
      $("#newsponsor").val(valor);
      }

      $( "#name_inv" ).prop( "disabled", true );
      $( "#dni_inv" ).prop( "disabled", true );
      $( "#phone_inv" ).prop( "disabled", true );
      action = 0;
    }).fail(function(){
      alert("Â¡Ha ocurrido un error en la operaciÃ³n!");//alerta del ticket no resgistrado
    });
}


function onKeyDownHandler(event)
{

    var codigo = event.which || event.keyCode;

    if(codigo === 13){//Al precionar enter
      getCustomerWinIstoShare();
    }

}

function cargarDni(){
  $("#modal-viewDniUpload").modal('show');
}

function viewDni(id)
{
  $('.carousel-inner').html("");
  var doc_front = $("#doc_front").val();
  var doc_back    = $("#doc_back").val();

  if (doc_front != '' && doc_back != '' ){
    $('.carousel-inner').html(
      '<div class="item active" align="center" >'+
      '<img src="'+doc_front+'" alt="DNI LADO A"  tyle="width:400px;height:400px;">'+
      '</div>'+

      '<div class="item" align="center">'+
      '<img src="'+doc_back+'" alt="DNI LADO B"   tyle="width:400px;height:400px;">'+
      '</div>'
    );
    $("#modal-viewDni").modal('show');

  }
  else{
    alert("Este usuario aun no ha cargado su documento de identidad.");
    cargarDni();
  }

}

function validDniFile()
{
  var doc_front = $("#doc_front").val();
  var doc_back    = $("#doc_back").val();

  if (doc_front != '' && doc_back != '' ){
    return 'true';
  }
  else{
    alert("Este usuario aun no ha cargado su documento de identidad.");
    cargarDni();
  }

}

function actualizarDni() {
  $("#modal-viewDni").modal('hide');
  cargarDni();
}

function saveDni() {
  var id       = $("#id_customer").val();
  upImgDni(id,'doc-front', 'doc_front', $("#country-name").val());
  upImgDni(id,'doc-back',    'doc_back'   , $("#country-name").val());
  $("#modal-viewDni").modal('hide');
  setTimeout(function() {
    location.reload();
  }, 3000);

}

function upImgDni(id, idinput, nameFile, country){
  var array     = new Uint32Array(1);
  var aleatorio = window.crypto.getRandomValues(array);

  ficherodni = document.getElementById(idinput);

  var metadata = {
    contentType: 'image/jpeg'
  };

  storageRef = firebase.storage().ref();
  var imagenASubir = ficherodni.files[0];
  var uploadTask = storageRef.child('dni_accionistas/'+country+'/'+aleatorio+''+imagenASubir.name).put(imagenASubir, metadata);
  uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
  function(snapshot){
  //se va mostrando el progreso de la subida de la imagenASubir
  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
  if (progress == 100){
    alertify.notify('se guardo la imagen', 'success', 3, function(){ });
  }

  }, function(error) {
    console.log('error '+error);
    //gestionar el error si se produce
    alert('Ha ocurrido un inconveniente al tratar de subir la imÃ¡gen, por favor intente de nuevo, si el problema persiste, por favor comunÃ­quese con soporteusuario@winhold.net');
  }, function() {
    //cuando se ha subido exitosamente la imagen
    pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
       data = {
          'id_customer': id,
          'url': downloadURL,
          'name': nameFile,
          'voucherName': imagenASubir.name
        };

      $.ajax({
        url: "/customer/saveDniFile",
        type:"post",
        data:{
          data : data
        },
        beforeSend: function () {
        },
        }).done( function(d) {

        }).fail( function() {
          alert("Ha ocurrido un error en la operaciÃ³n");
        }).always( function() {
        });


      });
    });

    return true;
}

$(document).on('change','.btn-file :file',function(){
  var input = $(this);
  var numFiles = input.get(0).files ? input.get(0).files.length : 1;
  var label = input.val().replace(/\\/g,'/').replace(/.*\//,'');
  input.trigger('fileselect',[numFiles,label]);
});

$(document).ready(function(){
  $('.btn-file :file').on('fileselect',function(event,numFiles,label){
    var input = $(this).parents('.input-group').find(':text');
    var log = numFiles > 1 ? numFiles + ' files selected' : label;
    if(input.length){ input.val(log); }else{ if (log) alert(log); }
  });
});

function activarTicket(idlocal)
{
  $.ajax({
    type: "POST",
    url: "/ticketActivationAdmin",
    data: {id:idlocal},
    dataType : 'json',
  }).done(function(d){
    console.log(d.rol);
    console.log(d.name);
    $.fn.updateStatus(idlocal);
    alertify.success('Se activo correctamente');
    enviarcorreo(idlocal);
  }).fail(function(){
    alert("No se pudo procesar la solicitud");
  });
}
function enviarcorreo(idlocal){
  alertify.confirm('Actualizado', 'Él ticket ha sido activado exitosamente! ¿ Desea enviar a su correo electronico el Ticket generado ?', function(){
      alertify.success('Aceptar');
      sendmail(idlocal);
      $('#load_inv').hide();

  },function(){
    alertify.success('Cancelar');
    $('#load_inv').hide();
    location.reload();
  });
}
function sendmail(idlocal){
  $.ajax({
    type: "POST",
    url: "/send/email/ticket",
    data: {id:idlocal},
    beforeSend: function () {
      $('#load_inv').show();
      },
  }).done(function(d){
    if(d.mensaje == 'Enviado el correo'){
      location.reload();
      $('#load_inv').hide();
    }
    $('#load_inv').hide();

  }).fail(function(){
    $('#load_inv').hide();
    alert("No se pudo procesar la solicitud");
  });
}


function openNoteCetificado(id_ticket)
{
  $.ajax({
    type: "POST",
    url: "/books/get",
    data: {id:id_ticket},
  }).done(function(d){
    alertify.prompt( 'Nota del certificado', 'Nota', d.data.note
                 , function(evt, value)
                 {

                   $.ajax({
                     type: "POST",
                     url: "/books/coments",
                     data: {id:id_ticket,note:value},
                     dataType : 'json',
                   }).done(function(d){
                     alertify.success('Se activo correctamente');
                   }).fail(function(){
                     alert("No se pudo procesar la solicitud");
                   });
                 }
                 , function() { alertify.error('Cancel') });
  }).fail(function(){
    alert("No se pudo procesar la solicitud");
  });

}

 function upModalTrasferencia(ids)
 {
   $('#modal-file').modal('show');
 }
 function upModalFile(id_book,id_customer)
  {

    $.ajax({
      type: "POST",
      url: "/file/get",
      data: {id_book:id_book,id_customer:id_customer},
      dataType : 'json',
    }).done(function(d){
      if(d.object == "success"){

        if(d.data == null)
        {

        }else {
          if(d.data.url_contrato != null)
          $('#ver_contrato').attr({'href': d.data.url_contrato,'style':'font-weight: bold !important; background-color:#C9C9C9 !important'});
          else {
            $('#ver_contrato').attr({'href': "#",'style':'font-style: oblique !important; background-color:#fff !important'});

          }
          if(d.data.url_certificado_old != null)
          $('#ver_certificado_old').attr({'href': d.data.url_certificado_old,'style':'font-weight: bold !important; background-color:#C9C9C9 !important'});
          else {
            $('#ver_certificado_old').attr({'href': "#",'style':'font-style: oblique !important; background-color:#fff !important'});
          }
          if(d.data.url_certificado_new != null)
          $('#ver_certificado_new').attr({'href': d.data.url_certificado_new,'style':'font-weight: bold !important; background-color:#C9C9C9 !important'});
          else {
            $('#ver_certificado_new').attr({'href': "#",'style':'font-style: oblique !important; background-color:#fff !important'});
          }
          if(d.data.url_baucher_old != null)
          $('#ver_baucher_old').attr({'href': d.data.url_baucher_old,'style':'font-weight: bold !important; background-color:#C9C9C9 !important'});
          else {
            $('#ver_baucher_old').attr({'href': "#",'style':'font-style: oblique !important; background-color:#fff !important'});
          }
          if(d.data.url_baucher_new != null)
          $('#ver_baucher_new').attr({'href': d.data.url_baucher_new,'style':'font-weight: bold !important; background-color:#C9C9C9 !important'});
          else {
            $('#ver_baucher_new').attr({'href': "#",'style':'font-style: oblique !important; background-color:#fff !important'});
          }
          if(d.data.url_traspado != null)
          $('#ver_traspado').attr({'href': d.data.url_traspado,'style':'font-weight: bold !important; background-color:#C9C9C9 !important'});
          else {
            $('#ver_traspado').attr({'href': "#",'style':'font-style: oblique !important; background-color:#fff !important'});
          }
        }
        daf.id_book = id_book;
        daf.id_customer = id_customer;
        $('#modal-file').modal('show');
      }
    }).fail(function(){
      alert("No se pudo procesar la solicitud");
    });

  }


var daf = new Object();
  function subirfoto()
  {
  var data = ['url_contrato','url_certificado_old','url_certificado_new','url_baucher_old','url_baucher_new','url_traspado'];
    upImg_g(data,daf,'/file/save','POST');
  }
