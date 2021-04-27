<div class="modal-header">
    <h4 class="modal-title">Resumen del proceso de admisión del PRP</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body table-responsive">
    <table id="TablaExpediente" class="table table-striped">
        <thead>
            <tr class="bg-primary">
                <th class="text-center"><small>Nombre de la OA</small></th>
                <th class="text-center"><small>Área origen</small></th>
                <th class="text-center"><small>Área destino</small></th>
                <th class="text-center"><small>Fecha recepción</small></th>
                <th class="text-center"><small>Tipo documento</small></th>
                <th class="text-center"><small>Nº documento</small></th>
                <th class="text-center"><small>Fecha documento</small></th>
                <th class="text-center"><small>Estado actual</small></th>
                <th class="text-center"><small>Evidencia</small></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $fila)
             <tr>
                <td class="text-center"><small>{{$fila->razon_social}}</small></td>
                <td class="text-center"><small>{{$fila->area_origen}}</small></td>
                <td class="text-center"><small>{{$fila->area_destino}}</small></td>
                <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_recepcion)->format('d/m/Y')}}</small></td>
                <td class="text-center"><small>{{$fila->tipo_documento}}</small></td>
                <td class="text-center"><small>{{$fila->nro_documento}}</small></td>
                <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_documento)->format('d/m/Y')}}</small></td>
                <td class="text-center"><small>{{$fila->estado}}</small></td>
                <td class="text-center">
                    <a href="{{ env('APP_URL_FILE') }}/{{$fila->evidencia}}" parent="_blank" class="btn btn-sm btn-succes"><i class="fas fa-download"></i></a>
                </td>
             </tr>   
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <div>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
    </div>
</div>