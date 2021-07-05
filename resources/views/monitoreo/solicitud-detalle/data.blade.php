<div class="modal-header">
    <h4 class="modal-title">Items que conformarn la solicitud de desembolso</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-sm table-bordered table-striped" id="TablaDetalleSolicitudDesembolso">
        <thead class="bg-primary">
            <tr>
                <th class="text-center"><small>Nº</small></th>
                <th class="text-center"><small>Tipo</small></th>
                <th class="text-center"><small>Actividad</small></th>
                <th class="text-center"><small>Item</small></th>
                <th class="text-center"><small>Nº RUC</small></th>
                <th class="text-center"><small>Razon social</small></th>
                <th class="text-center"><small>IFI</small></th>
                <th class="text-center"><small>Nº de CCI</small></th>
                <th class="text-center"><small>Importe(S/.)</small></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $keyNumber => $fila)
            <tr>
                <td class="text-center"><small>{{$keyNumber+1}}</small></td>
                <td class="text-center"><small>{{$fila->tipo}}</small></td>
                <td class="text-uppercase"><small>{{$fila->actividad}}</small></td>
                <td class="text-uppercase"><small>{{$fila->item}}</small></td>
                <td class="text-center"><small>{{$fila->ruc}}</small></td>
                <td class="text-uppercase"><small>{{$fila->razonSocial}}</small></td>
                <td class="text-center"><small>{{$fila->banco}}</small></td>
                <td class="text-center"><small>{{$fila->nroCCI}}</small></td>
                <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
</div>
@section('scripts')
<script>
    $('#TablaDetalleSolicitudDesembolso').DataTable();
</script>