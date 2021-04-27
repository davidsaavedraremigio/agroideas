$(document).ready(function () {
    var root    =   window.location.host;
    var urlApp  =   "{{ env('APP_URL') }}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //2. Configuramos el buscador en los select
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    //3. Configuramos un combo dinamico para el ubigeo
    $('#inputRegion').on('change', function(e){
        console.log(e);
        var region_id = e.target.value;
        $.get(urlApp+'/ubigeo/provincia/'+region_id, function(data) {
            $("#inputProvincia").prop("disabled", false);
            $("#inputProvincia").empty();
            $("#inputProvincia").append('<option value="" selected="selected">Seleccionar</option>');
            $.each(data, function(index, provinciaObj) {
                $("#inputProvincia").append('<option value="'+provinciaObj.id+'">'+provinciaObj.nombre+'</option>');
            })
        });
    });
    $('#inputProvincia').on('change', function(e){
        console.log(e);
        var provincia_id = e.target.value;
        $.get(urlApp+'/ubigeo/distrito/'+provincia_id, function(data) {
            // console.log(data);
            $("#inputDistrito").prop("disabled", false);
            $("#inputDistrito").empty();
            $("#inputDistrito").append('<option value="" selected="selected">Seleccionar</option>');
            $.each(data, function(index, distritoObj) {
                $("#inputDistrito").append('<option value="'+distritoObj.id+'">'+distritoObj.nombre+'</option>');
            })
        });
    });
    //4.Configuramos un combo dinamico para la caracterizacion
    $('#inputSector').on('change', function(e){
        console.log(e);
        var sector_id = e.target.value;
        $.get(urlApp+'/tipologia/linea/'+sector_id, function(data) {
            $("#inputLinea").prop("disabled", false);
            $("#inputLinea").empty();
            $("#inputLinea").append('<option value="" selected="selected">Seleccionar</option>');
            $.each(data, function(index, lineaObj) {
                $("#inputLinea").append('<option value="'+lineaObj.id+'">'+lineaObj.descripcion+'</option>');
            })
        });
    });
    $('#inputLinea').on('change', function(e){
        console.log(e);
        var linea_id = e.target.value;
        $.get(urlApp+'/tipologia/cadena/'+linea_id, function(data) {
            $("#inputCadena").prop("disabled", false);
            $("#inputCadena").empty();
            $("#inputCadena").append('<option value="" selected="selected">Seleccionar</option>');
            $.each(data, function(index, cadenaObj) {
                $("#inputCadena").append('<option value="'+cadenaObj.id+'">'+cadenaObj.descripcion+'</option>');
            })
        });
    });    
    $('#inputCadena').on('change', function(e){
        console.log(e);
        var cadena_id = e.target.value;
        $.get(urlApp+'/tipologia/producto/'+cadena_id, function(data) {
            $("#inputProducto").prop("disabled", false);
            $("#inputProducto").empty();
            $("#inputProducto").append('<option value="" selected="selected">Seleccionar</option>');
            $.each(data, function(index, productoObj) {
                $("#inputProducto").append('<option value="'+productoObj.id+'">'+productoObj.descripcion+'</option>');
            })
        });
    }); 
});