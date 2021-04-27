@extends('layouts.template')
@section('title', 'Evaluación documentaria')
@section('content')
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateExpedienteUR"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="TabProcesoUr" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProcesoUr001" data-toggle="pill" href="#custom-tabs-proceso-pendiente" role="tab" aria-controls="custom-tabs-proceso-pendiente" aria-selected="true">1. En Proceso</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUr002" data-toggle="pill" href="#custom-tabs-proceso-aprobado" role="tab" aria-controls="custom-tabs-proceso-aprobado" aria-selected="false">2. Derivados</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUr003" data-toggle="pill" href="#custom-tabs-proceso-observado" role="tab" aria-controls="custom-tabs-proceso-observado" aria-selected="false">3. Observados</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUr004" data-toggle="pill" href="#custom-tabs-proceso-desaprobado" role="tab" aria-controls="custom-tabs-proceso-desaprobado" aria-selected="false">4. Archivados</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoUrContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-proceso-pendiente" role="tabpanel" aria-labelledby="TabProcesoUr001">
                                        <div id="viewDataExpedienteUR" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-aprobado" role="tabpanel" aria-labelledby="TabProcesoUr002">
                                        <div id="viewDataExpedienteURAprobado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-observado" role="tabpanel" aria-labelledby="TabProcesoUr003">
                                        <div id="viewDataExpedienteURObservado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-desaprobado" role="tabpanel" aria-labelledby="TabProcesoUr004">
                                        <div id="viewDataExpedienteURArchivado" class="table-responsive"></div>
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
    <div class="modal fade" id="modalCreateExpedienteUR">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateExpedienteUR">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
{{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateExpedienteUR">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateExpedienteUR">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
{{-- Modal para la derivacion de registros --}}
    <div class="modal fade" id="modalDerivaExpedienteUr">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormDerivaExpedienteUr">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
{{-- Modal para el archivamiento de registros --}}    
<div class="modal fade" id="modalArchivaExpedienteUR">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormArchivaExpedienteUR">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la observación de registros --}}    
<div class="modal fade" id="modalObservaExpedienteUR">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormObservaExpedienteUR">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la correccion de observaciones --}}    
<div class="modal fade" id="modalSubsanaObservacionUR">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormSubsanaObservacionUR">
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

        $("#viewDataExpedienteUR").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUR").load("ur/data-pendiente");
        $("#viewDataExpedienteURAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteURAprobado").load("ur/data-aprobado");
        $("#viewDataExpedienteURObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteURObservado").load("ur/data-observado");
        $("#viewDataExpedienteURArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteURArchivado").load("ur/data-archivado");

        //#1.- Modal para crear un nuevo registro
        $('#modalCreateExpedienteUR').on('show.bs.modal', function (e) {
            $('#divFormCreateExpedienteUR').load("ur/create");
        });
        //#2 Proceso el formulario de registro
        $(document).on("click", '#btnCreateExpedienteUR', function (event) {
            event.preventDefault();
            var form = $("#FormCreateExpedienteUR");
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
                    $("#Footer_CreateExpedienteUR_Enabled").css("display", "none");
                    $("#Footer_CreateExpedienteUR_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUR_Disabled").css("display", "none");
                    $("#modalCreateExpedienteUR").modal('hide');
                    $("#viewDataExpedienteUR").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUR").load("ur/data-pendiente");
                    $("#viewDataExpedienteURAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURAprobado").load("ur/data-aprobado");
                    $("#viewDataExpedienteURObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURObservado").load("ur/data-observado");
                    $("#viewDataExpedienteURArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURArchivado").load("ur/data-archivado");
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
                    $("#ExpedienteURAlerts").css("display", "block");
                    $("#ExpedienteURAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUR_Disabled").css("display", "none");
                }
            });
        });
        //#3.- Modal para editar un registro
        $('#modalUpdateExpedienteUR').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateExpedienteUR').load('ur/' + idExpediente + '/edit');
        });
        //#4. Actualizo el registro
        $(document).on("click", '#btnUpdateExpedienteUR', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateExpedienteUR");
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
                    $("#Footer_UpdateExpedienteUR_Enabled").css("display", "none");
                    $("#Footer_UpdateExpedienteUR_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedienteUR_Disabled").css("display", "none");
                    $("#modalUpdateExpedienteUR").modal('hide');
                    $("#viewDataExpedienteUR").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUR").load("ur/data-pendiente");
                    $("#viewDataExpedienteURAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURAprobado").load("ur/data-aprobado");
                    $("#viewDataExpedienteURObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURObservado").load("ur/data-observado");
                    $("#viewDataExpedienteURArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURArchivado").load("ur/data-archivado");
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
                    $("#ExpedienteURAlerts").css("display", "block");
                    $("#ExpedienteURAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedienteUR_Disabled").css("display", "none");
                }
            });
        });
        //#5. Modal para derivar el expediente
        $('#modalDerivaExpedienteUr').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormDerivaExpedienteUr').load('ur/' + idExpediente + '/documento');
        });
        //#6. Proceso la derivacion del expediente
        $(document).on("click", '#btnDerivaExpedienteUR', function (event) {
            event.preventDefault();
            var form = $("#FormDerivaExpedienteUR");
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
                    $("#Footer_DerivaExpedienteUR_Enabled").css("display", "none");
                    $("#Footer_DerivaExpedienteUR_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_DerivaExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUR_Disabled").css("display", "none");
                    $("#modalDerivaExpedienteUr").modal('hide');
                    $("#viewDataExpedienteUR").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUR").load("ur/data-pendiente");
                    $("#viewDataExpedienteURAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURAprobado").load("ur/data-aprobado");
                    $("#viewDataExpedienteURObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURObservado").load("ur/data-observado");
                    $("#viewDataExpedienteURArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURArchivado").load("ur/data-archivado");
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
                    $("#ExpedienteURAlerts").css("display", "block");
                    $("#ExpedienteURAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_DerivaExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUR_Disabled").css("display", "none");
                }
            });
        });
        //#7. Muestro el formulario para observar los expedientes
        $('#modalObservaExpedienteUR').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormObservaExpedienteUR').load('ur/' + idExpediente + '/observa');
        });
        //#8. Proceso la observacion del expediente
        $(document).on("click", '#btnObservaExpedienteUR', function (event) {
            event.preventDefault();
            var form = $("#FormObservaExpedienteUR");
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
                    $("#Footer_ObservaExpedienteUR_Enabled").css("display", "none");
                    $("#Footer_ObservaExpedienteUR_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ObservaExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_ObservaExpedienteUR_Disabled").css("display", "none");
                    $("#modalObservaExpedienteUR").modal('hide');
                    $("#viewDataExpedienteUR").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUR").load("ur/data-pendiente");
                    $("#viewDataExpedienteURAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURAprobado").load("ur/data-aprobado");
                    $("#viewDataExpedienteURObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURObservado").load("ur/data-observado");
                    $("#viewDataExpedienteURArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURArchivado").load("ur/data-archivado");
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
                    $("#ExpedienteURAlerts").css("display", "block");
                    $("#ExpedienteURAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ObservaExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_ObservaExpedienteUR_Disabled").css("display", "none");
                }
            });
        });
        //#9. Muestro el formulario para levantar las observaciones
        $('#modalSubsanaObservacionUR').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormSubsanaObservacionUR').load('ur/' + idExpediente + '/subsana-observacion');
        });
        //#10. Proceso la subsanación de la observacion del expediente
        $(document).on("click", '#btnSubsanaObservacionUR', function (event) {
            event.preventDefault();
            var form = $("#FormSubsanaObservacionUR");
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
                    $("#Footer_SubsanaObservacionUR_Enabled").css("display", "none");
                    $("#Footer_SubsanaObservacionUR_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_SubsanaObservacionUR_Enabled").css("display", "block");
                    $("#Footer_SubsanaObservacionUR_Disabled").css("display", "none");
                    $("#modalSubsanaObservacionUR").modal('hide');
                    $("#viewDataExpedienteUR").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUR").load("ur/data-pendiente");
                    $("#viewDataExpedienteURAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURAprobado").load("ur/data-aprobado");
                    $("#viewDataExpedienteURObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURObservado").load("ur/data-observado");
                    $("#viewDataExpedienteURArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURArchivado").load("ur/data-archivado");
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
                    $("#SubsanaObservacionURAlerts").css("display", "block");
                    $("#SubsanaObservacionURAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_SubsanaObservacionUR_Enabled").css("display", "block");
                    $("#Footer_SubsanaObservacionUR_Disabled").css("display", "none");
                }
            });
        });
        //#11. Muestro el formulario para Archivar los expedientes
        $('#modalArchivaExpedienteUR').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormArchivaExpedienteUR').load('ur/' + idExpediente + '/archivo');
        });
        //#12. Proceso la observacion del expediente
        $(document).on("click", '#btnArchivaExpedienteUR', function (event) {
            event.preventDefault();
            var form = $("#FormArchivaExpedienteUR");
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
                    $("#Footer_ArchivaExpedienteUR_Enabled").css("display", "none");
                    $("#Footer_ArchivaExpedienteUR_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ArchivaExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_ArchivaExpedienteUR_Disabled").css("display", "none");
                    $("#modalArchivaExpedienteUR").modal('hide');
                    $("#viewDataExpedienteUR").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUR").load("ur/data-pendiente");
                    $("#viewDataExpedienteURAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURAprobado").load("ur/data-aprobado");
                    $("#viewDataExpedienteURObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURObservado").load("ur/data-observado");
                    $("#viewDataExpedienteURArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteURArchivado").load("ur/data-archivado");
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
                    $("#ExpedienteURAlerts").css("display", "block");
                    $("#ExpedienteURAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ArchivaExpedienteUR_Enabled").css("display", "block");
                    $("#Footer_ArchivaExpedienteUR_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop