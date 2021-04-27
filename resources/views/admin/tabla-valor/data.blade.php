<table id="TablaValor" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Tabla</small></th>
            <th class="text-center"><small>Nombre</small></th>
            <th class="text-center"><small>Valor</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
            <tr>
                <td class="text-center"><small>{{$keyNumber+1}}</small></td>
                <td class="text-center"><small>{{$fila->Tabla}}</small></td>
                <td class="text-center"><small>{{$fila->Nombre}}</small></td>
                <td class="text-center"><small>{{$fila->Valor}}</small></td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateTablaValor" data-toggle="modal" data-target="#modalUpdateTablaValor" data-id="{{$fila->id}}"><i class="fas fa-edit"></i> </a>
                    <a href="#" class="btn btn-sm btn-danger btnDeleteTablaValor" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i> </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaValor').DataTable({
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