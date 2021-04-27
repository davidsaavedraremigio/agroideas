@extends('layouts.template')
@section('title', 'Resumen ejecutivo - Eventos y compromisos')
@section('content')
{{-- Inicio del Contenido Principal --}}
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>
                <div class="card-tools">
                    <a href="../iniciativa/evento/excel" class="btn btn-sm btn-primary"><i class="fas fa-download"></i><span> Descargar consolidado</span></a>
                </div>
            </div>
            <div class="card-body">
                <div class="ibox-content">
                    <iframe width="100%" height="800" src="https://app.powerbi.com/view?r=eyJrIjoiYTM0NjNlZjItMzViMy00ZWQyLTg0NjYtYmIwMWJlY2VjYmQxIiwidCI6ImM0YTY2YzM0LTJiYjctNDUxZi04YmUxLWIyYzI2YTQzMDE1OCIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Termino del Contenido Principal --}}
@endsection