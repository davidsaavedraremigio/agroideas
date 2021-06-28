@extends('layouts.template')
@section('title', 'Módulo para la atención de solicitudes de No Objeción')
@section('content')
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header bg-primary">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-sm btn-info" title="Registre un nuevo proceso"><i class="fas fa-plus-circle"></i><span> Añadir nuevo</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div id="viewDataNoObjecion" class="table-responsive"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Término del contenido--}}
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            //1. Obtengo la información de eventos registrados
            $("#viewDataNoObjecion").html("<i class='fas fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
            $("#viewDataNoObjecion").load(route("nobjecion.data"));
        });
    </script>
@stop