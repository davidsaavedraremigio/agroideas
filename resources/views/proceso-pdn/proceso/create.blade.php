{!! Form::open(array('id'=>'FormCreateProcesoExpediente','url'=>'proceso-pdn/proceso','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ProcesoExpedienteAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $expediente->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', '1. Recepción del expediente') !!}</div></div>
        <div class="row">
            <div class="col-md-8">{!! Form::label('responsable_asignado', 'Especialista asignado') !!}
                <select name="responsable_asignado" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($staff as $fila)
                        <option value="{{$fila->id}}">{{$fila->sigla}} - {{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_asignacion', 'Fecha') !!} {!! Form::date('fecha_asignacion', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', '2. Documento de salida') !!}</div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_documento', 'Tipo de documento') !!}
                <select name="tipo_documento" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_doc as $fila)
                    <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_documento', 'Fecha') !!} {!! Form::date('fecha_documento', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_documento', 'Nº de documento') !!} {!! Form::number('nro_documento', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>

    <div class="form-group">
        <div class="row"><div class="col-md-12">{!! Form::label('', '3. Resultado de la revisión y derivación') !!}</div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('estado_proceso', 'Estado del expediente') !!}
                <select name="estado_proceso" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($estado as $fila)
                    <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">{!! Form::label('evidencia', 'Cargar evidencia') !!} {!! Form::file('evidencia', ['class' => 'form-control']) !!}</div>
        </div>
        <div class="row"><div class="col-md-12">{!! Form::label('comentarios', 'Comentarios / Observaciones') !!} {!! Form::textarea('comentarios', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div></div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('destinatario', 'Especialista al que se deriva el expediente') !!}
                <select name="destinatario" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($staff as $fila)
                    <option value="{{$fila->id}}">{{$fila->sigla}} - {{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_derivacion', 'Fecha') !!} {!! Form::date('fecha_derivacion', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateProcesoExpediente_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateProcesoExpediente" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateProcesoExpediente_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    $('.select2').select2({
        theme: 'bootstrap4'
    });
</script>