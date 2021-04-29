<table id="TablaAprobado" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº Expediente</small></th>
            <th class="text-center"><small>Incentivo</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razon social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Nro Informe</small></th>
            <th class="text-center"><small>Nro Carta</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Fecha de derivacion</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_incentivo}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->responsable_evaluacion}}</small></td>
            <td class="text-center"><small>{{$fila->nro_informe}}</small></td>
            <td class="text-center"><small>{{$fila->nro_carta_aprobacion}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_carta_aprobacion)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_derivacion)->format('d/m/Y')}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateProductor" data-toggle="modal" data-target="#modalCreateProductor" data-id="{{$fila->id}}" title="Añadir productor"><i class="fas fa-user-plus"></i></a>
                <a href="#" class="btn btn-sm btn-success" id="btnmodalDataProductor" data-toggle="modal" data-target="#modalDataProductor" data-id="{{$fila->id}}" title="Beneficiarios del Proyecto"><i class="fas fa-users"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaAprobado').DataTable();
    });
</script>