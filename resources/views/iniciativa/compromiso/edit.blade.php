{!!Form::model($compromiso,['id'=>'FormUpdateCompromiso', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['compromiso.update',$compromiso->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="CompromisoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('tipo_documento', 'Tipo de documento') !!}
                <select name="tipo_documento" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoDocumento as $fila)
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $compromiso->codTipoDocumento)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('nro_documento', 'Nº de documento') !!} {!! Form::text('nro_documento', $compromiso->nroDocumento, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('fecha_documento', 'Fecha') !!} {!! Form::date('fecha_documento', $compromiso->fechaDocumento, ['class' => 'form-control']) !!}</div>
        </div>
    </div>    
    <div class="form-group">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-lg-12">{!! Form::label('compromiso', 'Compromiso asumido') !!} {!! Form::textarea('compromiso', $compromiso->compromiso, ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => 'Describa el acuerdo, actividad y/o compromiso asumido']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('tipo_compromiso', 'Tipo de compromiso') !!}
                <select name="tipo_compromiso" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoCompromiso as $fila)
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $compromiso->codTipoCompromiso)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('fecha_plazo', 'Fecha límite') !!} {!! Form::date('fecha_plazo', $compromiso->fechaPlazo, ['class' => 'form-control']) !!}</div>
            <div class="col-md-4 col-lg-4 col-xs-4">{!! Form::label('inversion', 'Inversión (S/)') !!} {!! Form::text('inversion', $compromiso->inversion, ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xs-12">{!! Form::label('responsable', 'Responsable(s)') !!} {!! Form::text('responsable', $compromiso->responsable, ['class' => 'form-control', 'placeholder' => 'Responsable de realizar seguimiento al cumplimiento del compromiso']) !!}</div>
            <div class="col-md-4 col-lg-4 col-xs-12">{!! Form::label('nro_incentivo', 'Nº de incentivos a identificar') !!} {!! Form::number('nro_incentivo', $compromiso->nroEntidades, ['class' => 'form-control', 'min' => '0', 'max' => '100', 'placeholder' => '0']) !!}</div>
            <div class="col-md-4 col-lg-4 col-xs-12">{!! Form::label('estado_compromiso', 'Situación') !!}
                <select name="estado_compromiso" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($estadoCompromiso as $fila)
                        <option value="{{$fila->Orden}}" {{($fila->Orden == $compromiso->codEstado)?'selected':''}}>{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateCompromiso_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateCompromiso" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateCompromiso_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}