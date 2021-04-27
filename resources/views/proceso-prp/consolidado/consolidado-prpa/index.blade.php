@extends('layouts.template')
@section('title', 'PRPAs en formulación')
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
                filename: appUrl+"/proceso-prp/consolidado/consolidado-prpa/data",
                mapping: {
                    "ruc":  {"type": "string"},
                    "razon social":  {"type": "string"},
                    "nro cut":  {"type": "string"},
                    "nro expediente":  {"type": "string"},
                    "fecha expediente":  {"type": "year/quarter/month/day"},
                    "area": {"type": "string"},
                    "region":  {"type": "string"},
                    "provincia":  {"type": "string"},
                    "distrito":  {"type": "string"},
                    "cultivo a reconvertir":  {"type": "string"},
                    "cultivo a instalar":  {"type": "string"},
                    "nro ha":  {"type": "number"},
                    "nro beneficiarios":  {"type": "number"},
                    "inversion total":  {"type": "number"},
                    "inversion pcc":  {"type": "number"},
                    "porcentaje pcc":  {"type": "number"},
                    "inversion entidad":  {"type": "number"},
                    "porcentaje entidad":  {"type": "number"},
                }
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
            slice:{                
                columns: [{uniqueName: "ruc"}, {uniqueName: "razon social"}, {uniqueName: "area"}, {uniqueName: "nro cut"}, {uniqueName: "nro expediente"}, {uniqueName: "fecha expediente"}, {uniqueName: "region"}, {uniqueName: "provincia"}, {uniqueName: "distrito"}, {uniqueName: "cultivo a reconvertir"}, {uniqueName: "cultivo a instalar"}],
                measures: [{uniqueName: "nro ha"}, {uniqueName: "nro beneficiarios"}, {uniqueName: "inversion total"}, {uniqueName: "inversion pcc"}, {uniqueName: "porcentaje pcc", aggregation: "Average", active: true }, {uniqueName: "inversion entidad"}, {uniqueName: "porcentaje entidad", aggregation: "Average", active: true }]
            }
        }
    });    
</script>    
@stop