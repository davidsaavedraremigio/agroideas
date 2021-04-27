@extends('layouts.template')
@section('title', 'Registrar nuevo pedido de solicitud de apoyo')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabPRP" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabSda001" data-toggle="pill" href="#custom-tabs-sda" role="tab" aria-controls="custom-tabs-sda" aria-selected="true">1. Información general</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabSdaContent">
                    <div class="tab-pane fade show active" id="custom-tabs-sda" role="tabSda" aria-labelledby="TabSda001">
                        {!!Form::open(array('id'=>'FormCreateSda','url'=>'iniciativa/sda','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data'))!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="SdaAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12"><label for="">I. Datos de la organización</label></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ruc', 'Nro de RUC (*)') !!} {!! Form::text('ruc', '', ['class' => 'form-control', 'placeholder' => '00000000000', 'maxlength' => '11', 'id' => 'input_nro_documento']) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo_entidad', 'Tipo de organización (*)') !!}
                                    <select name="tipo_entidad" id="input_tipo_entidad" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoEntidad as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">{!! Form::label('nombre', 'Razon social (*)') !!}{!! Form::text('nombre', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombre']) !!}</div>    
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ubigeo', 'Código ubigeo (*)') !!} {!! Form::text('ubigeo', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_ubigeo']) !!}</div>
                                <div class="col-md-9">{!! Form::label('direccion', 'Dirección (*)') !!} {!! Form::text('direccion', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_direccion']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row"><div class="col-md-12">{!! Form::label('', 'II. Datos de la propuesta de SDA:') !!}</div></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('tipo', 'Tipo de incentivo') !!}
                                    <select name="tipo" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoIncentivo as $fila)
                                            @if ($fila->Orden != 2)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('cadena', 'Cultivo / Crianza') !!}
                                    <select name="cadena" class="form-control select2" id ="inputCadena">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($cadena as $fila)
                                            <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('nro_ha_total', 'Nº Has total') !!} {!! Form::text('nro_ha_total', '', ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('nro_ha', 'Nº Has destinadas al cultivo') !!} {!! Form::text('nro_ha', '', ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('productores_varones', 'Nº hombres') !!} {!! Form::number('productores_varones', '', ['class' => 'form-control beneficiario', 'min' => '1', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                <div class="col-md-3">{!! Form::label('productores_mujeres', 'Nº mujeres') !!} {!! Form::number('productores_mujeres', '', ['class' => 'form-control beneficiario', 'min' => '1', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                <div class="col-md-3">{!! Form::label('productores', 'Total') !!} {!! Form::number('productores', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_beneficiarios_total']) !!}</div>
                                <div class="col-md-3">{!! Form::label('inversion', 'Inversión (S/.)') !!} {!! Form::text('inversion', '', ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_CreateSda_Enabled">
                                       <a href="#" id="btnCreateSda" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/iniciativa/sda" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_CreateSda_Disabled" style="display:none;">
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
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //1. Obtengo los datos de SUNAT
        var urlApp  = "{{ env('APP_URL') }}";
        $("#input_nro_documento").keypress(function(e) {
            var tecla   = (e.keyCode ? e.keyCode : e.which);
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
                                $("#input_direccion").val(cadena.direccion);
                                $("#input_ubigeo").val(cadena.ubigeo);
                                $("#input_tipo_entidad").append('<option value="'+cadena.codigo+'" selected="selected">'+cadena.tipo+'</option>');
                            }
                            else
                            {
                                alertify.error('El RUC consultado se encuenta en estado: '+cadena.dato);
                                $("#input_nombre").val("");
                                $("#input_direccion").val("");
                                $("#input_ubigeo").val("");
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
                    $("#input_direccion").val("");
                    $("#input_ubigeo").val("");
                    $("#input_nro_documento").focus();
                    return false;
                }
            }
        });
        //2. Guardamos la información
        $(document).on("click", '#btnCreateSda', function (event) {
            event.preventDefault();
            var form = $("#FormCreateSda");
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
                    $("#Footer_CreateSda_Enabled").css("display", "none");
                    $("#Footer_CreateSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje     = response.mensaje;
                    var codigo      = response.dato;
                    var url_edit    = codigo +'/edit';
                    alertify.success(mensaje);
                    $("#Footer_CreateSda_Enabled").css("display", "block");
                    $("#Footer_CreateSda_Disabled").css("display", "none");
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
                    $("#SdaAlerts").css("display", "block");
                    $("#SdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateSda_Enabled").css("display", "block");
                    $("#Footer_CreateSda_Disabled").css("display", "none");
                }
            });
        });
    });

    //a. Sumanos la cantidad de productores
    function sumaBeneficiarios() {
        var add = 0;
        $('.beneficiario').each(function() {
            if (!isNaN($(this).val())) {
                add += Number($(this).val());
            }
        });
        $('#input_beneficiarios_total').val(add);
    };

</script>
@stop