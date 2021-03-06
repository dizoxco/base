let mix = require('laravel-mix');
const path = require('path');
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
var tailwindcss = require('tailwindcss');

mix.js('resources/assets/js/app.js', 'public/js')
   .react('resources/assets/js/admin.js', 'public/js')
   .sass('resources/assets/sass/front/main.scss', 'public/css', {
         includePaths: [path.resolve(__dirname, 'node_modules')]
      }).options({
         processCssUrls: false,
         postCss: [ tailwindcss('resources/assets/sass/front/tailwind.js') ],
      })
   .sass('resources/assets/sass/admin/admin.scss', 'public/css', {
         includePaths: [path.resolve(__dirname, 'node_modules')]
      }).options({
         processCssUrls: false,
         postCss: [ tailwindcss('resources/assets/sass/admin/tailwind.js') ],
      });
