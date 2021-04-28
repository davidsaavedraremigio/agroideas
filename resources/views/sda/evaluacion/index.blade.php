@extends('layouts.template')
@section('title', 'Módulo para la evaluación de Solicitudes de apoyo - UN')
@section('content')
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="TabProcesoUn" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProcesoUn001" data-toggle="pill" href="#custom-tabs-proceso-pendiente" role="tab" aria-controls="custom-tabs-proceso-pendiente" aria-selected="true">1. En proceso</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUn002" data-toggle="pill" href="#custom-tabs-proceso-aprobado" role="tab" aria-controls="custom-tabs-proceso-aprobado" aria-selected="false">2. Con opinión favorable</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUn003" data-toggle="pill" href="#custom-tabs-proceso-observado" role="tab" aria-controls="custom-tabs-proceso-observado" aria-selected="false">3. Observado</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUn004" data-toggle="pill" href="#custom-tabs-proceso-archivado" role="tab" aria-controls="custom-tabs-proceso-archivado" aria-selected="false">4. Con opinión No favorable</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoUnContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-proceso-pendiente" role="tabpanel" aria-labelledby="TabProcesoUn001">
                                        <div id="viewDataExpedienteUn" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-aprobado" role="tabpanel" aria-labelledby="TabProcesoUn002">
                                        <div id="viewDataExpedienteUnAprobado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-observado" role="tabpanel" aria-labelledby="TabProcesoUn003">
                                        <div id="viewDataExpedienteUnObservado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-archivado" role="tabpanel" aria-labelledby="TabProcesoUn004">
                                        <div id="viewDataExpedienteUnArchivado" class="table-responsive"></div>
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
<div class="modal fade" id="modalCreateExpedienteUn">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateExpedienteUn">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 
{{-- Modal para la observacion de registros --}}
<div class="modal fade" id="modalObservaExpedienteUn">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormObservaExpedienteUn">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 
{{-- Modal para la derivacion de registros --}}
<div class="modal fade" id="modalDerivaExpedienteUn">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormDerivaExpedienteUn">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 
{{-- Modal para la observación de registros --}}    
<div class="modal fade" id="modalArchivaExpedienteUn">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormArchivaExpedienteUn">
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
        //1. Cargo la info de los paneles
        $("#viewDataExpedienteUn").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUn").load("evaluacion/data-pendiente");
        $("#viewDataExpedienteUnAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUnAprobado").load("evaluacion/data-aprobado");
        $("#viewDataExpedienteUnObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUnObservado").load("evaluacion/data-observado");
        $("#viewDataExpedienteUnArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUnArchivado").load("evaluacion/data-archivado");

        //2. muestro el modal para asignar un expediente
        $('#modalCreateExpedienteUn').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormCreateExpedienteUn').load("evaluacion/"+idExpediente+"/create");
        });
        $(document).on("click", '#btnCreateExpedienteUn', function (event) {
            event.preventDefault();
            var form = $("#FormCreateExpedienteUn");
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
                    $("#Footer_CreateExpedienteUn_Enabled").css("display", "none");
                    $("#Footer_CreateExpedienteUn_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateExpedienteUn_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUn_Disabled").css("display", "none");
                    $("#modalCreateExpedienteUn").modal('hide');
                    $("#viewDataExpedienteUn").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUn").load("evaluacion/data-pendiente");
                    $("#viewDataExpedienteUnAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnAprobado").load("evaluacion/data-aprobado");
                    $("#viewDataExpedienteUnObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnObservado").load("evaluacion/data-observado");
                    $("#viewDataExpedienteUnArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnArchivado").load("evaluacion/data-archivado");
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
                    $("#ExpedienteUnAlerts").css("display", "block");
                    $("#ExpedienteUnAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateExpedienteUn_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUn_Disabled").css("display", "none");
                }
            });
        });
        //3. muestro el modal para archivar un expediente
        $('#modalArchivaExpedienteUn').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormArchivaExpedienteUn').load("evaluacion/"+idExpediente+"/archivo");
        });
        $(document).on("click", '#btnArchivaExpedienteUn', function (event) {
            event.preventDefault();
            var form = $("#FormArchivaExpedienteUn");
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
                    $("#Footer_ArchivaExpedienteUn_Enabled").css("display", "none");
                    $("#Footer_ArchivaExpedienteUn_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ArchivaExpedienteUn_Enabled").css("display", "block");
                    $("#Footer_ArchivaExpedienteUn_Disabled").css("display", "none");
                    $("#modalArchivaExpedienteUn").modal('hide');
                    $("#viewDataExpedienteUn").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUn").load("evaluacion/data-pendiente");
                    $("#viewDataExpedienteUnAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnAprobado").load("evaluacion/data-aprobado");
                    $("#viewDataExpedienteUnObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnObservado").load("evaluacion/data-observado");
                    $("#viewDataExpedienteUnArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnArchivado").load("evaluacion/data-archivado");
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
                    $("#ArchivaExpedienteUnAlerts").css("display", "block");
                    $("#ArchivaExpedienteUnAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ArchivaExpedienteUn_Enabled").css("display", "block");
                    $("#Footer_ArchivaExpedienteUn_Disabled").css("display", "none");
                }
            });
        });
        //4. muestro el modal para derivar un expediente
        $('#modalDerivaExpedienteUn').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormDerivaExpedienteUn').load("evaluacion/"+idExpediente+"/deriva");
        });
        $(document).on("click", '#btnDerivaExpedienteUn', function (event) {
            event.preventDefault();
            var form = $("#FormDerivaExpedienteUn");
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
                    $("#Footer_DerivaExpedienteUn_Enabled").css("display", "none");
                    $("#Footer_DerivaExpedienteUn_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_DerivaExpedienteUn_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUn_Disabled").css("display", "none");
                    $("#modalDerivaExpedienteUn").modal('hide');
                    $("#viewDataExpedienteUn").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUn").load("evaluacion/data-pendiente");
                    $("#viewDataExpedienteUnAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnAprobado").load("evaluacion/data-aprobado");
                    $("#viewDataExpedienteUnObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnObservado").load("evaluacion/data-observado");
                    $("#viewDataExpedienteUnArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUnArchivado").load("evaluacion/data-archivado");
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
                    $("#ExpedienteUnAlerts").css("display", "block");
                    $("#ExpedienteUnAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_DerivaExpedienteUn_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUn_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop