@extends('layouts.template')
@section('title', 'Módulo para la actualización de Información General de Proyectos')
@section('content')
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header bg-primary">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <div id="viewDataProyecto" class="table-responsive"></div>
            </div>
        </div>
    </div>
</section>
{{-- Término del contenido--}}
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#viewDataProyecto").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataProyecto").load(route("proyecto-prpa.data"));
        });
    </script>
@stop