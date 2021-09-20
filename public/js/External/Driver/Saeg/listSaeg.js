$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
fillTable();
function fillTable()//Inicio Fill
{
  $.ajax({
    url: "/driver/saeg/list/drivers",
    type:"post",
    beforeSend: function () {
    },
  }).done( function(d) {

    if(d.object == "success"){
       $('#driver').DataTable({
      'responsive'  : false,
      'destroy'  : true,
      "scrollX"  : true,
      'buttons'  : [
        {
          'extend': 'pdf',
          'text': 'PDF',
          'messageBottom': null,
          'download': 'open',

        },

        {
          'extend': 'excel',
          'text' :   'EXCEL',
          'messageTop': null,

        },
        {   'extend': 'copy',
            'text': 'Copiar',

        },

        {
            'extend': 'print',
            'text' : 'Imprimir',
            'messageTop':null,
            'messageBottom': null,

        }
        ],
      'language' : {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando START a END de TOTAL Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de MAX total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar MENU Entradas",
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
      "data"     : d.data,
      "columns"  : [
        // {
        //        sortable: false,
        //        "render": function ( data, type, full, meta ) {
        //            return '<a class="btn btn-primary fa fa-cog" href="/driver/externo/details/'+ 3 +'" target="_blank"></a>';
        //        }
        // },
        // {
        //    sortable: false,
        //    "render": function ( data, type, full, meta ) {
        //        return '<button type="button" class="btn btn-primary fa fa-user" onclick="viewHistorico('+full.id+')"></button>';
        //        }
        // },
        // {
        //    sortable: false,
        //    "render": function ( data, type, full, meta ) {
        //        return '<button type="button" class="btn btn-primary fa fa-binoculars" onclick="viewRecord('+full.id+')"></button>';
        //        }
        // },
        {
           sortable: false,
           "render": function ( data, type, full, meta ) {
             if(full.status==null)
             {
               //$(data).css('background-color', 'Red');
               return '<p style="color:red">no se mando la solicitud.</p>';
             }
             else
             {
               return '<p style="color:blue">-.</p>';
             }

               }
        },
          {data:"dni"},
          {data:"id_office"},
          {data:"first_name"},
          {data:"last_name"},
          {data:"phone"},
          {data:"email"},
          {
             sortable: false,
             "render": function ( data, type, full, meta ) {
               if(full.antecedentes==0)
               {
                 //$(data).css('background-color', 'Red');
                 return '<button type="button" class="btn fa fa-eye-slash"</button>';
               }
               else
               {
                 return '<button type="button" class="btn fa  fa-eye" onclick="viewPDF('+full.id+')"></button>';
               }

                 }
          },
      ]
  });

    } else {
      $('#driver').DataTable();
      alert(d.message);
    }
  }).fail( function() {
    alert("Ocurrio un error en la operación");
  }).always( function() {


  });
}//fin de fillTable

function abrirNuevoTab(url) {
        // Abrir nuevo tab
        var win = window.open(url, '_blank');
        // Cambiar el foco al nuevo tab (punto opcional)
        win.focus();
      }

function viewPDF(id)
{
  abrirNuevoTab(url="/driver/saeg/pdf/antecedente/"+id);
}
