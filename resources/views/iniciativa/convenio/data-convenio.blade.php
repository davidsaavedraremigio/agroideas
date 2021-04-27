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
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
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
             <td class="text-center"><small>{{($fila->cod_estado == 3)? $fila->nro_dias:'-'}}</small></td>
             <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateRm" data-toggle="modal" data-target="#modalUpdateRm" data-id="{{$fila->id}}"><i class="fas fa-folder-open"></i></a>
                <a href="#" class="btn btn-sm btn-primary" id="btnmodalCreateAmpliacion" data-toggle="modal" data-target="#modalCreateAmpliacion" data-id="{{$fila->id}}"><i class="fas fa-calendar-plus"></i></a>
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