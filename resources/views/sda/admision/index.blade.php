@extends('layouts.template')
@section('title', 'Módulo para la admisión de Solicitudes de apoyo')
@section('content')
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateSdaUr"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="TabProcesoUr" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProcesoSdaUr001" data-toggle="pill" href="#custom-tabs-sda-pendiente" role="tab" aria-controls="custom-tabs-sda-pendiente" aria-selected="true">1. En Proceso</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoSdaUr002" data-toggle="pill" href="#custom-tabs-sda-aprobado" role="tab" aria-controls="custom-tabs-sda-aprobado" aria-selected="false">2. Elegibilidad otorgada</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoSdaUr003" data-toggle="pill" href="#custom-tabs-sda-observado" role="tab" aria-controls="custom-tabs-sda-observado" aria-selected="false">3. Observados</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoSdaUr004" data-toggle="pill" href="#custom-tabs-sda-archivado" role="tab" aria-controls="custom-tabs-sda-archivado" aria-selected="false">4. Improcedente</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoSdaUrContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-sda-pendiente" role="tabpanel" aria-labelledby="TabProcesoSdaUr001">
                                        <div id="viewDataSdaPendiente" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-sda-aprobado" role="tabpanel" aria-labelledby="TabProcesoSdaUr002">
                                        <div id="viewDataSdaAprobado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-sda-observado" role="tabpanel" aria-labelledby="TabProcesoSdaUr003">
                                        <div id="viewDataSdaObservado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-sda-archivado" role="tabpanel" aria-labelledby="TabProcesoSdaUr004">
                                        <div id="viewDataSdaArchivado" class="table-responsive"></div>
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
<div class="modal fade" id="modalCreateSdaUr">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateSdaUr">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la edición de registros --}}
<div class="modal fade" id="modalUpdateSdaUr">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateSdaUr">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la observación de registros --}}    
<div class="modal fade" id="modalObservaSdaUr">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormObservaSdaUr">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para el archivamiento de registros --}}    
<div class="modal fade" id="modalArchivaSdaUr">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormArchivaSdaUr">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para el archivamiento de registros --}}    
<div class="modal fade" id="modalDerivaSdaUr">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormDerivaSdaUr">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para el levantamiento de observaciones --}}    
<div class="modal fade" id="modalSubsanaObservacionSda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormSubsanaSdaUr">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

{{-- Inicio del contenido--}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //1.- Obtengo la data de los expedientes registrados
        $("#viewDataSdaPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataSdaPendiente").load("admision/data-pendiente");
        $("#viewDataSdaAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataSdaAprobado").load("admision/data-aprobado");
        $("#viewDataSdaObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataSdaObservado").load("admision/data-observado");
        $("#viewDataSdaArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataSdaArchivado").load("admision/data-archivado");
        //2.- Modal para crear un nuevo registro
        $('#modalCreateSdaUr').on('show.bs.modal', function (e) {
            $('#divFormCreateSdaUr').load("admision/create");
        });
        $('#modalUpdateSdaUr').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateSdaUr').load('admision/' + idExpediente + '/edit');
        });
        //3.- Proceso el formulario de registro
        $(document).on("click", '#btnCreateSdaUr', function (event) {
            event.preventDefault();
            var form = $("#FormCreateSdaUr");
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
                    $("#Footer_CreateSdaUr_Enabled").css("display", "none");
                    $("#Footer_CreateSdaUr_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateSdaUr_Enabled").css("display", "block");
                    $("#Footer_CreateSdaUr_Disabled").css("display", "none");
                    $("#modalCreateSdaUr").modal('hide');
                    $("#viewDataSdaPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaPendiente").load("admision/data-pendiente");
                    $("#viewDataSdaAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaAprobado").load("admision/data-aprobado");
                    $("#viewDataSdaObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaObservado").load("admision/data-observado");
                    $("#viewDataSdaArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaArchivado").load("admision/data-archivado");
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
                    $("#ExpedienteSdaUrAlerts").css("display", "block");
                    $("#ExpedienteSdaUrAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateExpedienteSdaUr_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteSdaUr_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateSdaUr', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateSdaUr");
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
                    $("#Footer_UpdateSdaUr_Enabled").css("display", "none");
                    $("#Footer_UpdateSdaUr_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateSdaUr_Enabled").css("display", "block");
                    $("#Footer_UpdateSdaUr_Disabled").css("display", "none");
                    $("#modalUpdateSdaUr").modal('hide');
                    $("#viewDataSdaPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaPendiente").load("admision/data-pendiente");
                    $("#viewDataSdaAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaAprobado").load("admision/data-aprobado");
                    $("#viewDataSdaObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaObservado").load("admision/data-observado");
                    $("#viewDataSdaArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaArchivado").load("admision/data-archivado");
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
                    $("#ExpedienteSdaUrAlerts").css("display", "block");
                    $("#ExpedienteSdaUrAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateExpedienteSdaUr_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedienteSdaUr_Disabled").css("display", "none");
                }
            });
        });
        //4.- Muestro el formulario para observar los expedientes
        $('#modalObservaSdaUr').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormObservaSdaUr').load('admision/' + idExpediente + '/observa');
        });
        $(document).on("click", '#btnObservaSdaUr', function (event) {
            event.preventDefault();
            var form = $("#FormObservaSdaUr");
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
                    $("#Footer_ObservaSdaUr_Enabled").css("display", "none");
                    $("#Footer_ObservaSdaUr_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ObservaSdaUr_Enabled").css("display", "block");
                    $("#Footer_ObservaSdaUr_Disabled").css("display", "none");
                    $("#modalObservaSdaUr").modal('hide');
                    $("#viewDataSdaPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaPendiente").load("admision/data-pendiente");
                    $("#viewDataSdaAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaAprobado").load("admision/data-aprobado");
                    $("#viewDataSdaObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaObservado").load("admision/data-observado");
                    $("#viewDataSdaArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaArchivado").load("admision/data-archivado");
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
                    $("#ExpedienteObservaSdaAlerts").css("display", "block");
                    $("#ExpedienteObservaSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ObservaSdaUr_Enabled").css("display", "block");
                    $("#Footer_ObservaSdaUr_Disabled").css("display", "none");
                }
            });
        });
        //5.- Muestro el formulario para archivar los expedientes
        $('#modalArchivaSdaUr').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormArchivaSdaUr').load('admision/' + idExpediente + '/archiva');
        });
        $(document).on("click", '#btnArchivaSdaUr', function (event) {
            event.preventDefault();
            var form = $("#FormArchivaSdaUr");
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
                    $("#Footer_ArchivaSdaUr_Enabled").css("display", "none");
                    $("#Footer_ArchivaSdaUr_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ArchivaSdaUr_Enabled").css("display", "block");
                    $("#Footer_ArchivaSdaUr_Disabled").css("display", "none");
                    $("#modalArchivaSdaUr").modal('hide');
                    $("#viewDataSdaPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaPendiente").load("admision/data-pendiente");
                    $("#viewDataSdaAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaAprobado").load("admision/data-aprobado");
                    $("#viewDataSdaObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaObservado").load("admision/data-observado");
                    $("#viewDataSdaArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaArchivado").load("admision/data-archivado");
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
                    $("#ExpedienteArchivaSdaAlerts").css("display", "block");
                    $("#ExpedienteArchivaSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ArchivaSdaUr_Enabled").css("display", "block");
                    $("#Footer_ArchivaSdaUr_Disabled").css("display", "none");
                }
            });
        });
        //6.- Muestro el formulario para derivar los expedientes
        $('#modalDerivaSdaUr').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormDerivaSdaUr').load('admision/' + idExpediente + '/deriva');
        });
        $(document).on("click", '#btnDerivaSdaUr', function (event) {
            event.preventDefault();
            var form = $("#FormDerivaSdaUr");
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
                    $("#Footer_DerivaSdaUr_Enabled").css("display", "none");
                    $("#Footer_DerivaSdaUr_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_DerivaSdaUr_Enabled").css("display", "block");
                    $("#Footer_DerivaSdaUr_Disabled").css("display", "none");
                    $("#modalDerivaSdaUr").modal('hide');
                    $("#viewDataSdaPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaPendiente").load("admision/data-pendiente");
                    $("#viewDataSdaAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaAprobado").load("admision/data-aprobado");
                    $("#viewDataSdaObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaObservado").load("admision/data-observado");
                    $("#viewDataSdaArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaArchivado").load("admision/data-archivado");
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
                    $("#ExpedienteDerivaSdaAlerts").css("display", "block");
                    $("#ExpedienteDerivaSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_DerivaSdaUr_Enabled").css("display", "block");
                    $("#Footer_DerivaSdaUr_Disabled").css("display", "none");
                }
            });
        });
        //7.- Muestro el formulario para el levantamiento de observaciones
        $('#modalSubsanaObservacionSda').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormSubsanaSdaUr').load('admision/' + idExpediente + '/subsana-observacion');
        });
        $(document).on("click", '#btnSubsanaSdaUr', function (event) {
            event.preventDefault();
            var form = $("#FormSubsanaSdaUr");
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
                    $("#Footer_SubsanaSdaUr_Enabled").css("display", "none");
                    $("#Footer_SubsanaSdaUr_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_SubsanaSdaUr_Enabled").css("display", "block");
                    $("#Footer_SubsanaSdaUr_Disabled").css("display", "none");
                    $("#modalSubsanaObservacionSda").modal('hide');
                    $("#viewDataSdaPendiente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaPendiente").load("admision/data-pendiente");
                    $("#viewDataSdaAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaAprobado").load("admision/data-aprobado");
                    $("#viewDataSdaObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaObservado").load("admision/data-observado");
                    $("#viewDataSdaArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataSdaArchivado").load("admision/data-archivado");
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
                    $("#ExpedienteSubsanaSdaAlerts").css("display", "block");
                    $("#ExpedienteSubsanaSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_SubsanaSdaUr_Enabled").css("display", "block");
                    $("#Footer_SubsanaSdaUr_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop