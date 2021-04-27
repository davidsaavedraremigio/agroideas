{!!Form::model($proceso,['id'=>'FormUpdateProceso', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['proceso.update',$proceso->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ProcesoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('parent', 'Seleccionar módulo') !!} 
                <select name="parent" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($modulos as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $proceso->parent)?'selected':''}}>{{$fila->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8 col-lg-8 col-xs-8">{!! Form::label('nombre', 'Nombre') !!} {!! Form::text('nombre', $proceso->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre del proceso']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12">{!! Form::label('descripcion', 'Descripción') !!} {!! Form::text('descripcion', $proceso->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción del módulo']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('orden', 'Nro Orden') !!} {!! Form::number('orden', $proceso->orden, ['class' => 'form-control', 'min' => '1', 'max' => '99']) !!}</div>
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('ruta', 'Ubicación') !!} {!! Form::text('ruta', $proceso->ruta, ['class' => 'form-control', 'placeholder' => 'Ingrese la ruta del controlador']) !!}</div>
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('icono', 'Icono') !!} {!! Form::text('icono', $proceso->icono, ['class' => 'form-control', 'placeholder' => 'Código de icono']) !!}</div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <div id="Footer_UpdateProceso_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateProceso" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateProceso_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}