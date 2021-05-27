{!!Form::model($upfp,['id'=>'FormUpdateExpedienteUpfp', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['mantenimiento.update-upfp',$upfp->id]])!!}
{{Form::token()}}
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">II. Evaluación Técnica</h3>
    </div>
    <div class="card-body">
        <div id="ExpedienteUrAlerts" class="alert alert-danger" style="display: none;"></div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">{!! Form::label('especialista_asignado', 'Especialista asignado') !!}
                    <select name="especialista_asignado" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $upfp->cod_responsable_eva_campo)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('fecha_recepcion', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion', $upfp->fechaRecepcion, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'min' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">{!! Form::label('', '3.1. ETAPAS DE LA EVALUACIÓN TÉCNICA') !!}</div>
            </div>
            <div class="row">
                <div class="col-md-4">{!! Form::label('especialista_responsable', 'Responsable de la evaluación') !!}
                    <select name="especialista_responsable" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $upfp->codResponsableAsignado)?'selected':''}}> {{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('fecha_campo', 'Fecha de evaluación de campo') !!} {!! Form::date('fecha_campo', $upfp->fecha_eva_campo, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_suelo', 'Fecha análisis de suelo') !!} {!! Form::date('fecha_suelo', $upfp->fecha_analisis_suelo, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_agua', 'Fecha análisis de agua') !!} {!! Form::date('fecha_agua', $upfp->fecha_analisis_agua, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_balance_hidrico', 'Fecha balance hídrico') !!} {!! Form::date('fecha_balance_hidrico', $upfp->fecha_balance_hidrico, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
            </div>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">{!! Form::label('', '3.2. OPINIÓN TÉCNICA FAVORABLE') !!}</div>
            </div>
            <div class="row">
                <div class="col-md-4">{!! Form::label('especialista_tecnico', 'Especialista responsable') !!}
                    <select name="especialista_tecnico" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $upfp->cod_responsable_tec)?'selected':''}}> {{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('nro_informe_tecnico', 'Nº de informe') !!} {!! Form::number('nro_informe_tecnico', $upfp->nro_informe_tec, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_informe_tecnico', 'Fecha') !!} {!! Form::date('fecha_informe_tecnico', $upfp->fecha_informe_tec, ['class' => 'form-control']) !!}</div>
                <div class="col-md-2">{!! Form::label('habilita_formulacion', 'Habilita formulación?') !!}
                    <select name="habilita_formulacion" class="form-control">
                        <option value="" selected="selected">Seleccionar</option>
                        <option value="1" {{($upfp->HabilitaFormulacion == 1)?'selected':''}}>SI</option>
                        <option value="0" {{($upfp->HabilitaFormulacion == 0)?'selected':''}}>NO</option>
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('fecha_derivacion', 'Fecha derivacion') !!} {!! Form::date('fecha_derivacion', $upfp->fecha_derivacion, ['class' => 'form-control']) !!}</div>
            </div>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">{!! Form::label('', '3.3. OPINIÓN FORMULACION FAVORABLE') !!}</div>
            </div>
            <div class="row">
                <div class="col-md-4">{!! Form::label('especialista_formulacion', 'Especialista responsable') !!}
                    <select name="especialista_formulacion" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $upfp->cod_responsable_form)?'selected':''}}> {{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('nro_informe_form', 'Nº de informe') !!} {!! Form::number('nro_informe_form', $upfp->nro_informe_form, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_informe_form', 'Fecha') !!} {!! Form::date('fecha_informe_form', $upfp->fecha_informe_form, ['class' => 'form-control']) !!}</div>
                <div class="col-md-2">{!! Form::label('nro_memo', 'Nº de memorándum') !!} {!! Form::number('nro_memo', '', ['class' => 'form-control', 'min' => '1', 'max' => 'form-control']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_memo', 'Fecha') !!} {!! Form::date('fecha_memo', '', ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div id="Footer_UpdateExpedienteUpfp_Enabled">
            <a href="#" id="btnUpdateExpedienteUpfp" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
            <a href="{{route("mantenimiento.index")}}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
        </div>
        <div id="Footer_UpdateExpedienteUpfp_Disabled" style="display:none;">
            <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
@section('scripts')
<script>
    $('.select2').select2({
        theme: 'bootstrap4'
    });
</script>
