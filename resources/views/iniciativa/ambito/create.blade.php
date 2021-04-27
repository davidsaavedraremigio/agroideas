{!! Form::open(array('id'=>'FormCreateUbigeo','url'=>'iniciativa/ambito','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="UbigeoAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    {!! Form::hidden('codigo', $postulante->id, ['class' => 'form-control']) !!}
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('descripcion', 'Descripción de referencia de la ubicación') !!} {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'rows' => '2', 'cols' => '2']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('region', 'Región (*)') !!}
                <select name="region" id="inputRegionUbigeo" class="form-control select2">
                    <option value="" selected>Seleccionar</option>
                    @foreach ($regiones as $fila)
                        <option value="{{$fila->id}}">{{$fila->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('provincia', 'Provincia (*)') !!}
                <select name="provincia" id="inputProvinciaUbigeo" class="form-control" disabled="disabled">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
            <div class="col-md-4">{!! Form::label('distrito', 'Distrito (*)') !!}
                <select name="distrito" id="inputDistritoUbigeo" class="form-control" disabled="disabled">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('latitud', 'Latitud (*)') !!} {!! Form::text('latitud', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('longitud', 'Longitud (*)') !!} {!! Form::text('longitud', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('principal', 'Ubicación principal?') !!}
                <select name="principal" class="form-control">
                    <option value="" selected>Seleccionar</option>
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
    </div>


</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateUbigeo_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateUbigeo" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateUbigeo_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
@section('scripts')
<script>
        var urlApp  = "{{ env('APP_URL') }}";
        $('.select2').select2({
            theme: 'bootstrap4'
        });
        $('#inputRegionUbigeo').on('change', function(e){
            console.log(e);
            var region_id = e.target.value;
            $.get(urlApp+'/ubigeo/provincia/'+region_id, function(data) {
                $("#inputProvinciaUbigeo").prop("disabled", false);
                $("#inputProvinciaUbigeo").empty();
                $("#inputProvinciaUbigeo").append('<option value="" selected="selected">Seleccionar</option>');
                $.each(data, function(index, provinciaObj) {
                    $("#inputProvinciaUbigeo").append('<option value="'+provinciaObj.id+'">'+provinciaObj.nombre+'</option>');
                })
            });
        });
        $('#inputProvinciaUbigeo').on('change', function(e){
            console.log(e);
            var provincia_id = e.target.value;
            $.get(urlApp+'/ubigeo/distrito/'+provincia_id, function(data) {
                // console.log(data);
                $("#inputDistritoUbigeo").prop("disabled", false);
                $("#inputDistritoUbigeo").empty();
                $("#inputDistritoUbigeo").append('<option value="" selected="selected">Seleccionar</option>');
                $.each(data, function(index, distritoObj) {
                    $("#inputDistritoUbigeo").append('<option value="'+distritoObj.id+'">'+distritoObj.nombre+'</option>');
                })
            });
        });
</script>