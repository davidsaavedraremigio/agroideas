<figure class="highcharts-figure">
    <div id="container"></div>
    <!--<p class="highcharts-description">Muestra el Nº de incentivos aprobados por mes para el periodo <strong>{{date('Y')}}</strong>, de acuerdo a la fecha de aprobación.</p>-->
</figure>
@section('scripts')
<script>
    //1. Obtenemos la información
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

    //2. Ejecucion fisica mensual
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
</script>