@extends('layouts.template')
@section('title', 'Tabla interactiva - Solicitudes de apoyo aprobadas')
@section('content')
{{-- Inicio del Contenido Principal --}}
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
                    <iframe width="100%" height="800" src="https://app.powerbi.com/view?r=eyJrIjoiMDNlZjg0YmYtN2M4Ny00Y2RiLWE3MjAtNjkxNDNkOGVhOGUyIiwidCI6IjNlYzkwMWZjLTBhMDMtNDdmZi04OWQzLTk2MWY1YTAwMWFhOCIsImMiOjR9&pageName=ReportSection" frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Termino del Contenido Principal --}}
@endsection
