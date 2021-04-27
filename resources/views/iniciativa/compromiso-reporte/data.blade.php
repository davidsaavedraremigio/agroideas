<table class="table table-bordered table-sm table-striped table-hover">
    <thead class="bg-success">
        <tr>
            <th class="text-center" width="5%"><small>Nº</small></th>
            <th class="text-center" width="10%"><small>REGIÓN</small></th>
            <th class="text-center"><small>ORIGEN DEL COMPROMISO</small></th>
            <th class="text-center"><small>TIPO DE COMPROMISO</small></th>
            <th class="text-center"><small>COMPROMISO</small></th>
            <th class="text-center" width="10%"><small>FECHA LÍMITE</small></th>
            <th class="text-center" width="10%"><small>ESTADO</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-uppercase"><small>{{$fila->origen}}</small></td>
            <td class="text-center"><small>{{$fila->tipo}}</small></td>
            <td class="text-justify"><small>{{$fila->compromiso}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_limite)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
        </tr>    
        @endforeach
    </tbody>
</table>