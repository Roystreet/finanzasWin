@extends('layouts.app')
@section('title', 'Listado de Recargas')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />


@endsection

@section('content')

<section class="content-header"></section>

<section class="content">

<div class="modal fade" id="modal-img">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Imagen</h4>
      </div>
      <div class="modal-body">
        <div id="verimgTicket"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar Recarga N° <label id="code"></label></h4>
      </div>
      <div class="modal-body">
        <form id="myformedit">
        {{ csrf_field() }}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <label class="col-sm-2 control-label">Fecha</label>
        <div class="form-group">
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              {!! Form::text('date_ed', null,['id'=>'date_ed', 'class'=>'form-control', 'style'=>'width: 100%', 'required' => 'required'] ) !!}
            </div>
            <div><span class="help-block" id="error"></span></div>
          </div>
        </div>

        <label class="col-sm-2 control-label">Hora:</label>
        <div class="form-group">
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
              {!! Form::text('hour_pay_ed', null ,['id'=>'hour_pay_ed', 'class'=>'form-control timepicker', 'required' => 'required']) !!}
              {!! Form::hidden('id', null ,['id'=>'id', 'class'=>'form-control timepicker', 'required' => 'required']) !!}

            </div>
            <div><span class="help-block" id="error"></span></div>
          </div>
        </div>

        <label class="col-sm-2 control-label">Tipo</label>
        <div class="form-group">
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-gg"></i></div>
              {!! Form::select('id_pay_ed', $pay, null,['id'=>'id_pay_ed', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 100%', 'required' => 'required'] ) !!}
            </div>
            <div><span class="help-block" id="error"></span></div>
          </div>
        </div>

        <div id="banks" style="display:none;">
          <label class="col-sm-2 control-label">Banco</label></th>
          <div class="form-group">
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-bank"></i></div>
                {!! Form::select('id_bank_ed', $bank, null,['id'=>'id_bank_ed', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 100%'] ) !!}
              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
          <label class="col-sm-2 control-label">Cuenta:</label>
          <div class="form-group">
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-bars"></i></div>
                {!! Form::select('id_account_ed', $account_type, null,['id'=>'id_account_ed', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 100%'] ) !!}
                </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>

        <div id="num" style="display:none;">
          <label class="col-sm-2 control-label">N/Operacion</label>
          <div class="form-group">
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-500px"></i></div>
                {!! Form::text('number_operation_ed', null,['id'=>'number_operation_ed', 'class'=>'form-control', 'style'=>'width: 100%', 'onchange'=>"return $.fn.validaNumber();"] ) !!}
              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>

        <label class="col-sm-2 control-label">Monto</label>
        <div class="form-group">
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
              {!! Form::text('saldo_ed', null,['id'=>'saldo_ed', 'class'=>'form-control', 'style'=>'width: 100%', 'onchange'=>"return $.fn.validaNumber();"] ) !!}
            </div>
            <div><span class="help-block" id="error"></span></div>
          </div>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-default pull-rigth" id="editar">Guardar</button>
      </form>
      </div>
    </div>
  </div>
</div>

<div class="box box-primary">

  <div class="box-header with-border">
    <h3 class="box-title">Itéms de Busqueda</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>

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
                {!! Form::select('id_pay', $pay,     null,['id'=>'id_pay', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                {!! Form::hidden('id_bank',          null,['id'=>'modified_by', 'class'=>'form-control', 'style'=>'width: 80%', 'required' => 'required'] ) !!}
                {!! Form::hidden('id_account_type',  null,['id'=>'id_country',  'class'=>'form-control', 'style'=>'width: 80%', 'required' => 'required'] ) !!}
                {!! Form::hidden('view', 'index',['id'=>'view', 'class'=>'form-control', 'style'=>'width: 80%', 'required' => 'required'] ) !!}

              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Conductor</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-car"></i></div>
                {!! Form::select('id_driver', $driver, null,['id'=>'id_driver', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
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
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Pais</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                {!! Form::select('id_country', $country, null,['id'=>'id_country', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
              </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Fecha/Recarga</label>
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
            <label for="inputEmail3" class="col-sm-2 control-label">Estatus</label>
            <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-check-circle"></i></div>
                {!! Form::select('status_user', $status, null,['id'=>'status_user', 'class'=>'form-control select2',  'placeholder' => 'Selecciona', 'style'=>'width: 80%'] ) !!}
                </div>
              <div><span class="help-block" id="error"></span></div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-footer">
    <div class="form-group">
      <div class="input-group">
        <button type="button" class="btn btn-primary btn-center" id="search" >Buscar</button>
      </div>
    </div>
  </div>

</div>

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>



  <script src="{{ asset('js/CapitalDriver/index.js')}} "></script>

@endsection
