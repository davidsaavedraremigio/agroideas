<table id="TablaEntidad" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center"><small>Nº</small></th>
            <th class="text-center"><small>Nro RUC</small></th>
            <th class="text-center"><small>Razon social</small></th>
            <th class="text-center"><small>Tipo de entidad</small></th>
            <th class="text-center"><small>Región</small></th>
            <th class="text-center"><small>Provincia</small></th>
            <th class="text-center"><small>Distrito</small></th>
            <th class="text-center"><small>Dirección</small></th>
            <th class="text-center"><small>Estado SUNAT</small></th>
            <th class="text-center"><small>Fecha inscripción RRPP</small></th>
            <th class="text-center" width="12%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->nroDocumento}}</small></td>
            <td class="text-left"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->tipoEntidad}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-left"><small>{{$fila->direccion}}</small></td>
            <td class="text-center"><small>{{$fila->estadoContribuyente}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fechaRRPP)->format('d/m/Y')}}</small></td>
            <td class="text-center">
                <a href="{{URL::action('EntidadController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-edit"></i></a>
                <a href="#" class="btn btn-danger btn-sm btnDeleteEntidad" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
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