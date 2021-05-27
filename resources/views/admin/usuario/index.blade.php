@extends('layouts.template')
@section('title', 'Módulo para el mantenimiento de usuarios')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateUsuario"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataUsuario" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateUsuario">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateUsuario">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateUsuario">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateUsuario">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la actualización de contraseñas de usuario --}}
    <div class="modal fade" id="modalUpdatePassword">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdatePassword">
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
            $("#viewDataUsuario").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataUsuario").load("usuario/data");
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateUsuario').on('show.bs.modal', function (e) {
                $('#divFormCreateUsuario').load("usuario/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateUsuario').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateUsuario').load('usuario/' + codigo + '/edit');
            }); 
            //#3.- Modal para actualizar una contraseña
            $('#modalUpdatePassword').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdatePassword').load('usuario/' + codigo + '/reset');
            }); 
            //#4.- Modal para proceder al registro de la información
            $(document).on("click", '#btnCreateUsuario', function (event) {
                event.preventDefault();
                var form = $("#FormCreateUsuario");
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
                        $("#Footer_CreateUsuario_Enabled").css("display", "none");
                        $("#Footer_CreateUsuario_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateUsuario_Enabled").css("display", "block");
                        $("#Footer_CreateUsuario_Disabled").css("display", "none");
                        $("#modalCreateUsuario").modal('hide');
                        $("#viewDataUsuario").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataUsuario').load('usuario/data');
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
                        $("#UsuarioAlerts").css("display", "block");
                        $("#UsuarioAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateUsuario_Enabled").css("display", "block");
                        $("#Footer_CreateUsuario_Disabled").css("display", "none");
                    }
                });
            });
            //#5.- Modal para proceder la actualizacion de la información
            $(document).on("click", '#btnUpdateUsuario', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateUsuario");
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
                        $("#Footer_UpdateUsuario_Enabled").css("display", "none");
                        $("#Footer_UpdateUsuario_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateUsuario_Enabled").css("display", "block");
                        $("#Footer_UpdateUsuario_Disabled").css("display", "none");
                        $("#modalUpdateUsuario").modal('hide');
                        $("#viewDataUsuario").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataUsuario').load('usuario/data');
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
                        $("#UsuarioAlerts").css("display", "block");
                        $("#UsuarioAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateUsuario_Enabled").css("display", "block");
                        $("#Footer_UpdateUsuario_Disabled").css("display", "none");
                    }
                });
            });
            //#6.- Modal para proceder a la deshabilitación de módulos
            $(document).on("click", '.btnDeleteUsuario', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = route("usuario.destroy", codigo);
                // Antes de procesar realizamos una confirmación del proceso
                alertify.confirm("Confirmación de envío de formulario", "¿Esta seguro de que desea dar de baja a este usuario?.",
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
                                    $("#viewDataUsuario").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataUsuario").load(route("usuario.data"));
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
                        $("#viewDataUsuario").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataUsuario").load(route("usuario.data"));
                    }
                );
            });
            //#7. Modal para proceder a la actualización de la contraseña de usuario
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
                        $("#viewDataUsuario").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataUsuario').load('usuario/data');
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