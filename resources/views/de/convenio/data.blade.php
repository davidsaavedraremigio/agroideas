<table id="TablaConvenioMarco" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Fecha de firma</small></th>
            <th class="text-center"><small>Nº RUC</small></th>
            <th class="text-center"><small>Nombre de la organización</small></th>
            <th class="text-center"><small>Región</small></th>
            <th class="text-center"><small>Provincia</small></th>
            <th class="text-center"><small>Distrito</small></th>
            <th class="text-center"><small>Objetivo</small></th>
            <th class="text-center"><small>Fecha de término</small></th>
            <th class="text-center"><small>Estado</small></th>
            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->numero}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_firma)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-justify"><small>{{$fila->objetivo}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_termino)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->estado}}</small></td>
            <td class="text-center">
                <a href="{{URL::action('ConvenioMarcoController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-edit"></i></a> 
                <a href="" class="btn btn-sm btn-primary" title="Registrar avances"><i class="fas fa-calendar-check"></i></a> 
                <a href="#" class="btn btn-danger btn-sm btnDeleteConvenioMarco" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaConvenioMarco').DataTable({
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