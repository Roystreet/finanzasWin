@extends('layouts.app')
@section('title', 'Auditoria')
@section('css')
<link rel="stylesheet" href="{{ asset('css/table-small.css') }}"/>
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Auditoria</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <!-- Filtros para busqueda -->
        <div class="box box-primary">

          <form id=formIndexAuditoria>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="box-body">

              <div class="row">

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="id_pay" class="control-label">Campo</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-th-large"></i></div>
                      {!! Form::text('campo_search', null, ['id'=> 'campo_search', 'class' => 'form-control']) !!}
                    </div>
                    <div><span class="help-block" id="error"></span></div>
                  </div>
                </div>
              </div>

            </div>

            <div class="box-footer">
              <button type="button" class="btn btn-clean btn-default" id="clean">Limpiar</button>
              <button type="button" class="btn btn-search pull-right btn-default btn-registro" id="search">Buscar</button>
            </div>
          </form>
        </div>
        <!-- Filtros para busqueda -->

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
              @include('auditoria.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection
@section('js')
<!-- DataTable -->
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>

<script src="{{ asset('js/Auditoria/index.js')}} "></script>

@endsection
