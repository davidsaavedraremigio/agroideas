<table id="TablaLinea" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Sector</small></th>
            <th class="text-center"><small>Descripción de Linea</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>    
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->sector}}</small></td>
            <td class="text-center"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateLinea" data-toggle="modal" data-target="#modalUpdateLinea" data-id="{{$fila->id}}" title="Actualizar registros"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteLinea" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaLinea').DataTable();
        });
</script>