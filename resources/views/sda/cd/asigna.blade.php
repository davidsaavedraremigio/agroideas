{!! Form::open(array('id'=>'FormAsignaSda','url'=>'sda/cd/asigna','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Asignar expediente a Consejo directivo</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="AsignaSdaAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $cd->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('numero', 'Consejo directivo Nº') !!} {!! Form::number('numero', $cd->numero, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha') !!} {!! Form::date('fecha', $cd->fecha, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_aprobacion', 'Fecha de aprobación') !!} {!! Form::date('fecha_aprobacion', '', ['class' => 'form-control', 'min' => date('Y-m-d')]) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('objetivo', 'Objetivo del Consejo directivo') !!} {!! Form::textarea('objetivo', $cd->descripcion, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('expediente', 'Seleccionar expedientes que se aprobaron en el presente Consejo directivo') !!}
                <select name="expediente[]" class="form-control select2" multiple="multiple">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($expediente as $fila)
                        <option value="{{$fila->id}}">{{$fila->nro_expediente}} - {{$fila->razon_social}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_AsignaSda_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnAsignaSda" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_AsignaSda_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    var urlApp          = "{{ env('APP_URL') }}";
    //1. Validamos la información del DNI
    $('.select2').select2({
        theme: 'bootstrap4'
    });
</script>