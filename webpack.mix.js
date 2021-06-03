const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
    mix.sass('resources/AdminLTE/build/scss/AdminLTE.scss', 'public/css');
    mix.styles([
        'resources/AdminLTE/plugins/fontawesome-free/css/all.css',
        'resources/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css',
        'resources/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.css',
        'resources/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.css',
        'resources/AdminLTE/plugins/select2/css/select2.css',
        'resources/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
        'resources/AdminLTE/plugins/chart.js/Chart.css',
        'resources/AdminLTE/plugins/highcharts/code/css/highcharts.css',


    ], 'public/css/app.css');
    mix.scripts([
        'resources/AdminLTE/plugins/jquery/jquery.js',
        'resources/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.js',
        'resources/AdminLTE/plugins/datatables/jquery.dataTables.js',
        'resources/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js',
        'resources/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.js',
        'resources/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.js',
        'resources/AdminLTE/plugins/select2/js/select2.full.js',
        'resources/AdminLTE/plugins/jquery-validation/jquery.validate.js',
        'resources/AdminLTE/plugins/jquery-validation/additional-methods.js',
        'resources/AdminLTE/plugins/jquery-validation/localization/messages_es_PE.js',
        'resources/AdminLTE/plugins/chart.js/Chart.js',
        'resources/AdminLTE/plugins/highcharts/code/highcharts.js',
        'resources/AdminLTE/plugins/highcharts/code/modules/exporting.js',
        'resources/AdminLTE/plugins/highcharts/code/modules/export-data.js',
        'resources/AdminLTE/plugins/highcharts/code/modules/accessibility.js',

        'resources/AdminLTE/dist/js/adminlte.js',
    ], 'public/js/app.js');
    mix.js('resources/js/config-app.js', 'public/js');
    mix.copyDirectory('resources/AdminLTE/plugins/fontawesome-free/webfonts', 'public/webfonts');
    mix.copyDirectory('resources/AdminLTE/plugins/flexmonster/theme/assets', 'public/webfonts');
    mix.copyDirectory('resources/AdminLTE/dist/img', 'public/img');