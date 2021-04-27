@extends('layouts.template')
@section('title', 'Módulo para la actualización de expedientes')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabExpediente" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabExpediente001" data-toggle="pill" href="#custom-tabs-expediente" role="tab" aria-controls="custom-tabs-expediente" aria-selected="true">1. Información del Expediente</a>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="tab-content" id="TabExpedienteContent">
                        <div class="tab-pane fade show active" id="custom-tabs-expediente" role="tabpanel" aria-labelledby="TabExpediente001">
                            {!!Form::model($expediente,['id'=>'FormUpdateExpediente', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['sda-ur.edit-proceso',$expediente->id]])!!}
                            {{Form::token()}}
                            {{-- Panel para mostrar alertas --}}
						    <div id="ExpedienteAlerts" class="alert alert-danger" style="display: none;"></div>
                            {{-- Panel para mostrar alertas --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">{!! Form::label('ruc', 'Nº de RUC') !!} {!! Form::text('ruc', $entidad->nroDocumento, ['class' => 'form-control', 'placeholder' => '00000000000', 'id' => 'input_nro_documento']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('tipo_entidad', 'Tipo de entidad') !!}
                                        <select name="tipo_entidad" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($tipo_entidad as $fila)
                                                <option value="{{$fila->Orden}}" {{($fila->Orden == $entidad->codTipoEntidad)?'selected':''}}>{{$fila->Nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">{!! Form::label('tipo_iniciativa', 'Tipo de incentivo') !!}
                                        <select name="tipo_iniciativa" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($tipo_incentivo as $fila)
                                                <option value="{{$fila->Orden}}" {{($fila->Orden == $postulante->codTipoIncentivo)?'selected':''}}>{{$fila->Nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">{!! Form::label('razon_social', 'Razon social') !!} {!! Form::text('razon_social', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombre']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">{!! Form::label('fecha_rrpp', 'Fecha RRPP') !!} {!! Form::date('fecha_rrpp', $entidad->fechaRRPP, ['class' => 'form-control', 'id' => 'input_fecha_rrpp', 'readonly' => 'readonly']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('ubigeo', 'Ubigeo') !!} {!! Form::text('ubigeo', $entidad->ubigeo, ['class' => 'form-control', 'id' => 'input_ubigeo', 'readonly' => 'readonly']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('estado_sunat', 'Estado SUNAT') !!} {!! Form::text('estado_sunat', $entidad->estadoContribuyente, ['class' => 'form-control', 'id' => 'input_estado_contribuyente', 'readonly' => 'readonly']) !!}</div>
                                    <div class="col-md-6">{!! Form::label('direccion', 'Dirección registrada en SUNAT') !!} {!! Form::text('direccion', $entidad->direccion, ['class' => 'form-control', 'id' => 'input_direccion', 'readonly' => 'readonly']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('nro_cut', 'Nº de CUT') !!} {!! Form::number('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('fecha_cut', 'Fecha') !!} {!! Form::date('fecha_cut', $expediente->fechaCut, ['class' => 'form-control']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('nro_expediente', 'Nº de Expediente') !!} {!! Form::number('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('oficina', 'Ubicación del expediente') !!}
                                        <select name="oficina" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($oficina as $fila)
                                                <option value="{{$fila->id}}" {{($fila->id == $expediente->codOficina)?'selected':''}}>{{$fila->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">{!! Form::label('area', 'Área asignada') !!}
                                        <select name="area" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($area as $fila)
                                                <option value="{{$fila->id}}" {{($fila->id == $expediente->codArea)?'selected':''}}>{{$fila->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">{!! Form::label('personal', 'Especialista asignado') !!}
                                        <select name="personal" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($personal as $fila)
                                                <option value="{{$fila->id}}" {{($fila->id == $expediente->codPersonalAsignado)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- Botonera  --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="Footer_UpdateExpediente_Enabled">
                                           <a href="#" id="btnUpdateExpediente" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                           <a href="{{ env('APP_URL') }}/proceso-pdn/proceso-ur" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                       </div>
                                       <div id="Footer_UpdateExpediente_Disabled" style="display:none;">
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
        //1. Obtengo el numero de ruc de la entidad a consultar
        $("#input_nro_documento").keypress(function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            if (tecla == 13) 
            {
                var ruc         =   $("#input_nro_documento").val();
                var caracteres  =   ruc.length;

                if (caracteres == 11) 
                {
                    event.preventDefault();
                    var urlAction = urlApp+'/ruc/'+ruc;
                    $.ajax({
                        url:    urlAction,
                        method: "GET",
                        data:   ruc,
                        beforeSend: function() {
                            $("#input_nombre").val("Consultando datos del proveedor ...");
                        },
                        success: function(response) {
                            var cadena      =   jQuery.parseJSON(response);
                            var estado      =   cadena.estado;
                            if (estado == 1)
                            {
                                $("#input_nombre").val(cadena.dato);
                                $("#input_estado_contribuyente").val(cadena.situacion);
                                $("#input_direccion").val(cadena.direccion);
                                $("#input_ubigeo").val(cadena.ubigeo);
                                $("#input_fecha_rrpp").val(cadena.fecha);
                            }
                            else
                            {
                                alertify.error('El RUC consultado se encuenta en estado: '+cadena.dato);
                                $("#input_nombre").val("");
                                $("#input_estado_contribuyente").val("");
                                $("#input_direccion").val("");
                                $("#input_ubigeo").val("");
                                $("#input_fecha_rrpp").val("");
                                $("#input_nro_documento").focus();
                                return false;
                            }
                        },
                        statusCode: {
                            404: function() {
                                alertify.error('El sistema presenta problemas de funcionamiento.');
                            }
                        }
                    });
                }
                else
                {
                    alertify.error('Error. Ingrese un número de RUC válido.');
                    $("#input_nro_documento").val("");
                    $("#input_nombre").val("");
                    $("#input_estado_contribuyente").val("");
                    $("#input_direccion").val("");
                    $("#input_ubigeo").val("");
                    $("#input_fecha_rrpp").val("");
                    $("#input_nro_documento").focus();
                    return false;
                }
            }
        });
        //2. Realizo el procesamiento del formulario
        $(document).on("click", '#btnUpdateExpediente', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateExpediente");
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
                    $("#Footer_UpdateExpediente_Enabled").css("display", "none");
                    $("#Footer_UpdateExpediente_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateExpediente_Enabled").css("display", "block");
                    $("#Footer_UpdateExpediente_Disabled").css("display", "none");
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
                    $("#ExpedienteAlerts").css("display", "block");
                    $("#ExpedienteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateExpediente_Enabled").css("display", "block");
                    $("#Footer_UpdateExpediente_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop