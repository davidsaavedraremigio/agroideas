<table id="TablaDesembolso" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Nº Convenio</th>
            <th class="text-center">RUC</th>
            <th class="text-center">Razon social</th>
            <th class="text-center">Periodo</th>
            <th class="text-center">Mes</th>
            <th class="text-center">Importe</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->nro_contrato}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->periodo}}</small></td>
            <td class="text-center"><small>{{$fila->mes}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-danger btnDeleteImportDesembolsoSda" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaDesembolso').DataTable();
        });
</script>