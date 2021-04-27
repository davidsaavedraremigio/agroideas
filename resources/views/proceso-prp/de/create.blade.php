{!! Form::open(array('id'=>'FormCreateExpedienteDe','url'=>'proceso-prp/de','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Procesar expediente Nº {{$expediente->nroExpediente}}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExpedienteDeAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('referencia', $documento->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row"><div class="col-md-12"><label for="">I. REFERENCIA</label></div></div>
        <div class="row">
            <div class="col-md-6">{!! Form::label('tipo_documento_referencia', 'Tipo documento') !!}
                <select name="tipo_documento_referencia" class="form-control" disabled>
                    @foreach ($tipo_documento as $fila)
                    <option value="{{$fila->Orden}}" {{($fila->Orden == $documento->codTipoDocumento)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">{!! Form::label('nro_documento_referencia', 'Nº documento') !!} {!! Form::text('nro_documento_referencia', $documento->nroDocumento, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-3">{!! Form::label('fecha_documento_referencia', 'Fecha') !!} {!! Form::date('fecha_documento_referencia', $documento->fechaDocumento, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="row"><div class="col-md-12"><label for="">II. INFORMACIÓN GENERAL</label></div></div>
        <div class="row">
            <div class="col-md-3">{!! Form::label('fecha_recepcion', 'Fecha recepción') !!} {!! Form::date('fecha_recepcion', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-3">{!! Form::label('tipo_documento', 'Tipo documento') !!}
                <select name="tipo_documento" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_documento as $fila)
                    <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">{!! Form::label('nro_documento', 'Nº documento') !!} {!! Form::text('nro_documento', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-3">{!! Form::label('fecha_documento', 'Fecha') !!} {!! Form::date('fecha_documento', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('area_origen', 'Área origen') !!}
                <select name="area_origen" class="form-control" disabled>
                    @foreach ($areas as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $documento->codAreaDestino)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">{!! Form::label('area_destino', 'Área destino') !!}
                <select name="area" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($areas as $fila)
                        <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">{!! Form::label('nro_contrato', 'Nº contrato') !!} {!! Form::number('nro_contrato', '', ['class' => 'form-control', 'min' => '1', 'max' => '999']) !!}</div>
            <div class="col-md-3">{!! Form::label('fecha_contrato', 'Fecha contrato') !!} {!! Form::date('fecha_contrato', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-3">{!! Form::label('nro_resolucion', 'Nº R.M.') !!} {!! Form::number('nro_resolucion', '', ['class' => 'form-control', 'min' => '1', 'max' => '999']) !!}</div>
            <div class="col-md-3">{!! Form::label('fecha_resolucion', 'Fecha R.M.') !!} {!! Form::date('fecha_resolucion', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('comentarios', 'Comentarios adicionales') !!} {!! Form::textarea('comentarios', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('evidencia', 'Documentación que sustenta la evaluación') !!} {!! Form::file('evidencia', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('estado', 'Estado situacional') !!} 
                <select name="estado" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($estados as $fila)
                    <option value="{{$fila->Orden}}" {{($fila->Orden == $expediente->codEstado)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateExpedienteDe_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateExpedienteDe" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateExpedienteDe_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}