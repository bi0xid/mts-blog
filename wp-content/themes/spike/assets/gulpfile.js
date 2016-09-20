var gulp       = require('gulp'),
	notify     = require('gulp-notify'),
	stylus     = require('gulp-stylus'),
	minify     = require('gulp-minify-css'),
	nib        = require('nib'),
	gulpif     = require('gulp-if'),
	livereload = require('gulp-livereload');

var args    = require('yargs').argv,
	getTime = require('./assets/includes/getTime.js');

var dest = {
	'css': '../css/'
};

var assets = {
	'styl': './assets/**/*.styl'
}

var isProduction = args.env   === 'prod';

isProduction && gulp.task('default', ['stylus']);
isProduction || gulp.task('default', ['stylus', 'watch']);

gulp.task('stylus', function() {
	gulp.src('./assets/*.styl')
		.pipe(stylus({
			use    : [nib()],
			errors : true,
			'include css': true
		}))
		.pipe(gulpif(isProduction, minify()))
		.pipe(gulp.dest(dest.css))
		.pipe(notify({
			onLast  : true,
			title   : 'Stylus Spike',
			message : 'Generados Stylus'
		}))
		.pipe(livereload());
});

gulp.task('watch', function() {
	livereload.listen();
	gulp.watch(assets.styl, ['stylus']);
});
