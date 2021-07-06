<table id="TablaConvenioAmpliacion" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Fecha</small></th>
            <th class="text-center"><small>Tipo</small></th>
            <th class="text-center"><small>Objetivo</small></th>
            <th class="text-center"><small>Fecha de término</small></th>
            <th class="text-center" width="6%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->numero}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_firma)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->tipo}}</small></td>
            <td class="text-justify"><small>{{$fila->objetivo}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_termino)->format('d/m/Y')}}</small></td>
            <td class="text-center">
                <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateConvenioAmpliacion" data-toggle="modal" data-target="#modalUpdateConvenioAmpliacion" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaConvenioAmpliacion').DataTable({
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