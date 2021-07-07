@extends('layouts.template-pdf')
@section('title', 'Pruebas')
@section('content')
{{-- Inicio del contenido --}}
<table class="granTitulo" style="width: 100%;">
    <tr>
        <td>
            REPORTE DE EJECUCIÓN DEL CONVENIO DE COOPERACIÓN O ESPECÍFICO
        </td>
    </tr>
</table>
<table id="estiloTabla">
    <tr>
        <td style="width: 35%;">Código de convenio</td>
        <td colspan="3">{{$convenio->nro_convenio}}</td>
    </tr>
    <tr>
        <td style="width: 35%;">Fecha de suscripción</td>
        <td>{{ \Carbon\Carbon::parse($convenio->fecha_firma)->format('d/m/Y')}}</td>
        <td style="width: 35%;">Fecha de finalización</td>
        <td>{{ \Carbon\Carbon::parse($convenio->fecha_termino)->format('d/m/Y')}}</td>
    </tr>
</table>
<p class="titularNivel3">Coordinador(a) del convenio</p>
<table id="estiloTabla">
    <tr>
        <th style="width: 40%;"><br></th>
        <th style="width: 30%;">Órgano o Unidad órganica - MIDAGRI</th>
        <th style="width: 30%;">Contraparte</th>
    </tr>
    <tr>
        <td>Nombres y Apellidos:</td>
        <td>{{$convenio->coordinador_pcc_titular}}</td>
        <td>{{$convenio->coordinador_entidad_titular}}</td>
    </tr>
    <tr>
        <td>Correo electrónico:</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Teléfono fijo / anexo:</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Teléfono celular:</td>
        <td></td>
        <td></td>
    </tr>
</table>
<p class="titularNivel3">Avance en base a los documentos de planificación</p>
<table id="estiloTabla">
    <tr>
        <td>
            <p class="text-justify" style="padding-left: 10px;">El presente convenio cuenta con las siguientes actividades realizadas:</p>

            <table id="estiloTablaSinBordes">
                <tr>
                    <th>Nº</th>
                    <th>Compromiso</th>
                    <th>Actividad</th>
                    <th>Fecha</th>
                    <th>Acciones realizadas</th>
                </tr>
                @foreach ($actividades as $keyNumber => $fila)
                <tr>
                    <td>{{$keyNumber+1}}</td>
                    <td>{{$fila->compromiso}}</td>
                    <td>{{$fila->actividad}}</td>
                    <td>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</td>
                    <td>{{$fila->acciones}}</td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
<br>
<table id="estiloTabla">
    <tr>
        <td style="width: 35%;">FECHA DE PRESENTACIÓN DEL REPORTE:</td>
        <td style="width: 30%;"></td>
    </tr>
</table>
@endsection