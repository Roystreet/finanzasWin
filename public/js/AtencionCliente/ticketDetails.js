$('#answerticket').hide();
$('#addnotadiv').hide();
$('#group').select2();
$('#id_priority').select2();
$('#id_status').select2();
$('#typeRs').select2();
$('#agentID').select2();
$('#typeConv').select2();
$('#agentsGID').select2();


$("#respdiv").click(function() {
  $('#answerticket').show();
  $('#respdiv').hide();
  $('#respNot').hide();
});


$("#respNot").click(function() {
  $('#addnotadiv').show();
  $('#respdiv').hide();
  $('#respNot').hide();
});


$("#respdelete").click(function() {
  $('#answerticket').hide();
  $('#respdiv').show();
  $('#respNot').show();
});

$("#respdeleteNot").click(function() {
  $('#addnotadiv').hide();
  $('#respdiv').show();
  $('#respNot').show();
});

$("#typeRs").change(function(){
  if ($(this).val() == ""){
    $('#btn-updateT').prop("disabled", true);
  }else{
    $('#btn-updateT').prop("disabled", false);
  }
});

$("#id_status").change(function(){
  if ($(this).val() == ""){
    $('#btn-updateT').prop("disabled", true);
  }else{
    $('#btn-updateT').prop("disabled", false);
  }
});

$("#id_priority").change(function(){
  if ($(this).val() == ""){
    $('#btn-updateT').prop("disabled", true);
  }else{
    $('#btn-updateT').prop("disabled", false);
  }
});

$("#group").change(function(){
  var groupVal = $(this).val();
  if (groupVal == ""){
    $('#btn-updateT').prop("disabled", true);
  }else{
    $.ajax(
      {
        url: "/atencion/freshdesk/GetAgentsByGroupID",
        type: "POST",
        data : { id : groupVal},
        dataType: "json",
      }).done(function(d)
      {
        console.log(d.data);
        $('#agentID').empty();
        var fila = '<option value="">--</option>';
        $.each(d.data,function(key, registro)
        {
          fila += '<option value='+registro.id+'>'+registro.username.toUpperCase()+' - '+registro.name.toUpperCase()+' '+registro.lastname.toUpperCase()+'</option>';
        });
        $("#agentID").append(fila);

      }).fail(function(d){
        console.log(d);//alerta del ticket no resgistrado
      });
      $('#btn-updateT').prop("disabled", false);
  }
});

$("#agentID").change(function(){
  if ($(this).val() == ""){
    $('#btn-updateT').prop("disabled", true);
  }else{
    $('#btn-updateT').prop("disabled", false);
  }
});

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$("#btn-updateT").click(function() {
  var formDataS = new FormData($("#updateTi")[0]);
  var nroti = $('#tic').attr('data-id');
  var idregti = $('#tic').attr('data-idr');
  formDataS.append("idregti", idregti);
  formDataS.append("nroti", nroti);
  $.ajax(
    {
      url: "/atencion/freshdesk/update",
      type: "POST",
      data : formDataS,
      processData: false,
      contentType: false,
    }).done(function(d)
    {
      alertify.notify('Se actualizo correctamente el ticket', 'success', 2 , function(){ location.reload(); });
    }).fail(function(d){
      console.log(d);
      //alerta del ticket no resgistrado
      alert('el ticket no se actualizo');
    });
});


$(".pend").click(function() {
  var type = $(this).attr('data-id');
  var idti = $('#tic').attr('data-id');
  var idregt = $('#tic').attr('data-idr');
  var editor = CKEDITOR.instances['editor'].getData();
  var formData = new FormData($("#myform")[0]);
  formData.append("type", type);
  formData.append("idti", idti);
  formData.append("idregt", idregt);
  formData.append("desc", editor);
  $.ajax(
    {
      url: "/atencion/freshdesk/reply",
      type: "POST",
      data : formData,
      processData: false,
      contentType: false,
    }).done(function(d)
    {
      alertify.notify('Se agrego exitosamente la respuesta!', 'success', 2 , function(){ location.reload(); });
    }).fail(function(d){
      console.log(d);//alerta del ticket no resgistrado
      alert('el ticket no se registro');
    });
});

$(".noteSt").click(function() {
  var typeN = $(this).attr('data-id');
  var idtiN = $('#ticNot').attr('data-id');
  var idregtN = $('#ticNot').attr('data-idr');
  var editorN = CKEDITOR.instances['editor1'].getData();
  var formData = new FormData($("#myform1")[0]);
  formData.append("type", typeN);
  formData.append("idti", idtiN);
  formData.append("idregt", idregtN);
  formData.append("desc", editorN);
  $.ajax(
    {
      url: "/atencion/freshdesk/replyNote",
      type: "POST",
      data : formData,
      processData: false,
      contentType: false,
    }).done(function(d)
    {
      alertify.notify('Se creo exitosamente la nota!', 'success', 2 , function(){ location.reload(); });
    }).fail(function(d){
      console.log(d);//alerta del ticket no resgistrado
      alert('la nota no se registro');
    });
});
