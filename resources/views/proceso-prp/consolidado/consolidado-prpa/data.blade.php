<table class="table table-bordered table-striped table-sm">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>FECHA DE INGRESO</small></th>
            <th class="text-center"><small>Nº DE CUT</small></th>
            <th class="text-center"><small>Nº EXPEDIENTE</small></th>
            <th class="text-center"><small>RUC</small></th>
            <th class="text-center"><small>NOMBRE DE LA ORGANIZACIÓN</small></th>
            <th class="text-center"><small>REGIÓN</small></th>
            <th class="text-center"><small>PROVINCIA</small></th>
            <th class="text-center"><small>DISTRITO</small></th>
            <th class="text-center"><small>CULTIVO A RECONVERTIR</small></th>
            <th class="text-center"><small>CULTIVO A INSTALAR</small></th>
            <th class="text-center"><small>AREA (Ha)</small></th>
            <th class="text-center"><small>Nº DE PRODUCTORES</small></th>
            <th class="text-center"><small>UBICACIÓN</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_ingreso)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->cultivo_inicial}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha,2)}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-center"><small>{{$fila->area}}</small></td>
        </tr>    
        @endforeach
    </tbody>
</table>