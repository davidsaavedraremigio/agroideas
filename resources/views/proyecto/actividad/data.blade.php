<table id="TablaActividad" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Componente</th>
            <th class="text-center">Descripción de la actividad</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
         <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-uppercase"><small>{{$fila->referencia}}</small></td>
            <td class="text-uppercase"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateComponente" data-toggle="modal" data-target="#modalUpdateComponente" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteComponente" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
         </tr>   
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaActividad').DataTable();
        });
</script>