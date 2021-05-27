{!!Form::model($expediente_ur,['id'=>'FormUpdateExpedienteUr', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['mantenimiento.update-ur',$expediente_ur->id]])!!}
{{Form::token()}}
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">II. Evaluación documentaria</h3>
    </div>
    <div class="card-body">
        <div id="ExpedienteUrAlerts" class="alert alert-danger" style="display: none;"></div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">{!! Form::label('', '2.1. EVALUACIÓN GEOESPACIAL') !!}</div>
            </div>
            <div class="row">
                <div class="col-md-4">{!! Form::label('responsable_geo', 'Especialista responsable de realizar la evaluación') !!}
                    <select name="responsable_geo" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $expediente_ur->cod_responsable_geo)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('fecha_recepcion_ur', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion_ur', $expediente_ur->fechaRecepcion, ['class' => 'form-control']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_solicitud_geo', 'Fecha de solicitud') !!} {!! Form::date('fecha_solicitud_geo', $expediente_ur->fecha_solicitud_geo, ['class' => 'form-control']) !!}</div> 
                <div class="col-md-2">{!! Form::label('fecha_informe_geo', 'Fecha de informe') !!} {!! Form::date('fecha_informe_geo', $expediente_ur->fecha_informe_doc, ['class' => 'form-control']) !!}</div>
                <div class="col-md-2"></div>
            </div>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">{!! Form::label('', '2.2. EVALUACIÓN DOCUMENTARIA') !!}</div>
            </div>
            <div class="row">
                <div class="col-md-4">{!! Form::label('responsable_doc', 'Especialista responsable de realizar la evaluación') !!}
                    <select name="responsable_doc" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $expediente_ur->cod_responsable_doc)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('nro_informe_doc', 'Nº de informe') !!} {!! Form::number('nro_informe_doc', $expediente_ur->nro_informe_doc, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_informe_doc', 'Fecha') !!} {!! Form::date('fecha_informe_doc', $expediente_ur->fecha_informe_doc, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_derivacion', 'Fecha derivación') !!} {!! Form::date('fecha_derivacion', $expediente_ur->fecha_derivacion, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('estado', 'Estado situacional') !!}
                    <select name="estado" class="form-control" disabled="disabled">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($estados as $fila)
                            <option value="{{$fila->Orden}}" {{($fila->Orden == $expediente_ur->codEstadoProceso)?'selected':''}}>{{$fila->Nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">{!! Form::label('', '2.3. INFORMACIÓN DE EXPEDIENTE IMPROCEDENTE') !!}</div>
            </div>
            <div class="row">
                <div class="col-md-4">{!! Form::label('responsable_archiva', 'Especialista responsable de realizar la evaluación') !!}
                    <select name="responsable_archiva" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $expediente_ur->cod_responsable_tec)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('nro_informe_archiva', 'Nº de informe') !!}{!! Form::number('nro_informe_archiva', $expediente_ur->nro_informe_tec, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_informe_archiva', 'Fecha') !!} {!! Form::date('fecha_informe_archiva', $expediente_ur->fecha_informe_tec, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('nro_carta_archiva', 'Nº de carta') !!} {!! Form::number('nro_carta_archiva', $expediente_ur->nro_carta_archivo, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_carta_archiva', 'Fecha') !!} {!! Form::date('fecha_carta_archiva', $expediente_ur->fecha_carta_archivo, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
            </div>
        </div>
        <hr class="my-4">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">{!! Form::label('', '2.4. INFORMACIÓN DE EXPEDIENTE OBSERVADO') !!}</div>
            </div>
            <div class="row">
                <div class="col-md-4">{!! Form::label('responsable_observa', 'Especialista responsable de realizar la evaluación') !!}
                    <select name="responsable_observa" class="form-control select2">
                        <option value="" selected="selected">Seleccionar</option>
                        @foreach ($personal as $fila)
                            <option value="{{$fila->id}}" {{($fila->id == $expediente_ur->cod_responsable_tec)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">{!! Form::label('nro_informe_observa', 'Nº de informe') !!} {!! Form::number('nro_informe_observa', $expediente_ur->nro_informe_doc_observa, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_informe_observa', 'Fecha') !!} {!! Form::date('fecha_informe_observa', $expediente_ur->fecha_informe_doc_observa, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('nro_carta_observa', 'Nº de carta') !!} {!! Form::number('nro_carta_observa', $expediente_ur->nro_carta_observa, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_carta_observa', 'Fecha') !!} {!! Form::date('fecha_carta_observa', $expediente_ur->fecha_carta_observa, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-8">{!! Form::label('observacion', 'Observaciones:') !!} {!! Form::textarea('observacion', $expediente_ur->observacion, ['class' => 'form-control', 'rows' => '1', 'cols' => '2']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_levanta_observacion', 'Fecha de subsanación') !!} {!! Form::date('fecha_levanta_observacion', $expediente_ur->fecha_levanta_observacion, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_recepcion_observacion', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion_observacion', $expediente_ur->fecha_recibe_expediente_observado, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div id="Footer_UpdateExpedienteUr_Enabled">
            <a href="#" id="btnUpdateExpedienteUr" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
            <a href="{{route("mantenimiento.index")}}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
        </div>
        <div id="Footer_UpdateExpedienteUr_Disabled" style="display:none;">
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