@extends('layouts.template')
@section('title', 'Módulo para el registro de convenios')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header bg-primary">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="convenio/create" class="btn btn-sm btn-info" title="Realizar nuevo registro"><i class="fas fa-plus-circle"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataConvenio" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalUploadConvenioMarco">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUploadConvenioMarco">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>    
    <div class="modal fade" id="modalUpdateEstadoConvenioMarco">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateEstadoConvenioMarco">
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
            //1. Obtengo la información de eventos registrados
            $("#viewDataConvenio").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataConvenio").load(route("convenio-marco.data"));
            //2. Mostramos los modals
            $('#modalUploadConvenioMarco').on('show.bs.modal', function (e) {
                var codConvenio= $(e.relatedTarget).attr('data-id');
                $('#divFormUploadConvenioMarco').load(route("convenio-marco.form-upload", codConvenio));
            });
            $('#modalUpdateEstadoConvenioMarco').on('show.bs.modal', function (e) {
                var codConvenio= $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateEstadoConvenioMarco').load(route("convenio-marco.form-situacion", codConvenio));
            });
            //3. Procesamos la información solicitada
            $(document).on("click", '#btnUploadConvenioMarco', function (event) {
                event.preventDefault();
                var form = $("#FormUploadConvenioMarco");
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
                        $("#Footer_UploadConvenioMarco_Enabled").css("display", "none");
                        $("#Footer_UploadConvenioMarco_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UploadConvenioMarco_Enabled").css("display", "block");
                        $("#Footer_UploadConvenioMarco_Disabled").css("display", "none");
                        $("#modalUploadConvenioMarco").modal('hide');
                        $("#viewDataConvenio").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataConvenio").load(route("convenio-marco.data"));
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
                        $("#UploadConvenioMarcoAlerts").css("display", "block");
                        $("#UploadConvenioMarcoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UploadConvenioMarco_Enabled").css("display", "block");
                        $("#Footer_UploadConvenioMarco_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '.btnDeleteConvenioMarco', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'convenio/'+codigo+'/destroy';
                // Antes de procesar realizamos una confirmación del proceso
                alertify.confirm("Confirmación de envío de formulario", "¿Esta seguro de que desea eliminar este ítem?.",
                    function () {
                        $.ajax({
                            url: urlAction,
                            method: "POST",
                            data: codigo,
                            beforeSend: function () {},
                            success: function (response) {
                                var cadena = response;
                                var mensaje = cadena.mensaje;
                                alertify.alert("Proceso concluido", mensaje, function () {
                                    $("#viewDataConvenio").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataConvenio").load("convenio/data");
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
                        $("#viewDataConvenio").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataConvenio").load("convenio/data");
                    }
                );
            });
            $(document).on("click", '#btnUpdateEstadoConvenioMarco', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateEstadoConvenioMarco");
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
                        $("#Footer_UpdateEstadoConvenioMarco_Enabled").css("display", "none");
                        $("#Footer_UpdateEstadoConvenioMarco_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateEstadoConvenioMarco_Enabled").css("display", "block");
                        $("#Footer_UpdateEstadoConvenioMarco_Disabled").css("display", "none");
                        $("#modalUpdateEstadoConvenioMarco").modal('hide');
                        $("#viewDataConvenio").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataConvenio").load(route("convenio-marco.data"));
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
                        $("#UpdateEstadoConvenioMarcoAlerts").css("display", "block");
                        $("#UpdateEstadoConvenioMarcoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateEstadoConvenioMarco_Enabled").css("display", "block");
                        $("#Footer_UpdateEstadoConvenioMarco_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop