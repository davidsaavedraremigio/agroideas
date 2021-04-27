<table id="TablaConvenioImplementacion" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Descripción del compromiso</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Resultados</small></th>
            <th class="text-center"><small>Dificultades encontradas</small></th>
            <th class="text-center"><small>Propuestas de solución</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-left"><small>{{$fila->compromiso}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-justify"><small>{{$fila->resultados}}</small></td>
            <td class="text-justify"><small>{{$fila->dificultades}}</small></td>
            <td class="text-justify"><small>{{$fila->recomendaciones}}</small></td>
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
        $('#TablaConvenioImplementacion').DataTable();
    });
</script>