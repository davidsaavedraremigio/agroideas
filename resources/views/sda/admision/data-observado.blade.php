<table id="TablaObservado" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razón Social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Nº Informe</small></th>
            <th class="text-center"><small>Nº Carta</small></th>
            <th class="text-center"><small>Fecha de observación</small></th>
            <th class="text-center"><small>Nº días transcurridos</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-uppercase"><small>{{$fila->responsable_evaluacion}}</small></td>
            <td class="text-center"><small>{{$fila->nro_informe}}</small></td>
            <td class="text-center"><small>{{$fila->nro_carta_observacion}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_carta_observacion)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small></small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-default" id="btnmodalSubsanaObservacionSda" data-toggle="modal" data-target="#modalSubsanaObservacionSda" data-id="{{$fila->id}}" title="Subsana observaciones"><i class="fas fa-clipboard-check"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaObservado').DataTable();
    });
</script>