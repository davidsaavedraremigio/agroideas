{!!Form::model($linea,['id'=>'FormUpdateLinea', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['linea.update',$linea->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="LineaAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('sector', 'Seleccione un sector') !!}
                <select name="sector" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($sectores as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $linea->maestroSectorID)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">{!! Form::label('descripcion', 'Descripción de la línea') !!} {!! Form::text('descripcion', $linea->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción de la línea']) !!}</div>
        </div>
    </div>    
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateLinea_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateLinea" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateLinea_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
