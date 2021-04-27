@extends('layouts.template')
@section('title', 'Sectores productivos')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateSector"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataSector" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateSector">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateSector">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateSector">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateSector">
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
            $("#viewDataSector").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataSector").load("sector/data");
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateSector').on('show.bs.modal', function (e) {
                $('#divFormCreateSector').load("sector/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateSector').on('show.bs.modal', function (e) {
                var idSector = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateSector').load('sector/' + idSector + '/edit');
            }); 
            //#3.- Modal para proceder al registro de la información
            $(document).on("click", '#btnCreateSector', function (event) {
                event.preventDefault();
                var form = $("#FormCreateSector");
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
                        $("#Footer_CreateSector_Enabled").css("display", "none");
                        $("#Footer_CreateSector_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateSector_Enabled").css("display", "block");
                        $("#Footer_CreateSector_Disabled").css("display", "none");
                        $("#modalCreateSector").modal('hide');
                        $("#viewDataSector").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataSector').load('sector/data');
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
                        $("#SectorAlerts").css("display", "block");
                        $("#SectorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateSector_Enabled").css("display", "block");
                        $("#Footer_CreateSector_Disabled").css("display", "none");
                    }
                });
            });
            //#4.- Modal para proceder la actualizacion de la información
            $(document).on("click", '#btnUpdateSector', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateSector");
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
                        $("#Footer_UpdateSector_Enabled").css("display", "none");
                        $("#Footer_UpdateSector_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateSector_Enabled").css("display", "block");
                        $("#Footer_UpdateSector_Disabled").css("display", "none");
                        $("#modalUpdateSector").modal('hide');
                        $("#viewDataSector").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataSector').load('sector/data');
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
                        $("#SectorAlerts").css("display", "block");
                        $("#SectorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateSector_Enabled").css("display", "block");
                        $("#Footer_UpdateSector_Disabled").css("display", "none");
                    }
                });
            });
            //#5.- Modal para proceder a la deshabilitación de módulos
            $(document).on("click", '.btnDeleteSector', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'sector/'+codigo;
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
                                    $("#viewDataSector").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $('#viewDataSector').load('sector/data');
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
                        $("#viewDataSector").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataSector').load('sector/data');
                    }
                );
            });
        });
    </script>
@stop