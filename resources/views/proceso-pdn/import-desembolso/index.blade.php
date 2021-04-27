@extends('layouts.template')
@section('title', 'Módulo para la carga masiva de información de desembolsos de Solicitudes de apoyo (SDA)')
@section('content')
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header bg-primary">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-sm btn-info" title="Cargar información de desembolso"  data-toggle="modal" data-target="#modalImportDesembolsoSda"><i class="fas fa-upload"></i><span> Importar información</span></a>
                    <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalDeleteDesembolsoSda"><i class="fa fa-trash"></i> <span> Eliminar información</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div id="viewDataImportDesembolsoSda" class="table-responsive"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Modal para la Importación de registos --}}
<div class="modal fade" id="modalImportDesembolsoSda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormImportDesembolsoSda">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la eliminación de registos --}}
<div class="modal fade" id="modalDeleteDesembolsoSda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormDeleteDesembolsoSda">
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
            //1. Obtengo la información de eventos registrados
            $("#viewDataImportDesembolsoSda").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataImportDesembolsoSda").load("import-desembolso/data");
            //#2.- Modal para la importación de nuevos registros
            $('#modalImportDesembolsoSda').on('show.bs.modal', function (e) {
                $('#divFormImportDesembolsoSda').load("import-desembolso/create");
            });
            //#3.- Procesamos el formulario para crear nuevos registros
            $(document).on("click", '#btnImportDesembolsoSda', function (event) {
                event.preventDefault();
                var form = $("#FormImportDesembolsoSda");
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
                        $("#Footer_ImportDesembolsoSda_Enabled").css("display", "none");
                        $("#Footer_ImportDesembolsoSda_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.dato;
                        form[0].reset();
                        $("#Footer_ImportDesembolsoSda_Enabled").css("display", "block");
                        $("#Footer_ImportDesembolsoSda_Disabled").css("display", "none");
                        $("#modalImportDesembolsoSda").modal('hide');
                        $("#viewDataImportDesembolsoSda").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataImportDesembolsoSda").load("import-desembolso/data");
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
                        $("#ImportDesembolsoSdaAlerts").css("display", "block");
                        $("#ImportDesembolsoSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_ImportDesembolsoSda_Enabled").css("display", "block");
                        $("#Footer_ImportDesembolsoSda_Disabled").css("display", "none");
                    }
                });
            });
            //#5.- Modal para proceder a la deshabilitación de módulos
            $(document).on("click", '.btnDeleteImportDesembolsoSda', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'import-desembolso/'+codigo+'/destroy';
                // Antes de procesar realizamos una confirmación del proceso
                alertify.confirm("Confirmación de envío de formulario", "¿Esta seguro de que desea eliminar este ítem?.",
                    function () {
                        $.ajax({
                            url: urlAction,
                            method: "POST",
                            data: codigo,
                            beforeSend: function () {},
                            success: function (response) {
                                var cadena = response;
                                var mensaje = cadena.mensaje;
                                alertify.alert("Proceso concluido", mensaje, function () {
                                    $("#viewDataImportDesembolsoSda").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataImportDesembolsoSda").load("import-desembolso/data");
                                });
                            },
                            statusCode: {
                                404: function () {
                                    ertify.error('El sistema presenta problemas de funcionamiento.');
                                }
                            },
                            error: function (x, xs, xt) {
                                var errors = x.responseJSON;
                                var errorsHtml = '';
                                $.each(errors['errors'], function (index, value) {
                                    errorsHtml += '<ul>';
                                    errorsHtml += '<li>' + value + "</li>";
                                    errorsHtml += '</ul>';
                                });
                                alertify.alert("Error de validación", errorsHtml, function () {
                                    form[0].reset();
                                });
                            }
                        });
                    },
                    function () {
                        alertify.error('Proceso cancelado');
                        $("#viewDataImportDesembolsoSda").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataImportDesembolsoSda").load("import-desembolso/data");
                    }
                );
            });   
            //#6.- Modal para la eliminación de registros en bloque
            $('#modalDeleteDesembolsoSda').on('show.bs.modal', function (e) {
                $('#divFormDeleteDesembolsoSda').load("import-desembolso/delete");
            }); 
            //#7.- Procesamos el formulario para eliminar registros por lote
            $(document).on("click", '#btnDeleteDesembolsoSda', function (event) {
                event.preventDefault();
                var form = $("#FormDeleteDesembolsoSda");
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
                        $("#Footer_DeleteDesembolsoSda_Enabled").css("display", "none");
                        $("#Footer_DeleteDesembolsoSda_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.message;
                        form[0].reset();
                        $("#Footer_DeleteDesembolsoSda_Enabled").css("display", "block");
                        $("#Footer_DeleteDesembolsoSda_Disabled").css("display", "none");
                        $("#modalDeleteDesembolsoSda").modal('hide');
                        $("#viewDataImportDesembolsoSda").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataImportDesembolsoSda").load("import-desembolso/data");
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
                        $("#DeleteDesembolsoSdaAlerts").css("display", "block");
                        $("#DeleteDesembolsoSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_DeleteDesembolsoSda_Enabled").css("display", "block");
                        $("#Footer_DeleteDesembolsoSda_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop