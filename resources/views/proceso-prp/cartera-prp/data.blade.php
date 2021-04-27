<table id="TablaCartera" class="table table-sm table-bordered table-striped">
    <thead>
        <th class="text-center"><small>Nº</small></th>
        <th class="text-center"><small>Descripción de cartera</small></th>
        <th class="text-center"><small>Regiones atendidas</small></th>
        <th class="text-center"><small>Nº de Resolución</small></th>
        <th class="text-center"><small>Fecha</small></th>
        <th class="text-center"><small>Importe</small></th>
        <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-uppercase"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center"><small>{{$fila->ubigeo}}</small></td>
            <td class="text-center"><small>{{$fila->nro_resolucion}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalAsignaPrp" data-toggle="modal" data-target="#modalAsignaPrp" data-id="{{$fila->id}}"><i class="fas fa-bars"></i></a>
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateCarteraPrp" data-toggle="modal" data-target="#modalUpdateCarteraPrp" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteCarteraPrp" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaCartera').DataTable();
    });
</script>