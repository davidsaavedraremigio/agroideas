{!!Form::model($producto,['id'=>'FormUpdateProducto', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['producto-especifico.update',$producto->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ProductoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('cadena', 'Cadena productiva (*)') !!}
                <select name="cadena" class="form-control" id="inputCadenaProductiva">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadenas as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $productoEspecifico->maestroCadenaID)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('producto', 'Producto (*)') !!}
                <select name="producto" class="form-control" id="inputProductoEspecifico">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($productos as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $producto->codProducto)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('variedad', 'Variedad a cultivar') !!} {!! Form::text('variedad', $producto->variedad, ['class' => 'form-control', 'Indique la variedad a cultivar']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_produccion', 'Tipo de producción (*)') !!}
                <select name="tipo_produccion" class="form-control">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($tipoProduccion as $fila)
                    <option value="{{$fila->Orden}}" {{($fila->Orden == $producto->tipoProduccion)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('hectareas', 'Nro Has asociadas (*)') !!} {!! Form::text('hectareas', $producto->nroHas, ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
            <div class="col-md-4">{!! Form::label('productores', 'Nro productores (*)') !!} {!! Form::number('productores', $producto->nroProductores, ['class' => 'form-control', 'min' => '1', 'max' => '999']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('principal', 'Es producto principal? (*)') !!}
                <select name="principal" class="form-control">
                    <option value="" selected>Seleccionar</option>
                    <option value="1" {{($producto->principal == 1)?'selected':''}}>Si</option>
                    <option value="0" {{($producto->principal == 0)?'selected':''}}>No</option>
                </select>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
    </div>    
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_Producto_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateProducto" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateProducto_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
@section('scripts')
<script>

        $('.select2').select2({
            theme: 'bootstrap4'
        });
        $('#inputCadenaProductiva').on('change', function(e){
            console.log(e);
            var cadena_id = e.target.value;
            $.get('../../../tipologia/producto/'+cadena_id, function(data) {
                console.log(data);
                $("#inputProductoEspecifico").prop("disabled", false);
                $("#inputProductoEspecifico").empty();
                $("#inputProductoEspecifico").append('<option value="" selected="selected">Seleccionar</option>');
                $.each(data, function(index, productoObj) {
                    $("#inputProductoEspecifico").append('<option value="'+productoObj.id+'">'+productoObj.descripcion+'</option>');
                })
            });
        }); 
</script>