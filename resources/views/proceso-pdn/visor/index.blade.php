@extends('layouts.template')
@section('title', 'Resumen ejecutivo - Solicitudes de apoyo')
@section('content')
{{-- Inicio del Contenido Principal --}}
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <!--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCreateArea"><i class="fa fa-plus" aria-hidden="true"></i><span> Añadir nuevo</span></a>-->
                </div>
            </div>
            <div class="card-body">
                <div class="ibox-content">
                    <iframe width="100%" height="800" src="https://app.powerbi.com/view?r=eyJrIjoiZWI2MmI0MDktMjVmMC00MDQzLTkyYzItNzJmODViMmQ5MTVjIiwidCI6IjNlYzkwMWZjLTBhMDMtNDdmZi04OWQzLTk2MWY1YTAwMWFhOCIsImMiOjR9&pageName=ReportSection" frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Termino del Contenido Principal --}}
@endsection