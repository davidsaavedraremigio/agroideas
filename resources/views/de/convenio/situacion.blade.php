{!!Form::model($convenio,['id'=>'FormUpdateEstadoConvenioMarco', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-marco.situacion',$convenio->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar estado situacional</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="UpdateEstadoConvenioMarcoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_convenio', 'Nº de convenio') !!} {!! Form::number('nro_convenio', $convenio->numero, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de convenio') !!} {!! Form::date('fecha', $convenio->fecha_firma, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('duracion', 'Duración') !!} {!! Form::number('duracion', $convenio->duracion, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('estado', 'Estado situacional') !!}
                <select name="estado" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($estados as $fila)
                    <option value="{{$fila->Orden}}" {{($fila->Orden == $convenio->cod_estado)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_actualizacion', 'Fecha de actualización') !!} {!! Form::date('fecha_actualizacion', '', ['class' => 'form-control', 'min' => $convenio->fecha_firma, 'max' => $convenio->fecha_termino]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('justificacion', 'Justificación / Causa del cierre') !!} {!! Form::textarea('justificacion', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateEstadoConvenioMarco_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateEstadoConvenioMarco" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateEstadoConvenioMarco_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}