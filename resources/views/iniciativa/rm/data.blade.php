<table id="TablaExpediente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">RUC</th>
            <th class="text-center">Razon Social</th>
            <th class="text-center">Ubigeo</th>
            <th class="text-center">Oficina</th>
            <th class="text-center">Responsable</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->oficina}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateRm" data-toggle="modal" data-target="#modalCreateRm" data-id="{{$fila->id}}"><i class="fas fa-folder-plus"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaExpediente').DataTable();
    });
</script>