<table id="TablaPC" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Resultado esperado</th>
            <th class="text-center">Mes de inicio</th>
            <th class="text-center">Mes de término</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr> 
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-left"><small>{{$fila->resultadoEsperado}}</small></td>
            <td class="text-center"><small>{{$fila->inicio}}</small></td>
            <td class="text-center"><small>{{$fila->termino}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdatePC" data-toggle="modal" data-target="#modalUpdatePC" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeletePC" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaPC').DataTable();
        });
</script>