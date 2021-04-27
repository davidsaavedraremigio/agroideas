@extends('layouts.template')
@section('title', 'Situación de expedientes - PRP')
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
                    <iframe width="100%" height="800" src="https://app.powerbi.com/view?r=eyJrIjoiN2E1Mzk1YTctZmNlNC00ZjY3LWJhMzctMzFiMzEwOTMwMTI4IiwidCI6ImM0YTY2YzM0LTJiYjctNDUxZi04YmUxLWIyYzI2YTQzMDE1OCIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Termino del Contenido Principal --}}
@endsection