<table id="TablaArea" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Sigla</small></th>
            <th class="text-center"><small>Nombre</small></th>
            <th class="text-center"><small>Estado</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->sigla}}</small></td>
            <td class="text-left"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center"><small>{{($fila->estado == 1)?'Vigente':'Dado de baja'}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateArea" data-toggle="modal" data-target="#modalUpdateArea" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteArea" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaArea').DataTable();
    });
</script>