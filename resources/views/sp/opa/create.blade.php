@extends('layouts.template')
@section('title', 'Registro de organizaciones de productores')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabEntidad" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabEntidad001" data-toggle="pill" href="#custom-tabs-entidad" role="tab" aria-controls="custom-tabs-entidad" aria-selected="true">Información general</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="TabEntidad002" data-toggle="pill" href="#custom-tabs-beneficiarios" role="tab" aria-controls="custom-tabs-beneficiarios" aria-selected="false">Beneficiarios</a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" id="TabEntidad003" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Representantes legales</a>
                    </li>-->
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabEntidadContent">
                    <div class="tab-pane fade show active" id="custom-tabs-entidad" role="tabpanel" aria-labelledby="TabEntidad001">
                        {!!Form::open(array('id'=>'FormCreateEntidad','url'=>'sp/opa','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="EntidadAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('tipo_entidad', 'Tipo de organización') !!}
                                    <select name="tipo_entidad" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipo_entidad as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('nro_documento', 'Nro de RUC') !!} {!! Form::text('nro_documento', '', ['class' => 'form-control', 'placeholder' => '00000000000', 'maxlength' => '11', 'id' => 'input_nro_documento']) !!}</div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('nombre', 'Razon social') !!} {!! Form::textarea('nombre', '', ['class' => 'form-control', 'readonly' => 'readonly', 'cols' => '2', 'rows' => '2', 'id' => 'input_nombre']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('fecha_rrpp', 'Fecha de inscripción SUNARP') !!} {!! Form::date('fecha_rrpp', '', ['class' => 'form-control', 'placeholder' => 'yyyy-mm-dd', 'id' => 'input_fecha_rrpp']) !!}</div>
                                <div class="col-md-3">{!! Form::label('ubigeo', 'Código ubigeo') !!} {!! Form::text('ubigeo', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_ubigeo']) !!}</div>
                                <div class="col-md-3">{!! Form::label('estado_domicilio', 'Condición domicilio') !!} {!! Form::text('estado_domicilio', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_estado_domicilio']) !!}</div>
                                <div class="col-md-3">{!! Form::label('estado_contribuyente', 'Estado en SUNAT') !!} {!! Form::text('estado_contribuyente', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_estado_contribuyente']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('direccion', 'Dirección') !!} {!! Form::textarea('direccion', '', ['class' => 'form-control', 'readonly' => 'readonly', 'cols' => '2', 'rows' => '2', 'id' => 'input_direccion']) !!}</div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_CreateEntidad_Enabled">
                                       <a href="#" id="btnCreateEntidad" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/sp/opa" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_CreateEntidad_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!--<div class="tab-pane fade" id="custom-tabs-beneficiarios" role="tabpanel" aria-labelledby="TabEntidad002"></div>
                    <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="TabEntidad003"></div>-->
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
                                $("#input_estado_domicilio").val(cadena.domicilio);
                                $("#input_estado_contribuyente").val(cadena.situacion);
                                $("#input_direccion").val(cadena.direccion);
                                $("#input_ubigeo").val(cadena.ubigeo);
                                $("#input_fecha_rrpp").val(cadena.fecha);
                            }
                            else
                            {
                                alertify.error('El RUC consultado se encuenta en estado: '+cadena.dato);
                                $("#input_nombre").val("");
                                $("#input_estado_domicilio").val("");
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
                    $("#input_estado_domicilio").val("");
                    $("#input_estado_contribuyente").val("");
                    $("#input_direccion").val("");
                    $("#input_ubigeo").val("");
                    $("#input_fecha_rrpp").val("");
                    $("#input_nro_documento").focus();
                    return false;
                }
            }
        });
        //2. Proceso el formulario
        $(document).on("click", '#btnCreateEntidad', function (event) {
            event.preventDefault();
            var form = $("#FormCreateEntidad");
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
                    $("#Footer_CreateEntidad_Enabled").css("display", "none");
                    $("#Footer_CreateEntidad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje     = response.mensaje;
                    var codigo      = response.dato;
                    var url_edit    = codigo +'/edit';
                    alertify.success(mensaje);
                    $("#Footer_CreateEntidad_Enabled").css("display", "block");
                    $("#Footer_CreateEntidad_Disabled").css("display", "none");
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
                    $("#EntidadAlerts").css("display", "block");
                    $("#EntidadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateEntidad_Enabled").css("display", "block");
                    $("#Footer_CreateEntidad_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop
