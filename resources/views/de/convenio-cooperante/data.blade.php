<table id="TablaConvenioEntidad" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razon Social</small></th>
            <th class="text-center"><small>Nº DNI</small></th>
            <th class="text-center"><small>Representante legal</small></th>
            <th class="text-center"><small>Cargo</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-center"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->representante_dni}}</small></td>
            <td class="text-center"><small>{{$fila->representante_nombre}}</small></td>
            <td class="text-center"><small>{{$fila->representante_cargo}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateEntidadCooperante" data-toggle="modal" data-target="#modalUpdateEntidadCooperante" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteEntidadCooperante" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaConvenioEntidad').DataTable();
    });
</script>