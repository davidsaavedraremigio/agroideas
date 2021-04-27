@extends('layouts.template')
@section('title', 'Programar evento de capacitación')
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
                        {!!Form::open(array('id'=>'FormCreateCapacitacion','url'=>'iniciativa/capacitacion','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="CapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('tipo_evento', 'Tipo de evento') !!}
                                    <select name="tipo_evento" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoEvento as $fila)
                                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">{!! Form::label('tematica', 'Temática del evento') !!}
                                    <select name="tematica" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tematica as $fila)
                                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('organizacion', 'Organización del evento') !!}
                                    <select name="organizacion" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($organizacion as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('fecha', 'Fecha programada del evento') !!} {!! Form::date('fecha', '', ['class' => 'form-control', 'min' => $fechaMinima, 'max' => $fechaMaxima]) !!}</div>
                                <div class="col-md-2">{!! Form::label('horas', 'Nº de horas programadas') !!} {!! Form::number('horas', '', ['class' => 'form-control', 'min' => '1', 'max' => '24']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('nombre', 'Nombre del evento') !!} {!! Form::textarea('nombre', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
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
                                <div class="col-md-6 col-xs-6 col-lg-6">{!! Form::label('lugar', 'Lugar de realización del evento') !!} {!! Form::text('lugar', '', ['class' => 'form-control', 'placeholder' => 'Indique el lugar donde se realizará el evento']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('objetivo', 'Objetivos del evento') !!} {!! Form::textarea('objetivo', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('agenda', 'Comentarios') !!} {!! Form::textarea('agenda', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('responsable', 'Especialista responsable') !!}
                                    <select name="responsable" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($personal as $fila)
                                        <option value="{{$fila->id}}">{{$fila->sigla}} - {{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('nro_participantes', 'Nº de participantes') !!} {!! Form::number('nro_participantes', '', ['class' => 'form-control', 'min' => '1', 'max' => '500']) !!}</div>
                                <div class="col-md-3">{!! Form::label('importe', 'Costo del evento (S/.)') !!} {!! Form::text('importe', '', ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('actividad_operativa', 'Actividad operativa') !!}
                                    <select name="actividad_operativa" class="form-control select2">
                                        <option value="1" selected="selected">Seleccionar</option>
                                        @foreach ($poa as $fila)
                                            <option value="{{$fila->id}}">{{$fila->codigo}} - {{$fila->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_CreateCapacitacion_Enabled">
                                       <a href="#" id="btnCreateCapacitacion" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/iniciativa/capacitacion" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_CreateCapacitacion_Disabled" style="display:none;">
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
            $(document).on("click", '#btnCreateCapacitacion', function (event) {
                event.preventDefault();
                var form = $("#FormCreateCapacitacion");
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
                        $("#Footer_CreateCapacitacion_Enabled").css("display", "none");
                        $("#Footer_CreateCapacitacion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje     = response.mensaje;
                        var codigo      = response.dato;
                        var url_edit    = codigo +'/edit';
                        alertify.success(mensaje);
                        $("#Footer_CreateCapacitacion_Enabled").css("display", "block");
                        $("#Footer_CreateCapacitacion_Disabled").css("display", "none");
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
                        $("#CapacitacionAlerts").css("display", "block");
                        $("#CapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateCapacitacion_Enabled").css("display", "block");
                        $("#Footer_CreateCapacitacion_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop