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

// js


mix.js('resources/assets/js/app.js', 'public/js');

// common.js
mix.combine(['resources/assets/js/nav.js', 'resources/assets/js/common.js'], 'public/js/common.js');

// admin.js
mix.combine(['resources/assets/js/nav.js', 'resources/assets/js/admin/admin.js'], 'public/js/admin/admin.js');

// register-pool-owner.js
mix.combine(['resources/assets/js/register/jquery.backstretch.js', 'resources/assets/js/register/jquery.payment.js', 
'resources/assets/js/register/additional-methods.js', 'resources/assets/js/register/retina-1.1.0.js', 
'resources/assets/js/register/register-pool-owner.js'], 'public/js/register/register-pool-owner.js');

// register-pool-service.js
mix.combine(['resources/assets/js/register/jquery.backstretch.js', 'resources/assets/js/register/jquery.payment.js', 
'resources/assets/js/register/additional-methods.js', 'resources/assets/js/register/retina-1.1.0.js', 
'resources/assets/js/register/register-pool-service.js'], 'public/js/register/register-pool-service.js');


// Sass

// // app
mix.sass('resources/assets/sass/admin.scss', 'public/css/admin.css')
.options({
        processCssUrls: false
});
// // css
mix.sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .options({
        processCssUrls: false
});
