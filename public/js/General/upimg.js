
function upImg_g(array,data,url,metodo,reload = true)//data en array, data en un objeto,url,el metodo
{
  var contador = 0;
  var contadorVerificado = 0;
  array.forEach((item, i) => {
    if(($('#'+item).get(0).files.length)===0)
    {
    }else {
      contadorVerificado++;
    }
  });
  array.forEach((item, i) => {
    if(($('#'+item).get(0).files.length)===0)
    {
    }else {
      sleep(300);
      fichero = document.getElementById(item);
      storageRef = firebase.storage().ref();
      var imagenASubir = fichero.files[0];
      var aleatorio = Math.floor(Math.random() * (999 - 100)) + 100;
      var uploadTask = storageRef.child('imgVoucher/' + imagenASubir.name+aleatorio).put(imagenASubir);
      uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
      function(snapshot){

      var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
      }, function(error) {
        //gestionar el error si se produce
      }, function() {
        //cuando se ha subido exitosamente la imagen
        pathUrlImg = uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
          console.log(downloadURL);
          $.ajax({
             type: metodo,
             url: url,
             data: {
               url : downloadURL,
               campo : item,
               data:data
             },
             dataType : 'json',
             beforeSend: function(){
             },
             success: function(d) {
                if (d.object == "success"){
                  alertify.success('registrado');
                  contador++;
                  if(contadorVerificado == contador)
                  {
                    if(reload)
                    {
                      location.reload();
                    }
                  }
                }
             },
             error: function(data) {
             }
          })
       });
     });
    }


  });


}
