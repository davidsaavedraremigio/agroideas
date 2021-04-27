{!! Form::open(array('id'=>'FormCreateEjecucionCompromiso','url'=>'iniciativa/ejec-compromiso','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="EjecucionCompromisoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <input type="hidden" name="evento" value="{{$evento}}">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-lg-12">{!! Form::label('compromiso', 'Seleccione un compromiso') !!}
                <select name="compromiso" id="inputCompromiso" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($compromisos as $fila)
                <option value="{{$fila->id}}">{{$fila->compromiso}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-lg-12">{!! Form::label('etapa', 'Indique la actividad de la que se registrará un avance') !!}
                <select name="etapa" id="inputEtapa" class="form-control" disabled="disabled">
                    <option value="" selected="selected">Seleccionar</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-xs-6">{!! Form::label('responsable', 'Responsable') !!} {!! Form::text('responsable', '', ['class' => 'form-control', 'placeholder' => 'Responsable de reportar el avance en la ejecución']) !!}</div>
            <div class="col-lg-4 col-md-4 col-xs-6">{!! Form::label('fecha', 'Fecha de implementación') !!} {!! Form::date('fecha', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">{!! Form::label('resultado', 'Resultados alcanzados') !!} {!! Form::textarea('resultado', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Resultados alcanzados en la implementación del compromiso.']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">{!! Form::label('observaciones', 'Comentarios u observaciones') !!} {!! Form::textarea('observaciones', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'placeholder' => 'Observaciones u comentarios sobre la implementación del compromiso.']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-6">{!! Form::label('evidencia', 'Evidencia que refleje en avance') !!} {!! Form::file('evidencia', ['class' => 'form-control']) !!}</div>
            <div class="col-lg-6 col-md-6 col-xs-6">{!! Form::label('estado', 'Actualización del estado del compromiso') !!} 
                <select name="estado" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($estados as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateEjecucionCompromiso_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateEjecucionCompromiso" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateEjecucionCompromiso_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}

@section('scripts')
<script>
    $('#inputCompromiso').on('change', function(e){
            console.log(e);
            var urlApp          = "{{ env('APP_URL') }}";
            var compromiso_id   = e.target.value;
            $.get(urlApp+'/iniciativa/compromiso/'+compromiso_id+'/etapa', function(data) {
                $("#inputEtapa").prop("disabled", false);
                $("#inputEtapa").empty();
                $("#inputEtapa").append('<option value="" selected="selected">Seleccionar</option>');
                $.each(data, function(index, EtapaObj) {
                    $("#inputEtapa").append('<option value="'+EtapaObj.id+'">'+EtapaObj.descripcion+'</option>');
                })
            });
    });
</script>
