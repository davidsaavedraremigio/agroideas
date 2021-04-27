{!!Form::model($expediente,['id'=>'FormDerivaExpedienteUpfp', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['upfp.procesa-informe',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Derivar Informe Técnico de Formulación</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExpedienteUpfpAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nº de trámite (CUT)') !!} {!! Form::text('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nº de Expediente') !!} {!! Form::text('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control', 'max' => date('Y-m-d'), 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>    
    <div class="form-group">
        <div class="row"><div class="col-md-12"><label for="">INFORME DE FORMULACION FAVORABLE</label></div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('especialista', 'Especialista responsable') !!}
                <select name="especialista" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $upfp->cod_responsable_form)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_informe_form', 'Número') !!} {!! Form::number('nro_informe_form', $upfp->nro_informe_form, ['class' => 'form-control', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe_form', 'Fecha') !!} {!! Form::date('fecha_informe_form', $upfp->fecha_informe_form, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">MEMORÁNDUN DE PASE DE UNIDAD DE NEGOCIOS</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_informe_tec', 'Número') !!} {!! Form::number('nro_informe_tec', $upfp->nro_informe_tec, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe_tec', 'Fecha') !!} {!! Form::date('fecha_informe_tec', $upfp->fecha_informe_tec, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_derivacion', 'Fecha de derivacion') !!} {!! Form::date('fecha_derivacion', $upfp->fecha_derivacion, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
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
@section('scripts')
<script>
    $('.select2').select2({
        theme: 'bootstrap4'
    });
</script>