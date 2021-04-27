{!! Form::open(array('id'=>'FormCreateEntidadIdentificada','url'=>'de/convenio-postulante','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">OA's identificadas</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="EntidadIdentificadaAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <input type="hidden" name="codigo" value="{{$convenio->id}}">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_convenio_marco', 'Nº de convenio') !!} {!! Form::number('nro_convenio_marco', $convenio->numero, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('inicio_marco', 'Fecha de inicio') !!} {!! Form::date('inicio_marco', $convenio->fecha_firma, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('termino_marco', 'Fecha de término') !!} {!! Form::date('termino_marco', $convenio->fecha_termino, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('postulante', 'Seleccione una organización de la relación mostrada a continuación:') !!}
                <select name="postulante" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($postulante as $fila)
                       <option value="{{$fila->id}}">{{$fila->nro_contrato}} - {{$fila->ruc}}: {{$fila->razon_social}}</option> 
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateEntidadIdentificada_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateEntidadIdentificada" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateEntidadIdentificada_Disabled" style="display:none;">
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