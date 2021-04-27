<table id="TablaRendicionDifusion" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Concepto de gasto</small></th>
            <th class="text-center"><small>Importe (S/)</small></th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-uppercase"><small>{{$fila->concepto}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateRendicionDifusion" data-toggle="modal" data-target="#modalUpdateRendicionDifusion" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteRendicionDifusion" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaRendicionDifusion').DataTable();
        });
</script>