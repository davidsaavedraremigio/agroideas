{!!Form::model($expediente,['id'=>'FormDerivaExpedienteUn', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['evaluacion.procesa-derivacion',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Derivar Expediente Nº {{$expediente->nroExpediente}}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExpedienteUnAlerts" class="alert alert-danger" style="display: none;"></div>
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
            <div class="col-md-12"><label for="">OPINIÓN FAVORABLE Y DERIVACIÓN A UAJ</label></div>
        </div>

        <div class="row">
            <div class="col-md-4">{!! Form::label('responsable', 'Especialista responsable') !!}
                <select name="responsable" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $un->cod_responsable)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_informe', 'Nº informe') !!} {!! Form::number('nro_informe', $un->nro_informe, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe', 'Fecha') !!} {!! Form::date('fecha_informe', $un->fecha_informe, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_memo', 'Nº de memorándum') !!} {!! Form::number('nro_memo', $un->nro_memo_favorable, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_memo', 'Fecha de memorándum') !!} {!! Form::date('fecha_memo', $un->fecha_memo_favorable, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_derivacion', 'Fecha de derivación') !!} {!! Form::date('fecha_derivacion', $un->fecha_derivacion, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">COFINANCIAMIENTO DEL PLAN DE NEGOCIOS</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('aporte_pcc', 'PCC (S/.)') !!} {!! Form::text('aporte_pcc', $proyecto->inversion_pcc, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('aporte_entidad', 'Entidad (S/)') !!} {!! Form::text('aporte_entidad', $proyecto->inversion_entidad, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('aporte_total', 'Total (S/.)') !!} {!! Form::text('aporte_total', $proyecto->inversion_total, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_DerivaExpedienteUn_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnDerivaExpedienteUn" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_DerivaExpedienteUn_Disabled" style="display:none;">
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