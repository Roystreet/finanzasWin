$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
///---------------------------------------------------------------------------
//cargarArbol();
var tree;
function cargarArbol()
{
  $( "#tree-simple" ).remove();
  $( '<div id="tree-simple" style="width:100%; height: 800px;"> </div>' ).insertBefore( "#user" );
  var user = $('#user').val();
  var profundidad = 200;
  $.ajax(
  {
    url: "/customer/tree",
    type:"POST",
    data:{pro:profundidad,user:user},
    dataType: "json",
    beforeSend: function () {
      $('.docs-example-modal-sm').modal('toggle');
          }
  }).done(function(d)
  {
    console.log(d.mensaje);
     tree_structure =

    {
        chart: {
            container: "#tree-simple",
            levelSeparation:    20,
            siblingSeparation:  15,
            subTeeSeparation:   15,
            rootOrientation: "EAST",

            node: {
                HTMLclass: "tennis-draw",
                drawLineThrough: true
            },
            connectors: {
                type: "straight",
                style: {
                    "stroke-width": 2,
                    "stroke": "#ccc"
                }
            }
        },
        nodeStructure:d.mensaje.tree
    };
      new Treant( tree_structure );
     // $('#sponsor').html(d.mensaje.sponsor.Apellido +", "+ d.mensaje.sponsor.Nombre);
     // $('#parent').html(d.mensaje.pared.Apellido +", "+ d.mensaje.pared.Nombre);
     // $('#directos').html(d.mensaje.person.countDirect);
     $('#countTree').html(cantidadpersonas(d.mensaje.tree));
     //
     // $('#first_name').val(d.mensaje.person.Nombre);
     // $('#phone').val(d.mensaje.person.phone);
     // $('#last_name').val(d.mensaje.person.Apellido);
     // $('#user').val(d.mensaje.person.Codigo);
     // $('#email').val(d.mensaje.person.Correo);
     $('.docs-example-modal-sm').modal('hide');
     //
     // getTree(objetoPerson(d.mensaje.tree));
  }).fail(function(){
    alert("¡Ha ocurrido un error en la operación!");//alerta del ticket no resgistrado
  });
}

function getTree(a)
{
  tree = a;
}

function cantidadpersonas(d)
{
  var cantidad = 0;
  $.each( d.children, function( key, value )
  {
  cantidad++;
  cantidad += cantidadpersonas(value);
  });
  return cantidad;
}

function objetoPerson(d)
{
  var arry = [];
  $.each( d.children, function( key, value )
  {
  var a = new Object();
  a = value.text;
  arry.push(a);

  if(value.children)
  {
    var b = objetoPerson(value);
    $.each( b, function( key, value )
    {
      var c = new Object();
      c = value.text;
      arry.push(value);
    });
  }
  });
  return arry;
}
