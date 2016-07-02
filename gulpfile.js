var elixir = require('laravel-elixir');

// generate source maps
//elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
  // compile and combine all sass file to single one
  mix.sass('main.sass', 'public/assets/css/bundle.css');
  // copy bootstrap fonts to public directory
  mix.copy('bower_components/bootstrap/dist/fonts', 'public/build/assets/fonts');
  // combine all javascript to single one
  mix.scripts([
    '../../../bower_components/jquery/dist/jquery.js',
    '../../../bower_components/bootstrap/dist/js/bootstrap.js',
    '' // all files in assets/js
  ], 'public/assets/js/bundle.js');
  // attach version
  mix.version(['assets/css/bundle.css', 'assets/js/bundle.js']);
  // copy shim & shiv files
  mix.copy('bower_components/html5shiv/dist/html5shiv.js',
    'public/assets/js/html5shiv.js');
  mix.copy('bower_components/es5-shim/es5-shim.js',
    'public/assets/js/es5-shim.js');
  mix.copy('bower_components/respond/dest/respond.src.js',
    'public/assets/js/respond.js');
});
