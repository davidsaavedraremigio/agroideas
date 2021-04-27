{!! Form::open(array('id'=>'FormDeleteDesembolsoSda','url'=>'proceso-pdn/import-desembolso/delete','method'=>'POST','autocomplete'=>'off', 'files' => 'true', 'enctype' => 'multipart/form-data')) !!}
<div class="modal-header">
    <h4 class="modal-title">Eliminar información por lotes</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="DeleteDesembolsoSdaAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
                    <div class="col-md-6">{!! Form::label('mes', 'Seleccione un mes') !!}
                        <select name="mes" class="form-control select2">
                            <option value="" selected="selected">Seleccionar</option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                    <div class="col-md-6">{!! Form::label('periodo', 'Periodo (año)') !!} {!! Form::number('periodo', '', ['class' => 'form-control', 'min' => '2010', 'max' => date('Y')]) !!}</div>
                </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_DeleteDesembolsoSda_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnDeleteDesembolsoSda" class="btn btn-primary btn-sm"><i class="fas fa-trash-alt"></i> Procesar operación</a>
    </div>
    <div id="Footer_DeleteDesembolsoSda_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}