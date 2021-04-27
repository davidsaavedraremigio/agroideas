{!! Form::open(array('id'=>'FormCreateTablaValor','url'=>'admin/tabla-valor','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="TablaValorAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('tabla', 'Seleccione una tabla') !!}
                <select name="tabla" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tablas as $fila)
                        <option value="{{$fila->id}}">{{$fila->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('nombre', 'Nombre') !!} {!! Form::text('nombre', '', ['class' => 'form-control', 'placeholder' => 'Nombre de la variable']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('orden', 'Nro Orden') !!} {!! Form::number('orden', '', ['class' => 'form-control', 'min' => '1', 'max' => '999']) !!}</div>
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('valor', 'Valor de la variable') !!} {!! Form::text('valor', '', ['class' => 'form-control', 'max' => '3']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateTablaValor_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateTablaValor" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateTablaValor_Disabled" style="display:none;">
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