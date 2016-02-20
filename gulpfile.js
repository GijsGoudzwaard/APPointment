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

var excluded_paths = [
	'!../bower_components/**/bootstrap-theme.css'
];

elixir(function(mix) {
	//  Compile sass to css
	mix.sass(["**/*.scss", "!/login.scss"],
		'resources/assets/css'
	);

	// Compile login.scss to seperate file
	mix.sass("/login.scss",
	    'public/assets/dist/login.css'
	);

	//  Concat css files and bower components
	mix.styles(["../bower_components/**/*.css", "!../bower_components/**/*.min.css", "*.css", excluded_paths.join(", ")],
		'public/assets/dist/all.css'
	);

	// Scripts
	mix.scripts(["../bower_components/**/*.min.js", "**/*.js"],
		'public/assets/dist/all.js'
	);
});
