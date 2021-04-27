@extends('layouts.template')
@section('title', 'Reporte consolidado de Convenios Interistitucionales suscritos por el PCC')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header bg-primary">
                    <h3 class="card-title">@yield('title')</h3>
                    <div id="boton" class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="ibox-content">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">{!! Form::label('tipo', 'Seleccione un tipo de convenio') !!}
                                    <select name="tipo" id="inputTipo" class="form-control select2">
                                        <option value="100" selected="selected">Seleccionar todo</option>
                                        @foreach ($tipoConvenio as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">{!! Form::label('estado', 'Seleccione un estado') !!}
                                    <select name="estado" id="inputEstado" class="form-control select2">
                                        <option value="100" selected="selected">Seleccionar todo</option>
                                        @foreach ($estadoConvenio as $fila)
                                            <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3"><br></div>
                                <div class="col-md-3"><br></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="#" id="btnConsultaConvenio" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Realizar consulta</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="data_convenio" class="table-responsive"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    {{-- Término del contenido --}}
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            //#1. Obtengo la relación de compromisos por defecto
            $("#data_convenio").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, el reporte se esta procesando ...</h5>");
            $('#data_convenio').load('convenio-reporte/100/100/data');
            $("#boton").html("<a href='convenio-reporte/100/100/excel' class='btn btn-warning btn-sm'><i class='fas fa-download'></i> Descargar Consolidado</a>");
            //2. Obtengo el resultado de la consulta
            $('#btnConsultaConvenio').click(function () {
                var tipo    =   $("#inputTipo").val();
                var estado  =   $("#inputEstado").val();
                $("#data_convenio").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, el reporte se esta procesando ...</h5>");
                $('#data_convenio').load("convenio-reporte/"+tipo+"/"+estado+"/data");
                $("#boton").html("<a href='convenio-reporte/"+tipo+"/"+estado+"/excel' class='btn btn-warning btn-sm'><i class='fas fa-download'></i> Descargar Consolidado</a>");
            });
        });
    </script>
@stop