<figure class="highcharts-figure">
    <div id="containerCadena"></div>
    <!--<p class="highcharts-description">Muestra las <strong>10</strong> principales Cadenas productivas atendidas por el PCC de acuerdo a la demanda.</p>-->
</figure>
@section('scripts')
<script>
    //1. Proceso los datos de la cadena productiva
    var cadena                  =   @json($data);
    var dataCadenas             =   [];
    for(var i in cadena)
    {
        var array = cadena[i];
        dataCadenas.push({
            name: array.cadena,
            y: parseFloat(array.total)
        },);
    }   
    //2. Genero una gráfica
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