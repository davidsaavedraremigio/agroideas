<table id="TablaUbigeo" class="table table-striped">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Codigo</small></th>
            <th class="text-center"><small>Nombre</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ubigeo as $keyNumber => $fila)
            <tr>
                <td class="text-center"><small>{{$keyNumber+1}}</small></td>
                <td class="text-center"><small>{{$fila->id}}</small></td>
                <td class="text-center"><small>{{$fila->nombre}}</small></td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateUbigeo" data-toggle="modal" data-target="#modalUpdateUbigeo" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btnDeleteUbigeo" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaUbigeo').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
</script>