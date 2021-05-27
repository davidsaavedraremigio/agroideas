@extends('layouts.template')
@section('title', 'Módulo para el mantenimiento de información de Expedientes')
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
                    <div id="viewDataExpedientePrp" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        $("#viewDataExpedientePrp").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataExpedientePrp").load(route("mantenimiento.data"));
    });
</script>
@stop