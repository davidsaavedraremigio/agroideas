{!! Form::open(array('id'=>'FormCreatePC','url'=>'iniciativa/paso-critico','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="PCAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('resultado', 'Resultado esperado al finalizar el Paso crítico (*)') !!} {!! Form::textarea('resultado', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Indique que es lo que se espera al finalizar el Paso crítico.']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">{!! Form::label('inicio', 'Mes de inicio (*)') !!} {!! Form::number('inicio', '', ['class' => 'form-control', 'min' => '1', 'max' => '99']) !!}</div>
            <div class="col-md-3">{!! Form::label('termino', 'Mes de termino (*)') !!} {!! Form::number('termino', '', ['class' => 'form-control', 'min' => '1', 'max' => '99']) !!}</div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreatePC_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreatePC" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreatePC_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}