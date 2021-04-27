<table id="TablaExpediente" class="table table-striped table-bordered">
    <thead>
        <th class="text-center"><small>Nº Expediente</small></th>
        <th class="text-center"><small>Nº CUT</small></th>
        <th class="text-center"><small>Nombre de la organización</small></th>
        <th class="text-center"><small>Fecha de recepción</small></th>
        <th class="text-center"><small>Area origen</small></th>
        <th class="text-center"><small>Tipo de documento</small></th>
        <th class="text-center"><small>Nº de documento</small></th>
        <th class="text-center"><small>Fecha de documento</small></th>
        <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
    </thead>
    <tbody>
        @foreach ($documentos as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_recepcion)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->area_origen}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_documento}}</small></td>
            <td class="text-center"><small>{{$fila->nro_documento}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_documento)->format('d/m/Y')}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-info" id="btnmodalCreateExpedienteDe" data-toggle="modal" data-target="#modalCreateExpedienteDe" data-id="{{$fila->id}}" title="Derivar expediente"><i class="fas fa-folder-plus"></i></a>    
                <a href="#" class="btn btn-sm btn-success" id="btnmodalMonitoreoExpedienteDe" data-toggle="modal" data-target="#modalMonitoreoExpediente" data-id="{{$fila->cod_expediente}}" title="Visualizar historial"><i class="far fa-folder-open"></i></a>
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