@extends('layouts.template')
@section('title', 'Resoluciones Ministeriales')
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
                                <ul class="nav nav-tabs" id="TabProcesoRm" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabProcesoRm001" data-toggle="pill" href="#custom-tabs-rm-pendiente" role="tab" aria-controls="custom-tabs-rm-pendiente" aria-selected="true">1. Pendientes</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabProcesoRm002" data-toggle="pill" href="#custom-tabs-rm-aprobado" role="tab" aria-controls="custom-tabs-rm-aprobado" aria-selected="false">2. Emitidas</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabProcesoRmContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-rm-pendiente" role="tabpanel" aria-labelledby="TabProcesoRm001">
                                        <div id="viewDataExpedienteRm" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-rm-aprobado" role="tabpanel" aria-labelledby="TabProcesoRm002">
                                        <div id="viewDataRm" class="table-responsive"></div>
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
<div class="modal fade" id="modalCreateRm">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div id="divFormCreateRm">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
    </div> 
</div>
{{-- Modal para la edición de registros --}}
<div class="modal fade" id="modalUpdateRm">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div id="divFormUpdateRm">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //#1. Obtengo los datos correspondientes
        $("#viewDataExpedienteRm").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedienteRm").load("rm/data");
        $("#viewDataRm").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataRm").load("rm/data-rm");
        //#2.- Modal para crear un nuevo registro
        $('#modalCreateRm').on('show.bs.modal', function (e) {
            var idExpediente = $(e.relatedTarget).attr('data-id');
            $('#divFormCreateRm').load("rm/"+idExpediente+"/create");
        });
        $('#modalUpdateRm').on('show.bs.modal', function (e) {
            var idRM = $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateRm').load("rm/"+idRM+"/edit");
        });
        //#3.- Proceso los registros generados
        $(document).on("click", '#btnCreateRm', function (event) {
            event.preventDefault();
            var form = $("#FormCreateRm");
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
                    $("#Footer_CreateRm_Enabled").css("display", "none");
                    $("#Footer_CreateRm_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateRm_Enabled").css("display", "block");
                    $("#Footer_CreateRm_Disabled").css("display", "none");
                    $("#modalCreateRm").modal('hide');
                    $("#viewDataExpedienteRm").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExpedienteRm").load("rm/data");
                    $("#viewDataRm").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataRm").load("rm/data-rm");
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
                    $("#CreateRmAlerts").css("display", "block");
                    $("#CreateRmAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateRm_Enabled").css("display", "block");
                    $("#Footer_CreateRm_Disabled").css("display", "none");
                }
            });
        });





    });
</script>
@stop