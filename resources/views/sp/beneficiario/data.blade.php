<table id="TablaBeneficiario" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Nro DNI</small></th>
            <th class="text-center"><small>Nombres y apellidos</small></th>
            <th class="text-center"><small>Fecha de nacimiento</small></th>
            <th class="text-center"><small>Sexo</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->dni}}</small></td>
            <td class="text-left"><small>{{$fila->nombres}} {{$fila->paterno}} {{$fila->materno}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fechaNacimiento)->format('d/m/Y')}}</small></td>
            <td class="text-center">{{($fila->sexo == 1)?'M':'F'}}<small></small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateBeneficiario" data-toggle="modal" data-target="#modalUpdateBeneficiario" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteBeneficiario" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaBeneficiario').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
</script>