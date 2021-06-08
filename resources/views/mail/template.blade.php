@extends('layouts.template-mail')
@section('title', 'Notificación de asignación de expediente')
@section('content')
{{-- Inicio del contenido --}}
<table class="main" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="content-wrap">
            <!-- Inicio del contenido -->
            <p>Estimado Señor(a):<br/>"{{$responsable->nombres}}”<br/><u>Presente</u>. -</p>
            <p class="alignjustify">La presente hace de su conocimiento la notificación de asignación del Expediente Nº {{$expediente->nroExpediente}} el cual fue presentado por la entidad {{$entidad->nombre}} para su revisión, evaluación y factibilidad de ser el caso.</p>
            <p>En ese sentido, se hace de su conocimiento la asignación del mismo para los fines y acciones que correspondan.</p>
            <p>Nota: La notificación se considerará efectuada y se entiende eficaz desde la fecha de su emisión, de conformidad con lo establecido por el artículo 16.2° de la Ley del Procedimiento Administrativo General - Ley N° 27444.</p>
            <!-- Fin del contenido -->
        </td>
    </tr>
</table>
{{-- Fin del contenido --}}
@endsection