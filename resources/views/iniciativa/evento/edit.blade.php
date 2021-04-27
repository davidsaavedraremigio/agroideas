@extends('layouts.template')
@section('title', 'Actualizar información de eventos y compromisos')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabEvento" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabEvento001" data-toggle="pill" href="#custom-tabs-evento" role="tab" aria-controls="custom-tabs-evento" aria-selected="true">1. Datos del evento</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="TabEvento002" data-toggle="pill" href="#custom-tabs-compromisos" role="tab" aria-controls="custom-tabs-compromisos" aria-selected="false">2. Compromisos asumidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="TabEvento003" data-toggle="pill" href="#custom-tabs-ejecucion" role="tab" aria-controls="custom-tabs-ejecucion" aria-selected="false">3. Implementación de compromisos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="TabEvento004" data-toggle="pill" href="#custom-tabs-oa" role="tab" aria-controls="custom-tabs-oa" aria-selected="false">4. Organizaciones identificadas</a>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="tab-content" id="TabEventoContent">
                        <div class="tab-pane fade show active" id="custom-tabs-evento" role="tabpanel" aria-labelledby="TabEvento001">
                            {!!Form::model($evento,['id'=>'FormUpdateEvento', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['evento.update',$evento->id]])!!}
                            {{Form::token()}}
                            {{-- Panel para mostrar alertas --}}
                            <div id="EventoAlerts" class="alert alert-danger" style="display: none;"></div>
                            {{-- Panel para mostrar alertas --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">{!! Form::label('tipo_evento', 'Tipo de evento') !!}
                                        <select name="tipo_evento" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($tipoEvento as $fila)
                                                <option value="{{$fila->Orden}}" {{($fila->Orden == $evento->codTipoEvento)?'selected':''}}>{{$fila->Nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">{!! Form::label('fecha_evento', 'Fecha del evento') !!} {!! Form::date('fecha_evento', $evento->inicio, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                    <div class="col-md-8">{!! Form::label('nombre', 'Nombre del evento / espacio de diálogo') !!} {!! Form::text('nombre', $evento->nombre, ['class' => 'form-control', 'placeholder' => 'Indique el nombre del evento / espacio de diálogo.']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 col-xs-6 col-lg-2">{!! Form::label('region', 'Seleccione una región') !!}
                                        <select name="region" id="inputRegion" class="form-control">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($regiones as $fila)
                                                <option value="{{$fila->id}}" {{(trim($fila->id ) == substr($evento->ubigeo, 0, 2))?'selected':''}}>{{$fila->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-xs-6 col-lg-2">{!! Form::label('provincia', 'Seleccione una provincia') !!}
                                        <select name="provincia" id="inputProvincia" class="form-control">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($provincias as $fila)
                                                <option value="{{$fila->id}}" {{(trim($fila->id) == substr($evento->ubigeo, 0, 4))?'selected':''}}>{{$fila->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-xs-6 col-lg-2">{!! Form::label('distrito', 'Seleccione un distrito') !!}
                                        <select name="distrito" id="inputDistrito" class="form-control">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($distritos as $fila)
                                                <option value="{{$fila->id}}" {{(trim($fila->id) == $evento->ubigeo)?'selected':''}}>{{$fila->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-6 col-lg-6">{!! Form::label('lugar', 'Lugar de realización del evento / espacio de diálogo') !!} {!! Form::text('lugar', $evento->lugar, ['class' => 'form-control', 'placeholder' => 'Indique el lugar donde se realizó el evento / espacio de diálogo']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('nombre_st', 'Secretaria técnica') !!} {!! Form::text('nombre_st', $evento->nombreSecretariaTecnica, ['class' => 'form-control']) !!}</div>
                                    <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('representante_st', 'Representante secretaría técnica') !!} {!! Form::text('representante_st', $evento->representanteSecretariaTecnica, ['class' => 'form-control']) !!}</div>
                                    <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('organizador', 'Institución que lidera la comisión') !!} {!! Form::text('organizador', $evento->nombreInstitucionOrganizadora, ['class' => 'form-control']) !!}</div>
                                    <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('representante_organizador', 'Representante de la institución') !!} {!! Form::text('representante_organizador', $evento->representanteInstitucionOrganizadora, ['class' => 'form-control']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-9 col-lg-9 col-xs-6">{!! Form::label('integrantes', 'Instituciones integrantes') !!} {!! Form::text('integrantes', $evento->integrantes, ['class' => 'form-control']) !!}</div>
                                    <div class="col-md-3 col-lg-3 col-xs-6">{!! Form::label('representante_pcc', 'Representante PCC') !!}
                                        <select name="representante_pcc" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($personal as $fila)
                                            <option value="{{$fila->id}}" {{($fila->id == $evento->codRepresentantePCC)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}} - {{$fila->cargo}} {{$fila->oficina}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-lg-6">{!! Form::label('objetivo', 'Objetivo del espacio de diálogo') !!} {!! Form::textarea('objetivo', $evento->objetivo, ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => 'Cual es el objetivo de este evento / espacio de diálogo?']) !!}</div>
                                    <div class="col-md-6 col-xs-12 col-lg-6">{!! Form::label('resultadoEsperado', 'Resultados esperados') !!} {!! Form::textarea('resultadoEsperado', $evento->resultadoEsperado, ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => 'Que se espera alcanzar con la realización de este evento / espacio de diálogo?']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">{!! Form::label('evidencia', 'Acta inicial de compromisos') !!} {!! Form::file('evidencia', ['class' => 'form-control', 'placeholder' => 'Adjuntar acta', 'accept' => 'application/pdf']) !!}</div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                            {{-- Botonera  --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="Footer_UpdateEvento_Enabled">
                                           <a href="#" id="btnUpdateEvento" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                           <a href="{{ env('APP_URL') }}/iniciativa/evento" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                       </div>
                                       <div id="Footer_UpdateEvento_Disabled" style="display:none;">
                                           <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-compromisos" role="tabpanel" aria-labelledby="TabEvento002">
                            {{-- Contenido del módulo Compromisos--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Compromisos MINAGRI</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateCompromiso"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataCompromiso" class="table-responsive" data-id="{{$evento->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo Compromisos--}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-ejecucion" role="tabpanel" aria-labelledby="TabEvento003">
                            {{-- Contenido del módulo implementación de compromisos--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Seguimiento a los compromisos</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateEjecucionCompromiso"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataEjecucionCompromiso" class="table-responsive" data-id="{{$evento->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo implementación de compromisos--}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-oa" role="tabpanel" aria-labelledby="TabEvento004">
                            {{-- Contenido del módulo entidades identificadas --}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Organizaciones identificadas</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateEntidad"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataEntidad" class="table-responsive" data-id="{{$evento->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo entidades identificadas --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modals --}}
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalCreateCompromiso">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateCompromiso">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros --}}
<div class="modal fade" id="modalUpdateCompromiso">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateCompromiso">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de registros Ejecucion de compromiso --}}
<div class="modal fade" id="modalCreateEjecucionCompromiso">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateEjecucionCompromiso">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de registros Ejecucion de compromiso--}}
<div class="modal fade" id="modalUpdateEjecucionCompromiso">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateEjecucionCompromiso">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación de entidades --}}
<div class="modal fade" id="modalCreateEntidad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateEntidad">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de entidades --}}
<div class="modal fade" id="modalUpdateEntidad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateEntidad">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Fin del contenido --}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //1. Proceso el formulario
        $(document).on("click", '#btnUpdateEvento', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateEvento");
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
                    $("#Footer_UpdateEvento_Enabled").css("display", "none");
                    $("#Footer_UpdateEvento_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateEvento_Enabled").css("display", "block");
                    $("#Footer_UpdateEvento_Disabled").css("display", "none");
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
                    $("#EventoAlerts").css("display", "block");
                    $("#EventoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateEvento_Enabled").css("display", "block");
                    $("#Footer_UpdateEvento_Disabled").css("display", "none");
                }
            });
        });
        //2. Cargo la información de beneficiarios
        var codEvento    =   $("#viewDataCompromiso").attr('data-id');
        $("#viewDataCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataCompromiso").load('../../compromiso/'+ codEvento +'/data');
        //3. Muestro el formulario de registro de compromisos
        $('#modalCreateCompromiso').on('show.bs.modal', function (e) {
            $('#divFormCreateCompromiso').load('../../compromiso/' + codEvento + '/create');
        });
        //4. Muestro el formulario para la edición de compromisos
        $('#modalUpdateCompromiso').on('show.bs.modal', function (e) {
            var codCompromiso= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateCompromiso').load('../../compromiso/'+codCompromiso+'/edit');
        });
        //5. Genero la información de compromisos
        $(document).on("click", '#btnCreateCompromiso', function (event) {
            event.preventDefault();
            var form = $("#FormCreateCompromiso");
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
                    $("#Footer_CreateCompromiso_Enabled").css("display", "none");
                    $("#Footer_CreateCompromiso_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateCompromiso_Enabled").css("display", "block");
                    $("#Footer_CreateCompromiso_Disabled").css("display", "none");
                    $("#modalCreateCompromiso").modal('hide');
                    $("#viewDataCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataCompromiso").load('../../compromiso/'+ codEvento +'/data');
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
                    $("#CompromisoAlerts").css("display", "block");
                    $("#CompromisoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateCompromiso_Enabled").css("display", "block");
                    $("#Footer_CreateCompromiso_Disabled").css("display", "none");
                }
            });
        });
        //6. Actualizo la informacion de compromisos
        $(document).on("click", '#btnUpdateCompromiso', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateCompromiso");
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
                    $("#Footer_UpdateCompromiso_Enabled").css("display", "none");
                    $("#Footer_UpdateCompromiso_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateCompromiso_Enabled").css("display", "block");
                    $("#Footer_UpdateCompromiso_Disabled").css("display", "none");
                    $("#modalUpdateCompromiso").modal('hide');
                    $("#viewDataCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataCompromiso").load('../../compromiso/'+ codEvento +'/data');
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
                    $("#CompromisoAlerts").css("display", "block");
                    $("#CompromisoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateCompromiso_Enabled").css("display", "block");
                    $("#Footer_UpdateCompromiso_Disabled").css("display", "none");
                }
            });
        });
        //7. Elimino la información de compromisos
        $(document).on("click", '.btnDeleteCompromiso', function (event) {
            event.preventDefault();
            var codigo = $(this).data("id");
            var urlAction = '../../compromiso/'+codigo+'/destroy';
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
                                    $("#viewDataCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataCompromiso").load('../../compromiso/'+ codEvento +'/data');
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
                        $("#viewDataCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCompromiso").load('../../compromiso/'+ codEvento +'/data');
                    }
                );
        });        
        //8. Obtengo la información de avances en la ejecución de compromisos
        $("#viewDataEjecucionCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataEjecucionCompromiso").load('../../ejec-compromiso/'+ codEvento +'/data');
        //9. Muestro el formulario de ejecucion de compromisos
        $('#modalCreateEjecucionCompromiso').on('show.bs.modal', function (e) {
            $('#divFormCreateEjecucionCompromiso').load('../../ejec-compromiso/' + codEvento + '/create');
        });
        //10. Muestro el formulario de edición de compromisos
        $('#modalUpdateEjecucionCompromiso').on('show.bs.modal', function (e) {
            var codEjecucionCompromiso= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateEjecucionCompromiso').load('../../ejec-compromiso/'+codEjecucionCompromiso+'/edit');
        });
        //11. Muestro el formulario de registro de Ejecucion de compromisos
        $(document).on("click", '#btnCreateEjecucionCompromiso', function (event) {
            event.preventDefault();
            var form = $("#FormCreateEjecucionCompromiso");
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
                    $("#Footer_CreateEjecucionCompromiso_Enabled").css("display", "none");
                    $("#Footer_CreateEjecucionCompromiso_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateEjecucionCompromiso_Enabled").css("display", "block");
                    $("#Footer_CreateEjecucionCompromiso_Disabled").css("display", "none");
                    $("#modalCreateEjecucionCompromiso").modal('hide');
                    $("#viewDataEjecucionCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEjecucionCompromiso").load('../../ejec-compromiso/'+ codEvento +'/data');
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
                    $("#EjecucionCompromisoAlerts").css("display", "block");
                    $("#EjecucionCompromisoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateEjecucionCompromiso_Enabled").css("display", "block");
                    $("#Footer_CreateEjecucionCompromiso_Disabled").css("display", "none");
                }
            });
        });
        //12. Proceso la actualización de la información
        $(document).on("click", '#btnUpdateEjecucionCompromiso', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateEjecucionCompromiso");
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
                    $("#Footer_UpdateEjecucionCompromiso_Enabled").css("display", "none");
                    $("#Footer_UpdateEjecucionCompromiso_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateEjecucionCompromiso_Enabled").css("display", "block");
                    $("#Footer_UpdateEjecucionCompromiso_Disabled").css("display", "none");
                    $("#modalUpdateEjecucionCompromiso").modal('hide');
                    $("#viewDataEjecucionCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEjecucionCompromiso").load('../../ejec-compromiso/'+ codEvento +'/data');
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
                    $("#EjecucionCompromisoAlerts").css("display", "block");
                    $("#EjecucionCompromisoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateEjecucionCompromiso_Enabled").css("display", "block");
                    $("#Footer_UpdateEjecucionCompromiso_Disabled").css("display", "none");
                }
            });
        });
        //13. Procedo a eliminar el avance a la fecha del compromiso seleccionado
        $(document).on("click", '.btnDeleteEjecucionCompromiso', function (event) {
            event.preventDefault();
            var codigo = $(this).data("id");
            var urlAction = '../../ejec-compromiso/'+codigo+'/destroy';
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
                                    $("#viewDataEjecucionCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataEjecucionCompromiso").load('../../ejec-compromiso/'+ codEvento +'/data');
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
                    $("#viewDataEjecucionCompromiso").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEjecucionCompromiso").load('../../ejec-compromiso/'+ codEvento +'/data');
                }
            );
        }); 
        //14. Obtengo la información de entidades identificadas
        $("#viewDataEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataEntidad").load('../../evento-entidad/'+ codEvento +'/data');
        //15. Muestro el formulario para el registro de entidades
        $('#modalCreateEntidad').on('show.bs.modal', function (e) {
            $('#divFormCreateEntidad').load('../../evento-entidad/' + codEvento + '/create');
        });
        //16. Muestro el formulario para la edición de entidades
        $('#modalUpdateEntidad').on('show.bs.modal', function (e) {
            var codEntidad= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateEntidad').load('../../evento-entidad/'+codEntidad+'/edit');
        });
        //17.procedo al registro de las entidades
        $(document).on("click", '#btnCreateEntidad', function (event) {
            event.preventDefault();
            var form = $("#FormCreateEntidad");
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
                    $("#Footer_CreateEntidad_Enabled").css("display", "none");
                    $("#Footer_CreateEntidad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateEntidad_Enabled").css("display", "block");
                    $("#Footer_CreateEntidad_Disabled").css("display", "none");
                    $("#modalCreateEntidad").modal('hide');
                    $("#viewDataEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEntidad").load('../../evento-entidad/'+ codEvento +'/data');
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
                    $("#EntidadAlerts").css("display", "block");
                    $("#EntidadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateEntidad_Enabled").css("display", "block");
                    $("#Footer_CreateEntidad_Disabled").css("display", "none");
                }
            });
        });
        //18. Procedo a realizar la actualizacion de las entidades
        $(document).on("click", '#btnUpdateEntidad', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateEntidad");
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
                    $("#Footer_UpdateEntidad_Enabled").css("display", "none");
                    $("#Footer_UpdateEntidad_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateEntidad_Enabled").css("display", "block");
                    $("#Footer_UpdateEntidad_Disabled").css("display", "none");
                    $("#modalUpdateEntidad").modal('hide');
                    $("#viewDataEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEntidad").load('../../evento-entidad/'+ codEvento +'/data');
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
                    $("#EntidadAlerts").css("display", "block");
                    $("#EntidadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateEntidad_Enabled").css("display", "block");
                    $("#Footer_UpdateEntidad_Disabled").css("display", "none");
                }
            });
        });
        //19. Eliminamos a la entidad seleccionada
        $(document).on("click", '.btnDeleteEntidad', function (event) {
            event.preventDefault();
            var codigo = $(this).data("id");
            var urlAction = '../../evento-entidad/'+codigo+'/destroy';
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
                                    $("#viewDataEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                    $("#viewDataEntidad").load('../../evento-entidad/'+ codEvento +'/data');
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
                    $("#viewDataEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEntidad").load('../../evento-entidad/'+ codEvento +'/data');
                }
            );
        }); 
    });
</script>
@stop