<table id="TablaEvaluacionCampo" class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th class="text-center"><small>Nº DNI</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Sexo</small></th>
            <th class="text-center"><small>Propietario / Consecionario</small></th>
            <th class="text-center"><small>Latitud</small></th>
            <th class="text-center"><small>Longitud</small></th>
            <th class="text-center"><small>Altitud (msnm)</small></th>
            <th class="text-center"><small>Área a reconvertir solicitada (ha)</small></th>
            <th class="text-center"><small>Área a reconvertir - plano (ha)</small></th>
            <th class="text-center"><small>Área bajo riego (ha)</small></th>
            <th class="text-center"><small>Resultado de la verificación de campo</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->dni}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</small></td>
            <td class="text-center"><small>{{($fila->sexo == 0)?'FEMENINO':'MASCULINO'}}</small></td>
            <td class="text-center"><small>{{($fila->tipoPropietario == 1)?'PROPIETARIO':'POSESIONARIO'}}</small></td>
            <td class="text-right"><small>{{$fila->latitud}}</small></td>
            <td class="text-right"><small>{{$fila->longitud}}</small></td>
            <td class="text-right"><small>{{$fila->altitud}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha_plano,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha_riego,2)}}</small></td>
            <td class="text-center"><small>{{($fila->eval_campo == 1)?'Favorable':'No aplica'}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateEvaluacionCampo" data-toggle="modal" data-target="#modalUpdateEvaluacionCampo" data-id="{{$fila->id}}"><i class="fas fa-user-check"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaEvaluacionCampo').DataTable();
        });
</script>