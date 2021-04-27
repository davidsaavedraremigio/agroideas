@extends('layouts.template')
@section('title', 'Módulo para la formulación de PRPA')
@section('content')
{{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div id="viewDataFormulacion" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
{{-- Término del contenido--}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //1. Obtengo los datos generados
        $("#viewDataFormulacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataFormulacion").load("formulacion/data");
    });
</script>
@stop