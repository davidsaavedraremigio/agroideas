{!! Form::open(array('id'=>'FormCreateActividad','url'=>'proceso-prp/actividad','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ActividadAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('componente', 'Seleccionar componente') !!}
                <select name="componente" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($componentes as $fila)
                    <option value="{{$fila->id}}">{{$fila->nombre}}</option>    
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_orden', 'Nº de orden') !!} {!! Form::number('nro_orden', '', ['class' => 'form-control', 'min' => '1', 'max' => '100']) !!}</div>
            <div class="col-md-8">{!! Form::label('descripcion', 'Actividad') !!} {!! Form::text('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripción del objetivo específico']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('unidad', 'U.M.') !!}
                <select name="unidad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($unidades as $fila)
                    <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('meta_fisica', 'Meta física') !!} {!! Form::text('meta_fisica', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('precio', 'Precio unitario') !!} {!! Form::text('precio', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateActividad_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateActividad" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateActividad_Disabled" style="display:none;">
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