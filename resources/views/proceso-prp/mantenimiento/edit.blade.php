@extends('layouts.template')
@section('title', 'Mantenimiento de información de expedientes')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabExpediente" role="tablist" data-id="{{$expediente->id}}">
                    <li class="nav-item"><a class="nav-link active" id="TabExpediente001" data-toggle="pill" href="#custom-tabs-expediente" role="tab" aria-controls="custom-tabs-expediente" aria-selected="true">1. Información de Expediente</a></li>
                    @if (isset($ur->id))
                    <li class="nav-item"><a class="nav-link" id="TabExpediente002" data-toggle="pill" href="#custom-tabs-ur" role="tab" aria-controls="custom-tabs-ur" aria-selected="false">2. Evaluación Documentaria</a></li>   
                    @endif
                    @if (isset($upfp->id))
                    <li class="nav-item"><a class="nav-link" id="TabExpediente003" data-toggle="pill" href="#custom-tabs-upfp" role="tab" aria-controls="custom-tabs-upfp" aria-selected="false">3. Evaluación Técnica</a></li>   
                    @endif
                    <!--
                    <li class="nav-item"><a class="nav-link" id="TabExpediente004" data-toggle="pill" href="#custom-tabs-un" role="tab" aria-controls="custom-tabs-un" aria-selected="false">4. Unidad de Negocios</a></li>   
                    <li class="nav-item"><a class="nav-link" id="TabExpediente005" data-toggle="pill" href="#custom-tabs-uaj" role="tab" aria-controls="custom-tabs-uaj" aria-selected="false">5. Unidad de asesoría jurídica</a></li>   
                    -->
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabExpedienteContent">
                    <div class="tab-pane fade show active" id="custom-tabs-expediente" role="tabpanel" aria-labelledby="TabExpediente001">
                        {!!Form::model($expediente,['id'=>'FormUpdateExpedientePrp', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['mantenimiento.update',$expediente->id]])!!}
                        {{Form::token()}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">I. Datos del Expediente</h3>
                            </div>
                            <div class="card-body">
                                <div id="ExpedientePrpAlerts" class="alert alert-danger" style="display: none;"></div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">{!! Form::label('entidad', 'Nombre de la entidad que accederá al incentivo') !!} {!! Form::text('entidad', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                        <div class="col-md-2">{!! Form::label('nro_cut', 'Nº de CUT') !!} {!! Form::number('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                        <div class="col-md-2">{!! Form::label('fecha_recepcion', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion', $expediente->fechaCut, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                                        <div class="col-md-2">{!! Form::label('nro_expediente', 'Nº de Expediente') !!} {!! Form::number('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                        <div class="col-md-2">{!! Form::label('fecha_expediente', 'Fecha de expediente') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">{!! Form::label('especialista_asignado', 'Especialista asignado') !!}
                                            <select name="especialista_asignado" class="form-control select2">
                                                <option value="" selected="selected">Seleccionar</option>
                                                @foreach ($personal as $fila)
                                                    <option value="{{$fila->id}}" {{($fila->id == $expediente->codPersonalAsignado)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">{!! Form::label('oficina', 'Ubicación del expediente') !!}
                                            <select name="oficina" class="form-control select2">
                                                <option value="" selected="selected">Seleccionar</option>
                                                @foreach ($oficinas as $fila)
                                                    <option value="{{$fila->id}}" {{($fila->id == $expediente->codOficina)?'selected':''}}>{{$fila->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">{!! Form::label('area', 'Área actual') !!}
                                            <select name="area" class="form-control" disabled="disabled">
                                                <option value="" selected="selected">Seleccionar</option>
                                                @foreach ($areas as $fila)
                                                    <option value="{{$fila->id}}" {{($fila->id == $expediente->codArea)?'selected':''}}>{{$fila->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">{!! Form::label('estado', 'Situación actual') !!}
                                            <select name="estado" class="form-control" disabled="disabled">
                                                <option value="" selected="selected">Seleccionar</option>
                                                @foreach ($estados as $fila)
                                                    <option value="{{$fila->Orden}}" {{($fila->Orden == $expediente->codEstado)?'selected':''}}>{{$fila->Nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div id="Footer_UpdateExpedientePrp_Enabled">
                                    <a href="#" id="btnUpdateExpedientePrp" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                    <a href="{{route("mantenimiento.index")}}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                </div>
                                <div id="Footer_UpdateExpedientePrp_Disabled" style="display:none;">
                                    <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-ur" role="tabpanel" aria-labelledby="TabExpediente002">
                        <div id="divFormUpdateExpedienteUr">
                            <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-upfp" role="tabpanel" aria-labelledby="TabExpediente003">
                        <div id="divFormUpdateExpedienteUpfp">
                            <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-un" role="tabpanel" aria-labelledby="TabExpediente004">
                        <div id="divFormUpdateExpedienteUn">
                            <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-uaj" role="tabpanel" aria-labelledby="TabExpediente005">
                        <div id="divFormUpdateExpedienteUaj">
                            <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Fin del contenido --}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        var codExpediente    =   $("#TabExpediente").attr('data-id');
        //1. Muestro los formularios solicitados
        $('#divFormUpdateExpedienteUr').load(route("mantenimiento.edit-ur", codExpediente));
        $('#divFormUpdateExpedienteUpfp').load(route("mantenimiento.edit-upfp", codExpediente));
        $('#divFormUpdateExpedienteUn').load(route("mantenimiento.edit-un", codExpediente));
        $('#divFormUpdateExpedienteUaj').load(route("mantenimiento.edit-uaj", codExpediente));
        //2. Proceso los datos de los formularios
        $(document).on("click", '#btnUpdateExpedientePrp', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateExpedientePrp");
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
                    $("#Footer_UpdateExpedientePrp_Enabled").css("display", "none");
                    $("#Footer_UpdateExpedientePrp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateExpedientePrp_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedientePrp_Disabled").css("display", "none");
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
                    $("#ExpedientePrpAlerts").css("display", "block");
                    $("#ExpedientePrpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateExpedientePrp_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedientePrp_Disabled").css("display", "none");
                }
            });
        });       
        $(document).on("click", '#btnUpdateExpedienteUr', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateExpedienteUr");
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
                    $("#Footer_UpdateExpedienteUr_Enabled").css("display", "none");
                    $("#Footer_UpdateExpedienteUr_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateExpedienteUr_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedienteUr_Disabled").css("display", "none");
                    $('#divFormUpdateExpedienteUr').load(route("mantenimiento.edit-ur", codExpediente));
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
                    $("#ExpedienteUrAlerts").css("display", "block");
                    $("#ExpedienteUrAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateExpedienteUr_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedienteUr_Disabled").css("display", "none");
                }
            });
        }); 
        $(document).on("click", '#btnUpdateExpedienteUpfp', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateExpedienteUpfp");
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
                    $("#Footer_UpdateExpedienteUpfp_Enabled").css("display", "none");
                    $("#Footer_UpdateExpedienteUpfp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedienteUpfp_Disabled").css("display", "none");
                    $('#divFormUpdateExpedienteUpfp').load(route("mantenimiento.edit-upfp", codExpediente));
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
                    $("#ExpedienteUpfpAlerts").css("display", "block");
                    $("#ExpedienteUpfpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_UpdateExpedienteUpfp_Disabled").css("display", "none");
                }
            });
        });   
    });
</script>
@stop