@extends('layouts.app')
@section('title', 'Listado de Ticket')
@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/DataTable/DataTables-1.10.18/css/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Responsive-2.2.2/css/responsive.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/DataTable/Buttons-1.5.2/css/buttons.dataTables.min.css')}}">

  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">


@endsection

@section('content')
<section class="content">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Listado de Tickets</h3>
      <?php
      echo $permisocrear == true || $rolid == 4 ? '<div class="tickets"><a href="'.route('customer.create').'" class="btn btn-info pull-right">Registrar Accionista</a></div>' : '';
      ?>
    </div>
    <div class="box-body">
      <div class="hero-callout">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <table id="tickets" name="tickets"  class="table table-bordered table-striped" details="{{ $permisodetails }}" download="{{ $permisodownload }}" see="{{ $permisover }}" seespec="{{ $permisoverespe }}" rolid="{{ $rolid }}">
        <thead>
          <tr>
           <th width="5%">Detalles</th>
           <th width="5%">Descargar</th>
           <th width="5%">Ver</th>
           <th width="5%">Codigo</th>
           <th width="5%">Nombre</th>
           <th width="5%">Apellido</th>
           <th width="5%">DNI</th>
           <th width="5%">Invitado Por</th>
           <th width="5%">Producto</th>
           <th width="5%">Pais a Invertir</th>
           <th width="5%">Fecha de Creaccion</th>
           <th width="5%">Moneda</th>
           <th width="5%">Total</th>
           <th width="5%">Estatus</th>
           <th width="5%">Responsable</th>
           <th width="5%">Creador</th>
         </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
         <tr>
           <th width="5%">Detalles</th>
           <th width="5%">Descargar</th>
           <th width="5%">Ver</th>
           <th width="5%">Codigo</th>
           <th width="5%">Nombre</th>
           <th width="5%">Apellido</th>
           <th width="5%">DNI</th>
           <th width="5%">Invitado Por</th>
           <th width="5%">Producto</th>
           <th width="5%">Pais a Invertir</th>
           <th width="5%">Fecha de Creaccion</th>
           <th width="5%">Moneda</th>
           <th width="5%">Total</th>
           <th width="5%">Estatus</th>
           <th width="5%">Responsable</th>
           <th width="5%">Creador</th>
         </tr>
        </tfoot>
      </table>


      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal-viewTicketbyID">
	<div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">Vista del voucher</div>
					<div class="panel-body">
						<div id="verimgTicket"><center>
                <img src="{{ URL::asset('imagenes/logotipo.png')}}" style="display: block; max-width: 30%; height: auto;" alt="Logotipo">
                 <p id="codregticket"></p>
                 <p id="prodregticket"></p>
                 <p id="fecharegticket"></p>
                 <table>
                   <thead>
                     <tr>
                       <th class="cantidad" colspan="2" align="center" style="background-color:#ededed" >DATOS DEL ACCIONISTA</th>
                     </tr>
                   </thead>
                   <tbody>
                     <tr>
                       <td class="cantidad">DNI</td>
                       <td class="producto" id="dnicompradticket"></td>

                     </tr>
                     <tr>
                       <td class="cantidad">Comprador</td>
                       <td class="producto" id="compradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Pais</td>
                       <td class="producto" id="paiscompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Estado</td>
                       <td class="producto" id="estcompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Ciudad</td>
                       <td class="producto" id="ciucompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Dirección</td>
                       <td class="producto" id="direccompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Teléfono</td>
                       <td class="producto" id="telfcompradticket"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Correo</td>
                       <td class="producto" id="corrcompradticket"></td>
                     </tr>
                     <tr>
                       <th class="cantidad" colspan="2" align="center" style="background-color:#ededed">DATOS DE LA COMPRA</th>
                     <tr>
                       <td class="cantidad">Monto</td>
                       <td class="producto" id="montcompra"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Tipo de pago</td>
                       <td class="producto" id="tippaycompra"></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Nro Ope.</td>
                       <td class="producto"id="nroopecompra" ></td>
                     </tr>
                     <tr>
                       <td class="cantidad">Fecha Pago</td>
                       <td class="producto" id="fechpagcompra"></td>
                     </tr>
                     <tr>
                       <th Classes="cantidad" colspan="2" align="center" style="background-color:#ededed">DATOS DEL ANFITRION</th>
                     </tr>
                     <tr>
                       <td class="cantidad">Nombre</td>
                       <td class="producto" id="nameinvtcomp"></td>
                     </tr>
                     <tr>
                       <th class="producto" colspan="2" align="center" style="background-color:#ededed">PAIS A INVERTIR</th>
                     </tr>
                     <tr>
                       <td class="producto" colspan="2" align="center" id="paisainvert"></td>
                     </tr>
                     <tr>
                       <th class="producto" colspan="2" align="center" style="background-color:#ededed">OBSERVACIONES</th>
                     </tr>
                     <tr>
                       <td class="producto" colspan="2" align="center" id="observaticket"></td>
                     </tr>
                   </tbody>
                 </table>
                 <br>
                <p style="font-size: 10px !important;" class="centrado">*Este es un comprobante de pago que será válido hasta que se emita el certificado de tenencia de acción
                </p>
              </center>
            </div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
        <div id="downloadvoucher"><a type="button" class="btn btn-success pull-left" id="download-voucher">Descargar</a></div>
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

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
<script src="{{ asset('js/Ticket/index.js')}} "></script>
@endsection
