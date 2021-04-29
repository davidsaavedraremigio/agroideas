<table id="TablaPendiente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº Expediente</th>
            <th class="text-center">Incentivo</th>
            <th class="text-center">Nº de CD</th>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Razon Social</th>
            <th class="text-center">Ubigeo</th>
            <th class="text-center">Cadena</th>
            <th class="text-center">Nº de beneficiarios</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        @if ($fila->nro_memo == NULL)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_incentivo}}</small></td>
            <td class="text-center"><small>{{$fila->nro_consejo_directivo}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_beneficiarios)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateContrato" data-toggle="modal" data-target="#modalCreateContrato" data-id="{{$fila->id}}"><i class="fas fa-folder-plus"></i></a>
            </td>
        </tr>    
        @endif
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaPendiente').DataTable();
    });
</script>