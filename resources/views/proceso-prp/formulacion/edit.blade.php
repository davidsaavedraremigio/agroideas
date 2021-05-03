@extends('layouts.template')
@section('title', 'Formulación de PRPA')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabFormulacion" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabForm001" data-toggle="pill" href="#custom-tabs-general" role="tab" aria-controls="custom-tabs-general" aria-selected="true">1. Información general</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabForm002" data-toggle="pill" href="#custom-tabs-productor" role="tab" aria-controls="custom-tabs-productor" aria-selected="false">2. Productores</a></li>
                    <!--
                    <li class="nav-item"><a class="nav-link" id="TabForm003" data-toggle="pill" href="#custom-tabs-indicador" role="tab" aria-controls="custom-tabs-indicador" aria-selected="false">3. Resultados</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabForm004" data-toggle="pill" href="#custom-tabs-presupuesto" role="tab" aria-controls="custom-tabs-presupuesto" aria-selected="false">4. Presupuesto</a></li>-->
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabFormulacionContent">
                    <div class="tab-pane fade show active" id="custom-tabs-general" role="tabpanel" aria-labelledby="TabForm001">
                        {!!Form::model($expediente,['id'=>'FormUpdateFormulacion', 'method'=>'PUT', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['formulacion.update',$expediente->id]])!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="FormulacionAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12"><label for="">I. Datos de la organización</label></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('ruc', 'Nro de RUC (*)') !!} {!! Form::text('ruc', $entidad->nroDocumento, ['class' => 'form-control', 'placeholder' => '00000000000', 'maxlength' => '11', 'id' => 'input_nro_documento', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo_entidad', 'Tipo de organización (*)') !!}
                                    <select name="tipo_entidad" class="form-control select2" disabled="disabled">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipo_entidad as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $entidad->codTipoEntidad)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">{!! Form::label('nombre', 'Razon social (*)') !!}{!! Form::text('nombre', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_nombre']) !!}</div>    
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('', 'II. Diagnóstico del PRPA') !!}</div>
                            </div>
                            <div class="row">  
                                <div class="col-md-2">{!! Form::label('fecha_inicio', 'Inicio propuesto') !!} {!! Form::date('fecha_inicio', $proyecto->fecha_inicio, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-2">{!! Form::label('duracion', 'duración (meses)') !!} {!! Form::number('duracion', $proyecto->duracion, ['class' => 'form-control', 'min' => '36', 'max' => '72']) !!}</div>
                                <div class="col-md-2">{!! Form::label('cadena', 'Producto a instalar') !!}
                                    <select name="cadena" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($cultivos as $fila)
                                        <option value="{{$fila->id}}" {{($fila->id == $producto->codCadena)?'selected':''}}>{{$fila->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('nro_ha', 'Área a reconvertir (Ha)') !!} {!! Form::text('nro_ha', $area, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-3">{!! Form::label('nro_productores', 'Nº de productores') !!} {!! Form::text('nro_productores', $beneficiarios, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('objetivo', 'III. Objetivo general del PRPA') !!} {!! Form::textarea('objetivo', $proyecto->mlProposito, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('', 'IV. Financiamiento del PRPA') !!}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">{!! Form::label('aporte_pcc', 'PCC (S/)') !!} {!! Form::text('aporte_pcc', $proyecto->inversion_pcc, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-2">{!! Form::label('aporte_entidad', 'OA (S/)') !!} {!! Form::text('aporte_entidad', $proyecto->inversion_entidad, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-2">{!! Form::label('aporte_total', 'Total (S/.)') !!} {!! Form::text('aporte_total', $proyecto->inversion_total, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-6"><br></div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_UpdateFormulacion_Enabled">
                                       <a href="#" id="btnUpdateFormulacion" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/proceso-prp/formulacion" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_UpdateFormulacion_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-productor" role="tabpanel" aria-labelledby="TabForm002">
                        {{-- Contenido del módulo productores --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Productores beneficiarios del PRPA</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateProductorPrpa"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataProductorPrpa" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo productores --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modals para la gestión de Productores --}}
<div class="modal fade" id="modalCreateProductorPrpa">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateProductorPrpa">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateProductorPrpa">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateProductorPrpa">
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
        var urlApp              = "{{ env('APP_URL') }}";
        var codPostulante       =   $("#viewDataProductorPrpa").attr('data-id');
        //1. Proceso la información del proyecto
        $(document).on("click", '#btnUpdateFormulacion', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateFormulacion");
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
                    $("#Footer_UpdateFormulacion_Enabled").css("display", "none");
                    $("#Footer_UpdateFormulacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateFormulacion_Enabled").css("display", "block");
                    $("#Footer_UpdateFormulacion_Disabled").css("display", "none");
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
                    $("#FormulacionAlerts").css("display", "block");
                    $("#FormulacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateFormulacion_Enabled").css("display", "block");
                    $("#Footer_UpdateFormulacion_Disabled").css("display", "none");
                }
            });
        });
        //2. Muestro los datos de los productores del PRPA
        $("#viewDataProductorPrpa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataProductorPrpa").load(urlApp+'/prpa/productor/'+ codPostulante +'/data');
        //3. Genero los modals para añadir y editar productores
        $('#modalCreateProductorPrpa').on('show.bs.modal', function (e) {
            $('#divFormCreateProductorPrpa').load(urlApp+'/prpa/productor/' + codPostulante + '/create');
        });
        $('#modalUpdateProductorPrpa').on('show.bs.modal', function (e) {
            var codProductor= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateProductorPrpa').load(urlApp+'/prpa/productor/'+codProductor+'/edit');
        });
        //4. Proceso la información de productores del PRPA
        $(document).on("click", '#btnCreateProductorPrpa', function (event) {
            event.preventDefault();
            var form = $("#FormCreateProductorPrpa");
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
                    $("#Footer_CreateProductorPrpa_Enabled").css("display", "none");
                    $("#Footer_CreateProductorPrpa_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_CreateProductorPrpa_Enabled").css("display", "block");
                    $("#Footer_CreateProductorPrpa_Disabled").css("display", "none");
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
                    $("#ProductorPrpaAlerts").css("display", "block");
                    $("#ProductorPrpaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateProductorPrpa_Enabled").css("display", "block");
                    $("#Footer_CreateProductorPrpa_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateProductorPrpa', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateProductorPrpa");
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
                    $("#Footer_UpdateProductorPrpa_Enabled").css("display", "none");
                    $("#Footer_UpdateProductorPrpa_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateProductorPrpa_Enabled").css("display", "block");
                    $("#Footer_UpdateProductorPrpa_Disabled").css("display", "none");
                    $("#modalUpdateProductorPrpa").modal('hide');
                    $("#viewDataProductorPrpa").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataProductorPrpa").load(urlApp+'/prpa/productor/'+ codPostulante +'/data');
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
                    $("#ProductorPrpaAlerts").css("display", "block");
                    $("#ProductorPrpaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateProductorPrpa_Enabled").css("display", "block");
                    $("#Footer_UpdateProductorPrpa_Disabled").css("display", "none");
                }
            });
        });



/*
        $("#viewDataObjetivoEspecifico").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataObjetivoEspecifico").load(urlApp+'/proceso-prp/objetivo-especifico/'+ codPostulante +'/data');
        //3. Muestro el formulario de registro y edición de objetivos especifico
        $('#modalCreateObjetivoEspecifico').on('show.bs.modal', function (e) {
            $('#divFormCreateObjetivoEspecifico').load(urlApp+'/proceso-prp/objetivo-especifico/' + codPostulante + '/create');
        });
        $('#modalUpdateObjetivoEspecifico').on('show.bs.modal', function (e) {
            var codObjetivo= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateObjetivoEspecifico').load(urlApp+'/proceso-prp/objetivo-especifico/'+codObjetivo+'/edit');
        });
        //4. Proceso la información de objetivos específicos
        $(document).on("click", '#btnCreateObjetivoEspecifico', function (event) {
            event.preventDefault();
            var form = $("#FormCreateObjetivoEspecifico");
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
                    $("#Footer_CreateObjetivoEspecifico_Enabled").css("display", "none");
                    $("#Footer_CreateObjetivoEspecifico_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_CreateObjetivoEspecifico_Enabled").css("display", "block");
                    $("#Footer_CreateObjetivoEspecifico_Disabled").css("display", "none");
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
                    $("#ObjetivoEspecificoAlerts").css("display", "block");
                    $("#ObjetivoEspecificoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateObjetivoEspecifico_Enabled").css("display", "block");
                    $("#Footer_CreateObjetivoEspecifico_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateObjetivoEspecifico', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateObjetivoEspecifico");
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
                    $("#Footer_UpdateObjetivoEspecifico_Enabled").css("display", "none");
                    $("#Footer_UpdateObjetivoEspecifico_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateObjetivoEspecifico_Enabled").css("display", "block");
                    $("#Footer_UpdateObjetivoEspecifico_Disabled").css("display", "none");
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
                    $("#ObjetivoEspecificoAlerts").css("display", "block");
                    $("#ObjetivoEspecificoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateObjetivoEspecifico_Enabled").css("display", "block");
                    $("#Footer_UpdateObjetivoEspecifico_Disabled").css("display", "none");
                }
            });
        });
        //5. Muestro los datos de los componentes
        $("#viewDataComponente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataComponente").load(urlApp+'/proceso-prp/componente/'+ codPostulante +'/data');
        //6. Muestro el formulario de registro y edición de componentes
        $('#modalCreateComponente').on('show.bs.modal', function (e) {
            $('#divFormCreateComponente').load(urlApp+'/proceso-prp/componente/' + codPostulante + '/create');
        });
        $('#modalUpdateComponente').on('show.bs.modal', function (e) {
            var codComponente= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateComponente').load(urlApp+'/proceso-prp/componente/'+codComponente+'/edit');
        });
        //7. Proceso la información de componentes
        $(document).on("click", '#btnCreateComponente', function (event) {
            event.preventDefault();
            var form = $("#FormCreateComponente");
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
                    $("#Footer_CreateComponente_Enabled").css("display", "none");
                    $("#Footer_CreateComponente_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateComponente_Enabled").css("display", "block");
                    $("#Footer_CreateComponente_Disabled").css("display", "none");
                    $("#modalCreateComponente").modal('hide');
                    $("#viewDataComponente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataComponente").load(urlApp+'/proceso-prp/componente/'+ codPostulante +'/data');
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
                    $("#ComponenteAlerts").css("display", "block");
                    $("#ComponenteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateComponente_Enabled").css("display", "block");
                    $("#Footer_CreateComponente_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateComponente', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateComponente");
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
                    $("#Footer_UpdateComponente_Enabled").css("display", "none");
                    $("#Footer_UpdateComponente_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateComponente_Enabled").css("display", "block");
                    $("#Footer_UpdateComponente_Disabled").css("display", "none");
                    $("#modalUpdateComponente").modal('hide');
                    $("#viewDataComponente").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataComponente").load(urlApp+'/proceso-prp/componente/'+ codPostulante +'/data');
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
                    $("#ComponenteAlerts").css("display", "block");
                    $("#ComponenteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateComponente_Enabled").css("display", "block");
                    $("#Footer_UpdateComponente_Disabled").css("display", "none");
                }
            });
        });
        //8. Muestro los datos de las actividades
        $("#viewDataActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataActividad").load(urlApp+'/proceso-prp/actividad/'+ codPostulante +'/data');
        //9. Muestro el formulario de registro y edición de actividades
        $('#modalCreateActividad').on('show.bs.modal', function (e) {
            $('#divFormCreateActividad').load(urlApp+'/proceso-prp/actividad/' + codPostulante + '/create');
        });
        $('#modalUpdateActividad').on('show.bs.modal', function (e) {
            var codActividad= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateActividad').load(urlApp+'/proceso-prp/actividad/'+codActividad+'/edit');
        });
        //10. Proceso la información de componentes
        $(document).on("click", '#btnCreateActividad', function (event) {
            event.preventDefault();
            var form = $("#FormCreateActividad");
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
                    $("#Footer_CreateActividad_Enabled").css("display", "none");
                    $("#Footer_CreateActividad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateActividad_Enabled").css("display", "block");
                    $("#Footer_CreateActividad_Disabled").css("display", "none");
                    $("#modalCreateActividad").modal('hide');
                    $("#viewDataActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataActividad").load(urlApp+'/proceso-prp/actividad/'+ codPostulante +'/data');
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
                    $("#ActividadAlerts").css("display", "block");
                    $("#ActividadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateActividad_Enabled").css("display", "block");
                    $("#Footer_CreateActividad_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateActividad', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateActividad");
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
                    $("#Footer_UpdateActividad_Enabled").css("display", "none");
                    $("#Footer_UpdateActividad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateActividad_Enabled").css("display", "block");
                    $("#Footer_UpdateActividad_Disabled").css("display", "none");
                    $("#modalUpdateActividad").modal('hide');
                    $("#viewDataActividad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataActividad").load(urlApp+'/proceso-prp/actividad/'+ codPostulante +'/data');
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
                    $("#ActividadAlerts").css("display", "block");
                    $("#ActividadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateActividad_Enabled").css("display", "block");
                    $("#Footer_UpdateActividad_Disabled").css("display", "none");
                }
            });
        });

        //11. Muestro los datos de los Indicadores de resultado
        $("#viewDataIndicador").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataIndicador").load(urlApp+'/proceso-prp/indicador/'+ codPostulante +'/data');
        //12. Muestro el formulario de registro y edición de indicadores
        $('#modalCreateIndicador').on('show.bs.modal', function (e) {
            $('#divFormCreateIndicador').load(urlApp+'/proceso-prp/indicador/' + codPostulante + '/create');
        });
        $('#modalUpdateIndicador').on('show.bs.modal', function (e) {
            var codIndicador= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateIndicador').load(urlApp+'/proceso-prp/indicador/'+codIndicador+'/edit');
        });
        //13. Proceso la información de indicadores
        $(document).on("click", '#btnCreateIndicador', function (event) {
            event.preventDefault();
            var form = $("#FormCreateIndicador");
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
                    $("#Footer_CreateIndicador_Enabled").css("display", "none");
                    $("#Footer_CreateIndicador_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateIndicador_Enabled").css("display", "block");
                    $("#Footer_CreateIndicador_Disabled").css("display", "none");
                    $("#modalCreateIndicador").modal('hide');
                    $("#viewDataIndicador").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataIndicador").load(urlApp+'/proceso-prp/indicador/'+ codPostulante +'/data');
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
                    $("#IndicadorAlerts").css("display", "block");
                    $("#IndicadorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateIndicador_Enabled").css("display", "block");
                    $("#Footer_CreateIndicador_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateIndicador', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateIndicador");
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
                    $("#Footer_UpdateIndicador_Enabled").css("display", "none");
                    $("#Footer_UpdateIndicador_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateIndicador_Enabled").css("display", "block");
                    $("#Footer_UpdateIndicador_Disabled").css("display", "none");
                    $("#modalUpdateIndicador").modal('hide');
                    $("#viewDataIndicador").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataIndicador").load(urlApp+'/proceso-prp/indicador/'+ codPostulante +'/data');
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
                    $("#IndicadorAlerts").css("display", "block");
                    $("#IndicadorAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateIndicador_Enabled").css("display", "block");
                    $("#Footer_UpdateIndicador_Disabled").css("display", "none");
                }
            });
        });
*/


















    });
</script>
@stop