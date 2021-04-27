<table id="TablaIndicadorActividad" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Codigo</small></th>
            <th class="text-center"><small>Referencia</small></th>
            <th class="text-center"><small>Descripcion del indicador</small></th>
            <th class="text-center"><small>U.M.</small></th>
            <th class="text-center"><small>Medio de verificacion</small></th>
            <th class="text-center"><small>Supuestos</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->codigo}}</small></td>
            <td class="text-uppercase"><small>{{$fila->referencia}}</small></td>
            <td class="text-uppercase"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center"><small>{{$fila->unidad}}</small></td>
            <td class="text-uppercase"><small>{{$fila->medioVerificacion}}</small></td>
            <td class="text-uppercase"><small>{{$fila->supuestos}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateIndicadorActividad" data-toggle="modal" data-target="#modalUpdateIndicadorActividad" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteIndicadorActividad" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaIndicadorActividad').DataTable();
        });
</script>