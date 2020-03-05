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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/admin.scss', 'public/css/admin/styles.css')
   .sass('resources/sass/driver.scss', 'public/css/driver/styles.css')
   .sass('resources/sass/customer.scss', 'public/css/customer/styles.css');

/**
mix.styles([
    'public/css/vendor/normalize.css',
    'public/css/vendor/videojs.css'
], 'public/css/all.css');

mix.js('resources/js/app.js', 'public/js')
    .extract(['vue'])
    => public/js/manifest.js: The Webpack manifest runtime
    => public/js/vendor.js: Your vendor libraries
    => public/js/app.js: Your application code
    
*/
