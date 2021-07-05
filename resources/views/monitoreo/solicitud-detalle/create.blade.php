{!! Form::open(array('id'=>'FormCreateSolicitudDesembolsoDetalle','route'=>'solicitud-detalle.store','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Asignar informes de No objeción a la Solicitud de desembolso</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="SolicitudDesembolsoDetalleAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $solicitud->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('no_objecion', 'Seleccione un informe de No Objeción') !!}
                <select name="no_objecion" class="form-control select2" multiple="multiple">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($objeciones as $fila)
                        <option value="{{$fila->id}}">{{$fila->nro_solicitud}} - {{$fila->razon_social}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateSolicitudDesembolsoDetalle_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateSolicitudDesembolsoDetalle" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateSolicitudDesembolsoDetalle_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(".select2").select2();
</script>