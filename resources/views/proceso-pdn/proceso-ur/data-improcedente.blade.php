<table id="TablaExpedienteImprocedente" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº Expediente</th>
            <th class="text-center">Nº RUC</th>
            <th class="text-center">Razon Social</th>
            <th class="text-center">Tipo de incentivo</th>
            <th class="text-center">Especialista</th>
            <th class="text-center">Area</th>
            <th class="text-center">Nº de documento</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Razón por la que se declara la improcedencia</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$fila->nro_expediente}}</small></td>
            <td class="text-center"><small>{{$fila->ruc}}</small></td>
            <td class="text-uppercase"><small>{{$fila->razon_social}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_incentivo}}</small></td>
            <td class="text-center"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->area}}</small></td>
            <td class="text-center"><small>{{$fila->nro_documento}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha_documento)->format('d/m/Y')}}</small></td>
            <td class="text-justify"><small>{{$fila->comentarios}}</small></td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
    $(function () {
        $('#TablaExpedienteImprocedente').DataTable({
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