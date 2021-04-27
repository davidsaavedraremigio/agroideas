<table id="TablaCompromiso" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Descripción del compromiso</th>
            <th class="text-center">Responsable</th>
            <th class="text-center">Nº de OAS por identificar</th>
            <th class="text-center">Fecha límite</th>
            <th class="text-center">Estado actual</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($compromisos as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo}}</small></td>
            <td class="text-left"><small>{{$fila->compromiso}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-right"><small>{{$fila->prog_entidades}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_plazo)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->situacion}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateCompromiso" data-toggle="modal" data-target="#modalUpdateCompromiso" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-sm btn-danger btnDeleteCompromiso" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaCompromiso').DataTable({
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