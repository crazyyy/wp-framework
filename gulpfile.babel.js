'use strict';
/* if work with html set TRUE, else - FALSE */
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
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(config.path.styles.css))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:styles'
    }));
});

// postcss autoprefix
gulp.task('postcss', function() {
  var processors = [cssnext({
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


    )
  ];;
  return gulp
    .src(config.path.styles.cssfiles)
    .pipe(customPlumber('Error Compiling PostCSS'))
    .pipe(plugins.newer(config.path.styles.dest))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.postcss(processors))
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(config.path.styles.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:postcss'
    }));
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
      plugins.imagemin.gifsicle({
        interlaced: true
      }),
      plugins.imagemin.jpegtran({
        progressive: true
      }),
      plugins.imagemin.optipng({
        optimizationLevel: 5
      }),
      plugins.imagemin.svgo({
        plugins: [{
          removeViewBox: true
        }]
      })
    ]))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:images'
    }))
    .pipe(gulp.dest(config.path.images.dest));
});

// Generate sprites
gulp.task('sprite', function() {
  var spriteData = gulp
    .src(config.path.images.sprite + '*.png')
    .pipe(plugins.spritesmith({
      imgName: config.sprite.imgName,
      cssName: config.sprite.cssName,
      imgPath: config.sprite.imgPath,
      cssVarMap: function(sprite) {
        sprite.name = 'sprite-' + sprite.name;
      }
    }))
    .pipe(plugins.if('*.png', gulp.dest(config.path.images.src)))
    .pipe(plugins.if('*.scss', gulp.dest(config.path.styles.src)))
    .pipe(plugins.size({
      showFiles: true,
      title: ' task:sprite'
    }));
});

// Copy web fonts to dist
gulp.task('fonts', function() {
  return gulp
    .src(config.path.fonts.src)
    .pipe(plugins.newer(config.path.fonts.dest))
    .pipe(gulp.dest(config.path.fonts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:fonts'
    }));
});

// Optimize script
gulp.task('scripts', function() {
  return gulp
    .src(config.path.scripts.src)
    .pipe(plugins.newer(config.path.scripts.dest))
    .pipe(customPlumber('Error Compiling Scripts'))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.if('*.js', plugins.uglify()))
    .pipe(plugins.sourcemaps.write('maps', {
      includeContent: true
    }))
    .pipe(gulp.dest(config.path.scripts.dest))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:scripts:'
    }));
});

// Browser Sync
gulp.task('browserSync', function() {
  let args;
  if (htmlOWp === true) {
    args = {
      notify: false,
      port: 9080,
      server: {
        baseDir: config.path.base.dest,
      }
    }
  } else {
    args = {
      notify: false,
      port: 9090,
      proxy: config.domain,
      host: config.domain
    }
  }
  browserSync(args)
});

// watch for changes
gulp.task('watch', function() {

  gulp.watch([config.path.base.desthtml]).on('change', reload);

  gulp.watch(config.path.images.sprite, ['sprite', 'images', 'styles', reload]);
  gulp.watch(config.path.images.sprite, ['styles', reload]);

  gulp.watch(config.path.images.srcimg, ['images', reload]);

  gulp.watch(config.path.styles.srcfiles, ['styles', reload]);

  gulp.watch(config.path.fonts.src, ['fonts', reload]);
  gulp.watch(config.path.scripts.src, ['scripts', reload]);

});

// Consolidated dev phase task
gulp.task('serve', function(callback) {
  runSequence(
    ['sprite', 'images'], ['scripts'], ['scss', 'fonts'], ['postcss'], ['browserSync', 'watch'],
    callback
  );
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
  config.path.scripts.dest = config.path.scripts.dest.replace(config.path.base.dest, config.path.base.wp);
  config.path.base.desthtml = config.path.base.desthtml.replace(config.path.base.dest, config.path.base.wp);
}
