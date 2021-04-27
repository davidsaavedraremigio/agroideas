{!! Form::open(array('id'=>'FormObservaExpediente','url'=>'proceso-pdn/proceso-ur/observa','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Realizar observaciones al expediente</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ObservaExpedienteAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $expediente->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('especialista', 'Especialista responsable') !!}
                <select name="especialista" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $expediente->codPersonalAsignado)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}} - {{$fila->cargo}} - {{$fila->oficina}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_documento', 'Tipo de documento') !!}
                <select name="tipo_documento" class="form-control select2">
                    <option value="" class="form-control">Seleccionar</option>
                    @foreach ($tipo_doc as $fila)
                    <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>  
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_documento', 'Nº de documento') !!} {!! Form::number('nro_documento', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_documento', 'Fecha') !!} {!! Form::date('fecha_documento', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('observaciones', 'Observaciones encontradas') !!} {!! Form::textarea('observaciones', '', ['class' => 'form-control', 'cols' => '2', 'rows' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_ObservaExpediente_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnObservaExpediente" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_ObservaExpediente_Disabled" style="display:none;">
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