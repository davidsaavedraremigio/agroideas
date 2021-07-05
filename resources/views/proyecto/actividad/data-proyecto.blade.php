<table id="TablaProyecto" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">Nº Convenio</th>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Razon Social</th>
            <th class="text-center">Región</th>
            <th class="text-center">Cadena</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_contrato}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateActividad" data-toggle="modal" data-target="#modalCreateActividad" data-id="{{$fila->id}}" title="Añadir Actividad"><i class="far fa-plus-square"></i></a>
                <a href="#" class="btn btn-sm btn-success" id="btnmodalDataActividad" data-toggle="modal" data-target="#modalDataActividad" data-id="{{$fila->id}}" title="Actividades correspondientes al Proyecto"><i class="far fa-list-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaProyecto').DataTable();
    });
</script>