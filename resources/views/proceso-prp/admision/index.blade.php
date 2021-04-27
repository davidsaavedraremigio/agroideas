@extends('layouts.template')
@section('title', 'Módulo para la admisión de pedidos de reconversión productiva')
@section('content')
{{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateAdmisionExpediente"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataAdmisionExpediente" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
{{-- Término del contenido--}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //1. Obtengo los datos generados
        $("#viewDataAdmisionExpediente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataAdmisionExpediente").load("admision/data");
        //2. Modal para crear y editar registros
        $('#modalCreateAdmisionExpediente').on('show.bs.modal', function (e) {
            $('#divFormCreateAdmisionExpediente').load("admision/create");
        });
        $('#modalUpdateAdmisionExpediente').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateAdmisionExpediente').load('admision/' + idExpediente + '/edit');
        });
        //3. Proceso la información de los formularios
        $(document).on("click", '#btnCreateAdmisionExpediente', function (event) {
            event.preventDefault();
            var form = $("#FormCreateAdmisionExpediente");
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
                    $("#Footer_CreateAdmisionExpediente_Enabled").css("display", "none");
                    $("#Footer_CreateAdmisionExpediente_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateAdmisionExpediente_Enabled").css("display", "block");
                    $("#Footer_CreateAdmisionExpediente_Disabled").css("display", "none");
                    $("#modalCreateAdmisionExpediente").modal('hide');
                    $("#viewDataAdmisionExpediente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataAdmisionExpediente").load("admision/data");
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
                    $("#AdmisionExpedienteAlerts").css("display", "block");
                    $("#AdmisionExpedienteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateAdmisionExpediente_Enabled").css("display", "block");
                    $("#Footer_CreateAdmisionExpediente_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateAdmisionExpediente', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateAdmisionExpediente");
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
                    $("#Footer_UpdateAdmisionExpediente_Enabled").css("display", "none");
                    $("#Footer_UpdateAdmisionExpediente_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateAdmisionExpediente_Enabled").css("display", "block");
                    $("#Footer_UpdateAdmisionExpediente_Disabled").css("display", "none");
                    $("#modalUpdateAdmisionExpediente").modal('hide');
                    $("#viewDataAdmisionExpediente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataAdmisionExpediente").load("admision/data");
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
                    $("#AdmisionExpedienteAlerts").css("display", "block");
                    $("#AdmisionExpedienteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateAdmisionExpediente_Enabled").css("display", "block");
                    $("#Footer_UpdateAdmisionExpediente_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop