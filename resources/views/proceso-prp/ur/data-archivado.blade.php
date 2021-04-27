<table id="TablaArchivado" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razón Social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Nº Carta</small></th>
            <th class="text-center"><small>Fecha</small></th>
        </tr>
    </thead>
    <tbody>
       @foreach ($expediente as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}} / {{$fila->provincia}} / {{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->responsable_doc}}</small></td>
            <td class="text-center"><small>{{$fila->nro_carta_archivo}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_carta_archivo)->format('d/m/Y')}}</small></td>
        </tr>   
       @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaArchivado').DataTable();
    });
</script>