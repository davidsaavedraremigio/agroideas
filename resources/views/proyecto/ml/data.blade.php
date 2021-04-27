<table id="TablaMl" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>RUC</small></th>
            <th class="text-center"><small>Razon social</small></th>
            <th class="text-center"><small>Inicio</small></th>
            <th class="text-center"><small>Término</small></th>
            <th class="text-center"><small>Fin</small></th>
            <th class="text-center"><small>Propósito</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $fila)
        <tr>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razonSocial}}</small></td>
            <td class="text-center"><small>{{$fila->periodoInicio}}</small></td>
            <td class="text-center"><small>{{$fila->periodoFin}}</small></td>
            <td class="text-uppercase"><small>{{$fila->Fin}}</small></td>
            <td class="text-uppercase"><small>{{$fila->Proposito}}</small></td>
            <td class="text-center">
                <a href="{{URL::action('MLProyectoController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-edit"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>