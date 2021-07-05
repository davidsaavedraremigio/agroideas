<div class="modal-header">
    <h4 class="modal-title">Actividades registradas</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table id="TablaActividad" class="table table-striped table-bordered">
        <thead class="bg-success">
            <tr>
                <th class="text-center"><small>Nº</small></th>
                <th class="text-center"><small>Descripción de la actividad</small></th>
                <th class="text-center"><small>U.M.</small></th>
                <th class="text-center"><small>Precio Unitario (S/.)</small></th>
                <th class="text-center"><small>Meta física</small></th>
                <th class="text-center"><small>Meta financiera (S/.)</small></th>
                <th class="text-center"><small>Aporte PCC (S/.)</small></th>
                <th class="text-center"><small>Aporte OA (S/.)</small></th>
                <th class="text-center"><i class="fa fa-cog"></i></th>
            </tr>
            <tbody>
                @foreach ($data as $keyNumber => $fila)
                <tr>
                    <td class="text-center"><small>{{$fila->codigo}}</small></td>
                    <td class="text-uppercase"><small>{{$fila->descripcion}}</small></td>
                    <td class="text-center"><small>{{$fila->unidad}}</small></td>
                    <td class="text-right"><small>{{number_format($fila->precio,2)}}</small></td>
                    <td class="text-right"><small>{{number_format($fila->meta_fisica,2)}}</small></td>
                    <td class="text-right"><small>{{number_format($fila->meta_financiera,2)}}</small></td>
                    <td class="text-right"><small>{{number_format($fila->aporte_pcc,2)}}</small></td>
                    <td class="text-right"><small>{{number_format($fila->aporte_oa,2)}}</small></td>
                    <td class="text-center">
                        <a href="#" class="btn btn-sm btn-danger btnDeleteActividad" title="Eliminar registro" data-id="{{$fila->id}}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>    
                @endforeach
            </tbody>
        </thead>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
</div>





@section('scripts')
<script>
        $(function () {
            $('#TablaActividad').DataTable();
        });
</script>