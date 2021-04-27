{!! Form::open(array('id'=>'FormCreateCoordinadorEntidad','url'=>'de/convenio-coordinador-entidad','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Registro de coordinadores</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CoordinadorEntidadAlerts" class="alert alert-danger" style="display: none;"></div>
    <input type="hidden" name="codigo" value="{{$convenio->id}}">
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nº de DNI') !!} {!! Form::text('dni', '', ['class' => 'form-control', 'id' => 'input_nro_dni_entidad', 'placeholder' => '00000000']) !!}</div>
            <div class="col-md-4">{!! Form::label('cargo', 'Cargo') !!} {!! Form::text('cargo', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('tipo', 'Tipo de coordinador') !!}
                <select name="tipo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1">Titular</option>
                    <option value="2">Suplente</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', '', ['class' => 'form-control', 'id' => 'input_nombres_entidad', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Paterno') !!} {!! Form::text('paterno', '', ['class' => 'form-control', 'id' => 'input_paterno_entidad', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Materno') !!} {!! Form::text('materno', '', ['class' => 'form-control', 'id' => 'input_materno_entidad', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('referencia', 'Nº de documento de designación') !!} {!! Form::text('referencia', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateCoordinadorEntidad_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateCoordinadorEntidad" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateCoordinadorEntidad_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    var urlApp          = "{{ env('APP_URL') }}";
    $("#input_nro_dni_entidad").keypress(function(e) {
        var tecla = (e.keyCode ? e.keyCode : e.which);
        if (tecla == 13)
        {
            var dni         =   $("#input_nro_dni_entidad").val();
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
                        $("#input_paterno_entidad").val("Consultando ...");
                        $("#input_materno_entidad").val("Consultando ...");
                        $("#input_nombres_entidad").val("Consultando ...");
                    },
                    success: function(response) {
                        var cadena      =   jQuery.parseJSON(response);
                        var estado      =   cadena.estado;

                        if (estado == 200) 
                        {
                            $("#input_paterno_entidad").val(cadena.paterno);
                            $("#input_materno_entidad").val(cadena.materno);
                            $("#input_nombres_entidad").val(cadena.nombre);
                        }
                        else
                        {
                            alertify.error('El DNI consultado no figura en la base de datos.');
                            $("#input_paterno_entidad").val("");
                            $("#input_materno_entidad").val("");
                            $("#input_nombres_entidad").val("");
                            $("#input_nro_dni_entidad").val("");
                            $("#input_nro_dni_entidad").focus();
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