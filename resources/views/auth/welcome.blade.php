@include('partials.top-index')
@include('partials.nav-index')
@section('title', 'Inicio de sesión | WIN')
        <div class="container" id="LoginForm">
          <!-- Outer Row -->
          <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

              <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                      <div class="p-5">
                          <div class="text-center"> <!-- Título de login -->
                              <h1 class="h3 text-gray-900 mb-4">Bienvenidos</h1>
                              <h2 class="h4 text-gray-900 mb-4">Sistema administrativo de Perú</h2>
                          </div>
                          <form class="user" id="Login" action="{{ url('login') }}" method="POST">
                              {{ csrf_field() }}
                              @if(Session::has('error_message'))
                              <div class="alert alert-info">
                                {{ Session::get('error_message') }}
                              </div>
                              @endif
                              <div class="form-group {{ $errors->has('username')? 'has-error' :'' }}">
                                  <label class="text-gray-600 small" for="username">Nombre de usuario</label>
                                  <input id="username" name="username" class="form-control form-control-solid py-4" type="text" aria-label="Nombre de Usuario" value="{{ old('username') }}" />
                                  {!! $errors->first ('username', '<div class="error"><span class="help-block">:message</span></div>') !!}
                              </div>
                              <div class="form-group">
                                  <label class="text-gray-600 small" for="password">Contraseña</label>
                                  <input id="password" name="password" class="form-control form-control-solid py-4" type="password" aria-label="Contraseña"/>
                                  {!! $errors->first ('password', '<div class="error"><span class="help-block">:message</span></div>') !!}
                              </div>
                              @if (session()->has('flash') )
                                <div class="alert alert-info">{{ session('flash')}}</div>
                              @endif
                              <div class="form-group {{ $errors->has('datos')? 'has-error' :'' }}">
                                {!! $errors->first ('datos', '<div class="error"><span class="help-block">:message</span></div>') !!}
                              </div>
                              <div class="form-group d-flex align-items-center justify-content-between mb-0">
                                  <div class="custom-control custom-control-solid custom-checkbox">
                                      <input class="custom-control-input small" id="rememberPassword" type="checkbox"/>
                                      <label class="custom-control-label" for="rememberPassword">Recordar contraseña</label>
                                  </div>
                                  <button type="submit" class="btn btn-primary">Ingresar</button>
                              </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@include('partials.footer-index')
