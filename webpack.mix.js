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

mix.js('resources/assets/js/app.js', 'public/js');
mix.js('resources/assets/js/app_angular.js', 'public/js');
// mix.sass('resources/assets/sass/app.scss', 'public/css');
// mix.react('resources/assets/js/react/app.jsx', 'public/js');

//
// mix.scripts([
//     'node_modules/core-js/client/shim.min.js',
//     'node_modules/zone.js/dist/zone.js',
//     'node_modules/rxjs/bundles/Rx.js',
//     'node_modules/@angular/core/bundles/core.umd.js',
//     'node_modules/@angular/common/bundles/common.umd.js',
//     'node_modules/@angular/compiler/bundles/compiler.umd.js',
//     'node_modules/@angular/platform-browser/bundles/platform-browser.umd.js',
//     'node_modules/@angular/platform-browser-dynamic/bundles/platform-browser-dynamic.umd.js'
//
// ], 'public/js/angular.js');