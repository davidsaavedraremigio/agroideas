<table id="TablaPRP" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº Expediente</th>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Razón Social</th>
            <th class="text-center">Región</th>
            <th class="text-center">Provincia</th>
            <th class="text-center">Distrito</th>
            <th class="text-center">Cultivo a instalar</th>
            <th class="text-center">Área total a reconvertir (ha)</th>
            <th class="text-center">N° socios</th>
            <th class="text-center">Situación</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{number_format($fila->nro_ha, 2)}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
            <td class="text-center">
                @if ($fila->cod_estado!= 13 and $fila->cod_estado != 0)
                    <i class="fas fa-lock"></i>
                @else
                    <a href="{{URL::action('InicPRPController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm btnDeleteEvento" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
                @endif
            </td>
        </tr> 
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $('#TablaPRP').DataTable();
</script>