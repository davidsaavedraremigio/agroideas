@extends('layouts.template')
@section('title', 'Módulo: Solicitudes de Desembolso')
@section('content')
{{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateSolicitudDesembolso" title="Registrar un nuevo proceso"><i class="fa fa-plus-circle" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div id="viewDataSolicitudDesembolso" class="table-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para el mantenimiento de No Objeciones --}}
    <div class="modal fade" id="modalCreateSolicitudDesembolso">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateSolicitudDesembolso">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    <div class="modal fade" id="modalUpdateSolicitudDesembolso">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateSolicitudDesembolso">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para el mantenimiento de Detalle de Solicitudes --}}
    <div class="modal fade" id="modalCreateSolicitudDesembolsoDetalle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateSolicitudDesembolsoDetalle">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    <div class="modal fade" id="modalDataSolicitudDesembolsoDetalle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormDataSolicitudDesembolsoDetalle">
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
            //#1. Obtengo la información de eventos registrados
            $("#viewDataSolicitudDesembolso").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataSolicitudDesembolso").load(route("solicitud.data"));
            //#2.- Modal para el mantenimiento de No Objeciones
            $('#modalCreateSolicitudDesembolso').on('show.bs.modal', function (e) {
                $('#divFormCreateSolicitudDesembolso').load(route("solicitud.create"));
            });
            $('#modalUpdateSolicitudDesembolso').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormSolicitudDesembolso').load(route("solicitud.edit", codigo));
            });
            //#3.- Modal para el mantenimiento de detalle de No Objeciones
            $('#modalCreateSolicitudDesembolsoDetalle').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormCreateSolicitudDesembolsoDetalle').load(route("solicitud-detalle.create", codigo));
            });
            $('#modalDataSolicitudDesembolsoDetalle').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormDataSolicitudDesembolsoDetalle').load(route("solicitud-detalle.show", codigo));
            });
            //#4.- Procesamos el formulario para crear nuevos registros
            $(document).on("click", '#btnCreateSolicitudDesembolso', function (event) {
                event.preventDefault();
                var form = $("#FormCreateSolicitudDesembolso");
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
                        $("#Footer_CreateSolicitudDesembolso_Enabled").css("display", "none");
                        $("#Footer_CreateSolicitudDesembolso_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateSolicitudDesembolso_Enabled").css("display", "block");
                        $("#Footer_CreateSolicitudDesembolso_Disabled").css("display", "none");
                        $("#modalCreateSolicitudDesembolso").modal('hide');
                        $("#viewDataSolicitudDesembolso").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataSolicitudDesembolso").load(route("solicitud.data"));
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
                        $("#SolicitudDesembolsoAlerts").css("display", "block");
                        $("#SolicitudDesembolsoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateSolicitudDesembolso_Enabled").css("display", "block");
                        $("#Footer_CreateSolicitudDesembolso_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateSolicitudDesembolso', function (event) {
                event.preventDefault();
                var form = $("#FormCreateSolicitudDesembolso");
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
                        $("#Footer_UpdateSolicitudDesembolso_Enabled").css("display", "none");
                        $("#Footer_UpdateSolicitudDesembolso_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateSolicitudDesembolso_Enabled").css("display", "block");
                        $("#Footer_UpdateSolicitudDesembolso_Disabled").css("display", "none");
                        $("#modalUpdateSolicitudDesembolso").modal('hide');
                        $("#viewDataSolicitudDesembolso").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataSolicitudDesembolso").load(route("solicitud.data"));
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
                        $("#SolicitudDesembolsoAlerts").css("display", "block");
                        $("#SolicitudDesembolsoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateSolicitudDesembolso_Enabled").css("display", "block");
                        $("#Footer_UpdateSolicitudDesembolso_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '.btnDeleteSolicitudDesembolso', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = route("solicitud.destroy", codigo)
                // Antes de procesar realizamos una confirmación del proceso
                alertify.confirm("Confirmación de envío de formulario", "¿Esta seguro de que desea eliminar este ítem?.",
                    function () {
                        $.ajax({
                            url: urlAction,
                            method: "DELETE",
                            data: codigo,
                            beforeSend: function () {},
                            success: function (response) {
                                var cadena = response;
                                var mensaje = cadena.mensaje;
                                alertify.alert("Proceso concluido", mensaje, function () {
                                    $("#viewDataSolicitudDesembolso").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataSolicitudDesembolso").load(route("solicitud.data"));
                                });
                            },
                            statusCode: {
                                404: function () {
                                    ertify.error('El sistema presenta problemas de funcionamiento.');
                                }
                            },
                            error: function (x, xs, xt) {
                                var errors = x.responseJSON;
                                var errorsHtml = '';
                                $.each(errors['errors'], function (index, value) {
                                    errorsHtml += '<ul>';
                                    errorsHtml += '<li>' + value + "</li>";
                                    errorsHtml += '</ul>';
                                });
                                alertify.alert("Error de validación", errorsHtml, function () {
                                    form[0].reset();
                                });
                            }
                        });
                    },
                    function () {
                        alertify.error('Proceso cancelado');
                        $("#viewDataSolicitudDesembolso").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataSolicitudDesembolso").load(route("solicitud.data"));
                    }
                );
            });
            $(document).on("click", '#btnCreateSolicitudDesembolsoDetalle', function (event) {
                event.preventDefault();
                var form = $("#FormCreateSolicitudDesembolsoDetalle");
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
                        $("#Footer_CreateSolicitudDesembolsoDetalle_Enabled").css("display", "none");
                        $("#Footer_CreateSolicitudDesembolsoDetalle_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateSolicitudDesembolsoDetalle_Enabled").css("display", "block");
                        $("#Footer_CreateSolicitudDesembolsoDetalle_Disabled").css("display", "none");
                        $("#modalCreateSolicitudDesembolsoDetalle").modal('hide');
                        $("#viewDataSolicitudDesembolso").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataSolicitudDesembolso").load(route("solicitud.data"));
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
                        $("#SolicitudDesembolsoDetalleAlerts").css("display", "block");
                        $("#SolicitudDesembolsoDetalleAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateSolicitudDesembolsoDetalle_Enabled").css("display", "block");
                        $("#Footer_CreateSolicitudDesembolsoDetalle_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop