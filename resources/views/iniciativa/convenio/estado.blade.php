{!!Form::model($postulante,['id'=>'FormUpdateEstadoContrato', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['contrato.estado-update',$postulante->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar Estado</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="UpdateEstadoContratoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('numero', 'Nro de convenio') !!} {!! Form::number('numero', $contrato->nroContrato, ['class' => 'form-control', 'min' => '1', 'max' => '9999', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', $contrato->fechaFirma, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('estado', 'Estado situacional') !!}
                <select name="estado" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($estados as $fila)
                    <option value="{{$fila->Orden}}" {{($fila->Orden == $estado->codEstadoSituacional)?'selected':''}}>{{$fila->Nombre}}</option>    
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateEstadoContrato_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateEstadoContrato" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateEstadoContrato_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
@section('scripts')
<script>
    var urlApp  = "{{ env('APP_URL') }}";
    $('.select2').select2({
        theme: 'bootstrap4'
    });
</script>