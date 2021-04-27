@extends('layouts.template')
@section('title', 'Módulo para la revisión de PRPA y opinión de UAJ')
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
                                <ul class="nav nav-tabs" id="TabProcesoUaj" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProcesoUaj001" data-toggle="pill" href="#custom-tabs-proceso-pendiente" role="tab" aria-controls="custom-tabs-proceso-pendiente" aria-selected="true">1. Pendientes</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUaj002" data-toggle="pill" href="#custom-tabs-proceso-aprobado" role="tab" aria-controls="custom-tabs-proceso-aprobado" aria-selected="false">2. Enviados a Midagri</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoUaj003" data-toggle="pill" href="#custom-tabs-proceso-observado" role="tab" aria-controls="custom-tabs-proceso-observado" aria-selected="false">3. Observados</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoUajContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-proceso-pendiente" role="tabpanel" aria-labelledby="TabProcesoUaj001">
                                        <div id="viewDataExpedienteUaj" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-aprobado" role="tabpanel" aria-labelledby="TabProcesoUaj002">
                                        <div id="viewDataExpedienteUajAprobado" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-proceso-observado" role="tabpanel" aria-labelledby="TabProcesoUaj003">
                                        <div id="viewDataExpedienteUajObservado" class="table-responsive"></div>
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
<div class="modal fade" id="modalCreateExpedienteUaj">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateExpedienteUaj">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 
{{-- Modal para la derivacion de registros --}}
<div class="modal fade" id="modalEvaluaExpedienteUaj">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormEvaluaExpedienteUaj">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 
{{-- Modal para la observación de registros --}}    
<div class="modal fade" id="modalObservaExpedienteUaj">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormObservaExpedienteUaj">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la derivacion de registros --}}
<div class="modal fade" id="modalDerivaExpedienteUaj">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormDerivaExpedienteUaj">
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
        $("#viewDataExpedienteUaj").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUaj").load("uaj/data-pendiente");
        $("#viewDataExpedienteUajAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUajAprobado").load("uaj/data-aprobado");
        $("#viewDataExpedienteUajObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteUajObservado").load("uaj/data-observado");
        //#1.- Modal para crear un nuevo registro
        $('#modalCreateExpedienteUaj').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormCreateExpedienteUaj').load("uaj/"+idExpediente+"/create");
        });
        $(document).on("click", '#btnCreateExpedienteUaj', function (event) {
            event.preventDefault();
            var form = $("#FormCreateExpedienteUaj");
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
                    $("#Footer_CreateExpedienteUaj_Enabled").css("display", "none");
                    $("#Footer_CreateExpedienteUaj_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUaj_Disabled").css("display", "none");
                    $("#modalCreateExpedienteUaj").modal('hide');
                    $("#viewDataExpedienteUaj").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUaj").load("uaj/data-pendiente");
                    $("#viewDataExpedienteUajAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajAprobado").load("uaj/data-aprobado");
                    $("#viewDataExpedienteUajObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajObservado").load("uaj/data-observado");
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
                    $("#ExpedienteUajAlerts").css("display", "block");
                    $("#ExpedienteUajAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_CreateExpedienteUaj_Disabled").css("display", "none");
                }
            });
        });
        //#2. Modal para derivar el expediente
        $('#modalEvaluaExpedienteUaj').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormEvaluaExpedienteUaj').load('uaj/' + idExpediente + '/califica');
        });
        $(document).on("click", '#btnEvaluaExpedienteUaj', function (event) {
            event.preventDefault();
            var form = $("#FormEvaluaExpedienteUaj");
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
                    $("#Footer_EvaluaExpedienteUaj_Enabled").css("display", "none");
                    $("#Footer_EvaluaExpedienteUaj_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_EvaluaExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_EvaluaExpedienteUaj_Disabled").css("display", "none");
                    $("#modalEvaluaExpedienteUaj").modal('hide');
                    $("#viewDataExpedienteUaj").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUaj").load("uaj/data-pendiente");
                    $("#viewDataExpedienteUajAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajAprobado").load("uaj/data-aprobado");
                    $("#viewDataExpedienteUajObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajObservado").load("uaj/data-observado");
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
                    $("#ExpedienteUajAlerts").css("display", "block");
                    $("#ExpedienteUajAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_EvaluaExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_EvaluaExpedienteUaj_Disabled").css("display", "none");
                }
            });
        });
        //#3. Muestro el formulario para observar los expedientes
        $('#modalObservaExpedienteUaj').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormObservaExpedienteUaj').load('uaj/' + idExpediente + '/observa');
        });
        $(document).on("click", '#btnObservaExpedienteUaj', function (event) {
            event.preventDefault();
            var form = $("#FormObservaExpedienteUaj");
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
                    $("#Footer_ObservaExpedienteUaj_Enabled").css("display", "none");
                    $("#Footer_ObservaExpedienteUaj_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_ObservaExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_ObservaExpedienteUaj_Disabled").css("display", "none");
                    $("#modalObservaExpedienteUaj").modal('hide');
                    $("#viewDataExpedienteUaj").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUaj").load("uaj/data-pendiente");
                    $("#viewDataExpedienteUajAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajAprobado").load("uaj/data-aprobado");
                    $("#viewDataExpedienteUajObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajObservado").load("uaj/data-observado");
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
                    $("#ObservaExpedienteUajAlerts").css("display", "block");
                    $("#ObservaExpedienteUajAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_ObservaExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_ObbservaExpedienteUaj_Disabled").css("display", "none");
                }
            });
        });
        //#4. Muestro el formulario para derivar los expedientes
        $('#modalDerivaExpedienteUaj').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormDerivaExpedienteUaj').load('uaj/' + idExpediente + '/deriva');
        });
        $(document).on("click", '#btnDerivaExpedienteUaj', function (event) {
            event.preventDefault();
            var form = $("#FormDerivaExpedienteUaj");
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
                    $("#Footer_DerivaExpedienteUaj_Enabled").css("display", "none");
                    $("#Footer_DerivaExpedienteUaj_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_DerivaExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUaj_Disabled").css("display", "none");
                    $("#modalDerivaExpedienteUaj").modal('hide');
                    $("#viewDataExpedienteUaj").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUaj").load("uaj/data-pendiente");
                    $("#viewDataExpedienteUajAprobado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajAprobado").load("uaj/data-aprobado");
                    $("#viewDataExpedienteUajObservado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteUajObservado").load("uaj/data-observado");
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
                    $("#DerivaExpedienteUajAlerts").css("display", "block");
                    $("#DerivaExpedienteUajAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_DerivaExpedienteUaj_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUaj_Disabled").css("display", "none");
                }
            });
        });



    });
</script>
@stop