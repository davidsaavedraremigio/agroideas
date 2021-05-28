{!! Form::open(array('id'=>'FormCreateProductor','route'=>'productor-prpa.store','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Módulo para el registro de nuevos productores</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ProductorAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_documento', 'Nro. DNI') !!} {!! Form::text('nro_documento', '', ['class' => 'form-control', 'placeholder' => '00000000', 'id' => 'input_nro_dni']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de nacimiento') !!} {!! Form::date('fecha', '', ['class' => 'form-control', 'placeholder' => 'yyyy-mm-dd', 'min' => $minDate, 'max' => $maxDate]) !!}</div>
            <div class="col-md-4">{!! Form::label('sexo', 'Sexo') !!} 
                <select name="sexo" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="0">Femenino</option>
                    <option value="1">Masculino</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombres']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Apellido paterno') !!} {!! Form::text('paterno', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_paterno']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Apellido materno') !!} {!! Form::text('materno', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_materno']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección (La que figura en RENIEC)') !!} {!! Form::textarea('direccion', '', ['class' => 'form-control', 'readonly' => 'readonly', 'cols' => '2', 'rows' => '2', 'id' => 'input_direccion_dni']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_propietario', 'Propietario / Pocesionario') !!}
                <select name="tipo_propietario" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1">PROPIETARIO</option>
                    <option value="2">POSECIONARIO</option>
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_ha_solicitada', 'Área a reconvertir (ha) ') !!} {!! Form::text('nro_ha_solicitada', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_ha', 'Área total (ha)') !!} {!! Form::text('nro_ha', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateProductor_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateProductor" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateProductor_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    $("#input_nro_dni").keypress(function(e) {
        var tecla = (e.keyCode ? e.keyCode : e.which);
        if (tecla == 13) 
        {
            var dni         =   $("#input_nro_dni").val();
            var caracteres  =   dni.length;

            if (caracteres == 8)
            {
                event.preventDefault();
                var urlAction = route("servicio.dni", dni);
                $.ajax({
                    url:    urlAction,
                    method: "GET",
                    data:   dni,
                    beforeSend: function() {
                        $("#input_paterno").val("Consultando ...");
                        $("#input_materno").val("Consultando ...");
                        $("#input_nombres").val("Consultando ...");
                        $("#input_direccion_dni").val("Consultando ...");
                    },
                    success: function(response) {
                        var cadena      =   jQuery.parseJSON(response);
                        var estado      =   cadena.estado;

                        if (estado == 200) 
                        {
                            $("#input_paterno").val(cadena.paterno);
                            $("#input_materno").val(cadena.materno);
                            $("#input_nombres").val(cadena.nombre);
                            $("#input_direccion_dni").val(cadena.direccion);
                        }
                        else
                        {
                            alertify.error('El DNI consultado no figura en la base de datos.');
                            $("#input_paterno").val("");
                            $("#input_materno").val("");
                            $("#input_nombres").val("");
                            $("#input_direccion_dni").val("");
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
                $("#input_paterno").val("");
                $("#input_materno").val("");
                $("#input_nombres").val("");
                $("#input_direccion_dni").val("");
                $("#input_nro_dni").val("");
                $("#input_nro_dni").focus();
                return false;
            } 
        }
    });
</script>