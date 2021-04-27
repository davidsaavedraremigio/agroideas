@extends('layouts.template')
@section('title', 'Módulo para la gestión de Indicadores de resultado')
@section('content')
{{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateIndicadorResultado"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataIndicadorResultado" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateIndicadorResultado">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateIndicadorResultado">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateIndicadorResultado">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateIndicadorResultado">
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
            $("#viewDataIndicadorResultado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataIndicadorResultado").load("indicador-resultado/data");
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateIndicadorResultado').on('show.bs.modal', function (e) {
                $('#divFormCreateIndicadorResultado').load("indicador-resultado/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateIndicadorResultado').on('show.bs.modal', function (e) {
                var codIndicador = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateIndicadorResultado').load('indicador-resultado/' + codIndicador + '/edit');
            });
            //#3.- Procesamos el formulario para crear nuevos registros
            $(document).on("click", '#btnCreateIndicadorResultado', function (event) {
                event.preventDefault();
                var form = $("#FormCreateIndicadorResultado");
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
                        $("#Footer_CreateIndicadorResultado_Enabled").css("display", "none");
                        $("#Footer_CreateIndicadorResultado_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateIndicadorResultado_Enabled").css("display", "block");
                        $("#Footer_CreateIndicadorResultado_Disabled").css("display", "none");
                        $("#modalCreateIndicadorResultado").modal('hide');
                        $("#viewDataIndicadorResultado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataIndicadorResultado').load('indicador-resultado/data');
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
                        $("#IndicadorResultadoAlerts").css("display", "block");
                        $("#IndicadorResultadoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateIndicadorResultado_Enabled").css("display", "block");
                        $("#Footer_CreateIndicadorResultado_Disabled").css("display", "none");
                    }
                });
            });
            //4.- Procesamos el formulario para actualizar registros
            $(document).on("click", '#btnUpdateIndicadorResultado', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateIndicadorResultado");
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
                        $("#Footer_UpdateIndicadorResultado_Enabled").css("display", "none");
                        $("#Footer_UpdateIndicadorResultado_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateIndicadorResultado_Enabled").css("display", "block");
                        $("#Footer_UpdateIndicadorResultado_Disabled").css("display", "none");
                        $("#modalUpdateIndicadorResultado").modal('hide');
                        $("#viewDataIndicadorResultado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataIndicadorResultado').load('indicador-resultado/data');
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
                        $("#IndicadorResultadoAlerts").css("display", "block");
                        $("#IndicadorResultadoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateIndicadorResultado_Enabled").css("display", "block");
                        $("#Footer_UpdateIndicadorResultado_Disabled").css("display", "none");
                    }
                });
            });
            //5.- Modificamos el estado situacional del registro
            $(document).on("click", '.btnDeleteIndicadorResultado', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'indicador-resultado/'+codigo;
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
                                    $("#viewDataIndicadorResultado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $('#viewDataIndicadorResultado').load('indicador-resultado/data');
                                });
                            },
                            statusCode: {
                                404: function () {
                                    alertify.error('El sistema presenta problemas de funcionamiento.');
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
                        $("#viewDataIndicadorResultado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataIndicadorResultado').load('indicador-resultado/data');
                    }
                );
            });
        });
    </script>
@stop
