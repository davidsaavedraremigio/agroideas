{!! Form::open(array('id'=>'FormCreateCarteraPrp','url'=>'proceso-prp/cartera-prp','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CarteraPrpAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('descripcion', 'Descripción') !!} {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'placeholder' => 'Indicar lo citado en la Resolución', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_resolucion', 'Nº de resolución') !!} {!! Form::text('nro_resolucion', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de resolución') !!} {!! Form::date('fecha', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('importe', 'Importe (S/.)') !!} {!! Form::text('importe', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('ubigeo', 'Regiones a implementar') !!}
                <select name="ubigeo[]" class="form-control select2" multiple="multiple">
                    @foreach ($regiones as $fila)
                        <option value="{{$fila->id}}">{{$fila->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateCarteraPrp_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateCarteraPrp" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateCarteraPrp_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
@section('script')
<script>
    $(".select2").select2();
</script>