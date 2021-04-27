<table id="TablaAprobado" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Fecha de recepción</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razon Social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Nº Informe</small></th>
            <th class="text-center"><small>Nº Memorándun</small></th>
            <th class="text-center"><small>Fecha derivación</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_recepcion)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-uppercase"><small>{{$fila->responsable_evaluacion}}</small></td>
            <td class="text-center"><small>{{$fila->nro_informe}}</small></td>
            <td class="text-center"><small>{{$fila->nro_memo_favorable}}</small></td>
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