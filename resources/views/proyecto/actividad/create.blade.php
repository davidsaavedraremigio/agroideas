{!! Form::open(array('id'=>'FormCreateActividad','route'=>'actividad.store','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Importar actividades</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ActividadAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('codigo', 'Código del Proyecto') !!} {!! Form::text('codigo', $postulante->id, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-8">{!! Form::label('file', 'Seleccionar archivo a importar') !!} {!! Form::file('file', ['class' => 'form-control']) !!}</div>
        </div>
    </div>




</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateActividad_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateActividad" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateActividad_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
