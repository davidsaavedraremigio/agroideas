@extends('layouts.template')
@section('title', 'Tablas del sistema')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateTabla"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataTabla" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateTabla">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateTabla">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateTabla">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateTabla">
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
            $("#viewDataTabla").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataTabla").load("tabla/data");
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateTabla').on('show.bs.modal', function (e) {
                $('#divFormCreateTabla').load("tabla/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateTabla').on('show.bs.modal', function (e) {
                var idTabla = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateTabla').load('tabla/' + idTabla + '/edit');
            }); 
            //#3.- Modal para proceder al registro de la información
            $(document).on("click", '#btnCreateTabla', function (event) {
                event.preventDefault();
                var form = $("#FormCreateTabla");
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
                        $("#Footer_CreateTabla_Enabled").css("display", "none");
                        $("#Footer_CreateTabla_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateTabla_Enabled").css("display", "block");
                        $("#Footer_CreateTabla_Disabled").css("display", "none");
                        $("#modalCreateTabla").modal('hide');
                        $("#viewDataTabla").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataTabla').load('tabla/data');
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
                        $("#TablaAlerts").css("display", "block");
                        $("#TablaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateTabla_Enabled").css("display", "block");
                        $("#Footer_CreateTabla_Disabled").css("display", "none");
                    }
                });
            });
            //#4.- Modal para proceder la actualizacion de la información
            $(document).on("click", '#btnUpdateTabla', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateTabla");
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
                        $("#Footer_UpdateTabla_Enabled").css("display", "none");
                        $("#Footer_UpdateTabla_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateTabla_Enabled").css("display", "block");
                        $("#Footer_UpdateTabla_Disabled").css("display", "none");
                        $("#modalUpdateTabla").modal('hide');
                        $("#viewDataTabla").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataTabla').load('tabla/data');
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
                        $("#TablaAlerts").css("display", "block");
                        $("#TablaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateTabla_Enabled").css("display", "block");
                        $("#Footer_UpdateTabla_Disabled").css("display", "none");
                    }
                });
            });
            //#5.- Modal para proceder a la deshabilitación de módulos
            $(document).on("click", '.btnDeleteTabla', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'tabla/'+codigo;
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
                                    $("#viewDataTabla").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $('#viewDataTabla').load('tabla/data');
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
                        $("#viewDataTabla").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataTabla').load('tabla/data');
                    }
                );
            });
        });
    </script>
@stop