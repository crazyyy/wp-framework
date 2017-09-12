'use strict';
/* if work with html set TRUE, else - FALSE */
const htmlOWp = true;

/* import dependencies */
import config from 'config';
import gulp from 'gulp';
import runSequence from 'run-sequence';
import browserSync from 'browser-sync';
import imagemin from 'imagemin';
import imageminPngquant from 'imagemin-pngquant';

const reload = browserSync.reload;
const plugins = require("gulp-load-plugins")({
  pattern: ['gulp-*', 'gulp.*'],
  replaceString: /\bgulp[\-.]/
});



if (htmlOWp === true) {
  var basePaths = {
    src: 'assets/',
    dest: './html/'
  };
} else {
  var basePaths = {
    src: 'assets/',
    dest: './wordpress/wp-content/themes/' + config.theme + '/'
  };
}
var paths = {
  images: {
    src: basePaths.src + 'img/',
    srcimg: basePaths.src + 'img/**/*.{png,jpg,jpeg,gif,svg}',
    dest: basePaths.dest + 'img/'
  },
  scripts: {
    src: basePaths.src + 'js/**',
    dest: basePaths.dest + 'js/'
  },
  styles: {
    src: basePaths.src + 'scss/',
    css: basePaths.src + 'css/',
    dest: basePaths.dest + 'css/'
  },
  fonts: {
    src: basePaths.src + 'fonts/**',
    dest: basePaths.dest + 'fonts/'
  },
  sprite: {
    src: basePaths.src + 'sprite/*'
  }
};



// Optimize images
gulp.task('images', function() {
  return gulp.src(paths.images.srcimg)
    .pipe(plugins.newer(paths.images.dest))
    .pipe(plugins.imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{
        removeViewBox: false
      }],
      use: [imageminPngquant()]
    }))
    .pipe(plugins.size({
      showFiles: true,
      title: 'task:images'
    }))
    .pipe(gulp.dest(paths.images.dest));
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
