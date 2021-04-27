@extends('layouts.template')
@section('title', 'Módulo para el registro de Consejos directivos')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header bg-primary">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalCreateCd"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataCd" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateCd">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateCd">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateCd">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateCd">
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
        $("#viewDataCd").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataCd").load("cd/data");

        //#1.- Modal para crear un nuevo registro
        $('#modalCreateCd').on('show.bs.modal', function (e) {
            $('#divFormCreateCd').load("cd/create");
        });

        //#2.- Modal para editar registros
        $('#modalUpdateCd').on('show.bs.modal', function (e) {
            var idCd = $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateCd').load('cd/' + idCd + '/edit');
        });

        //#3.- Procesamos el formulario para crear nuevos registros
        $(document).on("click", '#btnCreateCd', function (event) {
            event.preventDefault();
            var form = $("#FormCreateCd");
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
                    $("#Footer_CreateCd_Enabled").css("display", "none");
                    $("#Footer_CreateCd_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateCd_Enabled").css("display", "block");
                    $("#Footer_CreateCd_Disabled").css("display", "none");
                    $("#modalCreateCd").modal('hide');
                    $("#viewDataCd").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $('#viewDataCd').load('cd/data');
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
                    $("#CdAlerts").css("display", "block");
                    $("#CdAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateCd_Enabled").css("display", "block");
                    $("#Footer_CreateCd_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateCd', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateCd");
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
                    $("#Footer_UpdateCd_Enabled").css("display", "none");
                    $("#Footer_UpdateCd_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateCd_Enabled").css("display", "block");
                    $("#Footer_UpdateCd_Disabled").css("display", "none");
                    $("#modalUpdateCd").modal('hide');
                    $("#viewDataCd").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $('#viewDataCd').load('cd/data');
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
                    $("#CdAlerts").css("display", "block");
                    $("#CdAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateCd_Enabled").css("display", "block");
                    $("#Footer_UpdateCd_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop
