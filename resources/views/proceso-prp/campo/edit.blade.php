{!!Form::model($productor,['id'=>'FormUpdateEvaluacionCampo', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['socio.update-campo',$productor->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Resultados de la verificación de campo</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="EvaluacionCampoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_documento', 'Nro. DNI') !!} {!! Form::text('nro_documento', $persona->dni, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-8">{!! Form::label('nombres', 'Nombres y apellidos') !!} {!! Form::text('nombres', $persona->nombres." ".$persona->paterno." ".$persona->materno, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección (La que figura en RENIEC)') !!} {!! Form::textarea('direccion', $persona->direccion, ['class' => 'form-control', 'readonly' => 'readonly', 'cols' => '2', 'rows' => '2', 'id' => 'input_direccion_dni']) !!}</div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="row">{!! Form::label('', '1. Antecedentes') !!}</div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_ha_solicitada', 'Área que solicita reconvertir') !!} {!! Form::text('nro_ha_solicitada', number_format($productor->nroHaSolicitaReconvertir,2), ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_ha_plano', 'Área según plano') !!} {!! Form::text('nro_ha_plano', number_format($productor->nroHaReconvertirPlano,2), ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_ha', 'Área total') !!} {!! Form::text('nro_ha', number_format($productor->nro_ha, 2), ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">{!! Form::label('', '2. Resultado de la evaluación') !!}</div>
        <!--
        <div class="row">
            <div class="col-md-4">{!! Form::label('latitud', 'Latitud') !!} {!! Form::text('latitud', $productor->latitud, ['class' => 'form-control', 'placeholder' => '-00.0000']) !!}</div>
            <div class="col-md-4">{!! Form::label('longitud', 'Longitud') !!} {!! Form::text('longitud', $productor->longitud, ['class' => 'form-control', 'placeholder' => '-00.0000']) !!}</div>
            <div class="col-md-4">{!! Form::label('altitud', 'Altitud (m.s.n.m.)') !!} {!! Form::text('altitud', $productor->altitud, ['class' => 'form-control', 'placeholder' => '0000.00']) !!}</div>
        </div>
        -->
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_ha_riego', 'Área bajo riego') !!} {!! Form::text('nro_ha_riego', number_format($productor->nroHaRiego,2), ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_ha_geo', 'Área medida') !!} {!! Form::text('nro_ha_geo', number_format($productor->nroHaDisponible,2), ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('resultado_final', 'Resultado de la evaluación') !!}
                <select name="resultado_final" class="form-control">
                    <option value="" selected="selected">No evaluado</option>
                    <option value="1" {{($productor->resultadoEvaluacionCampo == 1)?'selected':''}}>Favorable</option>
                    <option value="2" {{($productor->resultadoEvaluacionCampo == 2)?'selected':''}}>Observado</option>
                    <option value="3" {{($productor->resultadoEvaluacionCampo == 3)?'selected':''}}>No aplica</option>
                    <option value="0" {{($productor->resultadoEvaluacionCampo == 0)?'selected':''}}>No Evaluado</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('comentario', 'Comentarios / observaciones') !!} {!! Form::textarea('comentario', $productor->comentarioEvaluacionCampo, ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Comentarios u observaciones de la verificación en campo']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateEvaluacionCampo_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateEvaluacionCampo" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateEvaluacionCampo_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}