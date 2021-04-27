{!!Form::model($ubigeo,['id'=>'FormUpdateUbigeo', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['ubigeo.update',$ubigeo->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="UbigeoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('codigo', 'Codigo ubigeo') !!} {!! Form::text('codigo', $ubigeo->id, ['class' => 'form-control', 'placeholder' => '000000']) !!}</div>
            <div class="col-md-8 col-lg-8 col-xs-8">{!! Form::label('nombre', 'Nombre') !!} {!! Form::text('nombre', $ubigeo->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la región / provincia / distrito']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div id="Footer_UpdateUbigeo_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateUbigeo" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateUbigeo_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}