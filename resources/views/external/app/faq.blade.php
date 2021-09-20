@extends('external.app.layout.main')
@section('title', 'FAQ')
@section('content')

<div class="col-md-12 p-lg-12 mx-auto my-12">
    <h1 class="display-4 font-weight-normal faq-text">Preguntas Frecuentes</h1>
</div>
<div class="container py-3">
    <div class="row">
        <div class="col-10 mx-auto">
            <h5>Conductores</h5>
            <div class="accordion" id="conductores">
                <div class="card">
                    <div class="card-header p-2" id="conductoresOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Pregunta 1
                            </button>
                          </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="conductoresOne" data-parent="#conductores">
                        <div class="card-body">
                            <b>Respuesta:</b> 1
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2" id="conductoresTwo">
                        <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Pregunta 2
                        </button>
                      </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="conductoresTwo" data-parent="#conductores">
                        <div class="card-body">
                            <b>Respuesta:</b> 2
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2" id="conductoresThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              Pregunta 3
                            </button>
                          </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="conductoresThree" data-parent="#conductores">
                        <div class="card-body">
                            <b>Respuesta:</b> 3
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2" id="conductoresFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                              Pregunta 4
                            </button>
                          </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="conductoresFour" data-parent="#conductores">
                        <div class="card-body">
                            <b>Respuesta:</b> 4
                        </div>
                    </div>
                </div>
            </div>
            <h5>Pasajeros</h5>
            <div class="accordion" id="pasajeros">
                <div class="card">
                    <div class="card-header p-2" id="pasajerosOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseUno" aria-expanded="false" aria-controls="collapseUno">
                              Pregunta 1
                            </button>
                          </h5>
                    </div>
                    <div id="collapseUno" class="collapse" aria-labelledby="pasajerosOne" data-parent="#pasajeros">
                        <div class="card-body">
                            <b>Respuesta:</b> 1
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2" id="pasajerosTwo">
                        <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseDos" aria-expanded="false" aria-controls="collapseDos">
                          Pregunta 2
                        </button>
                      </h5>
                    </div>
                    <div id="collapseDos" class="collapse" aria-labelledby="pasajerosTwo" data-parent="#pasajeros">
                        <div class="card-body">
                            <b>Respuesta:</b> 2
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2" id="pasajerosThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTres" aria-expanded="false" aria-controls="collapseTres">
                              Pregunta 3
                            </button>
                          </h5>
                    </div>
                    <div id="collapseTres" class="collapse" aria-labelledby="pasajerosThree" data-parent="#pasajeros">
                        <div class="card-body">
                            <b>Respuesta:</b> 3
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2" id="pasajerosFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseCuatro" aria-expanded="false" aria-controls="collapseCuatro">
                              Pregunta 4
                            </button>
                          </h5>
                    </div>
                    <div id="collapseCuatro" class="collapse" aria-labelledby="pasajerosFour" data-parent="#pasajeros">
                        <div class="card-body">
                            <b>Respuesta:</b> 4
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
</div>
<!--container-->
@endsection
