@extends('layouts.template')
@section('title', 'Registrar información de marco lógico')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabML" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabML001" data-toggle="pill" href="#custom-tabs-ml" role="tab" aria-controls="custom-tabs-ml" aria-selected="true">1. Datos del Proyecto</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabMLContent">
                    <div class="tab-pane fade show active" id="custom-tabs-ml" role="tabpanel" aria-labelledby="TabML001">
                        {!!Form::open(array('id'=>'FormCreateMarcoLogico','url'=>'proyecto/ml','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="MarcoLogicoAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ruc', 'Nro RUC') !!} {!! Form::text('ruc', '', ['class' => 'form-control', 'placeholder' => '00000000000']) !!}</div>
                                <div class="col-md-9">{!! Form::label('razon_social', 'Razon social del Proyecto') !!} {!! Form::text('razon_social', '', ['class' => 'form-control', 'placeholder' => 'Nombre del proyecto / programa de acuerdo a SUNAT']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('inicio', 'Año de inicio') !!} {!! Form::number('inicio', '', ['class' => 'form-control', 'min' => '2010', 'max' => '2030']) !!}</div>
                                <div class="col-md-3">{!! Form::label('termino', 'Año de término') !!} {!! Form::number('termino', '', ['class' => 'form-control', 'min' => '2010', 'max' => '2030']) !!}</div>
                                <div class="col-md-6">{!! Form::label('direccion', 'Dirección de la sede principal del proyecto') !!} {!! Form::text('direccion', '', ['class' => 'form-control', 'placeholder' => 'Dirección de la sede central del proyecto']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">{!! Form::label('fin', 'Fin del proyecto') !!} {!! Form::textarea('fin', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                                <div class="col-md-6">{!! Form::label('proposito', 'Objetivo del proyecto') !!} {!! Form::textarea('proposito', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_CreateMarcoLogico_Enabled">
                                       <a href="#" id="btnCreateMarcoLogico" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/proyecto/ml" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_CreateMarcoLogico_Disabled" style="display:none;">
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
{{-- Inicio del contenido--}}
@stop
@section('scripts')
<script>
        $(document).ready(function () {
            $(document).on("click", '#btnCreateMarcoLogico', function (event) {
                event.preventDefault();
                var form = $("#FormCreateMarcoLogico");
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
                        $("#Footer_CreateMarcoLogico_Enabled").css("display", "none");
                        $("#Footer_CreateMarcoLogico_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje     = response.mensaje;
                        var codigo      = response.dato;
                        var url_edit    = codigo +'/edit';
                        alertify.success(mensaje);
                        $("#Footer_CreateMarcoLogico_Enabled").css("display", "block");
                        $("#Footer_CreateMarcoLogico_Disabled").css("display", "none");
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
                        $("#Footer_CreateMarcoLogico_Enabled").css("display", "block");
                        $("#Footer_CreateMarcoLogico_Disabled").css("display", "none");
                    }
                });
            });
        });
</script>
@stop