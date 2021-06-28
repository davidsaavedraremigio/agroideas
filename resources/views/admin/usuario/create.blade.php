{!! Form::open(array('id'=>'FormCreateUsuario','url'=>'admin/usuario','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
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
            <div class="col-md-4">{!! Form::label('personal', 'Colaborador') !!}
                <select name="personal" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($staff as $fila)
                        <option value="{{$fila->id}}">{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('cargo', 'Cargo') !!}
                <select name="cargo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cargos as $fila)
                        <option value="{{$fila->id}}">{{$fila->area}} - {{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('sede', 'Oficina') !!}
                <select name="sede" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($sedes as $fila)
                    <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('rol', 'Rol asignado') !!}
                <select name="rol" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($roles as $fila)
                    <option value="{{$fila->Valor}}">{{$fila->Nombre}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('email', 'Email') !!} {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'email@me.com']) !!}</div>
            <div class="col-md-4">{!! Form::label('password', 'Contraseña') !!} {!! Form::password('password', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateUsuario_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateUsuario" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateUsuario_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
@section('scripts')
<script>
    $('.select2').select2({
        theme: 'bootstrap4'
    });
</script>