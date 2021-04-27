{!! Form::open(array('id'=>'FormCreateEntidadParticipante','url'=>'iniciativa/difusion-entidad-participante','method'=>'POST','autocomplete'=>'off')) !!}
<div class="modal-header">
    <h4 class="modal-title">Añadir nuevo registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="EntidadParticipanteAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <input type="hidden" name="codigo" value="{{$difusion->id}}">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('ruc', 'Nº de RUC') !!} {!! Form::text('ruc', '', ['class' => 'form-control', 'placeholder' => '00000000000']) !!}</div>
            <div class="col-md-8">{!! Form::label('tipo_entidad', 'Tipo de entidad') !!}
                <select name="tipo_entidad" class="form-control select2">
                    <option value="" selected="selected">Seleccionar</option>
                    @foreach ($tipo_entidad as $fila)
                        <option value="{{$fila->Orden}}">{{$fila->Nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">{!! Form::label('razon_social', 'Razón social') !!} {!! Form::text('razon_social', '', ['class' => 'form-control']) !!}</div>
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
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección') !!} {!! Form::text('direccion', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('nombre_contacto', 'Nombre de la persona de contacto') !!} {!! Form::text('nombre_contacto', '', ['class' => 'form-control']) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-4">{!! Form::label('cargo', 'Cargo que ocupa') !!} {!! Form::text('cargo', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('telefono', 'Nº de teléfono') !!} {!! Form::text('telefono', '', ['class' => 'form-control']) !!}</div>
            <div class="col-md-4">{!! Form::label('email', 'Email') !!} {!! Form::email('email', '', ['class' => 'form-control']) !!}</div>
        </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <div id="Footer_CreateEntidadParticipante_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnCreateEntidadParticipante" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_CreateEntidadParticipante_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    var urlApp          = "{{ env('APP_URL') }}";
    //1. Validamos la información del DNI
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
            $("#inputDistritoUbigeo").prop("disabled", false);
            $("#inputDistritoUbigeo").empty();
            $("#inputDistritoUbigeo").append('<option value="" selected="selected">Seleccionar</option>');
            $.each(data, function(index, distritoObj) {
                $("#inputDistritoUbigeo").append('<option value="'+distritoObj.id+'">'+distritoObj.nombre+'</option>');
            })
        });
    });

</script>