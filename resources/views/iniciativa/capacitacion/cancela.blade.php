{!!Form::model($capacitacion,['id'=>'FormCancelaCapacitacion', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['capacitacion.cancela',$capacitacion->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Cancelar evento</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CancelaCapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('nombre', 'Nombre del evento') !!} {!! Form::textarea('nombre', $capacitacion->nombre, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('justificacion', 'Justificación') !!} {!! Form::textarea('justificacion', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Justificar la cancelación del evento']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CancelaCapacitacion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCancelaCapacitacion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CancelaCapacitacion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}