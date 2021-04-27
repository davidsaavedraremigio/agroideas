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
                        <a class="nav-link" id="TabEvento003" data-toggle="pill" href="#custom-tabs-instituciones" role="tab" aria-controls="custom-tabs-instituciones" aria-selected="false">3. Instituciones aliadas</a>
                    </li>
                <!--
                    <li class="nav-item">
                        <a class="nav-link" id="TabEvento004" data-toggle="pill" href="#custom-tabs-participantes" role="tab" aria-controls="custom-tabs-participantes" aria-selected="false">4. Registro de participantes</a>
                    </li>
                -->
                </ul>
                <div class="card-body">
                    <div class="tab-content" id="TabEventoContent">
                        <div class="tab-pane fade show active" id="custom-tabs-evento" role="tabpanel" aria-labelledby="TabEvento001">
                            {!!Form::model($implementacion,['id'=>'FormUpdateImplementacionDifusion', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['difusion-implementacion.update',$implementacion->id]])!!}
                            {{Form::token()}}
                            {{-- Panel para mostrar alertas --}}
                            <div id="DifusionAlerts" class="alert alert-danger" style="display: none;"></div>
                            {{-- Panel para mostrar alertas --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">{!! Form::label('difusion', 'Seleccione un evento de promoción y difusión') !!}
                                        <select name="difusion" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($eventos as $fila)
                                            <option value="{{$fila->id}}" {{($fila->id == $difusion->id)?'selected':''}}>{{$fila->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('fecha', 'Fecha de implementación') !!} {!! Form::date('fecha', $implementacion->fechaRendicion, ['class' => 'form-control']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('hora_inicio', 'Hora de inicio') !!} {!! Form::text('hora_inicio', $implementacion->hora_inicio, ['class' => 'form-control', 'placeholder' => '00:00']) !!}</div> 
                                    <div class="col-md-3">{!! Form::label('hora_termino', 'Hora de término') !!} {!! Form::text('hora_termino', $implementacion->hora_termino, ['class' => 'form-control', 'placeholder' => '00:00']) !!}</div> 
                                    <div class="col-md-3">{!! Form::label('importe', 'Monto ejecutado (S/.)') !!} {!! Form::text('importe', '', ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">{!! Form::label('resultados', 'Indique los resultados del evento') !!} {!! Form::textarea('resultados', $difusion->resultados, ['class' => 'form-control', 'cols' => '2', 'rows' => '2']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">{!! Form::label('acuerdos', 'Acuerdos realizados') !!} {!! Form::textarea('acuerdos', $difusion->acuerdos, ['class' => 'form-control', 'cols' => '2', 'rows' => '2']) !!}</div>
                                    <div class="col-md-6">{!! Form::label('comentarios', 'Comentarios u observaciones') !!} {!! Form::textarea('comentarios', $difusion->comentarios, ['class' => 'form-control', 'cols' => '2', 'rows' => '2']) !!}</div>
                                </div>
                            </div>
                            {{-- Botonera  --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="Footer_UpdateImplementacionDifusion_Enabled">
                                           <a href="#" id="btnUpdateImplementacionDifusion" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                           <a href="{{ env('APP_URL') }}/iniciativa/difusion-implementacion" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                       </div>
                                       <div id="Footer_UpdateImplementacionDifusion_Disabled" style="display:none;">
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
                                            <h3 class="card-title">Gastos realizados en el evento de promoción y difusión</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateRendicionDifusion"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataRendicionDifusion" class="table-responsive" data-id="{{$implementacion->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo Ejecución de gastos --}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-instituciones" role="tabpanel" aria-labelledby="TabEvento004">
                            {{-- Contenido del módulo Compromisos--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Relación de instituciones participantes</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateEntidadParticipante"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataInstitucionesDifusion" class="table-responsive" data-id="{{$implementacion->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo Compromisos--}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-participantes" role="tabpanel" aria-labelledby="TabEvento004">
                            {{-- Contenido del módulo Compromisos--}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Relación de asistentes al evento de promoción y difusión</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateParticipanteDifusion"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataParticipanteDifusion" class="table-responsive" data-id="{{$implementacion->id}}"></div>
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
</div>
{{-- Modals --}}
{{-- Modal para la creación y modificación de registros --}}
<div class="modal fade" id="modalCreateRendicionDifusion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateRendicionDifusion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateRendicionDifusion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateRendicionDifusion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalCreateEntidadParticipante">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateEntidadParticipante">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateEntidadParticipante">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateEntidadParticipante">
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
        var urlApp  = "{{ env('APP_URL') }}";
        //1. Proceso el formulario
        $(document).on("click", '#btnUpdateImplementacionDifusion', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateImplementacionDifusion");
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
                    $("#Footer_UpdateImplementacionDifusion_Enabled").css("display", "none");
                    $("#Footer_UpdateImplementacionDifusion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateImplementacionDifusion_Enabled").css("display", "block");
                    $("#Footer_UpdateImplementacionDifusion_Disabled").css("display", "none");
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
                    $("#ImplementacionDifusionAlerts").css("display", "block");
                    $("#ImplementacionDifusionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateImplementacionDifusion_Enabled").css("display", "block");
                    $("#Footer_UpdateImplementacionDifusion_Disabled").css("display", "none");
                }
            });
        });
        //2. Cargo la información de rendiciones de gastos
        var codRendicion    =   $("#viewDataRendicionDifusion").attr('data-id');
        $("#viewDataRendicionDifusion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataRendicionDifusion").load(urlApp+'/iniciativa/difusion-ejecucion/'+ codRendicion +'/data');
        //3. Muestro los modals correspondientes a la rendicion de gastos
        $('#modalCreateRendicionDifusion').on('show.bs.modal', function (e) {
            $('#divFormCreateRendicionDifusion').load(urlApp+'/iniciativa/difusion-ejecucion/' + codRendicion + '/create');
        });
        $('#modalUpdateRendicionDifusion').on('show.bs.modal', function (e) {
            var codRendicionDifusion= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateRendicionDifusion').load(urlApp+'/iniciativa/difusion-ejecucion/'+codRendicionDifusion+'/edit');
        });
        //4. Proceso los formularios de rendición de gastos
        $(document).on("click", '#btnCreateRendicionDifusion', function (event) {
            event.preventDefault();
            var form = $("#FormCreateRendicionDifusion");
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
                    $("#Footer_CreateRendicionDifusion_Enabled").css("display", "none");
                    $("#Footer_CreateRendicionDifusion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateRendicionDifusion_Enabled").css("display", "block");
                    $("#Footer_CreateRendicionDifusion_Disabled").css("display", "none");
                    $("#modalCreateRendicionDifusion").modal('hide');
                    $("#viewDataRendicionDifusion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataRendicionDifusion").load(urlApp+'/iniciativa/difusion-ejecucion/'+ codRendicion +'/data');
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
                    $("#RendicionDifusionAlerts").css("display", "block");
                    $("#RendicionDifusionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateRendicionDifusion_Enabled").css("display", "block");
                    $("#Footer_CreateRendicionDifusion_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateRendicionDifusion', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateRendicionDifusion");
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
                    $("#Footer_UpdateRendicionDifusion_Enabled").css("display", "none");
                    $("#Footer_UpdateRendicionDifusion_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateRendicionDifusion_Enabled").css("display", "block");
                    $("#Footer_UpdateRendicionDifusion_Disabled").css("display", "none");
                    $("#modalUpdateRendicionDifusion").modal('hide');
                    $("#viewDataRendicionDifusion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataRendicionDifusion").load(urlApp+'/iniciativa/difusion-ejecucion/'+ codRendicion +'/data');
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
                    $("#RendicionDifusionAlerts").css("display", "block");
                    $("#RendicionDifusionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateRendicionDifusion_Enabled").css("display", "block");
                    $("#Footer_UpdateRendicionDifusion_Disabled").css("display", "none");
                }
            });
        });
        //5. Cargo la información de Entidades Participantes
        $("#viewDataInstitucionesDifusion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataInstitucionesDifusion").load(urlApp+'/iniciativa/difusion-entidad-participante/'+ codRendicion +'/data');
        //6. Muestro los modals correspondientes a las Entidades Participantes
        $('#modalCreateEntidadParticipante').on('show.bs.modal', function (e) {
            $('#divFormCreateEntidadParticipante').load(urlApp+'/iniciativa/difusion-entidad-participante/' + codRendicion + '/create');
        });
        $('#modalUpdateEntidadParticipante').on('show.bs.modal', function (e) {
            var codEntidadParticipante= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateEntidadParticipante').load(urlApp+'/iniciativa/difusion-entidad-participante/'+codEntidadParticipante+'/edit');
        });
        //7. Proceso los formularios de Entidades participantes
        $(document).on("click", '#btnCreateEntidadParticipante', function (event) {
            event.preventDefault();
            var form = $("#FormCreateEntidadParticipante");
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
                    $("#Footer_CreateEntidadParticipante_Enabled").css("display", "none");
                    $("#Footer_CreateEntidadParticipante_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateEntidadParticipante_Enabled").css("display", "block");
                    $("#Footer_CreateEntidadParticipante_Disabled").css("display", "none");
                    $("#modalCreateEntidadParticipante").modal('hide');
                    $("#viewDataInstitucionesDifusion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataInstitucionesDifusion").load(urlApp+'/iniciativa/difusion-entidad-participante/'+ codRendicion +'/data');
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
                    $("#EntidadParticipanteAlerts").css("display", "block");
                    $("#EntidadParticipantesAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateEntidadParticipante_Enabled").css("display", "block");
                    $("#Footer_CreateEntidadParticipante_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateEntidadParticipante', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateEntidadParticipante");
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
                    $("#Footer_UpdateEntidadParticipante_Enabled").css("display", "none");
                    $("#Footer_UpdateEntidadParticipante_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateEntidadParticipante_Enabled").css("display", "block");
                    $("#Footer_UpdateEntidadParticipante_Disabled").css("display", "none");
                    $("#modalUpdateEntidadParticipante").modal('hide');
                    $("#viewDataInstitucionesDifusion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataInstitucionesDifusion").load(urlApp+'/iniciativa/difusion-entidad-participante/'+ codRendicion +'/data');
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
                    $("#EntidadParticipanteAlerts").css("display", "block");
                    $("#EntidadParticipantesAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateEntidadParticipante_Enabled").css("display", "block");
                    $("#Footer_UpdateEntidadParticipante_Disabled").css("display", "none");
                }
            });
        });


        

    });
</script>
@stop