<table id="TablaEjecucionCompromiso" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Tipo compromiso</th>
            <th class="text-center">Descripción del compromiso</th>
            <th class="text-center">Nombre de la actividad</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Responsable</th>
            <th class="text-center">Resultados alcanzados</th>
            <th class="text-center">Observaciones / Comentarios</th>
            <th class="text-center">Evidencia</th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($resultados as $keyNumber => $fila)
            <tr>
                <td class="text-center"><small>{{$keyNumber+1}}</small></td>
                <td class="text-center"><small>{{$fila->tipoCompromiso}}</small></td>
                <td class="text-left"><small>{{$fila->compromiso}}</small></td>
                <td class="text-left"><small>{{$fila->etapa}}</small></td>
                <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
                <td class="text-center"><small>{{$fila->responsable}}</small></td>
                <td class="text-left"><small>{{$fila->resultados}}</small></td>
                <td class="text-left"><small>{{$fila->observaciones}}</small></td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></a>
                </td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-warning" id="btnmodalUpdateEjecucionCompromiso" data-toggle="modal" data-target="#modalUpdateEjecucionCompromiso" data-id="{{$fila->id}}"><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btnDeleteEjecucionCompromiso" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaEjecucionCompromiso').DataTable({
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