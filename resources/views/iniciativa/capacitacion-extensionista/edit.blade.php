{!!Form::model($extensionista,['id'=>'FormUpdateExtensionistaCapacitacion', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['capacitacion-extensionista.update',$extensionista->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExtensionistaCapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nº de DNI') !!} {!! Form::text('dni', $extensionista->dni, ['class' => 'form-control', 'id' => 'input_nro_dni', 'placeholder' => '00000000']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de nacimiento') !!} {!! Form::date('fecha', $extensionista->fecha, ['class' => 'form-control', 'id' => 'input_fecha']) !!}</div>
            <div class="col-md-4">{!! Form::label('sexo', 'Sexo') !!} 
                <select name="sexo" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1" {{($extensionista->sexo == 1)?'selected':''}}>Hombre</option>
                    <option value="0" {{($extensionista->sexo == 0)?'selected':''}}>Mujer</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', $extensionista->nombres, ['class' => 'form-control', 'id' => 'input_nombres', ]) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Paterno') !!} {!! Form::text('paterno', $extensionista->paterno, ['class' => 'form-control', 'id' => 'input_paterno', ]) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Materno') !!} {!! Form::text('materno', $extensionista->materno, ['class' => 'form-control', 'id' => 'input_materno', ]) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_ExtensionistaCapacitacion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateExtensionistaCapacitacion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_ExtensionistaCapacitacion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>