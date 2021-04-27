{!!Form::model($usuario,['id'=>'FormUpdatePassword', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['usuario.update-password',$usuario->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar contraseña</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="PasswordAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-6 col-xs-6 col-lg-6">{!! Form::label('usuario', 'Usuario') !!} {!! Form::text('usuario', $usuario->email, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-6 col-xs-6 col-lg-6">{!! Form::label('password', 'Nueva contraseña (autogenerada)') !!} {!! Form::text('password', $clave, ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdatePassword_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdatePassword" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdatePassword_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}