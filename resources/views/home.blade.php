@extends('layouts.template')
@section('title', 'Bienvenidos')
@section('content')
{{-- Inicio del contenido --}}
<div class="container-fluid">
    <div id="divChartResumen">
        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
        <span class="sr-only">Cargando...</span>
    </div>
    <hr class="my-4">
    <div class="row">
        <section class="col-md-8 connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line"></i> Nº de incentivos aprobados por mes</h3>
                    <div class="card-tools">
                        <select name="periodo" id="input_periodo" class="form-control input-sm">
                            @for ($i = 2010; $i <= date('Y'); $i++)
                            <option value="{{$i}}" {{(date('Y') == $i)?'selected':''}}>Periodo {{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div id="divChartIncentivo">
                        <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="col-md-4 connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Top 10 de Cadenas productivas con mayor demanda</h3>
                    <div class="card-tools">
                        <select name="tipo" id="input_tipo" class="form-control input-sm">
                            <option value="0" selected="selected">Seleccionar</option>
                            <option value="2">Reconversión productiva</option>
                            <option value="3">Asociatividad</option>
                            <option value="4">Gestión empresarial</option>
                            <option value="5">Adopción de tecnología</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div id="divChartCadenaProductiva">
                        <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>






{{-- Término del contenido--}}
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $("#divChartResumen").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#divChartResumen").load(route("home.resumen"));
        
        $("#divChartCadenaProductiva").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#divChartCadenaProductiva").load(route("home.cadena", 0));

        $("#divChartIncentivo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#divChartIncentivo").load(route("home.incentivo", {{date('Y')}}));

        $('#input_periodo').on('change', function(e){
            var periodo     =   e.target.value;
            var url         =   route('home.incentivo', periodo);
            $.get(url, function(data) {
                $("#divChartIncentivo").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                $("#divChartIncentivo").load(url);
            });
        });

        $('#input_tipo').on('change', function(e){
            var tipo_incentivo     =   e.target.value;
            var url                 =   route('home.cadena', tipo_incentivo);
            $.get(url, function(data) {
                $("#divChartCadenaProductiva").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                $("#divChartCadenaProductiva").load(route("home.cadena", tipo_incentivo));
            });
        });

    });


</script>
@endsection
