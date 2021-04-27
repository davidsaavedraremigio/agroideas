{!!Form::model($ampliacion,['id'=>'FormUpdateConvenioAmpliacion', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-ampliacion.update',$ampliacion->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar información</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ConvenioAmpliacionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('numero', 'Número de adenda') !!} {!! Form::number('numero', $ampliacion->numero, ['class' => 'form-control', 'min' => '1', 'max' => '10']) !!}</div>
            <div class="col-md-4">{!! Form::label('tipo', 'Tipo') !!}
                <select name="tipo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo as $fila)
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $ampliacion->cod_tipo)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', $ampliacion->fecha_firma, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('objetivo', 'Objetivo') !!} {!! Form::textarea('objetivo', $ampliacion->objetivo, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('termino', 'Nueva fecha de término') !!} {!! Form::date('termino', $ampliacion->fecha_termino, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateConvenioAmpliacion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateConvenioAmpliacion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateConvenioAmpliacion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}