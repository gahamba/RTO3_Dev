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

mix.react('resources/js/app.js', 'public/js')
    .react('resources/js/home.js', 'public/js')
    .react('resources/js/user.js', 'public/js')
    .react('resources/js/company.js', 'public/js')
    .react('resources/js/device.js', 'public/js')
    .react('resources/js/reports.js', 'public/js')
    .react('resources/js/messages.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
