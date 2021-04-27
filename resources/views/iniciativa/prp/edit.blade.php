@extends('layouts.template')
@section('title', 'Pedido de reconversión productiva')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabPRP" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabPRP001" data-toggle="pill" href="#custom-tabs-prp" role="tab" aria-controls="custom-tabs-prp" aria-selected="true">1. Información general</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabPRP002" data-toggle="pill" href="#custom-tabs-ambito" role="tab" aria-controls="custom-tabs-ambito" aria-selected="false">2. Ámbito de intervención</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabPRP003" data-toggle="pill" href="#custom-tabs-productor" role="tab" aria-controls="custom-tabs-productor" aria-selected="false">3. Productores</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabPRPContent">
                    <div class="tab-pane fade show active" id="custom-tabs-prp" role="tabPRP" aria-labelledby="TabPRP001">
                        {!!Form::model($postulante,['id'=>'FormUpdatePRP', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['prp.update',$postulante->id]])!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="PRPAlerts" class="alert alert-danger" style="display: none;"></div>
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
                            <div class="row"><div class="col-md-12">{!! Form::label('', 'II. Información de cultivo/crianza a reconvertir:') !!}</div></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('cultivo', 'Cultivo/Crianza a reconvertir') !!} {!! Form::text('cultivo', $cultivo->descripcion, ['class' => 'form-control', 'placeholder' => 'Indique que cultivos/crianzas desea reconvertir.']) !!}</div>
                                <div class="col-md-3">{!! Form::label('cadena', 'Cultivo/Crianza a instalar') !!}
                                    <select name="cadena" class="form-control select2" id ="inputCadena">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($cadena as $fila)
                                            <option value="{{$fila->id}}" {{($fila->id == $producto->codCadena)?'selected':''}}>{{$fila->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('hectareas_sp', 'Nº Has') !!} {!! Form::text('hectareas_sp', $proyecto->area, ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
                                <div class="col-md-3">{!! Form::label('productores_total', 'Nº de socios') !!} {!! Form::number('productores_total', $proyecto->nro_beneficiarios, ['class' => 'form-control', 'min' => '1', 'max' => '999']) !!}</div>
                            </div>
                        </div>            
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_UpdatePRP_Enabled">
                                       <a href="#" id="btnUpdatePRP" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/iniciativa/prp" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_UpdatePRP_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-ambito" role="tabpanel" aria-labelledby="TabPRP002">
                        {{-- Contenido del módulo Ambito--}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Ámbito de intervención</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateUbigeo"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataUbigeo" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ambito--}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-productor" role="tabpanel" aria-labelledby="TabPRP003">
                        {{-- Contenido del módulo PC--}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Relación de socios productores participantes</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateProductor"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataProductor" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ambito--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modals --}}
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateProducto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateProducto">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateProducto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateProducto">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateUbigeo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateUbigeo">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateUbigeo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateUbigeo">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateProductor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateProductor">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateProductor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateProductor">
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
        //1. Obtengo los datos de SUNAT
        $("#input_nro_documento").keypress(function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
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
        //2. Definimos los campos numericos
        $("#inputImportePCC").numeric();
        $("#inputImporteEntidad").numeric();
        $("#inputImporteTotal").numeric();
        //3. Proceso el registro
        $(document).on("click", '#btnUpdatePRP', function (event) {
            event.preventDefault();
            var form = $("#FormUpdatePRP");
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
                    $("#Footer_UpdatePRP_Enabled").css("display", "none");
                    $("#Footer_UpdatePRP_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdatePRP_Enabled").css("display", "block");
                    $("#Footer_UpdatePRP_Disabled").css("display", "none");
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
                    $("#PRPAlerts").css("display", "block");
                    $("#PRPAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdatePRP_Enabled").css("display", "block");
                    $("#Footer_UpdatePRP_Disabled").css("display", "none");
                }
            });
        });
        //4. Modulo Productos
        var codigo    =   $("#viewDataUbigeo").attr('data-id');
        $("#viewDataUbigeo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataUbigeo").load(urlApp+'/iniciativa/ambito/'+ codigo +'/data');
        $('#modalCreateUbigeo').on('show.bs.modal', function (e) {
            $('#divFormCreateUbigeo').load(urlApp+'/iniciativa/ambito/' + codigo + '/create');
        });
        $('#modalUpdateUbigeo').on('show.bs.modal', function (e) {
            var codUbigeo= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateUbigeo').load(urlApp+'/iniciativa/ambito/'+codUbigeo+'/edit');
        });
        $(document).on("click", '#btnCreateUbigeo', function (event) {
            event.preventDefault();
            var form = $("#FormCreateUbigeo");
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
                    $("#Footer_CreateUbigeo_Enabled").css("display", "none");
                    $("#Footer_CreateUbigeo_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateUbigeo_Enabled").css("display", "block");
                    $("#Footer_CreateUbigeo_Disabled").css("display", "none");
                    $("#modalCreateUbigeo").modal('hide');
                    $("#viewDataUbigeo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataUbigeo").load(urlApp+'/iniciativa/ambito/'+ codigo +'/data');
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
                    $("#UbigeoAlerts").css("display", "block");
                    $("#UbigeoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateUbigeo_Enabled").css("display", "block");
                    $("#Footer_CreateUbigeo_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateUbigeo', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateUbigeo");
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
                    $("#Footer_UpdateUbigeo_Enabled").css("display", "none");
                    $("#Footer_UpdateUbigeo_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateUbigeo_Enabled").css("display", "block");
                    $("#Footer_UpdateUbigeo_Disabled").css("display", "none");
                    $("#modalUpdateUbigeo").modal('hide');
                    $("#viewDataUbigeo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataUbigeo").load(urlApp+'/iniciativa/ambito/'+ codigo +'/data');
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
                    $("#UbigeoAlerts").css("display", "block");
                    $("#UbigeoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateUbigeo_Enabled").css("display", "block");
                    $("#Footer_UpdateUbigeo_Disabled").css("display", "none");
                }
            });
        });
        //6. Módulo Productores
        $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataProductor").load(urlApp+'/iniciativa/socio/'+ codigo +'/data');
        $('#modalCreateProductor').on('show.bs.modal', function (e) {
            $('#divFormCreateProductor').load(urlApp+'/iniciativa/socio/' + codigo + '/create');
        });
        $('#modalUpdateProductor').on('show.bs.modal', function (e) {
            var codProductor= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateProductor').load(urlApp+'/iniciativa/socio/'+codProductor+'/edit');
        });
        $(document).on("click", '#btnCreateProductor', function (event) {
            event.preventDefault();
            var form = $("#FormCreateProductor");
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
                    $("#Footer_CreateProductor_Enabled").css("display", "none");
                    $("#Footer_CreateProductor_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateProductor_Enabled").css("display", "block");
                    $("#Footer_CreateProductor_Disabled").css("display", "none");
                    $("#modalCreateProductor").modal('hide');
                    $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductor").load(urlApp+'/iniciativa/socio/'+ codigo +'/data');
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
                    $("#ProductorAlerts").css("display", "block");
                    $("#ProductorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateProductor_Enabled").css("display", "block");
                    $("#Footer_CreateProductor_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateProductor', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateProductor");
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
                    $("#Footer_UpdateProductor_Enabled").css("display", "none");
                    $("#Footer_UpdateProductor_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateProductor_Enabled").css("display", "block");
                    $("#Footer_UpdateProductor_Disabled").css("display", "none");
                    $("#modalUpdateProductor").modal('hide');
                    $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductor").load(urlApp+'/iniciativa/socio/'+ codigo +'/data');
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
                    $("#ProductorAlerts").css("display", "block");
                    $("#ProductorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateProductor_Enabled").css("display", "block");
                    $("#Footer_UpdateProductor_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop