
    @extends('layout-simple')
    @section('title', 'Pago por tarjeta')
    @section('content')

    <style>
    .categoriesDiv {
      width:100% !important;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .button {
  background-color: #008CBA; /* Green */
  border: 2px;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}
.button2:hover {
  background-color: #ffe22b;
  color: black;
}

    </style>
    <section class="content">
      <div class="box content-pay" style="margin-bottom:4%;height:270px;margin-top:4%;margin-left:auto;margin-right:auto;">
        <div class="box-header">
          <h3 class="box-title">Pago con tarjeta</h3>
        </div>
        <div class="box-body">

      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- title row -->
      <div class="panel panel-primary" style="width:250px;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;box-shadow: 3px 3px 6px #999;">
          <!-- pagar con tarjeta -->
          <div class="panel-heading">Pagar via Culqi</div>
          <div class="panel-body"> <!-- panel-primary-body -->
          <div class="categoriesDiv" style="width:100% " >


          <div class="form-group"  >
            <div class="row">
              <div class="col-xs-9" id="pago" data-amount="{{ $monto }}" data-desc="{{ $ticket->getProduct[0]->cant }} {{ $ticket->getProduct[0]->name_product}}" data-mon="{{ $ticket->getMoney[0]->{'description'} }}" data-dni="{{ $ticket->getCustomer->document }}" data-id="{{ $id }}"><label for="Datos">Pago con tarjeta</label>
                <div class="input-group valpago">
                  <div class="input-group-addon" style="border-color:#252d3d;">
                    <i class="fa  fa-credit-card" style="box-shadow: 3px 3px 6px #999;"></i>
                  </div>
                    <button type="button" class="button button2" name="btn_culqi" id="btn_culqi" style="box-shadow: 3px 3px 6px #999;margin:0px;border-color:#252d3d;"><b>Pagar</b></button>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>





          <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
            <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
              <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
            </div>
          </div>
        </div><!-- box body -->
        </div><!-- box -->

    </section>
    @endsection
    @section('script')
    <script src="{{ asset('js/External/sales/checkout.js')}}"></script>
    @endsection
