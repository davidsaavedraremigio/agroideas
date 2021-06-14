{!! Form::open(array('id'=>'FormCreateCierre','route'=>'cierre.store','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Registrar cierre</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CierreAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    <div class="form-group">
        <div class="row"><div class="col-md-12"><label for="">I. Monitoreo y evaluación</label></div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_documento_me', 'Tipo de documento') !!} 
                <select name="tipo_documento_me" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoDocumento as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_documento_me', 'Nº de documento') !!} {!! Form::number('nro_documento_me', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_me', 'Fecha de documento') !!} {!! Form::date('fecha_me', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div> 
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('especialista', 'Especialista asignado') !!}
                <select name="especialista_me" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($monitoreo as $fila)
                        <option value="{{$fila->id}}">{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div> 
    <hr>
    <div class="form-group">
        <div class="row"><div class="col-md-12"><label for="">II. Unidad de Asesoría Jurídica</label></div></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_documento_uaj', 'Tipo de documento') !!} 
                <select name="tipo_documento_uaj" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoDocumento as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_documento_uaj', 'Nº de documento') !!} {!! Form::number('nro_documento_uaj', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_uaj', 'Fecha de documento') !!} {!! Form::date('fecha_uaj', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div> 
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('especialista_uaj', 'Especialista asignado') !!}
                <select name="especialista_uaj" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($uaj as $fila)
                        <option value="{{$fila->id}}">{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>       
    <hr>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('', 'III. Dirección Ejecutiva') !!}</div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_documento_de', 'Tipo de documento') !!} 
                <select name="tipo_documento_de" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoDocumento as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_documento_de', 'Nº de documento') !!} {!! Form::number('nro_documento_de', '', ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha_de', 'Fecha de documento') !!} {!! Form::date('fecha_de', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('especialista_de', 'Responsable de firma') !!}
                <select name="especialista_de" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($de as $fila)
                        <option value="{{$fila->id}}">{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>   

</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateCierre_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateCierre" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateCierre_Disabled" style="display:none;">
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