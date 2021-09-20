$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
function imprimir()
{

    var data =
    [
      2642,2641,2639
    ];
    var fecha = "12-12-2012";
    var str = "Lima";
    window.location.href = "/customers/print/blocks/"+data+"/"+fecha+"/"+str;

}
