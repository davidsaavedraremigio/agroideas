{!! Form::open(array('id'=>'FormCreateAdendaContrato','url'=>'iniciativa/convenio-ampliacion','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Generar adenda</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CreateAdendaContratoAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $contrato->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('numero', 'Nº de convenio') !!} {!! Form::number('numero', $contrato->nroContrato, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de convenio') !!} {!! Form::date('fecha', $contrato->fechaFirma, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('tipo', 'Tipo de ampliación') !!}
                <select name="tipo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_ampliacion', 'Nº de ampliación') !!} {!! Form::number('nro_ampliacion', '', ['class' => 'form-control', 'min' => '1', 'max' => '9']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_ampliacion', 'Fecha de firma') !!} {!! Form::date('fecha_ampliacion', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('meses', 'Nº de meses a ampliar') !!} {!! Form::number('meses', '', ['class' => 'form-control', 'min' => '1', 'max' => '12']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('objetivo', 'Objetivo de la adenda') !!} {!! Form::textarea('objetivo', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateAdendaContrato_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateAdendaContrato" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateAdendaContrato_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}