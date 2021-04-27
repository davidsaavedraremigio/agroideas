@extends('layouts.template')
@section('title', 'Gestión de información de convenio')
@section('content')
{{-- Inicio del contenido--}}
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="TabConvenio" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="TabConvenio001" data-toggle="pill" href="#custom-tabs-convenio" role="tab" aria-controls="custom-tabs-convenio" aria-selected="true">1. Datos del convenio</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabConvenio002" data-toggle="pill" href="#custom-tabs-cooperante" role="tab" aria-controls="custom-tabs-cooperante" aria-selected="false">2. Entidad cooperante</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabConvenio003" data-toggle="pill" href="#custom-tabs-pcc" role="tab" aria-controls="custom-tabs-pcc" aria-selected="false">3. Coordinadores PCC</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabConvenio004" data-toggle="pill" href="#custom-tabs-coordinadores" role="tab" aria-controls="custom-tabs-coordinadores" aria-selected="false">4. Coordinadores contraparte</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabConvenio005" data-toggle="pill" href="#custom-tabs-compromisos" role="tab" aria-controls="custom-tabs-compromisos" aria-selected="false">5. Compromisos</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabConvenio006" data-toggle="pill" href="#custom-tabs-implementacion" role="tab" aria-controls="custom-tabs-implementacion" aria-selected="false">6. Implementacion</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabConvenio007" data-toggle="pill" href="#custom-tabs-postulante" role="tab" aria-controls="custom-tabs-postulante" aria-selected="false">7. OA's atendidas</a></li>
                    <li class="nav-item"><a class="nav-link" id="TabConvenio008" data-toggle="pill" href="#custom-tabs-ampliacion" role="tab" aria-controls="custom-tabs-ampliacion" aria-selected="false">8. Adendas</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="TabConvenioContent">
                    <div class="tab-pane fade show active" id="custom-tabs-convenio" role="tabpanel" aria-labelledby="TabConvenio001">
                        {!!Form::model($convenio,['id'=>'FormUpdateConvenio', 'method'=>'POST', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['convenio-marco.update',$convenio->id]])!!}
                        {{Form::token()}}
                        {{-- Panel para mostrar alertas --}}
						<div id="ConvenioAlerts" class="alert alert-danger" style="display: none;"></div>
                        {{-- Panel para mostrar alertas --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('nro_cut', 'Nº de CUT') !!} {!! Form::number('nro_cut', $convenio->nro_cut, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                <div class="col-md-3">{!! Form::label('fecha_cut', 'Fecha') !!} {!! Form::date('fecha_cut', $convenio->fecha_cut, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                <div class="col-md-3">{!! Form::label('tipo', 'Tipo de convenio') !!}
                                    <select name="tipo" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($tipo as $fila)
                                            <option value="{{$fila->Orden}}" {{($fila->Orden == $convenio->tipo_convenio)?'selected':''}}>{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('duracion', 'Duración (meses)') !!} {!! Form::number('duracion', $convenio->duracion, ['class' => 'form-control', 'min' => '1', 'max' => '72', 'maxlength' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('nro_convenio', 'Nº de convenio') !!} {!! Form::number('nro_convenio', $convenio->numero, ['class' => 'form-control', 'min' => '1', 'max' => '9999']) !!}</div>
                                <div class="col-md-3">{!! Form::label('fecha_firma', 'Fecha de firma') !!} {!! Form::date('fecha_firma', $convenio->fecha_firma, ['class' => 'form-control', 'max' => date('Y-m-d')]) !!}</div>
                                <div class="col-md-3">{!! Form::label('nro_ley', 'Ley de presupuesto (Si aplica)') !!} {!! Form::text('nro_ley', $convenio->nro_ley, ['class' => 'form-control']) !!}</div>
                                <div class="col-md-3">{!! Form::label('importe', 'Importe (S/.) (Si aplica)') !!} {!! Form::text('importe', $convenio->importe, ['class' => 'form-control', 'placeholder' => '0.00']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">{!! Form::label('objetivo', 'Objetivo del convenio marco') !!} {!! Form::textarea('objetivo', $convenio->objetivo, ['class'=> 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">{!! Form::label('representante_pcc', 'Representante del PCC') !!}
                                    <select name="representante_pcc" class="form-control select2">
                                        <option value="" selected="selected">Seleccionar</option>
                                        @foreach ($personal as $fila)
                                            <option value="{{$fila->id}}" {{($fila->id == $convenio->cod_representante_pcc)?'selected':''}}>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}} - {{$fila->cargo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-9"><br></div>
                            </div>
                        </div>
                        {{-- Botonera  --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="Footer_UpdateConvenio_Enabled">
                                       <a href="#" id="btnUpdateConvenio" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Guardar cambios</a>
                                       <a href="{{ env('APP_URL') }}/de/convenio" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i> Cerrar formulario</a>
                                   </div>
                                   <div id="Footer_UpdateConvenio_Disabled" style="display:none;">
                                       <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-cooperante" role="tabpanel" aria-labelledby="TabConvenio002">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Entidad cooperante</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateEntidadCooperante"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataEntidadCooperante" class="table-responsive" data-id="{{$convenio->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-pcc" role="tabpanel" aria-labelledby="TabConvenio003">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Coordinadores representantes del PCC</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateCoordinadorPcc"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataCoordinadorPcc" class="table-responsive" data-id="{{$convenio->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-coordinadores" role="tabpanel" aria-labelledby="TabConvenio004">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Coordinadores representantes de la Entidad cooperante</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateCoordinadorEntidad"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataCoordinadorEntidad" class="table-responsive" data-id="{{$convenio->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-compromisos" role="tabpanel" aria-labelledby="TabConvenio005">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Compromisos asumidos</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateCompromisoConvenio"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataCompromisoConvenio" class="table-responsive" data-id="{{$convenio->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-implementacion" role="tabpanel" aria-labelledby="TabConvenio006">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Implementación de compromisos</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateCompromisoImplementacion"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataCompromisoImplementacion" class="table-responsive" data-id="{{$convenio->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-postulante" role="tabpanel" aria-labelledby="TabConvenio007">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">OA's identificadas</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateEntidadIdentificada"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataEntidadIdentificada" class="table-responsive" data-id="{{$convenio->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-ampliacion" role="tabpanel" aria-labelledby="TabConvenio008">
                        {{-- Contenido del módulo Ejecución de gastos --}}
                        <section class="content">
                            <div class="container-fluid">
                                <div class="card card-default color-palette-box">
                                    <div class="card-header">
                                        <h3 class="card-title">Adendas emitidas</h3>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateConvenioAmpliacion"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="viewDataConvenioAmpliacion" class="table-responsive" data-id="{{$convenio->id}}"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- Contenido del módulo Ejecución de gastos --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal para la creación y modificación de registros --}}
<div class="modal fade" id="modalCreateEntidadCooperante">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateEntidadCooperante">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateEntidadCooperante">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateEntidadCooperante">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

<div class="modal fade" id="modalCreateCoordinadorPcc">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateCoordinadorPcc">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateCoordinadorPcc">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateCoordinadorPcc">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

<div class="modal fade" id="modalCreateCoordinadorEntidad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateCoordinadorEntidad">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateCoordinadorEntidad">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateCoordinadorEntidad">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

<div class="modal fade" id="modalCreateCompromisoConvenio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateCompromisoConvenio">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateCompromisoConvenio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateCompromisoConvenio">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

<div class="modal fade" id="modalCreateCompromisoImplementacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateCompromisoImplementacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateCompromisoImplementacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateCompromisoImplementacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

<div class="modal fade" id="modalCreateEntidadIdentificada">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateEntidadIdentificada">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateEntidadIdentificada">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateEntidadIdentificada">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>

<div class="modal fade" id="modalCreateConvenioAmpliacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormCreateConvenioAmpliacion">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div>
<div class="modal fade" id="modalUpdateConvenioAmpliacion">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormUpdateConvenioAmpliacion">
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
            //#1. Proceso el formulario de edición de registros
            $(document).on("click", '#btnUpdateConvenio', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateConvenio");
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
                        $("#Footer_UpdateConvenio_Enabled").css("display", "none");
                        $("#Footer_UpdateConvenio_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var cadena      =   response;
                        var mensaje     =   cadena.mensaje;
                        var codigo      =   cadena.dato;
                        var url_edit    =   'edit';
                        $("#Footer_UpdateConvenio_Enabled").css("display", "block");
                        $("#Footer_UpdateConvenio_Disabled").css("display", "none");
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
                        $("#ConvenioAlerts").css("display", "block");
                        $("#ConvenioAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateConvenio_Enabled").css("display", "block");
                        $("#Footer_UpdateConvenio_Disabled").css("display", "none");
                    }
                });
            });
            //2. Cargo la información de Entidades cooperantes
            var codConvenio    =   $("#viewDataEntidadCooperante").attr('data-id');
            $("#viewDataEntidadCooperante").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataEntidadCooperante").load(urlApp+'/de/convenio-cooperante/'+ codConvenio +'/data');
            //3. Muestro los modals correspondientes a la entidad cooperante
            $('#modalCreateEntidadCooperante').on('show.bs.modal', function (e) {
                $('#divFormCreateEntidadCooperante').load(urlApp+'/de/convenio-cooperante/' + codConvenio + '/create');
            });
            $('#modalUpdateEntidadCooperante').on('show.bs.modal', function (e) {
                var codEntidadCooperante= $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateEntidadCooperante').load(urlApp+'/de/convenio-cooperante/'+codEntidadCooperante+'/edit');
            });
            //4. Proceso los formularios de la entidad cooperante
            $(document).on("click", '#btnCreateEntidadCooperante', function (event) {
                event.preventDefault();
                var form = $("#FormCreateEntidadCooperante");
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
                        $("#Footer_CreateEntidadCooperante_Enabled").css("display", "none");
                        $("#Footer_CreateEntidadCooperante_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateEntidadCooperante_Enabled").css("display", "block");
                        $("#Footer_CreateEntidadCooperante_Disabled").css("display", "none");
                        $("#modalCreateEntidadCooperante").modal('hide');
                        $("#viewDataEntidadCooperante").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataEntidadCooperante").load(urlApp+'/de/convenio-cooperante/'+ codConvenio +'/data');
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
                        $("#EntidadCooperanteAlerts").css("display", "block");
                        $("#EntidadCooperanteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateEntidadCooperante_Enabled").css("display", "block");
                        $("#Footer_CreateEntidadCooperante_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateEntidadCooperante', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateEntidadCooperante");
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
                        $("#Footer_UpdateEntidadCooperante_Enabled").css("display", "none");
                        $("#Footer_UpdateEntidadCooperante_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateEntidadCooperante_Enabled").css("display", "block");
                        $("#Footer_UpdateEntidadCooperante_Disabled").css("display", "none");
                        $("#modalUpdateEntidadCooperante").modal('hide');
                        $("#viewDataEntidadCooperante").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataEntidadCooperante").load(urlApp+'/de/convenio-cooperante/'+ codConvenio +'/data');
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
                        $("#EntidadCooperanteAlerts").css("display", "block");
                        $("#EntidadCooperanteAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateEntidadCooperante_Enabled").css("display", "block");
                        $("#Footer_UpdateEntidadCooperante_Disabled").css("display", "none");
                    }
                });
            });
            //5. Coordinadores PCC
            $("#viewDataCoordinadorPcc").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataCoordinadorPcc").load(urlApp+'/de/convenio-coordinador-pcc/'+ codConvenio +'/data');
            $('#modalCreateCoordinadorPcc').on('show.bs.modal', function (e) {
                $('#divFormCreateCoordinadorPcc').load(urlApp+'/de/convenio-coordinador-pcc/' + codConvenio + '/create');
            });
            $('#modalUpdateCoordinadorPcc').on('show.bs.modal', function (e) {
                var codCoordinador= $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateCoordinadorPcc').load(urlApp+'/de/convenio-coordinador-pcc/'+codCoordinador+'/edit');
            });
            $(document).on("click", '#btnCreateCoordinadorPcc', function (event) {
                event.preventDefault();
                var form = $("#FormCreateCoordinadorPcc");
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
                        $("#Footer_CreateCoordinadorPcc_Enabled").css("display", "none");
                        $("#Footer_CreateCoordinadorPcc_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateCoordinadorPcc_Enabled").css("display", "block");
                        $("#Footer_CreateCoordinadorPcc_Disabled").css("display", "none");
                        $("#modalCreateCoordinadorPcc").modal('hide');
                        $("#viewDataCoordinadorPcc").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCoordinadorPcc").load(urlApp+'/de/convenio-coordinador-pcc/'+ codConvenio +'/data');
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
                        $("#CoordinadorPccAlerts").css("display", "block");
                        $("#CoordinadorPccAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateCoordinadorPcc_Enabled").css("display", "block");
                        $("#Footer_CreateCoordinadorPcc_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateCoordinadorPcc', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateCoordinadorPcc");
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
                        $("#Footer_UpdateCoordinadorPcc_Enabled").css("display", "none");
                        $("#Footer_UpdateCoordinadorPcc_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateCoordinadorPcc_Enabled").css("display", "block");
                        $("#Footer_UpdateCoordinadorPcc_Disabled").css("display", "none");
                        $("#modalUpdateCoordinadorPcc").modal('hide');
                        $("#viewDataCoordinadorPcc").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCoordinadorPcc").load(urlApp+'/de/convenio-coordinador-pcc/'+ codConvenio +'/data');
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
                        $("#CoordinadorPccAlerts").css("display", "block");
                        $("#CoordinadorPccAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateCoordinadorPcc_Enabled").css("display", "block");
                        $("#Footer_UpdateCoordinadorPcc_Disabled").css("display", "none");
                    }
                });
            });
            //6. Coordinador de la Entidad cooperante
            $("#viewDataCoordinadorEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataCoordinadorEntidad").load(urlApp+'/de/convenio-coordinador-entidad/'+ codConvenio +'/data');
            $('#modalCreateCoordinadorEntidad').on('show.bs.modal', function (e) {
                $('#divFormCreateCoordinadorEntidad').load(urlApp+'/de/convenio-coordinador-entidad/' + codConvenio + '/create');
            });
            $('#modalUpdateCoordinadorEntidad').on('show.bs.modal', function (e) {
                var codCoordinadorEntidad= $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateCoordinadorEntidad').load(urlApp+'/de/convenio-coordinador-entidad/'+codCoordinadorEntidad+'/edit');
            });
            $(document).on("click", '#btnCreateCoordinadorEntidad', function (event) {
                event.preventDefault();
                var form = $("#FormCreateCoordinadorEntidad");
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
                        $("#Footer_CreateCoordinadorEntidad_Enabled").css("display", "none");
                        $("#Footer_CreateCoordinadorEntidad_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateCoordinadorEntidad_Enabled").css("display", "block");
                        $("#Footer_CreateCoordinadorEntidad_Disabled").css("display", "none");
                        $("#modalCreateCoordinadorEntidad").modal('hide');
                        $("#viewDataCoordinadorEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCoordinadorEntidad").load(urlApp+'/de/convenio-coordinador-entidad/'+ codConvenio +'/data');
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
                        $("#CoordinadorEntidadAlerts").css("display", "block");
                        $("#CoordinadorEntidadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateCoordinadorEntidad_Enabled").css("display", "block");
                        $("#Footer_CreateCoordinadorEntidad_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateCoordinadorEntidad', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateCoordinadorEntidad");
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
                        $("#Footer_UpdateCoordinadorEntidad_Enabled").css("display", "none");
                        $("#Footer_UpdateCoordinadorEntidad_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateCoordinadorEntidad_Enabled").css("display", "block");
                        $("#Footer_UpdateCoordinadorEntidad_Disabled").css("display", "none");
                        $("#modalUpdateCoordinadorEntidad").modal('hide');
                        $("#viewDataCoordinadorEntidad").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCoordinadorEntidad").load(urlApp+'/de/convenio-coordinador-entidad/'+ codConvenio +'/data');
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
                        $("#CoordinadorEntidadAlerts").css("display", "block");
                        $("#CoordinadorEntidadAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateCoordinadorEntidad_Enabled").css("display", "block");
                        $("#Footer_UpdateCoordinadorEntidad_Disabled").css("display", "none");
                    }
                });
            });
            //7. Muestro los modals correspondientes a los compromisos asumidos
            $("#viewDataCompromisoConvenio").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataCompromisoConvenio").load(urlApp+'/de/convenio-compromiso/'+ codConvenio +'/data');
            $('#modalCreateCompromisoConvenio').on('show.bs.modal', function (e) {
                $('#divFormCreateCompromisoConvenio').load(urlApp+'/de/convenio-compromiso/' + codConvenio + '/create');
            });
            $('#modalUpdateCompromisoConvenio').on('show.bs.modal', function (e) {
                var codCompromiso= $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateCompromisoConvenio').load(urlApp+'/de/convenio-compromiso/'+codCompromiso+'/edit');
            });
            $(document).on("click", '#btnCreateCompromisoConvenio', function (event) {
                event.preventDefault();
                var form = $("#FormCreateCompromisoConvenio");
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
                        $("#Footer_CreateCompromisoConvenio_Enabled").css("display", "none");
                        $("#Footer_CreateCompromisoConvenio_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateCompromisoConvenio_Enabled").css("display", "block");
                        $("#Footer_CreateCompromisoConvenio_Disabled").css("display", "none");
                        $("#modalCreateCompromisoConvenio").modal('hide');
                        $("#viewDataCompromisoConvenio").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCompromisoConvenio").load(urlApp+'/de/convenio-compromiso/'+ codConvenio +'/data');
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
                        $("#CompromisoConvenioAlerts").css("display", "block");
                        $("#CompromisoConvenioAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateCompromisoConvenio_Enabled").css("display", "block");
                        $("#Footer_CreateCompromisoConvenio_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateCompromisoConvenio', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateCompromisoConvenio");
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
                        $("#Footer_UpdateCompromisoConvenio_Enabled").css("display", "none");
                        $("#Footer_UpdateCompromisoConvenio_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateCompromisoConvenio_Enabled").css("display", "block");
                        $("#Footer_UpdateCompromisoConvenio_Disabled").css("display", "none");
                        $("#modalUpdateCompromisoConvenio").modal('hide');
                        $("#viewDataCompromisoConvenio").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCompromisoConvenio").load(urlApp+'/de/convenio-compromiso/'+ codConvenio +'/data');
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
                        $("#CompromisoConvenioAlerts").css("display", "block");
                        $("#CompromisoConvenioAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateCompromisoConvenio_Enabled").css("display", "block");
                        $("#Footer_UpdateCompromisoConvenio_Disabled").css("display", "none");
                    }
                });
            });
            //8. muestro los modals para implementacion de compromisos
            $("#viewDataCompromisoImplementacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataCompromisoImplementacion").load(urlApp+'/de/convenio-implementacion/'+ codConvenio +'/data');
            $('#modalCreateCompromisoImplementacion').on('show.bs.modal', function (e) {
                $('#divFormCreateCompromisoImplementacion').load(urlApp+'/de/convenio-implementacion/' + codConvenio + '/create');
            });
            $('#modalUpdateCompromisoImplementacion').on('show.bs.modal', function (e) {
                var codImplementacion= $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateCompromisoImplementacion').load(urlApp+'/de/convenio-implementacion/'+codImplementacion+'/edit');
            });
            $(document).on("click", '#btnCreateCompromisoImplementacion', function (event) {
                event.preventDefault();
                var form = $("#FormCreateCompromisoImplementacion");
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
                        $("#Footer_CreateCompromisoImplementacion_Enabled").css("display", "none");
                        $("#Footer_CreateCompromisoImplementacion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateCompromisoImplementacion_Enabled").css("display", "block");
                        $("#Footer_CreateCompromisoImplementacion_Disabled").css("display", "none");
                        $("#modalCreateCompromisoImplementacion").modal('hide');
                        $("#viewDataCompromisoImplementacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCompromisoImplementacion").load(urlApp+'/de/convenio-implementacion/'+ codConvenio +'/data');
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
                        $("#CompromisoImplementacionAlerts").css("display", "block");
                        $("#CompromisoImplementacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateCompromisoImplementacion_Enabled").css("display", "block");
                        $("#Footer_CreateCompromisoImplementacion_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateCompromisoImplementacion', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateCompromisoImplementacion");
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
                        $("#Footer_UpdateCompromisoImplementacion_Enabled").css("display", "none");
                        $("#Footer_UpdateCompromisoImplementacion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateCompromisoImplementacion_Enabled").css("display", "block");
                        $("#Footer_UpdateCompromisoImplementacion_Disabled").css("display", "none");
                        $("#modalUpdateCompromisoImplementacion").modal('hide');
                        $("#viewDataCompromisoImplementacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataCompromisoImplementacion").load(urlApp+'/de/convenio-implementacion/'+ codConvenio +'/data');
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
                        $("#CompromisoImplementacionAlerts").css("display", "block");
                        $("#CompromisoImplementacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateCompromisoImplementacion_Enabled").css("display", "block");
                        $("#Footer_UpdateCompromisoImplementacion_Disabled").css("display", "none");
                    }
                });
            });
            //9. muestro los modals para la identificacion de organizaciones
            $("#viewDataEntidadIdentificada").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataEntidadIdentificada").load(urlApp+'/de/convenio-postulante/'+ codConvenio +'/data');
            $('#modalCreateEntidadIdentificada').on('show.bs.modal', function (e) {
                $('#divFormCreateEntidadIdentificada').load(urlApp+'/de/convenio-postulante/' + codConvenio + '/create');
            });
            $(document).on("click", '#btnCreateEntidadIdentificada', function (event) {
                event.preventDefault();
                var form = $("#FormCreateEntidadIdentificada");
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
                        $("#Footer_CreateEntidadIdentificada_Enabled").css("display", "none");
                        $("#Footer_CreateEntidadIdentificada_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateEntidadIdentificada_Enabled").css("display", "block");
                        $("#Footer_CreateEntidadIdentificada_Disabled").css("display", "none");
                        $("#modalCreateEntidadIdentificada").modal('hide');
                        $("#viewDataEntidadIdentificada").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataEntidadIdentificada").load(urlApp+'/de/convenio-postulante/'+ codConvenio +'/data');
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
                        $("#EntidadIdentificadaAlerts").css("display", "block");
                        $("#EntidadIdentificadaAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateEntidadIdentificada_Enabled").css("display", "block");
                        $("#Footer_CreateEntidadIdentificada_Disabled").css("display", "none");
                    }
                });
            });
            //10. Muestro las ampliaciones generadas
            $("#viewDataConvenioAmpliacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataConvenioAmpliacion").load(urlApp+'/de/convenio-ampliacion/'+ codConvenio +'/data');
            $('#modalCreateConvenioAmpliacion').on('show.bs.modal', function (e) {
                $('#divFormCreateConvenioAmpliacion').load(urlApp+'/de/convenio-ampliacion/' + codConvenio + '/create');
            });
            $('#modalUpdateConvenioAmpliacion').on('show.bs.modal', function (e) {
                var codConvenioAmpliacion   = $(e.relatedTarget).attr('data-id');
                $('#divFormUpdateConvenioAmpliacion').load(urlApp+'/de/convenio-ampliacion/'+codConvenioAmpliacion+'/edit');
            });
            $(document).on("click", '#btnCreateConvenioAmpliacion', function (event) {
                event.preventDefault();
                var form = $("#FormCreateConvenioAmpliacion");
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
                        $("#Footer_CreateConvenioAmpliacion_Enabled").css("display", "none");
                        $("#Footer_CreateConvenioAmpliacion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_CreateConvenioAmpliacion_Enabled").css("display", "block");
                        $("#Footer_CreateConvenioAmpliacion_Disabled").css("display", "none");
                        $("#modalCreateConvenioAmpliacion").modal('hide');
                        $("#viewDataConvenioAmpliacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataConvenioAmpliacion").load(urlApp+'/de/convenio-ampliacion/'+ codConvenio +'/data');
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
                        $("#ConvenioAmpliacionAlerts").css("display", "block");
                        $("#ConvenioAmpliacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_CreateConvenioAmpliacion_Enabled").css("display", "block");
                        $("#Footer_CreateConvenioAmpliacion_Disabled").css("display", "none");
                    }
                });
            });
            $(document).on("click", '#btnUpdateConvenioAmpliacion', function (event) {
                event.preventDefault();
                var form = $("#FormUpdateConvenioAmpliacion");
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
                        $("#Footer_UpdateConvenioAmpliacion_Enabled").css("display", "none");
                        $("#Footer_UpdateConvenioAmpliacion_Disabled").css("display", "block");
                    },
                    success: function (response) {
                        var mensaje = response.mensaje;
                        form[0].reset();
                        $("#Footer_UpdateConvenioAmpliacion_Enabled").css("display", "block");
                        $("#Footer_UpdateConvenioAmpliacion_Disabled").css("display", "none");
                        $("#modalUpdateConvenioAmpliacion").modal('hide');
                        $("#viewDataConvenioAmpliacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                        $("#viewDataConvenioAmpliacion").load(urlApp+'/de/convenio-ampliacion/'+ codConvenio +'/data');
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
                        $("#ConvenioAmpliacionAlerts").css("display", "block");
                        $("#ConvenioAmpliacionAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                        $("#Footer_UpdateConvenioAmpliacion_Enabled").css("display", "block");
                        $("#Footer_UpdateConvenioAmpliacion_Disabled").css("display", "none");
                    }
                });
            });
        });
    </script>
@stop