@extends('layouts.template')
@section('title', 'Valores de la tablas del sistema')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateTablaValor"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataTablaValor" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateTablaValor">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateTablaValor">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateTablaValor">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateTablaValor">
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
            $("#viewDataTablaValor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataTablaValor").load("tabla-valor/data");
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateTablaValor').on('show.bs.modal', function (e) {
                $('#divFormCreateTablaValor').load("tabla-valor/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateTablaValor').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateTablaValor').load('tabla-valor/' + codigo + '/edit');
            }); 
            //#3.- Modal para proceder al registro de la información
            $(document).on("click", '#btnCreateTablaValor', function (event) {
                event.preventDefault();
                var form = $("#FormCreateTablaValor");
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
                        $("#Footer_CreateTablaValor_Enabled").css("display", "none");
                        $("#Footer_CreateTablaValor_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateTablaValor_Enabled").css("display", "block");
                        $("#Footer_CreateTablaValor_Disabled").css("display", "none");
                        $("#modalCreateTablaValor").modal('hide');
                        $("#viewDataTablaValor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataTablaValor').load('tabla-valor/data');
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
                        $("#TablaValorAlerts").css("display", "block");
                        $("#TablaValorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateTablaValor_Enabled").css("display", "block");
                        $("#Footer_CreateTablaValor_Disabled").css("display", "none");
                    }
                });
            });
            //#4.- Modal para proceder la actualizacion de la información
            $(document).on("click", '#btnUpdateTablaValor', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateTablaValor");
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
                        $("#Footer_UpdateTablaValor_Enabled").css("display", "none");
                        $("#Footer_UpdateTablaValor_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateTablaValor_Enabled").css("display", "block");
                        $("#Footer_UpdateTablaValor_Disabled").css("display", "none");
                        $("#modalUpdateTablaValor").modal('hide');
                        $("#viewDataTablaValor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataTablaValor').load('tabla-valor/data');
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
                        $("#TablaValorAlerts").css("display", "block");
                        $("#TablaValorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateTablaValor_Enabled").css("display", "block");
                        $("#Footer_UpdateTablaValor_Disabled").css("display", "none");
                    }
                });
            });
            //#5.- Modal para proceder a la deshabilitación de módulos
            $(document).on("click", '.btnDeleteTablaValor', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'tabla-valor/'+codigo;
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
                                    $("#viewDataTablaValor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $('#viewDataTablaValor').load('tabla-valor/data');
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
                        $("#viewDataTablaValor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataTablaValor').load('tabla-valor/data');
                    }
                );
            });
        });
    </script>
@stop