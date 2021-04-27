<table id="TablaProducto" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Sector</th>
            <th class="text-center">Linea</th>
            <th class="text-center">Cadena productiva</th>
            <th class="text-center">Producto específico</th>
            <th class="text-center">Variedad</th>
            <th class="text-center">Tipo de producción</th>
            <th class="text-center">Nº Has asociadas</th>
            <th class="text-center">Nº productores</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->sector}}</small></td>
            <td class="text-center"><small>{{$fila->linea}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{$fila->producto}}</small></td>
            <td class="text-center"><small>{{$fila->variedad}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_produccion}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nroHas,2)}}</small></td>
            <td class="text-center"><small>{{$fila->nroProductores}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateProducto" data-toggle="modal" data-target="#modalUpdateProducto" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteProducto" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaProducto').DataTable();
        });
</script>