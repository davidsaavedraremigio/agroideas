{!! Form::open(array('id'=>'FormCreateContrato','url'=>'iniciativa/convenio','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Registrar Convenio</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ContratoAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_rm', 'Nro Resolución') !!} {!! Form::number('nro_rm', $rm->nroResolucion, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('inicio', 'Fecha de inicio') !!} {!! Form::date('inicio', $rm->fechaFirma, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('importe', 'Importe total (S/.)') !!} {!! Form::text('importe', $proyecto->inversion_total, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('nombre', 'Razón social') !!} {!! Form::text('nombre', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_contrato', 'Nro de convenio') !!} {!! Form::number('nro_contrato', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de firma') !!} {!! Form::date('fecha', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
            <div class="col-md-4">{!! Form::label('duracion', 'Duración (meses)') !!} {!! Form::number('duracion', $proyecto->duracion, ['class' => 'form-control', 'min' => '1', 'max' => '99', 'maxlength' => '2']) !!}</div>
        </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('objetivo', 'Objetivo del convenio') !!} {!! Form::textarea('objetivo', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateContrato_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateContrato" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateContrato_Disabled" style="display:none;">
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