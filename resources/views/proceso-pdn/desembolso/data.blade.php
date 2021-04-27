<table id="TablaDesembolso" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Nº Siaf</th>
            <th class="text-center">Nº de solicitud</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Importe</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->nroExpedienteSiaf}}</small></td>
            <td class="text-center"><small></small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fechaDesembolso)->format('d/m/Y')}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateDesembolsoSda" data-toggle="modal" data-target="#modalUpdateDesembolsoSda" data-id="{{$fila->id}}" title="Actualizar registros"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteDesembolsoSda" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
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