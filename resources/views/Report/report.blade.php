@extends('layouts.app')
@section('title', 'Reportes')

@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
  <!-- include the style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css" />
  <link rel="stylesheet" href="{{ asset('css/loading.css') }}" />

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- Estulos personalizados --}}
  {{-- <link rel="stylesheet" href="{!! asset('css/Report/report.css') !!}"> --}}
@endsection

@section('content')

<section class="content">
  <div class="box">
    <div class="box-header">

    </div>
    <div class="box-body" id="content">
        {{-- dsfsdf --}}


        <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Taxi Win</a></li>
    <li><a data-toggle="tab" href="#menu1">Win is to share</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">


      {{--  --}}
      {{-- Inicio de win is to share  --}}
          <div id="home" class="tab-pane fade in active">

            {{-- inicio de filtros --}}
            <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Filtros :</h3>
                  </div>
                  <div class="box-body">
                    <!-- Date range -->
                    <meta name="csrf-token" content="{{ csrf_token() }}" />

                      <div class="row">
                        <div class="col-xs-3">
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-list-alt"></i>
                            </div>
                            <select id="e2_3" style="width:250px">
                                <option value="sales">Ventas</option>
                                <option value="onHold">En Espera</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-xs-4">
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-inbox"></i>
                            </div>
                            <select id="e2_4" style="width:250px">
                              <option value=" ">Todos</option>
                            </select>
                          </div>
                        </div>

                      </div>




                    <!-- /.form group -->
                    <!-- Date range -->
                    <div class="form-group">
                      <label>Rangos de Fechas:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" name="datetimes" id="rageTimes">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <div class="form-group">
                      <div class="input-group">
                        <button type="button" class="btn btn-primary" id="salesToDay" onclick="filterAdvance()">Procesar</button>
                      </div>
                      <!-- /.input group -->
                    </div>


                    <!-- Date -->
                    <div class="form-group">
                      <label>Acciones Rápidas:</label>
                      <div class="input-group">
                          <button type="button" class="btn btn-primary" id="salesToDay" onclick="salesToday()">Ventas de hoy</button>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- Date -->
                    <div class="form-group">
                      <div class="input-group">
                          <button type="button" class="btn btn-primary" id="salesMonth" onclick="salesMonth()">Ventas de este mes</button>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->

                    <!-- Date -->
                    <div class="form-group">
                      <div class="input-group">
                          <button type="button" class="btn btn-primary" id="salesMonth" onclick="salesAll()">Todas las ventas</button>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->



                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <!-- /.box -->
              </div>
            {{-- fin de filtros --}}


            <table id="taxiWin"  class="display responsive nowrap">
              <thead class="thead-dark">
                  <tr>
                    <th>user</th>
                    <th>Dni</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Pais</th>
                    <th>Stado</th>
                    <th>Cuidad</th>
                    <th>Dirección</th>
                    <th>Producto</th>
                    <th>Sku</th>
                    <th>Precio</th>
                    <th>Money</th>
                    <th>Fecha Pago</th>
                    <th>Estado del Pedido</th>
                    <th>Post</th>
                  </tr>
              </thead>
            <tbody>

            </tbody>
            <tfoot class="thead-dark">
              <tr>
                <th>user</th>
                <th>Dni</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Pais</th>
                <th>Stado</th>
                <th>Cuidad</th>
                <th>Dirección</th>
                <th>Producto</th>
                <th>Sku</th>
                <th>Precio</th>
                <th>Money</th>
                <th>Fecha Pago</th>
                <th>Estado del Pedido</th>
                <th>Post</th>
              </tr>
            </tfoot>
        </table>



            </div>
      {{--  --}}





    </div>


    <div id="menu1" class="tab-pane fade">  {{-- inicio menu1 --}}


      {{-- inicio de filtros --}}
      <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Filtros :</h3>
            </div>
            <div class="box-body">
              <!-- Date range -->
              <meta name="csrf-token" content="{{ csrf_token() }}" />

                <div class="row">
                  <div class="col-xs-3">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-list-alt"></i>
                      </div>
                      <select id="w2_3" style="width:250px">
                          <option value="sales">Ventas</option>
                          <option value="onHold">En espera</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-inbox"></i>
                      </div>
                      <select id="w2_4" style="width:250px">
                        <option value=" ">Todos</option>
                      </select>
                    </div>
                  </div>

                </div>




              <!-- /.form group -->
              <!-- Date range -->
              <div class="form-group">
                <label>Rangos de Fechas:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="datetimes" id="rageTimesW">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="btn btn-primary" id="salesToDayW" onclick="filterAdvanceW()">Procesar</button>
                </div>
                <!-- /.input group -->
              </div>


              <!-- Date -->
              <div class="form-group">
                <label>Acciones Rápidas:</label>
                <div class="input-group">
                    <button type="button" class="btn btn-primary" id="salesToDayW" onclick="salesTodayW()">Ventas de hoy</button>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date -->
              <div class="form-group">
                <div class="input-group">
                    <button type="button" class="btn btn-primary" id="salesMonthW" onclick="salesMonthW()">Ventas de este mes</button>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

              <!-- Date -->
              <div class="form-group">
                <div class="input-group">
                    <button type="button" class="btn btn-primary" id="salesMonth" onclick="salesAllW()">Todas las ventas</button>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->



            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
      {{-- fin de filtros --}}


                  <table id="winistoshare"  class="display responsive nowrap">
                    <thead class="thead-dark">
                        <tr>
                          <th>Dni</th>
                          <th>Apellido</th>
                          <th>Nombre</th>
                          <th>Correo</th>
                          <th>Celular</th>
                          <th>Pais</th>
                          <th>Stado</th>
                          <th>Cuidad</th>
                          <th>Dirección</th>
                          <th>Producto</th>
                          <th>Sku</th>
                          <th>Precio</th>
                          <th>Money</th>
                          <th>Fecha Pago</th>
                          <th>Estado del Pedido</th>
                          <th>Post</th>
                        </tr>
                    </thead>
                  <tbody>

                  </tbody>
                  <tfoot class="thead-dark">
                    <tr>
                      <th>Dni</th>
                      <th>Apellido</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Celular</th>
                      <th>Pais</th>
                      <th>Stado</th>
                      <th>Cuidad</th>
                      <th>Dirección</th>
                      <th>Producto</th>
                      <th>Sku</th>
                      <th>Precio</th>
                      <th>Money</th>
                      <th>Fecha Pago</th>
                      <th>Estado del Pedido</th>
                      <th>Post</th>
                    </tr>
                  </tfoot>
              </table>


    </div>{{--fin menu1  --}}
  </div>
</div> {{-- fin del contendor  --}}
    {{-- Inicio del modal --}}

    <!-- Small modal -->
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".docs-example-modal-sm">Small modal</button> --}}

    <div class="modal fade docs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content ">
          <div class="bg-successe">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Obteniendo datos, por favor espere ...</h5>
                    </div>
                    <div class="modal-body">
                      {{--  --}}
                              @include('load.loading')
                    {{--  --}}
                    </div>
          </div>

        </div>
      </div>
    </div>
    {{--FIn del modal  --}}
{{-- porte visa--}}


{{-- fin porte visa--}}






        {{--  --}}
    </div>
  </div>
</section>


@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>


<script src="{{ asset('js/Report/report.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


{{-- VIsa --}}
<script type="text/javascript" src="https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true"></script>


@endsection
