var elixir = require("laravel-elixir");

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

var excluded_css = [
	"!../bower_components/**/bootstrap-theme.min.css"
];

var css = [
	"../bower_components/**/*.min.css",
	"*.css"
];

var excluded_js = [
	"!../bower_components/jquery/dist/jquery.slim.min.js",
	"!../bower_components/moment-timezone/builds/moment-timezone-with-data-2010-2020.min.js",
	"!../bower_components/moment-timezone/builds/moment-timezone-with-data.min.js",
	"!../bower_components/moment-timezone/builds/moment-timezone.min.js"
];

var js = [
	"../bower_components/jquery/dist/jquery.min.js",
	"../bower_components/moment/min/moment.min.js",
	"../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js",
	"../bower_components/**/*.min.js",
	"**/*.js"
];

elixir(function(mix) {
	//  Compile sass to css
	mix.sass(["/app.scss", "!/login.scss"],
		"resources/assets/css"
	);

	// Compile login.scss to seperate file
	mix.sass("/login.scss",
	    "public/assets/dist/login.css"
	);

	//  Concat css files and bower components
	mix.styles(excluded_css.concat(css), "public/assets/dist/all.css");

	// Scripts
	mix.scripts(excluded_js.concat(js), "public/assets/dist/all.js");
});
