{!!Form::model($expediente,['id'=>'FormUpdateExpedienteUR', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['ur.update',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExpedienteURAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('entidad', 'Seleccione el PRP que accederá al incentivo') !!}
                <select name="entidad" class="form-control" disabled="disabled">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($entidades as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $expediente->codPostulante)?'selected':''}}>{{$fila->ruc}} - {{$fila->razon_social}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_recepcion', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion', $expediente->fechaCut, ['class' => 'form-control', 'max' => date('Y-m-d'), 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nº de  trámite (CUT)') !!} {!! Form::number('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nº de expediente') !!} {!! Form::number('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('cartera', 'Nº de cartera a la que se asocia el pedido:') !!} 
                <select name="cartera" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cartera as $fila)
                        <option value="{{$fila->id}}">{{$fila->nro_resolucion}} - {{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('especialista', 'Especialista asignado') !!}
                <select name="especialista" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $expediente->codPersonalAsignado)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('oficina', 'Ubicación del expediente') !!}
                <select name="oficina" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($oficinas as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $expediente->codOficina)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">II. Evaluación Geoespacial - PRP</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('responsable_informe_geo', 'Responsable informe') !!}
                <select name="responsable_informe_geo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    @if ($fila->id == 1053 OR $fila->id == 1145 OR $fila->id == 1061)
                    <option value="{{$fila->id}}" {{($fila->id == $ur->cod_responsable_geo)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>  
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_solicitud_geo', 'Fecha solicitud') !!} {!! Form::date('fecha_solicitud_geo', $ur->fecha_solicitud_geo, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_informe_geo', 'Fecha de informe') !!} {!! Form::date('fecha_informe_geo', $ur->fecha_informe_geo, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">III. Informe de evaluación documentaria con observaciones</label></div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('responsable_informe_doc', 'Especialista responsable') !!}
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
</div>
<div class="modal-footer">
    <div id="Footer_UpdateExpedienteUR_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateExpedienteUR" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateExpedienteUR_Disabled" style="display:none;">
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