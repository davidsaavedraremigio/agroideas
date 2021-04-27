<table id="TablaCapacitacion" class="table table-striped table-bordered">
    <thead class="bg-success">
        <tr>
            <th class="text-center">Nº</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Nombre del evento</th>
            <th class="text-center">Temática</th>
            <th class="text-center">Fecha del evento</th>
            <th class="text-center">Región</th>
            <th class="text-center">Provincia</th>
            <th class="text-center">Distrito</th>
            <th class="text-center">Nº de participantes</th>
            <th class="text-center">Especialista responsable</th>
            <th class="text-center">Costo del evento (S/.)</th>
            <th class="text-center">Estado</th>
            <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $keyNumber => $fila)
        <tr>
            <td class="text-center"><small>{{$keyNumber+1}}</small></td>
            <td class="text-center"><small>{{$fila->tipo_evento}}</small></td>
            <td class="text-uppercase"><small>{{$fila->nombre}}</small></td>
            <td class="text-center"><small>{{$fila->tematica}}</small></td>
            <td class="text-center"><small>{{ \Carbon\Carbon::parse($fila->fecha)->format('d/m/Y')}}</small></td>
            <td class="text-center"><small>{{$fila->region}}</small></td>
            <td class="text-center"><small>{{$fila->provincia}}</small></td>
            <td class="text-center"><small>{{$fila->distrito}}</small></td>
            <td class="text-center"><small>{{$fila->participantes}}</small></td>
            <td class="text-center"><small>{{$fila->responsable}}</small></td>
            <td class="text-right"><small>{{number_format($fila->importe,2)}}</small></td>
            <td class="text-center"><small>
                @if ($fila->codEstado == 1)
                    PROGRAMADO
                @else
                    EJECUTADO
                @endif
            </small></td>
            <td class="text-center">
                @if ($fila->codEstado == 1)
                <a href="{{URL::action('CapacitacionController@edit',$fila->id)}}" class="btn btn-sm btn-warning" title="Actualizar registro"><i class="fas fa-calendar-day"></i></a> 
                @endif
                <a href="{{env('APP_URL').'/formats/format_participantes_capacitacion.xlsx'}}" class="btn btn-sm btn-info" title="Descargar formato de registro de participantes"><i class="fas fa-file-download"></i></a>
            </td>
        </tr>    
        @endforeach
    </tbody>
</table>
@section('scripts')
<script>
        $(function () {
            $('#TablaCapacitacion').DataTable({
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