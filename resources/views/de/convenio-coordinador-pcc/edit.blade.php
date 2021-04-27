{!!Form::model($coordinador,['id'=>'FormUpdateCoordinadorPcc', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-coordinador-pcc.update',$coordinador->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar información</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CoordinadorPccAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo', 'Tipo de coordinador') !!}
                <select name="tipo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="1" {{($coordinador->tipo == 1)?'selected':''}}>Titular</option>
                    <option value="2" {{($coordinador->tipo == 2)?'selected':''}}>Suplente</option>
                </select>
            </div>
            <div class="col-md-8">{!! Form::label('personal', 'Personal que asume como coordinador') !!}
                <select name="personal" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}" {{($fila->id == $coordinador->codPersonal)?'selected':''}}>{{$fila->sigla}} - {{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}} - {{$fila->cargo}}</option>    
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('referencia', 'Nº de documento de designación') !!} {!! Form::text('referencia', $coordinador->referencia, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', $coordinador->fecha_referencia, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateCoordinadorPcc_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateCoordinadorPcc" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateCoordinadorPcc_Disabled" style="display:none;">
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