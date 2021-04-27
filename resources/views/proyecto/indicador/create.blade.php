{!! Form::open(array('id'=>'FormCreateIndicador','url'=>'proyecto/indicador','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="IndicadorAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('codigo', 'Codigo') !!} {!! Form::text('codigo', '', ['class' => 'form-control', 'placeholder' => 'C-']) !!}</div>
            <div class="col-md-8">{!! Form::label('componente', 'Seleccionar Componente') !!}
                <select name="componente" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($componentes as $fila)
                    <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('descripcion', 'Descripción del indicador') !!} {!! Form::text('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripción del indicador']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_orden', 'Nº orden') !!} {!! Form::number('nro_orden', '', ['class' => 'form-control', 'min' => '1', 'max' => '100', 'placeholder' => '1-100']) !!}</div>
            <div class="col-md-4">{!! Form::label('unidad', 'U.M.') !!}
                <select name="unidad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($unidades as $fila)
                    <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('frecuencia', 'Frecuencia de medición') !!} {!! Form::text('frecuencia', '', ['class' => 'form-control', 'placeholder' => 'Frecuencia de medición']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('medio_verificacion', 'Medio de verificación') !!} {!! Form::textarea('medio_verificacion', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Medio de verificación']) !!}</div>
            <div class="col-md-6">{!! Form::label('supuestos', 'Supuestos') !!} {!! Form::textarea('supuestos', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Supuestos']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('formula', 'Pegar formula para el cálculo del indicador') !!} {!! Form::textarea('formula', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Formula / consulta que se requiere para obtener el resultado del indicador']) !!}</div>
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