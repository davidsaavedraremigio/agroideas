{!! Form::open(array('id'=>'FormCreateIndicador','url'=>'proceso-prp/indicador','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="IndicadorAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('indicador', 'Seleccionar indicador') !!}
                <select name="indicador" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($indicadores as $fila)
                    <option value="{{$fila->id}}">{{$fila->indicador}} - {{$fila->unidad}}</option>    
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('linea_base', 'Línea de base') !!} {!! Form::text('linea_base', '', ['class' => 'form-control', 'placeholder' => '00.00']) !!}</div>
            <div class="col-md-6">{!! Form::label('meta', 'Meta propuesta') !!} {!! Form::text('meta', '', ['class' => 'form-control', 'placeholder' => '00.00']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateIndicador_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateIndicador" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateIndicador_Disabled" style="display:none;">
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