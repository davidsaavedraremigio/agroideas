@extends('layouts.template')
@section('title', 'Procesos de Iniciativas')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateProcesoIniciativa"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataProcesoIniciativa" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateProcesoIniciativa">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateProcesoIniciativa">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateProcesoIniciativa">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateProcesoIniciativa">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            var urlApp          = "{{ env('APP_URL') }}";
            $("#viewDataProcesoIniciativa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataProcesoIniciativa").load('proceso-iniciativa/data');
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateProcesoIniciativa').on('show.bs.modal', function (e) {
                $('#divFormCreateProcesoIniciativa').load("proceso-iniciativa/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateProcesoIniciativa').on('show.bs.modal', function (e) {
                var idProceso = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateProcesoIniciativa').load('proceso-iniciativa/' + idProceso + '/edit');
            }); 
            //#3.- Realizamos el procesamiento de la información
            $(document).on("click", '#btnCreateProcesoIniciativa', function (event) {
                event.preventDefault();
                var form = $("#FormCreateProcesoIniciativa");
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
                        $("#Footer_CreateProcesoIniciativa_Enabled").css("display", "none");
                        $("#Footer_CreateProcesoIniciativa_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateProcesoIniciativa_Enabled").css("display", "block");
                        $("#Footer_CreateProcesoIniciativa_Disabled").css("display", "none");
                        $("#modalCreateProcesoIniciativa").modal('hide');
                        $("#viewDataProcesoIniciativa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataProcesoIniciativa").load('proceso-iniciativa/data');
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
                        $("#ProcesoIniciativaAlerts").css("display", "block");
                        $("#ProcesoIniciativaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateProcesoIniciativa_Enabled").css("display", "block");
                        $("#Footer_CreateProcesoIniciativa_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateProcesoIniciativa', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateProcesoIniciativa");
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
                        $("#Footer_UpdateProcesoIniciativa_Enabled").css("display", "none");
                        $("#Footer_UpdateProcesoIniciativa_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateProcesoIniciativa_Enabled").css("display", "block");
                        $("#Footer_UpdateProcesoIniciativa_Disabled").css("display", "none");
                        $("#modalUpdateProcesoIniciativa").modal('hide');
                        $("#viewDataProcesoIniciativa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataProcesoIniciativa").load('proceso-iniciativa/data');
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
                        $("#ProcesoIniciativaAlerts").css("display", "block");
                        $("#ProcesoIniciativaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateProcesoIniciativa_Enabled").css("display", "block");
                        $("#Footer_UpdateProcesoIniciativa_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '.btnDeleteProcesoIniciativa', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'proceso-iniciativa/'+codigo;
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
                                    $("#viewDataProcesoIniciativa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataProcesoIniciativa").load('proceso-iniciativa/data');
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
                        $("#viewDataProcesoIniciativa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataProcesoIniciativa").load('proceso-iniciativa/data');
                    }
                );
            });
        });
    </script>
@stop
