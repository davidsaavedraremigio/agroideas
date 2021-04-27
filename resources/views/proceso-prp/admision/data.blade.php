<table id="TablaAdmisionExpediente" class="table table-sm table-bordered table-striped">
    <thead>
        <th class="text-center"><small>Nº Expediente</small></th>
        <th class="text-center"><small>Nº CUT</small></th>
        <th class="text-center"><small>Fecha de presentación</small></th>
        <th class="text-center"><small>Nombre de la organización</small></th>
        <th class="text-center"><small>Cultivo a implementar</small></th>
        <th class="text-center"><small>Responsable asignado</small></th>
        <th class="text-center"><small>Oficina</small></th>
        <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_presentacion)->format('d/m/Y')}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-center"><small>{{$fila->oficina}}</small></td>
            <td class="text-center"><small></small></td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaAdmisionExpediente').DataTable();
    });
</script>