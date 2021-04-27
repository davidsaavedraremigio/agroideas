@extends('layouts.template')
@section('title', 'Módulo para la gestión de carteras de PRPA')
@section('content')
{{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateCarteraPrp"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataCarteraPrp" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateCarteraPrp">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateCarteraPrp">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateCarteraPrp">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateCarteraPrp">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la asignación de Prp's --}}
    <div class="modal fade" id="modalAsignaPrp">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormAsignaPrp">
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
            $("#viewDataCarteraPrp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataCarteraPrp").load("cartera-prp/data");
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateCarteraPrp').on('show.bs.modal', function (e) {
                $('#divFormCreateCarteraPrp').load("cartera-prp/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateCarteraPrp').on('show.bs.modal', function (e) {
                var idCartera = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateCarteraPrp').load('cartera-prp/' + idCartera + '/edit');
            });
            //#3. Modal para asignar Incentivos
            $('#modalAsignaPrp').on('show.bs.modal', function (e) {
                var idCartera = $(e.relatedTarget).attr('data-id');
                $('#divFormAsignaPrp').load('cartera-prp/' + idCartera + '/asigna-prp');
            });
            //#4.- Procesamos el formulario para crear nuevos registros
            $(document).on("click", '#btnCreateCarteraPrp', function (event) {
                event.preventDefault();
                var form = $("#FormCreateCarteraPrp");
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
                        $("#Footer_CreateCarteraPrp_Enabled").css("display", "none");
                        $("#Footer_CreateCarteraPrp_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateCarteraPrp_Enabled").css("display", "block");
                        $("#Footer_CreateCarteraPrp_Disabled").css("display", "none");
                        $("#modalCreateCarteraPrp").modal('hide');
                        $("#viewDataCarteraPrp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataCarteraPrp').load('cartera-prp/data');
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
                        $("#AreaAlerts").css("display", "block");
                        $("#AreaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateArea_Enabled").css("display", "block");
                        $("#Footer_CreateArea_Disabled").css("display", "none");
                    }
                });
            });
            //#5.- Procesamos el formulario para actualizar registros
            $(document).on("click", '#btnUpdateCarteraPrp', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateCarteraPrp");
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
                        $("#Footer_UpdateCarteraPrp_Enabled").css("display", "none");
                        $("#Footer_UpdateCarteraPrp_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateCarteraPrp_Enabled").css("display", "block");
                        $("#Footer_UpdateCarteraPrp_Disabled").css("display", "none");
                        $("#modalUpdateCarteraPrp").modal('hide');
                        $("#viewDataCarteraPrp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataCarteraPrp').load('cartera-prp/data');
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
                        $("#CarteraPrpAlerts").css("display", "block");
                        $("#CarteraPrpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateCarteraPrp_Enabled").css("display", "block");
                        $("#Footer_UpdateCarteraPrp_Disabled").css("display", "none");
                    }
                });
            });
            //#5.- Procesamos el formulario para actualizar registros
            $(document).on("click", '#btnAsignaPrp', function (event) {
                event.preventDefault();
                var form = $("#FormAsignaPrp");
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
                        $("#Footer_AsignaPrp_Enabled").css("display", "none");
                        $("#Footer_AsignaPrp_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_AsignaPrp_Enabled").css("display", "block");
                        $("#Footer_AsignaPrp_Disabled").css("display", "none");
                        $("#modalAsignaPrp").modal('hide');
                        $("#viewDataCarteraPrp").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataCarteraPrp').load('cartera-prp/data');
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
                        $("#AsignaPrpAlerts").css("display", "block");
                        $("#AsignaPrpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_AsignaPrp_Enabled").css("display", "block");
                        $("#Footer_AsignaPrp_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop