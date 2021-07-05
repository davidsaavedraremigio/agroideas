{!!Form::model($actividad,['id'=>'FormUpdateConvenioActividad', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-actividad-programacion.update',$actividad->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar Actividades</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ConvenioActividadAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('compromiso', 'Seleccione un compromiso') !!}
                <select name="compromiso" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($compromisos as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $actividad->codInicConvenioMarcoCompromiso)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('actividad', 'Actividad programada') !!} {!! Form::text('actividad', $actividad->nombreActividad, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('meta_fisica', 'Meta') !!} {!! Form::text('meta_fisica', $actividad->metaFisica, ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_limite', 'Fecha de cumplimiento') !!} {!! Form::date('fecha_limite', $actividad->fechaLimite, ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('descripcion', 'Descripción de tareas') !!} {!! Form::textarea('descripcion', $actividad->descripcion, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateConvenioActividad_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateConvenioActividad" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateConvenioActividad_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    $('.select2').select2();
</script>