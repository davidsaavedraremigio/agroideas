<table id="TablaSda" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Razón Social</th>
            <th class="text-center">Región</th>
            <th class="text-center">Provincia</th>
            <th class="text-center">Distrito</th>
            <th class="text-center">Cadena productiva</th>
            <th class="text-center">Área (ha)</th>
            <th class="text-center">N° productores</th>
            <th class="text-center">Situación</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->cadena}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nro_ha,2)}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
            <td class="text-center">
                <a href="{{URL::action('InicSdaController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-danger btn-sm btnDeleteSda" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr> 
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaSda').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            dom: 'Bfrtip',
            buttons: [
                'print',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }
            ]
        });
    });
</script>