<table id="TablaIndicadorResultado" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center"><small>Descripción del indicador</small></th>
            <th class="text-center"><small>Unidad de medida</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo}}</small></td>
            <td class="text-left"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center"><small>{{$fila->unidad}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateIndicadorResultado" data-toggle="modal" data-target="#modalUpdateIndicadorResultado" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteIndicadorResultado" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaIndicadorResultado').DataTable();
    });
</script>