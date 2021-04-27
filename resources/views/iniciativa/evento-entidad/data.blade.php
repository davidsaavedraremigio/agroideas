<table id="TablaEntidad" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Tipo compromiso</th>
            <th class="text-center">Descripción del compromiso</th>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Nombre de la organización</th>
            <th class="text-center">Incentivo</th>
            <th class="text-center">Cadena propuesta</th>
            <th class="text-center">Nº productores</th>
            <th class="text-center">Nº Has</th>
            <th class="text-center">Inversión (S/)</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipoCompromiso}}</small></td>
            <td class="text-left"><small>{{$fila->compromiso}}</small></td>
            <td class="text-center"><small>{{$fila->nroDocumento}}</small></td>
            <td class="text-left"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->tipoIncentivo}}</small></td>
            <td class="text-center"><small>{{$fila->cadenaPropuesta}}</small></td>
            <td class="text-center"><small>{{$fila->nroProductores}}</small></td>
            <td class="text-right"><small>{{number_format($fila->nroHas,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion,2)}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateEntidad" data-toggle="modal" data-target="#modalUpdateEntidad" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteEntidad" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaEntidad').DataTable({
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