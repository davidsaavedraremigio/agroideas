<table id="TablaProceso" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Módulo</small></th>
            <th class="text-center"><small>Nombre</small></th>
            <th class="text-center"><small>Descripción</small></th>
            <th class="text-center"><small>Ruta</small></th>
            <th class="text-center"><small>Icono</small></th>
            <th class="text-center"><small>Estado</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($procesos as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->modulo}}</small></td>
            <td class="text-left"><small>{{$fila->nombre}}</small></td>
            <td class="text-left"><small>{{$fila->descripcion}}</small></td>
            <td class="text-center"><small>{{$fila->ruta}}</small></td>
            <td class="text-center"><i class="fa {{$fila->icono}}"></i></td>
            <td class="text-center"><small>{{($fila->estado == 1)?'Habilitado':'Deshabilitado'}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateProceso" data-toggle="modal" data-target="#modalUpdateProceso" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteProceso" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaProceso').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
</script>