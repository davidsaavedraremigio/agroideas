{!!Form::model($expediente,['id'=>'FormDerivaExpedienteUR', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['ur.procesa-envio',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Derivar expediente</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExpedienteURAlerts" class="alert alert-danger" style="display: none;"></div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nº de trámite (CUT)') !!} {!! Form::text('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nº de Expediente') !!} {!! Form::text('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control', 'max' => date('Y-m-d'), 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">EVALUACIÓN DOCUMENTARIA - PRP</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('responsable_informe_doc', 'Responsable evaluación') !!}
                <select name="responsable_informe_doc" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $ur->cod_responsable_doc)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_informe_doc', 'Nº de informe') !!} {!! Form::text('nro_informe_doc', $ur->nro_informe_doc, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe_doc', 'Fecha de informe') !!} {!! Form::date('fecha_informe_doc', $ur->fecha_informe_doc, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>    
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">EVALUACIÓN GEOESPACIAL - PRP</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('responsable_informe_geo', 'Responsable informe') !!}
                <select name="responsable_informe_geo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $ur->cod_responsable_geo)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_solicitud_geo', 'Fecha solicitud') !!} {!! Form::date('fecha_solicitud_geo', $ur->fecha_solicitud_geo, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe_geo', 'Fecha de informe') !!} {!! Form::date('fecha_informe_geo', $ur->fecha_informe_geo, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">INFORME DE OPINIÓN TECNICA FAVORABLE Y DERIVACIÓN</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_informe_tec', 'Nº de informe') !!} {!! Form::number('nro_informe_tec', $ur->nro_informe_tec, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe_tec', 'Fecha de informe') !!} {!! Form::date('fecha_informe_tec', $ur->fecha_informe_tec, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_derivacion', 'Fecha de derivacion') !!} {!! Form::date('fecha_derivacion', $ur->fecha_derivacion, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_DerivaExpedienteUR_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnDerivaExpedienteUR" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_DerivaExpedienteUR_Disabled" style="display:none;">
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