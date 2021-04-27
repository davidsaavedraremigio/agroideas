@extends('layouts.template')
@section('title', 'Actualizar información del Proyecto')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabML" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabML001" data-toggle="pill" href="#custom-tabs-ml" role="tab" aria-controls="custom-tabs-ml" aria-selected="true">1. Datos del Proyecto</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabML002" data-toggle="pill" href="#custom-tabs-resultados" role="tab" aria-controls="custom-tabs-resultados" aria-selected="false">2. Componentes</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabML003" data-toggle="pill" href="#custom-tabs-indicadores" role="tab" aria-controls="custom-tabs-indicadores" aria-selected="false">3. Indicadores de componente</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabML004" data-toggle="pill" href="#custom-tabs-actividades" role="tab" aria-controls="custom-tabs-actividades" aria-selected="false">4. Actividades</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabML005" data-toggle="pill" href="#custom-tabs-indicador-actividad" role="tab" aria-controls="custom-tabs-indicador-actividad" aria-selected="false">5. Indicadores de actividades</a></li>
                </ul>
                <div class="card-body">
                    <div class="tab-content" id="TabMLContent">
                        <div class="tab-pane fade show active" id="custom-tabs-ml" role="tabpanel" aria-labelledby="TabML001">
                            {!!Form::model($proyecto,['id'=>'FormUpdateMarcoLogico', 'method'=>'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['ml.update',$proyecto->id]])!!}
                            {{Form::token()}}
                            {{-- Panel para mostrar alertas --}}
                            <div id="MarcoLogicoAlerts" class="alert alert-danger" style="display: none;"></div>
                            {{-- Panel para mostrar alertas --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('ruc', 'Nro RUC') !!} {!! Form::text('ruc', $proyecto->ruc, ['class' => 'form-control', 'placeholder' => '00000000000']) !!}</div>
                                    <div class="col-md-9">{!! Form::label('razon_social', 'Razon social del Proyecto') !!} {!! Form::text('razon_social', $proyecto->razonSocial, ['class' => 'form-control', 'placeholder' => 'Nombre del proyecto / programa de acuerdo a SUNAT']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('inicio', 'Año de inicio') !!} {!! Form::number('inicio', $proyecto->periodoInicio, ['class' => 'form-control', 'min' => '2010', 'max' => '2030']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('termino', 'Año de término') !!} {!! Form::number('termino', $proyecto->periodoFin, ['class' => 'form-control', 'min' => '2010', 'max' => '2030']) !!}</div>
                                    <div class="col-md-6">{!! Form::label('direccion', 'Dirección de la sede principal del proyecto') !!} {!! Form::text('direccion', $proyecto->direccion, ['class' => 'form-control', 'placeholder' => 'Dirección de la sede central del proyecto']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">{!! Form::label('fin', 'Fin del proyecto') !!} {!! Form::textarea('fin', $proyecto->Fin, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                                    <div class="col-md-6">{!! Form::label('proposito', 'Objetivo del proyecto') !!} {!! Form::textarea('proposito', $proyecto->Proposito, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                                </div>
                            </div>
                            {{-- Botonera  --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="Footer_UpdateMarcoLogico_Enabled">
                                           <a href="#" id="btnUpdateMarcoLogico" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                           <a href="{{ env('APP_URL') }}/proyecto/ml" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                       </div>
                                       <div id="Footer_UpdateMarcoLogico_Disabled" style="display:none;">
                                           <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-resultados" role="tabpanel" aria-labelledby="TabML002">
                            {{-- Contenido del módulo Compromisos--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Componentes del Marco Lógico</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateComponente"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataComponente" class="table-responsive" data-id="{{$proyecto->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo Compromisos--}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-indicadores" role="tabpanel" aria-labelledby="TabML003">
                            {{-- Contenido del módulo Indicadores--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Indicadores de Componente</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateIndicador"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataIndicador" class="table-responsive" data-id="{{$proyecto->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo Indicadores --}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-actividades" role="tabpanel" aria-labelledby="TabML004">
                            {{-- Contenido del módulo Compromisos--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Actividades del Marco Lógico</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateActividad"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataActividad" class="table-responsive" data-id="{{$proyecto->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo Compromisos--}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-indicador-actividad" role="tabpanel" aria-labelledby="TabML005">
                            {{-- Contenido del módulo Compromisos--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Indicadores de actividades</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateIndicadorActividad"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataIndicadorActividad" class="table-responsive" data-id="{{$proyecto->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo Compromisos--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modals --}}
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateComponente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateComponente">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateComponente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateComponente">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateIndicador">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateIndicador">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateIndicador">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateIndicador">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de registros --}}
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
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateActividad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateActividad">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateIndicadorActividad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateIndicadorActividad">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateIndicadorActividad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateIndicadorActividad">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>


{{-- Fin del contenido --}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        var urlApp             =   "{{ env("APP_URL") }}";
        $(document).on("click", '#btnUpdateMarcoLogico', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateMarcoLogico");
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
                    $("#Footer_UpdateMarcoLogico_Enabled").css("display", "none");
                    $("#Footer_UpdateMarcoLogico_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateMarcoLogico_Enabled").css("display", "block");
                    $("#Footer_UpdateMarcoLogico_Disabled").css("display", "none");
                    $(location).attr('href', url_edit);
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
                    $("#MarcoLogicoAlerts").css("display", "block");
                    $("#MarcoLogicoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateMarcoLogico_Enabled").css("display", "block");
                    $("#Footer_UpdateMarcoLogico_Disabled").css("display", "none");
                }
            });
        });
        //2. Cargo la información de beneficiarios
        var codML    =   $("#viewDataComponente").attr('data-id');
        $("#viewDataComponente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataComponente").load(urlApp+'/proyecto/resultado/'+ codML +'/data');
        //3. Muestro el formulario de registro de compromisos
        $('#modalCreateComponente').on('show.bs.modal', function (e) {
            $('#divFormCreateComponente').load('../../resultado/' + codML + '/create');
        });
        //4. Muestro el formulario para la edición de compromisos
        $('#modalUpdateComponente').on('show.bs.modal', function (e) {
            var codComponente= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateComponente').load('../../resultado/'+codComponente+'/edit');
        });
        //5. Guardo la información de componentes
        $(document).on("click", '#btnCreateComponente', function (event) {
            event.preventDefault();
            var form = $("#FormCreateComponente");
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
                    $("#Footer_CreateComponente_Enabled").css("display", "none");
                    $("#Footer_CreateComponente_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateComponente_Enabled").css("display", "block");
                    $("#Footer_CreateComponente_Disabled").css("display", "none");
                    $("#modalCreateComponente").modal('hide');
                    $("#viewDataComponente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataComponente").load(urlApp+'/proyecto/resultado/'+ codML +'/data');
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
                    $("#ComponenteAlerts").css("display", "block");
                    $("#ComponenteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateComponente_Enabled").css("display", "block");
                    $("#Footer_CreateComponente_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateComponente', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateComponente");
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
                    $("#Footer_UpdateComponente_Enabled").css("display", "none");
                    $("#Footer_UpdateComponente_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateComponente_Enabled").css("display", "block");
                    $("#Footer_UpdateComponente_Disabled").css("display", "none");
                    $("#modalUpdateComponente").modal('hide');
                    $("#viewDataComponente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataComponente").load(urlApp+'/proyecto/resultado/'+ codML +'/data');
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
                    $("#ComponenteAlerts").css("display", "block");
                    $("#ComponenteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateComponente_Enabled").css("display", "block");
                    $("#Footer_UpdateComponente_Disabled").css("display", "none");
                }
            });
        });
        //6. Cargo la información de Indicadores
        $("#viewDataIndicador").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataIndicador").load(urlApp+'/proyecto/indicador/'+ codML +'/data');
        //7. Muestro el formulario de registro de compromisos
        $('#modalCreateIndicador').on('show.bs.modal', function (e) {
            $('#divFormCreateIndicador').load('../../indicador/' + codML + '/create');
        });
        //8. Muestro el formulario para la edición de compromisos
        $('#modalUpdateIndicador').on('show.bs.modal', function (e) {
            var codIndicador= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateIndicador').load(urlApp+'/proyecto/indicador/'+codIndicador+'/edit');
        });
        //9. Guardo la información de componentes
        $(document).on("click", '#btnCreateIndicador', function (event) {
            event.preventDefault();
            var form = $("#FormCreateIndicador");
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
                    $("#Footer_CreateIndicador_Enabled").css("display", "none");
                    $("#Footer_CreateIndicador_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateIndicador_Enabled").css("display", "block");
                    $("#Footer_CreateIndicador_Disabled").css("display", "none");
                    $("#modalCreateIndicador").modal('hide');
                    $("#viewDataIndicador").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataIndicador").load(urlApp+'/proyecto/indicador/'+ codML +'/data');
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
                    $("#IndicadorAlerts").css("display", "block");
                    $("#IndicadorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateIndicador_Enabled").css("display", "block");
                    $("#Footer_CreateIndicador_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateIndicador', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateIndicador");
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
                    $("#Footer_UpdateIndicador_Enabled").css("display", "none");
                    $("#Footer_UpdateIndicador_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateIndicador_Enabled").css("display", "block");
                    $("#Footer_UpdateIndicador_Disabled").css("display", "none");
                    $("#modalUpdateIndicador").modal('hide');
                    $("#viewDataIndicador").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataIndicador").load(urlApp+'/proyecto/indicador/'+ codML +'/data');
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
                    $("#IndicadorAlerts").css("display", "block");
                    $("#IndicadorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateIndicador_Enabled").css("display", "block");
                    $("#Footer_UpdateIndicador_Disabled").css("display", "none");
                }
            });
        });
        //10. Cargo la información de actividades
        $("#viewDataActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataActividad").load(urlApp+'/proyecto/actividad/'+ codML +'/data');
        //11. Muestro el formulario de registro de actividades
        $('#modalCreateActividad').on('show.bs.modal', function (e) {
            $('#divFormCreateActividad').load(urlApp+'/proyecto/actividad/' + codML + '/create');
        });
        //12. Muestro el formulario para la edición de actividades
        $('#modalUpdateActividad').on('show.bs.modal', function (e) {
            var codActividad= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateActividad').load(urlApp+'/proyecto/actividad/'+codActividad+'/edit');
        });
        //13. Guardo la información de componentes
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
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateActividad_Enabled").css("display", "block");
                    $("#Footer_CreateActividad_Disabled").css("display", "none");
                    $("#modalCreateActividad").modal('hide');
                    $("#viewDataActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataActividad").load(urlApp+'/proyecto/actividad/'+ codML +'/data');
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
                    $("#ActividadAlerts").css("display", "block");
                    $("#ActividadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateActividad_Enabled").css("display", "block");
                    $("#Footer_CreateActividad_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateActividad', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateActividad");
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
                    $("#Footer_UpdateActividad_Enabled").css("display", "none");
                    $("#Footer_UpdateActividad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateActividad_Enabled").css("display", "block");
                    $("#Footer_UpdateActividad_Disabled").css("display", "none");
                    $("#modalUpdateActividad").modal('hide');
                    $("#viewDataActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataActividad").load(urlApp+'/proyecto/actividad/'+ codML +'/data');
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
                    $("#ActividadAlerts").css("display", "block");
                    $("#ActividadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateActividad_Enabled").css("display", "block");
                    $("#Footer_UpdateActividad_Disabled").css("display", "none");
                }
            });
        });
        //14. Cargo la información de indicadores de actividad
        $("#viewDataIndicadorActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataIndicadorActividad").load(urlApp+'/proyecto/indicador-actividad/'+ codML +'/data');
        //15. Muestro el formulario de registro de indicador de actividades
        $('#modalCreateIndicadorActividad').on('show.bs.modal', function (e) {
            $('#divFormCreateIndicadorActividad').load(urlApp+'/proyecto/indicador-actividad/' + codML + '/create');
        });
        //16. Muestro el formulario para la edición de indicador de actividades
        $('#modalUpdateIndicadorActividad').on('show.bs.modal', function (e) {
            var codIndicadorActividad= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateIndicadorActividad').load(urlApp+'/proyecto/indicador-actividad/'+codIndicadorActividad+'/edit');
        });
        //17. Guardo la información de Indicador de actividades
        $(document).on("click", '#btnCreateIndicadorActividad', function (event) {
            event.preventDefault();
            var form = $("#FormCreateIndicadorActividad");
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
                    $("#Footer_CreateIndicadorActividad_Enabled").css("display", "none");
                    $("#Footer_CreateIndicadorActividad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateIndicadorActividad_Enabled").css("display", "block");
                    $("#Footer_CreateIndicadorActividad_Disabled").css("display", "none");
                    $("#modalCreateIndicadorActividad").modal('hide');
                    $("#viewDataIndicadorActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataIndicadorActividad").load(urlApp+'/proyecto/indicador-actividad/'+ codML +'/data');
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
                    $("#IndicadorActividadAlerts").css("display", "block");
                    $("#IndicadorActividadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateIndicadorActividad_Enabled").css("display", "block");
                    $("#Footer_CreateIndicadorActividad_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateIndicadorActividad', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateIndicadorActividad");
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
                    $("#Footer_UpdateIndicadorActividad_Enabled").css("display", "none");
                    $("#Footer_UpdateIndicadorActividad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateIndicadorActividad_Enabled").css("display", "block");
                    $("#Footer_UpdateIndicadorActividad_Disabled").css("display", "none");
                    $("#modalUpdateIndicadorActividad").modal('hide');
                    $("#viewDataIndicadorActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataIndicadorActividad").load(urlApp+'/proyecto/indicador-actividad/'+ codML +'/data');
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
                    $("#IndicadorActividadAlerts").css("display", "block");
                    $("#IndicadorActividadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateIndicadorActividad_Enabled").css("display", "block");
                    $("#Footer_UpdateIndicadorActividad_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop