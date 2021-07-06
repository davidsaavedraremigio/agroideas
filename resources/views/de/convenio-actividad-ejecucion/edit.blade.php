{!!Form::model($ejecucion,['id'=>'FormUpdateConvenioActividadEjecucion', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-actividad-ejecucion.update',$ejecucion->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Plan de trabajo: Reportar avance actividad</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ConvenioActividadEjecucionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('actividad', 'Actividad a implementar') !!}
                <select name="actividad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($actividades as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $ejecucion->codActividadProgramacion)?'selected':''}}>{{$fila->actividad}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de actualización') !!} {!! Form::date('fecha', $ejecucion->fecha, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('accciones', 'Acciones realizadas') !!} {!! Form::textarea('acciones', $ejecucion->acciones, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('responsable', 'Especialista responsable') !!}
                <select name="responsable" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $ejecucion->codResponsable)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('meta_ejecutada', 'Meta ejecutada') !!} {!! Form::text('meta_ejecutada', number_format($ejecucion->metaEjecutada,2,'.',''), ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
            <div class="col-md-4">{!! Form::label('situacion', 'Estado de la actividad') !!}
                <select name="situacion" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1" {{($actividad->estadoImplementacion == 1)?'selected':''}}>Por implementar</option>
                    <option value="2" {{($actividad->estadoImplementacion == 2)?'selected':''}}>Implementada</option>
                    <option value="0" {{($actividad->estadoImplementacion == 0)?'selected':''}}>Cancelada / Impedida</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateConvenioActividadEjecucion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateConvenioActividadEjecucion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateConvenioActividadEjecucion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    $('.select2').select2();
</script>