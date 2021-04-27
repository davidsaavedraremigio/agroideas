{!!Form::model($expediente,['id'=>'FormSubsanaObservacionUR', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['ur.subsana-observacion',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Formulario para el levantamiento de observaciones</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="SubsanaObservacionURAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nº de expediente') !!} {!! Form::text('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nº de CUT') !!} {!! Form::text('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de admisión') !!} {!! Form::date('fecha', $expediente->fechaExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">EVALUACIÓN DOCUMENTARIA CON OBSERVACIONES - PRP</label></div>
        </div>
        <div class="row">
            <div class="col-md-8">{!! Form::label('responsable', 'Responsable de evaluación') !!}
                <select name="responsable" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $ur->cod_responsable_doc)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_observacion', 'Fecha de observacion') !!} {!! Form::date('fecha_observacion', $ur->fecha_carta_observa, ['class' => 'form-control', 'max' => date('Y-m-d'), 'readonly' => 'readonly']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('observaciones', 'Observaciones encontradas') !!} {!! Form::textarea('observaciones', $ur->observacion, ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('fecha_respuesta', 'Fecha de respuesta') !!} {!! Form::date('fecha_respuesta', $ur->fecha_levanta_observacion, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4"><br></div>
            <div class="col-md-4">{!! Form::label('fecha_recepcion', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion', $ur->fecha_recibe_expediente_observa, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div id="Footer_SubsanaObservacionUR_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnSubsanaObservacionUR" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_SubsanaObservacionUR_Disabled" style="display:none;">
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