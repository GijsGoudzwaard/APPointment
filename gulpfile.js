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
	//  Compile sass to css
	mix.sass(["resources/assets/sass/**/*.scss"],
		'resources/assets/css'
	);
	//  Concat css files and bower components
	mix.styles(["../bower_components/**/*.css", "!../bower_components/**/*.min.css", "resources/assets/css/*.css"],
		'resources/assets/dist/all.css'
	);
	// Scripts
	mix.scripts(["resources/assets/**/*.js", "!resources/assets/**/*.min.js"],
		'resources/assets/js'
	);

 });
