<table id="TablaProductorPrpa" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>DNI</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Edad</small></th>
            <th class="text-center"><small>Sexo</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center"><small>Latitud</small></th>
            <th class="text-center"><small>Longitud</small></th>
            <th class="text-center"><small>Nº Ha</small></th>
            <th class="text-center"><small>Importe (S/)</small></th>
            <th class="text-center" width="8%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->dni}}</small></td>
            <td class="text-left"><small>{{$fila->productor}}</small></td>
            <td class="text-center"><small>{{$fila->edad}}</small></td>
            <td class="text-center"><small>{{$fila->sexo}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_productor}}</small></td>
            <td class="text-center"><small>{{$fila->latitud}}</small></td>
            <td class="text-center"><small>{{$fila->longitud}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha_final,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->aporte,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateProductorPrpa" data-toggle="modal" data-target="#modalUpdateProductorPrpa" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteProductorPrpa" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaProductorPrpa').DataTable({
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