<table id="TablaFormulacion" class="table table-sm table-bordered table-striped">
    <thead class="bg-success">
        <th class="text-center" width="8%"><small>Nº Expediente</small></th>
        <th class="text-center" width="8%"><small>Nº CUT</small></th>
        <th class="text-center"><small>Nº RUC</small></th>
        <th class="text-center" width="15%"><small>Nombre de la organización</small></th>
        <th class="text-center"><small>Cultivo a implementar</small></th>
        <th class="text-center"><small>Ubigeo</small></th>
        <th class="text-center"><small>Nº Has</small></th>
        <th class="text-center"><small>Nº Productores</small></th>
        <th class="text-center"><small>Responsable asignado</small></th>
        <th class="text-center" width="8%"><i class="fa fa-cog"></i></th>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-right"><small>{{number_format($fila->area,2)}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-center">
                @if ($fila->estado == 1)
                    <a href="{{URL::action('FormulacionController@edit',$fila->id)}}" class="btn btn-sm btn-primary" title="Información general"><i class="fas fa-address-card"></i></a>
                    <a href="#" class="btn btn-sm btn-success" id="btnmodalDerivaExpedienteUpfp" data-toggle="modal" data-target="#modalDerivaExpedienteUpfp" data-id="{{$fila->id}}" title="Derivar expediente"><i class="far fa-paper-plane"></i></a>
                @else
                    <a href="#" class="btn btn-sm btn-warning" title="Desbloquear información"><i class="fas fa-lock"></i></a>
                @endif
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaFormulacion').DataTable();
    });
</script>