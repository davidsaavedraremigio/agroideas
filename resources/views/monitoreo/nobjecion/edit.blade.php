{!!Form::model($nobjecion,['id'=>'FormUpdateNoObjecion', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['nobjecion.update',$nobjecion->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="NoObjecionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', $nobjecion->fecha, ['class' => 'form-control', 'max' => date("Y-m-d")]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('numero', 'Nº de solicitud') !!} {!! Form::number('numero', $nobjecion->numero, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_carta_solicitud', 'Nº carta') !!} {!! Form::number('nro_carta_solicitud', $nobjecion->nroCartaSolicitud, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_carta_solicitud', 'Fecha de carta') !!} {!! Form::date('fecha_carta_solicitud', $nobjecion->fechaCartaSolicitud, ['class' => 'form-control', 'max' => date("Y-m-d")]) !!}</div>
        </div>
    </div>
    <hr class="my-4">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('justificacion', 'Justificación') !!} {!! Form::textarea('justificacion', $nobjecion->justificacion, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>    
</div>
<div class="modal-footer">
    <div id="Footer_UpdateNoObjecion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateNoObjecion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateNoObjecion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}