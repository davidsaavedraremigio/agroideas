<table id="TablaPendiente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Nº de Resolución</th>
            <th class="text-center">RUC</th>
            <th class="text-center">Razon Social</th>
            <th class="text-center">Ubigeo</th>
            <th class="text-center">Inversión PCC (S/.)</th>
            <th class="text-center">Inversión Entidad (S/.)</th>
            <th class="text-center">Inversión Total (S/.)</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->nro_rm}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion_pcc,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion_entidad,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion_total,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateContrato" data-toggle="modal" data-target="#modalCreateContrato" data-id="{{$fila->id}}"><i class="fas fa-folder-plus"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaPendiente').DataTable();
    });
</script>