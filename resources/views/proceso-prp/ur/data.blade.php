<table id="TablaExpediente" class="table table-sm table-bordered table-striped">
    <thead>
        <tr class="bg-success">
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Nº CUT</small></th>
            <th class="text-center"><small>Fecha de presentación</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Nombre de la organización</small></th>
            <th class="text-center"><small>Cultivo a implementar</small></th>
            <th class="text-center"><small>Area (Has)</small></th>
            <th class="text-center"><small>Nº beneficiarios</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expediente as $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_recepcion)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha,2)}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-success" id="btnmodalUpdateExpedienteUR" data-toggle="modal" data-target="#modalUpdateExpedienteUR" data-id="{{$fila->id}}" title="Evaluar expediente"><i class="fas fa-check-double"></i></a>
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalObservaExpedienteUR" data-toggle="modal" data-target="#modalObservaExpedienteUR" data-id="{{$fila->id}}" title="Realizar Observaciones"><i class="fas fa-exclamation-circle"></i></a>
                <a href="#" class="btn btn-sm btn-danger" id="btnmodalArchivaExpedienteUR" data-toggle="modal" data-target="#modalArchivaExpedienteUR" data-id="{{$fila->id}}" title="Archivar expediente"><i class="fas fa-thumbs-down"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalDerivaExpedienteUr" data-toggle="modal" data-target="#modalDerivaExpedienteUr" data-id="{{$fila->id}}" title="Derivar expediente"><i class="fas fa-paper-plane"></i></a>
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