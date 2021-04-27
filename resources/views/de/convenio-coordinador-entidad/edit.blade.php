{!!Form::model($coordinador,['id'=>'FormUpdateCoordinadorEntidad', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-coordinador-entidad.update',$coordinador->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar información</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CoordinadorEntidadAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nº de DNI') !!} {!! Form::text('dni', $coordinador->nro_documento, ['class' => 'form-control', 'id' => 'input_nro_dni', 'placeholder' => '00000000']) !!}</div>
            <div class="col-md-4">{!! Form::label('cargo', 'Cargo') !!} {!! Form::text('cargo', $coordinador->cargo, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('tipo', 'Tipo de coordinador') !!}
                <select name="tipo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1" {{($coordinador->tipo == 1)?'selected':''}}>Titular</option>
                    <option value="2" {{($coordinador->tipo == 2)?'selected':''}}>Suplente</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', $coordinador->nombres, ['class' => 'form-control', 'id' => 'input_nombres', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Paterno') !!} {!! Form::text('paterno', $coordinador->paterno, ['class' => 'form-control', 'id' => 'input_paterno', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Materno') !!} {!! Form::text('materno', $coordinador->materno, ['class' => 'form-control', 'id' => 'input_materno', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('referencia', 'Nº de documento de designación') !!} {!! Form::text('referencia', $coordinador->referencia, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', $coordinador->fecha_referencia, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateCoordinadorEntidad_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateCoordinadorEntidad" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateCoordinadorEntidad_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}