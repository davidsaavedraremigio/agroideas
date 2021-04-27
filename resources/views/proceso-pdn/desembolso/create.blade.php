{!! Form::open(array('id'=>'FormCreateDesembolsoSda','url'=>'proceso-pdn/desembolso','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="DesembolsoSdaAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_solicitud', 'Nº de solicitud') !!} {!! Form::number('nro_solicitud', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', '', ['class' => 'form-control', 'max' => $termino, 'min' => $inicio]) !!}</div>
            <div class="col-md-4">{!! Form::label('saldo', 'Saldo disponible') !!} {!! Form::text('saldo', number_format($saldo,2,'.',''), ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nroSiaf', 'Nº de SIAF') !!} {!! Form::text('nroSiaf', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('importe', 'Importe') !!} {!! Form::text('importe', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nuevo_saldo', 'Nuevo saldo') !!} {!! Form::text('nuevo_saldo', '', ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateDesembolsoSda_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateDesembolsoSda" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateDesembolsoSda_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}