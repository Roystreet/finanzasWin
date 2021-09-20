$(document).ready(function(){
  $('.select2').select2();
  var table;

  table = $('#users').DataTable({
      'ajax': {
        'url': "/usersAll",
        'type':"GET",
      },
       'responsive'  : true,
       'autoWidth': false,
       'destroy'   : true,
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
       'columns':[
          {data: "action"},
          {data:"username"},
          {data:"name"},
          {data:"document"},
          {data:"phone"},
          {data:"email"},
          {data:"id_country"},
          {data:"usermodifyby"},
          {data:"status_user"}]
    });
  $("#btn_rol").unbind('click');

  $('#users tbody' ).on('click','.btn-modalShow', function () {
    var id = $(this).attr("data-id");
  	$("#id_user").val(id);
    $.fn.showUser(id);
  });

  $(".btn-modalRol").unbind('click');
  $('#users tbody' ).on('click','.btn-modalRol',  function () {
    var id = $(this).attr("data-id");
    $.fn.showRoles(id);
  });

  $(".btn-modalPermisos").unbind('click');
  $('#users tbody' ).on('click','.btn-modalPermisos',  function () {
    var id = $(this).attr("data-id");
    $.fn.showPermisos(id);
  });

  $.fn.showPermisos = function(id){
  var htmlRol = '';
  $('#id_permisos').val('').trigger('change.select2');
  $("#id_userP").val(id);

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
          data:  {id : id},
          url:   "/user/PermisosDetails",
          dataType: "json",
          type:  "POST",
          success:  function (response) {
            var id_permisos =  [];
            var id_roluser = response.id_roluser;
            $.each(response.permisos_user, function(i, item) {
                if (id_permisos.indexOf(item.id_permission)== -1) {id_permisos.push(item.id_permission); }
            });
            $('#id_permisos').val(id_permisos).trigger("change");
            $("#id_roluserp").val(id_roluser);
          }
      });
}

$(".btn-SavedPermisos").on("click",function() {
    var id_permisos  = $('#id_permisos').val();
    var id_roluserp = $('#id_roluserp').val();
    $.fn.updatePermisos(id_roluserp, id_permisos, table);
  });



  $('#users tbody' ).on('click','.btn-modalPass', function () {
    var id = $(this).attr("data-id");
    $('#password').closest('.form-group').removeClass('has-error');
    $('#password').closest('.form-group').find('.help-block').html('');
    $('#password-confirm').closest('.form-group').removeClass('has-error');
    $('#password-confirm').closest('.form-group').find('.help-block').html('');
    $('#id').val(id);
  });

  $('#users tbody').on('click','#status', function () {
    var status = $(this).attr("status");
    var id     = $(this).attr("data-id");

    alertify.confirm('Cambiar Estatus', '¿Está usted seguro que desea cambiar el estatus del usuario?', function(){
        $.fn.updateStatus(status, id, table);
    },function(){
    }).set({labels:{ok:'SI', cancel: 'NO'}, padding: false});

  });

  $(".btn-SavedRol").on("click",function() {
    var id_rol  = $('#id_rolU').val();
    var id_user = $('#id_userR').val();
    $.fn.updateRol(id_user, id_rol, table);
  });

  $("#sendPassw"   ).on("click",function() {
    var id = $('#id').val();
    $.fn.updatePassw(table);
  });


});


$.fn.selectRol         = function() {



}

$.fn.validaLetras      = function(event) {
    if(event.charCode >= 65 && event.charCode <= 241 || event.charCode == 32 ){
      return true;
     }
     return false;
}

$.fn.validaNumericos   = function(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;
}

$.fn.emptyTable        = function()  {
  $('#fullName').empty('');
  $('#document').empty('');
  $('#birthdate').empty('');
  $('#phone').empty('');
  $('#id_country').empty('');
  $('#address').empty('');
  $('#username').empty('');
  $('#gender').empty('');
  $('#id_rol').empty('');

}

$.fn.showUser          = function(id){
  $.fn.emptyTable();
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
      data:  {id : id},
      url:  "/userDetails",
      dataType: "json",
      type:  "POST",
      success:  function (response) {
        $('#fullName').append(response.user.lastname+' '+response.user.name);
        $('#document').append(response.user.document);
        $('#birthdate').append(response.user.birthdate);
        $('#phone').append(response.user.phone);
        $('#id_country').append(response.user.get_country.description);
        $('#address').append(response.user.address);
        $('#username').append(response.user.username);
        $('#gender').append(response.user.gender);

        var rol = '<table id="roles"  name="roles"   width="100%" align="left">'+
                    '<tr>'+
                      '<td colspan="2" height="20px"><pre><i class="fa fa-user"></i> - <b>Roles</b></pre></td>'+
                    '</tr>'+
                    '<tr>'+
                      '<td align="center"><b>N°</b></td>'+
                      '<td align="left"><b>Descripción</b></td>'+
                  '</tr>';

        $.each(response.user.get_roles, function( index, value ) {
          var num = index +1;
          rol += '<tr>'+
                      '<td align="center">'+num+'</th>'+
                      '<td align="left">'+value.description+'</td>'+
                    '</tr>';
        });
        rol += '</table>'
        $('#id_rol').append(rol);


      }
  });

}

$.fn.showRoles         = function(id){
  var htmlRol = '';
  $('#rol_details').empty();
  $('#id_rolU').val('').trigger('change.select2');
  $("#id_userR").val(id);

  $("#id_rolU").unbind('select2:select');
  $("#id_rolU").on('select2:select', function(e) {
  	$.fn.getRolDescription(e.params.data.id);
  });

  $("#id_rolU").unbind('select2:unselect');
  $("#id_rolU").on('select2:unselect', function(e) {
    $(".rol_"+e.params.data.id).remove();
  });


  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
          data:  {id : id},
          url:   "/user/rolDetails",
          dataType: "json",
          type:  "POST",
          success:  function (response) {
            var id_rol =  [];
            $.each(response.rol_user, function(i, item) {
                htmlRol += '<tr class=rol_'+item.id_rol+'>'+
                            '<td align="left" width="auto">'+item.main+'</td>'+
                            '<td align="left" with="100px">'+item.ramanombre+'</td>'+
                            '<td align="left" with="100px">'+item.rol+'</td>'+
                          '</tr>';
                if (id_rol.indexOf(item.id_rol)== -1) {id_rol.push(item.id_rol); }
            });
            $('#id_rolU').val(id_rol).trigger("change");
            $('#rol_details').append(htmlRol);
          }
      });


}

$.fn.getRolDescription = function(id){
  $(".rol_"+id).remove();
  var htmlRol = '';
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
          data:  {id : id},
          url:   "/user/rolDetailsSelect",
          dataType: "json",
          type:  "POST",
          success:  function (response) {
            $.each(response.rol, function(i, item) {
                console.log(item);
                htmlRol += '<tr class=rol_'+item.id_rol+'>'+
                            '<td align="left" width="auto">'+item.main+'</td>'+
                            '<td align="left" with="100px">'+item.ramanombre+'</td>'+
                            '<td align="left" with="100px">'+item.rol+'</td>'+
                          '</tr>';
            });
            $('#rol_details').append(htmlRol);
          }
    });

}

$.fn.updateRol = function(id_user, id_rol, table){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
          data:  {id_rol : id_rol, id_user : id_user},
          url:   "/user/updateRolUser",
          dataType: "json",
          type:  "POST",
          success:  function (response) {
            alertify.alert('Gestion de Roles', response.mensaje, function(){
               table.ajax.reload();
               $("#modal-rol").modal('hide');
            });
          }
  });

}


$.fn.updatePermisos = function(id_roluserp, id_permisos, table){
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  $.ajax({
          data:  {id_permisos : id_permisos, id_roluserp : id_roluserp},
          url:   "/user/updatePermisoUser",
          dataType: "json",
          type:  "POST",
          success:  function (response) {
            alertify.alert('Gestion de Permisos', response.mensaje, function(){
               table.ajax.reload();
               $("#modal-permisos").modal('hide');
            });
          }
  });

}

$.fn.updatePassw       = function(table){
  var flashP = false;
  var regex = /^[A-Za-z\d$@$!%*?&]{6,8}$/;
  var value  = $('#password').val();

  if(value == "" ){
    flashP = false;
    $('#password').closest('.form-group').find('.help-block').html('Este campo es obligatorio.');
    $('#password').closest('.form-group').removeClass('has-success').addClass('has-error');
    $('#password').focus();
  }
  else if(regex.test(value) == false){
      flashP = false;
      $('#password').closest('.form-group').find('.help-block').html('- Minimo 6 caracteres <br> - Maximo 8 <br> - Al menos una letra mayúscula <br> - Al menos una letra minucula <br> - Al menos un dígito <br> - No espacios en blanco <br> - Al menos 1 caracter especial');
      $('#password').closest('.form-group').removeClass('has-success').addClass('has-error');
      $('#password').focus();
  }
  else {
        flashP = true;
        $('#password').closest('.form-group').removeClass('has-error').addClass('has-success');
        $('#password').closest('.form-group').find('.help-block').html('');
  }


  if (flashP == true ){
     var password = $('#password').val();
     var id_user  = $('#id').val();

     console.log(password);
     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
     $.ajax({
               data:  {password : password, id_user : id_user},
               url:   "/user/updatePassword",
               dataType: "json",
               type:  "POST",
               success:  function (response) {
                 alertify.alert('Gestion de Contraseña', response.mensaje, function(){
                    table.ajax.reload();
                    $("#modal-passw").modal('hide');
                 });
                }
         });
   }

}

$.fn.updateStatus       = function(status, id, table){
   $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
   $.ajax({
             data:  {status : status, id : id},
             url:   "/user/updateStatus",
             dataType: "json",
             type:  "POST",
             success:  function (response) {
                alertify.alert('Gestion de Estatus', response.mensaje, function(){
                   table.ajax.reload();
                });
               }
       });
 }

$.fn.serializeObject   = function(){
    var o = {};
    var a = this.serializeArray()
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
}
