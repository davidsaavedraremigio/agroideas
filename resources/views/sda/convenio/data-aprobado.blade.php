<table id="TablaConvenio" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº de Convenio</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">RUC</th>
            <th class="text-center">Razon Social</th>
            <th class="text-center">Ubigeo</th>
            <th class="text-center">Fecha de término</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Días por vencer</th>
            <th class="text-center" width="8%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_convenio}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->inicio)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->region}}/{{$fila->provincia}}/{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->termino)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
            <td class="text-center"><small>{{($fila->cod_estado == 3)?$fila->nro_dias:'0'}}</small></td>
            <td class="text-center">
                @if ($fila->cod_estado == 5)
                <a href="#" class="btn btn-sm btn-success" title="Proceso de cierre del convenio" id="btnmodalCreateProcesoCierre" data-toggle="modal" data-target="#modalCreateProcesoCierre" data-id="{{$fila->id}}"><i class="fas fa-toggle-off"></i></a> 
                @endif
                @if ($fila->cod_estado == 6)
                <a href="#" class="btn btn-sm btn-secondary" title="Cierre del convenio" id="btnmodalCreateCierre" data-toggle="modal" data-target="#modalCreateCierre" data-id="{{$fila->id}}"><i class="fas fa-shield-alt"></i></a>  
                @endif
                @if ($fila->cod_estado == 3)
                <a href="#" title="Generar adenda al convenio" class="btn btn-sm btn-primary" id="btnmodalCreateAdendaContrato" data-toggle="modal" data-target="#modalCreateAdendaContrato" data-id="{{$fila->id}}"><i class="fas fa-calendar-plus"></i></a> 
                @endif



                
                
                <!--<a href="#" title="Actualizar estado situacional" class="btn btn-sm btn-success" id="btnmodalUpdateEstadoContrato" data-toggle="modal" data-target="#modalUpdateEstadoContrato" data-id="{{$fila->id}}"><i class="fas fa-toggle-on"></i></a>-->
                
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaConvenio').DataTable();
    });
</script>