<table id="TablaExpedienteDerivado" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razon social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Fecha Informe Ev. Geoespacial</small></th>
            <th class="text-center"><small>Fecha Informe Ev. Documentaria</small></th>
            <th class="text-center"><small>Fecha de derivacion</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expediente as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}} / {{$fila->provincia}} / {{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->especialista_asignado}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_informe_geo)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_informe_doc)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_derivacion)->format('d/m/Y')}}</small></td>
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