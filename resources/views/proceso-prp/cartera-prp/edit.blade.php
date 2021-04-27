{!!Form::model($cartera,['id'=>'FormUpdateCarteraPrp', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['cartera-prp.update',$cartera->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
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
            <div class="col-md-12">{!! Form::label('descripcion', 'Descripción') !!} {!! Form::text('descripcion', $cartera->descripcion, ['class' => 'form-control', 'placeholder' => 'Descripción de la cartera']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('fecha', 'Fecha de disponibilidad') !!} {!! Form::date('fecha', $cartera->fechaDisponibilidad, ['class' => 'form-control']) !!}</div>
            <div class="col-md-6">{!! Form::label('importe', 'Importe') !!} {!! Form::text('importe', $cartera->importe, ['class' => 'form-control']) !!}</div>
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
<div class="modal-footer">
    <div id="Footer_UpdateCarteraPrp_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateCarteraPrp" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateCarteraPrp_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
@section('script')
<script>
    $(".select2").select2();
</script>