<table id="TablaExtensionistaCapacitacion" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>DNI</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Edad</small></th>
            <th class="text-center"><small>Sexo</small></th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->dni}}</small></td>
            <td class="text-upper"><small>{{$fila->nombres}}</small></td>
            <td class="text-center"><small>{{$fila->edad}}</small></td>
            <td class="text-center"><small>{{($fila->sexo == 1)?'Masculino':'Femenino'}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateExtensionistaCapacitacion" data-toggle="modal" data-target="#modalUpdateExtensionistaCapacitacion" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteExtensionistaCapacitacion" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr> 
        @endforeach
    </tbody>
</table>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaExtensionistaCapacitacion').DataTable();
    });
</script>