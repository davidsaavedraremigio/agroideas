@extends('layouts.template')
@section('title', 'Módulo: Solicitudes de No Objeción')
@section('content')
{{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateNoObjecion" title="Registrar un nuevo proceso"><i class="fa fa-plus-circle" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div id="viewDataNoObjecion" class="table-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para el mantenimiento de No Objeciones --}}
    <div class="modal fade" id="modalCreateNoObjecion">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateNoObjecion">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    <div class="modal fade" id="modalUpdateNoObjecion">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateNoObjecion">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para el mantenimiento de Detalle de No Objeciones --}}
    <div class="modal fade" id="modalCreateNoObjecionDetalle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateNoObjecionDetalle">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    <div class="modal fade" id="modalUpdateNoObjecionDetalle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateNoObjecionDetalle">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    <div class="modal fade" id="modalDataNoObjecionDetalle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormDataNoObjecionDetalle">
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
            $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataNoObjecion").load(route("nobjecion.data"));
            //#2.- Modal para el mantenimiento de No Objeciones
            $('#modalCreateNoObjecion').on('show.bs.modal', function (e) {
                $('#divFormCreateNoObjecion').load(route("nobjecion.create"));
            });
            $('#modalUpdateNoObjecion').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateNoObjecion').load(route("nobjecion.edit", codigo));
            });
            //#3.- Modal para el mantenimiento de detalle de No Objeciones
            $('#modalCreateNoObjecionDetalle').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormCreateNoObjecionDetalle').load(route("nobjecion-detalle.create", codigo));
            });
            $('#modalUpdateNoObjecionDetalle').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateNoObjecionDetalle').load(route("nobjecion-detalle.edit", codigo));
            });
            $('#modalDataNoObjecionDetalle').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormDataNoObjecionDetalle').load(route("nobjecion-detalle.show", codigo));
            });
            //#4.- Procesamos el formulario para crear nuevos registros
            $(document).on("click", '#btnCreateNoObjecion', function (event) {
                event.preventDefault();
                var form = $("#FormCreateNoObjecion");
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
                        $("#Footer_CreateNoObjecion_Enabled").css("display", "none");
                        $("#Footer_CreateNoObjecion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateNoObjecion_Enabled").css("display", "block");
                        $("#Footer_CreateNoObjecion_Disabled").css("display", "none");
                        $("#modalCreateNoObjecion").modal('hide');
                        $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataNoObjecion").load(route("nobjecion.data"));
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
                        $("#NoObjecionAlerts").css("display", "block");
                        $("#NoObjecionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateNoObjecion_Enabled").css("display", "block");
                        $("#Footer_CreateNoObjecion_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateNoObjecion', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateNoObjecion");
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
                        $("#Footer_UpdateNoObjecion_Enabled").css("display", "none");
                        $("#Footer_UpdateNoObjecion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateNoObjecion_Enabled").css("display", "block");
                        $("#Footer_UpdateNoObjecion_Disabled").css("display", "none");
                        $("#modalUpdateNoObjecion").modal('hide');
                        $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataNoObjecion").load(route("nobjecion.data"));
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
                        $("#NoObjecionAlerts").css("display", "block");
                        $("#NoObjecionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateNoObjecion_Enabled").css("display", "block");
                        $("#Footer_UpdateNoObjecion_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '.btnDeleteNoObjecion', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = route("nobjecion.destroy", codigo)
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
                                    $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataNoObjecion").load(route("nobjecion.data"));
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
                        $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataNoObjecion").load(route("nobjecion.data"));
                    }
                );
            });
            $(document).on("click", '#btnCreateNoObjecionDetalle', function (event) {
                event.preventDefault();
                var form = $("#FormCreateNoObjecionDetalle");
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
                        $("#Footer_CreateNoObjecionDetalle_Enabled").css("display", "none");
                        $("#Footer_CreateNoObjecionDetalle_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateNoObjecionDetalle_Enabled").css("display", "block");
                        $("#Footer_CreateNoObjecionDetalle_Disabled").css("display", "none");
                        $("#modalCreateNoObjecionDetalle").modal('hide');
                        $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataNoObjecion").load(route("nobjecion.data"));
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
                        $("#NoObjecionDetalleAlerts").css("display", "block");
                        $("#NoObjecionDetalleAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateNoObjecionDetalle_Enabled").css("display", "block");
                        $("#Footer_CreateNoObjecionDetalle_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '.btnDeleteNoObjecionDetalle', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = route("nobjecion-detalle.destroy", codigo)
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
                                    $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataNoObjecion").load(route("nobjecion.data"));
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
                        $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataNoObjecion").load(route("nobjecion.data"));
                    }
                );
            });
        });
    </script>
@stop