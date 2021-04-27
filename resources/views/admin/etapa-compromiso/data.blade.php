<table id="TablaEtapa" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Tipo compromiso</small></th>
            <th class="text-center"><small>Descripcion de la etapa</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>    
    <tbody>
        @foreach ($etapas as $keyNumber => $fila)
         <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_compromiso}}</small></td>
            <td class="text-left"><small>{{$fila->descripcion}}</small></td>
             <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateEtapa" data-toggle="modal" data-target="#modalUpdateEtapa" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteEtapa" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
             </td>
         </tr>   
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaEtapa').DataTable();
        });
</script>