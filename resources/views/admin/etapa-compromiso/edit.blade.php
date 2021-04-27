{!!Form::model($etapa,['id'=>'FormUpdateEtapa', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['etapa-compromiso.update',$etapa->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="EtapaAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('tipo_compromiso', 'Seleccione el tipo de compromiso') !!}
                <select name="tipo_compromiso" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoCompromiso as $fila)
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $etapa->codTipoCompromiso)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-6">{!! Form::label('descripcion', 'Descripción de la etapa') !!} {!! Form::text('descripcion', $etapa->descripcion, ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div id="Footer_UpdateEtapa_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateEtapa" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateEtapa_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}