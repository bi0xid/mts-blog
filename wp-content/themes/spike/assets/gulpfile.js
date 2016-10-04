var gulp       = require('gulp'),
	nib        = require('nib'),
	gulpif     = require('gulp-if'),
	gulpUtil   = require('gulp-util'),
	args       = require('yargs').argv,
	stylus     = require('gulp-stylus'),
	notify     = require('gulp-notify'),
	uglify     = require('gulp-uglify'),
	minify     = require('gulp-minify-css'),
	browserify = require('gulp-browserify'),
	livereload = require('gulp-livereload');

var isProduction = args.env   === 'prod';

isProduction && gulp.task('default', ['stylus', 'scripts']);
isProduction || gulp.task('default', ['stylus', 'scripts', 'watch']);

gulp.task('stylus', function() {
	gulp.src('./theme-assets/style.styl')
		.pipe(stylus({
			use    : [nib()],
			errors : true,
			'include css': true
		}))
		.pipe(gulpif(isProduction, minify()))
		.pipe(gulp.dest('../css/'))
		.pipe(notify({
			onLast  : true,
			title   : 'Stylus',
			message : 'Generado Stylus'
		}))
		.pipe(livereload());
});

gulp.task('scripts', function() {
	gulp.src('./theme-assets/main.js')
		.pipe(browserify({ insertGlobals : true }))
		.pipe(gulpif(isProduction, uglify().on('error', gulpUtil.log)))
		.pipe(gulp.dest('../js/'))
		.pipe(notify({
			onLast  : true,
			title   : 'Scripts',
			message : 'Generado Scripts'
		}))
		.pipe(livereload());
});

gulp.task('watch', function() {
	livereload.listen();

	gulp.watch('./theme-assets/**/*.js', ['scripts']);
	gulp.watch('./theme-assets/**/*.styl', ['stylus']);
});
