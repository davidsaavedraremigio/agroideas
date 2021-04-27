<table id="TablaConvenioCoordinadorPcc" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Nº DNI</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Cargo</small></th>
            <th class="text-center"><small>Area</small></th>
            <th class="text-center"><small>Oficina</small></th>
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
            <td class="text-center"><small>{{$fila->area}}</small></td>
            <td class="text-center"><small>{{$fila->oficina}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateCoordinadorPcc" data-toggle="modal" data-target="#modalUpdateCoordinadorPcc" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteCoordinadorPcc" title="Dar de baja" data-id="{{$fila->id}}"><i class="fas fa-thumbs-down"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaConvenioCoordinadorPcc').DataTable();
    });
</script>