<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
    <li class="nav-item d-none d-sm-inline-block"><a href="{{ url('/home') }}" class="nav-link">Inicio</a></li>
  </ul>
  <!-- Menu superior derecho -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown"><a class="nav-link" data-toggle="dropdown" href="#"><i class="fab fa-centos"></i><span> Opciones</span></a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">Opciones de cuenta</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item" title="Actualizar contraseña" id="btnmodalUpdatePassword" data-toggle="modal" data-target="#modalUpdatePassword" data-id="{{ Auth::user()->id }}"> <i class="fas fa-key"></i> Cambiar contraseña</a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>