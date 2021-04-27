<table id="TablaExpediente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Fecha de presentación</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Nombre de la organización</small></th>
            <th class="text-center"><small>Región</small></th>
            <th class="text-center"><small>Provincia</small></th>
            <th class="text-center"><small>Distrito</small></th>
            <th class="text-center"><small>Cadena a trabajar</small></th>
            <th class="text-center"><small>Nº Ha</small></th>
            <th class="text-center"><small>Nº productores</small></th>
            <th class="text-center"><small>Area</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expediente as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{number_format($fila->nro_ha,2)}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-center"><small>{{$fila->area_sigla}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-success" id="btnmodalCreateExpedienteUaj" data-toggle="modal" data-target="#modalCreateExpedienteUaj" data-id="{{$fila->id}}" title="Recepcionar expediente"><i class="fas fa-inbox"></i></a>
                <a href="#" class="btn btn-sm bg-gray" id="btnmodalEvaluaExpedienteUaj" data-toggle="modal" data-target="#modalEvaluaExpedienteUaj" data-id="{{$fila->id}}" title="Evaluar expediente"><i class="fas fa-check-double"></i></a>
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalObservaExpedienteUaj" data-toggle="modal" data-target="#modalObservaExpedienteUaj" data-id="{{$fila->id}}" title="Devolver con observaciones"><i class="fas fa-exclamation-circle"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalDerivaExpedienteUaj" data-toggle="modal" data-target="#modalDerivaExpedienteUaj" data-id="{{$fila->id}}" title="Derivar expediente"><i class="fas fa-paper-plane"></i></a>
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