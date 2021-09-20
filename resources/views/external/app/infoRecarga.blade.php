
@extends('external.app.layout.layout-head')
@section('title', 'Inicio')
@section('content')
<div class="container-fluid" id="content-app">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12  col-centered">
          <div class="row  text-center" style="padding:10px;">
              <strong class="font-app">Ingresa tu ID de Conductor</strong>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-8 col-xs-10  col-centered text-center">
                  <div class="input-group" style="display: flex;padding:10px;">
                    <input type="number"  id="id_driver" name="id_driver" maxlength="5" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control ph-center" placeholder="ID Conductor"  placeholder="Color">
                  </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-8 col-xs-10  col-centered text-center">
                  <div class="input-group" style="display: flex;padding:10px;">
                    <button type="button" class="btn btn-success btn-block " name="button"> <strong>Consultar ID</strong> </button>
                  </div>
            </div>
          </div>




          <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-8 col-xs-10  col-centered text-center">
                  <div class="input-group" style="display: flex;padding:10px;">




                      <transition name="slide-fade">
                    
                        <p v-if="show">hello</p>

                      </transition>




                  </div>
            </div>
          </div>

    </div>
  </div>

</div>
@endsection
@section('script')


<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}} "></script>
<script src="{{ asset('js/External/app/infoRecarga.js')}} "></script>
@endsection
