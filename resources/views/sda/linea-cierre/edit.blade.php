{!!Form::model($indicador,['id'=>'FormUpdateLineaCierre', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['linea-cierre.update',$indicador->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="LineaCierreAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('indicador', 'Indicador de resultados') !!}
                <select name="indicador" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($indicadores as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $indicador->codIndicador)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('linea_cierre', 'Valor de línea de cierre') !!} {!! Form::text('linea_cierre', number_format($indicador->valor_linea_cierre,2,'.',''), ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div> 
        </div>
    </div>


</div>
<div class="modal-footer">
    <div id="Footer_UpdateLineaCierre_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateLineaCierre" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateLineaCierre_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}