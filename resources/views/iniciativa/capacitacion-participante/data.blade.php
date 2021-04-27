<table id="TablaParticipanteCapacitacion" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>DNI</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Edad</small></th>
            <th class="text-center"><small>Actividad del Productor</small></th>
            <th class="text-center"><small>Actividad del Participante</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Razon social</small></th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->dni}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</small></td>
            <td class="text-center"><small>{{$fila->edad}}</small></td>
            <td class="text-center"><small>{{$fila->actividad_productor}}</small></td>
            <td class="text-center"><small>{{$fila->actividad_participante}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateParticipanteCapacitacion" data-toggle="modal" data-target="#modalUpdateParticipanteCapacitacion" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteParticipanteCapacitacion" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaParticipanteCapacitacion').DataTable();
    });
</script>