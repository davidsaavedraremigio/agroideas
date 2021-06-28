{!! Form::open(array('id'=>'FormCreateNoObjecion','route'=>'nobjecion.store','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo proceso</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="NoObjecionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('nro_contrato', 'Nº de convenio') !!}
                <select name="nro_contrato" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($data as $fila)
                        <option value="{{$fila->id}}">{{$fila->numero}} - {{$fila->razon_social}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', now(), ['class' => 'form-control', 'max' => date("Y-m-d")]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('numero', 'Nº de solicitud') !!} {!! Form::number('numero', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_carta_solicitud', 'Nº carta solicitud') !!} {!! Form::number('nro_carta_solicitud', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_carta_solicitud', 'Fecha de carta solicitud') !!} {!! Form::date('fecha_carta_solicitud', now(), ['class' => 'form-control', 'max' => date("Y-m-d")]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('justificacion', 'Justificación') !!} {!! Form::textarea('justificacion', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '1']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateNoObjecion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateNoObjecion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateNoObjecion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    $('.select2').select2({
        theme: 'bootstrap4'
    });   
</script>