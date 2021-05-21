@extends('layouts.template')
@section('title', 'Actualizar información de implementación de eventos')
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
                        <a class="nav-link" id="TabEvento002" data-toggle="pill" href="#custom-tabs-ejecucion" role="tab" aria-controls="custom-tabs-ejecucion" aria-selected="false">2. Rendición de gastos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="TabEvento003" data-toggle="pill" href="#custom-tabs-extensionista" role="tab" aria-controls="custom-tabs-extensionista" aria-selected="false">3. Extensionistas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="TabEvento004" data-toggle="pill" href="#custom-tabs-participantes" role="tab" aria-controls="custom-tabs-participantes" aria-selected="false">4. Registro de participantes</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabEventoContent">
                    <div class="tab-pane fade show active" id="custom-tabs-evento" role="tabpanel" aria-labelledby="TabEvento001">
                        {!!Form::model($implementacion,['id'=>'FormUpdateImplementacionCapacitacion', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['capacitacion-implementacion.update',$implementacion->id]])!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="CapacitacionAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">{!! Form::label('nombre', 'Nombre del evento de capacitación') !!} {!! Form::textarea('nombre', $capacitacion->nombre, ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'readonly' => 'readonly']) !!}</div>
                                <div class="col-md-6">{!! Form::label('objetivos', 'Objetivos del evento') !!} {!! Form::textarea('objetivos', $capacitacion->objetivo, ['class' => 'form-control', 'rows' => '2', 'cols' => '2', 'readonly' => 'readonly']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">{!! Form::label('tipo_evento', 'Tipo de evento') !!}
                                    <select name="tipo_evento" class="form-control" disabled="disabled">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipoEvento as $fila)
                                        <option value="{{$fila->Orden}}" {{($fila->Orden == $capacitacion->codTipo)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('tematica', 'Temática del evento') !!}
                                    <select name="tematica" class="form-control" disabled="disabled">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tematica as $fila)
                                        <option value="{{$fila->Orden}}" {{($fila->Orden == $capacitacion->codTematica)?'selected':''}}>{{$fila->Nombre}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('organizacion', 'Organización del evento') !!}
                                    <select name="organizacion" class="form-control" disabled="disabled">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($organizacion as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $capacitacion->codOrganizacion)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">{!! Form::label('fecha', 'Fecha de implementación') !!} {!! Form::date('fecha', $implementacion->fechaRendicion, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-2">{!! Form::label('hora_inicio', 'Hora de inicio') !!} {!! Form::text('hora_inicio', $implementacion->hora_inicio, ['class' => 'form-control', 'placeholder' => '00:00']) !!}</div> 
                                <div class="col-md-2">{!! Form::label('hora_termino', 'Hora de término') !!} {!! Form::text('hora_termino', $implementacion->hora_termino, ['class' => 'form-control', 'placeholder' => '00:00']) !!}</div> 
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('resultados', 'Resultados obtenidos:') !!} {!! Form::textarea('resultados', $capacitacion->resultados, ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => 'Describa que resultados se alcanzaron con la realización del evento.']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">{!! Form::label('acuerdos', 'Acuerdos realizados:') !!} {!! Form::textarea('acuerdos', $capacitacion->acuerdos, ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => '(Si es que aplica) Describa los acuerdos que han surgido en el evento.']) !!}</div>
                                <div class="col-md-6">{!! Form::label('comentarios', 'Comentarios u observaciones:') !!} {!! Form::textarea('comentarios', $capacitacion->comentarios, ['class' => 'form-control', 'cols' => '2', 'rows' => '2', 'placeholder' => '(Si es que aplica) Indique que comentarios, observaciones y/o sugerencias puede dar del evento realizado.']) !!}</div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_UpdateImplementacionCapacitacion_Enabled">
                                       <a href="#" id="btnUpdateImplementacionCapacitacion" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{route("capacitacion.index")}}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_UpdateImplementacionCapacitacion_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-ejecucion" role="tabpanel" aria-labelledby="TabEvento002">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Gastos realizados en el evento de capacitación</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateRendicionCapacitacion"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataRendicionCapacitacion" class="table-responsive" data-id="{{$implementacion->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-extensionista" role="tabpanel" aria-labelledby="TabEvento003">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Datos de los extensionistas rurales</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateExtensionistaCapacitacion"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataExtensionistaCapacitacion" class="table-responsive" data-id="{{$implementacion->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-participantes" role="tabpanel" aria-labelledby="TabEvento004">
                        {{-- Contenido del módulo Compromisos--}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Relación de asistentes al evento de capacitación</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateParticipanteCapacitacion"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataParticipanteCapacitacion" class="table-responsive" data-id="{{$implementacion->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Compromisos--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modals --}}
{{-- Modal para la creación y modificación de registros --}}
<div class="modal fade" id="modalCreateRendicionCapacitacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateRendicionCapacitacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateRendicionCapacitacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateRendicionCapacitacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación y modificación de registros --}}
<div class="modal fade" id="modalCreateParticipanteCapacitacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateParticipanteCapacitacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateParticipanteCapacitacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateParticipanteCapacitacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la creación y modificación de extensionistas --}}
<div class="modal fade" id="modalCreateExtensionistaCapacitacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateExtensionistaCapacitacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateExtensionistaCapacitacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateExtensionistaCapacitacion">
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
        $(document).on("click", '#btnUpdateImplementacionCapacitacion', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateImplementacionCapacitacion");
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
                    $("#Footer_UpdateImplementacionCapacitacion_Enabled").css("display", "none");
                    $("#Footer_UpdateImplementacionCapacitacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   route("capacitacion-implementacion.edit", codigo);
                    $("#Footer_UpdateImplementacionCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateImplementacionCapacitacion_Disabled").css("display", "none");
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
                    $("#ImplementacionCapacitacionAlerts").css("display", "block");
                    $("#ImplementacionCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateImplementacionCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateImplementacionCapacitacion_Disabled").css("display", "none");
                }
            });
        });
        //2. Cargo la información de rendiciones de gastos
        var codRendicion    =   $("#viewDataRendicionCapacitacion").attr('data-id');
        $("#viewDataRendicionCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataRendicionCapacitacion").load(route("capacitacion-ejecucion.data", codRendicion));
        //3. Muestro los modals correspondientes a la rendicion de gastos
        $('#modalCreateRendicionCapacitacion').on('show.bs.modal', function (e) {
            $('#divFormCreateRendicionCapacitacion').load(route("capacitacion-ejecucion.create", codRendicion));
        });
        $('#modalUpdateRendicionCapacitacion').on('show.bs.modal', function (e) {
            var codRendicionCapacitacion= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateRendicionCapacitacion').load(route("capacitacion-implementacion.edit", codRendicionCapacitacion));
        });
        //4. Proceso los formularios de rendición de gastos
        $(document).on("click", '#btnCreateRendicionCapacitacion', function (event) {
            event.preventDefault();
            var form = $("#FormCreateRendicionCapacitacion");
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
                    $("#Footer_CreateRendicionCapacitacion_Enabled").css("display", "none");
                    $("#Footer_CreateRendicionCapacitacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateRendicionCapacitacion_Enabled").css("display", "block");
                    $("#Footer_CreateRendicionCapacitacion_Disabled").css("display", "none");
                    $("#modalCreateRendicionCapacitacion").modal('hide');
                    $("#viewDataRendicionCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataRendicionCapacitacion").load(route("capacitacion-ejecucion.data", codRendicion));
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
                    $("#RendicionCapacitacionAlerts").css("display", "block");
                    $("#RendicionCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateRendicionCapacitacion_Enabled").css("display", "block");
                    $("#Footer_CreateRendicionCapacitacion_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateRendicionCapacitacion', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateRendicionCapacitacion");
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
                    $("#Footer_UpdateRendicionCapacitacion_Enabled").css("display", "none");
                    $("#Footer_UpdateRendicionCapacitacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateRendicionCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateRendicionCapacitacion_Disabled").css("display", "none");
                    $("#modalUpdateRendicionCapacitacion").modal('hide');
                    $("#viewDataRendicionCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataRendicionCapacitacion").load(route("capacitacion-ejecucion.data", codRendicion));
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
                    $("#RendicionCapacitacionAlerts").css("display", "block");
                    $("#RendicionCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateRendicionCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateRendicionCapacitacion_Disabled").css("display", "none");
                }
            });
        });
        //5. Cargo la información de participantes al evento de capacitacion
        $("#viewDataParticipanteCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataParticipanteCapacitacion").load(route("capacitacion-participante.data", codRendicion));
        //6. Muestro los modals correspondientes al registro de participantes
        $('#modalCreateParticipanteCapacitacion').on('show.bs.modal', function (e) {
            $('#divFormCreateParticipanteCapacitacion').load(route("capacitacion-participante.create", codRendicion));
        });
        $('#modalUpdateParticipanteCapacitacion').on('show.bs.modal', function (e) {
            var codParticipante= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateParticipanteCapacitacion').load(route("capacitacion-participante.edit", codParticipante));
        });
        //7. Proceso los formularios de participantes
        $(document).on("click", '#btnCreateParticipanteCapacitacion', function (event) {
            event.preventDefault();
            var form = $("#FormCreateParticipanteCapacitacion");
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
                    $("#Footer_CreateParticipanteCapacitacion_Enabled").css("display", "none");
                    $("#Footer_CreateParticipanteCapacitacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateParticipanteCapacitacion_Enabled").css("display", "block");
                    $("#Footer_CreateParticipanteCapacitacion_Disabled").css("display", "none");
                    $("#modalCreateParticipanteCapacitacion").modal('hide');
                    $("#viewDataParticipanteCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataParticipanteCapacitacion").load(route("capacitacion-participante.data", codRendicion));
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
                    $("#ParticipanteCapacitacionAlerts").css("display", "block");
                    $("#ParticipanteCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateParticipanteCapacitacion_Enabled").css("display", "block");
                    $("#Footer_CreateParticipanteCapacitacion_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateParticipanteCapacitacion', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateParticipanteCapacitacion");
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
                    $("#Footer_UpdateParticipanteCapacitacion_Enabled").css("display", "none");
                    $("#Footer_UpdateParticipanteCapacitacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateParticipanteCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateParticipanteCapacitacion_Disabled").css("display", "none");
                    $("#modalUpdateParticipanteCapacitacion").modal('hide');
                    $("#viewDataParticipanteCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataParticipanteCapacitacion").load(route("capacitacion-participante.data", codRendicion));
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
                    $("#ParticipanteCapacitacionAlerts").css("display", "block");
                    $("#ParticipanteCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateParticipanteCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateParticipanteCapacitacion_Disabled").css("display", "none");
                }
            });
        }); 
        $(document).on("click", '.btnDeleteParticipanteCapacitacion', function (event) {
            event.preventDefault();
            var codigo = $(this).data("id");
            var urlAction = route("capacitacion-participante.destroy", codigo);
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
                                $("#viewDataParticipanteCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                $("#viewDataParticipanteCapacitacion").load(route("capacitacion-participante.data", codRendicion));
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
                    $("#viewDataParticipanteCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataParticipanteCapacitacion").load(route("capacitacion-participante.data", codRendicion));
                }
            );
        });
        //8. Cargo la información de extensionistas del evento de capacitacion
        $("#viewDataExtensionistaCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExtensionistaCapacitacion").load(route("capacitacion-extensionista.data", codRendicion));
        //9. Muestro los modals correspondientes al registro de extensionistas
        $('#modalCreateExtensionistaCapacitacion').on('show.bs.modal', function (e) {
            $('#divFormCreateExtensionistaCapacitacion').load(route("capacitacion-extensionista.create", codRendicion));
        });
        $('#modalUpdateExtensionistaCapacitacion').on('show.bs.modal', function (e) {
            var codExtensionista= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateExtensionistaCapacitacion').load(route("capacitacion-extensionista.edit", codExtensionista));
        });
        //10. Proceso los formularios de Extensionista
        $(document).on("click", '#btnCreateExtensionistaCapacitacion', function (event) {
            event.preventDefault();
            var form = $("#FormCreateExtensionistaCapacitacion");
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
                    $("#Footer_CreateExtensionistaCapacitacion_Enabled").css("display", "none");
                    $("#Footer_CreateExtensionistaCapacitacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateExtensionistaCapacitacion_Enabled").css("display", "block");
                    $("#Footer_CreateExtensionistaCapacitacion_Disabled").css("display", "none");
                    $("#modalCreateExtensionistaCapacitacion").modal('hide');
                    $("#viewDataExtensionistaCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExtensionistaCapacitacion").load(route("capacitacion-extensionista.data", codRendicion));
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
                    $("#ExtensionistaCapacitacionAlerts").css("display", "block");
                    $("#ExtensionistaCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateExtensionistaCapacitacion_Enabled").css("display", "block");
                    $("#Footer_CreateExtensionistaCapacitacion_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateExtensionistaCapacitacion', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateExtensionistaCapacitacion");
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
                    $("#Footer_UpdateExtensionistaCapacitacion_Enabled").css("display", "none");
                    $("#Footer_UpdateExtensionistaCapacitacion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateExtensionistaCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateExtensionistaCapacitacion_Disabled").css("display", "none");
                    $("#modalUpdateExtensionistaCapacitacion").modal('hide');
                    $("#viewDataExtensionistaCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExtensionistaCapacitacion").load(route("capacitacion-extensionista.data", codRendicion));
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
                    $("#ExtensionistaCapacitacionAlerts").css("display", "block");
                    $("#ExtensionistaCapacitacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateExtensionistaCapacitacion_Enabled").css("display", "block");
                    $("#Footer_UpdateExtensionistaCapacitacion_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '.btnDeleteExtensionistaCapacitacion', function (event) {
            event.preventDefault();
            var codigo = $(this).data("id");
            var urlAction = route("capacitacion-implementacion.destroy", codigo);
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
                                $("#viewDataExtensionistaCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                                $("#viewDataExtensionistaCapacitacion").load(route("capacitacion-extensionista.data", codRendicion));
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
                    $("#viewDataExtensionistaCapacitacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataExtensionistaCapacitacion").load(route("capacitacion-extensionista.data", codRendicion));
                }
            );
        });
    });
</script>
@stop