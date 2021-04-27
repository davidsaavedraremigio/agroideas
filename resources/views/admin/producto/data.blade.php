<table id="TablaProducto" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Sector</small></th>
            <th class="text-center"><small>Linea</small></th>
            <th class="text-center"><small>Cadena</small></th>
            <th class="text-center"><small>Nombre del producto</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>    
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->sector}}</small></td>
            <td class="text-center"><small>{{$fila->linea}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateProducto" data-toggle="modal" data-target="#modalUpdateProducto" data-id="{{$fila->id}}" title="Actualizar registros"><i class="fas fa-edit"></i></a>
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