<table id="TablaFormulacion" class="table table-sm table-bordered table-striped">
    <thead>
        <th class="text-center"><small>Nº Expediente</small></th>
        <th class="text-center"><small>Nº CUT</small></th>
        <th class="text-center"><small>Nº RUC</small></th>
        <th class="text-center"><small>Nombre de la organización</small></th>
        <th class="text-center"><small>Cultivo a implementar</small></th>
        <th class="text-center"><small>Región</small></th>
        <th class="text-center"><small>Provincia</small></th>
        <th class="text-center"><small>Distrito</small></th>
        <th class="text-center"><small>Responsable asignado</small></th>
        <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-center">
                <a href="{{URL::action('FormulacionController@edit',$fila->id)}}" class="btn btn-sm btn-success" title="Formular proyecto"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-info" title="Bloquear expediente"><i class="fas fa-lock"></i></a>
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