@extends('layouts.template')
@section('title', 'Matriz para la recolección de informacion en materia de Capacitación a Productores')
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
        licenseKey: "Z7DT-XGAD3I-182M4K-4C4Z4I-234J5H-3L6P31-353V68-5H5A05-2L2H",
        componentFolder: "https://cdn.flexmonster.com/",
        width: "100%",
        height: 800, 
        toolbar: true,
        report: {
            dataSource: {
                dataSourceType: "json",
                filename: appUrl+"/iniciativa/pivot-capacitacion/data",
                mapping: {
                    "Region":  {"type": "string"},
                    "Modalidad Presencial / Virtual":  {"type": "string"},
                    "DNI":  {"type": "string"},
                    "Beneficiado - Apellidos":  {"type": "string"},
                    "Beneficiado - Nombres":  {"type": "string"},
                    "Sexo":  {"type": "string"},
                    "Edad":  {"type": "string"},
                    "Actividad del productor":  {"type": "string"},
                    "Principal cultivo agricola":  {"type": "string"},
                    "Principal crianza":  {"type": "string"},
                    "Principal plantacion forestal":  {"type": "string"},
                    "Actividad del participante":  {"type": "string"},
                    "Detalle del tipo de participante":  {"type": "string"},
                    "Pertenece a alguna organizacion":  {"type": "string"},
                    "Tipo de organizacion":  {"type": "string"},
                    "Nombre de la organizacion":  {"type": "string"},
                    "Ubigeo":  {"type": "string"},
                    "Departamento":  {"type": "string"},
                    "Provincia":  {"type": "string"},
                    "Distrito":  {"type": "string"},
                    "Sector":  {"type": "string"},
                    "Tematica":  {"type": "string"},
                    "Nombre del evento":  {"type": "string"},
                    "Horas de capacitacion":  {"type": "number"},
                    "Tipo de evento":  {"type": "string"},
                    "Fecha":  {"type": "date string"},
                    "Periodo del evento":  {"type": "string"},
                    "Fuente de financiamiento":  {"type": "string"},
                    "Categoria presupuestal":  {"type": "string"},
                    "Programa presupuestal":  {"type": "string"},
                    "Responsable":  {"type": "string"},
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
                columns: [
                    {uniqueName: "Region"}, {uniqueName: "Modalidad Presencial / Virtual"}, {uniqueName: "DNI"}, {uniqueName: "Beneficiado - Apellidos"}, {uniqueName: "Beneficiado - Nombres"}, {uniqueName: "Sexo"}, {uniqueName: "Edad"}, {uniqueName: "Actividad del productor"}, {uniqueName: "Principal cultivo agricola"}, {uniqueName: "Principal crianza"}, {uniqueName: "Principal plantacion forestal"}, {uniqueName: "Actividad del participante"}, {uniqueName: "Detalle del tipo de participante"},
                    {uniqueName: "Pertenece a alguna organizacion"}, {uniqueName: "Tipo de organizacion"}, {uniqueName: "Nombre de la organizacion"}, {uniqueName: "Ubigeo"}, {uniqueName: "Departamento"}, {uniqueName: "Provincia"}, {uniqueName: "Distrito"}, {uniqueName: "Sector"},
                    {uniqueName: "Tematica"}, {uniqueName: "Nombre del evento"}, {uniqueName: "Horas de capacitacion"}, {uniqueName: "Tipo de evento"}, {uniqueName: "Fecha"}, {uniqueName: "Periodo del evento"},
                    {uniqueName: "Fuente de financiamiento"}, {uniqueName: "Categoria presupuestal"}, {uniqueName: "Programa presupuestal"}, {uniqueName: "Responsable"}
                ],
            }
        }
    });    
</script>    
@stop