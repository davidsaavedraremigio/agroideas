@extends('layouts.template')
@section('title', 'Módulo para la actualización de información de los SDA')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabProyecto" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="TabProyecto001" data-toggle="pill" href="#custom-tabs-proyecto" role="tab" aria-controls="custom-tabs-proyecto" aria-selected="true">1. Información general</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" id="TabProyecto002" data-toggle="pill" href="#custom-tabs-ambito" role="tab" aria-controls="custom-tabs-ambito" aria-selected="false">2. Ámbito</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabProyecto003" data-toggle="pill" href="#custom-tabs-desembolso" role="tab" aria-controls="custom-tabs-desembolso" aria-selected="false">3. Desembolsos</a></li>
                </ul>
                <div class="card-body">
                    <div class="tab-content" id="TabProyectoContent">
                        <div class="tab-pane fade show active" id="custom-tabs-proyecto" role="tabpanel" aria-labelledby="TabProyecto001">
                            {!!Form::model($proyecto,['id'=>'FormUpdateProyectoSda', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['proyecto.update',$proyecto->id]])!!}
                            {{Form::token()}}
                            {{-- Panel para mostrar alertas --}}
                            <div id="ProyectoAlerts" class="alert alert-danger" style="display: none;"></div>
                            {{-- Panel para mostrar alertas --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">{!! Form::label('postulante', 'Seleccione un expediente') !!}
                                        <select name="postulante" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($postulantes as $fila)
                                                <option value="{{$fila->id}}" {{($fila->id == $proyecto->codPostulante)?'selected':''}}>{{$fila->nroExpediente}} - {{$fila->razon_social}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">{!! Form::label('duracion', 'Duración (meses)') !!} {!! Form::number('duracion', $proyecto->duracion, ['class' => 'form-control', 'min' => '1', 'max' => '72']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('fecha_inicio', 'Fecha de inicio') !!} {!! Form::date('fecha_inicio', $proyecto->fecha_inicio, ['class' => 'form-control']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">{!! Form::label('titulo', 'Titulo del incentivo') !!} {!! Form::textarea('titulo', $proyecto->tituloProyecto, ['class' => 'form-control', 'placeholder' => 'Título del Proyecto', 'rows' => '2', 'cols' => '2']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">{!! Form::label('', '3.1. Nº de beneficiarios participantes') !!}</div>
                                    <div class="col-md-6">{!! Form::label('', '3.2. Inversión programada (S/)') !!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">{!! Form::label('beneficiarios_varones', 'Nº de varones') !!} {!! Form::number('beneficiarios_varones', $proyecto->nro_beneficiarios_varones, ['class' => 'form-control beneficiario', 'min' => '0', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('beneficiarios_mujeres', 'Nº de mujeres') !!} {!! Form::number('beneficiarios_mujeres', $proyecto->nro_beneficiarios_mujeres, ['class' => 'form-control beneficiario', 'min' => '0', 'max' => '100', 'onChange' => 'sumaBeneficiarios();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('beneficiarios_total', 'Nº total') !!} {!! Form::number('beneficiarios_total', $proyecto->nro_beneficiarios, ['class' => 'form-control', 'min' => '0', 'max' => '100', 'readonly' => 'readonly', 'id' => 'input_beneficiarios_total']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('inversion_pcc', 'Inversión PCC') !!} {!! Form::text('inversion_pcc', $proyecto->inversion_pcc, ['class' => 'form-control importe', 'onChange' => 'sumaImporteTotal();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('inversion_entidad', 'Inversión entidad') !!} {!! Form::text('inversion_entidad', $proyecto->inversion_entidad, ['class' => 'form-control importe',  'onChange' => 'sumaImporteTotal();']) !!}</div>
                                    <div class="col-md-2">{!! Form::label('inversion_total', 'Inversión total') !!} {!! Form::text('inversion_total', $proyecto->inversion_total, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'input_importe_total']) !!}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">{!! Form::label('cadena', 'Cadena productiva') !!}
                                        <select name="cadena" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($cadena as $fila)
                                                <option value="{{$fila->id}}" {{($fila->id == $producto->codCadena)?'selected':''}}>{{$fila->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">{!! Form::label('tipo_produccion', 'Tipo de producción') !!}
                                        <select name="tipo_produccion" class="form-control select2">
                                            <option value="" selected="selected">Seleccionar</option>
                                            @foreach ($tipo_produccion as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $producto->tipoProduccion)?'selected':''}}>{{$fila->Nombre}}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">{!! Form::label('nro_has', 'Nº de hectareas') !!} {!! Form::text('nro_has', $proyecto->area, ['class' => 'form-control', 'placeholder' => '00.00']) !!}</div>
                                    <div class="col-md-3">{!! Form::label('nro_animales', 'Nº de animales') !!} {!! Form::text('nro_animales', '', ['class' => 'form-control', 'placeholder' => '00.00']) !!}</div>
                                </div>
                            </div>
                            {{-- Botonera  --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="Footer_UpdateProyectoSda_Enabled">
                                        <a href="#" id="btnUpdateProyectoSda" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                        <a href="{{ env('APP_URL') }}/proceso-pdn/proyecto" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                    </div>
                                    <div id="Footer_UpdateProyectoSda_Disabled" style="display:none;">
                                        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-ambito" role="tabpanel" aria-labelledby="TabProyecto002">
                            {{-- Contenido del módulo ámbito de intervención --}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Ámbito de intervención geográfica del incentivo</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateAmbitoSda"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataAmbito" class="table-responsive" data-id="{{$proyecto->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo ámbito de intervención --}}
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-desembolso" role="tabpanel" aria-labelledby="TabProyecto003">
                            {{-- Contenido del módulo ámbito de intervención --}}
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="card card-default color-palette-box">
                                        <div class="card-header">
                                            <h3 class="card-title">Esquema de desembolsos realizados al incentivo</h3>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateDesembolsoSda"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="viewDataDesembolsoSda" class="table-responsive" data-id="{{$proyecto->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            {{-- Contenido del módulo ámbito de intervención --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modals --}}
{{-- Modal para la creación y modificación de registros --}}
<div class="modal fade" id="modalCreateDesembolsoSda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateDesembolsoSda">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateDesembolsoSda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateDesembolsoSda">
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
    //1.1. Calculo el numero de beneficiarios
    function sumaBeneficiarios() {
        var add = 0;
        $('.beneficiario').each(function() {
            if (!isNaN($(this).val())) {
                add += Number($(this).val());
            }
        });
        $('#input_beneficiarios_total').val(add);
    };
    //1.2. Calculo el importe Programado
    function sumaImporteTotal() {
        var importe = 0;
        $('.importe').each(function() {
            if (!isNaN($(this).val())) {
                importe += Number($(this).val());
            }
        });
        $('#input_importe_total').val(importe);
    }
    //1.3. Validación y procesamiento de formularios
    $(document).ready(function () {
        var urlApp          = "{{ env('APP_URL') }}";
        //1. Realizo el procesamiento del formulario
        $(document).on("click", '#btnUpdateProyectoSda', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateProyectoSda");
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
                    $("#Footer_UpdateProyectoSda_Enabled").css("display", "none");
                    $("#Footer_UpdateProyectoSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var cadena      =   response;
                    var mensaje     =   cadena.mensaje;
                    var codigo      =   cadena.dato;
                    var url_edit    =   'edit';
                    $("#Footer_UpdateProyectoSda_Enabled").css("display", "block");
                    $("#Footer_UpdateProyectoSda_Disabled").css("display", "none");
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
                    $("#ProyectoSdaAlerts").css("display", "block");
                    $("#ProyectoSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateProyectoSda_Enabled").css("display", "block");
                    $("#Footer_UpdateProyectoSda_Disabled").css("display", "none");
                }
            });
        });
        //2. Cargo la info correspondiente a los desembolsos realizados
        var codProyecto    =   $("#viewDataDesembolsoSda").attr('data-id');
        $("#viewDataDesembolsoSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataDesembolsoSda").load(urlApp+'/proceso-pdn/desembolso/'+ codProyecto +'/data');
        //3. Muestro los modals correspondientes a los desembolsos realizados
        $('#modalCreateDesembolsoSda').on('show.bs.modal', function (e) {
            $('#divFormCreateDesembolsoSda').load(urlApp+'/proceso-pdn/desembolso/' + codProyecto + '/create');
        });
        $('#modalUpdateDesembolsoSda').on('show.bs.modal', function (e) {
            var codDesembolsoSda= $(e.relatedTarget).attr('data-id');
            $('#divFormUpdateDesembolsoSda').load(urlApp+'/proceso-pdn/desembolso/'+codDesembolsoSda+'/edit');
        });
        //4. Proceso los formularios de desembolsos
        $(document).on("click", '#btnCreateDesembolsoSda', function (event) {
            event.preventDefault();
            var form = $("#FormCreateDesembolsoSda");
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
                    $("#Footer_CreateDesembolsoSda_Enabled").css("display", "none");
                    $("#Footer_CreateDesembolsoSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_CreateDesembolsoSda_Enabled").css("display", "block");
                    $("#Footer_CreateDesembolsoSda_Disabled").css("display", "none");
                    $("#modalCreateDesembolsoSda").modal('hide');
                    $("#viewDataDesembolsoSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataDesembolsoSda").load(urlApp+'/proceso-pdn/desembolso/'+ codProyecto +'/data');
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
                    $("#DesembolsoSdaAlerts").css("display", "block");
                    $("#DesembolsoSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_CreateDesembolsoSda_Enabled").css("display", "block");
                    $("#Footer_CreateDesembolsoSda_Disabled").css("display", "none");
                }
            });
        });
        $(document).on("click", '#btnUpdateDesembolsoSda', function (event) {
            event.preventDefault();
            var form = $("#FormUpdateDesembolsoSda");
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
                    $("#Footer_UpdateDesembolsoSda_Enabled").css("display", "none");
                    $("#Footer_UpdateDesembolsoSda_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_UpdateDesembolsoSda_Enabled").css("display", "block");
                    $("#Footer_UpdateDesembolsoSda_Disabled").css("display", "none");
                    $("#modalUpdateDesembolsoSda").modal('hide');
                    $("#viewDataDesembolsoSda").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataDesembolsoSda").load(urlApp+'/proceso-pdn/desembolso/'+ codProyecto +'/data');
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
                    $("#DesembolsoSdaAlerts").css("display", "block");
                    $("#DesembolsoSdaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_UpdateDesembolsoSda_Enabled").css("display", "block");
                    $("#Footer_UpdateDesembolsoSda_Disabled").css("display", "none");
                }
            });
        });
    });

</script>
@stop