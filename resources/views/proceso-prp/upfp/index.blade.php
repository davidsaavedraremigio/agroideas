@extends('layouts.template')
@section('title', 'Evaluación Técnica')
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
                                <ul class="nav nav-tabs" id="TabProcesoUr" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProceso001" data-toggle="pill" href="#custom-tabs-proceso-pendiente" role="tab" aria-controls="custom-tabs-proceso-pendiente" aria-selected="true">1. Pendientes</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProceso002" data-toggle="pill" href="#custom-tabs-proceso-aprobado" role="tab" aria-controls="custom-tabs-proceso-aprobado" aria-selected="false">2. Aprobados</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProceso003" data-toggle="pill" href="#custom-tabs-proceso-observado" role="tab" aria-controls="custom-tabs-proceso-observado" aria-selected="false">3. Observados</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProceso004" data-toggle="pill" href="#custom-tabs-proceso-desaprobado" role="tab" aria-controls="custom-tabs-proceso-desaprobado" aria-selected="false">4. Archivados</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoUrContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-proceso-pendiente" role="tabpanel" aria-labelledby="TabProceso001">
                                        <div id="viewDataExpedienteUpfp" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-aprobado" role="tabpanel" aria-labelledby="TabProceso002">
                                        <div id="viewDataExpedienteUpfpAprobado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-observado" role="tabpanel" aria-labelledby="TabProceso003">
                                        <div id="viewDataExpedienteUpfpObservado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-desaprobado" role="tabpanel" aria-labelledby="TabProceso004">
                                        <div id="viewDataExpedienteUpfpArchivado" class="table-responsive"></div>
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
{{-- Modal para la admisión de un expediente --}}
<div class="modal fade" id="modalAdmiteExpedienteUpfp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormAdmiteExpedienteUpfp">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateExpedienteUpfp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateExpedienteUpfp">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 
{{-- Modal para la derivacion de registros --}}
<div class="modal fade" id="modalDerivaExpedienteUpfp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormDerivaExpedienteUpfp">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 
{{-- Modal para la observación de registros --}}    
<div class="modal fade" id="modalObservaExpedienteUpfp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormObservaExpedienteUpfp">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para el archivamiento de registros --}}
<div class="modal fade" id="modalArchivaExpedienteUpfp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormArchivaExpedienteUpfp">
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

        $("#viewDataExpedienteUpfp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUpfp").load("upfp/data-pendiente");
        $("#viewDataExpedienteUpfpAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUpfpAprobado").load("upfp/data-aprobado");
        $("#viewDataExpedienteUpfpObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUpfpObservado").load("upfp/data-observado");
        $("#viewDataExpedienteUpfpArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUpfpArchivado").load("upfp/data-archivado");
        //#1.- Modal para admitir un expediente
        $('#modalAdmiteExpedienteUpfp').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormAdmiteExpedienteUpfp').load("upfp/"+idExpediente+"/admision");
        });
        //#2. Proceso la admisión del expediente
        $(document).on("click", '#btnAdmiteExpedienteUPFP', function (event) {
            event.preventDefault();
            var form = $("#FormAdmiteExpedienteUPFP");
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
                    $("#Footer_AdmiteExpedienteUPFP_Enabled").css("display", "none");
                    $("#Footer_AdmiteExpedienteUPFP_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_AdmiteExpedienteUPFP_Enabled").css("display", "block");
                    $("#Footer_AdmiteExpedienteUPFP_Disabled").css("display", "none");
                    $("#modalAdmiteExpedienteUpfp").modal('hide');
                    $("#viewDataExpedienteUpfp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfp").load("upfp/data-pendiente");
                    $("#viewDataExpedienteUpfpAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpAprobado").load("upfp/data-aprobado");
                    $("#viewDataExpedienteUpfpObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpObservado").load("upfp/data-observado");
                    $("#viewDataExpedienteUpfpArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpArchivado").load("upfp/data-archivado");
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
                    $("#AdmiteExpedienteUPFPAlerts").css("display", "block");
                    $("#AdmiteExpedienteUPFPAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_AdmiteExpedienteUPFP_Enabled").css("display", "block");
                    $("#Footer_AdmiteExpedienteUPFP_Disabled").css("display", "none");
                }
            });
        });
        //#3.- Modal para crear un nuevo registro
        $('#modalCreateExpedienteUpfp').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormCreateExpedienteUpfp').load("upfp/"+idExpediente+"/create");
        });
        //#4 Proceso el formulario de registro
        $(document).on("click", '#btnCreateExpedienteUpfp', function (event) {
            event.preventDefault();
            var form = $("#FormCreateExpedienteUpfp");
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
                    $("#Footer_CreateExpedienteUpfp_Enabled").css("display", "none");
                    $("#Footer_CreateExpedienteUpfp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUpfp_Disabled").css("display", "none");
                    $("#modalCreateExpedienteUpfp").modal('hide');
                    $("#viewDataExpedienteUpfp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfp").load("upfp/data-pendiente");
                    $("#viewDataExpedienteUpfpAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpAprobado").load("upfp/data-aprobado");
                    $("#viewDataExpedienteUpfpObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpObservado").load("upfp/data-observado");
                    $("#viewDataExpedienteUpfpArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpArchivado").load("upfp/data-archivado");
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
                    $("#ExpedienteUpfpAlerts").css("display", "block");
                    $("#ExpedienteUpfpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUpfp_Disabled").css("display", "none");
                }
            });
        });
        //#3. Modal para derivar el expediente
        $('#modalDerivaExpedienteUpfp').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormDerivaExpedienteUpfp').load('upfp/' + idExpediente + '/informe');
        });
        //#4 Proceso el formulario de registro
        $(document).on("click", '#btnDerivaExpedienteUpfp', function (event) {
            event.preventDefault();
            var form = $("#FormDerivaExpedienteUpfp");
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
                    $("#Footer_DerivaExpedienteUpfp_Enabled").css("display", "none");
                    $("#Footer_DerivaExpedienteUpfp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_DerivaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUpfp_Disabled").css("display", "none");
                    $("#modalDerivaExpedienteUpfp").modal('hide');
                    $("#viewDataExpedienteUpfp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfp").load("upfp/data-pendiente");
                    $("#viewDataExpedienteUpfpAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpAprobado").load("upfp/data-aprobado");
                    $("#viewDataExpedienteUpfpObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpObservado").load("upfp/data-observado");
                    $("#viewDataExpedienteUpfpArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpArchivado").load("upfp/data-archivado");
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
                    $("#ExpedienteUpfpAlerts").css("display", "block");
                    $("#ExpedienteUpfpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_DerivaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUpfp_Disabled").css("display", "none");
                }
            });
        });
        //#5. Muestro el formulario para observar los expedientes
        $('#modalObservaExpedienteUpfp').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormObservaExpedienteUpfp').load('upfp/' + idExpediente + '/observa');
        });
        //#6. Proceso el formulario para observar expedientes
        $(document).on("click", '#btnObservaExpedienteUpfp', function (event) {
            event.preventDefault();
            var form = $("#FormObservaExpedienteUpfp");
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
                    $("#Footer_ObservaExpedienteUpfp_Enabled").css("display", "none");
                    $("#Footer_ObservaExpedienteUpfp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ObservaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_ObservaExpedienteUpfp_Disabled").css("display", "none");
                    $("#modalObservaExpedienteUpfp").modal('hide');
                    $("#viewDataExpedienteUpfp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfp").load("upfp/data-pendiente");
                    $("#viewDataExpedienteUpfpAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpAprobado").load("upfp/data-aprobado");
                    $("#viewDataExpedienteUpfpObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpObservado").load("upfp/data-observado");
                    $("#viewDataExpedienteUpfpArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpArchivado").load("upfp/data-archivado");
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
                    $("#ObservaExpedienteUpfpAlerts").css("display", "block");
                    $("#ObservaExpedienteUpfpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ObservaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_ObservaExpedienteUpfp_Disabled").css("display", "none");
                }
            });
        });
        //#7.- Modal para archivar un registro
        $('#modalArchivaExpedienteUpfp').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormArchivaExpedienteUpfp').load("upfp/"+idExpediente+"/archiva");
        });
        //#8. Proceso el proceso de archivamiento de expedientes
        $(document).on("click", '#btnArchivaExpedienteUpfp', function (event) {
            event.preventDefault();
            var form = $("#FormArchivaExpedienteUpfp");
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
                    $("#Footer_ArchivaExpedienteUpfp_Enabled").css("display", "none");
                    $("#Footer_ArchivaExpedienteUpfp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ArchivaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_ArchivaExpedienteUpfp_Disabled").css("display", "none");
                    $("#modalArchivaExpedienteUpfp").modal('hide');
                    $("#viewDataExpedienteUpfp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfp").load("upfp/data-pendiente");
                    $("#viewDataExpedienteUpfpAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpAprobado").load("upfp/data-aprobado");
                    $("#viewDataExpedienteUpfpObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpObservado").load("upfp/data-observado");
                    $("#viewDataExpedienteUpfpArchivado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUpfpArchivado").load("upfp/data-archivado");
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
                    $("#ArchivaExpedienteUpfpAlerts").css("display", "block");
                    $("#ArchivaExpedienteUpfpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ArchivaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_ArchivaExpedienteUpfp_Disabled").css("display", "none");
                }
            });
        });





    });
</script>
@stop