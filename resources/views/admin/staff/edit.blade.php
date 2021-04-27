{!!Form::model($staff,['id'=>'FormUpdateStaff', 'method'=>'PATCH', 'files' => 'true', 'enctype' => 'multipart/form-data', 'route'=>['staff.update',$staff->id]])!!}
<div class="modal-header">
    <h4 class="modal-title">Actualizar registro</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- Panel para mostrar alertas --}}
    <div id="StaffAlerts" class="alert alert-danger" style="display: none;"></div>
    {{-- Panel para mostrar alertas --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('dni', 'Nº DNI') !!} {!! Form::text('dni', $staff->nroDni, ['class' => 'form-control', 'placeholder' => '00000000', 'id' => 'inputDni']) !!}</div>
            <div class="col-md-4">{!! Form::label('ruc', 'Nº RUC') !!} {!! Form::text('ruc', $staff->nroRuc, ['class' => 'form-control', 'placeholder' => '00000000000', 'id' => 'inputRuc', 'readonly' => 'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('fecha', 'Fecha nacimiento') !!} {!! Form::date('fecha', $staff->fechaNacimiento, ['class' => 'form-control', 'id' => 'inputFecha']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">{!! Form::label('nombres', 'Nombres') !!} {!! Form::text('nombres', $staff->nombres, ['class' => 'form-control', 'id' => 'inputNombres', 'readonly'    =>  'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('paterno', 'Apellido paterno') !!} {!! Form::text('paterno', $staff->paterno, ['class' => 'form-control', 'id' => 'inputPaterno', 'readonly' =>  'readonly']) !!}</div>
            <div class="col-md-4">{!! Form::label('materno', 'Apellido materno') !!} {!! Form::text('materno', $staff->materno, ['class' => 'form-control', 'id' => 'inputMaterno', 'readonly' =>  'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">{!! Form::label('direccion', 'Dirección') !!} {!! Form::text('direccion', $staff->direccion, ['class' => 'form-control', 'id'   => 'inputDireccion', 'readonly' =>  'readonly']) !!}</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">{!! Form::label('poliza', 'Nº Poliza') !!} {!! Form::text('poliza', $staff->nroPoliza, ['class' => 'form-control']) !!}</div>
            <div class="col-md-6">{!! Form::label('telefono', 'Nº Teléfono') !!} {!! Form::text('telefono', $staff->nroTelefono, ['class' => 'form-control']) !!}</div>
        </div>
    </div>    
</div>
<div class="modal-footer">
    <div id="Footer_UpdateStaff_Enabled">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cerrar</button>
        <a href="#" id="btnUpdateStaff" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Guardar cambios</a>
    </div>
    <div id="Footer_UpdateStaff_Disabled" style="display:none;">
        <a href="#" class="btn btn-default btn-sm" disabled><i class="fas fa-spinner fa-pulse fa-1x fa-fw"></i> Espere un momento, se está procesando la solicitud</a>
    </div>
</div>
{!! Form::close() !!}
<script>
    var urlApp          = "{{ env('APP_URL') }}";
    $("#inputDni").keypress(function(e) {
        var tecla = (e.keyCode ? e.keyCode : e.which);
        if (tecla == 13) 
        {
            var dni         =   $("#inputDni").val();
            var caracteres  =   dni.length;

            if (caracteres == 8)
            {
                event.preventDefault();
                var urlAction = urlApp+'/dni/'+dni;
                $.ajax({
                    url:    urlAction,
                    method: "GET",
                    data:   dni,
                    beforeSend: function() {
                        $("#inputRuc").val("Consultando ...");
                        $("#inputPaterno").val("Consultando ...");
                        $("#inputMaterno").val("Consultando ...");
                        $("#inputNombres").val("Consultando ...");
                        $("#inputFecha").val("Consultando ...");
                        $("#inputDireccion").val("Consultando ...");
                    },
                    success: function(response) {
                        var cadena      =   jQuery.parseJSON(response);
                        var estado      =   cadena.estado;

                        if (estado == 200) 
                        {
                            $("#inputRuc").val(cadena.ruc);
                            $("#inputPaterno").val(cadena.paterno);
                            $("#inputMaterno").val(cadena.materno);
                            $("#inputNombres").val(cadena.nombre);
                            $("#inputFecha").val("");
                            $("#inputDireccion").val(cadena.direccion);
                        }
                        else
                        {
                            alertify.error('El DNI consultado no figura en la base de datos.');
                            $("#inputRuc").val("");
                            $("#inputPaterno").val("");
                            $("#inputMaterno").val("");
                            $("#inputNombres").val("");
                            $("#inputFecha").val("");
                            $("#inputDireccion").val("");
                            $("#inputDni").val("");
                            $("#inputDni").focus();
                            return false;
                        }
                    },
                    statusCode: {
                        404: function() {
                            alertify.error('El sistema presenta problemas de funcionamiento.');
                        }
                    }
                });
            }
            else
            {
                alertify.error('Error. Ingrese un número de DNI válido.');
                $("#inputRuc").val("");
                $("#inputPaterno").val("");
                $("#inputMaterno").val("");
                $("#inputNombres").val("");
                $("#inputFecha").val("");
                $("#inputDireccion").val("");
                $("#inputDni").val("");
                $("#inputDni").focus();
                return false;
            } 
        }
    });
</script>