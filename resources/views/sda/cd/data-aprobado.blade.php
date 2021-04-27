<div class="modal-header">
    <h4 class="modal-title">Expedientes aprobados en el consejo directivo Nº</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-sm table-bordered table-striped">
        <thead class="bg-primary">
            <tr>
                <th class="text-center"><small>Nº Expediente</small></th>
                <th class="text-center"><small>Tipo</small></th>
                <th class="text-center"><small>Nº RUC</small></th>
                <th class="text-center"><small>Razon social</small></th>
                <th class="text-center"><small>Cadena</small></th>
                <th class="text-center"><small>Ubigeo</small></th>
                <th class="text-center"><small>Fecha de aprobación</small></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $keyNumber => $fila)
            <tr>
                <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
                <td class="text-center"><small>{{$fila->tipo_incentivo}}</small></td>
                <td class="text-center"><small>{{$fila->ruc}}</small></td>
                <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
                <td class="text-center"><small>{{$fila->cadena}}</small></td>
                <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
                <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_derivacion)->format('d/m/Y')}}</small></td>
            </tr>    
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
</div>
