<table id="tablaExpediente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº de expediente</small></th>
            <th class="text-center"><small>Nº de RUC</small></th>
            <th class="text-center"><small>Razón social</small></th>
            <th class="text-center"><small>Ubigeo</small></th>
            <th class="text-center"><small>Cultivo/Crianza</small></th>
            <th class="text-center"><small>Nº beneficiarios</small></th>
            <th class="text-center"><small>Fecha de recepción</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expediente as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_recepcion)->format('d/m/Y')}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-success" id="btnmodalAdmiteExpedienteUpfp" data-toggle="modal" data-target="#modalAdmiteExpedienteUpfp" data-id="{{$fila->id}}" title="Recepcionar expediente"><i class="fas fa-inbox"></i></a>
                <a href="{{URL::action('ExpedienteController@editInformeUpfp',$fila->id)}}" class="btn btn-sm bg-gray" title="Registrar calificaciones"><i class="fas fa-check-double"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalDerivaExpedienteUpfp" data-toggle="modal" data-target="#modalDerivaExpedienteUpfp" data-id="{{$fila->id}}" title="Derivar expediente"><i class="fas fa-paper-plane"></i></a>
                <a href="#" class="btn btn-sm btn-danger" id="btnmodalArchivaExpedienteUpfp" data-toggle="modal" data-target="#modalArchivaExpedienteUpfp" data-id="{{$fila->id}}" title="Archivar expediente"><i class="fas fa-thumbs-down"></i></a>
<!--
                
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalObservaExpedienteUpfp" data-toggle="modal" data-target="#modalObservaExpedienteUpfp" data-id="{{$fila->id}}" title="Devolver con observaciones"><i class="fas fa-exclamation-circle"></i></a>
                <a href="#" class="btn btn-sm btn-danger" id="btnmodalArchivaExpedienteUpfp" data-toggle="modal" data-target="#modalArchivaExpedienteUpfp" data-id="{{$fila->id}}" title="Archivar expediente"><i class="fas fa-thumbs-down"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalDerivaExpedienteUpfp" data-toggle="modal" data-target="#modalDerivaExpedienteUpfp" data-id="{{$fila->id}}" title="Derivar expediente"><i class="fas fa-paper-plane"></i></a>
-->
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#tablaExpediente').DataTable();
    });
</script>