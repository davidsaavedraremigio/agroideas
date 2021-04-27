{!!Form::model($usuario,['id'=>'FormUpdateUsuario', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['usuario.update',$usuario->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="UsuarioAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('personal', 'Persona a la que se le genera el usuario') !!}
                <select name="personal" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($staff as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $usuarioStaff->codStaff)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">{!! Form::label('cargo', 'Cargo') !!}
                <select name="cargo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cargos as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $usuarioCargo->codMaestroCargo)?'selected':''}}>{{$fila->area}} - {{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('sede', 'Oficina') !!}
                <select name="sede" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($sedes as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $usuarioSede->codMaestroOficina)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('email', 'Email') !!} {!! Form::email('email', $usuario->email, ['class' => 'form-control', 'placeholder' => 'email@me.com']) !!}</div>
            <div class="col-md-4">{!! Form::label('password01', 'Contraseña') !!} {!! Form::password('password01', ['class' => 'form-control', 'disabled' => 'disabled']) !!}</div>
            {!! Form::hidden('password', $usuario->email, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateUsuario_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateUsuario" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateUsuario_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}