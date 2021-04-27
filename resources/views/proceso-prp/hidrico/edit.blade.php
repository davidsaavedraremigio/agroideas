{!!Form::model($productor,['id'=>'FormUpdateBalanceHidrico', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['socio.update-hidrico',$productor->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Resultados de la verificación de campo</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="BalanceHidricoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_documento', 'Nro. DNI') !!} {!! Form::text('nro_documento', $persona->dni, ['class' => 'form-control', 'placeholder' => '00000000', 'id' => 'input_nro_dni', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha de nacimiento') !!} {!! Form::date('fecha', $persona->fechaNacimiento, ['class' => 'form-control', 'placeholder' => 'yyyy-mm-dd', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('sexo', 'Sexo') !!} 
                <select name="sexo" class="form-control" disabled="disabled">
                    <option value="" selected="selected">Seleccionar</option>
                    <option value="0" {{($persona->sexo == 0)?'selected':''}}>Femenino</option>
                    <option value="1" {{($persona->sexo == 1)?'selected':''}}>Masculino</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', $persona->nombres, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombres']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Apellido paterno') !!} {!! Form::text('paterno', $persona->paterno, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_paterno']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Apellido materno') !!} {!! Form::text('materno', $persona->materno, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_materno']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección (La que figura en RENIEC)') !!} {!! Form::textarea('direccion', $persona->direccion, ['class' => 'form-control', 'readonly' => 'readonly', 'cols' => '2', 'rows' => '2', 'id' => 'input_direccion_dni']) !!}</div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="row"><label for="">1. ANTECEDENTES</label></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_ha_solicitada', 'Área que solicita reconvertir (ha) ') !!} {!! Form::text('nro_ha_solicitada', number_format($productor->nroHaSolicitaReconvertir,2), ['class' => 'form-control']) !!}</div>
            <div class="col-md-4"></div>
            <div class="col-md-4">{!! Form::label('nro_ha', 'Área total (ha)') !!} {!! Form::text('nro_ha', number_format($productor->nroHaPropiedad, 2), ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"><label for="">2. RESULTADO DE LA EVALUACIÓN</label></div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('resultado_suelo', 'Resultado análisis de suelo') !!}
                <select name="resultado_suelo" class="form-control">
                    <option value="" selected="selected">No evaluado</option>
                    <option value="1" {{($productor->resultadoAnalisisSuelo == 1)?'selected':''}}>Favorable</option>
                    <option value="2" {{($productor->resultadoAnalisisSuelo == 2)?'selected':''}}>Observado</option>
                    <option value="0" {{($productor->resultadoAnalisisSuelo == 0)?'selected':''}}>No aplica</option>
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('resultado_agua', 'Resultado análisis de agua') !!}
                <select name="resultado_agua" class="form-control">
                    <option value="" selected="selected">No evaluado</option>
                    <option value="1" {{($productor->resultadoAnalisisAgua == 1)?'selected':''}}>Favorable</option>
                    <option value="2" {{($productor->resultadoAnalisisAgua == 2)?'selected':''}}>Observado</option>
                    <option value="0" {{($productor->resultadoAnalisisAgua == 0)?'selected':''}}>No aplica</option>
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('resultado_hidrico', 'Resultado balance hídrico') !!}
                <select name="resultado_hidrico" class="form-control">
                    <option value="" selected="selected">No evaluado</option>
                    <option value="1" {{($productor->resultadoBalanceHidrico == 1)?'selected':''}}>Favorable</option>
                    <option value="2" {{($productor->resultadoBalanceHidrico == 2)?'selected':''}}>Observado</option>
                    <option value="0" {{($productor->resultadoBalanceHidrico == 0)?'selected':''}}>No aplica</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('comentario', 'Comentarios / observaciones') !!} {!! Form::textarea('comentario', $productor->comentarioBalanceHidrico, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_UpdateBalanceHidrico_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateBalanceHidrico" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateBalanceHidrico_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}