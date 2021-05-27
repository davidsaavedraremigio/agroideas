<table id="tabla-mantenimiento-expediente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center" width="5%"><small>Nº CUT</small></th>
            <th class="text-center" width="5%"><small>Nº Expediente</small></th>
            <th class="text-center" width="5%"><small>Nº RUC</small></th>
            <th class="text-center"width="20%"><small>Razón social</small></th>
            <th class="text-center"><small>Cadena</small></th>
            <th class="text-center"><small>Nº de productores</small></th>
            <th class="text-center"width="20%"><small>Responsable asignado</small></th>
            <th class="text-center"><small>Oficina</small></th>
            <th class="text-center"><small>Área actual</small></th>
            <th class="text-center"><small>Estado actual</small></th>
            <th class="text-center"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-uppercase"><small>{{$fila->especialista_asignado}}</small></td>
            <td class="text-center"><small>{{$fila->oficina}}</small></td>
            <td class="text-center"><small>{{$fila->area_sigla}}</small></td>
            <td class="text-center"><small>{{$fila->estado_proceso}}</small></td>
            <td class="text-center"><a href="{{route("mantenimiento.edit", $fila->id)}}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a></td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $('#tabla-mantenimiento-expediente').DataTable();
</script>