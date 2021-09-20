

<header class="overflow">
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <div class="logo"></div>
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav navbar-simple">
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a id="dropdown-toggle-simple" href="#" class="dropdown-toggle flex" data-toggle="dropdown">
            <i class="material-icons md-light">menu</i>
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">Menu</span>
          </a>
          <ul class="dropdown-menu">
            <!-- Menu Body -->
            <li class="user-body">
              <div class="">
                <div class="menu-link">
                  <a href="{{ url("/") }}">Inicio</a>
                </div>
                <div class="menu-link">
                  <a href="{{ url("/") }}">Nosotros</a>
                </div>
                <div class="menu-link">
                  <a href="{{ url("/") }}">Contáctanos</a>
                </div>
                <div class="menu-link">
                  @if(auth()->user())
                  <a href="{{ url("/panel") }}">Ir al panel del administrador</a>
                  @else
                  <a href="{{ url("/acceder") }}">Acceder</a>
                  @endif
                </div>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
