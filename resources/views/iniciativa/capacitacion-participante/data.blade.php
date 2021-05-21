<table id="TablaParticipanteCapacitacion" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">DNI</th>
            <th class="text-center">Nombres y apellidos</th>
            <th class="text-center">Edad</th>
            <th class="text-center">Actividad del productor</th>
            <th class="text-center">Actividad del participante</th>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Razon Social</th>
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