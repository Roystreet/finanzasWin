$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });







  $("#envi").click(function() {
    //var file = $('#fileSelect').target.files[0];
    var filename = $('#fileSelect').val().split('\\').pop();
      $.ajax({
            url: "/customer/mensaje",
            type:"post",
            data:{file:filename},
            datatype:"json",
            beforeSend: function () {
                  },
          }).done( function(d)
          {

          }).fail( function() {

          }).always( function() {

            });


});
