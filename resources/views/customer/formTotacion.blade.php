@extends('layout-backend')
@section('content')
      <section class="content">
        <div class="box" style="padding: 35px;">
          <div class="box-header">
          <h3 class="box-title">Votación </h3>
          </div>
          <div class="container">
            <form>
              <meta name="csrf-token" content="{{ csrf_token() }}">
              <div class="input-group input-group-sm mb-6">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">DNI</span>
                </div>
                <input type="text" class="form-control" id="document" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                <button type="button" class="btn btn-primary" id="condni">Consultar</button>
              </div>
              <div class="input-group ">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-sm">Datos</span>
                </div>
                <h4 id="datos"></h4>
              </div>

              <h2>Pregunta 1</h2>
              <p>Aprueba usted el Estado Financiero presentado por el Gerente General</p>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="P1radio1" name="optradio" value="1" >Sí
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P1radio2" name="optradio" value="2">No
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P1radio3" name="optradio" value="3" checked>Voto en blanco
                </label>
              </div>

              <h2>Pregunta 2</h2>
              <p>Aprueba usted el Aumento de capital indicado por el Gerente General </p>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="P2radio1" name="optradio1" value="1" >Sí
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P2radio2" name="optradio1" value="2">No
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P2radio3" name="optradio1" value="3" checked>Voto en blanco
                </label>
              </div>

              <h2>Pregunta 3</h2>
              <p>Aprueba usted el Factor de Multiplicación indicado por el Gerente General</p>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="P3radio1" name="optradio2" value="1" >Sí
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P3radio2" name="optradio2" value="2">No
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P3radio3" name="optradio2" value="3" checked>Voto en blanco
                </label>
              </div>

              <h2>Pregunta 4</h2>
              <p>IV.	Autoriza usted la aprobación de Dos pagos al año de Dividendos y Franquicias</p>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio1">
                  <input type="radio" class="form-check-input" id="P4radio1" name="optradio3" value="1" >Sí
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P4radio2" name="optradio3" value="2">No
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                  <input type="radio" class="form-check-input" id="P4radio3" name="optradio3" value="3" checked>Voto en blanco
                </label>
              </div>

              <button type="button" class="btn btn-primary" id="boton">Enviar</button>
            </form>
          </div>
        </div>
      </section>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
<script src="{{ asset('plugins/DataTable/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Responsive-2.2.2/js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('plugins/DataTable/Buttons-1.5.2/js/dataTables.buttons.min.js') }}"></script>
<script src="https://adminlte.io/themes/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('plugins/jquery/jQuery.print.js') }}"></script>
<script src="{{ asset('js/validate/validateForm.js')}}"></script>
<script src="{{ asset('js/Customer/formtotacion.js')}}"></script>
@endsection
