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
<div class="modal fade" id="modalUpdatePassword">
  <div class="modal-dialog modal-lg">
      <div class="modal-content animated fadeIn ">
          {{-- Inicio del contenido del modal --}}
          <div id="divFormUpdatePassword">
              <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
              <span class="sr-only">Cargando...</span>
          </div>
          {{-- Fin del contenido del modal --}}
      </div>
  </div>		
</div> 

@section('scripts')
<script>
    $(document).ready(function () {
        $('#modalUpdatePassword').on('show.bs.modal', function (e) {
            var codUsuario= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdatePassword').load(route("usuario.reset", codUsuario));
        });

        $(document).on("click", '#btnUpdatePassword', function (event) {
            event.preventDefault();
            var form = $("#FormUpdatePassword");
            var urlAction = form.attr('action');
            var formData = new FormData(form[0]);
            var dataAll = form.serialize();
            $.ajax({
                url: urlAction,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#Footer_UpdatePassword_Enabled").css("display", "none");
                    $("#Footer_UpdatePassword_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdatePassword_Enabled").css("display", "block");
                    $("#Footer_UpdatePassword_Disabled").css("display", "none");
                    $("#modalUpdatePassword").modal('hide');
                    alertify.success(mensaje);
                },
                error: function (response) {
                    var errors = response.responseJSON;
                    var errorTitle = errors.message;
                    console.error(errorTitle);
                    var errorsHtml = '';
                    $.each(errors['errors'], function (index, value) {
                        errorsHtml += '<ul>';
                        errorsHtml += '<li>' + value + "</li>";
                        errorsHtml += '</ul>';
                    });
                    $("#PasswordAlerts").css("display", "block");
                    $("#PasswordAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdatePassword_Enabled").css("display", "block");
                    $("#Footer_UpdatePassword_Disabled").css("display", "none");
                }
            });
        });        
    });
</script>
@stop