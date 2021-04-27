@extends('layouts.template')
@section('title', 'Registrar nuevo evento y compromisos')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabEvento" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabEvento001" data-toggle="pill" href="#custom-tabs-evento" role="tab" aria-controls="custom-tabs-evento" aria-selected="true">1. Datos del evento</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabEventoContent">
                    <div class="tab-pane fade show active" id="custom-tabs-evento" role="tabpanel" aria-labelledby="TabEvento001">
                        {!!Form::open(array('id'=>'FormCreateEvento','url'=>'iniciativa/evento','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="EventoAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">{!! Form::label('tipo_evento', 'Tipo de evento') !!}
                                    <select name="tipo_evento" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoEvento as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('fecha_evento', 'Fecha del evento') !!} {!! Form::date('fecha_evento', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                <div class="col-md-8">{!! Form::label('nombre', 'Nombre de la comisión') !!} {!! Form::text('nombre', '', ['class' => 'form-control', 'placeholder' => 'Indique el nombre del evento / espacio de diálogo.']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2 col-xs-6 col-lg-2">{!! Form::label('region', 'Seleccione una región') !!}
                                    <select name="region" id="inputRegion" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($regiones as $fila)
                                            <option value="{{$fila->id}}">{{$fila->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-xs-6 col-lg-2">{!! Form::label('provincia', 'Seleccione una provincia') !!}
                                    <select name="provincia" id="inputProvincia" class="form-control" disabled="disabled">
										<option value="" selected="selected">Seleccionar</option>
									</select>
                                </div>
                                <div class="col-md-2 col-xs-6 col-lg-2">{!! Form::label('distrito', 'Seleccione un distrito') !!}
                                    <select name="distrito" id="inputDistrito" class="form-control" disabled="disabled">
										<option value="" selected="selected">Seleccionar</option>
									</select>
                                </div>
                                <div class="col-md-6 col-xs-6 col-lg-6">{!! Form::label('lugar', 'Lugar de realización del evento / comisión') !!} {!! Form::text('lugar', '', ['class' => 'form-control', 'placeholder' => 'Indique el lugar donde se realizó el evento / comisión']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('nombre_st', 'Secretaria técnica') !!} {!! Form::text('nombre_st', '', ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('representante_st', 'Representante secretaría técnica') !!} {!! Form::text('representante_st', '', ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('organizador', 'Institución que lidera la comisión') !!} {!! Form::text('organizador', '', ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('representante_organizador', 'Representante de la institución') !!} {!! Form::text('representante_organizador', '', ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-9 col-lg-9 col-xs-6">{!! Form::label('integrantes', 'Instituciones integrantes') !!} {!! Form::text('integrantes', '', ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('representante_pcc', 'Representante PCC') !!}
                                    <select name="representante_pcc" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($personal as $fila)
                                    <option value="{{$fila->id}}">{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}} - {{$fila->cargo}} {{$fila->oficina}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-xs-12 col-lg-6">{!! Form::label('objetivo', 'Objetivo de la comisión') !!} {!! Form::textarea('objetivo', '', ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => 'Cual es el objetivo de este evento / comisión?']) !!}</div>
                                <div class="col-md-6 col-xs-12 col-lg-6">{!! Form::label('resultadoEsperado', 'Resultados esperados') !!} {!! Form::textarea('resultadoEsperado', '', ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => 'Que se espera alcanzar con la realización de este evento / comisión?']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">{!! Form::label('evidencia', 'Acta inicial de compromisos') !!} {!! Form::file('evidencia', ['class' => 'form-control', 'placeholder' => 'Adjuntar acta', 'accept' => 'application/pdf']) !!}</div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_CreateEvento_Enabled">
                                       <a href="#" id="btnCreateEvento" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/iniciativa/evento" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_CreateEvento_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
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
            $(document).on("click", '#btnCreateEvento', function (event) {
                event.preventDefault();
                var form = $("#FormCreateEvento");
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
                        $("#Footer_CreateEvento_Enabled").css("display", "none");
                        $("#Footer_CreateEvento_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje     = response.mensaje;
                        var codigo      = response.dato;
                        var url_edit    = codigo +'/edit';
                        alertify.success(mensaje);
                        $("#Footer_CreateEvento_Enabled").css("display", "block");
                        $("#Footer_CreateEvento_Disabled").css("display", "none");
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
                        $("#EventoAlerts").css("display", "block");
                        $("#EventoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateEvento_Enabled").css("display", "block");
                        $("#Footer_CreateEvento_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop