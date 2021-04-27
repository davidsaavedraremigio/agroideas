<table id="TablaActividad" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Descripción de la actividad</th>
            <th class="text-center">U.M.</th>
            <th class="text-center">Precio unitario</th>
            <th class="text-center">Meta física</th>
            <th class="text-center">Meta financiera</th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-uppercase"><small>{{$fila->unidad}}</small></td>
            <td class="text-right"><small>{{number_format($fila->precio,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->metaFisica,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->metaFinanciera,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateActividad" data-toggle="modal" data-target="#modalUpdateActividad" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteActividad" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>   
        @endforeach
    </tbody>
</table>