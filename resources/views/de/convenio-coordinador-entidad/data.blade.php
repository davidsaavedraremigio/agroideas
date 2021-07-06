<table id="TablaConvenioCoordinadorEntidad" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Nº DNI</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Cargo</small></th>
            <th class="text-center"><small>Documento de designación</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->dni}}</small></td>
            <td class="text-center"><small>{{($fila->tipo ==1)?'Titular':'Suplente'}}</small></td>
            <td class="text-center"><small>{{$fila->nombres}}</small></td>
            <td class="text-center"><small>{{$fila->cargo}}</small></td>
            <td class="text-center"><small>{{$fila->referencia}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateCoordinadorEntidad" data-toggle="modal" data-target="#modalUpdateCoordinadorEntidad" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteCoordinadorEntidad" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaConvenioCoordinadorEntidad').DataTable();
    });
</script>