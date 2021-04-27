@extends('layouts.template')
@section('title', 'Formulario para el registro de convenios')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabEvento" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabConvenio001" data-toggle="pill" href="#custom-tabs-convenio" role="tab" aria-controls="custom-tabs-convenio" aria-selected="true">1. Datos del convenio</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabConvenioContent">
                    <div class="tab-pane fade show active" id="custom-tabs-evento" role="tabpanel" aria-labelledby="TabConvenio001">
                        {!!Form::open(array('id'=>'FormCreateConvenio','url'=>'de/convenio','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="ConvenioAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('nro_cut', 'Nº de CUT') !!} {!! Form::number('nro_cut', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                <div class="col-md-3">{!! Form::label('fecha_cut', 'Fecha') !!} {!! Form::date('fecha_cut', date('Y-m-d'), ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo', 'Tipo de convenio') !!}
                                    <select name="tipo" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipo as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('duracion', 'Duración (meses)') !!} {!! Form::number('duracion', '', ['class' => 'form-control', 'min' => '1', 'max' => '72', 'maxlength' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('nro_convenio', 'Nº de convenio') !!} {!! Form::number('nro_convenio', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                <div class="col-md-3">{!! Form::label('fecha_firma', 'Fecha de firma') !!} {!! Form::date('fecha_firma', date('Y-m-d'), ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                <div class="col-md-3">{!! Form::label('nro_ley', 'Ley de presupuesto (Si aplica)') !!} {!! Form::text('nro_ley', '', ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('importe', 'Importe (S/.) (Si aplica)') !!} {!! Form::text('importe', '', ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('objetivo', 'Objetivo del convenio marco') !!} {!! Form::textarea('objetivo', '', ['class'=> 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('representante_pcc', 'Representante del PCC') !!}
                                    <select name="representante_pcc" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($personal as $fila)
                                            <option value="{{$fila->id}}">{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}} - {{$fila->cargo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-9"><br></div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_CreateConvenio_Enabled">
                                       <a href="#" id="btnCreateConvenio" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/de/convenio" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_CreateConvenio_Disabled" style="display:none;">
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
            $(document).on("click", '#btnCreateConvenio', function (event) {
                event.preventDefault();
                var form = $("#FormCreateConvenio");
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
                        $("#Footer_CreateConvenio_Enabled").css("display", "none");
                        $("#Footer_CreateConvenio_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje     = response.mensaje;
                        var codigo      = response.dato;
                        var url_edit    = codigo +'/edit';
                        alertify.success(mensaje);
                        $("#Footer_CreateConvenio_Enabled").css("display", "block");
                        $("#Footer_CreateConvenio_Disabled").css("display", "none");
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
                        $("#ConvenioAlerts").css("display", "block");
                        $("#ConvenioAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateConvenio_Enabled").css("display", "block");
                        $("#Footer_CreateConvenio_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop