@extends('layouts.template')
@section('title', 'Evaluación técnica del expediente PRP')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabExpediente" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabExpediente001" data-toggle="pill" href="#custom-tabs-general" role="tab" aria-controls="custom-tabs-General" aria-selected="true">1. Revisión del expediente</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabExpediente002" data-toggle="pill" href="#custom-tabs-campo" role="tab" aria-controls="custom-tabs-campo" aria-selected="false">2. Verificación de campo</a></li>
                    <!--<li class="nav-item"><a class="nav-link" id="TabExpediente003" data-toggle="pill" href="#custom-tabs-suelo" role="tab" aria-controls="custom-tabs-suelo" aria-selected="false">3. Análisis de suelo</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabExpediente004" data-toggle="pill" href="#custom-tabs-agua" role="tab" aria-controls="custom-tabs-agua" aria-selected="false">4. Análisis de agua</a></li>-->
                    <li class="nav-item"><a class="nav-link" id="TabExpediente005" data-toggle="pill" href="#custom-tabs-balance" role="tab" aria-controls="custom-tabs-balance" aria-selected="false">3. Balance hídrico</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabExpediente006" data-toggle="pill" href="#custom-tabs-final" role="tab" aria-controls="custom-tabs-final" aria-selected="false">4. Resultado final</a></li>
                </ul>
                <div class="card-body">
                    <div class="tab-content" id="TabExpedienteContent">
                        <div class="tab-pane fade show active" id="custom-tabs-general" role="tabpanel" aria-labelledby="TabExpediente001">
                            {!!Form::model($expediente,['id'=>'FormUpdateUpfp', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['upfp.update',$expediente->id]])!!}
                            {{Form::token()}}
                            {{-- Panel para mostrar alertas --}}
                            <div id="UpfpAlerts" class="alert alert-danger" style="display: none;"></div>
                            {{-- Panel para mostrar alertas --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12"><label for="">1. Información general del expediente</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('nro_expediente', 'Nº de expediente') !!} {!! Form::text('nro_expediente', $expediente->nroExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('nro_cut', 'Nº de CUT') !!} {!! Form::text('nro_cut', $expediente->nroCut, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('fecha_expediente', 'Fecha') !!} {!! Form::date('fecha_expediente', $expediente->fechaExpediente, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('fecha_recepcion', 'Fecha de recepción') !!} {!! Form::date('fecha_recepcion', $upfp->fechaRecepcion, ['class' => 'form-control', 'readonly' => 'readonly', 'max' => date('Y-m-d')]) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('ruc', 'Nº de RUC') !!} {!! Form::text('ruc', $entidad->nroDocumento, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                    <div class="col-md-9">{!! Form::label('razon_social', 'Razon social') !!} {!! Form::text('razon_social', $entidad->nombre, ['class' => 'form-control', 'readonly' => 'readonly']) !!}</div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">{!! Form::label('', '2. Etapa de evaluación técnica ') !!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('especialista_responsable', 'Especialista responsable de la evaluación') !!}
                                        <select name="especialista_responsable" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($personal as $fila)
                                            <option value="{{$fila->id}}" {{($fila->id == $upfp->cod_responsable_eva_campo)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('fecha_eval_campo', 'Fecha de evaluación de campo') !!} {!! Form::date('fecha_eval_campo', $upfp->fecha_eva_campo, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                    <div class="col-md-3">{!! Form::label('fecha_eval_suelo', 'Fecha análisis de suelo') !!} {!! Form::date('fecha_eval_suelo', $upfp->fecha_analisis_suelo, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                    <div class="col-md-3">{!! Form::label('fecha_eval_agua', 'Fecha análisis de agua') !!} {!! Form::date('fecha_eval_agua', $upfp->fecha_analisis_agua, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                    <div class="col-md-3">{!! Form::label('fecha_eval_balance_hidrico', 'Fecha balance hídrico') !!} {!! Form::date('fecha_eval_balance_hidrico', $upfp->fecha_balance_hidrico, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                </div>
                            </div>
                            {{-- Botonera  --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="Footer_UpdateUpfp_Enabled">
                                           <a href="#" id="btnUpdateUpfp" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                           <a href="{{ env('APP_URL') }}/proceso-prp/upfp" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                       </div>
                                       <div id="Footer_UpdateUpfp_Disabled" style="display:none;">
                                           <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-campo" role="tabpanel" aria-labelledby="TabExpediente002">
                            {{-- Contenido del módulo evaluacion final --}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Resultados de la evaluación de campo</h3>
                                            <div class="card-tools">
                                                <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateResultado"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataEvaluacionCampo" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo evaluacion final --}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-suelo" role="tabpanel" aria-labelledby="TabExpediente003">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Soluta illo optio facere molestiae expedita sapiente cupiditate fuga, illum qui quae accusantium error, asperiores nostrum praesentium veritatis hic enim animi ipsa.
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-agua" role="tabpanel" aria-labelledby="TabExpediente004">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cum, placeat architecto consectetur aliquid vitae assumenda delectus reiciendis atque sunt, voluptate eum. Magni aliquid earum itaque ab rerum praesentium distinctio exercitationem!
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-balance" role="tabpanel" aria-labelledby="TabExpediente005">
                            {{-- Contenido del módulo evaluacion final --}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Resultado balance hídrico</h3>
                                            <div class="card-tools">
                                                <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateResultado"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataBalanceHidrico" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo evaluacion final --}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-final" role="tabpanel" aria-labelledby="TabExpediente006">
                            {{-- Contenido del módulo evaluacion final --}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Resultado final por productor</h3>
                                            <div class="card-tools">
                                                <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateResultado"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataResultadoFinal" class="table-responsive" data-id="{{$postulante->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo evaluacion final --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal para la actualización de resultado final --}}
<div class="modal fade" id="modalUpdateResultadoFinal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateResultadoFinal">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización de la evaluacion de campo --}}
<div class="modal fade" id="modalUpdateEvaluacionCampo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateEvaluacionCampo">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
{{-- Modal para la actualización del balance hidrico --}}
<div class="modal fade" id="modalUpdateBalanceHidrico">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateBalanceHidrico">
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
        //#1. Actualizo la información
        $(document).on("click", '#btnUpdateUpfp', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateUpfp");
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
                    $("#Footer_UpdateUpfp_Enabled").css("display", "none");
                    $("#Footer_UpdateUpfp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateUpfp_Enabled").css("display", "block");
                    $("#Footer_UpdateUpfp_Disabled").css("display", "none");
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
                    $("#UpfpAlerts").css("display", "block");
                    $("#UpfpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateUpfp_Enabled").css("display", "block");
                    $("#Footer_UpdateUpfp_Disabled").css("display", "none");
                }
            });
        });
        //#2. Muestro los resultados finales de la evaluación
        var codEntidad    =   $("#viewDataResultadoFinal").attr('data-id');
        $("#viewDataResultadoFinal").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataResultadoFinal").load('../../resultado/'+ codEntidad +'/data');
        //3. Muestro el formulario para la actualizacion de resultados finales
        $('#modalUpdateResultadoFinal').on('show.bs.modal', function (e) {
            var codProductor= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateResultadoFinal').load('../../resultado/'+codProductor+'/edit');
        });
        //4. Proceso el formulario para la actualizacion de resultados finales
        $(document).on("click", '#btnUpdateResultadoFinal', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateResultadoFinal");
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
                    $("#Footer_UpdateResultadoFinal_Enabled").css("display", "none");
                    $("#Footer_UpdateResultadoFinal_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateResultadoFinal_Enabled").css("display", "block");
                    $("#Footer_UpdateResultadoFinal_Disabled").css("display", "none");
                    $("#modalUpdateResultadoFinal").modal('hide');
                    $("#viewDataResultadoFinal").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataResultadoFinal").load('../../resultado/'+ codEntidad +'/data');
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
                    $("#ResultadoFinalAlerts").css("display", "block");
                    $("#ResultadoFinalAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateResultadoFinal_Enabled").css("display", "block");
                    $("#Footer_UpdateResultadoFinal_Disabled").css("display", "none");
                }
            });
        });
        //#5. Muestro los resultados finales de la evaluación
        $("#viewDataEvaluacionCampo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataEvaluacionCampo").load('../../campo/'+ codEntidad +'/data');
        //#6. Muestro el formulario para la actualizacion de resultados finales
        $('#modalUpdateEvaluacionCampo').on('show.bs.modal', function (e) {
            var codProductorCampo= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateEvaluacionCampo').load('../../campo/'+codProductorCampo+'/edit');
        });
        //#7. Proceso el formulario para la actualizacion de resultados finales
        $(document).on("click", '#btnUpdateEvaluacionCampo', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateEvaluacionCampo");
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
                    $("#Footer_UpdateEvaluacionCampo_Enabled").css("display", "none");
                    $("#Footer_UpdateEvaluacionCampo_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateEvaluacionCampo_Enabled").css("display", "block");
                    $("#Footer_UpdateEvaluacionCampo_Disabled").css("display", "none");
                    $("#modalUpdateEvaluacionCampo").modal('hide');
                    $("#viewDataEvaluacionCampo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataEvaluacionCampo").load('../../campo/'+ codEntidad +'/data');
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
                    $("#EvaluacionCampoAlerts").css("display", "block");
                    $("#EvaluacionCampoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateEvaluacionCampo_Enabled").css("display", "block");
                    $("#Footer_UpdateEvaluacionCampo_Disabled").css("display", "none");
                }
            });
        });
        //#8. Mostramos los resultados del balance hidrico
        $("#viewDataBalanceHidrico").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataBalanceHidrico").load('../../hidrico/'+ codEntidad +'/data');
        //#9. Muestro el formulario para la actualizacion de balance hidrico
        $('#modalUpdateBalanceHidrico').on('show.bs.modal', function (e) {
            var codProductorH= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateBalanceHidrico').load('../../hidrico/'+codProductorH+'/edit');
        });
        //#10. Proceso el formulario para la actualizacion del balance hidrico
        $(document).on("click", '#btnUpdateBalanceHidrico', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateBalanceHidrico");
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
                    $("#Footer_UpdateBalanceHidrico_Enabled").css("display", "none");
                    $("#Footer_UpdateBalanceHidrico_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateBalanceHidrico_Enabled").css("display", "block");
                    $("#Footer_UpdateBalanceHidrico_Disabled").css("display", "none");
                    $("#modalUpdateBalanceHidrico").modal('hide');
                    $("#viewDataBalanceHidrico").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataBalanceHidrico").load('../../hidrico/'+ codEntidad +'/data');
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
                    $("#BalanceHidricoAlerts").css("display", "block");
                    $("#BalanceHidricoAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateBalanceHidrico_Enabled").css("display", "block");
                    $("#Footer_UpdateBalanceHidrico_Disabled").css("display", "none");
                }
            });
        });


    });
</script>
@stop