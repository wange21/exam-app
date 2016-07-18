var gulp = require('gulp');
var util = require('gulp-util');
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
  var task = util.env.task;
  if (!task || task === 'css') {
    var theme = util.env.theme || 'superhero';
    // compile and combine all sass file to single one
    mix.sass('main.sass', 'public/assets/themes/' + theme + '/bundle.css');
  }
  if (!task || task === 'font') {
    // copy bootstrap fonts to public directory
    mix.copy('bower_components/bootstrap-sass/assets/fonts/bootstrap',
      'public/assets/fonts/bootstrap');
  }
  if (!task || task === 'javascript') {
    // combine all javascript to single one
    mix.scripts([
      '../../../bower_components/jquery/dist/jquery.js',
      '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
      '' // all files in assets/js
    ], 'public/assets/js/bundle.js');
  }
  if (!task || task === 'shiv') {
    // copy shim & shiv files
    mix.copy('bower_components/html5shiv/dist/html5shiv.js',
      'public/assets/js/html5shiv.js');
    mix.copy('bower_components/es5-shim/es5-shim.js',
      'public/assets/js/es5-shim.js');
    mix.copy('bower_components/respond/dest/respond.src.js',
      'public/assets/js/respond.js');
  }
});
