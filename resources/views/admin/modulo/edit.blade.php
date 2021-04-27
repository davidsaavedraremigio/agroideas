{!!Form::model($modulo,['id'=>'FormUpdateModulo', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['modulo.update',$modulo->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ModuloAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12">{!! Form::label('nombre', 'Nombre') !!} {!! Form::text('nombre', $modulo->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre del módulo']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12">{!! Form::label('descripcion', 'Descripción') !!} {!! Form::text('descripcion', $modulo->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción del módulo']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('orden', 'Nro Orden') !!} {!! Form::number('orden', $modulo->orden, ['class' => 'form-control', 'min' => '1', 'max' => '99']) !!}</div>
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('icono', 'Icono') !!} {!! Form::text('icono', $modulo->icono, ['class' => 'form-control', 'placeholder' => 'Código de icono']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div id="Footer_UpdateModulo_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateModulo" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateModulo_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}