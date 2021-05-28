@extends('layouts.template')
@section('title', 'Módulo Información general del Proyecto')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabProyecto" role="tablist" data-id="{{$proyecto->id}}">
                    <li class="nav-item"><a class="nav-link active" id="TabProyecto001" data-toggle="pill" href="#custom-tabs-proyecto" role="tab" aria-controls="custom-tabs-proyecto" aria-selected="true">1. Información general</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabProyecto002" data-toggle="pill" href="#custom-tabs-productor" role="tab" aria-controls="custom-tabs-productor" aria-selected="false">2. Productores</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabProyecto003" data-toggle="pill" href="#custom-tabs-campo" role="tab" aria-controls="custom-tabs-campo" aria-selected="false">3. Verificación de campo</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabProyecto004" data-toggle="pill" href="#custom-tabs-balance" role="tab" aria-controls="custom-tabs-balance" aria-selected="false">4. Balance hídrico</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabProyecto005" data-toggle="pill" href="#custom-tabs-final" role="tab" aria-controls="custom-tabs-final" aria-selected="false">5. Resultado final</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabProyectoContent">
                    <div class="tab-pane fade show active" id="custom-tabs-proyecto" role="tabpanel" aria-labelledby="TabProyecto001">
                        {!!Form::model($proyecto,['id'=>'FormUpdateProyecto', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['proyecto-prpa.update',$proyecto->id]])!!}
                        {{-- Panel para mostrar alertas --}}
                        <div id="ProyectoAlerts" class="alert alert-danger" style="display: none;"></div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-productor" role="tabpanel" aria-labelledby="TabProyecto002">
                        {{-- Contenido del módulo Indicadores - Linea de base --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Productores que conforman el Proyecto de Reconversión Productiva</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateProductor"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataProductor" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Indicadores - Linea de base --}}  
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-campo" role="tabpanel" aria-labelledby="TabProyecto003">
                        {{-- Contenido del módulo evaluacion final --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Resultados de la evaluación de campo</h3>
                                        <div class="card-tools">
                                            <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateResultado"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataEvaluacionCampo" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo evaluacion final --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-balance" role="tabpanel" aria-labelledby="TabProyecto004">
                        {{-- Contenido del módulo evaluacion final --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Resultado balance hídrico</h3>
                                        <div class="card-tools">
                                            <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateResultado"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataBalanceHidrico" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo evaluacion final --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-final" role="tabpanel" aria-labelledby="TabProyecto005">
                        {{-- Contenido del módulo evaluacion final --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Resultado final por productor</h3>
                                        <div class="card-tools">
                                            <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateResultado"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataResultadoFinal" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo evaluacion final --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- Modals para el mantenimiento de Productores --}}
<div class="modal fade" id="modalCreateProductor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateProductor">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateProductor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateProductor">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateEvaluacionCampo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateEvaluacionCampo">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateBalanceHidrico">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateBalanceHidrico">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateResultadoFinal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateResultadoFinal">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>


{{-- Término del contenido --}}
@stop
@section('scripts')
<script>
    $(document).ready(function () 
    {
        var codPostulante       =   $("#viewDataProductor").attr('data-id');
        //1. Muestro los cuadros con datos
        $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataProductor").load(route("socio.data", codPostulante));
        $("#viewDataEvaluacionCampo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataEvaluacionCampo").load(route("socio.data-campo", codPostulante));
        $("#viewDataBalanceHidrico").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataBalanceHidrico").load(route("socio.data-hidrico", codPostulante));
        $("#viewDataResultadoFinal").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataResultadoFinal").load(route("socio.data-resultado", codPostulante));
        //2. Cargo los modals para crear y editar registros
        $('#modalCreateProductor').on('show.bs.modal', function (e) {
            $('#divFormCreateProductor').load(route("socio.create", codPostulante));
        });
        $('#modalUpdateProductor').on('show.bs.modal', function (e) {
            var codProductor= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateProductor').load(route("socio.edit", codProductor));
        });
        $('#modalUpdateEvaluacionCampo').on('show.bs.modal', function (e) {
            var codProductorCampo= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateEvaluacionCampo').load(route("socio.edit-campo", codProductorCampo));
        });
        $('#modalUpdateBalanceHidrico').on('show.bs.modal', function (e) {
            var codProductorH= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateBalanceHidrico').load(route("socio.edit-hidrico", codProductorH));
        });
        $('#modalUpdateResultadoFinal').on('show.bs.modal', function (e) {
            var codProductor= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateResultadoFinal').load(route("socio.edit-resultado", codProductor));
        });
        //3. Realizo el procesamiento del formulario
        $(document).on("click", '#btnCreateProductor', function (event) {
            event.preventDefault();
            var form = $("#FormCreateProductor");
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
                    $("#Footer_CreateProductor_Enabled").css("display", "none");
                    $("#Footer_CreateProductor_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateProductor_Enabled").css("display", "block");
                    $("#Footer_CreateProductor_Disabled").css("display", "none");
                    $("#modalCreateProductor").modal('hide');
                    $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductor").load(route("socio.data", codPostulante));
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
                    $("#ProductorAlerts").css("display", "block");
                    $("#ProductorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateProductor_Enabled").css("display", "block");
                    $("#Footer_CreateProductor_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateProductor', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateProductor");
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
                    $("#Footer_UpdateProductor_Enabled").css("display", "none");
                    $("#Footer_UpdateProductor_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateProductor_Enabled").css("display", "block");
                    $("#Footer_UpdateProductor_Disabled").css("display", "none");
                    $("#modalUpdateProductor").modal('hide');
                    $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductor").load(route("socio.data", codPostulante));
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
                    $("#ProductorAlerts").css("display", "block");
                    $("#ProductorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateProductor_Enabled").css("display", "block");
                    $("#Footer_UpdateProductor_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateEvaluacionCampo', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateEvaluacionCampo");
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
                    $("#Footer_UpdateEvaluacionCampo_Enabled").css("display", "none");
                    $("#Footer_UpdateEvaluacionCampo_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateEvaluacionCampo_Enabled").css("display", "block");
                    $("#Footer_UpdateEvaluacionCampo_Disabled").css("display", "none");
                    $("#modalUpdateEvaluacionCampo").modal('hide');
                    $("#viewDataEvaluacionCampo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEvaluacionCampo").load(route("socio.data-campo", codPostulante));
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
                    $("#EvaluacionCampoAlerts").css("display", "block");
                    $("#EvaluacionCampoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateEvaluacionCampo_Enabled").css("display", "block");
                    $("#Footer_UpdateEvaluacionCampo_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateBalanceHidrico', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateBalanceHidrico");
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
                    $("#Footer_UpdateBalanceHidrico_Enabled").css("display", "none");
                    $("#Footer_UpdateBalanceHidrico_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateBalanceHidrico_Enabled").css("display", "block");
                    $("#Footer_UpdateBalanceHidrico_Disabled").css("display", "none");
                    $("#modalUpdateBalanceHidrico").modal('hide');
                    $("#viewDataBalanceHidrico").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataBalanceHidrico").load(route("socio.data-hidrico", codPostulante));
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
                    $("#BalanceHidricoAlerts").css("display", "block");
                    $("#BalanceHidricoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateBalanceHidrico_Enabled").css("display", "block");
                    $("#Footer_UpdateBalanceHidrico_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateResultadoFinal', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateResultadoFinal");
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
                    $("#Footer_UpdateResultadoFinal_Enabled").css("display", "none");
                    $("#Footer_UpdateResultadoFinal_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateResultadoFinal_Enabled").css("display", "block");
                    $("#Footer_UpdateResultadoFinal_Disabled").css("display", "none");
                    $("#modalUpdateResultadoFinal").modal('hide');
                    $("#viewDataResultadoFinal").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataResultadoFinal").load(route("socio.data-resultado", codPostulante));
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
                    $("#ResultadoFinalAlerts").css("display", "block");
                    $("#ResultadoFinalAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateResultadoFinal_Enabled").css("display", "block");
                    $("#Footer_UpdateResultadoFinal_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '.btnDeleteProductor', function (event) {
            event.preventDefault();
            var codProductor = $(this).data("id");
            var urlAction = route("socio.destroy", codProductor);
            // Antes de procesar realizamos una confirmación del proceso
            alertify.confirm("Confirmación de envío de formulario", "¿Esta seguro de que desea eliminar este ítem?.",
                function () {
                    $.ajax({
                        url: urlAction,
                        method: "POST",
                        data: codProductor,
                        beforeSend: function () {},
                        success: function (response) {
                            var cadena = response;
                            var mensaje = cadena.mensaje;
                            alertify.alert("Proceso concluido", mensaje, function () {
                                $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                $("#viewDataProductor").load(route("socio.data", codPostulante));
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
                    $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductor").load(route("socio.data", codPostulante));
                }
            );
        });  
    });
</script>
@stop