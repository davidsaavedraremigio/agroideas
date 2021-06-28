<div class="modal-header">
    <h4 class="modal-title">Items que conformarn el Informe de No Objeción</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-sm table-bordered table-striped">
        <thead class="bg-primary">
            <tr>
                <th class="text-center"><small>Tipo</small></th>
                <th class="text-center"><small>Concepto de gasto</small></th>
                <th class="text-center"><small>Nº RUC</small></th>
                <th class="text-center"><small>Razon social</small></th>
                <th class="text-center"><small>IFI</small></th>
                <th class="text-center"><small>Nº de cuenta</small></th>
                <th class="text-center"><small>Importe(S/.)</small></th>
                <th class="text-center"><i class="fa fa-cog"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $keyNumber => $fila)
            <tr>
                <td class="text-center"><small>{{$fila->tipo}}</small></td>
                <td class="text-left"><small>{{$fila->descripcion}}</small></td>
                <td class="text-center"><small>{{$fila->ruc}}</small></td>
                <td class="text-left"><small>{{$fila->razonSocial}}</small></td>
                <td class="text-center"><small>{{$fila->banco}}</small></td>
                <td class="text-center"><small>{{$fila->nroCuentaBancaria}}</small></td>
                <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
                <td class="text-center"><a href="#" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a></td>
            </tr>    
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
</div>
