<table id="TablaImplementacionCapacitacion" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center" width="20%"><small>Nombre del evento</small></th>
            <th class="text-center"><small>Temática</small></th>
            <th class="text-center"><small>Fecha del implementación</small></th>
            <th class="text-center"><small>Región</small></th>
            <th class="text-center"><small>Provincia</small></th>
            <th class="text-center"><small>Distrito</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_evento}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->tematica}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_rendicion)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-center">
                <a href="{{URL::action('CapacitacionEjecucionController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-edit"></i></a> 
            </td>
        </tr>  
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $('#TablaImplementacionCapacitacion').DataTable();
</script>