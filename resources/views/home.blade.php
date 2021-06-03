@extends('layouts.template')
@section('title', 'Bienvenidos')
@section('content')
{{-- Inicio del contenido --}}
<div class="container-fluid">
    <div class="row">
        <!-- Primer Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Beneficiarios atendidos</span>
                    <span class="info-box-number">0</span>
                </div>
            </div>
        </div>

        <!-- Segundo Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Inversión PCC (S/)</span>
                    <span class="info-box-number">0.00</span>
                </div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <!-- Tercer Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Contrapartida (S/)</span>
                    <span class="info-box-number">0.00</span>
                </div>
            </div>
        </div>
        <!-- Cuarto Cuadro -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Nivel de ejecución</span>
                    <span class="info-box-number">0<small>%</small></span>
                </div>
            </div>
        </div>



    </div>
    <div class="row">
        <section class="col-md-6 connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line"></i> Nº de incentivos aprobados por mes</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                        <p class="highcharts-description">Muestra el Nº de incentivos aprobados por mes para el periodo <strong>{{date('Y')}}</strong>, de acuerdo a la fecha de aprobación.</p>
                    </figure>
                </div>
            </div>
        </section>
        <section class="col-md-6 connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Top 10 de Cadenas productivas con mayor demanda</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="containerCadena"></div>
                        <p class="highcharts-description">Muestra las <strong>10</strong> principales Cadenas productivas atendidas por el PCC de acuerdo a la demanda.</p>
                    </figure>
                </div>
            </div>
        </section>
    </div>
</div>






{{-- Término del contenido--}}
@endsection
@section('scripts')
<script>
    
    var prpa            =   @json($prpa);
    var dataPrpa        =   [];
	for (var i in prpa)
	{
		var array = prpa[i];
		dataPrpa.push(parseFloat(array.meta),);
	}

    var asoc                    =   @json($asoc);
    var dataAsociatividad       =   [];
    for (var i in asoc)
    {
        var array = asoc[i];
        dataAsociatividad.push(parseFloat(array.meta),);
    }

    var gest                    =   @json($gest);
    var dataGestion             =   [];
    for (var i in gest)
    {
        var array = gest[i];
        dataGestion.push(parseFloat(array.meta),);
    }

    var tec                     =   @json($tec);
    var dataTecnologia          =   [];
    for (var i in tec)
    {
        var array = tec[i];
        dataTecnologia.push(parseFloat(array.meta),);
    }

    var cadena                  =   @json($cadenas);
    var dataCadenas             =   [];
    for(var i in cadena)
    {
        var array = cadena[i];
        dataCadenas.push({
            name: array.cadena,
            y: parseFloat(array.total)
        },);
    }

    console.log(dataCadenas);

    //1. Ejecucion fisica mensual
    Highcharts.chart('container', {

        chart: {
            type: 'column'
        },

        title: {
            text: ''
        },

        xAxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        },
        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Número de incentivos aprobados'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                this.series.name + ': ' + this.y + '<br/>' +
                'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },

        series: [{
            name:   'PRPA',
            data:   dataPrpa,
            stack:  'male'
        }, {
            name:   'Asociatividad',
            data:   dataAsociatividad,
            stack:  'male'
        }, {
            name:   'Tecnología',
            data:   dataTecnologia,
            stack:  'male'
        }, {
            name:   'Gestión',
            data:   dataGestion,
            stack:  'male'
        }]
    });
    //2. Top 5 de productos con mayor demanda
    Highcharts.chart('containerCadena', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
            valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                },
                showInLegend: false
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: dataCadenas
        }]
    });


</script>
@endsection
