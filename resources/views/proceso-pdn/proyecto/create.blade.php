@extends('layouts.template')
@section('title', 'Módulo para el registro de la información general de los SDA')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabProyecto" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabProyecto001" data-toggle="pill" href="#custom-tabs-proyecto" role="tab" aria-controls="custom-tabs-proyecto" aria-selected="true">1. Información General</a>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="tab-content" id="TabProyectoContent">
                        <div class="tab-pane fade show active" id="custom-tabs-proyecto" role="tabpanel" aria-labelledby="TabProyecto001">
                            {!!Form::open(array('id'=>'FormCreateProyectoSda','url'=>'proceso-pdn/proyecto','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                            {{Form::token()}}
                            {{-- Panel para mostrar alertas --}}
                            <div id="ProyectoSdaAlerts" class="alert alert-danger" style="display: none;"></div>
                            {{-- Panel para mostrar alertas --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">{!! Form::label('postulante', 'Seleccione un expediente') !!}
                                        <select name="postulante" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($postulantes as $fila)
                                                <option value="{{$fila->id}}">{{$fila->nroExpediente}} - {{$fila->razon_social}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">{!! Form::label('duracion', 'Duración (meses)') !!} {!! Form::number('duracion', '', ['class' => 'form-control', 'min' => '1', 'max' => '72']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('fecha_inicio', 'Fecha de inicio') !!} {!! Form::date('fecha_inicio', '', ['class' => 'form-control']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">{!! Form::label('titulo', 'Titulo del incentivo') !!} {!! Form::textarea('titulo', '', ['class' => 'form-control', 'placeholder' => 'Título del Proyecto', 'rows' => '2', 'cols' => '2']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">{!! Form::label('', '3.1. Nº de beneficiarios participantes') !!}</div>
                                    <div class="col-md-6">{!! Form::label('', '3.2. Inversión programada (S/)') !!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">{!! Form::label('beneficiarios_varones', 'Nº de varones') !!} {!! Form::number('beneficiarios_varones', '', ['class' => 'form-control beneficiario', 'min' => '0', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('beneficiarios_mujeres', 'Nº de mujeres') !!} {!! Form::number('beneficiarios_mujeres', '', ['class' => 'form-control beneficiario', 'min' => '0', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('beneficiarios_total', 'Nº total') !!} {!! Form::number('beneficiarios_total', '', ['class' => 'form-control', 'min' => '0', 'max' => '100', 'readonly' => 'readonly', 'id' => 'input_beneficiarios_total']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('inversion_pcc', 'Inversión PCC') !!} {!! Form::text('inversion_pcc', '', ['class' => 'form-control importe', 'onChange' => 'sumaImporteTotal();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('inversion_entidad', 'Inversión entidad') !!} {!! Form::text('inversion_entidad', '', ['class' => 'form-control importe',  'onChange' => 'sumaImporteTotal();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('inversion_total', 'Inversión total') !!} {!! Form::text('inversion_total', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_importe_total']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('cadena', 'Cadena productiva') !!}
                                        <select name="cadena" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($cadena as $fila)
                                                <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">{!! Form::label('tipo_produccion', 'Tipo de producción') !!}
                                        <select name="tipo_produccion" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($tipo_produccion as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">{!! Form::label('nro_has', 'Nº de hectareas') !!} {!! Form::text('nro_has', '', ['class' => 'form-control', 'placeholder' => '00.00']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('nro_animales', 'Nº de animales') !!} {!! Form::text('nro_animales', '', ['class' => 'form-control', 'placeholder' => '00.00']) !!}</div>
                                </div>
                            </div>
                            {{-- Botonera  --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="Footer_CreateProyectoSda_Enabled">
                                        <a href="#" id="btnCreateProyectoSda" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                        <a href="{{ env('APP_URL') }}/proceso-pdn/proyecto" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                    </div>
                                    <div id="Footer_CreateProyectoSda_Disabled" style="display:none;">
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
</div>
{{-- Fin del contenido --}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        var urlApp          = "{{ env('APP_URL') }}";
        //1. Realizo el procesamiento del formulario
        $(document).on("click", '#btnCreateProyectoSda', function (event) {
            event.preventDefault();
            var form = $("#FormCreateProyectoSda");
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
                    $("#Footer_CreateProyectoSda_Enabled").css("display", "none");
                    $("#Footer_CreateProyectoSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje     = response.mensaje;
                    var codigo      = response.dato;
                    var url_edit    = codigo +'/edit';
                    alertify.success(mensaje);
                    $("#Footer_CreateProyectoSda_Enabled").css("display", "block");
                    $("#Footer_CreateProyectoSda_Disabled").css("display", "none");
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
                    $("#ProyectoSdaAlerts").css("display", "block");
                    $("#ProyectoSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateProyectoSda_Enabled").css("display", "block");
                    $("#Footer_CreateProyectoSda_Disabled").css("display", "none");
                }
            });
        });
    });
    //2.1. Calculo el numero de beneficiarios
    function sumaBeneficiarios() {
        var add = 0;
        $('.beneficiario').each(function() {
            if (!isNaN($(this).val())) {
                add += Number($(this).val());
            }
        });
        $('#input_beneficiarios_total').val(add);
    };
    //2.2. Calculo el importe Programado
    function sumaImporteTotal() {
        var importe = 0;
        $('.importe').each(function() {
            if (!isNaN($(this).val())) {
                importe += Number($(this).val());
            }
        });
        $('#input_importe_total').val(importe);
    }
</script>
@stop