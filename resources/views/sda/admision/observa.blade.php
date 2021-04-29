{!!Form::model($expediente,['id'=>'FormObservaSdaUr', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['admision.procesa-observacion',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Observar expediente</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExpedienteSdaUrAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nº de trámite (CUT)') !!} {!! Form::text('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nº de Expediente') !!} {!! Form::text('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control', 'max' => date('Y-m-d'), 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">II. INFORME DE EVALUACIÓN</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('especialista', 'Especialista responsable') !!}
                <select name="especialista" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $ur->cod_responsable_evaluacion)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_informe', 'Nº de informe') !!} {!! Form::text('nro_informe', $ur->nro_informe, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe', 'Fecha') !!} {!! Form::date('fecha_informe', $ur->fecha_informe, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">III. CARTA QUE NOTIFICA OBSERVACION</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_carta', 'Nº de carta') !!} {!! Form::number('nro_carta', $ur->nro_carta_observacion, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_carta', 'Fecha') !!} {!! Form::date('fecha_carta', $ur->fecha_carta_observacion, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_derivacion', 'Fecha derivación') !!} {!! Form::date('fecha_derivacion', $ur->fecha_derivacion, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('observacion', 'Indique las observaciones encontradas') !!} {!! Form::textarea('observacion', $ur->observacion, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div id="Footer_ObservaSdaUr_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnObservaSdaUr" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_ObservaSdaUr_Disabled" style="display:none;">
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