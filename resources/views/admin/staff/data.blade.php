<table id="TablaStaff" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>DNI</small></th>
            <th class="text-center"><small>RUC</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Dirección</small></th>
            <th class="text-center"><small>Teléfono</small></th>
            <th class="text-center"><small>Nº Póliza</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->nroDni}}</small></td>
            <td class="text-center"><small>{{$fila->nroRuc}}</small></td>
            <td class="text-left"><small>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</small></td>
            <td class="text-left"><small>{{$fila->direccion}}</small></td>
            <td class="text-center"><small>{{$fila->nroTelefono}}</small></td>
            <td class="text-center"><small>{{$fila->nroPoliza}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateStaff" data-toggle="modal" data-target="#modalUpdateStaff" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteStaff" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaStaff').DataTable();
    });
</script>