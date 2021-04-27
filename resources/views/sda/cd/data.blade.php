<table id="TablaConsejoDirectivo" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Descripción</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->numero}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-uppercase"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center">
                <a href="#" title="Editar información" class="btn btn-sm btn-warning" id="btnmodalUpdateCd" data-toggle="modal" data-target="#modalUpdateCd" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" title="Asignar entidades al Consejo directivo" class="btn btn-sm btn-primary" id="btnmodalAsignaSda" data-toggle="modal" data-target="#modalAsignaSda" data-id="{{$fila->id}}"><i class="fas fa-user-plus"></i></a>
                <a href="#" title="Mostrar entidades asignadas" class="btn btn-sm btn-success" id="btnmodalSda" data-toggle="modal" data-target="#modalSda" data-id="{{$fila->id}}"><i class="fas fa-users"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaConsejoDirectivo').DataTable();
    });
</script>