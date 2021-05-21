@extends('layouts.template')
@section('title', 'Módulo: Eventos de capacitación')
@section('content')
{{-- Inicio del contenido --}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <a href="{{route("capacitacion.create")}}" class="btn btn-sm btn-primary" title="Realizar nuevo registro"><i class="fas fa-plus-circle"></i><span> Añadir nuevo</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="TabCapacitacion" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="TabCapacitacion001" data-toggle="pill" href="#custom-tabs-capacitacion-pendiente" role="tab" aria-controls="custom-tabs-capacitacion-pendiente" aria-selected="true">1. Eventos programados</a></li>
                                    <li class="nav-item"><a class="nav-link" id="TabCapacitacion002" data-toggle="pill" href="#custom-tabs-capacitacion-implementado" role="tab" aria-controls="custom-tabs-capacitacion-implementado" aria-selected="false">2. Eventos implementados</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="TabCapacitacionContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-capacitacion-pendiente" role="tabpanel" aria-labelledby="TabCapacitacion001">
                                        <div id="viewDataCapacitacionPendiente" class="table-responsive"></div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-capacitacion-implementado" role="tabpanel" aria-labelledby="TabCapacitacion002">
                                        <div id="viewDataCapacitacionImplementado" class="table-responsive"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            //1. Obtengo la información de eventos registrados
            $("#viewDataCapacitacionPendiente").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataCapacitacionPendiente").load(route("capacitacion.data-pendiente"));
            $("#viewDataCapacitacionImplementado").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataCapacitacionImplementado").load(route("capacitacion-implementacion.data"));
        });
    </script>
@stop