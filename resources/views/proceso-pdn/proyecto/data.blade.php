<table id="TablaProyecto" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Razon Social</th>
            <th class="text-center">Nº Contrato</th>
            <th class="text-center">Titulo del proyecto</th>
            <th class="text-center">Duración</th>
            <th class="text-center">Inicio</th>
            <th class="text-center">Término</th>
            <th class="text-center">Nº de beneficiarios</th>
            <th class="text-center">Inversión PCC</th>
            <th class="text-center">Inversión OA</th>
            <th class="text-center">Inversión Total</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->nroContrato}}</small></td>
            <td class="text-uppercase"><small>{{$fila->titulo}}</small></td>
            <td class="text-center"><small>{{$fila->duracion}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_inicio)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_termino)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->nro_beneficiarios}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion_pcc,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion_entidad,2)}}</small></td>
            <td class="text-right"><small>{{number_format($fila->inversion_total,2)}}</small></td>
            <td class="text-center">
                <a href="{{URL::action('ProyectoSdaController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-edit"></i></a> 
            </td>
        </tr>     
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaProyecto').DataTable({
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