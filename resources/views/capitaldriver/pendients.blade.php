@extends('layouts.app')
@section('title', 'Listado de Recargas')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">

  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />



@endsection

@section('content')
<section class="content">
  <!-- SELECT2 EXAMPLE -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Itéms de Busqueda</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <form  id="myform">
              {{ csrf_field() }}
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Tipo/Pago</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-gg"></i></div>
                        {!! Form::select('id_pay', $pay, null,['id'=>'id_pay', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%', 'required'] ) !!}
                        {!! Form::hidden('status_user', 1,['id'=>'status_user', 'class'=>'form-control', 'style'=>'width: 80%', 'required' => 'required'] ) !!}
                        {!! Form::hidden('view', 'pendients',['id'=>'view', 'class'=>'form-control', 'style'=>'width: 80%', 'required' => 'required'] ) !!}

                      </div>
                      <div><span class="help-block" id="error"></span></div>
                    </div>
                  </div>
                </div>
                <div style="display:none;" class="col-xs-6 banks">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Banco</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-bank"></i></div>
                        {!! Form::select('id_bank', $bank, null,['id'=>'id_bank', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                  	<label for="inputEmail3" class="col-sm-2 control-label">Conductor</label>
                  	<div class="col-sm-10">
                  		<div class="input-group">
                  			<div class="input-group-addon"><i class="fa fa-car"></i></div>
                  			{!! Form::select('id_driver', $driver, null,['id'=>'id_driver', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                        {!! Form::hidden('id_country',  null,['id'=>'id_country',  'class'=>'form-control', 'style'=>'width: 80%', 'required' => 'required'] ) !!}


                  		</div>
                  		<div><span class="help-block" id="error"></span></div>
                  	</div>
                  </div>
                </div>
                <div style="display:none;" class="col-xs-6 banks">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Tipo/Cta</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-bars"></i></div>
                        {!! Form::select('id_account_type', $account_type, null,['id'=>'id_account_type', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Fecha/Creación</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        {!! Form::text('range_date', null,['id'=>'range_date', 'class'=>'form-control', 'style'=>'width: 80%'] ) !!}
                        </div>
                      <div><span class="help-block" id="error"></span></div>
                    </div>
                  </div>
                </div>



                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Responsable</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                        {!! Form::select('modified_by', $modified_by, null,['id'=>'modified_by', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                      </div>
                      <div><span class="help-block" id="error"></span></div>
                    </div>
                  </div>
                </div>
                  </div>


          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <div class="form-group">
              <div class="input-group">
                <button  type="submit"  class="btn btn-primary btn-center"  >Buscar</button>

              </div>
            </div>
          </div>
        </form>
        </div>
        <!-- /.box -->



 <div class="box box-info">
   <div class="box-header with-border">
     <h3 class="box-title">Listado de Recargas</h3>
   </div>

   <div class="box-body">
     <div class="hero-callout">

        <table id="recargas"  class="display compact nowrap" >
          <thead class="thead-dark">
            <tr>
              <th>Accion</th>
              <th>Voucher</th>
              <th>Codigo</th>
              <th>Licencia</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>DNI</th>
              <th>TpPago</th>
              <th>Banco</th>
              <th>Tp/Cta</th>
              <th>N°Op.</th>
              <th>Fecha de Pago</th>
              <th>Fecha de Recarga</th>
              <th>Saldo Previo</th>
              <th>Monto</th>
              <th>Estatus</th>
              <th>Responsable</th>
              <th>Observacion</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot class="thead-dark">
            <tr>
              <th>Accion</th>
              <th>Voucher</th>
              <th>Codigo</th>
              <th>Licencia</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>DNI</th>
              <th>TpPago</th>
              <th>Banco</th>
              <th>Tp/Cta</th>
              <th>N°Op.</th>
              <th>Fecha de Pago</th>
              <th>Fecha de Recarga</th>
              <th>Saldo Previo</th>
              <th>Monto</th>
              <th>Estatus</th>
              <th>Responsable</th>
              <th>Observacion</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>






</section>


<div class="modal fade" id="modal-img">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> Imagen</div>
      <div class="modal-body">
        <div class="modal-body">
          <div class="panel panel-info">
            <div class="panel-heading">Vista del voucher</div>
            <div class="panel-body">
              <div id="verimgTicket"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-rigth" data-dismiss="modal">Cerrar</button>
      </div>
    </form>
    </div>
  </div>
</div>


@endsection






@section('js')

<script src="{{ asset('plugins/jqueryvalidate/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jqueryvalidate/jquery.validate.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>


<!-- date-range-picker -->
<script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>



<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>


<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>
<script src="{{ asset('js/CapitalDriver/pendients.js')}} "></script>
@endsection
