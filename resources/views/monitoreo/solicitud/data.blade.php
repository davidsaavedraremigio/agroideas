<table id="TablaSolicitudDesembolso" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº Solicitud</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Nº de Memorando</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Nº de Informe</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Importe (S/.)</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_solicitud}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_solicitud)->format('d/m/Y')}}</small></td>
            <td class="text-left"><small>{{$fila->especialista}}</small></td>
            <td class="text-center"><small>{{$fila->nro_memo}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_memo)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->nro_informe}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_informe)->format('d/m/Y')}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateSolicitudDesembolso" data-toggle="modal" data-target="#modalUpdateSolicitudDesembolso" data-id="{{$fila->id}}" title="Actualizar registro"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateSolicitudDesembolsoDetalle" data-toggle="modal" data-target="#modalCreateSolicitudDesembolsoDetalle" data-id="{{$fila->id}}" title="Añadir detalle"><i class="far fa-plus-square"></i></a>
                <a href="#" class="btn btn-sm btn-success" id="btnmodalDataSolicitudDesembolsoDetalle" data-toggle="modal" data-target="#modalDataSolicitudDesembolsoDetalle" data-id="{{$fila->id}}" title="Detalle de la solicitud"><i class="far fa-list-alt"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteSolicitudDesembolso" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $('#TablaSolicitudDesembolso').DataTable();
</script>