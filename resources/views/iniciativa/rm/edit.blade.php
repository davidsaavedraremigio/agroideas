{!!Form::model($rm,['id'=>'FormUpdateRM', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['rm.update',$rm->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="RMAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('postulante', 'Seleccione una iniciativa') !!}
                <select name="postulante" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($prpa as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $rm->codPostulante)?'selected':''}}>{{$fila->razon_social}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('nro_resolucion', 'Nº de resolución') !!} {!! Form::text('nro_resolucion', $rm->nroResolucion, ['class' => 'form-control']) !!}</div>
            <div class="col-md-6">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', $rm->fechaFirma, ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateRM_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateRM" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateRM_Disabled" style="display:none;">
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