<table id="TablaAprobado" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Nº de RUC</small></th>
            <th class="text-center"><small>Razon social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Nº de informe</small></th>
            <th class="text-center"><small>Fecha Informe</small></th>
            <th class="text-center"><small>Fecha de derivacion</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expediente as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->especialista_asignado}}</small></td>
            <td class="text-center"><small>{{$fila->nro_informe_tec}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_informe_tec)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_derivacion)->format('d/m/Y')}}</small></td>
        </tr>   
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaAprobado').DataTable();
    });
</script>