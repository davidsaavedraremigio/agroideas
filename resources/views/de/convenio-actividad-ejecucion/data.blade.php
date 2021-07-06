<table id="TablaConvenioActividadEjecucion" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Compromiso</small></th>
            <th class="text-center"><small>Nombre de la actividad</small></th>
            <th class="text-center"><small>Especialista responsable</small></th>
            <th class="text-center"><small>Fecha de reporte</small></th>
            <th class="text-center"><small>Meta programada</small></th>
            <th class="text-center"><small>Meta ejecutada</small></th>
            <th class="text-center"><small>Acciones</small></th>
            <th class="text-center"><small>Estado</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-left"><small>{{$fila->compromiso}}</small></td>
            <td class="text-left"><small>{{$fila->actividad}}</small></td>
            <td class="text-left"><small>{{$fila->responsable}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-right"><small>{{number_format($fila->metaFisica,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->metaEjecutada,2)}}</small></td>
            <td class="text-justify"><small>{{$fila->acciones}}</small></td>
            <td class="text-center"><small>{{$fila->situacion}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateConvenioActividadEjecucion" data-toggle="modal" data-target="#modalUpdateConvenioActividadEjecucion" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteConvenioActividadEjecucion" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaConvenioActividadEjecucion').DataTable();
    });
</script>