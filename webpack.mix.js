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
        'resources/AdminLTE/plugins/alertifyjs/css/alertify.css',
        'resources/AdminLTE/plugins/alertifyjs/css/themes/default.css',
        'resources/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.css',
        'resources/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css',
        'resources/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.css',
        'resources/AdminLTE/plugins/select2/css/select2.css',
        'resources/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
        'resources/AdminLTE/plugins/flexmonster/flexmonster.css',
    ], 'public/css/app.css');
    mix.scripts([
        'resources/AdminLTE/plugins/jquery/jquery.js',
        'resources/AdminLTE/plugins/bootstrap/js/bootstrap.js',
        'resources/AdminLTE/dist/js/adminlte.js',
        'resources/AdminLTE/plugins/alertifyjs/alertify.js',
        'resources/AdminLTE/plugins/datatables/jquery.dataTables.js',
        'resources/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js',
        'resources/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.js',
        'resources/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.js',
        'resources/AdminLTE/plugins/datatables-buttons/js/buttons.html5.js',
        'resources/AdminLTE/plugins/datatables-buttons/js/buttons.print.js',
        'resources/AdminLTE/plugins/datatables-buttons/js/pdfmake.min.js',
        'resources/AdminLTE/plugins/datatables-buttons/js/vfs_fonts.js',
        'resources/AdminLTE/plugins/datatables-buttons/js/jszip.min.js',
        'resources/AdminLTE/plugins/select2/js/select2.js',
        'resources/AdminLTE/plugins/numeric/jquery.numeric.js',
    ], 'public/js/app.js');
    mix.js('resources/js/config-app.js', 'public/js');
    mix.copyDirectory('resources/AdminLTE/plugins/fontawesome-free/webfonts', 'public/webfonts');
    mix.copyDirectory('resources/AdminLTE/plugins/flexmonster/theme/assets', 'public/webfonts');
    mix.copyDirectory('resources/AdminLTE/dist/img', 'public/img');