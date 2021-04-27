<table id="TablaEntidadDifusion" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Razon Social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Persona de contacto</small></th>
            <th class="text-center"><small>Cargo</small></th>
            <th class="text-center"><small>Nº de teléfono</small></th>
            <th class="text-center"><small>Email</small></th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razonSocial}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombreContacto}}</small></td>
            <td class="text-center"><small>{{$fila->cargoContacto}}</small></td>
            <td class="text-center"><small>{{$fila->telefono}}</small></td>
            <td class="text-center"><small>{{$fila->email}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateEntidadParticipante" data-toggle="modal" data-target="#modalUpdateEntidadParticipante" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteEntidadParticipante" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaEntidadDifusion').DataTable();
        });
</script>