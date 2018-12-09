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
  .sass('resources/sass/app.scss', 'public/css');

if (process.env.npm_lifecycle_event !== 'hot') {
  mix.version()
}

mix.options({
  hmrOptions: {
    host: process.env.MIX_APP_URL,
    port: 8080
  }
});

//mix.disableNotifications();
