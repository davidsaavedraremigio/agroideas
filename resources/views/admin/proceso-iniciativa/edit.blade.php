{!!Form::model($proceso,['id'=>'FormUpdateProcesoIniciativa', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['proceso-iniciativa.update',$proceso->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ProcesoIniciativaAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('tipo_iniciativa', 'Tipo de iniciativa') !!}
                <select name="tipo_iniciativa" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_iniciativa as $fila)
                    <option value="{{$fila->Orden}}" {{($fila->Orden == $proceso->codTipoIniciativa)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">{!! Form::label('area', 'Area') !!}
                <select name="area" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($areas as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $proceso->codMaestroArea)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">{!! Form::label('nro_orden', 'Nº de orden') !!} {!! Form::number('nro_orden', $proceso->orden, ['class' => 'form-control', 'min' => '1', 'max' => '100']) !!}</div>
            <div class="col-md-9">{!! Form::label('descripcion', 'Nombre del proceso') !!} {!! Form::text('descripcion', $proceso->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción del proceso']) !!}</div>
        </div>
    </div>    
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateProcesoIniciativa_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateProcesoIniciativa" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateProcesoIniciativa_Disabled" style="display:none;">
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