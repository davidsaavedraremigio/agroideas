{!! Form::open(array('id'=>'FormCreateEntidad','url'=>'iniciativa/evento-entidad','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="EntidadAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <input type="hidden" name="evento" value="{{$codEvento}}">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('ruc', 'Nro de RUC') !!} {!! Form::text('ruc', '', ['class' => 'form-control', 'placeholder' => '00000000000', 'maxlength' => '11', 'id' => 'input_nro_documento']) !!}</div>
            <div class="col-md-8">{!! Form::label('tipo_entidad', 'Tipo de organización') !!}
                <select name="tipo_entidad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoEntidad as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>    
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xs-12">{!! Form::label('nombre', 'Razon social') !!}{!! Form::text('nombre', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombre']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('ubigeo', 'Código ubigeo') !!} {!! Form::text('ubigeo', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_ubigeo']) !!}</div>
            <div class="col-md-8">{!! Form::label('direccion', 'Dirección') !!} {!! Form::text('direccion', '', ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_direccion']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('compromiso', 'Seleccione el compromiso al que corresponde esta Organización') !!}
                <select name="compromiso" class="form-control select2">
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
            <div class="col-md-4">{!! Form::label('tipo_incentivo', 'Tipo de incentivo') !!}
                <select name="tipo_incentivo" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipoIncentivo as $fila)
                    <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('cadena_inicial', 'Cadena productiva inicial') !!} 
                <select name="cadena_inicial" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadenaProductiva as $fila)
                    <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('cadena_propuesta', 'Cadena productiva') !!}
                <select name="cadena_propuesta" class="form-control">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($cadenaProductiva as $fila)
                    <option value="{{$fila->id}}">{{$fila->descripcion}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nro_productores', 'Nro de productores (aprox.)') !!} {!! Form::text('nro_productores', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('nro_hectareas', 'Nro de Has (aprox.)') !!} {!! Form::text('nro_hectareas', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('inversion', 'Inversión PCC (S/)') !!} {!! Form::text('inversion', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateEntidad_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateEntidad" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateEntidad_Disabled" style="display:none;">
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
        $("#input_nro_documento").keypress(function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            if (tecla == 13) 
            {
                var ruc         =   $("#input_nro_documento").val();
                var caracteres  =   ruc.length;

                if (caracteres == 11) 
                {
                    event.preventDefault();
                    var urlAction =   urlApp+'/ruc/'+ruc;
                    
                    $.ajax({
                        url:    urlAction,
                        method: "GET",
                        data:   ruc,
                        beforeSend: function() {
                            $("#input_nombre").val("Consultando datos del proveedor ...");
                        },
                        success: function(response) {
                            var cadena      =   jQuery.parseJSON(response);
                            var estado      =   cadena.estado;
                            if (estado == 1)
                            {
                                $("#input_nombre").val(cadena.dato);
                                $("#input_estado_domicilio").val(cadena.domicilio);
                                $("#input_estado_contribuyente").val(cadena.situacion);
                                $("#input_direccion").val(cadena.direccion);
                                $("#input_ubigeo").val(cadena.ubigeo);
                            }
                            else
                            {
                                alertify.error('El RUC consultado se encuenta en estado: '+cadena.dato);
                                $("#input_nombre").val("");
                                $("#input_estado_domicilio").val("");
                                $("#input_estado_contribuyente").val("");
                                $("#input_direccion").val("");
                                $("#input_ubigeo").val("");
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
                    $("#input_estado_domicilio").val("");
                    $("#input_estado_contribuyente").val("");
                    $("#input_direccion").val("");
                    $("#input_ubigeo").val("");
                    $("#input_nro_documento").focus();
                    return false;
                }
            }
        });
    });
</script>