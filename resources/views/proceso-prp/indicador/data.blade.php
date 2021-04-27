<table id="TablaIndicadores" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Tipo de indicador</th>
            <th class="text-center">Descripción del indicador</th>
            <th class="text-center">U.M.</th>
            <th class="text-center">Linea de base</th>
            <th class="text-center">Meta</th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo}}</small></td>
            <td class="text-uppercase"><small>{{$fila->indicador}}</small></td>
            <td class="text-center"><small>{{$fila->unidad}}</small></td>
            <td class="text-right"><small>{{number_format($fila->valorLineaBase,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->valorMeta,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateIndicador" data-toggle="modal" data-target="#modalUpdateIndicador" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteIndicador" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>   
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaIndicadores').DataTable();
        });
</script>