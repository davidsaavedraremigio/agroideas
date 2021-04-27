<table id="TablaArchivado" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Nº CUT</small></th>
            <th class="text-center"><small>Fecha de presentación</small></th>
            <th class="text-center"><small>Nombre de la organización</small></th>
            <th class="text-center"><small>Duración</small></th>
            <th class="text-center"><small>Fecha de inicio</small></th>
            <th class="text-center"><small>Fecha de término</small></th>
            <th class="text-center"><small>Area</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expediente as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->duracion}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_inicio)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_termino)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->area_sigla}}</small></td>
            <td class="text-center"><small>-</small></td>
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