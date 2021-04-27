{!! Form::open(array('id'=>'FormCreateRm','url'=>'iniciativa/rm','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Registrar Resolución ministerial</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CreateRmAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nro Expediente') !!} {!! Form::number('nro_expediente', $expediente->nroExpediente, ['class' =>'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nro CUT') !!} {!! Form::number('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_admision', 'Fecha de admisión') !!} {!! Form::date('fecha_admision', $expediente->fechaExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('razon_social', 'Razon social') !!} {!! Form::text('razon_social', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_resolucion', 'Número de RM') !!} {!! Form::number('nro_resolucion', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4"><br></div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', date('Y-m-d'), ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('aporte_pcc', 'Aporte PCC (S/.)') !!} {!! Form::text('aporte_pcc', number_format($proyecto->inversion_pcc,'2','.',''), ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('aporte_entidad', 'Aporte Entidad (S/.)') !!} {!! Form::text('aporte_entidad', number_format($proyecto->inversion_entidad,'2','.',''), ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('aporte_total', 'Aporte Total (S/.)') !!}  {!! Form::text('aporte_total', number_format($proyecto->inversion_total,'2','.',''), ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateRm_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateRm" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateRm_Disabled" style="display:none;">
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