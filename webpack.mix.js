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
    .js('resources/js/frontend.js', 'public/js')
    .js('resources/js/rating.js', 'public/js/frontend.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/index.scss', 'public/assets/frontend.css');
mix.copyDirectory('resources/images', 'public/images/');
mix.copyDirectory('node_modules/video.js', 'public/plugins/');
mix.copyDirectory('node_modules/videojs-swf/dist/video-js.swf', 'public/plugins/video.js/dist/');
