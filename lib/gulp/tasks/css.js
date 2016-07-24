"use strict";

var gulp = require('gulp'),
  process = require('gulp-sass'),
  prefix = require('gulp-autoprefixer'),
  compress = require('gulp-minify-css'),
  gulpif = require('gulp-if'),
  rename = require('gulp-rename'),
  notifier = require('../helpers/notifier'),
  config = require('../config').css;

gulp.task('css', function(cb) {

  var queue = config.bundles.length;

  // var buildThis = function(bundle) {

    var build = function() {
      return (
        gulp.src(bundle.src)
        .pipe(process(config.params))
        // .pipe(prefix(config.autoprefixer))

        // .pipe(gulpif(bundle.compress, compress(config.compress)))
        // .pipe(gulpif(bundle.compress, rename({
        //   suffix: '.min'
        // })))
        .pipe(gulp.dest(bundle.destPublicDir))
        .on('end', handleQueue)
      );
    };

    var handleQueue = function() {
      notifier(bundle.destFile);
      if (queue) {
        queue--;
        if (queue === 0) cb();
      }
    };

    return build();
  // };

  config.bundles.forEach(buildThis);

});



// gulp.task('sass', function () {
//   // For best performance, don't add Sass partials to `gulp.src`
//   return gulp.src(appFiles.styles)
//     .pipe(customPlumber('Error Running Sass'))
//     .pipe(plugins.newer(paths.styles.dest))
//     .pipe(plugins.sourcemaps.init())
//     .pipe(plugins.sass({
//       outputStyle: 'compressed',
//       precision: 10,
//       onError: console.error.bind(console, 'Sass error:')
//     }))
//     .pipe(plugins.sourcemaps.write('maps', {includeContent: true}))
//     .pipe(gulp.dest(paths.styles.dest))
//     .pipe(plugins.size({showFiles: true, title: 'task:styles'}));
// });
