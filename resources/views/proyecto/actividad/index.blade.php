@extends('layouts.template')
@section('title', 'Módulo para el mantenimiento de actividades por Proyecto')
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
                    <div id="viewDataSP" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para el mantenimiento de Actividades --}}
    <div class="modal fade" id="modalCreateActividad">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateActividad">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    <div class="modal fade" id="modalDataActividad">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormDataActividad">
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
            $("#viewDataSP").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataSP").load(route("actividad.data-sp"));
            $('#modalCreateActividad').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormCreateActividad').load(route("actividad.create", codigo));
            });
            $('#modalDataActividad').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormDataActividad').load(route("actividad.data", codigo));
            });
            //#3.- Procesamos el formulario para crear nuevos registros
            $(document).on("click", '#btnCreateActividad', function (event) {
                event.preventDefault();
                var form = $("#FormCreateActividad");
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
                        $("#Footer_CreateActividad_Enabled").css("display", "none");
                        $("#Footer_CreateActividad_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.dato;
                        form[0].reset();
                        $("#Footer_CreateActividad_Enabled").css("display", "block");
                        $("#Footer_CreateActividad_Disabled").css("display", "none");
                        $("#modalCreateActividad").modal('hide');
                        $("#viewDataSP").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataSP").load(route("actividad.data-sp"));
                        alertify.success('Se importaron ('+mensaje+') registros.');
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
                        $("#ActividadAlerts").css("display", "block");
                        $("#ActividadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateActividad_Enabled").css("display", "block");
                        $("#Footer_CreateActividad_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop