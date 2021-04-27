{!! Form::open(array('id'=>'FormCreateRendicionCapacitacion','url'=>'iniciativa/capacitacion-ejecucion','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="RendicionCapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <input type="hidden" name="codigo" value="{{$capacitacion->id}}">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('concepto', 'Concepto de gasto') !!} {!! Form::text('concepto', '', ['class' => 'form-control', 'placeholder' => 'Indique la descripción del concepto de gasto']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', '', ['class' => 'form-control', 'max' => $capacitacion->fecha]) !!}</div>
            <div class="col-md-6">{!! Form::label('importe', 'Importe (S/)') !!} {!! Form::text('importe', '', ['class' => 'form-control', 'placeholder' => '00.00']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateRendicionCapacitacion_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateRendicionCapacitacion" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateRendicionCapacitacion_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}