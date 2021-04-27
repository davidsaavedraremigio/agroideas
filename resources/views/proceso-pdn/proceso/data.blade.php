<table id="TablaProcesoExpediente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Área origen</th>
            <th class="text-center">Fecha recepción</th>
            <th class="text-center">Especialista asignado</th>
            <th class="text-center">Nº de documento</th>
            <th class="text-center">Fecha de derivación</th>
            <th class="text-center">Área destino</th>
            <th class="text-center">Estado</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->area_origen}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_recepcion)->format('d/m/Y')}}</small></td>
            <td class="text-left"><small>{{$fila->especialista_origen}}</small></td>
            <td class="text-center"><small>{{$fila->nro_documento}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_derivacion)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->area_destino}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateProcesoExpediente" data-toggle="modal" data-target="#modalUpdateProcesoExpediente" data-id="{{$fila->id}}" title="Actualizar registros"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteProcesoExpediente" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaProcesoExpediente').DataTable();
        });
</script>