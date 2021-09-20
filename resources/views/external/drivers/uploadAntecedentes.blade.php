@extends('layout-backend')
@section('title', 'Buscar')
@section('css')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyBqCfECYsTVmKVgqJW2MuG-nNeIM_Gj1cU",
    authDomain: "voucher-img.firebaseapp.com",
    databaseURL: "https://voucher-img.firebaseio.com",
    projectId: "voucher-img",
    storageBucket: "voucher-img.appspot.com",
    messagingSenderId: "264645547952"
  };
  firebase.initializeApp(config);
</script>
@endsection

@section('content')
<section class="content">

    <div class="box box-info">
        <div class="box-header with-border">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <h3 class="box-title">Subir documento</h3>
        </div>
        <div class="seccion">
            <div  class="col-lg-12 padd2">
              <label class="col-xs-12 col-sm-4 col-md-3 padd" for="idoffice">ID de la oficina virtual:<code>*</code></label>
              <div class="col-xs-9 col-sm-5 col-md-7 padd" style="display: flex;">
                <input type="text" class="form-control" id="idoffice" placeholder="Ingresar el ID" name="idoffice">
              </div>
                <div class="col-xs-3 col-sm-3 col-md-2 padd" style="display: flex;">
                  <button type="button" id="btn_search" class="btn btn-success" onclick="getData()">Buscar</button>
                </div>
            </div>
            <div  class="col-xs-12 col-md-6 padd2">
                <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni-front">Nombres:<code>*</code></label>
                <div class="col-xs-12 col-sm-9 col-md-8 padd" id="first_name"></div>
            </div>
            <div  class="col-xs-12 col-md-6 padd2">
                <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni-back">Apellidos:<code>*</code></label>
                <div class="col-xs-12 col-sm-9 col-md-8 padd" id="last_name"></div>
            </div>
            <div  class="col-xs-12 col-md-6 padd2">
                <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni-back">Tipo de documento de identidad:<code>*</code></label>
                <div class="col-xs-12 col-sm-9 col-md-8 padd" id="tipodoc">
                  {!! Form::select('tipdocid', $type_docs, null, ['id'=>'tipdocid','placeholder'=>'SELECCIONAR','class'=>'form-control select2', 'style'=>'width: 100%'] ) !!}
                </div>
            </div>
            <div  class="col-xs-12 col-md-6 padd2">
                <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni-back">Numero de documento de identidad: <code>*</code></label>
                <div class="col-xs-12 col-sm-9 col-md-8 padd" id="document"></div>
            </div>

            <div  class="col-xs-12 col-md-12 padd2">
                <label class="col-xs-12 col-sm-3 col-md-4 padd" for="dni-back">Documento a subir:<code>*</code></label>
                <div class="col-xs-12 col-sm-9 col-md-8 padd"><input type="file" accept="application/pdf" id="file" /></div>
            </div>
        </div>
        <hr>
        <div class="seccion">
          <div  class="col-lg-12 padd2">
            <div class="col-xs-4"><button class="btn btn-success btn-rev" onclick="registar(1)" type="button" >Aprobar</button></div>
            <div class="col-xs-4"><button class="btn btn-success btn-rev" onclick="registar(0)" type="button" >Desaprobar</button></div>
          </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal-viewTicketbyID">
	<div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">Fotos</div>
					<div class="panel-body">
						<div>

              <div class="row">
                  <div class="col-lg-2 col-md-1"></div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="created_at" class="control-label">Placa</label>
                          <div id="placa">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="date_pay" class="control-label">Marca</label>
                          <div id="marca">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-2 col-md-1"></div>
              </div>

              <div class="row">
                  <div class="col-lg-2 col-md-1"></div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="created_at" class="control-label">modelo</label>
                          <div id="model">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                      <div class="form-group">
                          <label for="date_pay" class="control-label">Año</label>
                          <div id="year">


                          </div>
                      </div>
                  </div>
                  <div class="col-lg-2 col-md-1"></div>
              </div>

              <div id="carousel-example-generic" class="carousel slide" >
                  {{-- <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  </ol> --}}
                  <div class="carousel-inner">
                    {{-- <div class="item active">
                      <img src="http://placehold.it/900x500/39CCCC/ffffff&text=I+Love+Bootstrap" alt="First slide">

                      <div class="carousel-caption">
                        First Slide
                      </div>
                    </div>
                    <div class="item">
                      <img src="http://placehold.it/900x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">

                      <div class="carousel-caption">
                        Second Slide
                      </div>
                    </div>
                    <div class="item">
                      <img src="http://placehold.it/900x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">

                      <div class="carousel-caption">
                        Third Slide
                      </div>
                    </div> --}}
                  </div>
                  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="fa fa-angle-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="fa fa-angle-right"></span>
                  </a>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-2 col-md-1"></div>
                <div class="col-lg-8 col-md-10 col-sm-10 col-xs-12">
                    <div class="form-group">
                        <label for="created_at" class="control-label">Descripción</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-file-text"></i></div>
                            {!! Form::textarea('obser', null,['id'=>'obser', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                        </div>
                        <div><span class="help-block" id="error"></span></div>
                    </div>
                </div>
                {{-- <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="date_pay" class="control-label">Fecha de pago</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            {!! Form::text('date_pay', null,['id'=>'date_pay', 'class'=>'form-control', 'style'=>'width: 100%'] ) !!}
                        </div>
                        <div><span class="help-block" id="error"></span></div>
                    </div>
                </div> --}}
                <div class="col-lg-2 col-md-1"></div>
            </div>



					</div>
				</div>
			</div>
			<div class="modal-footer">
        <div><a type="button" class="btn btn-success pull-left" onclick="actulizarStado(2);">Aprobar</a></div>
        <div><a type="button" class="btn btn-success pull-left" onclick="actulizarStado(5);">Reprobar</a></div>
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



<div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
            <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
              <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
            </div>
          </div>


@endsection

@section('js')

  <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
  <script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

  <script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>

  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>



  <script src="{{ asset('js/External/Driver/UploadAntecendetes.js')}} "></script>

@endsection
