@extends('layouts.template')
@section('title', 'Clasificación de etapas por tipo de compromiso')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateEtapa"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataEtapa" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal para la creación de registros --}}
    <div class="modal fade" id="modalCreateEtapa">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn ">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormCreateEtapa">
                    <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                    <span class="sr-only">Cargando...</span>
                </div>
                {{-- Fin del contenido del modal --}}
            </div>
        </div>		
    </div>
    {{-- Modal para la edición de registros --}}
    <div class="modal fade" id="modalUpdateEtapa">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeIn">
                {{-- Inicio del contenido del modal --}}
                <div id="divFormUpdateEtapa">
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
            $("#viewDataEtapa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataEtapa").load("etapa-compromiso/data");
            //#1.- Modal para crear un nuevo registro
            $('#modalCreateEtapa').on('show.bs.modal', function (e) {
                $('#divFormCreateEtapa').load("etapa-compromiso/create");
            });
            //#2.- Modal para editar registros
            $('#modalUpdateEtapa').on('show.bs.modal', function (e) {
                var codigo = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateEtapa').load('etapa-compromiso/' + codigo + '/edit');
            }); 
            //#3. Proceso el formulario de registro
            $(document).on("click", '#btnCreateEtapa', function (event) {
                event.preventDefault();
                var form = $("#FormCreateEtapa");
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
                        $("#Footer_CreateEtapa_Enabled").css("display", "none");
                        $("#Footer_CreateEtapa_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateEtapa_Enabled").css("display", "block");
                        $("#Footer_CreateEtapa_Disabled").css("display", "none");
                        $("#modalCreateEtapa").modal('hide');
                        $("#viewDataEtapa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataEtapa').load('etapa-compromiso/data');
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
                        $("#EtapaAlerts").css("display", "block");
                        $("#EtapaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateEtapa_Enabled").css("display", "block");
                        $("#Footer_CreateEtapa_Disabled").css("display", "none");
                    }
                });
            });
            //#4. Proceso la actualizacion del registro
            $(document).on("click", '#btnUpdateEtapa', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateEtapa");
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
                        $("#Footer_UpdateEtapa_Enabled").css("display", "none");
                        $("#Footer_UpdateEtapa_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateEtapa_Enabled").css("display", "block");
                        $("#Footer_UpdateEtapa_Disabled").css("display", "none");
                        $("#modalUpdateEtapa").modal('hide');
                        $("#viewDataEtapa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataEtapa').load('etapa-compromiso/data');
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
                        $("#EtapaAlerts").css("display", "block");
                        $("#EtapaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateEtapa_Enabled").css("display", "block");
                        $("#Footer_UpdateEtapa_Disabled").css("display", "none");
                    }
                });
            });
            //#5. Proceso la eliminacion de registros
            $(document).on("click", '.btnDeleteEtapa', function (event) {
                event.preventDefault();
                var codigo = $(this).data("id");
                var urlAction = 'etapa-compromiso/'+codigo;
                // Antes de procesar realizamos una confirmación del proceso
                alertify.confirm("Confirmación de envío de formulario", "¿Esta seguro de que desea eliminar este ítem?.",
                    function () {
                        $.ajax({
                            url: urlAction,
                            method: "DELETE",
                            data: codigo,
                            beforeSend: function () {},
                            success: function (response) {
                                var cadena = response;
                                var mensaje = cadena.mensaje;
                                alertify.alert("Proceso concluido", mensaje, function () {
                                    $("#viewDataEtapa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $('#viewDataEtapa').load('etapa-compromiso/data');
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
                        $("#viewDataEtapa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $('#viewDataEtapa').load('etapa-compromiso/data');
                    }
                );
            });
        });
    </script>
@stop
