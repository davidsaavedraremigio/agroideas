<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <style>
            /** Define el estilo del texto en el documento y el tamaño de letra por defecto **/
            @page {
                margin: 0cm 0cm;
                font-family: "Arial Narrow", sans-serif;
                font-size: 9pt;
            }
            /** Define ahora los márgenes reales de cada página en el PDF **/
            body {
                margin-top: 2cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 2cm;
            }
            /** Define las reglas del header **/
            header {
                position: fixed;
                top: 0cm;
                left: 1cm;
                right: 1cm;
                height: 2cm;

                /** Estilos adicionales solicitados por el área usuaria **/
                font-family: Arial, sans-serif;
                font-size: 9pt;
                color: #333333;
                line-height: 1cm;
            }
            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 1cm; 
                right: 1cm;
                height: 2cm;
                /** Estilos adicionales solicitados por el área usuaria **/
                font-family: "Arial Narrow", sans-serif;
                font-size: 7pt;
            }
            /** Defino la estructura de columnas **/
            .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
                border:0;
                padding:0;
                margin-left:-0.00001;
            }
            /** Define la alineción de los textos **/
            .text-center { text-align: center; } .text-right { text-align: right; } .text-left { text-align: left; } .text-justify {text-align: justify;} .text-uppercase {text-transform: uppercase;}
            /** Obtengo el numero de la pagina **/
            .pagenum:before {
                content: counter(page);
            }
            /** Define el estilo de los titulos del Proyecto **/
            .miniTitulo{
                font-family: Arial, sans-serif;
                font-size: 7pt; 
                font-weight: bold;
                color: #000000;
            }
            .granTitulo{
                font-family: Arial, sans-serif;
                font-size: 11pt;
                font-weight: bold;
                text-align: center;
                background-color: #266a4c;
                color: white;
            }
            .titularNivel2{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10pt;
                font-weight: bold;
                color: white;
                background-color: #298760;
                padding-left: 10px;
            }
            .titularNivel3{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 9pt;
                font-weight: bold;
                color: #266a4c;
                padding-left: 5px;
            }
            .textoDestaque{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10pt;
                font-weight: bold;
                color: black;
                text-align: justify;
            }
            /** Defino los estilos de la tabla **/
            #estiloTabla {
                font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
                font-size: 8pt;
                border-collapse: collapse;
                width: 100%;
            }
            #estiloTabla td, #estiloTabla th {
                border: 1px solid #808080;
                padding: 5px;
                text-align: center;
            }
            #estiloTabla th {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 7pt;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #E5E9E4;
                color: #266a4c;
            }
            /** Defino los estilos  para quitar los bordes de una tabla **/
            #estiloTablaSinBordes {
                font-family: "Arial Narrow", Arial, Helvetica, sans-serif;
                font-size: 8pt;
                border-collapse: collapse;
                width: 100%;
            }
            #estiloTablaSinBordes td, #estiloTablaSinBordes th {
                border:none;
                border-bottom: 1px solid #808080;
                padding: 5px;
                text-align: center;
            }
            #estiloTablaSinBordes th {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 7pt;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #E5E9E4;
                color: #266a4c;
                border-top: 1px solid #808080;
            }
            /** Defino los estilos para mostrar una tabla sin bordes (Beneficiarios) **/
            #estiloTablaBeneficiarios{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12pt;
                border-collapse: collapse;
                width: 100%;
            }
            #estiloTablaBeneficiarios td, #estiloTablaBeneficiarios th {
                border: none;
                padding: 5px;
                text-align: center;
            }
            #estiloTablaBeneficiarios th {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10pt;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: white;
                color: #000000;
            }
            /** Defino los estilos para mostrar una tabla striped (Presupuesto) **/
            #estiloTablaPresupuesto{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 7pt;
                border-collapse: collapse;
                width: 100%;
            }
            #estiloTablaPresupuesto td, #estiloTablaPresupuesto th {
                border:none;
            }
            #estiloTablaPresupuesto tr:nth-child(even) {background-color: #dcdddf;}
            #estiloTablaPresupuesto th {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 7pt;
                background-color: white;
                color: #000000;
                border-bottom: 1px solid black;
            }


            /** Define un salto de pagina **/
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        <!-- Encabezado del documento -->
        <header>
            <table style="width: 100%;">
                <td style="width: 55%; text-align:left;">{{$convenio->nro_convenio}}</td>
                <td style="width: 10%;"></td>
                <td style="width: 35%; text-align:right;">MINAGRI-PCC</td>
            </table>
            <hr>
        </header>
        <!-- Pie de pagina del documento -->
        <footer>
            <hr>
            <table style="width: 100%;">
                <td style="width: 35%; text-align:left;">{{$convenio->nro_convenio}}</td>
                <td style="width: 30%;"></td>
                <td style="width: 35%; text-align:right;">Página <span class="pagenum"></span></td>
            </table>            
        </footer>
        <!-- Contenido del documento -->
        <div class="contenido">
            @yield('content')
        </div>
    </body>
</html>
