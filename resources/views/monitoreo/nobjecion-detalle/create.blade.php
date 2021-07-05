{!! Form::open(array('id'=>'FormCreateNoObjecionDetalle','route'=>'nobjecion-detalle.store','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo Bien o Servicio</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="NoObjecionDetalleAlerts" class="alert alert-danger" style="display: none;"></div>
    {!! Form::hidden('codigo', $informe->id, ['class' => 'form-control']) !!}
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('actividad', 'Actividad presupuestada') !!}
                <select name="actividad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($actividades as $fila)
                        <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8">{!! Form::label('descripcion', 'Descripción del bien / servicio') !!} {!! Form::text('descripcion', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_poa', 'Nº de POA') !!} {!! Form::number('nro_poa', '', ['class' => 'form-control', 'min' => '1', 'max' => '36']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_pc', 'Nº de Paso crítico') !!} {!! Form::number('nro_pc', '', ['class' => 'form-control', 'min' => '1', 'max' => '36']) !!}</div>
            <div class="col-md-4">{!! Form::label('referencia', 'Nº de ICM (Referencia)') !!} {!! Form::text('referencia', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_gasto', 'Tipo de gasto') !!}
                <select name="tipo_gasto" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_gastos as $fila)
                        <option value="{{$fila->Valor}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('financiamiento', 'Financiamiento') !!} {!! Form::text('financiamiento', $financiamiento->financiamiento, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('importe', 'Importe (S/.)') !!} {!! Form::text('importe', '', ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
        </div>
    </div>
    <hr class="my-4">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('banco', 'Entidad financiera') !!}
                <select name="banco" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($bancos as $fila)
                        <option value="{{$fila->Valor}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_cuenta', 'Tipo de cuenta') !!}
                <select name="tipo_cuenta" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_cuenta as $fila)
                        <option value="{{$fila->Valor}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('nro_cuenta', 'Nº de cuenta') !!} {!! Form::text('nro_cuenta', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_cci', 'Nº de CCI') !!} {!! Form::text('nro_cci', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <hr class="my-4">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('ruc', 'Nº de RUC') !!} {!! Form::text('ruc', '', ['class' => 'form-control', 'placeholder' => '00000000000', 'id' => 'input_nro_documento']) !!}</div>
            <div class="col-md-8">{!! Form::label('razon_social', 'Razón social') !!} {!! Form::text('razon_social', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombre']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('tipo_proveedor', 'Tipo de proveedor') !!} {!! Form::text('tipo_proveedor', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_tipo_proveedor']) !!}</div>
            <div class="col-md-4">{!! Form::label('esta_activo', 'Esta activo?') !!} {!! Form::text('esta_activo', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_esta_activo']) !!}</div>
            <div class="col-md-4">{!! Form::label('esta_habido', 'Esta habido?') !!} {!! Form::text('esta_habido', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_esta_habido']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección') !!} {!! Form::textarea('direccion', '', ['class' => 'form-control', 'rows' => '1', 'cols' => '2', 'readonly' => 'readonly', 'id' => 'input_direccion']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateNoObjecionDetalle_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateNoObjecionDetalle" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateNoObjecionDetalle_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    $('.select2').select2({
        theme: 'bootstrap4'
    });
 
    $("#input_nro_documento").keypress(function(e) {
            var tecla   = (e.keyCode ? e.keyCode : e.which);
            if (tecla == 13) 
            {
                var ruc         =   $("#input_nro_documento").val();
                var caracteres  =   ruc.length;

                if (caracteres == 11) 
                {
                    event.preventDefault();
                    var urlAction   =   route("servicio.ruc", ruc);

                    $.ajax({
                        url:    urlAction,
                        method: "GET",
                        data:   ruc,
                        beforeSend: function() {
                            $("#input_nombre").val("Consultando datos del proveedor ...");
                            $("#input_tipo_proveedor").val("Consultando datos del proveedor ...");
                            $("#input_esta_activo").val("Consultando datos del proveedor ...");
                            $("#input_esta_habido").val("Consultando datos del proveedor ...");
                            $("#input_direccion").val("Consultando datos del proveedor ...");
                        },
                        success: function(response) {
                            var cadena      =   jQuery.parseJSON(response);
                            var estado      =   cadena.estado;
                            if (estado == 1)
                            {
                                $("#input_nombre").val(cadena.nombre);
                                $("#input_tipo_proveedor").val(cadena.tipo);
                                $("#input_esta_activo").val(cadena.activo);
                                $("#input_esta_habido").val(cadena.habido);
                                $("#input_direccion").val(cadena.direccion);
                            }
                            else
                            {
                                alertify.error('El RUC consultado se encuenta en estado: '+cadena.dato);
                                $("#input_nombre").val("");
                                $("#input_tipo_proveedor").val("");
                                $("#input_esta_activo").val("");
                                $("#input_esta_habido").val("");
                                $("#input_direccion").val("");
                                $("#input_nro_documento").focus();
                                return false;
                            }
                        },
                        statusCode: {
                            404: function() {
                                alertify.error('El sistema presenta problemas de funcionamiento.');
                            }
                        }
                    });
                }
                else
                {
                    alertify.error('Error. Ingrese un número de RUC válido.');
                    $("#input_nro_documento").val("");
                    $("#input_nombre").val("");
                    $("#input_tipo_proveedor").val("");
                    $("#input_esta_activo").val("");
                    $("#input_esta_habido").val("");
                    $("#input_direccion").val("");
                    $("#input_nro_documento").focus();
                    return false;
                }
            }
        });   
</script>