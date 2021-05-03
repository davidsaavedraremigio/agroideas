@extends('layouts.template')
@section('title', 'Solicitudes de apoyo')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabSda" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabSda001" data-toggle="pill" href="#custom-tabs-sda" role="tab" aria-controls="custom-tabs-sda" aria-selected="true">1. Información general</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabSda002" data-toggle="pill" href="#custom-tabs-productor" role="tab" aria-controls="custom-tabs-productor" aria-selected="false">2. Productores</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabSdaContent">
                    <div class="tab-pane fade show active" id="custom-tabs-sda" role="tabSda" aria-labelledby="TabSda001">
                        {!!Form::model($postulante,['id'=>'FormUpdateSda', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['sda.update',$postulante->id]])!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="SdaAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12"><label for="">I. Datos de la organización</label></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ruc', 'Nro de RUC (*)') !!} {!! Form::text('ruc', $entidad->nroDocumento, ['class' => 'form-control', 'placeholder' => '00000000000', 'maxlength' => '11', 'id' => 'input_nro_documento']) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo_entidad', 'Tipo de organización (*)') !!}
                                    <select name="tipo_entidad" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoEntidad as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $entidad->codTipoEntidad)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">{!! Form::label('nombre', 'Razon social (*)') !!}{!! Form::text('nombre', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombre']) !!}</div>    
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ubigeo', 'Código ubigeo (*)') !!} {!! Form::text('ubigeo', $entidad->ubigeo, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_ubigeo']) !!}</div>
                                <div class="col-md-9">{!! Form::label('direccion', 'Dirección (*)') !!} {!! Form::text('direccion', $entidad->direccion, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_direccion']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row"><div class="col-md-12">{!! Form::label('', 'II. Datos de la propuesta de SDA:') !!}</div></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('tipo', 'Tipo de incentivo') !!}
                                    <select name="tipo" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoIncentivo as $fila)
                                            @if ($fila->Orden != 2)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $postulante->codTipoIncentivo)?'selected':''}}>{{$fila->Nombre}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('cadena', 'Cultivo / Crianza') !!}
                                    <select name="cadena" class="form-control select2" id ="inputCadena">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($cadena as $fila)
                                            <option value="{{$fila->id}}" {{($fila->id == $producto->codCadena)?'selected':''}}>{{$fila->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('nro_ha_total', 'Nº Has total') !!} {!! Form::text('nro_ha_total', $proyecto->area, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('nro_ha', 'Nº Has destinadas al cultivo') !!} {!! Form::text('nro_ha', $producto->nroHas, ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('productores_varones', 'Nº hombres') !!} {!! Form::number('productores_varones', $proyecto->nro_beneficiarios_varones, ['class' => 'form-control beneficiario', 'min' => '1', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                <div class="col-md-3">{!! Form::label('productores_mujeres', 'Nº mujeres') !!} {!! Form::number('productores_mujeres', $proyecto->nro_beneficiarios_mujeres, ['class' => 'form-control beneficiario', 'min' => '1', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                <div class="col-md-3">{!! Form::label('productores', 'Total') !!} {!! Form::number('productores', $proyecto->nro_beneficiarios, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_beneficiarios_total']) !!}</div>
                                <div class="col-md-3">{!! Form::label('inversion', 'Inversión (S/.)') !!} {!! Form::text('inversion', $proyecto->inversion_pcc, ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_UpdateSda_Enabled">
                                       <a href="#" id="btnUpdateSda" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/iniciativa/sda" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_UpdateSda_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-productor" role="tabpanel" aria-labelledby="TabSda002">
                        {{-- Contenido del módulo Beneficiarios--}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Productores que conforman el padrón de beneficiarios</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateProductorSda"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataProductorSda" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Beneficiarios--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal para el registro de nuevos productores--}}    
<div class="modal fade" id="modalCreateProductorSda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateProductorSda">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la edición de  registros --}}
<div class="modal fade" id="modalUpdateProductorSda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateProductorSda">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Fin del contenido--}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        var urlApp  = "{{ env('APP_URL') }}";
        var codPostulante    =   $("#viewDataProductorSda").attr('data-id');
        //1. Obtengo los datos de SUNAT
        $("#input_nro_documento").keypress(function(e) {
            var tecla   = (e.keyCode ? e.keyCode : e.which);
            if (tecla == 13) 
            {
                var ruc         =   $("#input_nro_documento").val();
                var caracteres  =   ruc.length;

                if (caracteres == 11) 
                {
                    event.preventDefault();
                    var urlAction = urlApp+'/ruc/'+ruc;
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
                                $("#input_direccion").val(cadena.direccion);
                                $("#input_ubigeo").val(cadena.ubigeo);
                                $("#input_tipo_entidad").append('<option value="'+cadena.codigo+'" selected="selected">'+cadena.tipo+'</option>');
                            }
                            else
                            {
                                alertify.error('El RUC consultado se encuenta en estado: '+cadena.dato);
                                $("#input_nombre").val("");
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
                    $("#input_direccion").val("");
                    $("#input_ubigeo").val("");
                    $("#input_nro_documento").focus();
                    return false;
                }
            }
        });
        //2. Actualizo el registro
        $(document).on("click", '#btnUpdateSda', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateSda");
            var urlAction = form.attr('action');
            var formData = new FormData(form[0]);
            var dataAll = form.serialize();
            var formMethod = form.attr('method');
            $.ajax({
                url: urlAction,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#Footer_UpdateSda_Enabled").css("display", "none");
                    $("#Footer_UpdateSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateSda_Enabled").css("display", "block");
                    $("#Footer_UpdateSda_Disabled").css("display", "none");
                    $(location).attr('href', url_edit);
                },
                error: function (response) {
                    var errors = response.responseJSON;
                    var errorTitle = errors.message;
                    console.error(errorTitle);
                    var errorsHtml = '';
                    $.each(errors['errors'], function (index, value) {
                        errorsHtml += '<ul>';
                        errorsHtml += '<li>' + value + "</li>";
                        errorsHtml += '</ul>';
                    });
                    $("#SdaAlerts").css("display", "block");
                    $("#SdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateSda_Enabled").css("display", "block");
                    $("#Footer_UpdateSda_Disabled").css("display", "none");
                }
            });
        });
        //3. Mostramos la información de los Productores
        $("#viewDataProductorSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataProductorSda").load(urlApp+'/sda/productor/'+codPostulante+'/data');
        //4. Mostramos los formularios para añadir y eliminar registros
        $('#modalCreateProductorSda').on('show.bs.modal', function (e) {
            $('#divFormCreateProductorSda').load(urlApp+'/sda/productor/' + codPostulante + '/create');
        });
        $('#modalUpdateProductorSda').on('show.bs.modal', function (e) {
            var codProductor= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateProductorSda').load(urlApp+'/sda/productor/'+codProductor+'/edit');
        });
        //5. Procesamos la información de Productores
        $(document).on("click", '#btnCreateProductorSda', function (event) {
            event.preventDefault();
            var form = $("#FormCreateProductorSda");
            var urlAction = form.attr('action');
            var formData = new FormData(form[0]);
            var dataAll = form.serialize();
            $.ajax({
                url: urlAction,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#Footer_CreateProductorSda_Enabled").css("display", "none");
                    $("#Footer_CreateProductorSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateProductorSda_Enabled").css("display", "block");
                    $("#Footer_CreateProductorSda_Disabled").css("display", "none");
                    $("#modalCreateProductorSda").modal('hide');
                    $("#viewDataProductorSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductorSda").load(urlApp+'/sda/productor/'+codPostulante+'/data');
                    alertify.success(mensaje);
                },
                error: function (response) {
                    var errors = response.responseJSON;
                    var errorTitle = errors.message;
                    console.error(errorTitle);
                    var errorsHtml = '';
                    $.each(errors['errors'], function (index, value) {
                        errorsHtml += '<ul>';
                        errorsHtml += '<li>' + value + "</li>";
                        errorsHtml += '</ul>';
                    });
                    $("#ProductorSdaAlerts").css("display", "block");
                    $("#ProductorSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateProductorSda_Enabled").css("display", "block");
                    $("#Footer_CreateProductorSda_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateProductorSda', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateProductorSda");
            var urlAction = form.attr('action');
            var formData = new FormData(form[0]);
            var dataAll = form.serialize();
            $.ajax({
                url: urlAction,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#Footer_UpdateProductorSda_Enabled").css("display", "none");
                    $("#Footer_UpdateProductorSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateProductorSda_Enabled").css("display", "block");
                    $("#Footer_UpdateProductorSda_Disabled").css("display", "none");
                    $("#modalUpdateProductorSda").modal('hide');
                    $("#viewDataProductorSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductorSda").load(urlApp+'/sda/productor/'+codPostulante+'/data');
                    alertify.success(mensaje);
                },
                error: function (response) {
                    var errors = response.responseJSON;
                    var errorTitle = errors.message;
                    console.error(errorTitle);
                    var errorsHtml = '';
                    $.each(errors['errors'], function (index, value) {
                        errorsHtml += '<ul>';
                        errorsHtml += '<li>' + value + "</li>";
                        errorsHtml += '</ul>';
                    });
                    $("#ProductorSdaAlerts").css("display", "block");
                    $("#ProductorSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateProductorSda_Enabled").css("display", "block");
                    $("#Footer_UpdateProductorSda_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '.btnDeleteProductorSda', function (event) {
            event.preventDefault();
            var codigo = $(this).data("id");
            var urlAction = urlApp+'/sda/productor/'+codigo+'/destroy';
            // Antes de procesar realizamos una confirmación del proceso
            alertify.confirm("Confirmación de envío de formulario", "¿Esta seguro de que desea eliminar este ítem?.",
                function () {
                    $.ajax({
                        url: urlAction,
                        method: "POST",
                        data: codigo,
                        beforeSend: function () {},
                        success: function (response) {
                            var cadena = response;
                            var mensaje = cadena.mensaje;
                            alertify.alert("Proceso concluido", mensaje, function () {
                                $("#viewDataProductorSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                $("#viewDataProductorSda").load(urlApp+'/sda/productor/'+codPostulante+'/data');
                            });
                        },
                        statusCode: {
                            404: function () {
                                ertify.error('El sistema presenta problemas de funcionamiento.');
                            }
                        },
                        error: function (x, xs, xt) {
                            var errors = x.responseJSON;
                            var errorsHtml = '';
                            $.each(errors['errors'], function (index, value) {
                                errorsHtml += '<ul>';
                                errorsHtml += '<li>' + value + "</li>";
                                errorsHtml += '</ul>';
                            });
                            alertify.alert("Error de validación", errorsHtml, function () {
                                form[0].reset();
                            });
                        }
                    });
                },
                function () {
                    alertify.error('Proceso cancelado');
                    $("#viewDataProductorSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductorSda").load(urlApp+'/sda/productor/'+codPostulante+'/data');
                }
            );
        });
    });

    //a. Sumanos la cantidad de productores
    function sumaBeneficiarios() {
        var add = 0;
        $('.beneficiario').each(function() {
            if (!isNaN($(this).val())) {
                add += Number($(this).val());
            }
        });
        $('#input_beneficiarios_total').val(add);
    };
</script>
@stop