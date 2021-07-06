<table class="table table-bordered table-sm table-striped table-hover">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">Tipo de convenio</th>
            <th class="text-center" width="5%">Nº de convenio</th>
            <th class="text-center">Objetivo del convenio</th>
            <th class="text-center">Nombre de la institución</th>
            <th class="text-center">Coordinador AGROIDEAS</th>
            <th class="text-center">Departamento</th>
            <th class="text-center">Avances a la fecha</th>
            <th class="text-center">Estado actual</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->tipo}}</small></td>
            <td class="text-center"><small>{{$fila->nro_convenio}}</small></td>
            <td class="text-justify"><small>{{$fila->objetivo}}</small></td>
            <td class="text-center"><small>{{$fila->institucion}}</small></td>
            <td class="text-center"><small>{{$fila->especialista}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-justify"><small>{{$fila->resultados}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
        </tr>    
        @endforeach
    </tbody>
</table>