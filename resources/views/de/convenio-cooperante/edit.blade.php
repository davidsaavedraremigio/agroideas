{!!Form::model($cooperante,['id'=>'FormUpdateEntidadCooperante', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-cooperante.update',$cooperante->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CompromisoConvenioAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">{!! Form::label('', 'I. DATOS DE LA ENTIDAD COOPERANTE') !!}</div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('ruc', 'Nro RUC') !!} {!! Form::text('ruc', $entidad->nro_documento, ['class' => 'form-control', 'id' => 'input_ruc', 'placeholder' => '00000000000']) !!}</div>
            <div class="col-md-8">{!! Form::label('razon_social', 'Razon social') !!} {!! Form::text('razon_social', $entidad->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la organización', 'readonly' => 'readonly', 'id' => 'input_razon_social']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo', 'Tipo de entidad') !!} {!! Form::text('tipo', $entidad->tipo_entidad, ['class' => 'form-control', 'id' => 'input_tipo_entidad', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('ubigeo', 'Ubigeo') !!} {!! Form::text('ubigeo', $entidad->ubigeo, ['class' => 'form-control', 'id' => 'input_ubigeo', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('principal', 'Organización principal?') !!}
                <select name="principal" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1" {{($cooperante->principal == 1)?'selected':''}}>Si</option>
                    <option value="0" {{($cooperante->principal == 0)?'selected':''}}>No</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección registrada en SUNAT') !!} {!! Form::textarea('direccion', $entidad->direccion, ['class' => 'form-control', 'id' => 'input_direccion', 'readonly' => 'readonly', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">{!! Form::label('', 'II. REPRESENTANTE LEGAL') !!}</div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nº de DNI') !!} {!! Form::text('dni', $cooperante->nro_documento, ['class' => 'form-control', 'id' => 'input_nro_dni', 'placeholder' => '00000000']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Paterno') !!} {!! Form::text('paterno', $cooperante->paterno, ['class' => 'form-control', 'id' => 'input_paterno', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Materno') !!} {!! Form::text('materno', $cooperante->materno, ['class' => 'form-control', 'id' => 'input_materno', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', $cooperante->nombres, ['class' => 'form-control', 'id' => 'input_nombres', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-8">{!! Form::label('cargo', 'Cargo que desempeña') !!} {!! Form::text('cargo', $cooperante->cargo, ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateEntidadCooperante_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateEntidadCooperante" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateEntidadCooperante_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
{!! Form::close() !!}
<script>
    var urlApp          = "{{ env('APP_URL') }}";
    //3. Validamos la información del RUC
    $("#input_ruc").keypress(function(e) {
        var tecla = (e.keyCode ? e.keyCode : e.which);
        if (tecla == 13) 
        {
                var ruc         =   $("#input_ruc").val();
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
                            $("#input_razon_social").val("Consultando datos del proveedor ...");
                        },
                        success: function(response) {
                            var cadena      =   jQuery.parseJSON(response);
                            var estado      =   cadena.estado;
                            if (estado == 1)
                            {
                                $("#input_razon_social").val(cadena.dato);
                                $("#input_direccion").val(cadena.direccion);
                                $("#input_ubigeo").val(cadena.ubigeo);
                                $("#input_fecha_inicio").val(cadena.fecha);
                                $("#input_tipo_entidad").val(cadena.tipo);
                            }
                            else
                            {
                                alertify.error('El RUC consultado se encuenta en estado: '+cadena.dato);
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
                    $("#input_ruc").val("");
                    return false;
                }
        }
    });    
    $("#input_nro_dni").keypress(function(e) {
        var tecla = (e.keyCode ? e.keyCode : e.which);
        if (tecla == 13)
        {
            var dni         =   $("#input_nro_dni").val();
            var caracteres  =   dni.length;
            if (caracteres == 8)
            {
                event.preventDefault();
                var urlAction = urlApp+'/dni/'+dni;
                $.ajax({
                    url:    urlAction,
                    method: "GET",
                    data:   dni,
                    beforeSend: function() {
                        $("#input_paterno").val("Consultando ...");
                        $("#input_materno").val("Consultando ...");
                        $("#input_nombres").val("Consultando ...");
                    },
                    success: function(response) {
                        var cadena      =   jQuery.parseJSON(response);
                        var estado      =   cadena.estado;

                        if (estado == 200) 
                        {
                            $("#input_paterno").val(cadena.paterno);
                            $("#input_materno").val(cadena.materno);
                            $("#input_nombres").val(cadena.nombre);
                        }
                        else
                        {
                            alertify.error('El DNI consultado no figura en la base de datos.');
                            $("#input_paterno").val("");
                            $("#input_materno").val("");
                            $("#input_nombres").val("");
                            $("#input_nro_dni").val("");
                            $("#input_nro_dni").focus();
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
                alertify.error('Error. Ingrese un número de DNI válido.');
            }
        }
    });
</script>