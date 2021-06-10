@extends('layouts.template')
@section('title', 'Módulo para la formulación de PRPA')
@section('content')
{{-- Inicio del contenido--}}
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">@yield('title')</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div id="viewDataFormulacion" class="table-responsive"></div>
                </div>
            </div>
        </div>
    </section>
{{-- Modal para la creación de registros --}}
<div class="modal fade" id="modalDerivaExpedienteUpfp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn ">
            {{-- Inicio del contenido del modal --}}
            <div id="divFormDerivaExpedienteUpfp">
                <i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
                <span class="sr-only">Cargando...</span>
            </div>
            {{-- Fin del contenido del modal --}}
        </div>
    </div>		
</div> 


{{-- Término del contenido--}}
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        //1. Obtengo los datos generados
        $("#viewDataFormulacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
        $("#viewDataFormulacion").load(route("formulacion.data"));
        //2. Cargo los modals
        $('#modalDerivaExpedienteUpfp').on('show.bs.modal', function (e) {
            var codigo = $(e.relatedTarget).attr('data-id');
            $('#divFormDerivaExpedienteUpfp').load(route("formulacion.form-deriva-expediente", codigo));
        });
        //3. Proceso el formulario de registro
        $(document).on("click", '#btnDerivaExpedienteUpfp', function (event) {
            event.preventDefault();
            var form = $("#FormDerivaExpedienteUpfp");
            var urlAction = form.attr('action');
            var formData = new FormData(form[0]);
            var dataAll = form.serialize();
            $.ajax({
                url: urlAction,
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#Footer_DerivaExpedienteUpfp_Enabled").css("display", "none");
                    $("#Footer_DerivaExpedienteUpfp_Disabled").css("display", "block");
                },
                success: function (response) {
                    var mensaje = response.mensaje;
                    form[0].reset();
                    $("#Footer_DerivaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUpfp_Disabled").css("display", "none");
                    $("#modalDerivaExpedienteUpfp").modal('hide');
                    $("#viewDataFormulacion").html("<i class='fa fa-spinner fa-pulse fa-2x fa-fw'></i><span class='sr-only'>Cargando...</span><h5>Espere un momento por favor, obteniendo datos ...</h5>");
                    $("#viewDataFormulacion").load(route("formulacion.data"));
                    alertify.success(mensaje);
                },
                error: function (response) {
                    var errors = response.responseJSON;
                    var errorTitle = errors.message;
                    console.error(errorTitle);
                    var errorsHtml = '';
                    $.each(errors['errors'], function (index, value) {
                        errorsHtml += '<ul>';
                        errorsHtml += '<li>' + value + "</li>";
                        errorsHtml += '</ul>';
                    });
                    $("#DerivaExpedienteUpfpAlerts").css("display", "block");
                    $("#DerivaExpedienteUpfpAlerts").html('<h4><i class="icon fa fa-exclamation-triangle"></i> Error: ' + errorTitle + '</h4>' + errorsHtml);
                    $("#Footer_DerivaExpedienteUpfp_Enabled").css("display", "block");
                    $("#Footer_DerivaExpedienteUpfp_Disabled").css("display", "none");
                }
            });
        });
    });
</script>
@stop