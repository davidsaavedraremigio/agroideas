@extends('layouts.template')
@section('title', 'Pedidos de reconversión productiva')
@section('content')
{{-- Inicio del Contenido Principal --}}
{{-- Inicio del contenido--}}
<section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-header bg-primary"><br></div>
            <div class="card-body">
                <div id="pivot-container" style="padding-bottom: 30px;"></div>
            </div>
        </div>
    </div>
</section>
{{-- Termino del Contenido Principal --}}
@stop
@section('scripts')
<script>
    var appUrl ="{{env('APP_URL')}}";
    new Flexmonster({
        container: "#pivot-container",
        global: {
            localization: "https://cdn.flexmonster.com/loc/es.json"
        },
        licenseKey: "Z7VT-XD2F39-1Y0R5N-6T1B4U",
        componentFolder: "https://cdn.flexmonster.com/",
        width: "100%",
        height: 800, 
        toolbar: true,
        report: {
            dataSource: {
                dataSourceType: "json",
                filename: appUrl+"/proceso-prp/consolidado/consolidado-ur/data",
            },
            formats: [
                {
                    name: "",
                    thousandsSeparator: ",",
                    decimalSeparator: ".",
                    decimalPlaces: 2,
                    maxDecimalPlaces: -2,
                    maxSymbols: 20,
                    currencySymbol: "",
                    currencySymbolAlign: "left",
                    isPercent: false,
                    nullValue: "0",
                    infinityValue: "Infinity",
                    divideByZeroValue: "Infinity",
                    beautifyFloatingPoint: true
                }
            ],  
            options: {
                grid: {
                    type: "flat"
                },
                configuratorActive: false
            },
        }
    });    
</script>  
@stop