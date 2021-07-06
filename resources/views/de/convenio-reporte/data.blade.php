<table class="table table-bordered table-sm table-striped table-hover">
    <thead class="bg-primary">
        <tr>
            <th class="text-center" width="5%"><small>Nº de convenio</small></th>
            <th class="text-center" width="10%"><small>Año suscripción</small></th>
            <th class="text-center"><small>Nombre de la institución</small></th>
            <th class="text-center"><small>Nº de adendas</small></th>
            <th class="text-center"><small>Dirección</small></th>
            <th class="text-center"><small>Región</small></th>
            <th class="text-center"><small>Nº de CUT</small></th>
            <th class="text-center"><small>Representante legal</small></th>
            <th class="text-center"><small>Cargo</small></th>
            <th class="text-center"><small>Fecha de firma</small></th>
            <th class="text-center"><small>Fecha de conclusión</small></th>
            <th class="text-center"><small>Coordinador titular PCC</small></th>
            <th class="text-center"><small>Coordinador alterno PCC</small></th>
            <th class="text-center"><small>Coordinador titular contraparte</small></th>
            <th class="text-center"><small>Coordinador suplente contraparte</small></th>
            <th class="text-center"><small>Documento de designación contraparte</small></th>
            <th class="text-center"><small>Presupuesto (S/.)</small></th>
            <th class="text-center"><small>Acciones realizadas</small></th>
            <th class="text-center"><small>Nº días pendientes</small></th>
            <th class="text-center"><small>Estado actual</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_convenio}}</small></td>
            <td class="text-center"><small>{{$fila->periodo}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->nro_adenda}}</small></td>
            <td class="text-uppercase"><small>{{$fila->direccion}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->nro_cut}}</small></td>
            <td class="text-center"><small>{{$fila->rl_nombre}}</small></td>
            <td class="text-center"><small>{{$fila->rl_cargo}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_firma)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_termino)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->coordinador_pcc_titular}}</small></td>
            <td class="text-center"><small>{{$fila->coordinador_pcc_suplente}}</small></td>
            <td class="text-center"><small>{{$fila->coordinador_entidad_titular}}</small></td>
            <td class="text-center"><small>{{$fila->coordinador_entidad_suplente}}</small></td>
            <td class="text-center"><small>{{$fila->referencia}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center"><small></small></td>
            <td class="text-center"><small>{{$fila->nro_dias_pendientes}}</small></td>
            <td class="text-center"><small>{{$fila->estado_situacional}}</small></td>
        </tr>
        @endforeach
    </tbody>
</table>