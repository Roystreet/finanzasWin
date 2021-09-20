
$(document).ready(function(){
        //$("#cod_shareholder").val("sadsdas");
        $("#cod_shareholder").prop('disabled', true);



        $(document).on('click','.btn_ajax',function()
        {
          var cod_shareholder = $('input:text[name=cod_shareholder]').val();
          var first_name = $('input:text[name=first_name]').val();
          var last_name = $('input:text[name=last_name]').val();
          var dni = $('input:text[name=document]').val();
          var phone = $('input:text[name=phone]').val();
          var email = $('input:text[name=email]').val();
          var pais = $("#sCountry option:selected").val();
          var departamento = $("#sState option:selected").val();
          var provincia = $("#sCity option:selected").val();
          var distrito = $('input:text[name=Distrito]').val();
          var parametros =  {
              "cod_shareholder" : cod_shareholder,
              "first_name" : first_name,
              "last_name" : last_name,
              "document" : dni,
              "phone" : phone,
              "email" : email,
              "cod_country":pais,
              "cod_state":departamento,
              "cod_city":provincia,
              "distrito":distrito
            };


          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          $.ajax(
            {
              url: "/shareholder",
              type:"POST",
              data:parametros
            }).done(function(d)
            {
                console.log(d);
                $("#cod_shareholder").val(d.codShareholder);
                alert("Registrado");
                $('#tbSahreholder tbody').empty();

                for(var i in d.shareholder)
                {
                  $('#tbSahreholder tbody').append('<tr><td>' + d.shareholder[i].cod_shareholder+
                  '</td><td>' + d.shareholder[i].first_name +
                  '</td><td>' + d.shareholder[i].last_name +
                  '</td><td>' + d.shareholder[i].document +
                  '</td><td>'+d.shareholder[i].phone+
                  '</td><td>'+d.shareholder[i].email+
                  '</td><td>'+d.shareholder[i].country+
                  '</td><td>' + d.shareholder[i].description +
                  '</td><td>'+d.shareholder[i].city+
                  '</td><td>'+d.shareholder[i].district+
                  '</td><td>'+d.shareholder[i].created_at+
                  '</td></tr>');
                }
            }).fail(function()
            {
              alert("Intenta Nueva Mente Error");
            });
        });


        $('#sCountry').on('change', function (e)
        {
          var selectVal = $("#sCountry option:selected").val();
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          $.ajax(
            {
              url: "/state",
              type:"POST",
              data:{id_country:selectVal}
            }).done(function(d)
            {
              $('#sState option').remove();
              $.each(d,function(key, registro)
                {
                  $("#sState").append('<option value='+registro.id+'>'+registro.description+'</option>');
                });
            }).fail(function()
            {
              alert("Intenta Nueva Mente Error");
            });
        });

        $('#sState').on('change', function (e)
        {
          var selectVal = $("#sState option:selected").val();
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          $.ajax(
            {
              url: "/city",
              type:"POST",
              data:{id_state:selectVal}
            }).done(function(d)
            {
              $('#sCity option').remove();
              $.each(d,function(key, registro)
                {
                  $("#sCity").append('<option value='+registro.id+'>'+registro.description+'</option>');
                });
            }).fail(function()
            {
              alert("Intenta Nueva Mente Error");
            });
        });

        $('#sState').on('change', function (e)
        {
          var selectVal = $("#sState option:selected").val();
          $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          $.ajax(
            {
              url: "/city",
              type:"POST",
              data:{id_state:selectVal}
            }).done(function(d)
            {
              $('#sCity option').remove();
              $.each(d,function(key, registro)
                {
                  $("#sCity").append('<option value='+registro.id+'>'+registro.description+'</option>');
                });
            }).fail(function()
            {
              alert("Intenta Nueva Mente Error");
            });
        });


        $('#tbSahreholder').DataTable({
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

});
