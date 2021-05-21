<table id="TablaCapacitacion" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center" width="20%"><small>Nombre del evento</small></th>
            <th class="text-center"><small>Temática</small></th>
            <th class="text-center"><small>Fecha del evento</small></th>
            <th class="text-center"><small>Región</small></th>
            <th class="text-center"><small>Provincia</small></th>
            <th class="text-center"><small>Distrito</small></th>
            <th class="text-center"><small>Nº de participantes</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Costo del evento (S/.)</small></th>
            <th class="text-center"><small>Estado</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_evento}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->tematica}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->participantes}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center"><small>{{($fila->codEstado == 1)?'Programado':'Reprogramado'}}</small></td>
            <td class="text-center">
                <a href="{{env('APP_URL').'/formats/format_participantes_capacitacion.xlsx'}}" class="btn btn-sm btn-primary" title="Descargar formato de registro de participantes"><i class="fas fa-arrow-circle-down"></i></a>
                <a href="{{route("capacitacion.edit", $fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="far fa-edit"></i></a> 
                <a href="#" class="btn btn-sm btn-success" title="Reprogramar Evento" id="btnmodalReprogramaCapacitacion" data-toggle="modal" data-target="#modalReprogramaCapacitacion" data-id="{{$fila->id}}"><i class="fas fa-calendar-alt"></i></a>
                <a href="#" class="btn btn-sm btn-danger" title="Cancelar Evento"  id="btnmodalCancelaCapacitacion" data-toggle="modal" data-target="#modalCancelaCapacitacion" data-id="{{$fila->id}}"><i class="far fa-calendar-times"></i></a>
                <a href="{{route("capacitacion-implementacion.create", $fila->id)}}" class="btn btn-sm btn-secondary" title="Implementación del evento"><i class="far fa-calendar-check"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $('#TablaCapacitacion').DataTable();
</script>