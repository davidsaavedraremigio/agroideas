{!!Form::model($indicador,['id'=>'FormUpdateResultado', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['indicador-resultado.update',$indicador->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="ResultadoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('indicador', 'Indicador de resultados') !!}
                <select name="indicador" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($indicadores as $fila)
                        <option value="{{$fila->id}}" {{($fila->id == $indicador->codIndicador)?'selected':''}}>{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm table-bordered table-striped">
                    <thead class="bg-secondary">
                        <tr>
                            <th class="text-center"><small>Nº</small></th>
                            <th class="text-center"><small>PERIODO</small></th>
                            <th class="text-center" width="20%"><small>PROYECCIÓN</small></th>
                            <th class="text-center" width="20%"><small>EJECUCIÓN</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><small>1</small></td>
                            <td class="text-left"><small>Proyección al año 01</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_1', number_format($indicador->proyeccion_anio_1,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_1', number_format($indicador->ejecucion_anio_1,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>2</small></td>
                            <td class="text-left"><small>Proyección al año 02</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_2', number_format($indicador->proyeccion_anio_2,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_2', number_format($indicador->ejecucion_anio_2,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>3</small></td>
                            <td class="text-left"><small>Proyección al año 03</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_3', number_format($indicador->proyeccion_anio_3,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_3', number_format($indicador->ejecucion_anio_3,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>4</small></td>
                            <td class="text-left"><small>Proyección al año 04</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_4', number_format($indicador->proyeccion_anio_4,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_4', number_format($indicador->ejecucion_anio_4,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>5</small></td>
                            <td class="text-left"><small>Proyección al año 05</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_5', number_format($indicador->proyeccion_anio_5,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_5', number_format($indicador->ejecucion_anio_5,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>6</small></td>
                            <td class="text-left"><small>Proyección al año 06</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_6', number_format($indicador->proyeccion_anio_6,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_6', number_format($indicador->ejecucion_anio_6,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>7</small></td>
                            <td class="text-left"><small>Proyección al año 07</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_7', number_format($indicador->proyeccion_anio_7,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_7', number_format($indicador->ejecucion_anio_7,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>8</small></td>
                            <td class="text-left"><small>Proyección al año 08</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_8', number_format($indicador->proyeccion_anio_8,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_8', number_format($indicador->ejecucion_anio_8,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>9</small></td>
                            <td class="text-left"><small>Proyección al año 09</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_9', number_format($indicador->proyeccion_anio_9,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_9', number_format($indicador->ejecucion_anio_9,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>10</small></td>
                            <td class="text-left"><small>Proyección al año 10</small></td>
                            <td class="text-center">{!! Form::text('prog_anio_10', number_format($indicador->proyeccion_anio_10,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00', 'readonly' => 'readonly']) !!}</td>
                            <td class="text-center">{!! Form::text('anio_10', number_format($indicador->ejecucion_anio_10,2,'.',''), ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                    </tbody>          
                </table>
            </div>
        </div>
    </div>   
</div>
<div class="modal-footer">
    <div id="Footer_UpdateResultado_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateResultado" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateResultado_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}