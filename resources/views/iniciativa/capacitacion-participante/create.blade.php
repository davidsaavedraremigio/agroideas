{!! Form::open(array('id'=>'FormCreateParticipanteCapacitacion','url'=>'iniciativa/capacitacion-participante','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ParticipanteCapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <input type="hidden" name="codigo" value="{{$capacitacion->id}}">
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', 'I. Datos del participante:') !!}</div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nº de DNI') !!} {!! Form::text('dni', '', ['class' => 'form-control', 'id' => 'input_nro_dni', 'placeholder' => '00000000']) !!}</div>
            <div class="col-md-4">{!! Form::label('edad', 'Edad') !!} {!! Form::number('edad', '', ['class' => 'form-control', 'min' => '18', 'max' => '99']) !!}</div>
            <div class="col-md-4">{!! Form::label('sexo', 'Sexo') !!} 
                <select name="sexo" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1">Hombre</option>
                    <option value="0">Mujer</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', '', ['class' => 'form-control', 'id' => 'input_nombres', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Paterno') !!} {!! Form::text('paterno', '', ['class' => 'form-control', 'id' => 'input_paterno', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Materno') !!} {!! Form::text('materno', '', ['class' => 'form-control', 'id' => 'input_materno', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', 'II. Caracterización del participante al evento de capacitación:') !!}</div></div>
        <div class="row"><div class="col-md-12">{!! Form::label('', '2.1. Si el participante SI es un productor, por favor completar la información:') !!}</div></div>
        <div class="row">
            <div class="col-md-6">{!! Form::label('actividad_productor', 'Actividad') !!}
                <select name="actividad_productor" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($actividad_productor  as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">{!! Form::label('cadena_agricola', 'Agrícola') !!}
                <select name="cadena_agricola" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadena_agricola as $fila)
                        <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">{!! Form::label('cadena_pecuaria', 'Pecuaria') !!}
                <select name="cadena_pecuaria" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadena_pecuaria as $fila)
                        <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">{!! Form::label('cadena_forestal', 'Forestal') !!}
                <select name="cadena_forestal" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadena_forestal as $fila)
                        <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', '2.2. Si el participante NO es un productor, por favor completar la información:') !!}</div></div>
        <div class="row">
            <div class="col-md-6">{!! Form::label('actividad_participante', 'Actividad') !!}
                <select name="actividad_participante" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($actividad_participante as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">{!! Form::label('detalla_otro', 'Detalle del Tipo de Participante') !!} {!! Form::text('detalla_otro', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', 'III. Si el productor pertenece a una organización, entonces registre los campos siguientes:') !!}</div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('ruc', 'Nro RUC') !!} {!! Form::text('ruc', '', ['class' => 'form-control', 'id' => 'input_ruc', 'placeholder' => '00000000000']) !!}</div>
            <div class="col-md-8">{!! Form::label('razon_social', 'Razon social') !!} {!! Form::text('razon_social', '', ['class' => 'form-control', 'placeholder' => 'Nombre de la organización', 'readonly' => 'readonly', 'id' => 'input_razon_social']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_entidad', 'Tipo de entidad') !!}
                <select name="tipo_entidad" id="input_tipo_entidad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_entidad as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('ubigeo', 'Ubigeo') !!} {!! Form::text('ubigeo', '', ['class' => 'form-control', 'id' => 'input_ubigeo', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_inicio', 'Fecha de inscripción') !!} {!! Form::date('fecha_inicio', '', ['class' => 'form-control', 'id' => 'input_fecha_inicio', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección registrada en SUNAT') !!} {!! Form::textarea('direccion', '', ['class' => 'form-control', 'id' => 'input_direccion', 'readonly' => 'readonly', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_ParticipanteCapacitacion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateParticipanteCapacitacion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateParticipanteCapacitacion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    var urlApp          = "{{ env('APP_URL') }}";
    //1. Validamos la información del DNI
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    //2. Validamos la información del DNI
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
                var urlAction = route("servicio.sunat", ruc);
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
                            $("#input_tipo_entidad").append('<option value="'+cadena.codigo+'" selected="selected">'+cadena.tipo+'</option>');
                            $("#input_fecha_inicio").val(cadena.fecha);
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
</script>