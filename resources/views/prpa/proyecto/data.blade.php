<table id="tabla-proyecto" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº Convenio</th>
            <th class="text-center" width="10%">Tipo de incentivo</th>
            <th class="text-center">RUC</th>
            <th class="text-center">Razon social</th>
            <th class="text-center" width="5%">Región</th>
            <th class="text-center" width="5%">Provincia</th>
            <th class="text-center" width="5%">Distrito</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_convenio}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_incentivo}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
            <td class="text-center">
                <a href="{{route("proyecto-prpa.edit", $fila->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pen-square"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#tabla-proyecto').DataTable();
    });
</script>