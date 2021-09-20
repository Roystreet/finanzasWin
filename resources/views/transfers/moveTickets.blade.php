@extends('layouts.app')
@section('title', 'Listado de Ticket')
@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">

  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

@endsection

@section('content')
<section class="content">
  <div class="row">
    <form method="POST" id="moveTickets" action="{{ url("transf/movingTicket") }}">
        {{ csrf_field() }}
        <meta name="csrf-token" content="{{ csrf_token() }}">
         <div class="col-md-6">

           <div class="box box-danger">
             <div class="box-header">
               <h3 class="box-title">USUARIO A</h3>
             </div>
             <div class="box-body">
               <!-- Date dd/mm/yyyy -->
               <div class="form-group">
                 <div class="input-group dniselect">
                   <div class="input-group-addon">
                     <i class="fa  fa-500px"></i>
                   </div>
                   {!! Form::select('id_customerA',$customer, null,['id'=>'id_customerA', 'name'=>'id_customerA', 'placeholder' => 'Selecciona', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                 </div>
               </div>
             </div>
             <!-- /.box-body -->
           </div>
           <!-- /.box -->

         </div>
         <!-- /.col (left) -->
         <div class="col-md-6">
           <div class="box box-info">
             <div class="box-header">
               <h3 class="box-title">USUARIO B</h3>
             </div>
             <div class="box-body">
               <!-- Date dd/mm/yyyy -->
               <div class="form-group">
                 <div class="input-group dniselect">
                   <div class="input-group-addon">
                     <i class="fa  fa-500px"></i>
                   </div>
                   {!! Form::select('id_customerB',$customer, null,['id'=>'id_customerB', 'name'=>'id_customerB', 'placeholder' => 'Selecciona', 'class'=>'form-control select2', 'style'=>'width: 100%']) !!}
                 </div>
               </div>
             </div>
             <!-- /.box-body -->
           </div>
           <!-- /.box -->
         </div>
         <!-- /.col (right) -->
       </div>
       <!-- /.row -->



       <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">TICKETS A ---> B </h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <div class="input-group dniselect">
                    <div class="input-group-addon">
                      <i class="fa  fa-barcode"></i>
                    </div>
                    {!! Form::select('id_ticket', ['placeholder' => ''], null,['id'=>'id_ticket',            'class'=>'form-control select2', 'style'=>'width: 100%']) !!}

                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                Nota: Estas realizando el traspaso del ticket al Usuario B </div>
            </div>
            <div class="input-group">
              <button type="submit" class="btn btn-primary pull-right">Mover Ticket</button><br><br><br>
            </div>
          </form>
            <!-- /.box -->



</section>

@endsection






@section('js')

  <script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>


<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/AJAX/pdfmake.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="{{ asset('js/Transfers/moveTickets.js')}} "></script>
@endsection
