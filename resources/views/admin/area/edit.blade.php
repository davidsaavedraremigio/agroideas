{!!Form::model($area,['id'=>'FormUpdateArea', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['area.update',$area->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="AreaAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('sigla', 'Sigla') !!} {!! Form::text('sigla', $area->sigla, ['class' => 'form-control']) !!}</div>
            <div class="col-md-8">{!! Form::label('descripcion', 'Descripción') !!} {!! Form::text('descripcion', $area->descripcion, ['class' => 'form-control', 'placeholder' => 'Indique el nombre del área a registrar.']) !!}</div>
        </div>
    </div>    
</div>
<div class="modal-footer">
    <div id="Footer_UpdateArea_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateArea" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateArea_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}