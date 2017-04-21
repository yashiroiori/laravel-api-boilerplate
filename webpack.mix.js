const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/dashboard.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/dashboard.scss', 'public/css');

mix.combine([
        'public/css/dashboard.css',
        'node_modules/pace/themes/white/pace-theme-minimal.css',
        'node_modules/admin-lte/dist/css/AdminLTE.css',
        'node_modules/admin-lte/dist/css/skins/_all-skins.css',
    ], 'public/css/all.css')
    //VENDOR RESOURCES
    .copy('node_modules/pace/pace.min.js', 'public/js')
    .copy('node_modules/font-awesome/fonts/*.*','public/fonts/')
    .copy('node_modules/ionicons/dist/fonts/*.*','public/fonts/')
    /*.copy('node_modules/admin-lte/bootstrap/fonts/*.*','public/fonts/bootstrap')*/

if (mix.config.inProduction) {
    mix.version();
}

/* OLD */
/*
mix.js('resources/assets/js/dashboard.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
*/