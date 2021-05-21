{!!Form::model($participante,['id'=>'FormUpdateParticipanteCapacitacion', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['capacitacion-participante.update',$participante->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ParticipanteCapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', 'I. Datos del participante:') !!}</div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nº de DNI') !!} {!! Form::text('dni', $participante->dni, ['class' => 'form-control', 'id' => 'input_nro_dni', 'placeholder' => '00000000']) !!}</div>
            <div class="col-md-4">{!! Form::label('edad', 'Edad') !!} {!! Form::number('edad', $edad, ['class' => 'form-control', 'min' => '18', 'max' => '99']) !!}</div>
            <div class="col-md-4">{!! Form::label('sexo', 'Sexo') !!} 
                <select name="sexo" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1" {{($participante->sexo == 1)?'selected':''}}>Hombre</option>
                    <option value="0" {{($participante->sexo == 0)?'selected':''}}>Mujer</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', $participante->nombres, ['class' => 'form-control', 'id' => 'input_nombres', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Paterno') !!} {!! Form::text('paterno', $participante->paterno, ['class' => 'form-control', 'id' => 'input_paterno', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Materno') !!} {!! Form::text('materno', $participante->materno, ['class' => 'form-control', 'id' => 'input_materno', 'readonly' => 'readonly']) !!}</div>
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
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $participante->codActividadProductor)?'selected':''}}>{{$fila->Nombre}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">{!! Form::label('cadena_agricola', 'Agrícola') !!}
                <select name="cadena_agricola" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadena_agricola as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $participante->codCadenaAgricola)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">{!! Form::label('cadena_pecuaria', 'Pecuaria') !!}
                <select name="cadena_pecuaria" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadena_pecuaria as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $participante->codCadenaPecuaria)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">{!! Form::label('cadena_forestal', 'Forestal') !!}
                <select name="cadena_forestal" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadena_forestal as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $participante->codCadenaForestal)?'selected':''}}>{{$fila->descripcion}}</option>
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
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $participante->codActividadParticipante)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">{!! Form::label('detalla_otro', 'Detalle del Tipo de Participante') !!} {!! Form::text('detalla_otro', $participante->detalleOtraActividad, ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    @if ($opa != null)
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', 'III. Si el productor pertenece a una organización, entonces registre los campos siguientes:') !!}</div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('ruc', 'Nro RUC') !!} {!! Form::text('ruc', $opa->nroDocumento, ['class' => 'form-control', 'id' => 'input_ruc', 'placeholder' => '00000000000']) !!}</div>
            <div class="col-md-8">{!! Form::label('razon_social', 'Razon social') !!} {!! Form::text('razon_social', $opa->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la organización', 'readonly' => 'readonly', 'id' => 'input_razon_social']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_entidad', 'Tipo de entidad') !!}
                <select name="tipo_entidad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_entidad as $fila)
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $opa->codTipoEntidad)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('ubigeo', 'Ubigeo') !!} {!! Form::text('ubigeo', $opa->ubigeo, ['class' => 'form-control', 'id' => 'input_ubigeo', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_inicio', 'Fecha de inscripción') !!} {!! Form::date('fecha_inicio', $opa->fechaRRPP, ['class' => 'form-control', 'id' => 'input_fecha_inicio', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección registrada en SUNAT') !!} {!! Form::textarea('direccion', $opa->direccion, ['class' => 'form-control', 'id' => 'input_direccion', 'readonly' => 'readonly', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    @endif
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_ParticipanteCapacitacion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateParticipanteCapacitacion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_ParticipanteCapacitacion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>