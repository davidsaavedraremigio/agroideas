<table id="TablaUsuario" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Nro. DNI</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Area</small></th>
            <th class="text-center"><small>Cargo</small></th>
            <th class="text-center"><small>Oficina</small></th>
            <th class="text-center"><small>Usuario</small></th>
            <th class="text-center"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->dni}}</small></td>
            <td class="text-left"><small>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</small></td>
            <td class="text-center"><small>{{$fila->area}}</small></td>
            <td class="text-center"><small>{{$fila->cargo}}</small></td>
            <td class="text-center"><small>{{$fila->oficina}}</small></td>
            <td class="text-center"><small>{{$fila->email}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-info" id="btnmodalUpdatePassword" data-toggle="modal" data-target="#modalUpdatePassword" data-id="{{$fila->id}}" title="Generar nueva contraseña"><i class="fas fa-shield-alt"></i></a>
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateUsuario" data-toggle="modal" data-target="#modalUpdateUsuario" data-id="{{$fila->id}}" title="Actualizar registro"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteUsuario" title="Realizar baja de usuario" data-id="{{$fila->id}}"><i class="fas fa-thumbs-down"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $('#TablaUsuario').DataTable();
</script>