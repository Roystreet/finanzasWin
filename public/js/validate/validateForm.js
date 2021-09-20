function formCreate(obj,f)
{
var  newtr = '<div class="row">';
    $.each( f, function( key, value ) {
      newtr = newtr + '<div class = "col-lg-6">'+
                      '<div class="form-group">'+
                      '<label for="'+value.lavel+'">'+value.lavel+'</label>'+
                      '<input type="'+value.type+'" class="form-control" id="'+value.id+'" '+
                      'placeholder="'+value.placeholder+'" ></div></div>' ;
    });
    newtr = newtr + "</div>";
    $(obj).append(newtr);
}

// var f = [
//    {id: 1,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    {id: 2,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true},
//    {id: 3,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    {id: 4,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true},
//    {id: 5,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    {id: 6,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true},
//    {id: 7,lavel:"Nombres",placeholder: "Nombres",type:"text",required:true},
//    {id: 8,lavel:"Apellidos", placeholder: "Apellidos",type:"file",required:true}
//  ];
// formCreate('#midiv',f);

function formValidateNull(f)
{
  var respuesta = false;
  $.each( f, function( key, value )
  {
    if($("#"+value.id).val() == "" || $("#"+value.id).val() == null)
    {
      $("#"+value.id).css("border", "1px solid red");
    }
    else
    {
      $("#"+value.id).css("border", "1px solid green");
    }
  });
}




function enviar()
{
  formValidate(f);
}
