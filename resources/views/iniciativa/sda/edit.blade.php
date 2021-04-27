@extends('layouts.template')
@section('title', 'Solicitudes de apoyo')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabSda" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabSda001" data-toggle="pill" href="#custom-tabs-sda" role="tab" aria-controls="custom-tabs-sda" aria-selected="true">1. Información general</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabSda002" data-toggle="pill" href="#custom-tabs-ambito" role="tab" aria-controls="custom-tabs-ambito" aria-selected="false">2. Ámbito de intervención</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabSda003" data-toggle="pill" href="#custom-tabs-productor" role="tab" aria-controls="custom-tabs-productor" aria-selected="false">3. Productores</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabSdaContent">
                    <div class="tab-pane fade show active" id="custom-tabs-sda" role="tabSda" aria-labelledby="TabSda001">
                        {!!Form::model($postulante,['id'=>'FormUpdateSda', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['sda.update',$postulante->id]])!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="SdaAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12"><label for="">I. Datos de la organización</label></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ruc', 'Nro de RUC (*)') !!} {!! Form::text('ruc', $entidad->nroDocumento, ['class' => 'form-control', 'placeholder' => '00000000000', 'maxlength' => '11', 'id' => 'input_nro_documento']) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo_entidad', 'Tipo de organización (*)') !!}
                                    <select name="tipo_entidad" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoEntidad as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $entidad->codTipoEntidad)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">{!! Form::label('nombre', 'Razon social (*)') !!}{!! Form::text('nombre', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombre']) !!}</div>    
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ubigeo', 'Código ubigeo (*)') !!} {!! Form::text('ubigeo', $entidad->ubigeo, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_ubigeo']) !!}</div>
                                <div class="col-md-9">{!! Form::label('direccion', 'Dirección (*)') !!} {!! Form::text('direccion', $entidad->direccion, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_direccion']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row"><div class="col-md-12">{!! Form::label('', 'II. Datos de la propuesta de SDA:') !!}</div></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-9">{!! Form::label('titulo', 'Nombre del Plan de negocio') !!} {!! Form::text('titulo', $proyecto->tituloProyecto, ['class' =>'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo', 'Tipo de incentivo') !!}
                                    <select name="tipo" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoIncentivo as $fila)
                                            @if ($fila->Orden != 2)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $postulante->codTipoIncentivo)?'selected':''}}>{{$fila->Nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('cadena', 'Cultivo / Crianza') !!}
                                    <select name="cadena" class="form-control select2" id ="inputCadena">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($cadena as $fila)
                                            <option value="{{$fila->id}}" {{($fila->id == $producto->codCadena)?'selected':''}}>{{$fila->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('variedad', 'Variedad') !!} {!! Form::text('variedad', $producto->variedad, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo_produccion', 'Tipo de producción') !!}
                                    <select name="tipo_produccion" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoProduccion as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $producto->tipoProduccion)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('nro_ha', 'Nº Has') !!} {!! Form::text('nro_ha', number_format($proyecto->area,2,'.',''), ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('productores_varones', 'Nº hombres') !!} {!! Form::number('productores_varones', $proyecto->nro_beneficiarios_varones, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('productores_mujeres', 'Nº mujeres') !!} {!! Form::number('productores_mujeres', $proyecto->nro_beneficiarios_mujeres, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('productores', 'Total') !!} {!! Form::number('productores', $proyecto->nro_beneficiarios, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('inversion', 'Inversión (S/.)') !!} {!! Form::text('inversion', number_format($proyecto->inversion_total,2,'.',''), ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_UpdateSda_Enabled">
                                       <a href="#" id="btnUpdateSda" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/iniciativa/sda" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_UpdateSda_Disabled" style="display:none;">
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
{{-- Fin del contenido--}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        var urlApp  = "{{ env('APP_URL') }}";
        //1. Obtengo los datos de SUNAT
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
        //2. Actualizo el registro
        $(document).on("click", '#btnUpdateSda', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateSda");
            var urlAction = form.attr('action');
            var formData = new FormData(form[0]);
            var dataAll = form.serialize();
            var formMethod = form.attr('method');
            $.ajax({
                url: urlAction,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#Footer_UpdateSda_Enabled").css("display", "none");
                    $("#Footer_UpdateSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateSda_Enabled").css("display", "block");
                    $("#Footer_UpdateSda_Disabled").css("display", "none");
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
                    $("#Footer_UpdateSda_Enabled").css("display", "block");
                    $("#Footer_UpdateSda_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop