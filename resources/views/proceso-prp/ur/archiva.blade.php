{!!Form::model($expediente,['id'=>'FormArchivaExpedienteUR', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['ur.procesa-archivo',$expediente->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Archivar expediente</h4>
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
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nº de trámite (CUT)') !!} {!! Form::text('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nº de Expediente') !!} {!! Form::text('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control', 'max' => date('Y-m-d'), 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><label for="">ARCHIVAMIENTO - PRP</label></div>
        </div>
        <div class="row">
            <div class="col-md-6">{!! Form::label('responsable', 'Responsable de evaluación') !!}
                <select name="responsable" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $ur->cod_responsable_doc)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">{!! Form::label('nro_carta', 'Nº carta') !!} {!! Form::text('nro_carta', $ur->nro_carta_archivo, ['class' => 'form-control']) !!}</div>
            <div class="col-md-3">{!! Form::label('fecha_carta', 'Fecha carta') !!} {!! Form::date('fecha_carta', $ur->fecha_carta_archivo, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('estado_situacional', 'Estado situacional') !!}
                <select name="estado_situacional" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($estado as $fila)
                    <option value="{{$fila->Orden}}" {{($fila->Orden == $ur->codEstadoProceso)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div id="Footer_ArchivaExpedienteUR_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnArchivaExpedienteUR" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_ArchivaExpedienteUR_Disabled" style="display:none;">
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