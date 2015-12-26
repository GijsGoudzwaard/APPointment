var elixir = require('laravel-elixir');

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
	//  Bower components
	mix.styles(["resources/assets/bower_components/bootstrap/dist/css/bootstrap.css"]);
	//  Our own files
	mix.sass(["resources/assets/sass/**/*.scss"],
		'resources/assets/css'
	);
	// Scripts
	mix.scripts(["resources/assets/**/*.js", "!resources/assets/**/*.min.js"],
		'resources/assets/js'
	);
 });
