{!! Form::open(array('id'=>'FormCreateCadena','url'=>'admin/cadena','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CadenaAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('sector', 'Seleccione una línea') !!}
                <select name="linea" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($lineas as $fila)
                    <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">{!! Form::label('descripcion', 'Descripción de la cadena productiva') !!} {!! Form::text('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Descripción de la cadena productiva']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('iconos', 'Icono') !!} {!! Form::text('icono', '', ['class' => 'form-control', 'placeholder' => 'Nombre del icono']) !!}</div>
            <div class="col-md-4"></div>
            <div class="col-md-4">{!! Form::label('agroexportacion', 'Potencial agroexportador') !!}
                <select name="agroexportacion" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1">SI</option>
                    <option value="0">NO</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateCadena_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateCadena" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateCadena_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
