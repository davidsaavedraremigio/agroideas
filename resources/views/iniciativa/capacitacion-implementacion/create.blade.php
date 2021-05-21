@extends('layouts.template')
@section('title', 'Registro de la implementación de evento de capacitación')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabEvento" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabEvento001" data-toggle="pill" href="#custom-tabs-evento" role="tab" aria-controls="custom-tabs-evento" aria-selected="true">1. Resultados del evento</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabEventoContent">
                    <div class="tab-pane fade show active" id="custom-tabs-evento" role="tabpanel" aria-labelledby="TabEvento001">
                        {!!Form::open(array('id'=>'FormCreateImplementacionCapacitacion','url'=>'iniciativa/capacitacion-implementacion','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="ImplementacionCapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
                        {!! Form::hidden('codigo', $capacitacion->id, ['class' => 'form-control']) !!}
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">{!! Form::label('nombre', 'Nombre del evento de capacitación') !!} {!! Form::textarea('nombre', $capacitacion->nombre, ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-6">{!! Form::label('objetivos', 'Objetivos del evento') !!} {!! Form::textarea('objetivos', $capacitacion->objetivo, ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'readonly' => 'readonly']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">{!! Form::label('tipo_evento', 'Tipo de evento') !!}
                                    <select name="tipo_evento" class="form-control" disabled="disabled">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoEvento as $fila)
                                        <option value="{{$fila->Orden}}" {{($fila->Orden == $capacitacion->codTipo)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('tematica', 'Temática del evento') !!}
                                    <select name="tematica" class="form-control" disabled="disabled">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tematica as $fila)
                                        <option value="{{$fila->Orden}}" {{($fila->Orden == $capacitacion->codTematica)?'selected':''}}>{{$fila->Nombre}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('organizacion', 'Organización del evento') !!}
                                    <select name="organizacion" class="form-control" disabled="disabled">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($organizacion as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $capacitacion->codOrganizacion)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('fecha', 'Fecha de implementación') !!} {!! Form::date('fecha', $capacitacion->fecha, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-2">{!! Form::label('hora_inicio', 'Hora de inicio') !!} {!! Form::text('hora_inicio', '', ['class' => 'form-control', 'placeholder' => '00:00']) !!}</div> 
                                <div class="col-md-2">{!! Form::label('hora_termino', 'Hora de término') !!} {!! Form::text('hora_termino', '', ['class' => 'form-control', 'placeholder' => '00:00']) !!}</div> 
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('resultados', 'Resultados obtenidos:') !!} {!! Form::textarea('resultados', '', ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => 'Describa que resultados se alcanzaron con la realización del evento.']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">{!! Form::label('acuerdos', 'Acuerdos realizados:') !!} {!! Form::textarea('acuerdos', '', ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => '(Si es que aplica) Describa los acuerdos que han surgido en el evento.']) !!}</div>
                                <div class="col-md-6">{!! Form::label('comentarios', 'Comentarios u observaciones:') !!} {!! Form::textarea('comentarios', '', ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => '(Si es que aplica) Indique que comentarios, observaciones y/o sugerencias puede dar del evento realizado.']) !!}</div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_CreateImplementacionCapacitacion_Enabled">
                                       <a href="#" id="btnCreateImplementacionCapacitacion" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{route('capacitacion.index')}}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_CreateImplementacionCapacitacion_Disabled" style="display:none;">
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
            $(document).on("click", '#btnCreateImplementacionCapacitacion', function (event) {
                event.preventDefault();
                var form = $("#FormCreateImplementacionCapacitacion");
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
                        $("#Footer_CreateImplementacionCapacitacion_Enabled").css("display", "none");
                        $("#Footer_CreateImplementacionCapacitacion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje     = response.mensaje;
                        var codigo      = response.dato;
                        var url_edit    = route("capacitacion-implementacion.edit", codigo);
                        alertify.success(mensaje);
                        $("#Footer_CreateImplementacionCapacitacion_Enabled").css("display", "block");
                        $("#Footer_CreateImplementacionCapacitacion_Disabled").css("display", "none");
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
                        $("#ImplementacionCapacitacionAlerts").css("display", "block");
                        $("#ImplementacionCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateImplementacionCapacitacion_Enabled").css("display", "block");
                        $("#Footer_CreateImplementacionCapacitacion_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop