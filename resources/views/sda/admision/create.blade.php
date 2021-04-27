{!! Form::open(array('id'=>'FormCreateSdaUr','url'=>'sda/admision','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ExpedienteSdaUrAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('postulante', 'Seleccione una entidad de la lista') !!}
                <select name="postulante" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($entidades as $fila)
                        <option value="{{$fila->id}}">{{$fila->ruc}} - {{$fila->razon_social}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('fecha_recepcion', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_cut', 'Nº de trámite (CUT)') !!} {!! Form::text('nro_cut', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_expediente', 'Nº de Expediente') !!} {!! Form::text('nro_expediente', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', '', ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('oficina', 'Ubicación del expediente') !!}
                <select id="inputOficina" name="oficina" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($oficinas as $fila)
                    <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">{!! Form::label('especialista', 'Especialista asignado') !!}
                <select id="inputEspecialista" name="especialista" class="form-control select2" disabled="disabled">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($personal as $fila)
                    <option value="{{$fila->id}}">{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateSdaUr_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateSdaUr" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateSdaUr_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
@section('scripts')
<script>
    $(document).ready(function () {
        var urlApp          = "{{ env('APP_URL') }}";

        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('#inputOficina').on('change', function (e) {
            console.log(e);
            var codOficina  =   e.target.value;
            $.get(urlApp + '/admin/usuario/' + codOficina, function (data) {
                $("#inputEspecialista").prop("disabled", false);
                $("#inputEspecialista").empty();
                $("#inputEspecialista").append('<option value="" selected="selected">Seleccionar</option>');
                $.each(data, function (index, especialistaObj) {
                    $("#inputEspecialista").append('<option value="' + especialistaObj.id + '">' + especialistaObj.nombres +' '+ especialistaObj.paterno +' '+ especialistaObj.materno +'</option>');
                });
            });
        });
    });
</script>