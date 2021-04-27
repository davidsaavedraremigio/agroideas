<table id="TablaExpedienteDerivado" class="table table-sm table-bordered table-striped">
    <thead>
        <th class="text-center"><small>Tipo de documento</small></th>
        <th class="text-center"><small>Nº documento</small></th>
        <th class="text-center"><small>Fecha de documento</small></th>
        <th class="text-center"><small>Nombre de la organización</small></th>
        <th class="text-center"><small>Duración</small></th>
        <th class="text-center"><small>Fecha de inicio</small></th>
        <th class="text-center"><small>Fecha de término</small></th>
        <th class="text-center"><small>Nº Expediente</small></th>
        <th class="text-center"><small>Nº CUT</small></th>
        <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
    </thead>
    <tbody>
        @foreach ($documentos as $fila)
        <tr>
            <td class="text-center"><small>{{$fila->tipo_documento}}</small></td>
            <td class="text-center"><small>{{$fila->nro_documento}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_documento)->format('d/m/Y')}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->duracion}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_inicio)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_termino)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-success" id="btnmodalMonitoreoExpedienteDe" data-toggle="modal" data-target="#modalMonitoreoExpediente" data-id="{{$fila->cod_expediente}}" title="Visualizar historial"><i class="far fa-folder-open"></i></a>
                <a href="{{ env('APP_URL_FILE') }}/{{$fila->evidencia}}" class="btn btn-sm btn-primary"><i class="fas fa-file-download"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaExpedienteDerivado').DataTable();
    });
</script>