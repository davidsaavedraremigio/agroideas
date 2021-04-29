<table id="TablaPendiente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Fecha de recepción</small></th>
            <!--<th class="text-center"><small>Nº Carta Elegibilidad</small></th>-->
            <th class="text-center"><small>Tipo de incentivo</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razon Social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Especialista asignado</small></th>
            
            <th class="text-center"><small>Nº días</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_recepcion)->format('d/m/Y')}}</small></td>
            <!--<td class="text-center"><small></small></td>-->
            <td class="text-center"><small>{{$fila->tipo_incentivo}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-uppercase"><small>{{$fila->responsable_evaluacion}}</small></td>
            <td class="text-center"><small>{{$fila->nro_dias}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-success" id="btnmodalCreateExpedienteUn" data-toggle="modal" data-target="#modalCreateExpedienteUn" data-id="{{$fila->id}}" title="Recepcionar expediente"><i class="fas fa-inbox"></i></a>
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalObservaExpedienteUn" data-toggle="modal" data-target="#modalObservaExpedienteUn" data-id="{{$fila->id}}" title="Devolver con observaciones"><i class="fas fa-exclamation-circle"></i></a>
                <a href="#" class="btn btn-sm btn-danger" id="btnmodalArchivaExpedienteUn" data-toggle="modal" data-target="#modalArchivaExpedienteUn" data-id="{{$fila->id}}" title="Archivar expediente"><i class="fas fa-thumbs-down"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalDerivaExpedienteUn" data-toggle="modal" data-target="#modalDerivaExpedienteUn" data-id="{{$fila->id}}" title="Derivar expediente"><i class="fas fa-paper-plane"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaPendiente').DataTable();
    });
</script>