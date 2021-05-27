@extends('layouts.template')
@section('title', 'Bienvenidos')
@section('content')
{{-- Inicio del contenido 
<div class="container-fluid">
    <div class="row">
        <!-- Primer Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CPU Traffic</span>
                    <span class="info-box-number">10<small>%</small></span>
                </div>
            </div>
        </div>
        <!-- Segundo Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Likes</span>
                    <span class="info-box-number">41,410</span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <!-- Tercer Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sales</span>
                    <span class="info-box-number">760</span>
                </div>
            </div>
        </div>
        <!-- Cuarto Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">New Members</span>
                    <span class="info-box-number">2,000</span>
                </div>
            </div>
        </div>
    </div>
</div>
--}}

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
{{-- Término del contenido--}}
@stop
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