@extends('layouts.template')
@section('title', 'Módulo para la elaboración de convenios')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateExpedienteUpfp"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="TabProcesoContrato" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" id="TabProcesoContrato001" data-toggle="pill" href="#custom-tabs-contrato-pendiente" role="tab" aria-controls="custom-tabs-contrato-pendiente" aria-selected="true">1. Pendientes</a></li>
                                        <li class="nav-item"><a class="nav-link" id="TabProcesoContrato002" data-toggle="pill" href="#custom-tabs-contrato-aprobado" role="tab" aria-controls="custom-tabs-contrato-aprobado" aria-selected="false">2. Emitidos</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="TabProcesoContratoContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-contrato-pendiente" role="tabpanel" aria-labelledby="TabProcesoContrato001">
                                            <div id="viewDataContratoPendiente" class="table-responsive"></div>
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-contrato-aprobado" role="tabpanel" aria-labelledby="TabProcesoContrato002">
                                            <div id="viewDataContratoAprobado" class="table-responsive"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateContrato">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateContrato">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para poder modificar los estados de la iniciativa --}}
    <div class="modal fade" id="modalUpdateEstadoContrato">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateEstadoContrato">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para poder generar los procesos de cierre --}}
    <div class="modal fade" id="modalCreateProcesoCierre">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateProcesoCierre">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    <div class="modal fade" id="modalCreateCierre">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateCierre">
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
                //1. Obtengo los datos
                $("#viewDataContratoPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                $("#viewDataContratoPendiente").load(route('convenio.data-pendiente'));
                $("#viewDataContratoAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                $("#viewDataContratoAprobado").load(route('convenio.data-aprobado'));
                //2. Modal para crear un nuevo registro
                $('#modalCreateContrato').on('show.bs.modal', function (e) {
                    var idPostulante = $(e.relatedTarget).attr('data-id');
                    $("#divFormCreateContrato").load(route('convenio.create', idPostulante));
                });
                //3. Procesamos la informacion
                $(document).on("click", '#btnCreateContrato', function (event) {
                    event.preventDefault();
                    var form = $("#FormCreateContrato");
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
                            $("#Footer_CreateContrato_Enabled").css("display", "none");
                            $("#Footer_CreateContrato_Disabled").css("display", "block");
                        },
                        success: function (response) {
                            var mensaje = response.mensaje;
                            form[0].reset();
                            $("#Footer_CreateContrato_Enabled").css("display", "block");
                            $("#Footer_CreateContrato_Disabled").css("display", "none");
                            $("#modalCreateContrato").modal('hide');
                            $("#viewDataContratoPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoPendiente").load(route('convenio.data-pendiente'));
                            $("#viewDataContratoAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoAprobado").load(route('convenio.data-aprobado'));
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
                            $("#ContratoAlerts").css("display", "block");
                            $("#ContratoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                            $("#Footer_CreateContrato_Enabled").css("display", "block");
                            $("#Footer_CreateContrato_Disabled").css("display", "none");
                        }
                    });
                });
                //4. Modal para actualizar el estado del contrato
                $('#modalUpdateEstadoContrato').on('show.bs.modal', function (e) {
                    var idcontrato = $(e.relatedTarget).attr('data-id');
                    $("#divFormUpdateEstadoContrato").load(route('convenio.estado', idcontrato));
                });
                $(document).on("click", '#btnUpdateEstadoContrato', function (event) {
                    event.preventDefault();
                    var form = $("#FormUpdateEstadoContrato");
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
                            $("#Footer_UpdateEstadoContrato_Enabled").css("display", "none");
                            $("#Footer_UpdateEstadoContrato_Disabled").css("display", "block");
                        },
                        success: function (response) {
                            var mensaje = response.mensaje;
                            form[0].reset();
                            $("#Footer_UpdateEstadoContrato_Enabled").css("display", "block");
                            $("#Footer_UpdateEstadoContrato_Disabled").css("display", "none");
                            $("#modalUpdateEstadoContrato").modal('hide');
                            $("#viewDataContratoPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoPendiente").load(route('convenio.data-pendiente'));
                            $("#viewDataContratoAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoAprobado").load(route('convenio.data-aprobado'));
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
                            $("#UpdateEstadoContratoAlerts").css("display", "block");
                            $("#UpdateEstadoContratoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                            $("#Footer_UpdateEstadoContrato_Enabled").css("display", "block");
                            $("#Footer_UpdateEstadoContrato_Disabled").css("display", "none");
                        }
                    });
                });
                //5. Modal para iniciar el proceso de cierre
                $('#modalCreateProcesoCierre').on('show.bs.modal', function (e) {
                    var idPostulante = $(e.relatedTarget).attr('data-id');
                    $("#divFormCreateProcesoCierre").load(route("proceso-cierre.create", idPostulante));
                });
                $('#modalCreateCierre').on('show.bs.modal', function (e) {
                    var idPostulante = $(e.relatedTarget).attr('data-id');
                    $("#divFormCreateCierre").load(route("cierre.create", idPostulante));
                });
                //6. Procesamos la información
                $(document).on("click", '#btnCreateProcesoCierre', function (event) {
                    event.preventDefault();
                    var form = $("#FormCreateProcesoCierre");
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
                            $("#Footer_CreateProcesoCierre_Enabled").css("display", "none");
                            $("#Footer_CreateProcesoCierre_Disabled").css("display", "block");
                        },
                        success: function (response) {
                            var mensaje = response.mensaje;
                            form[0].reset();
                            $("#Footer_CreateProcesoCierre_Enabled").css("display", "block");
                            $("#Footer_CreateProcesoCierre_Disabled").css("display", "none");
                            $("#modalCreateProcesoCierre").modal('hide');
                            $("#viewDataContratoPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoPendiente").load(route('convenio.data-pendiente'));
                            $("#viewDataContratoAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoAprobado").load(route('convenio.data-aprobado'));
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
                            $("#ProcesoCierreAlerts").css("display", "block");
                            $("#ProcesoCierreAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                            $("#Footer_CreateProcesoCierre_Enabled").css("display", "block");
                            $("#Footer_CreateProcesoCierre_Disabled").css("display", "none");
                        }
                    });
                });
                $(document).on("click", '#btnCreateCierre', function (event) {
                    event.preventDefault();
                    var form = $("#FormCreateCierre");
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
                            $("#Footer_CreateCierre_Enabled").css("display", "none");
                            $("#Footer_CreateCierre_Disabled").css("display", "block");
                        },
                        success: function (response) {
                            var mensaje = response.mensaje;
                            form[0].reset();
                            $("#Footer_CreateCierre_Enabled").css("display", "block");
                            $("#Footer_CreateCierre_Disabled").css("display", "none");
                            $("#modalCreateCierre").modal('hide');
                            $("#viewDataContratoPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoPendiente").load(route('convenio.data-pendiente'));
                            $("#viewDataContratoAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                            $("#viewDataContratoAprobado").load(route('convenio.data-aprobado'));
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
                            $("#CierreAlerts").css("display", "block");
                            $("#CierreAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                            $("#Footer_CreateCierre_Enabled").css("display", "block");
                            $("#Footer_CreateCierre_Disabled").css("display", "none");
                        }
                    });
                });
            });
        </script>
    @stop    