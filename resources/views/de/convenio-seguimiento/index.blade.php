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
                                <div class="col-md-3">{!! Form::label('periodo', 'Seleccione un periodo') !!}
                                    <select name="periodo" id="inputPeriodo" class="form-control select2">
                                        <option value="100" selected="selected">Seleccionar todo</option>
                                        <option value="2011">Periodo 2011</option>
                                        <option value="2012">Periodo 2012</option>
                                        <option value="2013">Periodo 2013</option>
                                        <option value="2014">Periodo 2014</option>
                                        <option value="2015">Periodo 2015</option>
                                        <option value="2016">Periodo 2016</option>
                                        <option value="2017">Periodo 2017</option>
                                        <option value="2018">Periodo 2018</option>
                                        <option value="2019">Periodo 2019</option>
                                        <option value="2020">Periodo 2020</option>
                                        <option value="2021">Periodo 2021</option>
                                    </select>
                                </div>
                                <div class="col-md-3"><br></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="#" id="btnConsultaSegumientoConvenio" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Realizar consulta</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="data_seguimiento_convenio" class="table-responsive"></div>
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
            $("#data_seguimiento_convenio").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, el reporte se esta procesando ...</h5>");
            $('#data_seguimiento_convenio').load('convenio-seguimiento/100/100/100/data');
            $("#boton").html("<a href='convenio-seguimiento/100/100/100/excel' class='btn btn-warning btn-sm'><i class='fas fa-download'></i> Descargar Consolidado</a>");
            //2. Obtengo el resultado de la consulta
            $('#btnConsultaSegumientoConvenio').click(function () {
                var tipo    =   $("#inputTipo").val();
                var estado  =   $("#inputEstado").val();
                var periodo  =   $("#inputPeriodo").val();
                $("#data_seguimiento_convenio").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, el reporte se esta procesando ...</h5>");
                $('#data_seguimiento_convenio').load("convenio-seguimiento/"+tipo+"/"+estado+"/"+periodo+"/data");
                $("#boton").html("<a href='convenio-seguimiento/"+tipo+"/"+estado+"/"+periodo+"/excel' class='btn btn-warning btn-sm'><i class='fas fa-download'></i> Descargar Consolidado</a>");
            });
        });
    </script>
@stop