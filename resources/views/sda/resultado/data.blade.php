<table id="tabla-ejecucion" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Descripción del indicador</small></th>
            <th class="text-center"><small>U.M.</small></th>
            <th class="text-center"><small>Año 1</small></th>
            <th class="text-center"><small>Año 2</small></th>
            <th class="text-center"><small>Año 3</small></th>
            <th class="text-center"><small>Año 4</small></th>
            <th class="text-center"><small>Año 5</small></th>
            <th class="text-center" width="8%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-left"><small>{{$fila->indicador}}</small></td>
            <td class="text-center"><small>{{$fila->unidad}}</small></td>
            <td class="text-right"><small>{{number_format($fila->ejecucion_anio_1,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->ejecucion_anio_2,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->ejecucion_anio_3,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->ejecucion_anio_4,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->ejecucion_anio_5,2)}}</small></td>
            <td class="text-center">
                <a href="#" title="Editar información" class="btn btn-sm btn-warning" id="btnmodalUpdateResultado" data-toggle="modal" data-target="#modalUpdateResultado" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
            </td>
        </tr>  
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#tabla-ejecucion').DataTable();
    });
</script>