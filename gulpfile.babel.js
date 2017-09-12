'use strict';
/* if work with html set TRUE, else - FALSE */
// const htmlOWp = false;
const htmlOWp = true;

/* import dependencies */
import config from 'config';

import gulp from 'gulp';
import runSequence from 'run-sequence';
import browserSync from 'browser-sync';
/* PostCSS plugins */
import cssnext from 'postcss-cssnext';
import cssnano from 'cssnano';

const reload = browserSync.reload;
const plugins = require("gulp-load-plugins")({
  pattern: ['gulp-*', 'gulp.*'],
  replaceString: /\bgulp[\-.]/
});

if (htmlOWp === false) {
  config.path.base.wp = './wordpress/wp-content/themes/' + config.theme + '/';
  ChangeBasePath(config);
  config.path.base.dest = config.path.base.wp;
}

let basePaths = '';

var paths = {
  scripts: {
    src: basePaths.src + 'js/**',
    dest: basePaths.dest + 'js/'
  },

  sprite: {
    src: basePaths.src + 'sprite/*'
  }
};

var appFiles = {
	scripts: [paths.scripts.src]
};
// postcss


// Compile and automatically prefix stylesheets
gulp.task('scss', function() {
  // For best performance, don't add Sass partials to `gulp.src`
  return gulp
		.src(config.path.styles.srcfiles)
		.pipe(customPlumber('Error Running Sass'))
		.pipe(plugins.newer(config.path.styles.css))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({
				outputStyle: 'expanded',
				precision: 5,
				onError: console.error.bind(console, 'Sass error:')
			}))
		.pipe(plugins.sourcemaps.write('maps', { includeContent: true }))
		.pipe(gulp.dest(config.path.styles.css))
		.pipe(plugins.size({ showFiles: true, title: 'task:styles' }));
});

// postcss autoprefix
gulp.task('postcss', function() {
  var processors =
    [cssnext({
      browsers: [
              'ie >= 8',
              'ie_mob >= 10',
              'ff >= 20',
              'chrome >= 24',
              'safari >= 5',
              'opera >= 12',
              'ios >= 7',
              'android >= 2.3',
              '> 1%',
              'last 5 versions',
              'bb >= 10'
            ]
    }),
    cssnano({
				discardComments: {
					removeAll: true
				}
			}


    )];;
  return gulp
		.src(config.path.styles.cssfiles)
		.pipe(customPlumber('Error Compiling PostCSS'))
		.pipe(plugins.newer(config.path.styles.dest))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.postcss(processors))
		.pipe(plugins.sourcemaps.write('maps', { includeContent: true }))
		.pipe(gulp.dest(config.path.styles.dest))
		.pipe(plugins.size({ showFiles: true, title: 'task:postcss' }));
});

gulp.task('styles', function(callback) {
	runSequence(['scss'], ['postcss'], callback);
});

// Optimize images
gulp.task('images', function() {
  return gulp
		.src(config.path.images.srcimg)
		.pipe(plugins.newer(config.path.images.dest))
    .pipe(plugins.imagemin([
      plugins.imagemin.gifsicle({ interlaced: true }),
      plugins.imagemin.jpegtran({ progressive: true }),
      plugins.imagemin.optipng({ optimizationLevel: 5 }),
      plugins.imagemin.svgo({ plugins: [{ removeViewBox: true }] })
    ]))
		.pipe(plugins.size({ showFiles: true, title: 'task:images' }))
		.pipe(gulp.dest(config.path.images.dest));
});

// Copy web fonts to dist
gulp.task('fonts', function() {
  return gulp
		.src(config.path.fonts.src)
		.pipe(plugins.newer(config.path.fonts.dest))
		.pipe(gulp.dest(config.path.fonts.dest))
		.pipe(plugins.size({ showFiles: true, title: 'task:fonts' }));
});


// Custom Plumber function for catching errors
function customPlumber(errTitle) {
  return plugins.plumber({
    errorHandler: plugins.notify.onError({
      // Customizing error title
      title: errTitle || 'Error running Gulp',
      message: 'Error: <%= error.message %>',
      sound: "Bottle"
    })
  });
};
module.exports = customPlumber;

function ChangeBasePath(config) {
  config.path.images.dest = config.path.images.dest.replace(config.path.base.dest, config.path.base.wp);
  config.path.fonts.dest = config.path.fonts.dest.replace(config.path.base.dest, config.path.base.wp);
  config.path.styles.dest = config.path.styles.dest.replace(config.path.base.dest, config.path.base.wp);
}
