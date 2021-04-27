@extends('layouts.template')
@section('title', 'Módulo para la revisión y procesamiento de Expedientes - DE')
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
                                <ul class="nav nav-tabs" id="TabProcesoUr" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProcesoUr001" data-toggle="pill" href="#custom-tabs-proceso-pendiente" role="tab" aria-controls="custom-tabs-proceso-pendiente" aria-selected="true">1. Pendientes</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUr002" data-toggle="pill" href="#custom-tabs-proceso-aprobado" role="tab" aria-controls="custom-tabs-proceso-aprobado" aria-selected="false">2. Derivados</a></li>
                                    <!--<li class="nav-item"><a class="nav-link" id="TabProcesoUr003" data-toggle="pill" href="#custom-tabs-proceso-desaprobado" role="tab" aria-controls="custom-tabs-proceso-desaprobado" aria-selected="false">3. Desaprobado</a></li>-->
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoUrContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-proceso-pendiente" role="tabpanel" aria-labelledby="TabProcesoUr001">
                                        <div id="viewDataExpedienteDe" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-aprobado" role="tabpanel" aria-labelledby="TabProcesoUr002">
                                        <div id="viewDataExpedienteDeAprobado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-desaprobado" role="tabpanel" aria-labelledby="TabProcesoUr003">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis corporis esse est, sequi deleniti atque rerum, qui nam fugit veritatis exercitationem amet ratione blanditiis, dolores dicta eos? Eaque, minima laudantium?
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
    <div class="modal fade" id="modalCreateExpedienteDe">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateExpedienteDe">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div> 
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalMonitoreoExpediente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormMonitoreoExpediente">
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
        var tipo    = 2;
        var area    = 1;
        $("#viewDataExpedienteDe").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteDe").load("de/"+area+"/"+tipo+"/data");
        $("#viewDataExpedienteDeAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteDeAprobado").load("de/"+area+"/"+tipo+"/documento");
        //#1.- Modal para crear un nuevo registro
        $('#modalCreateExpedienteDe').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormCreateExpedienteDe').load("de/"+idExpediente+"/create");
        });
        //#2 Proceso el formulario de registro
        $(document).on("click", '#btnCreateExpedienteDe', function (event) {
            event.preventDefault();
            var form = $("#FormCreateExpedienteDe");
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
                    $("#Footer_CreateExpedienteDe_Enabled").css("display", "none");
                    $("#Footer_CreateExpedienteDe_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateExpedienteDe_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteDe_Disabled").css("display", "none");
                    $("#modalCreateExpedienteDe").modal('hide');
                    $("#viewDataExpedienteDe").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteDe").load("de/"+area+"/"+tipo+"/data");
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
                    $("#ExpedienteDeAlerts").css("display", "block");
                    $("#ExpedienteDeAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateExpedienteDe_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteDe_Disabled").css("display", "none");
                }
            });
        });
        //#3. Muestro el historial del proceso
        $('#modalMonitoreoExpediente').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormMonitoreoExpediente').load("ur/"+idExpediente+"/monitoreo");
        });
    });
</script>
@stop