<table id="TablaResultadoProductor" class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th class="text-center"><small>Nº DNI</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Sexo</small></th>
            <th class="text-center"><small>Propietario / Consecionario</small></th>
            <th class="text-center"><small>Resultado</small></th>
            <th class="text-center"><small>Área final a reconvertir</small></th>
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
            <td class="text-center"><small>{{($fila->resultado == 1)?'Califica':'No califica'}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha_final,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateResultadoFinal" data-toggle="modal" data-target="#modalUpdateResultadoFinal" data-id="{{$fila->id}}"><i class="fas fa-user-check"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaResultadoProductor').DataTable();
        });
</script>