<table id="TablaProcesoIniciativa" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Tipo Iniciativa</th>
            <th class="text-center">Area</th>
            <th class="text-center">Descripción del proceso</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_iniciativa}}</small></td>
            <td class="text-center"><small>{{$fila->area_sigla}}</small></td>
            <td class="text-upper"><small>{{$fila->proceso}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateProcesoIniciativa" data-toggle="modal" data-target="#modalUpdateProcesoIniciativa" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteProcesoIniciativa" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaProcesoIniciativa').DataTable();
    });
</script>