{!!Form::model($upfp,['id'=>'FormUpdateExpedienteFormulacion', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['mantenimiento.update-formulacion',$upfp->id]])!!}
{{Form::token()}}
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">IV. Informe de formulación</h3>
    </div>
    <div class="card-body">
        <div id="ExpedienteFormulacionAlerts" class="alert alert-danger" style="display: none;"></div>
        <div class="form-group">
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
                <div class="col-md-2">{!! Form::label('nro_memo', 'Nº de memorándum') !!} {!! Form::number('nro_memo', $upfp->nro_memo_derivacion, ['class' => 'form-control', 'min' => '1', 'max' => 'form-control']) !!}</div>
                <div class="col-md-2">{!! Form::label('fecha_memo', 'Fecha') !!} {!! Form::date('fecha_memo', $upfp->fecha_memo_derivacion, ['class' => 'form-control', 'min' => $expediente->fechaCut, 'max' => date('Y-m-d')]) !!}</div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <div id="Footer_UpdateExpedienteFormulacion_Enabled">
            <a href="#" id="btnUpdateExpedienteFormulacion" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
            <a href="{{route("mantenimiento.index")}}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
        </div>
        <div id="Footer_UpdateExpedienteFormulacion_Disabled" style="display:none;">
            <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
        </div>
    </div>
</div>

{!! Form::close() !!}
