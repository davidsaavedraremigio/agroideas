<table id="TablaNoObjecion" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº Convenio</small></th>
            <th class="text-center"><small>Nº de RUC</small></th>
            <th class="text-center"><small>Razón social</small></th>
            <th class="text-center"><small>Nº de solicitud</small></th>
            <th class="text-center"><small>Fecha de solicitud</small></th>
            <th class="text-center"><small>Nº de carta</small></th>
            <th class="text-center"><small>Fecha de carta</small></th>
            <th class="text-center"><small>Justificación</small></th>
            <th class="text-center"><small>Importe (S/.)</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_contrato}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-left"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->nro_solicitud}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->nro_carta}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fechaCartaSolicitud)->format('d/m/Y')}}</small></td>
            <td class="text-justify"><small>{{$fila->justificacion}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateNoObjecion" data-toggle="modal" data-target="#modalUpdateNoObjecion" data-id="{{$fila->id}}" title="Actualizar registro"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateNoObjecionDetalle" data-toggle="modal" data-target="#modalCreateNoObjecionDetalle" data-id="{{$fila->id}}" title="Añadir detalle"><i class="far fa-plus-square"></i></a>
                <a href="#" class="btn btn-sm btn-success" id="btnmodalDataNoObjecionDetalle" data-toggle="modal" data-target="#modalDataNoObjecionDetalle" data-id="{{$fila->id}}" title="Detalle de la solicitud"><i class="far fa-list-alt"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteNoObjecion" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody> 
</table>
@section('scripts')
<script>
    $('#TablaNoObjecion').DataTable();
</script>