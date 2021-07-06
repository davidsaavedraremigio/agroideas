<table id="TablaConvenioPostulante" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº Convenio</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center"><small>RUC</small></th>
            <th class="text-center"><small>Razon social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Inversión PCC (S/.)</small></th>
            <th class="text-center"><small>Estado</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_contrato}}</small></td>
            <td class="text-center"><small>{{$fila->tipo}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}} / {{$fila->provincia}} / {{$fila->distrito}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion_pcc,2)}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-danger btnDeleteCompromisoPostulante" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaConvenioPostulante').DataTable();
    });
</script>