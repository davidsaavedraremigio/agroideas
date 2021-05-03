{!! Form::open(array('id'=>'FormCreateProductorSda','url'=>'sda/productor','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Registrar Productores</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ProductorSdaAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nro. DNI') !!} {!! Form::text('dni', '', ['class' => 'form-control', 'placeholder' => '00000000', 'id' => 'input_nro_dni']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de nacimiento') !!} {!! Form::date('fecha', '', ['class' => 'form-control', 'min' => $minDate, 'max' => $maxDate ]) !!}</div>
            <div class="col-md-4">{!! Form::label('sexo', 'Sexo') !!}
                <select name="sexo" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1">Masculino</option>
                    <option value="0">Femenino</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', '', ['class' => 'form-control', 'id' => 'input_nombres', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Apellido paterno') !!} {!! Form::text('paterno', '', ['class' => 'form-control', 'id' => 'input_paterno', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Apellido materno') !!} {!! Form::text('materno', '', ['class' => 'form-control', 'id' => 'input_materno', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección') !!} {!! Form::text('direccion', '', ['class' => 'form-control', 'id' => 'input_direccion_dni', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo', 'Propietario / Pocesionario') !!}
                <select name="tipo" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1">PROPIETARIO</option>
                    <option value="2">POSECIONARIO</option>
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_ha', 'Nº de Ha') !!} {!! Form::text('nro_ha', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('aporte', 'Aporte (S/)') !!} {!! Form::text('aporte', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateProductorSda_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateProductorSda" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateProductorSda_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    var urlApp          = "{{ env('APP_URL') }}";
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