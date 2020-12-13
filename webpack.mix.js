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

mix.js('resources/js/app.js', 'public/assets/compiled/js')
    .sass('resources/sass/app.scss', 'public/assets/compiled/css')
    .sourceMaps();

mix
    .ts('resources/ts/chest.ts', 'public/assets/compiled/js/chest.js')

