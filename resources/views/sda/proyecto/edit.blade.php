@extends('layouts.template')
@section('title', 'Módulo Información general del Proyecto')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabProyecto" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabProyecto001" data-toggle="pill" href="#custom-tabs-proyecto" role="tab" aria-controls="custom-tabs-proyecto" aria-selected="true">1. Información general</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabEvento002" data-toggle="pill" href="#custom-tabs-productor" role="tab" aria-controls="custom-tabs-productor" aria-selected="false">2. Productores</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabEvento003" data-toggle="pill" href="#custom-tabs-lb" role="tab" aria-controls="custom-tabs-lb" aria-selected="false">3. Línea de base</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabEvento004" data-toggle="pill" href="#custom-tabs-ejecucion" role="tab" aria-controls="custom-tabs-ejecucion" aria-selected="false">4. Ejecución</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabEvento005" data-toggle="pill" href="#custom-tabs-lc" role="tab" aria-controls="custom-tabs-lc" aria-selected="false">5. Línea de cierre</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabProyectoContent">
                    <div class="tab-pane fade show active" id="custom-tabs-proyecto" role="tabpanel" aria-labelledby="TabProyecto001">
                        {!!Form::model($postulante,['id'=>'FormUpdateProyecto', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['proyecto.update',$postulante->id]])!!}
                        {{-- Panel para mostrar alertas --}}
                        <div id="ProyectoAlerts" class="alert alert-danger" style="display: none;"></div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">{!! Form::label('nro_convenio', 'Nº de convenio') !!} {!! Form::number('nro_convenio', $contrato->nroContrato, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-2">{!! Form::label('fecha_firma', 'Fecha de firma') !!} {!! Form::date('fecha_firma', $contrato->fechaFirma, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-2">{!! Form::label('ruc', 'Nº RUC') !!} {!! Form::text('ruc', $entidad->nroDocumento, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-6">{!! Form::label('razon_social', 'Razón social') !!} {!! Form::textarea('razon_social', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly', 'rows' => '1', 'cols' => '1']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('titulo', 'Título del plan de negocio') !!} {!! Form::textarea('titulo', $proyecto->tituloProyecto, ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">{!! Form::label('incentivo', 'Tipo de incentivo') !!}
                                    <select name="incentivo" class="form-control">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($incentivos as $fila)
                                        @if ($fila->Orden!=2)
                                        <option value="{{$fila->Orden}}" {{($fila->Orden == $postulante->codTipoIncentivo)?'selected':''}}>{{$fila->Nombre}}</option>       
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('duracion', 'Duración') !!} {!! Form::number('duracion', $proyecto->duracion, ['class' => 'form-control', 'min' => '1', 'max' => '99']) !!}</div>
                                <div class="col-md-2">{!! Form::label('inicio', 'Fecha de inicio') !!} {!! Form::date('inicio', $proyecto->fecha_inicio, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-4">{!! Form::label('cadena', 'Cadena productiva') !!}
                                    <select name="cadena" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($cadenas as $fila)
                                        <option value="{{$fila->id}}" {{($fila->id == $cadena->codCadena)?'selected':''}}>{{$fila->descripcion}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('area', 'Nº Ha') !!} {!! Form::text('area', number_format($proyecto->area,2,'.',''), ['class' => 'form-control']) !!}</div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">{!! Form::label('prod_var', 'Productores varones') !!} {!! Form::number('prod_var', $proyecto->nro_beneficiarios_varones, ['class' => 'form-control productor', 'min' => '1', 'max' => '99', 'onChange' => 'sumaProductor();']) !!}</div>
                                <div class="col-md-2">{!! Form::label('prod_muj', 'Productores mujeres') !!} {!! Form::number('prod_muj', $proyecto->nro_beneficiarios_mujeres, ['class' => 'form-control productor', 'min' => '1', 'max' => '99', 'onChange' => 'sumaProductor();']) !!}</div>
                                <div class="col-md-2">{!! Form::label('prod_total', 'Productores total') !!} {!! Form::number('prod_total', $proyecto->nro_beneficiarios, ['class' => 'form-control', 'id' => 'input_productor_total', 'min' => '1', 'max' => '99', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-2">{!! Form::label('aporte_pcc', 'Aporte PCC (S/.)') !!} {!! Form::text('aporte_pcc', number_format($proyecto->inversion_pcc,2,'.',''), ['class' => 'form-control importe', 'onChange' => 'sumaImporte();']) !!}</div>
                                <div class="col-md-2">{!! Form::label('aporte_entidad', 'Aporte Entidad (S/.)') !!} {!! Form::text('aporte_entidad', number_format($proyecto->inversion_entidad,2,'.',''), ['class' => 'form-control importe', 'onChange' => 'sumaImporte();']) !!}</div>
                                <div class="col-md-2">{!! Form::label('aporte_total', 'Aporte Total (S/.)') !!} {!! Form::text('aporte_total', number_format($proyecto->inversion_total,2,'.',''), ['class' => 'form-control', 'id' => 'input_importe_total', 'readonly' => 'readonly']) !!}</div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_UpdateProyecto_Enabled">
                                       <a href="#" id="btnUpdateProyecto" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{route('proyecto.index')}}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_UpdateProyecto_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {{-- Panel para mostrar alertas --}}
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-productor" role="tabpanel" aria-labelledby="TabProyecto002">
                    {{-- Contenido del módulo Indicadores - Linea de base --}}
                    <section class="content">
                        <div class="container-fluid">
                            <div class="card card-default color-palette-box">
                                <div class="card-header">
                                    <h3 class="card-title">Productores que conforman el Plan de negocio</h3>
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
                    {{-- Contenido del módulo Indicadores - Linea de base --}}    
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-lb" role="tabpanel" aria-labelledby="TabProyecto003">
                        {{-- Contenido del módulo Indicadores - Linea de base --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Línea de base - Indicadores del Plan de negocio</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateLineaBase"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataLineaBase" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Indicadores - Linea de base --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-ejecucion" role="tabpanel" aria-labelledby="TabProyecto004">
                        {{-- Contenido del módulo Indicadores - Resultados --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Resultados - Indicadores del Plan de negocio</h3>
                                        <div class="card-tools"></div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataResultado" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Indicadores - Resultados --}}    
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-lc" role="tabpanel" aria-labelledby="TabProyecto005">
                        {{-- Contenido del módulo Indicadores - Linea de cierre --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Línea de cierre - Indicadores del Plan de negocio</h3>
                                        <div class="card-tools"></div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataLineaCierre" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Indicadores - Linea de cierre --}}    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal para la creación y modificación de registros --}}
<div class="modal fade" id="modalCreateLineaBase">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateLineaBase">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateLineaBase">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateLineaBase">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateResultado">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateResultado">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateLineaCierre">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateLineaCierre">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalCreateProductor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateProductor">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Fin del contenido--}}


{{-- Fin del contenido --}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //1. Actualizo la información del Proyecto
        $(document).on("click", '#btnUpdateProyecto', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateProyecto");
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
                    $("#Footer_UpdateProyecto_Enabled").css("display", "none");
                    $("#Footer_UpdateProyecto_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateProyecto_Enabled").css("display", "block");
                    $("#Footer_UpdateProyecto_Disabled").css("display", "none");
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
                    $("#ProyectoAlerts").css("display", "block");
                    $("#ProyectoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateProyecto_Enabled").css("display", "block");
                    $("#Footer_UpdateProyecto_Disabled").css("display", "none");
                }
            });
        });
        //2. Muestro la información de Línea de base
        var codPostulante    =   $("#viewDataLineaBase").attr('data-id');
        $("#viewDataLineaBase").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataLineaBase").load(route('linea-base.data', codPostulante));
        $("#viewDataResultado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataResultado").load(route('indicador-resultado.data', codPostulante));
        $("#viewDataLineaCierre").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataLineaCierre").load(route('linea-cierre.data', codPostulante));
        $("#viewDataProductor").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataProductor").load(route('productor-sda.data', codPostulante));
        //3. Muestro los modals
        $('#modalCreateLineaBase').on('show.bs.modal', function (e) {
            $("#divFormCreateLineaBase").load(route('linea-base.create', codPostulante));
        });
        $('#modalUpdateLineaBase').on('show.bs.modal', function (e) {
            var codLineaBase= $(e.relatedTarget).attr('data-id');
            $("#divFormUpdateLineaBase").load(route('linea-base.edit', codLineaBase));
        });
        $('#modalUpdateResultado').on('show.bs.modal', function (e) {
            var codIndicador= $(e.relatedTarget).attr('data-id');
            $("#divFormUpdateResultado").load(route('indicador-resultado.edit', codIndicador));
        });
        $('#modalUpdateLineaCierre').on('show.bs.modal', function (e) {
            var codLineaCierre= $(e.relatedTarget).attr('data-id');
            $("#divFormUpdateLineaCierre").load(route('linea-cierre.edit', codLineaCierre));
        });
        $('#modalCreateProductor').on('show.bs.modal', function (e) {
            $("divFormCreateProductor").load(route('productor-sda.create', codPostulante));
        });

        //4. Proceso los formularios
        $(document).on("click", '#btnCreateLineaBase', function (event) {
            event.preventDefault();
            var form = $("#FormCreateLineaBase");
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
                    $("#Footer_CreateLineaBase_Enabled").css("display", "none");
                    $("#Footer_CreateLineaBase_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateLineaBase_Enabled").css("display", "block");
                    $("#Footer_CreateLineaBase_Disabled").css("display", "none");
                    $("#modalCreateLineaBase").modal('hide');
                    $("#viewDataLineaBase").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataLineaBase").load(route('linea-base.data', codPostulante));
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
                    $("#LineaBaseAlerts").css("display", "block");
                    $("#LineaBaseAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateLineaBase_Enabled").css("display", "block");
                    $("#Footer_CreateLineaBase_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateLineaBase', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateLineaBase");
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
                    $("#Footer_UpdateLineaBase_Enabled").css("display", "none");
                    $("#Footer_UpdateLineaBase_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateLineaBase_Enabled").css("display", "block");
                    $("#Footer_UpdateLineaBase_Disabled").css("display", "none");
                    $("#modalUpdateLineaBase").modal('hide');
                    $("#viewDataLineaBase").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataLineaBase").load(route('linea-base.data', codPostulante));
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
                    $("#LineaBaseAlerts").css("display", "block");
                    $("#LineaBaseAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateLineaBase_Enabled").css("display", "block");
                    $("#Footer_UpdateLineaBase_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateResultado', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateResultado");
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
                    $("#Footer_UpdateResultado_Enabled").css("display", "none");
                    $("#Footer_UpdateResultado_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateResultado_Enabled").css("display", "block");
                    $("#Footer_UpdateResultado_Disabled").css("display", "none");
                    $("#modalUpdateResultado").modal('hide');
                    $("#viewDataResultado").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataResultado").load(route('indicador-resultado.data', codPostulante));
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
                    $("#ResultadoAlerts").css("display", "block");
                    $("#ResultadoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateResultado_Enabled").css("display", "block");
                    $("#Footer_UpdateResultado_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateLineaCierre', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateLineaCierre");
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
                    $("#Footer_UpdateLineaCierre_Enabled").css("display", "none");
                    $("#Footer_UpdateLineaCierre_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateLineaCierre_Enabled").css("display", "block");
                    $("#Footer_UpdateLineaCierre_Disabled").css("display", "none");
                    $("#modalUpdateLineaCierre").modal('hide');
                    $("#viewDataLineaCierre").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataLineaCierre").load(route('linea-cierre.data', codPostulante));
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
                    $("#LineaCierreAlerts").css("display", "block");
                    $("#LineaCierreAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateLineaCierre_Enabled").css("display", "block");
                    $("#Footer_UpdateLineaCierre_Disabled").css("display", "none");
                }
            });
        });
    });

    //#1. Función para sumar los aportes del proyecto
    function sumaImporte() {
        var add = 0;
        $('.importe').each(function() {
            if (!isNaN($(this).val())) {
                add += Number($(this).val());
            }
        });
        $('#input_importe_total').val(add);
    };  
    //#2. Función para sumar los beneficiarios del proyecto
    function sumaProductor() {
        var add = 0;
        $('.productor').each(function() {
            if (!isNaN($(this).val())) {
                add += Number($(this).val());
            }
        });
        $('#input_productor_total').val(add);
    }; 
</script>
@stop