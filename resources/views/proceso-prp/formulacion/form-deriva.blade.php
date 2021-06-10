{!!Form::model($expediente,['id'=>'FormDerivaExpedienteUpfp', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['formulacion.deriva-expediente',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Derivar expediente Nº {{$expediente->nroExpediente}} a la Unidad de Negocios</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="DerivaExpedienteUpfpAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('especialista', 'Especialista responsable') !!}
                <select name="especialista" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $upfp->cod_responsable_form)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_informe', 'Nº de informe') !!} {!! Form::number('nro_informe', $upfp->nro_informe_form, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe', 'Fecha') !!} {!! Form::date('fecha_informe', $upfp->fecha_informe_form, ['class' => 'form-control', 'min' => $expediente->fechaEsxpediente, 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_memo', 'Nº de memorandum') !!} {!! Form::number('nro_memo', $upfp->nro_memo_derivacion, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_memo', 'Fecha') !!} {!! Form::date('fecha_memo', $upfp->fecha_memo_derivacion, ['class' => 'form-control', 'min' => $expediente->fechaExpediente, 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_derivacion', 'Fecha de derivación') !!} {!! Form::date('fecha_derivacion', date('Y-m-d'), ['class' => 'form-control', 'min' => $expediente->fechaExpediente, 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_DerivaExpedienteUpfp_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnDerivaExpedienteUpfp" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_DerivaExpedienteUpfp_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}