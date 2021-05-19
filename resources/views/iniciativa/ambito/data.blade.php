<table id="TablaUbigeo" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Región</th>
            <th class="text-center">Provincia</th>
            <th class="text-center">Distrito</th>
            <th class="text-center">Latitud</th>
            <th class="text-center">Longitud</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>        
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->latitud}}</small></td>
            <td class="text-center"><small>{{$fila->longitud}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateUbigeo" data-toggle="modal" data-target="#modalUpdateUbigeo" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteUbigeo" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaUbigeo').DataTable();
        });
</script>