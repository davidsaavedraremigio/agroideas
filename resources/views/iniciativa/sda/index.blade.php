@extends('layouts.template')
@section('title', 'Módulo para la gestión de Solicitudes de apoyo a incentivos')
@section('content')
    {{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools">
                        <a href="sda/create" class="btn btn-sm btn-primary" title="Realizar nuevo registro"><i class="fas fa-plus-circle"></i><span> Añadir nuevo</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="viewDataSda" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            $("#viewDataSda").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataSda").load("sda/data");
        });
    </script>
@stop