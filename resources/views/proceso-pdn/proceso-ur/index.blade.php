@extends('layouts.template')
@section('title', 'Módulo para la admisión de expedientes de Solicitudes de apoyo (SDA)')
@section('content')
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header bg-primary">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <a href="proceso-ur/create" class="btn btn-sm btn-info" title="Registrar un nuevo expediente"><i class="fas fa-plus-circle"></i><span> Añadir nuevo</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="TabProcesoSdaUr" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProcesoSdaUr001" data-toggle="pill" href="#custom-tabs-sda-proceso" role="tab" aria-controls="custom-tabs-sda-proceso" aria-selected="true">1. En proceso</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoSdaUr002" data-toggle="pill" href="#custom-tabs-sda-observado" role="tab" aria-controls="custom-tabs-sda-observado" aria-selected="false">2. Observado</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoSdaUr003" data-toggle="pill" href="#custom-tabs-sda-elegible" role="tab" aria-controls="custom-tabs-sda-elegible" aria-selected="false">3. Elegible</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoSdaUr004" data-toggle="pill" href="#custom-tabs-sda-improcedente" role="tab" aria-controls="custom-tabs-sda-improcedente" aria-selected="false">4. Improcedente</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoSdaUrContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-sda-proceso" role="tabpanel" aria-labelledby="TabProcesoSdaUr001">
                                        <div id="viewDataExpedienteProceso" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-sda-observado" role="tabpanel" aria-labelledby="TabProcesoSdaUr002">
                                        <div id="viewDataExpedienteObservado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-sda-elegible" role="tabpanel" aria-labelledby="TabProcesoSdaUr003">
                                        <div id="viewDataExpedienteElegible" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-sda-improcedente" role="tabpanel" aria-labelledby="TabProcesoSdaUr004">
                                        <div id="viewDataExpedienteImprocedente" class="table-responsive"></div>
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
{{-- Modal para observar un expediente --}}
<div class="modal fade" id="modalObservaExpediente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormObservaExpediente">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para declarar elegible un expediente --}}
<div class="modal fade" id="modalApruebaExpediente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormApruebaExpediente">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para declarar improcedente un expediente --}}
<div class="modal fade" id="modalDesapruebaExpediente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormDesapruebaExpediente">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

{{-- Término del contenido--}}
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            //1. Mostramos la información cargada
            $("#viewDataExpedienteProceso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataExpedienteProceso").load("proceso-ur/data");
            $("#viewDataExpedienteObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataExpedienteObservado").load("proceso-ur/data/observado");
            $("#viewDataExpedienteElegible").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataExpedienteElegible").load("proceso-ur/data/elegible");
            $("#viewDataExpedienteImprocedente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataExpedienteImprocedente").load("proceso-ur/data/improcedente");

            //2. Mostramos un modal para realizar observaciones
            $('#modalObservaExpediente').on('show.bs.modal', function (e) {
                var idExpediente = $(e.relatedTarget).attr('data-id');
                $('#divFormObservaExpediente').load('proceso-ur/' + idExpediente + '/observa');
            });
            $(document).on("click", '#btnObservaExpediente', function (event) {
                event.preventDefault();
                var form = $("#FormObservaExpediente");
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
                        $("#Footer_ObservaExpediente_Enabled").css("display", "none");
                        $("#Footer_ObservaExpediente_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_ObservaExpediente_Enabled").css("display", "block");
                        $("#Footer_ObservaExpediente_Disabled").css("display", "none");
                        $("#modalObservaExpediente").modal('hide');
                        $("#viewDataExpedienteProceso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteProceso").load("proceso-ur/data");
                        $("#viewDataExpedienteObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteObservado").load("proceso-ur/data/observado");
                        $("#viewDataExpedienteElegible").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteElegible").load("proceso-ur/data/elegible");
                        $("#viewDataExpedienteImprocedente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteImprocedente").load("proceso-ur/data/improcedente");
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
                        $("#ObservaExpedienteAlerts").css("display", "block");
                        $("#ObservaExpedienteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_ObservaExpediente_Enabled").css("display", "block");
                        $("#Footer_ObservaExpediente_Disabled").css("display", "none");
                    }
                });
            });

            //3. Mostramos un modal para declarar elegible un expediente
            $('#modalApruebaExpediente').on('show.bs.modal', function (e) {
                var idExpediente = $(e.relatedTarget).attr('data-id');
                $('#divFormApruebaExpediente').load('proceso-ur/' + idExpediente + '/elegible');
            });
            $(document).on("click", '#btnApruebaExpediente', function (event) {
                event.preventDefault();
                var form = $("#FormApruebaExpediente");
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
                        $("#Footer_ApruebaExpediente_Enabled").css("display", "none");
                        $("#Footer_ApruebaExpediente_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_ApruebaExpediente_Enabled").css("display", "block");
                        $("#Footer_ApruebaExpediente_Disabled").css("display", "none");
                        $("#modalApruebaExpediente").modal('hide');
                        $("#viewDataExpedienteProceso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteProceso").load("proceso-ur/data");
                        $("#viewDataExpedienteObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteObservado").load("proceso-ur/data/observado");
                        $("#viewDataExpedienteElegible").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteElegible").load("proceso-ur/data/elegible");
                        $("#viewDataExpedienteImprocedente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteImprocedente").load("proceso-ur/data/improcedente");
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
                        $("#ApruebaExpedienteAlerts").css("display", "block");
                        $("#ApruebaExpedienteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_ApruebaExpediente_Enabled").css("display", "block");
                        $("#Footer_ApruebaExpediente_Disabled").css("display", "none");
                    }
                });
            });
            

            //4. Mostramos un modal para declarar improcedente un expediente
            $('#modalDesapruebaExpediente').on('show.bs.modal', function (e) {
                var idExpediente = $(e.relatedTarget).attr('data-id');
                $('#divFormDesapruebaExpediente').load('proceso-ur/' + idExpediente + '/improcedente');
            });
            $(document).on("click", '#btnDesapruebaExpediente', function (event) {
                event.preventDefault();
                var form = $("#FormDesapruebaExpediente");
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
                        $("#Footer_DesapruebaExpediente_Enabled").css("display", "none");
                        $("#Footer_DesapruebaExpediente_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_DesapruebaExpediente_Enabled").css("display", "block");
                        $("#Footer_DesapruebaExpediente_Disabled").css("display", "none");
                        $("#modalDesapruebaExpediente").modal('hide');
                        $("#viewDataExpedienteProceso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteProceso").load("proceso-ur/data");
                        $("#viewDataExpedienteObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteObservado").load("proceso-ur/data/observado");
                        $("#viewDataExpedienteElegible").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteElegible").load("proceso-ur/data/elegible");
                        $("#viewDataExpedienteImprocedente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataExpedienteImprocedente").load("proceso-ur/data/improcedente");
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
                        $("#DesapruebaExpedienteAlerts").css("display", "block");
                        $("#DesapruebaExpedienteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_DesapruebaExpediente_Enabled").css("display", "block");
                        $("#Footer_DesapruebaExpediente_Disabled").css("display", "none");
                    }
                });
            });

        });
    </script>
@stop