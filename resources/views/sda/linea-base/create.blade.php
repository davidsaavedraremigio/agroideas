{!! Form::open(array('id'=>'FormCreateLineaBase', 'route' => 'linea-base.store' ,'method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="LineaBaseAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">{!! Form::label('indicador', 'Indicador de resultados') !!}
                <select name="indicador" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($indicadores as $fila)
                        <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('linea_base', 'Valor de línea de base') !!} {!! Form::text('linea_base', '', ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div> 
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
                            <th class="text-center" width="20%"><small>VALOR</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><small>1</small></td>
                            <td class="text-left"><small>Proyección al año 01</small></td>
                            <td class="text-center">{!! Form::text('anio_1', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>2</small></td>
                            <td class="text-left"><small>Proyección al año 02</small></td>
                            <td class="text-center">{!! Form::text('anio_2', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>3</small></td>
                            <td class="text-left"><small>Proyección al año 03</small></td>
                            <td class="text-center">{!! Form::text('anio_3', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>4</small></td>
                            <td class="text-left"><small>Proyección al año 04</small></td>
                            <td class="text-center">{!! Form::text('anio_4', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>5</small></td>
                            <td class="text-left"><small>Proyección al año 05</small></td>
                            <td class="text-center">{!! Form::text('anio_5', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>6</small></td>
                            <td class="text-left"><small>Proyección al año 06</small></td>
                            <td class="text-center">{!! Form::text('anio_6', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>7</small></td>
                            <td class="text-left"><small>Proyección al año 07</small></td>
                            <td class="text-center">{!! Form::text('anio_7', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>8</small></td>
                            <td class="text-left"><small>Proyección al año 08</small></td>
                            <td class="text-center">{!! Form::text('anio_8', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>9</small></td>
                            <td class="text-left"><small>Proyección al año 09</small></td>
                            <td class="text-center">{!! Form::text('anio_9', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><small>10</small></td>
                            <td class="text-left"><small>Proyección al año 10</small></td>
                            <td class="text-center">{!! Form::text('anio_10', '', ['class' => 'form-control form-sm', 'placeholder' => '0.00']) !!}</td>
                        </tr>
                    </tbody>          
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateLineaBase_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateLineaBase" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateLineaBase_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}